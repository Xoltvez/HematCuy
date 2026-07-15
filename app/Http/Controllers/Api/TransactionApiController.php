<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionApiController extends Controller
{
    /**
     * Get all transactions for the authenticated user.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ]);
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'notes' => 'nullable|string',
        ]);

        $transaction = new Transaction();
        $transaction->user_id = $request->user()->id;
        $transaction->title = $request->title;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->date = $request->date;
        $transaction->category_id = $request->category_id;
        $transaction->notes = $request->notes;
        $transaction->save();

        // Update user balance
        $user = $request->user();
        if ($request->type === 'income') {
            $user->balance += $request->amount;
        } else {
            $user->balance -= $request->amount;
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaksi berhasil ditambahkan.',
            'data' => $transaction,
            'new_balance' => $user->balance
        ], 201);
    }
}
