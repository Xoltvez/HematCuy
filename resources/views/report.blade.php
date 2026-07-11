@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Laporan Keuangan</h2>
            <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.95rem; margin-bottom: 0;">Ringkasan aktivitas dan arus kas Anda</p>
        </div>
        
        <!-- Toggle Balance -->
        <button type="button" id="toggleBalance" class="btn" style="background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem; border: 1px solid rgba(255,255,255,0.1); width: auto; padding: 0.5rem 1rem;">
            <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
            <span id="toggleText" style="font-size: 0.85rem;">Sembunyikan Saldo</span>
        </button>
    </div>

    <style>
        .custom-filter-select {
            appearance: none;
            -webkit-appearance: none;
            background: rgba(255,255,255,0.03) url("data:image/svg+xml;utf8,<svg fill='rgba(255,255,255,0.6)' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>") no-repeat right 0.5rem center;
            background-size: 1.25rem;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-md);
            color: var(--text-main);
            padding: 0.6rem 2.25rem 0.6rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .custom-filter-select:hover, .custom-filter-select:focus, .custom-filter-date:hover, .custom-filter-date:focus {
            background-color: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.25);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .custom-filter-select option {
            background: var(--bg-dark);
            color: white;
            padding: 0.5rem;
        }
        .custom-filter-date {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-md);
            color: var(--text-main);
            padding: 0.55rem 0.85rem;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
        }
        .custom-filter-date::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.5;
            cursor: pointer;
            transition: opacity 0.2s;
            padding: 0.2rem;
            margin-left: 0.5rem;
        }
        .custom-filter-date::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }

        /* Report Filter Styling */
        .filter-card {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            border-radius: var(--radius-xl);
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .filter-card-title {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .segmented-control {
            display: flex;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: var(--radius-lg);
            padding: 0.25rem;
            gap: 0.25rem;
            flex-wrap: wrap;
        }
        .segmented-control .btn-segment {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .segmented-control .btn-segment.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .segmented-control .btn-segment:hover:not(.active) {
            background: rgba(255,255,255,0.05);
            color: var(--text-main);
        }
        
        .custom-filter-month {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-md);
            color: var(--text-main);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
            cursor: pointer;
            font-family: inherit;
            width: 100%;
            box-sizing: border-box;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .custom-filter-month::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.5;
            cursor: pointer;
            transition: opacity 0.2s;
            padding: 0.2rem;
        }
        .custom-filter-month::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .filter-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .segmented-control {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
            }
            .segmented-control .btn-segment {
                text-align: center;
                padding: 0.5rem;
            }
            #input-kalender > div {
                flex-direction: column;
                align-items: stretch !important;
            }
            #btn-apply-kalender {
                width: 100%;
            }
        }
        }
        .btn-pdf-download:hover {
            background: rgba(239, 68, 68, 0.4) !important;
            color: #fff !important;
        }
    </style>

    <!-- Filter UI -->
    <form action="{{ route('report') }}" method="GET" id="report-filter-form">
        <input type="hidden" name="year" id="hidden_year" value="{{ request('year') }}">
        <input type="hidden" name="month" id="hidden_month" value="{{ request('month') }}">
        <input type="hidden" name="start_date" id="hidden_start" value="{{ request('start_date') }}">
        <input type="hidden" name="end_date" id="hidden_end" value="{{ request('end_date') }}">
    </form>

    <div class="filter-card">
        <div class="filter-card-title" style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <span>SARING RENTANG STATISTIK</span>
            <a href="{{ route('report.pdf', request()->all()) }}" class="btn-pdf-download" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); text-decoration: none; padding: 0.4rem 0.75rem; border-radius: var(--radius-md); font-size: 0.75rem; font-weight: 600; letter-spacing: 0; text-transform: none; transition: all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Cetak PDF
            </a>
        </div>
        <div class="segmented-control">
            <button type="button" class="btn-segment" data-mode="hari_ini">Hari Ini</button>
            <button type="button" class="btn-segment active" data-mode="bulanan">Bulanan</button>
            <button type="button" class="btn-segment" data-mode="kalender">Kalender</button>
            <button type="button" class="btn-segment" data-mode="semua">Semua</button>
        </div>
    </div>
    
    <div class="filter-card" id="filter-input-card" style="display: none; flex-direction: column; align-items: stretch; gap: 0.75rem; margin-bottom: 2rem;">
        <div class="filter-card-title" id="filter-input-title" style="margin-bottom: 0.25rem;">PILIH BULAN & TAHUN</div>
        
        <!-- For Bulanan -->
        <div id="input-bulanan">
            <input type="month" id="month_picker" class="custom-filter-month">
        </div>
        
        <!-- For Kalender -->
        <div id="input-kalender" style="display: none;">
            <div style="display: flex; gap: 1rem; align-items: center; width: 100%;">
                <input type="date" id="start_date_picker" value="{{ request('start_date') }}" class="custom-filter-date" placeholder="Dari Tanggal" style="flex: 1;">
                <span style="color: var(--text-muted); font-weight: 600;">-</span>
                <input type="date" id="end_date_picker" value="{{ request('end_date') }}" class="custom-filter-date" placeholder="Sampai Tanggal" style="flex: 1;">
                <button type="button" class="btn btn-primary" id="btn-apply-kalender" style="padding: 0.75rem 1.5rem; font-weight: 600; width: auto;">Terapkan</button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                </div>
                <div style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Saldo Tunai</div>
            </div>
            <div class="card-info-amount" data-original="Rp {{ number_format($balanceCash, 0, ',', '.') }}" style="font-size: 1.75rem; font-weight: 700; color: #fff; letter-spacing: -0.5px;">Rp {{ number_format($balanceCash, 0, ',', '.') }}</div>
        </div>
        
        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(167, 139, 250, 0.1); color: #a78bfa; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                </div>
                <div style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Saldo Bank</div>
            </div>
            <div class="card-info-amount" data-original="Rp {{ number_format($balanceBank, 0, ',', '.') }}" style="font-size: 1.75rem; font-weight: 700; color: #fff; letter-spacing: -0.5px;">Rp {{ number_format($balanceBank, 0, ',', '.') }}</div>
        </div>
        
        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); color: #34d399; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                </div>
                <div style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pemasukan</div>
            </div>
            <div class="card-info-amount" data-original="Rp {{ number_format($totalIncome, 0, ',', '.') }}" style="font-size: 1.75rem; font-weight: 700; color: #34d399; letter-spacing: -0.5px;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
        </div>

        <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(244, 63, 94, 0.1); color: #fb7185; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                </div>
                <div style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pengeluaran</div>
            </div>
            <div class="card-info-amount" data-original="Rp {{ number_format($totalExpense, 0, ',', '.') }}" style="font-size: 1.75rem; font-weight: 700; color: #fb7185; letter-spacing: -0.5px;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Trend Chart Section -->
    @php
        // Prepare Trend Chart Data
        $trendTxs = $transactions->groupBy('date')->sortBy(function($item, $key) {
            return $key; // sort by date ascending
        });

        $trendLabels = [];
        $trendIncome = [];
        $trendExpense = [];
        
        foreach ($trendTxs as $date => $txs) {
            $trendLabels[] = \Carbon\Carbon::parse($date)->format('d M');
            $trendIncome[] = $txs->where('type', 'income')->sum('amount');
            $trendExpense[] = $txs->where('type', 'expense')->sum('amount');
        }
    @endphp

    <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2rem; margin-bottom: 2rem;">
        <h3 style="margin: 0 0 1.5rem 0; font-size: 1.25rem; font-weight: 600;">Tren Arus Kas</h3>
        
        @if(count($trendLabels) === 0)
            <div class="empty-state" style="padding: 2rem 0; text-align: center;">
                <p style="color: var(--text-muted);">Belum ada data transaksi untuk ditampilkan pada grafik.</p>
            </div>
        @else
            <div style="width: 100%; height: 300px; position: relative;">
                <canvas id="trendChart"></canvas>
            </div>
        @endif
    </div>

    <!-- Chart & Details Section -->
    <div style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2rem;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Rincian Kategori</h3>
            <div class="filter-tabs" style="display: flex; gap: 0.5rem; background: rgba(0,0,0,0.4); padding: 0.35rem; border-radius: 2rem; border: 1px solid rgba(255,255,255,0.05);">
                <button type="button" class="btn-filter" id="btn-toggle-income" style="border-radius: 2rem; min-width: 120px; transition: all 0.3s ease;">Pemasukan</button>
                <button type="button" class="btn-filter active" id="btn-toggle-expense" style="border-radius: 2rem; background: var(--color-primary); color: white; min-width: 120px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); transition: all 0.3s ease;">Pengeluaran</button>
            </div>
        </div>
        
        <div class="report-grid-layout">
            <!-- Chart Container -->
            <div class="chart-container" style="width: 100%; display: flex; align-items: center; justify-content: center; position: relative;">
                <div style="width: 100%; max-width: 320px; aspect-ratio: 1; position: relative;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- List Container -->
            <div class="report-list" style="background: rgba(0,0,0,0.1); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid rgba(255,255,255,0.02);">
                @php
                    $palette = ['#3b82f6', '#8b5cf6', '#ec4899', '#10b981', '#f59e0b', '#06b6d4', '#f43f5e', '#6366f1', '#14b8a6', '#f97316', '#64748b'];
                    $expData = []; $incData = [];
                    $expColors = []; $incColors = [];
                    $expLabels = []; $incLabels = [];
                @endphp

                <!-- Expense Categories -->
                <div id="expense-categories">
                    <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--text-muted); margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.5px;">Analisis Pengeluaran</h4>
                    @if($expensesByCategory->isEmpty())
                        <div class="empty-state" style="padding: 2rem 0; text-align: center;">
                            <p style="color: var(--text-muted);">Belum ada pengeluaran pada periode ini.</p>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            @php $i = 0; @endphp
                            @foreach($expensesByCategory as $category => $data)
                                @php
                                    $catName = $category ? $category : 'Lainnya';
                                    $percentage = $totalExpense > 0 ? ($data['amount'] / $totalExpense) * 100 : 0;
                                    $color = $palette[$i % count($palette)];
                                    
                                    $expLabels[] = $catName;
                                    $expData[] = $data['amount'];
                                    $expColors[] = $color;
                                    $i++;
                                @endphp
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 12px; height: 12px; border-radius: 50%; background-color: {{ $color }};"></div>
                                            <span style="font-weight: 500; font-size: 0.95rem;">{{ $catName }}</span>
                                            <span style="font-size: 0.75rem; color: var(--text-muted); background: rgba(255,255,255,0.05); padding: 0.1rem 0.4rem; border-radius: 4px;">{{ $data['count'] }} trx</span>
                                        </div>
                                        <div style="font-weight: 600; font-size: 0.95rem;">Rp {{ number_format($data['amount'], 0, ',', '.') }}</div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="flex: 1; height: 6px; background: rgba(0,0,0,0.3); border-radius: 99px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ $percentage }}%; background: {{ $color }}; border-radius: 99px;"></div>
                                        </div>
                                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); width: 40px; text-align: right;">{{ number_format($percentage, 1, ',', '') }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Income Categories -->
                <div id="income-categories" style="display: none;">
                    <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--text-muted); margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.5px;">Analisis Pemasukan</h4>
                    @if($incomesByCategory->isEmpty())
                        <div class="empty-state" style="padding: 2rem 0; text-align: center;">
                            <p style="color: var(--text-muted);">Belum ada pemasukan pada periode ini.</p>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            @php $i = 0; @endphp
                            @foreach($incomesByCategory as $category => $data)
                                @php
                                    $catName = $category ? $category : 'Lainnya';
                                    $percentage = $totalIncome > 0 ? ($data['amount'] / $totalIncome) * 100 : 0;
                                    $color = $palette[$i % count($palette)];
                                    
                                    $incLabels[] = $catName;
                                    $incData[] = $data['amount'];
                                    $incColors[] = $color;
                                    $i++;
                                @endphp
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 12px; height: 12px; border-radius: 50%; background-color: {{ $color }};"></div>
                                            <span style="font-weight: 500; font-size: 0.95rem;">{{ $catName }}</span>
                                            <span style="font-size: 0.75rem; color: var(--text-muted); background: rgba(255,255,255,0.05); padding: 0.1rem 0.4rem; border-radius: 4px;">{{ $data['count'] }} trx</span>
                                        </div>
                                        <div style="font-weight: 600; font-size: 0.95rem;">Rp {{ number_format($data['amount'], 0, ',', '.') }}</div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="flex: 1; height: 6px; background: rgba(0,0,0,0.3); border-radius: 99px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ $percentage }}%; background: {{ $color }}; border-radius: 99px;"></div>
                                        </div>
                                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); width: 40px; text-align: right;">{{ number_format($percentage, 1, ',', '') }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div> <!-- End List -->
        </div>
    </div>
</div>

<style>
.report-grid-layout {
    display: grid; 
    grid-template-columns: 1fr 1.5fr; 
    gap: 3rem; 
    align-items: start;
}
@media (max-width: 900px) {
    .report-grid-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Data
    const expLabels = {!! json_encode($expLabels) !!};
    const expData = {!! json_encode($expData) !!};
    const expColors = {!! json_encode($expColors) !!};
    
    const incLabels = {!! json_encode($incLabels) !!};
    const incData = {!! json_encode($incData) !!};
    const incColors = {!! json_encode($incColors) !!};

    let initialLabels = expLabels;
    let initialData = expData;
    let initialColors = expColors;
    let tooltipEnabled = true;

    if (expData.length === 0) {
        initialLabels = ['Belum ada data'];
        initialData = [1];
        initialColors = ['rgba(255,255,255,0.05)'];
        tooltipEnabled = false;
    }

    const ctx = document.getElementById('categoryChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: initialLabels,
            datasets: [{
                data: initialData,
                backgroundColor: initialColors,
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: tooltipEnabled,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) label += ': ';
                            if (context.parsed !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    const btnIncome = document.getElementById('btn-toggle-income');
    const btnExpense = document.getElementById('btn-toggle-expense');
    const divIncome = document.getElementById('income-categories');
    const divExpense = document.getElementById('expense-categories');

    function updateChart(labels, data, colors) {
        if (data.length === 0) {
            myChart.data.labels = ['Belum ada data'];
            myChart.data.datasets[0].data = [1];
            myChart.data.datasets[0].backgroundColor = ['rgba(255,255,255,0.05)'];
            myChart.options.plugins.tooltip.enabled = false;
        } else {
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = data;
            myChart.data.datasets[0].backgroundColor = colors;
            myChart.options.plugins.tooltip.enabled = true;
        }
        myChart.update();
    }

    btnIncome.addEventListener('click', function() {
        btnIncome.classList.add('active');
        btnIncome.style.background = 'var(--color-primary)';
        btnIncome.style.color = 'white';
        btnIncome.style.boxShadow = '0 4px 12px rgba(59, 130, 246, 0.3)';
        
        btnExpense.classList.remove('active');
        btnExpense.style.background = 'transparent';
        btnExpense.style.color = 'var(--text-muted)';
        btnExpense.style.boxShadow = 'none';
        
        divIncome.style.display = 'block';
        divExpense.style.display = 'none';
        updateChart(incLabels, incData, incColors);
    });

    btnExpense.addEventListener('click', function() {
        btnExpense.classList.add('active');
        btnExpense.style.background = 'var(--color-primary)';
        btnExpense.style.color = 'white';
        btnExpense.style.boxShadow = '0 4px 12px rgba(59, 130, 246, 0.3)';
        
        btnIncome.classList.remove('active');
        btnIncome.style.background = 'transparent';
        btnIncome.style.color = 'var(--text-muted)';
        btnIncome.style.boxShadow = 'none';
        
        divExpense.style.display = 'block';
        divIncome.style.display = 'none';
        updateChart(expLabels, expData, expColors);
    });

    // Toggle Balance Visibility
    const toggleBalanceBtn = document.getElementById('toggleBalance');
    const amountElements = document.querySelectorAll('.card-info-amount');
    const iconEyeOpen = document.getElementById('icon-eye-open');
    const iconEyeClosed = document.getElementById('icon-eye-closed');
    const toggleText = document.getElementById('toggleText');
    
    let isBalanceHidden = localStorage.getItem('isBalanceHidden') === 'true';

    function updateBalanceVisibility() {
        if (isBalanceHidden) {
            amountElements.forEach(el => el.innerText = 'Rp ••••••••');
            iconEyeOpen.style.display = 'none';
            iconEyeClosed.style.display = 'block';
            if (toggleText) toggleText.innerText = 'Tampilkan Saldo';
        } else {
            amountElements.forEach(el => el.innerText = el.getAttribute('data-original'));
            iconEyeOpen.style.display = 'block';
            iconEyeClosed.style.display = 'none';
            if (toggleText) toggleText.innerText = 'Sembunyikan Saldo';
        }
    }

    if (amountElements.length > 0) {
        updateBalanceVisibility();
    }

    if (toggleBalanceBtn) {
        toggleBalanceBtn.addEventListener('click', () => {
            isBalanceHidden = !isBalanceHidden;
            localStorage.setItem('isBalanceHidden', isBalanceHidden);
            updateBalanceVisibility();
        });
    }

    // Initialize Bar Chart for Trends
    const trendLabels = {!! json_encode($trendLabels ?? []) !!};
    if (trendLabels.length > 0) {
        const trendIncome = {!! json_encode($trendIncome ?? []) !!};
        const trendExpense = {!! json_encode($trendExpense ?? []) !!};
        
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: trendIncome,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 5
                    },
                    {
                        label: 'Pengeluaran',
                        data: trendExpense,
                        borderColor: '#fb7185',
                        backgroundColor: 'rgba(244, 63, 94, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 2,
                        pointHoverRadius: 5
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
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.6)',
                            font: { size: 11 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: 5000,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.6)',
                            font: { size: 11 },
                            precision: 0,
                            callback: function(value) {
                                if (value === 0) return '0';
                                if (value >= 1000000 && value % 1000000 === 0) return (value / 1000000) + ' jt';
                                if (value >= 1000000) return (value / 1000000).toFixed(1).replace('.0', '').replace('.', ',') + ' jt';
                                if (value >= 1000 && value % 1000 === 0) return (value / 1000) + ' rb';
                                if (value >= 1000) return (value / 1000).toFixed(1).replace('.0', '').replace('.', ',') + ' rb';
                                return value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'rgba(255, 255, 255, 0.8)',
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#ccc',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
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
                }
            }
        });
    }
});

// New script for Report Filter UI logic
document.addEventListener('DOMContentLoaded', function() {
    const segments = document.querySelectorAll('.btn-segment');
    const inputCard = document.getElementById('filter-input-card');
    const inputTitle = document.getElementById('filter-input-title');
    const inputBulanan = document.getElementById('input-bulanan');
    const inputKalender = document.getElementById('input-kalender');
    const monthPicker = document.getElementById('month_picker');
    const btnApplyKalender = document.getElementById('btn-apply-kalender');
    const form = document.getElementById('report-filter-form');
    
    const hiddenYear = document.getElementById('hidden_year');
    const hiddenMonth = document.getElementById('hidden_month');
    const hiddenStart = document.getElementById('hidden_start');
    const hiddenEnd = document.getElementById('hidden_end');
    
    function updateUI(mode) {
        segments.forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.querySelector(`.btn-segment[data-mode="${mode}"]`);
        if(activeBtn) activeBtn.classList.add('active');
        
        if (mode === 'hari_ini' || mode === 'semua') {
            inputCard.style.display = 'none';
        } else if (mode === 'bulanan') {
            inputCard.style.display = 'flex';
            inputTitle.textContent = 'PILIH BULAN & TAHUN';
            inputBulanan.style.display = 'block';
            inputKalender.style.display = 'none';
        } else if (mode === 'kalender') {
            inputCard.style.display = 'flex';
            inputTitle.textContent = 'PILIH RENTANG TANGGAL';
            inputBulanan.style.display = 'none';
            inputKalender.style.display = 'block';
        }
    }

    segments.forEach(btn => {
        btn.addEventListener('click', function() {
            const mode = this.dataset.mode;
            updateUI(mode);
            
            if (mode === 'hari_ini') {
                const d = new Date();
                const todayStr = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
                hiddenStart.value = todayStr;
                hiddenEnd.value = todayStr;
                hiddenYear.value = '';
                hiddenMonth.value = '';
                form.submit();
            } else if (mode === 'semua') {
                hiddenStart.value = '';
                hiddenEnd.value = '';
                hiddenYear.value = '';
                hiddenMonth.value = '';
                form.submit();
            }
        });
    });
    
    if (monthPicker) {
        monthPicker.addEventListener('change', function() {
            if (this.value) {
                const parts = this.value.split('-');
                hiddenYear.value = parts[0];
                hiddenMonth.value = parts[1];
                hiddenStart.value = '';
                hiddenEnd.value = '';
                form.submit();
            }
        });
    }
    
    if (btnApplyKalender) {
        btnApplyKalender.addEventListener('click', function() {
            const start = document.getElementById('start_date_picker').value;
            const end = document.getElementById('end_date_picker').value;
            hiddenStart.value = start;
            hiddenEnd.value = end;
            hiddenYear.value = '';
            hiddenMonth.value = '';
            form.submit();
        });
    }
    
    // Initialize mode based on URL parameters
    const currentYear = '{{ request("year") }}';
    const currentMonth = '{{ request("month") }}';
    const currentStart = '{{ request("start_date") }}';
    const currentEnd = '{{ request("end_date") }}';
    
    const d = new Date();
    const todayStr = d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
    
    if (currentStart === todayStr && currentEnd === todayStr) {
        updateUI('hari_ini');
    } else if (currentStart || currentEnd) {
        updateUI('kalender');
    } else if (currentYear && currentMonth) {
        updateUI('bulanan');
        if (monthPicker) monthPicker.value = currentYear + '-' + currentMonth.padStart(2, '0');
    } else if (currentYear) {
        updateUI('semua'); // fallback if only year is set
    } else {
        updateUI('semua');
    }
});
</script>
@endsection
