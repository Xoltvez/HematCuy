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
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        
        $balanceCash = $transactions->where('account', 'cash')->where('type', 'income')->sum('amount') 
                     - $transactions->where('account', 'cash')->where('type', 'expense')->sum('amount');
                     
        $balanceBank = $transactions->where('account', 'bank')->where('type', 'income')->sum('amount') 
                     - $transactions->where('account', 'bank')->where('type', 'expense')->sum('amount');

        return view('dashboard', compact('transactions', 'totalIncome', 'totalExpense', 'balanceCash', 'balanceBank'));
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

        $transactions = $query->get();
        
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

        return view('report', compact('transactions', 'totalIncome', 'totalExpense', 'balanceCash', 'balanceBank', 'expensesByCategory', 'incomesByCategory'));
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
}
