@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Catat Transaksi</h2>
            <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.95rem; margin-bottom: 0;">Catat pemasukan atau pengeluaran baru Anda</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="transaction-form-section" style="background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2.5rem;">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            
            <!-- Tipe Transaksi (Pemasukan / Pengeluaran) -->
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="color: var(--text-main); font-weight: 600; margin-bottom: 0.75rem;">Jenis Transaksi</label>
                <div style="display: flex; gap: 1rem;">
                    <label style="flex: 1; position: relative; cursor: pointer; margin: 0;">
                        <input type="radio" name="type" value="income" required style="position: absolute; opacity: 0; width: 0; height: 0;" class="type-radio">
                        <div class="type-btn" style="border: 1px solid rgba(16, 185, 129, 0.3); padding: 1rem; text-align: center; border-radius: var(--radius-md); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background: rgba(16, 185, 129, 0.05); color: #34d399;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 5-5-3-5 3"/></svg>
                            Pemasukan
                        </div>
                    </label>
                    
                    <label style="flex: 1; position: relative; cursor: pointer; margin: 0;">
                        <input type="radio" name="type" value="expense" required style="position: absolute; opacity: 0; width: 0; height: 0;" class="type-radio" checked>
                        <div class="type-btn" style="border: 1px solid #f43f5e; padding: 1rem; text-align: center; border-radius: var(--radius-md); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background: #f43f5e; color: #fff; font-weight: 600; box-shadow: 0 4px 12px rgba(244,63,94,0.3);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 19-5 3-5-3"/></svg>
                            Pengeluaran
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-row-grid">
                <!-- Nominal -->
                <div class="form-group">
                    <label for="amount_display">Jumlah / Nominal (Rp)</label>
                    <input type="text" id="amount_display" required placeholder="Misal: 50.000" style="font-size: 1.1rem; font-weight: 600;" inputmode="numeric">
                    <input type="hidden" id="amount" name="amount" required min="0">
                </div>
                
                <!-- Tanggal -->
                <div class="form-group">
                    <label for="date">Tanggal Transaksi</label>
                    <input type="date" id="date" name="date" required value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="title">Judul / Keterangan Singkat</label>
                <input type="text" id="title" name="title" required placeholder="Contoh: Makan Siang, Beli Pulsa, Gaji Bulan Ini">
            </div>
            
            <div class="form-row-grid">
                <div class="form-group">
                    <label for="category">Kategori (Opsional)</label>
                    <!-- Menggunakan datalist agar pengguna bisa mengetik atau memilih dari daftar -->
                    <input type="text" id="category" name="category" list="category-list" placeholder="Pilih atau Ketik Baru">
                    <datalist id="category-list">
                        <option value="Makanan & Minuman">
                        <option value="Transportasi">
                        <option value="Belanja">
                        <option value="Tagihan & Utilitas">
                        <option value="Hiburan">
                        <option value="Kesehatan">
                        <option value="Tabungan">
                        <option value="Gaji">
                        <option value="Lain-lain">
                    </datalist>
                    <small style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.25rem; display: block;">*Penting: Samakan nama kategori dengan nama pos di fitur Budgeting agar progres terpotong otomatis.</small>
                </div>
                
                <div class="form-group">
                    <label for="account">Sumber Dana</label>
                    <select id="account" name="account" required>
                        <option value="cash">Tunai (Dompet)</option>
                        <option value="bank">Bank / E-Wallet</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Catatan Tambahan (Opsional)</label>
                <input type="text" id="description" name="description" placeholder="Catatan detail jika diperlukan">
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 1rem; font-size: 1.1rem; border-radius: var(--radius-lg); margin-top: 1rem;">Simpan Transaksi</button>
        </form>
    </div>
</div>

<style>
.form-row-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .form-row-grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .transaction-form-section {
        padding: 1.5rem !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountDisplay = document.getElementById('amount_display');
    const amountHidden = document.getElementById('amount');

    if (amountDisplay && amountHidden) {
        amountDisplay.addEventListener('input', function(e) {
            // Remove non-digit characters
            let value = this.value.replace(/[^0-9]/g, '');
            
            // Update hidden input
            amountHidden.value = value;
            
            // Format display value with thousands separator
            if(value) {
                this.value = parseInt(value, 10).toLocaleString('id-ID');
            } else {
                this.value = '';
            }
        });
    }

    const radios = document.querySelectorAll('.type-radio');
    
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset both styles
            document.querySelectorAll('.type-btn').forEach(btn => {
                btn.style.fontWeight = 'normal';
                btn.style.color = ''; // reset to default
                btn.style.background = '';
                btn.style.borderColor = '';
                btn.style.boxShadow = 'none';
            });
            
            const btn = this.nextElementSibling;
            if (this.value === 'income') {
                btn.style.background = '#10b981';
                btn.style.color = '#fff';
                btn.style.fontWeight = '600';
                btn.style.borderColor = '#10b981';
                btn.style.boxShadow = '0 4px 12px rgba(16,185,129,0.3)';
                
                const expBtn = document.querySelector('input[value="expense"]').nextElementSibling;
                expBtn.style.background = 'rgba(244, 63, 94, 0.05)';
                expBtn.style.color = '#fb7185';
                expBtn.style.borderColor = 'rgba(244, 63, 94, 0.3)';
                expBtn.style.boxShadow = 'none';
            } else {
                btn.style.background = '#f43f5e';
                btn.style.color = '#fff';
                btn.style.fontWeight = '600';
                btn.style.borderColor = '#f43f5e';
                btn.style.boxShadow = '0 4px 12px rgba(244,63,94,0.3)';
                
                const incBtn = document.querySelector('input[value="income"]').nextElementSibling;
                incBtn.style.background = 'rgba(16, 185, 129, 0.05)';
                incBtn.style.color = '#34d399';
                incBtn.style.borderColor = 'rgba(16, 185, 129, 0.3)';
                incBtn.style.boxShadow = 'none';
            }
        });
    });
});
</script>
@endsection
