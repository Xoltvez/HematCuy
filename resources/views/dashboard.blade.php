@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2>Ringkasan</h2>
        <p style="margin-bottom: 0;">Selamat datang kembali! Berikut ringkasan keuangan Anda.</p>
    </div>
    <button type="button" id="toggleBalance" class="btn" style="background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
        <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
        <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
        <span id="toggleText">Sembunyikan Saldo</span>
    </button>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="summary-cards">
        <div class="card balance-card" style="border-left: 4px solid #60a5fa;">
            <h3>Saldo Tunai (Cash)</h3>
            <p class="amount">Rp {{ number_format($balanceCash, 2, ',', '.') }}</p>
        </div>
        <div class="card balance-card" style="border-left: 4px solid #a78bfa;">
            <h3>Saldo Bank</h3>
            <p class="amount">Rp {{ number_format($balanceBank, 2, ',', '.') }}</p>
        </div>
    <div class="card income-card">
        <h3>Total Pemasukan</h3>
        <p class="amount">Rp {{ number_format($totalIncome, 2, ',', '.') }}</p>
    </div>
    <div class="card expense-card">
        <h3>Total Pengeluaran</h3>
        <p class="amount">Rp {{ number_format($totalExpense, 2, ',', '.') }}</p>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Transaction Form -->
    <div class="transaction-form-section">
        <h3>Tambah Transaksi Baru</h3>
        <form action="{{ route('transactions.store') }}" method="POST" class="transaction-form">
            @csrf
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" id="title" name="title" required placeholder="Cth. Gaji, Beli Makanan">
            </div>
            
            <div class="form-group">
                <label for="amount">Jumlah (Rp)</label>
                <input type="number" id="amount" name="amount" required min="0" step="any" placeholder="0">
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
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
                <div>
                    <label for="account">Sumber Dana</label>
                    <select id="account" name="account" required>
                        <option value="cash">Tunai (Cash)</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <input type="text" id="category" name="category" placeholder="Cth. Makanan, Transportasi">
            </div>

            <div class="form-group">
                <label for="description">Keterangan / Deskripsi</label>
                <textarea id="description" name="description" placeholder="Tambahkan catatan opsional" rows="2" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(15, 23, 42, 0.5); color: white; font-family: inherit; font-size: 0.95rem; resize: vertical;"></textarea>
            </div>

            <div class="form-group">
                <label for="date">Tanggal</label>
                <input type="date" id="date" name="date" required value="{{ date('Y-m-d') }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </form>
    </div>

    <!-- Transaction History -->
    <div class="transaction-history-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
            <h3 style="margin: 0;">Riwayat Transaksi</h3>
            <div class="filter-tabs" style="display: flex; flex-wrap: wrap; gap: 0.5rem; background: rgba(0,0,0,0.2); padding: 0.25rem; border-radius: 0.5rem;">
                <button type="button" class="btn-filter active" data-filter="all">Semua</button>
                <button type="button" class="btn-filter" data-filter="income">Pemasukan</button>
                <button type="button" class="btn-filter" data-filter="expense">Pengeluaran</button>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
            <input type="text" id="searchInput" placeholder="Cari judul atau kategori..." style="flex: 1; min-width: 200px; padding: 0.5rem 1rem; font-size: 0.9rem;">
            <input type="date" id="dateFilter" style="width: auto; padding: 0.5rem 1rem; font-size: 0.9rem;">
            <button type="button" id="btnResetFilter" class="btn" style="width: auto; padding: 0.5rem 1rem; background: rgba(255,255,255,0.1); color: var(--text-main);">Reset</button>
        </div>
        @if($transactions->isEmpty())
            <div class="empty-state">
                <p>Belum ada transaksi. Ayo mulai mencatat!</p>
            </div>
        @else
            <ul class="transaction-list">
                @foreach($transactions as $transaction)
                    <li class="transaction-item {{ $transaction->type }}" 
                        data-title="{{ strtolower($transaction->title) }}" 
                        data-category="{{ strtolower($transaction->category ?? '') }}" 
                        data-date="{{ $transaction->date }}">
                        <div class="transaction-info">
                            <div class="transaction-title">{{ $transaction->title }}</div>
                            <div class="transaction-meta">
                                <span>{{ $transaction->date }}</span>
                                <span class="category-badge type-badge {{ $transaction->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                    {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                                <span class="category-badge" style="background-color: rgba(96, 165, 250, 0.2); color: #60a5fa;">
                                    {{ $transaction->account === 'bank' ? '🏦 Bank' : '💵 Tunai' }}
                                </span>
                                @if($transaction->category)
                                    <span class="category-badge">{{ $transaction->category }}</span>
                                @endif
                            </div>
                            @if($transaction->description)
                                <div style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-muted); font-style: italic;">
                                    {{ $transaction->description }}
                                </div>
                            @endif
                        </div>
                        <div class="transaction-actions">
                            <span class="transaction-amount">
                                {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 2, ',', '.') }}
                            </span>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <a href="{{ route('transactions.edit', $transaction) }}" class="btn-edit" title="Edit" style="color: var(--text-muted); display: flex; align-items: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="delete-form" onsubmit="return confirm('Hapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Hapus" style="color: var(--color-expense); display: flex; align-items: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.btn-filter');
    const transactionItems = document.querySelectorAll('.transaction-item');
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const btnResetFilter = document.getElementById('btnResetFilter');

    let currentTypeFilter = 'all';

    function applyFilters() {
        const searchText = searchInput.value.toLowerCase();
        const searchDate = dateFilter.value;

        transactionItems.forEach(item => {
            const title = item.getAttribute('data-title');
            const category = item.getAttribute('data-category');
            const date = item.getAttribute('data-date');
            const isIncome = item.classList.contains('income');
            const isExpense = item.classList.contains('expense');

            // Check Type Filter
            let matchesType = true;
            if (currentTypeFilter === 'income' && !isIncome) matchesType = false;
            if (currentTypeFilter === 'expense' && !isExpense) matchesType = false;

            // Check Search Filter
            let matchesSearch = true;
            if (searchText !== '') {
                matchesSearch = title.includes(searchText) || category.includes(searchText);
            }

            // Check Date Filter
            let matchesDate = true;
            if (searchDate !== '') {
                matchesDate = (date === searchDate);
            }

            if (matchesType && matchesSearch && matchesDate) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentTypeFilter = btn.getAttribute('data-filter');
            applyFilters();
        });
    });

    searchInput.addEventListener('input', applyFilters);
    dateFilter.addEventListener('change', applyFilters);

    btnResetFilter.addEventListener('click', () => {
        searchInput.value = '';
        dateFilter.value = '';
        filterBtns.forEach(b => b.classList.remove('active'));
        document.querySelector('[data-filter="all"]').classList.add('active');
        currentTypeFilter = 'all';
        applyFilters();
    });

    // Toggle Balance Visibility
    const toggleBalanceBtn = document.getElementById('toggleBalance');
    const amountElements = document.querySelectorAll('.summary-cards .amount');
    const iconEyeOpen = document.getElementById('icon-eye-open');
    const iconEyeClosed = document.getElementById('icon-eye-closed');
    const toggleText = document.getElementById('toggleText');
    
    let isBalanceHidden = localStorage.getItem('isBalanceHidden') === 'true';
    
    amountElements.forEach(el => {
        el.setAttribute('data-original', el.innerText);
    });

    function updateBalanceVisibility() {
        if (isBalanceHidden) {
            amountElements.forEach(el => el.innerText = 'Rp ••••••••');
            iconEyeOpen.style.display = 'none';
            iconEyeClosed.style.display = 'block';
            toggleText.innerText = 'Tampilkan Saldo';
        } else {
            amountElements.forEach(el => el.innerText = el.getAttribute('data-original'));
            iconEyeOpen.style.display = 'block';
            iconEyeClosed.style.display = 'none';
            toggleText.innerText = 'Sembunyikan Saldo';
        }
    }

    // Initial load
    updateBalanceVisibility();

    toggleBalanceBtn.addEventListener('click', () => {
        isBalanceHidden = !isBalanceHidden;
        localStorage.setItem('isBalanceHidden', isBalanceHidden);
        updateBalanceVisibility();
    });
});
</script>
@endsection
