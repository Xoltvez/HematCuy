@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Catat Struk Belanja</h2>
            <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.95rem; margin-bottom: 0;">Foto struk belanja Anda, sistem akan mengekstrak dan menyimpannya secara otomatis.</p>
        </div>
    </div>

    <div class="splitbill-container" style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
        
        <!-- Bagian 1: Upload Struk -->
        <div class="card" id="upload-section" style="display: block; background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2.5rem;">
            <h3 style="margin: 0 0 1.5rem 0; font-size: 1.25rem; font-weight: 600; display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); color: #60a5fa; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                Unggah Foto Struk
            </h3>
            
            <form id="upload-form" onsubmit="analyzeReceipt(event)">
                @csrf
                <div id="drop-zone" class="scanner-container" style="border: 2px dashed rgba(59, 130, 246, 0.4); border-radius: var(--radius-lg); padding: 4rem 2rem; text-align: center; margin-bottom: 1.5rem; background: rgba(59, 130, 246, 0.05); cursor: pointer; transition: all 0.3s ease;" onclick="document.getElementById('receipt_image').click()">
                    <div class="scan-beam"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #60a5fa; margin-bottom: 1rem;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                    <p style="color: var(--text-main); font-weight: 600; font-size: 1.1rem; margin-bottom: 0.5rem;">Klik atau Seret (Drag & Drop) Foto Struk Kesini</p>
                    <p style="color: var(--text-muted); font-size: 0.9rem;" id="file-name">Format didukung: JPG, PNG, WEBP (Maks 5MB)</p>
                    <input type="file" id="receipt_image" name="receipt_image" accept="image/*" style="display: none;" onchange="updateFileName(this)" required>
                </div>
                
                <button type="submit" id="analyze-btn" class="btn btn-primary" style="width: 100%; border-radius: var(--radius-lg); font-size: 1.1rem; padding: 1.2rem; font-weight: 600; box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.4);">
                    Pindai Struk
                </button>
            </form>
            
            <div id="loading-indicator" style="display: none; text-align: center; margin-top: 2rem;">
                <svg class="spinner" viewBox="0 0 50 50" style="width: 48px; height: 48px; animation: rotate 2s linear infinite;">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4" stroke="#60a5fa" style="stroke-linecap: round; animation: dash 1.5s ease-in-out infinite;"></circle>
                </svg>
                <p style="color: #60a5fa; margin-top: 1rem; font-weight: 600; font-size: 1.1rem;" id="loading-text">Sistem sedang membaca tulisan pada struk...</p>
            </div>
        </div>

        <!-- Bagian 2: Hasil Review & Save -->
        <div id="result-section" style="display: none;">
            <div class="card" style="display: block; background: var(--bg-card); backdrop-filter: blur(24px); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2.5rem;">
                <h3 style="margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 700; color: #34d399; text-align: center;">🧾 Review Hasil Ekstrak</h3>
                <p style="text-align: center; color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">Periksa daftar barang di bawah ini. Anda dapat menyimpannya langsung menjadi riwayat pengeluaran.</p>
                
                <form id="saveExpenseForm" method="POST" action="{{ route('receipt.store') }}">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                        <div>
                            <label style="display:block; font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem;">Nama Transaksi</label>
                            <input type="text" name="title" value="Belanja Bulanan" required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255, 255, 255, 0.05); color: white; outline: none;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem;">Kategori</label>
                            <select name="category" required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: #0f172a; color: white; outline: none;">
                                <option value="Makanan & Minuman">Makanan & Minuman</option>
                                <option value="Belanja">Belanja Bulanan</option>
                                <option value="Transportasi">Transportasi</option>
                                <option value="Hiburan">Hiburan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem;">Dompet/Sumber Dana</label>
                            <select name="account" required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: #0f172a; color: white; outline: none;">
                                <option value="cash">Tunai (Cash)</option>
                                <option value="bank">Transfer Bank</option>
                                <option value="ewallet">E-Wallet (Gopay/OVO/dll)</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:0.85rem; color:var(--text-muted); margin-bottom:0.5rem;">Tanggal</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255, 255, 255, 0.05); color: white; outline: none; color-scheme: dark;">
                        </div>
                    </div>

                    <div id="items-list-container" style="background: rgba(255,255,255,0.02); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid rgba(255,255,255,0.05); margin-bottom: 2rem;">
                        <h4 style="margin: 0 0 1rem 0; font-size: 1.1rem;">Daftar Barang</h4>
                        <div id="items-list">
                            <!-- Items inserted by JS -->
                        </div>
                    </div>

                    <div style="background: rgba(255,255,255,0.02); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.5rem; color: #34d399;">
                            <span>Total Tagihan:</span>
                            <span id="label-total">Rp 0</span>
                        </div>
                        <input type="hidden" name="amount" id="final-amount">
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem; background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 1rem; border-radius: var(--radius-md); font-weight: 600; font-size: 1.1rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(16, 185, 129, 0.25)'" onmouseout="this.style.background='rgba(16, 185, 129, 0.15)'">
                            Simpan ke Pengeluaran
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes rotate { 100% { transform: rotate(360deg); } }
@keyframes dash {
  0% { stroke-dasharray: 1, 150; stroke-dashoffset: 0; }
  50% { stroke-dasharray: 90, 150; stroke-dashoffset: -35; }
  100% { stroke-dasharray: 90, 150; stroke-dashoffset: -124; }
}
</style>

<script>
    // Drag and Drop Logic
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('receipt_image');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        dropZone.addEventListener('mouseover', highlight, false);
        dropZone.addEventListener('mouseout', unhighlight, false);
        dropZone.addEventListener('drop', handleDrop, false);

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            dropZone.style.background = 'rgba(59, 130, 246, 0.15)';
            dropZone.style.borderColor = 'rgba(59, 130, 246, 0.8)';
        }

        function unhighlight(e) {
            dropZone.style.background = 'rgba(59, 130, 246, 0.05)';
            dropZone.style.borderColor = 'rgba(59, 130, 246, 0.4)';
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                if (files[0].type.startsWith('image/')) {
                    fileInput.files = files;
                    updateFileName(fileInput);
                } else {
                    alert('Mohon unggah file berupa gambar (JPG, PNG, WEBP).');
                }
            }
        }

        const itemsList = document.getElementById('items-list');
        if (itemsList) {
            itemsList.addEventListener('input', function(e) {
                if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
                    recalculateTotal();
                }
            });
        }
    });

    function updateFileName(input) {
        if (input.files && input.files[0]) {
            document.getElementById('file-name').innerHTML = `<span style="color: #34d399; font-weight: 600;">Terpilih: ${input.files[0].name}</span>`;
        }
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    async function analyzeReceipt(e) {
        e.preventDefault();
        
        const form = document.getElementById('upload-form');
        const formData = new FormData(form);
        const fileInput = document.getElementById('receipt_image');
        
        if (!fileInput.files || fileInput.files.length === 0) {
            alert('Pilih foto struk terlebih dahulu!');
            return;
        }

        document.getElementById('analyze-btn').style.display = 'none';
        document.getElementById('loading-indicator').style.display = 'block';
        document.getElementById('result-section').style.display = 'none';
        document.getElementById('drop-zone').classList.add('scanning');
        
        const loadingTexts = ["Sistem sedang membaca tulisan...", "Menghitung harga barang...", "Merekap barang...", "Hampir selesai..."];
        let textIdx = 0;
        const textInterval = setInterval(() => {
            textIdx = (textIdx + 1) % loadingTexts.length;
            document.getElementById('loading-text').innerText = loadingTexts[textIdx];
        }, 2000);

        try {
            const response = await fetch("{{ route('receipt.analyze') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const res = await response.json();
            
            clearInterval(textInterval);
            document.getElementById('drop-zone').classList.remove('scanning');
            document.getElementById('loading-indicator').style.display = 'none';
            document.getElementById('analyze-btn').style.display = 'block';
            
            if (res.success) {
                renderResults(res.data);
                document.getElementById('result-section').style.display = 'block';
                // Scroll to result
                document.getElementById('result-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                showErrorModal('Gagal: ' + res.message);
            }
        } catch (error) {
            clearInterval(textInterval);
            document.getElementById('drop-zone').classList.remove('scanning');
            document.getElementById('loading-indicator').style.display = 'none';
            document.getElementById('analyze-btn').style.display = 'block';
            showErrorModal('Terjadi kesalahan jaringan.');
            console.error(error);
        }
    }

    function recalculateTotal() {
        let total = 0;
        document.querySelectorAll('.receipt-item-row').forEach(row => {
            const qtyInput = row.querySelector('.item-qty');
            const priceInput = row.querySelector('.item-price');
            if (qtyInput && priceInput) {
                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                total += qty * price;
            }
        });
        document.getElementById('label-total').innerText = formatRupiah(total);
        document.getElementById('final-amount').value = total;
    }

    function renderResults(data) {
        const itemsList = document.getElementById('items-list');
        
        let html = '';
        let totalItemsCost = 0;
        
        data.items.forEach((item, index) => {
            const total = item.price * (item.qty || 1);
            totalItemsCost += total;
            html += `
                <div class="receipt-item-row" style="display: flex; gap: 1rem; align-items: center; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 2;">
                        <input type="text" name="items[${index}][name]" value="${item.name}" required style="width: 100%; padding: 0.5rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.2); background: transparent; color: white; outline: none;">
                    </div>
                    <div style="flex: 1;">
                        <input type="number" name="items[${index}][qty]" class="item-qty" value="${item.qty || 1}" min="1" required style="width: 100%; padding: 0.5rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.2); background: transparent; color: white; outline: none; text-align: center;">
                    </div>
                    <div style="flex: 2;">
                        <input type="number" name="items[${index}][price]" class="item-price" value="${item.price}" min="0" required style="width: 100%; padding: 0.5rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.2); background: transparent; color: white; outline: none;">
                    </div>
                </div>
            `;
        });
        
        // Cek jika tax belum masuk item (seperti kasus indomaret / restoran)
        const originalTotal = data.total || 0;
        const originalTaxAndService = (data.tax || 0) + (data.service_charge || 0);
        
        let isTaxIncluded = false;
        if (originalTotal > 0 && Math.abs(totalItemsCost - originalTotal) < Math.abs((totalItemsCost + originalTaxAndService) - originalTotal)) {
            isTaxIncluded = true;
        }
        
        if (!isTaxIncluded && originalTaxAndService > 0) {
            html += `
                <div class="receipt-item-row" style="display: flex; gap: 1rem; align-items: center; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 2;">
                        <input type="text" name="items[${data.items.length}][name]" value="Pajak & Layanan" required style="width: 100%; padding: 0.5rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.2); background: transparent; color: white; outline: none;">
                    </div>
                    <div style="flex: 1;">
                        <input type="number" name="items[${data.items.length}][qty]" class="item-qty" value="1" min="1" required style="width: 100%; padding: 0.5rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.2); background: transparent; color: white; outline: none; text-align: center;">
                    </div>
                    <div style="flex: 2;">
                        <input type="number" name="items[${data.items.length}][price]" class="item-price" value="${originalTaxAndService}" min="0" required style="width: 100%; padding: 0.5rem; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.2); background: transparent; color: white; outline: none;">
                    </div>
                </div>
            `;
            totalItemsCost += originalTaxAndService;
        }
        
        itemsList.innerHTML = html;
        document.getElementById('label-total').innerText = formatRupiah(totalItemsCost);
        document.getElementById('final-amount').value = totalItemsCost;
    }

    function showErrorModal(message) {
        document.getElementById('errorModalMessage').innerText = message;
        document.getElementById('receiptErrorModal').style.display = 'flex';
        // Trigger reflow
        void document.getElementById('receiptErrorModal').offsetWidth;
        document.getElementById('receiptErrorModal').classList.add('active');
    }

    function closeErrorModal(e) {
        if (!e || e.target.id === 'receiptErrorModal' || e.target.closest('.close-modal-btn')) {
            document.getElementById('receiptErrorModal').classList.remove('active');
            setTimeout(() => {
                document.getElementById('receiptErrorModal').style.display = 'none';
            }, 300);
        }
    }
</script>

<style>
    .receipt-error-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(10, 10, 10, 0.95);
        backdrop-filter: blur(12px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }
    .receipt-error-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .receipt-error-content {
        background: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        width: 90%;
        max-width: 400px;
        padding: 2rem;
        transform: translateY(20px);
        transition: all 0.3s;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    }
    .receipt-error-overlay.active .receipt-error-content {
        transform: translateY(0);
    }
</style>

<!-- Error Modal -->
<div class="receipt-error-overlay" id="receiptErrorModal" onclick="closeErrorModal(event)">
    <div class="receipt-error-content" onclick="event.stopPropagation()">
        <div style="color: #ef4444; margin-bottom: 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        </div>
        <h3 style="margin: 0 0 1rem 0; color: #fff; font-size: 1.25rem;">Oops, Gagal</h3>
        <p id="errorModalMessage" style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.95rem;">Terjadi kesalahan jaringan.</p>
        <button class="close-modal-btn" onclick="closeErrorModal()" style="background: var(--accent-blue); color: white; border: none; padding: 0.75rem 2.5rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; transition: all 0.2s;">Oke, Mengerti</button>
    </div>
</div>
@endsection
