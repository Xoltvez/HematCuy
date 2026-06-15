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
        $transactions = auth()->user()->transactions()->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        
        $currentMonth = now()->format('Y-m');
        $monthlyTransactions = $transactions->filter(function($tx) use ($currentMonth) {
            return \Carbon\Carbon::parse($tx->date)->format('Y-m') === $currentMonth;
        });

        $totalIncome = $monthlyTransactions->where('type', 'income')->sum('amount');
        $totalExpense = $monthlyTransactions->where('type', 'expense')->sum('amount');
        
        $today = now()->format('Y-m-d');
        $todayExpense = $transactions->filter(function($tx) use ($today) {
            return \Carbon\Carbon::parse($tx->date)->format('Y-m-d') === $today;
        })->where('type', 'expense')->sum('amount');
        
        $balanceCash = $transactions->where('account', 'cash')->where('type', 'income')->sum('amount') 
                     - $transactions->where('account', 'cash')->where('type', 'expense')->sum('amount');
                     
        $balanceBank = $transactions->where('account', 'bank')->where('type', 'income')->sum('amount') 
                     - $transactions->where('account', 'bank')->where('type', 'expense')->sum('amount');

        return view('dashboard', compact('transactions', 'totalIncome', 'totalExpense', 'todayExpense', 'balanceCash', 'balanceBank'));
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
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        
        $balanceCash = $transactions->where('account', 'cash')->where('type', 'income')->sum('amount') 
                     - $transactions->where('account', 'cash')->where('type', 'expense')->sum('amount');
                     
        $balanceBank = $transactions->where('account', 'bank')->where('type', 'income')->sum('amount') 
                     - $transactions->where('account', 'bank')->where('type', 'expense')->sum('amount');
        
        // Group by category for expenses
        $expensesByCategory = $transactions->where('type', 'expense')
            ->groupBy('category')
            ->map(function ($group) {
                return [
                    'amount' => $group->sum('amount'),
                    'count'  => $group->count(),
                ];
            });

        // Group by category for incomes
        $incomesByCategory = $transactions->where('type', 'income')
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
        //
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
}
