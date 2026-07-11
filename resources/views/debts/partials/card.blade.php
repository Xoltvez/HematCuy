<div class="debt-card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                <h3 style="margin: 0; font-size: 1.2rem; color: #fff;">{{ $debt->person_name }}</h3>
                @if($debt->status === 'unpaid')
                    <span class="status-badge status-unpaid">Belum Lunas</span>
                @elseif($debt->status === 'partially_paid')
                    <span class="status-badge status-partially">Dicicil</span>
                @else
                    <span class="status-badge status-paid">Lunas</span>
                @endif
            </div>
            
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0 0 1rem 0;">
                @if($debt->due_date)
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 0.25rem;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    Jatuh Tempo: {{ \Carbon\Carbon::parse($debt->due_date)->format('d M Y') }}
                    @if($debt->status !== 'paid' && \Carbon\Carbon::parse($debt->due_date)->isPast())
                        <span style="color: #ef4444; font-weight: 600; margin-left: 0.5rem;">(Terlewat)</span>
                    @endif
                @else
                    Tanpa Tenggat Waktu
                @endif
            </p>
        </div>
        
        <div style="text-align: right;">
            <div style="font-size: 1.25rem; font-weight: 700; color: {{ $debt->type === 'payable' ? '#ef4444' : '#10b981' }};">
                Rp {{ number_format($debt->amount, 0, ',', '.') }}
            </div>
            <div style="font-size: 0.9rem; color: var(--text-muted);">
                Telah dibayar: Rp {{ number_format($debt->amount_paid, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    @php
        $progress = $debt->amount > 0 ? ($debt->amount_paid / $debt->amount) * 100 : 0;
        $progressClass = $debt->type === 'payable' ? 'progress-bar-payable' : 'progress-bar-receivable';
    @endphp
    <div class="progress-bg">
        <div class="{{ $progressClass }}" style="width: {{ $progress }}%;"></div>
    </div>
    <div style="display: flex; justify-content: space-between; margin-top: 0.5rem; font-size: 0.8rem; color: var(--text-muted);">
        <span>{{ round($progress) }}% Lunas</span>
        <span>Sisa: Rp {{ number_format($debt->amount - $debt->amount_paid, 0, ',', '.') }}</span>
    </div>

    <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem; justify-content: flex-end;">
        @if($debt->status !== 'paid')
            <button class="btn btn-primary" onclick="openPayModal({{ $debt->id }}, {{ $debt->amount - $debt->amount_paid }})" style="padding: 0.5rem 1rem; font-size: 0.9rem; border-radius: var(--radius-md);">
                {{ $debt->type === 'payable' ? 'Bayar Cicilan/Lunas' : 'Terima Uang/Lunas' }}
            </button>
        @endif
        
        <button type="button" class="btn" onclick="openDeleteModal('{{ route('debts.destroy', $debt->id) }}')" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.5rem 1rem; font-size: 0.9rem; border-radius: var(--radius-md); border: 1px solid rgba(239, 68, 68, 0.2);">Hapus</button>
    </div>
</div>
