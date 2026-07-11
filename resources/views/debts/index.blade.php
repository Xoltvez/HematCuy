@extends('layouts.app')

@section('content')
<style>
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-content {
        background: #111111;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-xl);
        width: 100%;
        max-width: 500px;
        padding: 2rem;
        transform: translateY(20px) scale(0.95);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        max-height: 90vh;
        overflow-y: auto;
    }
    .modal-overlay.active .modal-content {
        transform: translateY(0) scale(1);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #fff;
    }
    .close-modal {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        transition: color 0.2s;
    }
    .close-modal:hover {
        color: #ef4444;
    }

    .debt-card {
        background: var(--bg-card);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    .stat-card {
        padding: 1.5rem;
        border-radius: var(--radius-xl);
        display: flex;
        flex-direction: column;
        gap: 1rem;
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-content h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
    }
    .stat-content .amount {
        font-size: 1.75rem;
        font-weight: 700;
        margin-top: 0.25rem;
        margin-bottom: 0.25rem;
    }
    .stat-content p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
    }
    .debt-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }
    .progress-bg {
        background: rgba(255,255,255,0.1);
        border-radius: 99px;
        height: 8px;
        width: 100%;
        margin-top: 0.5rem;
        overflow: hidden;
    }
    .progress-bar-payable {
        background: #ef4444; /* red for payable */
        height: 100%;
        border-radius: 99px;
        transition: width 0.5s ease;
    }
    .progress-bar-receivable {
        background: #10b981; /* green for receivable */
        height: 100%;
        border-radius: 99px;
        transition: width 0.5s ease;
    }
    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-md);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .status-unpaid {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    .status-partially {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    .status-paid {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .tab-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-muted);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        flex: 1;
        text-align: center;
    }
    .tab-btn.active {
        background: var(--accent-blue);
        color: #fff;
        border-color: var(--accent-blue);
    }
</style>

<div style="max-width: 1200px; margin: 0 auto;">
    <div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
        <div style="flex: 1; min-width: 250px;">
            <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Hutang & Piutang</h2>
            <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.95rem; margin-bottom: 0;">Catat pinjaman Anda atau pinjaman teman agar tidak lupa.</p>
        </div>
        <button class="btn btn-primary" onclick="openAddModal()" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: max-content; padding: 0.75rem 1.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Catat Baru
        </button>
    </div>

    <!-- Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="stat-card" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2);">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="stat-content">
                <h3>Total Hutang Saya</h3>
                <div class="amount" style="color: #ef4444;">Rp {{ number_format($totalPayable, 0, ',', '.') }}</div>
                <p>Uang yang harus dikembalikan</p>
            </div>
        </div>

        <div class="stat-card" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2);">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-content">
                <h3>Total Piutang (Uang Saya)</h3>
                <div class="amount" style="color: #10b981;">Rp {{ number_format($totalReceivable, 0, ',', '.') }}</div>
                <p>Uang yang dipinjam orang lain</p>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
        <div class="tab-btn active" id="tab-payable" onclick="switchTab('payable')">Hutang Saya</div>
        <div class="tab-btn" id="tab-receivable" onclick="switchTab('receivable')">Piutang (Uang Saya di Orang)</div>
    </div>

    <!-- Content: Payable -->
    <div id="content-payable" style="display: block;">
        @forelse($payables as $debt)
            @include('debts.partials.card', ['debt' => $debt])
        @empty
            <div style="text-align: center; padding: 3rem; background: var(--bg-card); border-radius: var(--radius-xl); border: 1px dashed var(--border-color);">
                <p style="color: var(--text-muted); margin: 0;">Yeay! Anda tidak memiliki hutang saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Content: Receivable -->
    <div id="content-receivable" style="display: none;">
        @forelse($receivables as $debt)
            @include('debts.partials.card', ['debt' => $debt])
        @empty
            <div style="text-align: center; padding: 3rem; background: var(--bg-card); border-radius: var(--radius-xl); border: 1px dashed var(--border-color);">
                <p style="color: var(--text-muted); margin: 0;">Belum ada catatan piutang uang.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Tambah Data -->
<div class="modal-overlay" id="addDebtModal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3>Catat Hutang/Piutang</h3>
            <button class="close-modal" onclick="closeAddModal()">&times;</button>
        </div>
        <form action="{{ route('debts.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Tipe Catatan</label>
                <select name="type" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: white;" required>
                    <option value="payable" style="color: black;">Saya berhutang / Meminjam uang</option>
                    <option value="receivable" style="color: black;">Saya meminjamkan uang ke orang (Piutang)</option>
                </select>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Nama Orang / Instansi</label>
                <input type="text" name="person_name" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: white;" placeholder="Cth: Budi / Paylater" required>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Jumlah Uang (Rp)</label>
                <input type="number" name="amount" min="1" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: white;" placeholder="0" required>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Sumber/Tujuan Dana</label>
                <select name="account" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: white;" required>
                    <option value="cash" style="color: black;">Tunai</option>
                    <option value="bank" style="color: black;">Bank/E-Wallet</option>
                </select>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Tanggal Jatuh Tempo (Opsional)</label>
                <input type="date" name="due_date" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: white; color-scheme: dark;">
            </div>
            
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">
                *Catatan: Saat Anda menyimpan data ini, sistem akan otomatis mencatatnya sebagai transaksi (memotong atau menambah saldo utama Anda).
            </p>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.8rem; font-weight: 600;">Simpan Catatan</button>
        </form>
    </div>
</div>

<!-- Modal Bayar/Cicil -->
<div class="modal-overlay" id="payDebtModal">
    <div class="modal-content" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Bayar / Terima Cicilan</h3>
            <button class="close-modal" onclick="closePayModal()">&times;</button>
        </div>
        <form id="payDebtForm" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Sisa yang belum lunas (Rp)</label>
                <div id="payDebtRemaining" style="font-size: 1.25rem; font-weight: 700; color: white;">Rp 0</div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Jumlah Dibayar (Rp)</label>
                <input type="number" name="amount" id="payDebtAmountInput" min="1" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: white;" required>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Gunakan Saldo Dari/Ke</label>
                <select name="account" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: white;" required>
                    <option value="cash" style="color: black;">Tunai</option>
                    <option value="bank" style="color: black;">Bank/E-Wallet</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.8rem; font-weight: 600;">Proses Pembayaran</button>
        </form>
    </div>
</div>

<script>
    function switchTab(tab) {
        if (tab === 'payable') {
            document.getElementById('tab-payable').classList.add('active');
            document.getElementById('tab-receivable').classList.remove('active');
            document.getElementById('content-payable').style.display = 'block';
            document.getElementById('content-receivable').style.display = 'none';
        } else {
            document.getElementById('tab-receivable').classList.add('active');
            document.getElementById('tab-payable').classList.remove('active');
            document.getElementById('content-receivable').style.display = 'block';
            document.getElementById('content-payable').style.display = 'none';
        }
    }

    function openAddModal() {
        document.getElementById('addDebtModal').classList.add('active');
    }

    function closeAddModal() {
        document.getElementById('addDebtModal').classList.remove('active');
    }

    function openPayModal(id, remaining) {
        document.getElementById('payDebtForm').action = '/debts/' + id + '/pay';
        document.getElementById('payDebtRemaining').innerText = 'Rp ' + remaining.toLocaleString('id-ID');
        document.getElementById('payDebtAmountInput').value = remaining;
        document.getElementById('payDebtAmountInput').max = remaining;
        document.getElementById('payDebtModal').classList.add('active');
    }

    function closePayModal() {
        document.getElementById('payDebtModal').classList.remove('active');
    }

    // Close modal when clicking outside
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
</script>
@endsection
