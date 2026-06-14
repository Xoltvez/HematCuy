@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2>Laporan Keuangan</h2>
        <p style="margin-bottom: 0;">Analisis pengeluaran dan pemasukan Anda.</p>
    </div>
    <button type="button" id="toggleBalance" class="btn" style="background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
        <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
        <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
        <span id="toggleText">Sembunyikan Saldo</span>
    </button>
</div>

<!-- Date Filter Form -->
<form action="{{ route('report') }}" method="GET" style="margin-bottom: 2rem; display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
        <label for="start_date" style="font-size: 0.875rem; color: var(--text-muted);">Dari Tanggal</label>
        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" style="padding: 0.5rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-main);">
    </div>
    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
        <label for="end_date" style="font-size: 0.875rem; color: var(--text-muted);">Sampai Tanggal</label>
        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" style="padding: 0.5rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-main);">
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.5rem;">Filter</button>
        @if(request('start_date') || request('end_date'))
            <a href="{{ route('report') }}" class="btn" style="padding: 0.5rem 1.5rem; background: rgba(255,255,255,0.1); color: var(--text-main); text-decoration: none; display: inline-block; text-align: center;">Reset</a>
        @endif
    </div>
</form>

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

<div class="dashboard-grid" style="grid-template-columns: 1fr;">
    <div class="transaction-history-section" style="background: var(--bg-card); padding: 2rem;">
        <div style="display: flex; justify-content: center; margin-bottom: 2rem;">
            <div class="filter-tabs" style="display: flex; gap: 0.5rem; background: rgba(0,0,0,0.2); padding: 0.25rem; border-radius: 2rem; width: 100%;">
                <button type="button" class="btn-filter" id="btn-toggle-income" style="flex: 1; border-radius: 2rem;">Pemasukan</button>
                <button type="button" class="btn-filter active" id="btn-toggle-expense" style="flex: 1; border-radius: 2rem; background: #bef264; color: #1e293b;">Pengeluaran</button>
            </div>
        </div>
        
        <h3 style="margin-bottom: 1.5rem;">Rincian kategori</h3>
        
        <div class="report-content-layout">
            <!-- Chart Container -->
            <div style="width: 100%; max-width: 350px; margin: 0 auto; position: relative; aspect-ratio: 1;">
                <canvas id="categoryChart"></canvas>
            </div>

            <div class="report-list">

        @php
            $palette = ['#f97316', '#3b82f6', '#10b981', '#a855f7', '#ef4444', '#eab308', '#ec4899', '#06b6d4', '#64748b'];
            $expData = [];
            $incData = [];
            $expColors = [];
            $incColors = [];
            $expLabels = [];
            $incLabels = [];
        @endphp

        <!-- Expense Categories -->
        <div id="expense-categories">
            @if($expensesByCategory->isEmpty())
                <div class="empty-state">
                    <p>Belum ada pengeluaran pada periode ini.</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column;">
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
                        <div class="responsive-flex-between" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background-color: {{ $color }}20; color: {{ $color }}; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 7h10"/><path d="M7 11h10"/><path d="M7 15h4"/></svg>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 500;">{{ $catName }}</span>
                                    <span style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">Dari {{ $data['count'] }} transaksi</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                    <span style="font-weight: 600; font-size: 1rem;">Rp {{ number_format($data['amount'], 0, ',', '.') }}</span>
                                </div>
                                <span style="font-weight: 600; font-size: 0.9rem; min-width: 45px; text-align: right;">{{ number_format($percentage, 1, ',', '') }}%</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);"><path d="m9 18 6-6-6-6"/></svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Income Categories -->
        <div id="income-categories" style="display: none;">
            @if($incomesByCategory->isEmpty())
                <div class="empty-state">
                    <p>Belum ada pemasukan pada periode ini.</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column;">
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
                        <div class="responsive-flex-between" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background-color: {{ $color }}20; color: {{ $color }}; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 500;">{{ $catName }}</span>
                                    <span style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.2rem;">Dari {{ $data['count'] }} transaksi</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                    <span style="font-weight: 600; font-size: 1rem;">Rp {{ number_format($data['amount'], 0, ',', '.') }}</span>
                                </div>
                                <span style="font-weight: 600; font-size: 0.9rem; min-width: 45px; text-align: right;">{{ number_format($percentage, 1, ',', '') }}%</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);"><path d="m9 18 6-6-6-6"/></svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        </div> <!-- End of report-list -->
        </div> <!-- End of report-content-layout -->

    </div>
</div>

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

    const ctx = document.getElementById('categoryChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: expLabels,
            datasets: [{
                data: expData,
                backgroundColor: expColors,
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
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
        myChart.data.labels = labels;
        myChart.data.datasets[0].data = data;
        myChart.data.datasets[0].backgroundColor = colors;
        myChart.update();
    }

    btnIncome.addEventListener('click', function() {
        btnIncome.classList.add('active');
        btnIncome.style.background = '#bef264';
        btnIncome.style.color = '#1e293b';
        
        btnExpense.classList.remove('active');
        btnExpense.style.background = 'transparent';
        btnExpense.style.color = 'var(--text-main)';
        
        divIncome.style.display = 'block';
        divExpense.style.display = 'none';
        updateChart(incLabels, incData, incColors);
    });

    btnExpense.addEventListener('click', function() {
        btnExpense.classList.add('active');
        btnExpense.style.background = '#bef264';
        btnExpense.style.color = '#1e293b';
        
        btnIncome.classList.remove('active');
        btnIncome.style.background = 'transparent';
        btnIncome.style.color = 'var(--text-main)';
        
        divExpense.style.display = 'block';
        divIncome.style.display = 'none';
        updateChart(expLabels, expData, expColors);
    });

    // Toggle Balance Visibility
    const toggleBalanceBtn = document.getElementById('toggleBalance');
    const amountElements = document.querySelectorAll('.summary-cards .amount');
    const listAmountElements = document.querySelectorAll('.cat-amount');
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
            if (toggleText) toggleText.innerText = 'Tampilkan Saldo';
        } else {
            amountElements.forEach(el => el.innerText = el.getAttribute('data-original'));
            iconEyeOpen.style.display = 'block';
            iconEyeClosed.style.display = 'none';
            if (toggleText) toggleText.innerText = 'Sembunyikan Saldo';
        }
    }

    // Initial load
    updateBalanceVisibility();

    if(toggleBalanceBtn) {
        toggleBalanceBtn.addEventListener('click', () => {
            isBalanceHidden = !isBalanceHidden;
            localStorage.setItem('isBalanceHidden', isBalanceHidden);
            updateBalanceVisibility();
        });
    }
});
</script>
@endsection
