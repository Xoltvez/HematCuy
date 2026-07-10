@extends('layouts.app')

@section('content')
<style>
.transaction-main-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    width: 100%;
}

.filter-tabs .btn-filter {
    flex: 1;
    text-align: center;
}

@media (max-width: 768px) {
    .transaction-main-row {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .transaction-actions {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(255,255,255,0.05);
        padding-top: 0.75rem;
    }
    
    .transaction-meta {
        gap: 0.5rem !important;
    }

    .filter-tabs {
        width: 100% !important;
        flex-wrap: nowrap !important;
        gap: 0.25rem !important;
    }

    .btn-filter {
        flex: 1 !important;
        text-align: center !important;
        padding: 0.5rem 0.25rem !important;
        font-size: 0.8rem !important;
    }
}
</style>

<div class="transaction-history-section" style="max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
                <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Riwayat Seluruh Transaksi</h2>
            <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.95rem; margin-bottom: 0;">Lihat semua riwayat pemasukan dan pengeluaran Anda</p>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: flex-end;">

            
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <select id="typeFilterDropdown" style="background: rgba(0,0,0,0.4) url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23ffffff%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E') no-repeat right 0.75rem top 50%; background-size: 0.65rem auto; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 0.5rem; padding: 0 2rem 0 1rem; font-size: 0.85rem; font-weight: 500; cursor: pointer; outline: none; appearance: none; -webkit-appearance: none; height: 38px; box-sizing: border-box; min-width: 160px; font-family: inherit;">
                    <option value="all" style="background: #1e293b; color: #fff;">Semua Transaksi</option>
                    <option value="income" style="background: #1e293b; color: #fff;">Pemasukan</option>
                    <option value="expense" style="background: #1e293b; color: #fff;">Pengeluaran</option>
                    <option value="tabungan" style="background: #1e293b; color: #fff;">Tabungan</option>
                </select>

                <a href="{{ route('transactions.export.pdf') }}" target="_blank" class="btn" style="background: rgba(244, 63, 94, 0.1); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.2); display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem; padding: 0 1rem; font-size: 0.85rem; font-weight: 500; border-radius: 0.5rem; text-decoration: none; height: 38px; box-sizing: border-box;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Cetak PDF
                </a>
            </div>
        </div>
    </div>
    
    <div style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem; flex-wrap: wrap; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.05);">
        <input type="text" id="searchInput" placeholder="Pencarian spesifik (judul / kategori)..." style="flex: 1; min-width: 150px;">
        <input type="text" id="dateFilter" class="custom-filter-date" placeholder="dd/mm/yyyy" style="width: 150px;">
        <button type="button" id="btnResetFilter" class="btn" style="width: auto; background: rgba(255,255,255,0.1); color: var(--text-main);">Reset Filter</button>
    </div>
    
    @if($transactions->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
            <p>Belum ada transaksi yang dicatat.</p>
        </div>
    @else
        <ul class="transaction-list">
            @foreach($transactions as $transaction)
                <li class="transaction-item {{ $transaction->type }} premium-glow-card" 
                    data-title="{{ strtolower($transaction->title) }}" 
                    data-category="{{ strtolower($transaction->category ?? '') }}" 
                    data-date="{{ $transaction->date }}"
                    style="display: block; transition: all 0.3s ease;">
                    
                    <div class="transaction-main-row">
                        <div class="transaction-info">
                        <div class="transaction-title">{{ $transaction->title }}</div>
                        <div class="transaction-meta">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline; vertical-align:text-bottom; margin-right:2px;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                {{ $transaction->date }}
                            </span>
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
                                "{{ $transaction->description }}"
                            </div>
                        @endif
                        
                        </div>
                        <div class="transaction-actions" style="flex-shrink: 0;">
                            <span class="transaction-amount" style="white-space: nowrap;">
                                @php
                                    $amt = $transaction->amount;
                                    if ($amt >= 10000000) {
                                        $val = floor($amt / 100000) / 10;
                                        $formatted = number_format($val, $val == floor($val) ? 0 : 1, ',', '.') . 'jt';
                                    } else {
                                        $formatted = number_format($amt, 0, ',', '.');
                                    }
                                @endphp
                                {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ $formatted }}
                            </span>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <a href="{{ route('transactions.edit', $transaction) }}" class="btn-edit" title="Edit" style="color: var(--text-muted); padding: 0.25rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="delete-form" onsubmit="confirmDelete(event, this, 'Hapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Hapus" style="color: var(--color-expense); padding: 0.25rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($transaction->items && $transaction->items->count() > 0)
                        <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px dashed rgba(255,255,255,0.1); width: 100%;">
                            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600;">🛒 Rincian Belanja:</div>
                            <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.85rem; color: var(--text-main);">
                                @foreach($transaction->items as $item)
                                    <li style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                                        <span style="flex: 1;">{{ $item->qty }}x {{ $item->name }}</span>
                                        <span style="font-weight: 500;">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeFilterDropdown = document.getElementById('typeFilterDropdown');
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

            const isTabungan = category.includes('tabungan ekstra');

            // Check Type Filter
            let matchesType = true;
            if (currentTypeFilter === 'all') {
                if (isTabungan) matchesType = false;
            } else if (currentTypeFilter === 'income') {
                if (!isIncome || isTabungan) matchesType = false;
            } else if (currentTypeFilter === 'expense') {
                if (!isExpense || isTabungan) matchesType = false;
            } else if (currentTypeFilter === 'tabungan') {
                if (!isTabungan) matchesType = false;
            }

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
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (typeFilterDropdown) {
        typeFilterDropdown.addEventListener('change', (e) => {
            currentTypeFilter = e.target.value;
            applyFilters();
        });
    }

    if(searchInput) searchInput.addEventListener('input', applyFilters);
    if(dateFilter) dateFilter.addEventListener('change', applyFilters);

    if(btnResetFilter) {
        btnResetFilter.addEventListener('click', () => {
            searchInput.value = '';
            dateFilter.value = '';
            if (typeFilterDropdown) typeFilterDropdown.value = 'all';
            currentTypeFilter = 'all';
            applyFilters();
        });
    }

    // Apply filters immediately on page load to hide Tabungan Ekstra from the 'Semua' view
    applyFilters();
});
</script>
@endsection
