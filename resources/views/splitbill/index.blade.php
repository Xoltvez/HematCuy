@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="margin-bottom: 2rem;">
    <h2>Bagi Tagihan <span style="background: rgba(167, 139, 250, 0.2); color: #a78bfa; font-size: 0.8rem; padding: 0.2rem 0.5rem; border-radius: 6px; vertical-align: middle;">AI</span></h2>
    <p>Unggah foto struk makanan, AI akan membacakannya, dan kita hitung patungan secara adil!</p>
</div>

<div class="splitbill-container" style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
    
    <!-- Bagian 1: Upload Struk -->
    <div class="card" id="upload-section" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 2rem;">
        <h3 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #a78bfa;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Langkah 1: Unggah Foto Struk
        </h3>
        
        <form id="upload-form" onsubmit="analyzeReceipt(event)">
            @csrf
            <div style="border: 2px dashed rgba(167, 139, 250, 0.4); border-radius: var(--radius-md); padding: 3rem 2rem; text-align: center; margin-bottom: 1.5rem; background: rgba(167, 139, 250, 0.05); cursor: pointer;" onclick="document.getElementById('receipt_image').click()">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #a78bfa; margin-bottom: 1rem;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                <p style="color: var(--text-main); font-weight: 500; margin-bottom: 0.5rem;">Klik untuk Memilih Foto Struk</p>
                <p style="color: var(--text-muted); font-size: 0.85rem;" id="file-name">Format didukung: JPG, PNG, WEBP (Maks 5MB)</p>
                <input type="file" id="receipt_image" name="receipt_image" accept="image/*" style="display: none;" onchange="updateFileName(this)" required>
            </div>
            
            <button type="submit" id="analyze-btn" class="btn btn-primary" style="width: 100%; background: linear-gradient(135deg, #7c3aed, #a78bfa); border: none; font-size: 1.1rem; padding: 1rem;">
                Analisis Struk dengan AI ✨
            </button>
        </form>
        
        <div id="loading-indicator" style="display: none; text-align: center; margin-top: 1.5rem;">
            <svg class="spinner" viewBox="0 0 50 50" style="width: 40px; height: 40px; animation: rotate 2s linear infinite;">
                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5" stroke="#a78bfa" style="stroke-linecap: round; animation: dash 1.5s ease-in-out infinite;"></circle>
            </svg>
            <p style="color: #a78bfa; margin-top: 1rem; font-weight: 500;" id="loading-text">AI sedang membaca tulisan pada struk...</p>
        </div>
    </div>

    <!-- Bagian 2: Hasil & Pembagian (Awalnya Sembunyi) -->
    <div id="result-section" style="display: none;">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; align-items: start;">
            
            <!-- Daftar Orang -->
            <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem;">
                <h3 style="margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">👥 Anggota Nongkrong</h3>
                
                <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; width: 100%;">
                    <input type="text" id="new-person" placeholder="Nama teman (cth: Budi)" style="flex-grow: 1; min-width: 0; padding: 0.5rem 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(15, 23, 42, 0.5); color: white; outline: none;">
                    <button type="button" class="btn btn-primary" onclick="addPerson()" style="width: auto; white-space: nowrap; padding: 0.5rem 1rem; flex-shrink: 0;">Tambah</button>
                </div>
                
                <div id="people-list" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <!-- Orang akan muncul di sini -->
                </div>
            </div>
            
            <!-- Rincian Struk & Penugasan -->
            <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem;">
                <h3 style="margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">🧾 Daftar Pesanan</h3>
                
                <div id="items-list" style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <!-- Item akan muncul di sini -->
                </div>
                
                <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: var(--radius-md);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: var(--text-muted);">
                        <span>Subtotal Makanan:</span>
                        <span id="label-subtotal">Rp 0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #f43f5e;">
                        <span>Pajak (PPN):</span>
                        <span id="label-tax">Rp 0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #f43f5e;">
                        <span>Biaya Layanan (Service):</span>
                        <span id="label-service">Rp 0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem; margin-top: 0.5rem;">
                        <span>Total Keseluruhan:</span>
                        <span id="label-total" style="color: var(--color-primary);">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hasil Patungan -->
        <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.5rem; margin-top: 1.5rem;">
            <h3 style="margin-bottom: 1rem; text-align: center; color: #10b981;">💰 Hasil Pembagian Tagihan (Proporsional)</h3>
            <p style="text-align: center; color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Sistem otomatis membagi pajak secara adil berdasarkan harga makanan masing-masing orang.</p>
            
            <div id="split-results" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
                <!-- Hasil hitungan akan muncul di sini -->
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
select.person-select {
    padding: 0.4rem;
    border-radius: 4px;
    background: #0f172a;
    color: white;
    border: 1px solid var(--border-color);
    outline: none;
}
</style>

<script>
    // State Aplikasi
    let receiptData = null;
    let people = ['Saya']; // Default person
    let itemAssignments = {}; // itemId -> personName

    function updateFileName(input) {
        if (input.files && input.files[0]) {
            document.getElementById('file-name').innerHTML = `<span style="color: #10b981;">Terpilih: ${input.files[0].name}</span>`;
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

        // Tampilkan loading
        document.getElementById('analyze-btn').style.display = 'none';
        document.getElementById('loading-indicator').style.display = 'block';
        document.getElementById('result-section').style.display = 'none';
        
        // Reset text animasi
        const loadingTexts = ["AI sedang membaca tulisan...", "Menghitung harga...", "Mengidentifikasi PPN...", "Hampir selesai..."];
        let textIdx = 0;
        const textInterval = setInterval(() => {
            textIdx = (textIdx + 1) % loadingTexts.length;
            document.getElementById('loading-text').innerText = loadingTexts[textIdx];
        }, 2000);

        try {
            const response = await fetch("{{ route('splitbill.analyze') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const result = await response.json();
            clearInterval(textInterval);

            if (result.success) {
                receiptData = result.data;
                // Normalisasi item ids
                receiptData.items = receiptData.items.map((item, index) => ({...item, id: 'item_' + index}));
                
                // Set default assign ke orang pertama
                itemAssignments = {};
                receiptData.items.forEach(item => {
                    itemAssignments[item.id] = people[0];
                });

                renderResults();
                document.getElementById('result-section').style.display = 'block';
            } else {
                alert('Gagal: ' + result.message);
            }
        } catch (error) {
            clearInterval(textInterval);
            console.error(error);
            alert('Terjadi kesalahan jaringan atau server.');
        } finally {
            document.getElementById('analyze-btn').style.display = 'block';
            document.getElementById('loading-indicator').style.display = 'none';
        }
    }

    function addPerson() {
        const input = document.getElementById('new-person');
        const name = input.value.trim();
        if (name && !people.includes(name)) {
            people.push(name);
            input.value = '';
            renderResults(); // Refresh all
        }
    }

    function removePerson(name) {
        if (people.length <= 1) {
            alert('Minimal harus ada 1 orang.');
            return;
        }
        people = people.filter(p => p !== name);
        // Pindahkan tugas item ke orang pertama yang tersedia
        Object.keys(itemAssignments).forEach(itemId => {
            if (itemAssignments[itemId] === name) {
                itemAssignments[itemId] = people[0];
            }
        });
        renderResults();
    }

    function assignItem(itemId, personName) {
        itemAssignments[itemId] = personName;
        calculateSplit(); // Just recalculate
    }

    function renderResults() {
        // Render Daftar Orang
        const peopleList = document.getElementById('people-list');
        peopleList.innerHTML = people.map(p => `
            <div style="display: flex; justify-content: space-between; background: rgba(255,255,255,0.05); padding: 0.5rem 1rem; border-radius: 4px;">
                <span>${p}</span>
                ${people.length > 1 ? `<button onclick="removePerson('${p}')" style="background:none; border:none; color:#f43f5e; cursor:pointer;">✕</button>` : ''}
            </div>
        `).join('');

        // Render Summary Struk
        document.getElementById('label-subtotal').innerText = formatRupiah(receiptData.subtotal || 0);
        document.getElementById('label-tax').innerText = formatRupiah(receiptData.tax || 0);
        document.getElementById('label-service').innerText = formatRupiah(receiptData.service_charge || 0);
        document.getElementById('label-total').innerText = formatRupiah(receiptData.total || 0);

        // Render Daftar Item
        const itemsList = document.getElementById('items-list');
        itemsList.innerHTML = receiptData.items.map(item => `
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed var(--border-color); padding-bottom: 0.75rem;">
                <div style="flex: 1;">
                    <div style="font-weight: 500;">${item.name} ${item.qty > 1 ? `<span style="color:var(--text-muted); font-size:0.8rem;">(x${item.qty})</span>` : ''}</div>
                    <div style="color: var(--color-primary); font-size: 0.9rem;">${formatRupiah(item.price * (item.qty || 1))}</div>
                </div>
                <div>
                    <select class="person-select" onchange="assignItem('${item.id}', this.value)">
                        ${people.map(p => `<option value="${p}" ${itemAssignments[item.id] === p ? 'selected' : ''}>${p}</option>`).join('')}
                    </select>
                </div>
            </div>
        `).join('');

        calculateSplit();
    }

    function calculateSplit() {
        const resultsContainer = document.getElementById('split-results');
        
        let personTotals = {};
        let totalAssignedAmount = 0;

        people.forEach(p => personTotals[p] = { itemsTotal: 0, itemsCount: 0 });

        // Hitung total makanan per orang
        receiptData.items.forEach(item => {
            const owner = itemAssignments[item.id];
            const cost = item.price * (item.qty || 1);
            if (personTotals[owner]) {
                personTotals[owner].itemsTotal += cost;
                personTotals[owner].itemsCount += 1;
                totalAssignedAmount += cost;
            }
        });

        // Hitung total beban pajak & service
        const totalTaxAndService = (receiptData.tax || 0) + (receiptData.service_charge || 0);
        
        // Peringatan jika data aneh
        let warningHtml = '';
        if (totalAssignedAmount === 0 && totalTaxAndService > 0) {
             warningHtml = '<div style="color: #f59e0b; font-size: 0.85rem; margin-bottom: 1rem; text-align: center;">⚠ Peringatan: Tidak ada harga makanan yang terdeteksi, pajak dibagi rata.</div>';
        }

        let html = warningHtml;

        people.forEach(p => {
            const pt = personTotals[p];
            // Proporsi pajak: (total makanan orang tsb / total semua makanan yang terdeteksi) * total pajak
            let taxShare = 0;
            if (totalAssignedAmount > 0) {
                taxShare = (pt.itemsTotal / totalAssignedAmount) * totalTaxAndService;
            } else if (people.length > 0) {
                // Jika tidak ada total makanan tapi ada pajak, bagi rata
                taxShare = totalTaxAndService / people.length;
            }
            
            const grandTotal = pt.itemsTotal + taxShare;

            html += `
                <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); padding: 1.25rem; border-radius: var(--radius-md);">
                    <h4 style="color: var(--text-main); margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between;">
                        ${p}
                        <span style="font-size: 0.8rem; background: rgba(255,255,255,0.1); padding: 0.2rem 0.5rem; border-radius: 12px;">${pt.itemsCount} pesanan</span>
                    </h4>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">
                        <span>Makanan:</span>
                        <span>${formatRupiah(pt.itemsTotal)}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #f43f5e; margin-bottom: 0.75rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem;">
                        <span>Porsi Pajak/Layanan:</span>
                        <span>+ ${formatRupiah(taxShare)}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem; color: #10b981;">
                        <span>Total Bayar:</span>
                        <span>${formatRupiah(grandTotal)}</span>
                    </div>
                </div>
            `;
        });

        resultsContainer.innerHTML = html;
    }

</script>
@endsection
