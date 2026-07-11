@extends('layouts.app')

@section('content')

<div style="max-width: 1200px; margin: 0 auto;">

@if(session('success'))
<div class="alert alert-success" style="margin-bottom: 2rem;">
    {{ session('success') }}
</div>
@endif

<!-- Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Welcome, {{ explode(' ', auth()->user()->name)[0] }} 👋</h2>
        <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.95rem; margin-bottom: 0;">Ringkasan keuangan Anda hari ini</p>
    </div>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <button type="button" id="toggleBalance" class="btn" style="background: rgba(255,255,255,0.05); color: var(--text-main); display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: 1px solid rgba(255,255,255,0.1); padding: 0 1rem; height: 42px; width: auto; box-sizing: border-box;">
            <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
        </button>
    </div>
</div>

<!-- Top Cards -->
<div class="animate-fade-in-up" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    
    <!-- Balance Card -->
    <div class="premium-glow-card" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.08) 100%); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: var(--radius-xl); padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
        
        <div class="custom-dropdown" style="position: relative; margin-bottom: 1rem;">
            <div id="balanceDropdownTrigger" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.95rem; font-weight: 500; cursor: pointer; padding: 0.3rem 0.6rem; margin-left: -0.6rem; border-radius: var(--radius-md); transition: all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #60a5fa;"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                <span id="balanceDropdownLabel">Total Saldo</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </div>
            
            <div id="balanceDropdownMenu" style="position: absolute; top: 100%; left: -0.5rem; background: rgba(20, 20, 20, 0.95); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: 0.5rem; display: none; flex-direction: column; gap: 0.25rem; min-width: 160px; z-index: 50; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.5);">
                <div class="dropdown-item active" data-value="total" style="padding: 0.5rem 1rem; border-radius: var(--radius-md); cursor: pointer; font-size: 0.9rem; transition: all 0.2s;">Total Saldo</div>
                <div class="dropdown-item" data-value="cash" style="padding: 0.5rem 1rem; border-radius: var(--radius-md); cursor: pointer; font-size: 0.9rem; color: var(--text-muted); transition: all 0.2s;">Saldo Tunai</div>
                <div class="dropdown-item" data-value="bank" style="padding: 0.5rem 1rem; border-radius: var(--radius-md); cursor: pointer; font-size: 0.9rem; color: var(--text-muted); transition: all 0.2s;">Saldo Bank</div>
            </div>
        </div>
        <div style="margin-bottom: 1.5rem;">
            <div id="mainBalanceAmount" class="amount" 
                data-original="Rp {{ number_format($balanceTotal, 0, ',', '.') }}" 
                data-total="Rp {{ number_format($balanceTotal, 0, ',', '.') }}" 
                data-cash="Rp {{ number_format($balanceCash, 0, ',', '.') }}" 
                data-bank="Rp {{ number_format($balanceBank, 0, ',', '.') }}" 
                style="font-size: 2rem; font-weight: 700; color: #fff; letter-spacing: -0.5px;">Rp {{ number_format($balanceTotal, 0, ',', '.') }}</div>
        </div>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; padding: 0.75rem; text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Catat Transaksi
        </a>
    </div>

    <!-- Monthly Spent -->
    <div class="premium-glow-card" style="background: linear-gradient(135deg, rgba(244, 63, 94, 0.08) 0%, rgba(244, 63, 94, 0.02) 100%); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(244, 63, 94, 0.15); border-radius: var(--radius-xl); padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div style="color: var(--text-muted); font-size: 0.95rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #fb7185;"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                Pengeluaran Bulanan
            </div>
        </div>
        <div>
            <div class="amount" data-original="Rp {{ number_format($totalExpense, 0, ',', '.') }}" style="font-size: 2rem; font-weight: 700; color: #fff; letter-spacing: -0.5px; margin-bottom: 0.5rem;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            
            @php 
                $isExpenseUp = $expenseChange > 0;
                $expenseBadgeColor = $isExpenseUp ? '#fb7185' : '#34d399';
                $expenseBgColor = $isExpenseUp ? 'rgba(244, 63, 94, 0.1)' : 'rgba(16, 185, 129, 0.1)';
                $expenseIcon = $isExpenseUp ? '<path d="m18 15-6-6-6 6"/>' : '<path d="m6 9 6 6 6-6"/>';
            @endphp
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="background: {{ $expenseBgColor }}; color: {{ $expenseBadgeColor }}; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $expenseIcon !!}</svg>
                    {{ number_format(abs($expenseChange), 1, ',', '') }}%
                </span>
                <span style="color: var(--text-muted); font-size: 0.85rem;">vs bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- Monthly Income -->
    <div class="premium-glow-card" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.02) 100%); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(16, 185, 129, 0.15); border-radius: var(--radius-xl); padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div style="color: var(--text-muted); font-size: 0.95rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #34d399;"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                Pemasukan Bulanan
            </div>
        </div>
        <div>
            <div class="amount" data-original="Rp {{ number_format($totalIncome, 0, ',', '.') }}" style="font-size: 2rem; font-weight: 700; color: #fff; letter-spacing: -0.5px; margin-bottom: 0.5rem;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            
            @php 
                $isIncomeUp = $incomeChange > 0;
                $incomeBadgeColor = $isIncomeUp ? '#34d399' : '#fb7185';
                $incomeBgColor = $isIncomeUp ? 'rgba(16, 185, 129, 0.1)' : 'rgba(244, 63, 94, 0.1)';
                $incomeIcon = $isIncomeUp ? '<path d="m18 15-6-6-6 6"/>' : '<path d="m6 9 6 6 6-6"/>';
            @endphp
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="background: {{ $incomeBgColor }}; color: {{ $incomeBadgeColor }}; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $incomeIcon !!}</svg>
                    {{ number_format(abs($incomeChange), 1, ',', '') }}%
                </span>
                <span style="color: var(--text-muted); font-size: 0.85rem;">vs bulan lalu</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Layout -->
<div class="dashboard-main-grid animate-fade-in-up" style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; align-items: start; animation-delay: 150ms;">
    
    <!-- Left Column -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Kategori Minggu Ini -->
        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Kategori Minggu Ini</h3>
                <span style="font-size: 0.8rem; color: var(--text-muted); background: rgba(255,255,255,0.05); padding: 0.2rem 0.6rem; border-radius: 12px;">Top Pengeluaran</span>
            </div>
            
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: flex-start;">
                @php
                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899'];
                @endphp
                @forelse($topCategories as $cat)
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; width: 60px;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: {{ $colors[$loop->index % count($colors)] }}20; color: {{ $colors[$loop->index % count($colors)] }}; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; border: 2px solid {{ $colors[$loop->index % count($colors)] }}40;">
                            @php
                                $catName = strtolower($cat['name']);
                            @endphp
                            @if(str_contains($catName, 'makanan') || str_contains($catName, 'minuman'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>
                            @elseif(str_contains($catName, 'transportasi') || str_contains($catName, 'bensin') || str_contains($catName, 'kendaraan'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                            @elseif(str_contains($catName, 'gaji') || str_contains($catName, 'pendapatan') || str_contains($catName, 'bonus'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                            @elseif(str_contains($catName, 'belanja') || str_contains($catName, 'shopping') || str_contains($catName, 'pakaian'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                            @elseif(str_contains($catName, 'tagihan') || str_contains($catName, 'listrik') || str_contains($catName, 'internet'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
                            @elseif(str_contains($catName, 'kesehatan') || str_contains($catName, 'obat') || str_contains($catName, 'medis'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                            @elseif(str_contains($catName, 'hiburan') || str_contains($catName, 'entertainment'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h20"/><path d="M12 2v20"/><path d="m4.93 4.93 14.14 14.14"/><path d="m4.93 19.07 14.14-14.14"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
                            @endif
                        </div>
                        <span style="font-size: 0.75rem; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%; color: var(--text-muted);">{{ $cat['name'] }}</span>
                    </div>
                @empty
                    <div style="color: var(--text-muted); font-size: 0.9rem; text-align: center; width: 100%;">Belum ada pengeluaran minggu ini.</div>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Terakhir -->
        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Aktivitas Terakhir</h3>
                <a href="{{ route('transactions.history') }}" style="font-size: 0.85rem; color: var(--color-primary); text-decoration: none;">Lihat Semua</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($recentTransactions as $tx)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            @if($tx->type === 'income')
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); color: #34d399; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 5-5-3-5 3"/></svg>
                                </div>
                            @else
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(244, 63, 94, 0.1); color: #fb7185; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 19-5 3-5-3"/></svg>
                                </div>
                            @endif
                            <div>
                                <div style="font-weight: 500; font-size: 0.95rem;">{{ $tx->title }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">
                                    {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                                    @if($tx->time)
                                        &bull; {{ \Carbon\Carbon::parse($tx->time)->format('H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div style="font-weight: 600; font-size: 0.95rem; color: {{ $tx->type === 'income' ? '#34d399' : '#fff' }}; white-space: nowrap;">
                            @php
                                $amt = $tx->amount;
                                if ($amt >= 10000000) {
                                    $val = floor($amt / 100000) / 10;
                                    $formatted = number_format($val, $val == floor($val) ? 0 : 1, ',', '.') . 'jt';
                                } else {
                                    $formatted = number_format($amt, 0, ',', '.');
                                }
                            @endphp
                            {{ $tx->type === 'income' ? '+' : '-' }}Rp {{ $formatted }}
                        </div>
                    </div>
                @empty
                    <div style="color: var(--text-muted); font-size: 0.9rem; text-align: center;">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Cashflow Chart -->
        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Arus Kas (Bulan Ini)</h3>
                <div style="display: flex; gap: 1rem; font-size: 0.8rem;">
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6;"></div> Pemasukan
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #fb7185;"></div> Pengeluaran
                    </div>
                </div>
            </div>
            <div style="position: relative; height: 250px; width: 100%;">
                <canvas id="cashflowChart"></canvas>
            </div>
        </div>

        <!-- Savings / Alokasi -->
        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div>
                    <h3 style="margin: 0 0 0.25rem 0; font-size: 1.1rem; font-weight: 600;">Budgeting</h3>
                    <div style="font-size: 1.25rem; font-weight: 700; color: #fff;">
                        Rp {{ number_format(collect($allocationsData)->sum('amount'), 0, ',', '.') }}
                        <span style="font-size: 0.85rem; font-weight: normal; color: #34d399; margin-left: 0.5rem; background: rgba(16, 185, 129, 0.1); padding: 0.2rem 0.5rem; border-radius: 4px;">Terencana</span>
                    </div>
                </div>
                <a href="{{ route('allocations.index') }}" style="background: rgba(255,255,255,0.05); color: var(--text-main); text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.1);">Atur Uang</a>
            </div>

            <div class="budgeting-grid" style="display: grid; gap: 1.5rem;">
                @forelse($allocationsData->take(3) as $allocation)
                    @php
                        $barColor = '#3b82f6';
                        if ($allocation['percentage'] > 75) $barColor = '#f59e0b';
                        if ($allocation['percentage'] >= 100) $barColor = '#ef4444';
                        
                        $isDanger = $allocation['percentage'] >= 85;
                        $pulseClass = $isDanger ? 'budget-pulse-danger' : '';
                    @endphp
                    <div class="{{ $pulseClass }}" style="background: rgba(255,255,255,0.02); padding: 1rem; border-radius: var(--radius-lg); border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease;">
                        <h4 style="margin: 0 0 0.5rem 0; font-size: 0.95rem; font-weight: 600;">{{ $allocation['category_name'] }}</h4>
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 0.75rem; color: var(--text-muted);">
                            <span>Target: Rp {{ number_format($allocation['amount'], 0, ',', '.') }}</span>
                        </div>
                        <div style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; color: #fff;">
                            Rp {{ number_format($allocation['amount'] - $allocation['spent'], 0, ',', '.') }} <span style="font-size: 0.75rem; font-weight: normal; color: var(--text-muted);">Sisa</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="flex: 1; height: 8px; background: rgba(0,0,0,0.3); border-radius: 99px; overflow: hidden;">
                                <div class="budget-progress" data-percent="{{ $allocation['percentage'] }}" style="height: 100%; width: 0%; background: {{ $barColor }}; border-radius: 99px; transition: width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);"></div>
                            </div>
                            <span style="font-size: 0.8rem; font-weight: 600; color: {{ $barColor }};">{{ $allocation['percentage'] }}%</span>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; padding: 2rem; text-align: center; color: var(--text-muted); font-size: 0.9rem; border: 1px dashed rgba(255,255,255,0.1); border-radius: var(--radius-lg);">
                        Anda belum merencanakan budgeting bulan ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
.budgeting-grid {
    grid-template-columns: repeat(3, 1fr);
}
@media (max-width: 992px) {
    .budgeting-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 768px) {
    .budgeting-grid {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 992px) {
    .dashboard-main-grid {
        grid-template-columns: 1fr !important;
    }
}
#balanceDropdownTrigger:hover { background: rgba(255,255,255,0.05); color: #fff !important; }
.dropdown-item:hover { background: rgba(255,255,255,0.1); color: #fff !important; }
.dropdown-item.active { background: rgba(59, 130, 246, 0.15); color: #3b82f6 !important; font-weight: 600; }
</style>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Balance Visibility
    const toggleBalanceBtn = document.getElementById('toggleBalance');
    const amountElements = document.querySelectorAll('.amount');
    const iconEyeOpen = document.getElementById('icon-eye-open');
    const iconEyeClosed = document.getElementById('icon-eye-closed');
    
    let isBalanceHidden = localStorage.getItem('isBalanceHidden') === 'true';

    function updateBalanceVisibility() {
        if (isBalanceHidden) {
            amountElements.forEach(el => el.innerText = 'Rp ••••••••');
            iconEyeOpen.style.display = 'none';
            iconEyeClosed.style.display = 'block';
        } else {
            amountElements.forEach(el => el.innerText = el.getAttribute('data-original'));
            iconEyeOpen.style.display = 'block';
            iconEyeClosed.style.display = 'none';
        }
    }
    updateBalanceVisibility();

    toggleBalanceBtn.addEventListener('click', () => {
        isBalanceHidden = !isBalanceHidden;
        localStorage.setItem('isBalanceHidden', isBalanceHidden);
        updateBalanceVisibility();
    });

    // Custom Balance Dropdown Logic
    const balanceDropdownTrigger = document.getElementById('balanceDropdownTrigger');
    const balanceDropdownMenu = document.getElementById('balanceDropdownMenu');
    const balanceDropdownLabel = document.getElementById('balanceDropdownLabel');
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const mainBalanceAmount = document.getElementById('mainBalanceAmount');

    if (balanceDropdownTrigger && balanceDropdownMenu) {
        balanceDropdownTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            balanceDropdownMenu.style.display = balanceDropdownMenu.style.display === 'flex' ? 'none' : 'flex';
        });

        document.addEventListener('click', () => {
            balanceDropdownMenu.style.display = 'none';
        });

        dropdownItems.forEach(item => {
            item.addEventListener('click', (e) => {
                const selectedType = item.getAttribute('data-value');
                const selectedText = item.innerText;
                
                // Update label
                balanceDropdownLabel.innerText = selectedText;
                
                // Update active state
                dropdownItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                
                // Update amount
                const newAmount = mainBalanceAmount.getAttribute('data-' + selectedType);
                mainBalanceAmount.setAttribute('data-original', newAmount);
                updateBalanceVisibility();
            });
        });
    }

    // Render Cashflow Chart
    const ctx = document.getElementById('cashflowChart');
    if (ctx) {
        const context2d = ctx.getContext('2d');
        
        // Create premium gradients
        const incomeGradient = context2d.createLinearGradient(0, 0, 0, 250);
        incomeGradient.addColorStop(0, 'rgba(59, 130, 246, 0.22)');
        incomeGradient.addColorStop(1, 'rgba(59, 130, 246, 0.00)');
        
        const expenseGradient = context2d.createLinearGradient(0, 0, 0, 250);
        expenseGradient.addColorStop(0, 'rgba(250, 113, 133, 0.22)');
        expenseGradient.addColorStop(1, 'rgba(250, 113, 133, 0.00)');

        new Chart(context2d, {
            type: 'line',
            data: {
                labels: {!! json_encode($cashflowLabels) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($cashflowIncome) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: incomeGradient,
                        borderWidth: 2.5,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: 'rgba(255, 255, 255, 0.1)'
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($cashflowExpense) !!},
                        borderColor: '#fb7185',
                        backgroundColor: expenseGradient,
                        borderWidth: 2.5,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#fb7185',
                        pointBorderColor: 'rgba(255, 255, 255, 0.1)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255,255,255,0.05)',
                        },
                        ticks: {
                            color: 'rgba(255,255,255,0.5)',
                            callback: function(value) {
                                if (value === 0) return '0';
                                if (value >= 1000000 && value % 1000000 === 0) return (value / 1000000) + ' jt';
                                if (value >= 1000000) return (value / 1000000).toFixed(1).replace('.0', '').replace('.', ',') + ' jt';
                                if (value >= 1000 && value % 1000 === 0) return (value / 1000) + ' rb';
                                if (value >= 1000) return (value / 1000).toFixed(1).replace('.0', '').replace('.', ',') + ' rb';
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            color: 'rgba(255,255,255,0.5)',
                        }
                    }
                }
            }
        });
    }

    // Animate budgeting progress bars
    setTimeout(() => {
        document.querySelectorAll('.budget-progress').forEach(bar => {
            const percent = bar.getAttribute('data-percent');
            bar.style.width = percent + '%';
        });
    }, 200);
});
</script>
</div>
@endsection
