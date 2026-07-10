@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 style="margin: 0; font-size: 1.5rem; font-weight: 700;">Target Harian</h3>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Target Harian -->
    <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); padding: 2rem; border-radius: var(--radius-xl); margin-bottom: 2rem; backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 19-5 3-5-3"/><path d="m17 5-5-3-5 3"/></svg>
            <h4 style="margin: 0; color: #60a5fa; font-size: 1.25rem;">Atur Batas Pengeluaran Harian</h4>
        </div>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.95rem;">Tentukan batas maksimal uang yang boleh Anda keluarkan dalam sehari. Kami akan melacak kedisiplinan Anda pada riwayat di bawah.</p>
        
        <form action="{{ route('budget.update') }}" method="POST" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            @csrf
            <div style="flex: 1; min-width: 250px;">
                <label for="daily_budget" style="color: #60a5fa;">Target Maksimal (Rp)</label>
                <input type="number" id="daily_budget" name="daily_budget" value="{{ $dailyBudget ? (int) $dailyBudget : '' }}" placeholder="Contoh: 50000" style="width: 100%; border-color: rgba(59, 130, 246, 0.3); font-size: 1.1rem; font-weight: 600;" min="0">
            </div>
            <button type="submit" class="btn" style="background: #3b82f6; color: #fff; width: auto; padding: 0.85rem 2rem;">Simpan Target</button>
        </form>
    </div>

    <!-- Riwayat Harian -->
    <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat Harian
    </h3>

    @if(empty($dailyHistory))
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            <p>Belum ada riwayat pengeluaran yang dicatat.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($dailyHistory as $history)
                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-lg); padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; backdrop-filter: blur(12px);">
                    
                    <div>
                        <div style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.25rem;">
                            {{ \Carbon\Carbon::parse($history['date'])->translatedFormat('l, d F Y') }}
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.9rem;">
                            Pengeluaran: <span style="color: white; font-weight: 500;">Rp {{ number_format($history['total_expense'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div>
                        @if($history['status'] === 'Boros')
                            <span style="background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.3); padding: 0.4rem 1rem; border-radius: 99px; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                                Boros
                            </span>
                        @elseif($history['status'] === 'Hemat')
                            <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.4rem 1rem; border-radius: 99px; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                Hemat
                            </span>
                        @else
                            <span style="background: rgba(255, 255, 255, 0.1); color: var(--text-muted); border: 1px solid rgba(255, 255, 255, 0.2); padding: 0.4rem 1rem; border-radius: 99px; font-weight: 600; font-size: 0.85rem;">
                                Belum Ditetapkan
                            </span>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
