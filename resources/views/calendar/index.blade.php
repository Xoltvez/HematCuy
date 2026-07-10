@extends('layouts.app')

@section('content')
<style>
    .calendar-container {
        max-width: 100%;
        margin: 0 auto;
    }

    .calendar-header-card {
        background: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .calendar-title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .calendar-icon-wrapper {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .calendar-controls {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .calendar-btn {
        background: var(--bg-color);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .calendar-btn:hover {
        background: var(--border-color);
    }

    .calendar-select {
        background: var(--bg-color);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        height: 40px;
        padding: 0 1rem;
        border-radius: var(--radius-md);
        outline: none;
        cursor: pointer;
        font-family: inherit;
    }

    .calendar-main-card {
        background: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 12px;
    }

    .calendar-day-name {
        text-align: center;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-main);
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }

    .calendar-cell {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: var(--radius-md);
        min-height: 110px;
        padding: 0.75rem;
        position: relative;
        display: flex;
        flex-direction: column;
        transition: all 0.2s;
    }

    .calendar-cell:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .calendar-cell.inactive {
        opacity: 0.3;
        background: transparent;
    }

    .calendar-cell.today {
        border: 2px solid #3b82f6;
        background: rgba(59, 130, 246, 0.15);
    }

    .calendar-date-number {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-main);
    }

    .calendar-cell.today .calendar-date-number {
        background: #3b82f6;
        color: #fff;
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.85rem;
    }

    .calendar-indicators {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: flex;
        gap: 4px;
    }

    .indicator-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .dot-income {
        background-color: #10b981;
        box-shadow: 0 0 4px rgba(16, 185, 129, 0.5);
    }

    .dot-expense {
        background-color: #ef4444;
        box-shadow: 0 0 4px rgba(239, 68, 68, 0.5);
    }

    .calendar-net {
        margin-top: auto;
        text-align: right;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .net-positive {
        color: #10b981;
    }

    .net-negative {
        color: #ef4444;
    }

    .calendar-legend {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem 2rem;
        margin-top: 2rem;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .legend-circle {
        width: 12px;
        height: 12px;
        border: 2px solid #3b82f6;
        border-radius: 50%;
    }

    /* Modal Styles */
    .cal-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 10, 10, 0.95);
        backdrop-filter: blur(12px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }

    .cal-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .cal-modal-content {
        background: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        width: 90%;
        max-width: 500px;
        padding: 1.5rem;
        transform: translateY(20px);
        transition: all 0.3s;
        max-height: 80vh;
        overflow-y: auto;
    }

    .cal-modal-overlay.active .cal-modal-content {
        transform: translateY(0);
    }

    .cal-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.5rem;
    }

    .cal-modal-close {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
    }

    .cal-modal-close:hover {
        color: var(--text-main);
    }

    .cal-tx-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .cal-tx-item:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .calendar-grid {
            gap: 2px;
        }

        .calendar-cell {
            padding: 0.25rem;
            min-height: 80px;
        }

        .calendar-date-number {
            font-size: 0.8rem;
        }

        .calendar-net {
            font-size: 0.6rem;
            letter-spacing: -0.5px;
        }

        .indicator-dot {
            width: 4px;
            height: 4px;
        }

        .calendar-indicators {
            top: 0.25rem;
            right: 0.25rem;
        }

        .calendar-header-card {
            flex-direction: column;
            align-items: stretch;
        }

        .calendar-controls {
            justify-content: space-between;
        }
    }
</style>

<div class="calendar-container animate-fade-in-up">
    <!-- Header Card -->
    <div class="calendar-header-card">
        <div class="calendar-title-group">
            <div class="calendar-icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div>
                <h2 style="margin: 0; font-size: 1.25rem; color: #fff;">Visualisasi Kalender Transaksi</h2>
                <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Lihat ringkasan arus kas masuk dan keluar Anda dalam kalender bulanan.</p>
            </div>
        </div>

        <div class="calendar-controls">
            <a href="{{ route('calendar', ['month' => $prevMonth->format('m'), 'year' => $prevMonth->format('Y')]) }}" class="calendar-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>

            <form action="{{ route('calendar') }}" method="GET" id="monthYearForm" style="display: flex; gap: 0.5rem;">
                <select name="month" class="calendar-select" onchange="document.getElementById('monthYearForm').submit()">
                    @foreach(['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $m => $mName)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $mName }}</option>
                    @endforeach
                </select>

                <select name="year" class="calendar-select" onchange="document.getElementById('monthYearForm').submit()">
                    @for($y = date('Y') - 5; $y <= date('Y') + 5; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                </select>
            </form>

            <a href="{{ route('calendar', ['month' => $nextMonth->format('m'), 'year' => $nextMonth->format('Y')]) }}" class="calendar-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Main Calendar Card -->
    <div class="calendar-main-card">
        <div class="calendar-grid">
            <div class="calendar-day-name">SEN</div>
            <div class="calendar-day-name">SEL</div>
            <div class="calendar-day-name">RAB</div>
            <div class="calendar-day-name">KAM</div>
            <div class="calendar-day-name">JUM</div>
            <div class="calendar-day-name">SAB</div>
            <div class="calendar-day-name">MIN</div>

            @php
            $todayDate = date('Y-m-d');
            @endphp

            @foreach($calendar as $dayData)
            @php
            $isToday = $dayData['date'] === $todayDate;
            $class = 'calendar-cell';
            if (!$dayData['is_current_month']) $class .= ' inactive';
            if ($isToday) $class .= ' today';
            @endphp

            @php
            $hasData = count($dayData['transactions'] ?? []) > 0 || count($dayData['notes'] ?? []) > 0;
            if ($hasData) $class .= ' has-data';
            @endphp

            <div class="{{ $class }}"
                @if($hasData)
                style="cursor: pointer;"
                onclick="showTransactions('{{ \Carbon\Carbon::parse($dayData['date'])->translatedFormat('d F Y') }}', {{ json_encode($dayData['transactions']) }}, {{ json_encode($dayData['notes'] ?? []) }})"
                @endif>
                <div class="calendar-date-number">{{ $dayData['day'] }}</div>

                <div class="calendar-indicators">
                    @if($dayData['income'] > 0)
                    <div class="indicator-dot dot-income"></div>
                    @endif
                    @if($dayData['expense'] > 0)
                    <div class="indicator-dot dot-expense"></div>
                    @endif
                    @if(count($dayData['notes'] ?? []) > 0)
                    <div class="indicator-dot" style="background-color: #f59e0b;"></div>
                    @endif
                </div>

                <div style="margin-top: auto; display: flex; flex-direction: column; gap: 2px;">
                    @if($dayData['income'] > 0)
                    @php
                    $inc = $dayData['income'];
                    if ($inc >= 1000000) {
                    $val = $inc / 1000000;
                    $fmtInc = (floor($val) == $val ? $val : number_format($val, 1, ',', '')) . ' jt';
                    } else {
                    $val = $inc / 1000;
                    $fmtInc = (floor($val) == $val ? $val : number_format($val, 1, ',', '')) . ' rb';
                    }
                    @endphp
                    <div class="calendar-net net-positive">+{{ $fmtInc }}</div>
                    @endif
                    @if($dayData['expense'] > 0)
                    @php
                    $exp = $dayData['expense'];
                    if ($exp >= 1000000) {
                    $val = $exp / 1000000;
                    $fmtExp = (floor($val) == $val ? $val : number_format($val, 1, ',', '')) . ' jt';
                    } else {
                    $val = $exp / 1000;
                    $fmtExp = (floor($val) == $val ? $val : number_format($val, 1, ',', '')) . ' rb';
                    }
                    @endphp
                    <div class="calendar-net net-negative">-{{ $fmtExp }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Legend -->
    <div class="calendar-legend">
        <div class="legend-item">
            <div class="legend-dot dot-income"></div>
            <span>Ada Pemasukan</span>
        </div>
        <div class="legend-item">
            <div class="legend-dot dot-expense"></div>
            <span>Ada Pengeluaran</span>
        </div>
        <div class="legend-item">
            <div class="legend-dot" style="background-color: #f59e0b;"></div>
            <span>Ada Tagihan</span>
        </div>
        <div class="legend-item">
            <div class="legend-circle"></div>
            <span>Hari Ini</span>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="cal-modal-overlay" id="calTxModal" onclick="closeCalModal(event)">
    <div class="cal-modal-content" onclick="event.stopPropagation()">
        <div class="cal-modal-header">
            <h3 style="margin: 0;" id="calModalTitle">Transaksi</h3>
            <button class="cal-modal-close" onclick="document.getElementById('calTxModal').classList.remove('active')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div id="calModalBody">
            <!-- Transactions will be loaded here via JS -->
        </div>
    </div>
</div>

<script>
    function showTransactions(dateFormatted, transactions, notes = []) {
        document.getElementById('calModalTitle').innerText = 'Aktivitas: ' + dateFormatted;

        let html = '';

        if (notes.length > 0) {
            html += '<h4 style="margin: 0 0 0.5rem 0; font-size: 0.95rem; color: #f59e0b;">Catatan / Tagihan</h4>';
            notes.forEach(note => {
                const amountFormatted = note.amount > 0 ? ('Rp ' + parseInt(note.amount).toLocaleString('id-ID')) : '';
                const status = note.is_paid ?
                    '<span style="color: #10b981; font-size: 0.75rem; border: 1px solid rgba(16, 185, 129, 0.2); background: rgba(16, 185, 129, 0.1); padding: 0.15rem 0.6rem; border-radius: 99px; font-weight: 600;">✅ Lunas</span>' :
                    '<span style="color: #ef4444; font-size: 0.75rem; border: 1px solid rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.1); padding: 0.15rem 0.6rem; border-radius: 99px; font-weight: 600;">Belum Lunas</span>';
                const actionBtn = (!note.is_paid && note.amount > 0) ?
                    `<a href="/notes" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 0.3rem 0.75rem; border-radius: var(--radius-md); font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-block;">Bayar di Catatan &rarr;</a>` :
                    '';

                html += `
                <div class="cal-tx-item" style="border-left: 3px solid #f59e0b; padding: 1rem; background: rgba(245, 158, 11, 0.05); border-radius: 0 var(--radius-md) var(--radius-md) 0; margin-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-start;">
                        <div style="font-weight: 600; font-size: 1rem;">${note.title}</div>
                        <div>${status}</div>
                    </div>
                    <div style="text-align: right; display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;">
                        <div style="font-weight: 700; color: #fff; font-size: 1rem;">
                            ${amountFormatted}
                        </div>
                        ${actionBtn}
                    </div>
                </div>
            `;
            });
            html += '<div style="margin-bottom: 1.5rem;"></div>';
        }

        if (transactions.length > 0) {
            html += '<h4 style="margin: 0 0 0.5rem 0; font-size: 0.95rem; color: var(--text-muted);">Transaksi</h4>';
            transactions.forEach(tx => {
                const isIncome = tx.type === 'income';
                const color = isIncome ? '#10b981' : '#ef4444';
                const sign = isIncome ? '+' : '-';
                const amountFormatted = 'Rp ' + parseInt(tx.amount).toLocaleString('id-ID');

                html += `
                <div class="cal-tx-item">
                    <div>
                        <div style="font-weight: 600;">${tx.title || (isIncome ? 'Pemasukan' : 'Pengeluaran')}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">${tx.category}</div>
                    </div>
                    <div style="font-weight: 700; color: ${color};">
                        ${sign}${amountFormatted}
                    </div>
                </div>
            `;
            });
        }

        if (transactions.length === 0 && notes.length === 0) {
            html = '<p style="color: var(--text-muted); text-align: center; padding: 1rem 0;">Tidak ada aktivitas.</p>';
        }

        document.getElementById('calModalBody').innerHTML = html;
        document.getElementById('calTxModal').classList.add('active');
    }

    function closeCalModal(e) {
        if (e.target.id === 'calTxModal') {
            document.getElementById('calTxModal').classList.remove('active');
        }
    }
</script>
@endsection