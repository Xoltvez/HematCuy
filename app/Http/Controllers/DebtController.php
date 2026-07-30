<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\DebtInstallment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $payables = $user->debts()->where('type', 'payable')->orderBy('created_at', 'desc')->get();
        $receivables = $user->debts()->where('type', 'receivable')->orderBy('created_at', 'desc')->get();
        
        $totalPayable = $payables->where('status', '!=', 'paid')->sum(fn($d) => $d->amount - $d->amount_paid);
        $totalReceivable = $receivables->where('status', '!=', 'paid')->sum(fn($d) => $d->amount - $d->amount_paid);

        return view('debts.index', compact('payables', 'receivables', 'totalPayable', 'totalReceivable'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $allowedAccounts = array_merge(['cash', 'bank'], $user->accounts()->pluck('name')->toArray());

        $request->validate([
            'type' => 'required|in:payable,receivable',
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'nullable|date',
            'account' => ['required', \Illuminate\Validation\Rule::in($allowedAccounts)]
        ]);

        try {
            DB::beginTransaction();

            if ($request->type === 'receivable') {
                $currentBalance = $user->getAccountBalance($request->account);
                if ($request->amount > $currentBalance) {
                    $accLabel = $request->account == 'cash' ? 'Tunai' : ($request->account == 'bank' ? 'Bank/E-Wallet' : $request->account);
                    return back()->with('error', 'Saldo ' . $accLabel . ' Anda tidak mencukupi untuk memberikan piutang! Sisa saldo: Rp ' . number_format($currentBalance, 0, ',', '.'))->withInput();
                }
            }
            
            $debt = $user->debts()->create([
                'type' => $request->type,
                'person_name' => $request->person_name,
                'amount' => $request->amount,
                'amount_paid' => 0,
                'due_date' => $request->due_date,
                'status' => 'unpaid',
                'account' => $request->account,
            ]);

            // Jika "payable" (Saya meminjam uang/Hutang), maka uang MASUK ke saldo saya.
            // Jika "receivable" (Saya meminjamkan uang/Piutang), maka uang KELUAR dari saldo saya.
            Transaction::create([
                'user_id' => $user->id,
                'type' => $request->type === 'payable' ? 'income' : 'expense',
                'amount' => $request->amount,
                'title' => ($request->type === 'payable' ? 'Pinjaman dari ' : 'Pinjaman ke ') . $request->person_name,
                'category' => 'Hutang/Piutang',
                'account' => $request->account,
                'date' => now(),
            ]);

            DB::commit();

            return redirect()->route('debts.index')->with('success', 'Catatan hutang/piutang berhasil ditambahkan dan saldo telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('debts.index')->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function pay(Request $request, Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();
        $allowedAccounts = array_merge(['cash', 'bank'], $user->accounts()->pluck('name')->toArray());

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'account' => ['required', \Illuminate\Validation\Rule::in($allowedAccounts)]
        ]);

        $amountToPay = min($request->amount, $debt->amount - $debt->amount_paid);

        if ($debt->type === 'payable') {
            $currentBalance = $user->getAccountBalance($request->account);
            if ($amountToPay > $currentBalance) {
                $accLabel = $request->account == 'cash' ? 'Tunai' : ($request->account == 'bank' ? 'Bank/E-Wallet' : $request->account);
                return back()->with('error', 'Saldo ' . $accLabel . ' Anda tidak mencukupi untuk membayar hutang! Sisa saldo: Rp ' . number_format($currentBalance, 0, ',', '.'))->withInput();
            }
        }

        try {
            DB::beginTransaction();

            // Create installment
            $debt->installments()->create([
                'amount' => $amountToPay,
                'account' => $request->account,
                'paid_at' => now(),
            ]);

            // Update debt status
            $debt->amount_paid += $amountToPay;
            if ($debt->amount_paid >= $debt->amount) {
                $debt->status = 'paid';
            } else {
                $debt->status = 'partially_paid';
            }
            $debt->save();

            // Create transaction
            // Jika "payable" (Membayar hutang), maka uang KELUAR (expense).
            // Jika "receivable" (Menerima pelunasan piutang), maka uang MASUK (income).
            Transaction::create([
                'user_id' => auth()->id(),
                'type' => $debt->type === 'payable' ? 'expense' : 'income',
                'amount' => $amountToPay,
                'title' => ($debt->type === 'payable' ? 'Bayar hutang ke ' : 'Terima pelunasan dari ') . $debt->person_name,
                'category' => 'Hutang/Piutang',
                'account' => $request->account,
                'date' => now(),
            ]);

            DB::commit();

            return redirect()->route('debts.index')->with('success', 'Pembayaran berhasil dicatat dan saldo telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('debts.index')->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function update(Request $request, Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();
        $allowedAccounts = array_merge(['cash', 'bank'], $user->accounts()->pluck('name')->toArray());

        $request->validate([
            'person_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:' . $debt->amount_paid,
            'due_date' => 'nullable|date',
            'account' => ['required', \Illuminate\Validation\Rule::in($allowedAccounts)]
        ]);

        try {
            DB::beginTransaction();

            // Find the original transaction created when this debt was stored
            $transaction = Transaction::where('user_id', $user->id)
                ->where('category', 'Hutang/Piutang')
                ->where('type', $debt->type === 'payable' ? 'income' : 'expense')
                ->where('amount', $debt->amount)
                ->where('account', $debt->account)
                ->where('title', 'like', '%' . $debt->person_name . '%')
                ->first();

            // Check balance if they are changing amount / account
            if ($debt->type === 'receivable') {
                $currentBalance = $user->getAccountBalance($request->account);
                if ($debt->account === $request->account) {
                    $currentBalance += $debt->amount;
                }
                if ($request->amount > $currentBalance) {
                    $accLabel = $request->account == 'cash' ? 'Tunai' : ($request->account == 'bank' ? 'Bank/E-Wallet' : $request->account);
                    return back()->with('error', 'Saldo ' . $accLabel . ' Anda tidak mencukupi! Sisa saldo: Rp ' . number_format($currentBalance, 0, ',', '.'))->withInput();
                }
            } else {
                if ($debt->account === $request->account) {
                    $currentBalance = $user->getAccountBalance($debt->account);
                    $difference = $debt->amount - $request->amount;
                    if ($difference > 0 && $difference > $currentBalance) {
                        $accLabel = $debt->account == 'cash' ? 'Tunai' : ($debt->account == 'bank' ? 'Bank/E-Wallet' : $debt->account);
                        return back()->with('error', 'Saldo ' . $accLabel . ' Anda tidak mencukupi untuk melakukan penyesuaian pengurangan hutang!')->withInput();
                    }
                }
            }

            // Update transaction if found
            if ($transaction) {
                $transaction->update([
                    'amount' => $request->amount,
                    'account' => $request->account,
                    'title' => ($debt->type === 'payable' ? 'Pinjaman dari ' : 'Pinjaman ke ') . $request->person_name,
                ]);
            }

            // Update debt
            $debt->person_name = $request->person_name;
            $debt->amount = $request->amount;
            $debt->due_date = $request->due_date;
            $debt->account = $request->account;

            // Recalculate status based on amount_paid vs new amount
            if ($debt->amount_paid >= $debt->amount) {
                $debt->status = 'paid';
            } elseif ($debt->amount_paid > 0) {
                $debt->status = 'partially_paid';
            } else {
                $debt->status = 'unpaid';
            }

            $debt->save();

            DB::commit();

            return redirect()->route('debts.index')->with('success', 'Catatan hutang/piutang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('debts.index')->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $debt->delete();
        // We do not reverse transactions automatically on delete to avoid messing up history,
        // or we could. For now, just delete the tracker.
        
        return redirect()->route('debts.index')->with('success', 'Catatan hutang/piutang berhasil dihapus.');
    }
}
