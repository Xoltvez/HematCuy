<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $allTransactions = $user->transactions()->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        
        $currentMonth = now()->format('Y-m');
        $lastMonth = now()->subMonth()->format('Y-m');
        
        $monthlyTransactions = $allTransactions->filter(function($tx) use ($currentMonth) {
            return \Carbon\Carbon::parse($tx->date)->format('Y-m') === $currentMonth;
        });

        $lastMonthTransactions = $allTransactions->filter(function($tx) use ($lastMonth) {
            return \Carbon\Carbon::parse($tx->date)->format('Y-m') === $lastMonth;
        });

        // This Month
        $totalIncome = $monthlyTransactions->where('type', 'income')->where('category', '!=', 'Tabungan Ekstra')->sum('amount');
        $totalExpense = $monthlyTransactions->where('type', 'expense')->whereNotIn('category', ['Pembelian Wishlist', 'Tabungan Ekstra'])->sum('amount');
        
        // Last Month
        $lastMonthIncome = $lastMonthTransactions->where('type', 'income')->where('category', '!=', 'Tabungan Ekstra')->sum('amount');
        $lastMonthExpense = $lastMonthTransactions->where('type', 'expense')->whereNotIn('category', ['Pembelian Wishlist', 'Tabungan Ekstra'])->sum('amount');
        
        // Percentages
        $incomeChange = $lastMonthIncome > 0 ? (($totalIncome - $lastMonthIncome) / $lastMonthIncome) * 100 : ($totalIncome > 0 ? 100 : 0);
        $expenseChange = $lastMonthExpense > 0 ? (($totalExpense - $lastMonthExpense) / $lastMonthExpense) * 100 : ($totalExpense > 0 ? 100 : 0);

        // Overall Balance
        $realIncomeTxs = $allTransactions->where('type', 'income')->where('category', '!=', 'Tabungan Ekstra');
        // Exclude Tabungan Ekstra completely from all balance calculations
        $balanceExpenseTxs = $allTransactions->where('type', 'expense')->whereNotIn('category', ['Pembelian Wishlist', 'Tabungan Ekstra']);

        $balanceTotal = $realIncomeTxs->sum('amount') - $balanceExpenseTxs->sum('amount');
        $balanceCash = $realIncomeTxs->where('account', 'cash')->sum('amount') - $balanceExpenseTxs->where('account', 'cash')->sum('amount');
        $balanceBank = $realIncomeTxs->where('account', 'bank')->sum('amount') - $balanceExpenseTxs->where('account', 'bank')->sum('amount');

        // Recent Activity (Top 5)
        $recentTransactions = $allTransactions->whereNotIn('category', ['Tabungan Ekstra'])->take(5);

        // Top Categories This Week
        $startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = now()->endOfWeek()->format('Y-m-d');
        $weeklyExpenses = $allTransactions->where('type', 'expense')->filter(function($tx) use ($startOfWeek, $endOfWeek) {
            return $tx->date >= $startOfWeek && $tx->date <= $endOfWeek;
        });
        
        $topCategories = $weeklyExpenses->groupBy('category')->map(function($group, $key) {
            return [
                'name' => $key ?: 'Lainnya',
                'amount' => $group->sum('amount')
            ];
        })->sortByDesc('amount')->take(5);

        // Cashflow Chart Data (This Month by Day)
        $daysInMonth = now()->daysInMonth;
        $cashflowLabels = [];
        $cashflowIncome = [];
        $cashflowExpense = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dateStr = now()->format('Y-m-') . str_pad($i, 2, '0', STR_PAD_LEFT);
            $dayTxs = $monthlyTransactions->where('date', $dateStr);
            $cashflowLabels[] = $i;
            $cashflowIncome[] = $dayTxs->where('type', 'income')->sum('amount');
            $cashflowExpense[] = $dayTxs->where('type', 'expense')->sum('amount');
        }

        // Allocations (Savings)
        $allocations = $user->allocations()->where('month_year', $currentMonth)->get();
        $allocationsData = $allocations->map(function ($allocation) use ($currentMonth, $allTransactions) {
            $spent = $allTransactions
                ->where('type', 'expense')
                ->where('category', $allocation->category_name)
                ->filter(function($tx) use ($currentMonth) {
                    return \Carbon\Carbon::parse($tx->date)->format('Y-m') === $currentMonth;
                })->sum('amount');
                
            return [
                'id' => $allocation->id,
                'category_name' => $allocation->category_name,
                'amount' => $allocation->amount,
                'spent' => $spent,
                'percentage' => $allocation->amount > 0 ? min(100, round(($spent / $allocation->amount) * 100)) : 0
            ];
        });

        return view('dashboard', compact(
            'totalIncome', 'totalExpense', 'incomeChange', 'expenseChange', 'balanceTotal', 'balanceCash', 'balanceBank',
            'recentTransactions', 'topCategories', 'cashflowLabels', 'cashflowIncome', 'cashflowExpense', 'allocationsData'
        ));
    }

    public function history()
    {
        $transactions = auth()->user()->transactions()->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        return view('history', compact('transactions'));
    }

    public function target()
    {
        $user = auth()->user();
        $dailyBudget = $user->daily_budget;

        $expenses = $user->transactions()
            ->where('type', 'expense')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
            });

        $dailyHistory = [];
        foreach ($expenses as $date => $transactions) {
            $totalExpense = $transactions->sum('amount');
            $status = 'Belum Ditetapkan';
            
            if ($dailyBudget > 0) {
                $status = ($totalExpense > $dailyBudget) ? 'Boros' : 'Hemat';
            }

            $dailyHistory[] = [
                'date' => $date,
                'total_expense' => $totalExpense,
                'status' => $status
            ];
        }

        return view('target', compact('dailyBudget', 'dailyHistory'));
    }

    public function report(\Illuminate\Http\Request $request)
    {
        $query = auth()->user()->transactions()->orderBy('date', 'desc');

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        $transactions = $query->get();

        // Get unique years for the dropdown
        $availableYears = auth()->user()->transactions()->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('Y');
        })->unique()->sortDesc()->values();
        
        $totalIncome = $transactions->where('type', 'income')->where('category', '!=', 'Tabungan Ekstra')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->whereNotIn('category', ['Pembelian Wishlist', 'Tabungan Ekstra'])->sum('amount');
        
        $balanceCash = $transactions->where('account', 'cash')->where('type', 'income')->where('category', '!=', 'Tabungan Ekstra')->sum('amount') 
                     - $transactions->where('account', 'cash')->where('type', 'expense')->whereNotIn('category', ['Pembelian Wishlist', 'Tabungan Ekstra'])->sum('amount');
                     
        $balanceBank = $transactions->where('account', 'bank')->where('type', 'income')->where('category', '!=', 'Tabungan Ekstra')->sum('amount') 
                     - $transactions->where('account', 'bank')->where('type', 'expense')->whereNotIn('category', ['Pembelian Wishlist', 'Tabungan Ekstra'])->sum('amount');
        
        $expensesByCategory = $transactions->where('type', 'expense')
            ->whereNotIn('category', ['Pembelian Wishlist', 'Tabungan Ekstra'])
            ->groupBy('category')
            ->map(function ($group) {
                return [
                    'amount' => $group->sum('amount'),
                    'count'  => $group->count(),
                ];
            });

        $incomesByCategory = $transactions->where('type', 'income')
            ->where('category', '!=', 'Tabungan Ekstra')
            ->groupBy('category')
            ->map(function ($group) {
                return [
                    'amount' => $group->sum('amount'),
                    'count'  => $group->count(),
                ];
            });

        return view('report', compact('transactions', 'totalIncome', 'totalExpense', 'balanceCash', 'balanceBank', 'expensesByCategory', 'incomesByCategory', 'availableYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'account' => 'required|in:cash,bank',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();
        Transaction::create($validated);

        if ($validated['type'] === 'expense') {
            $user = auth()->user();
            if ($user->daily_budget > 0) {
                $txDate = \Carbon\Carbon::parse($validated['date'])->format('Y-m-d');
                $today = now()->format('Y-m-d');
                
                if ($txDate === $today) {
                    $todayExpense = \App\Models\Transaction::where('user_id', $user->id)
                        ->where('type', 'expense')
                        ->whereDate('date', $today)
                        ->sum('amount');
                    
                    if ($todayExpense > $user->daily_budget) {
                        if ($user->daily_alert_sent_at !== $today) {
                            try {
                                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\DailyBudgetAlertMail($user, $todayExpense, $user->daily_budget));
                                $user->daily_alert_sent_at = $today;
                                $user->save();
                            } catch (\Exception $e) {
                                \Illuminate\Support\Facades\Log::error('Gagal mengirim email budget: ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }
        return view('edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'account' => 'required|in:cash,bank',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->update($validated);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }
        $transaction->delete();
        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function updateBudget(Request $request)
    {
        $request->validate([
            'daily_budget' => 'nullable|numeric|min:0'
        ]);

        $user = auth()->user();
        $user->daily_budget = $request->daily_budget;
        $user->save();

        return redirect()->back()->with('success', 'Batas anggaran harian berhasil diperbarui!');
    }


    public function exportPdf()
    {
        $transactions = auth()->user()->transactions()->orderBy('date', 'desc')->get();
        return view('transactions.print', compact('transactions'));
    }
}
