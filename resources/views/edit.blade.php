@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <h2>Edit Transaksi</h2>
    <p>Ubah detail transaksi Anda di bawah ini.</p>
</div>

<div class="transaction-form-section" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="transaction-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" id="title" name="title" required value="{{ old('title', $transaction->title) }}">
        </div>
        
        <div class="form-group">
            <label for="amount">Jumlah (Rp)</label>
            <input type="number" id="amount" name="amount" required min="0" step="any" value="{{ old('amount', $transaction->amount) }}">
            <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem; flex-wrap: wrap;">
                <button type="button" class="btn-quick-amount" onclick="document.getElementById('amount').value = (Number(document.getElementById('amount').value) || 0) + 10000">+10 Ribu</button>
                <button type="button" class="btn-quick-amount" onclick="document.getElementById('amount').value = (Number(document.getElementById('amount').value) || 0) + 50000">+50 Ribu</button>
                <button type="button" class="btn-quick-amount" onclick="document.getElementById('amount').value = (Number(document.getElementById('amount').value) || 0) + 100000">+100 Ribu</button>
                <button type="button" class="btn-quick-amount" onclick="document.getElementById('amount').value = 0" style="color: var(--color-expense); border-color: rgba(244, 63, 94, 0.3);">Reset</button>
            </div>
        </div>

        <div class="form-group grid-2-col" style="display: grid; gap: 1rem;">
            <div>
                <label for="type">Jenis</label>
                <select id="type" name="type" required>
                    <option value="income" {{ $transaction->type === 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ $transaction->type === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div>
                <label for="account">Sumber Dana</label>
                <select id="account" name="account" required>
                    <option value="cash" {{ $transaction->account === 'cash' ? 'selected' : '' }}>Tunai (Cash)</option>
                    <option value="bank" {{ $transaction->account === 'bank' ? 'selected' : '' }}>Bank</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="category">Kategori</label>
            <input type="text" id="category" name="category" value="{{ old('category', $transaction->category) }}">
        </div>

        <div class="form-group">
            <label for="description">Keterangan / Deskripsi</label>
            <textarea id="description" name="description" placeholder="Tambahkan catatan opsional" rows="2" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(15, 23, 42, 0.5); color: white; font-family: inherit; font-size: 0.95rem; resize: vertical;">{{ old('description', $transaction->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="date">Tanggal</label>
            <input type="date" id="date" name="date" required value="{{ old('date', $transaction->date) }}">
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <a href="{{ route('dashboard') }}" class="btn" style="background-color: transparent; border: 1px solid var(--border-color); color: var(--text-main);">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui Transaksi</button>
        </div>
    </form>
</div>
@endsection
