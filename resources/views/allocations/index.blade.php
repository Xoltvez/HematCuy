@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Budgeting</h2>
            <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.95rem; margin-bottom: 0;">Kelola pos-pos pengeluaran bulan {{ \Carbon\Carbon::parse($currentMonth)->translatedFormat('F Y') }}</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: start;">
        
        <!-- Left Column: Forms -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 100px;">
            
            <!-- Form Input Gaji -->
            <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; border-radius: var(--radius-xl); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); transform: translateZ(0);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    <h4 style="margin: 0; color: #60a5fa; font-size: 1.1rem;">Total Gaji Bulan Ini</h4>
                </div>
                
                <form action="{{ route('allocations.salary') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                    @csrf
                    <div>
                        <input type="text" id="salary_display" placeholder="Misal: 5.000.000" value="{{ $monthlySalary > 0 ? number_format($monthlySalary, 0, '', '.') : '' }}" required style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%;" inputmode="numeric">
                        <input type="hidden" id="salary" name="salary" value="{{ $monthlySalary > 0 ? $monthlySalary : '' }}" required min="0">
                        <small style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.25rem; display: block;">Masukkan total uang/gaji yang ingin dialokasikan bulan ini.</small>
                    </div>
                    <button type="submit" class="btn" style="background: #3b82f6; color: #fff; border-radius: var(--radius-md);">Simpan Gaji</button>
                </form>
            </div>

            <!-- Form Tambah Alokasi -->
            <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); padding: 1.5rem; border-radius: var(--radius-xl); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); transform: translateZ(0);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 5-5-3-5 3"/><path d="m17 19-5 3-5-3"/></svg>
                    <h4 style="margin: 0; color: #10b981; font-size: 1.1rem;">Buat Pos Pengeluaran</h4>
                </div>
            
            <form action="{{ route('allocations.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                <div>
                    <label for="category_name" style="color: var(--text-muted); font-size: 0.85rem;">Kategori Pengeluaran</label>
                    <input type="text" id="category_name" name="category_name" placeholder="Misal: Makanan, Transportasi, Kos..." required style="border-color: rgba(16, 185, 129, 0.3); background: rgba(0,0,0,0.2);">
                </div>
                <div>
                    <label for="amount_display" style="color: var(--text-muted); font-size: 0.85rem;">Target Anggaran (Rp)</label>
                    <input type="text" id="amount_display" placeholder="Misal: 1.000.000" required style="border-color: rgba(16, 185, 129, 0.3); background: rgba(0,0,0,0.2);" inputmode="numeric">
                    <input type="hidden" id="amount" name="amount" required min="0">
                </div>
                <button type="submit" class="btn" style="background: #10b981; color: #fff; margin-top: 0.5rem; border-radius: var(--radius-md);">Simpan Alokasi</button>
            </form>
        </div>
        </div>

        <!-- Daftar Alokasi & Progress -->
        <div>
            @if(count($allocationsData) === 0)
                <div class="empty-state" style="background: var(--bg-card); border-radius: var(--radius-xl); border: 1px solid var(--border-color); padding: 3rem 1.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <p style="margin-bottom: 0;">Belum ada pos uang yang dibuat bulan ini.<br>Mulai tentukan anggaran Anda di samping kiri!</p>
                </div>
            @else
                <!-- Total Rekap -->
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; backdrop-filter: blur(12px);">
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.25rem;">Total Uang Dialokasikan</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #60a5fa;">Rp {{ number_format($totalAllocated, 0, ',', '.') }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.25rem;">Total Uang Terpakai</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #f43f5e;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($allocationsData as $item)
                        @php
                            $barColor = '#10b981'; // green
                            if ($item['status'] === 'warning') $barColor = '#eab308'; // yellow
                            if ($item['status'] === 'danger') $barColor = '#ef4444'; // red
                        @endphp
                        
                        @php
                            $isTabungan = isset($item['is_tabungan']) && $item['is_tabungan'] === true;
                            $cardBg = $isTabungan ? 'rgba(59, 130, 246, 0.05)' : 'rgba(255,255,255,0.02)';
                            $cardBorder = $isTabungan ? '1px solid rgba(59, 130, 246, 0.3)' : '1px solid rgba(255,255,255,0.05)';
                            
                            $isDanger = ($item['status'] === 'danger' && !$isTabungan);
                            $pulseClass = $isDanger ? 'budget-pulse-danger' : '';
                        @endphp

                        <div class="premium-glow-card {{ $pulseClass }}" style="background: {{ $cardBg }}; border: {{ $cardBorder }}; border-radius: var(--radius-lg); padding: 1.25rem; position: relative; transition: all 0.3s ease;">
                            
                            @if(!$isTabungan)
                            <!-- Delete Button -->
                            <form action="{{ route('allocations.destroy', $item['id']) }}" method="POST" style="position: absolute; top: 1rem; right: 1rem;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="confirmDelete(event, this.closest('form'), 'Hapus pos alokasi ini?');" style="color: var(--text-muted);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                            @endif

                            <div style="margin-bottom: 1rem;">
                                <h4 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; font-weight: 600; padding-right: 3rem; {{ $isTabungan ? 'color: #60a5fa;' : '' }}">
                                    @if($isTabungan) 💰 @endif
                                    {{ $item['category_name'] }}
                                </h4>
                                
                                @if($isTabungan)
                                    <div style="font-size: 1.75rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem;">
                                        Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                    </div>
                                @else
                                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                                        <span style="color: var(--text-muted);">Terpakai: <span style="color: #fff;">Rp {{ number_format($item['spent'], 0, ',', '.') }}</span></span>
                                        <span style="color: var(--text-muted);">Dari <span style="color: #fff;">Rp {{ number_format($item['amount'], 0, ',', '.') }}</span></span>
                                    </div>
                                @endif
                            </div>
                            
                            @if(!$isTabungan)
                            <!-- Progress Bar Container -->
                            <div style="width: 100%; height: 8px; background: rgba(0,0,0,0.3); border-radius: 99px; overflow: hidden; margin-bottom: 0.5rem;">
                                <div class="budget-progress" data-percent="{{ $item['percentage'] }}" style="height: 100%; width: 0%; background: {{ $barColor }}; border-radius: 99px; transition: width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);"></div>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                                <span style="color: {{ $barColor }}; font-weight: 600;">{{ $item['percentage'] }}%</span>
                                <span style="color: var(--text-muted);">
                                    @if($item['remaining'] > 0)
                                        Sisa: <span style="color: #fff;">Rp {{ number_format($item['remaining'], 0, ',', '.') }}</span>
                                    @else
                                        <span style="color: #ef4444;">Overbudget: Rp {{ number_format(abs($item['remaining']), 0, ',', '.') }}</span>
                                    @endif
                                </span>
                            </div>
                            @endif
                            
                            <!-- AI Insight Box -->
                            <div style="margin-top: 1rem; padding: 0.75rem; border-radius: var(--radius-sm); background: rgba(255,255,255,0.02); border-left: 3px solid {{ $barColor }}; font-size: 0.85rem; color: var(--text-muted); display: flex; gap: 0.5rem; align-items: flex-start;">
                                <span style="font-weight: 600; min-width: max-content;">Informasi:</span>
                                <span style="line-height: 1.4;">{!! $item['insight'] !!}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 2fr;"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupFormatting(displayId, hiddenId) {
        const displayInput = document.getElementById(displayId);
        const hiddenInput = document.getElementById(hiddenId);

        if (displayInput && hiddenInput) {
            displayInput.addEventListener('input', function(e) {
                // Remove non-digit characters
                let value = this.value.replace(/[^0-9]/g, '');
                
                // Update hidden input
                hiddenInput.value = value;
                
                // Format display value with thousands separator
                if(value) {
                    this.value = parseInt(value, 10).toLocaleString('id-ID');
                } else {
                    this.value = '';
                }
            });
        }
    }

    setupFormatting('salary_display', 'salary');
    setupFormatting('amount_display', 'amount');
    
    // Animate budgeting progress bars
    setTimeout(() => {
        document.querySelectorAll('.budget-progress').forEach(bar => {
            const percent = bar.getAttribute('data-percent');
            bar.style.width = percent + '%';
        });
    }, 200);
});
</script>
@endsection
