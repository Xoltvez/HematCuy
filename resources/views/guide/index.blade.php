@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding-bottom: 4rem;">
    
    <!-- Hero Search Section -->
    <div class="guide-hero">
        <h2 class="hero-title">Apa yang bisa kami bantu hari ini?</h2>
        <p class="hero-subtitle">Cari panduan, tutorial, atau pertanyaan yang sering diajukan.</p>
        
        <div class="search-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="guideSearch" class="search-input" placeholder="Ketik kata kunci (misal: 'lupa password' atau 'struk')...">
        </div>
    </div>

    <!-- Category Grid -->
    <div class="category-grid" id="categoryGrid">
        <div class="category-card active" data-target="daftar-login">
            <div class="cat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            </div>
            <h3>Daftar & Login</h3>
            <p>Panduan akun & akses</p>
        </div>
        
        <div class="category-card" data-target="catat-transaksi">
            <div class="cat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
            </div>
            <h3>Catat Transaksi</h3>
            <p>Manual & sumber dana</p>
        </div>

        <div class="category-card" data-target="budgeting">
            <div class="cat-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
            </div>
            <h3>Budgeting</h3>
            <p>Pos anggaran & AI insight</p>
        </div>

        <div class="category-card" data-target="tabungan">
            <div class="cat-icon yellow">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <h3>Tabungan</h3>
            <p>Kelola wishlist impian</p>
        </div>

        <div class="category-card" data-target="catat-struk">
            <div class="cat-icon pink">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect x="7" y="7" width="10" height="10" rx="1"/></svg>
            </div>
            <h3>Catat Struk AI</h3>
            <p>Scan otomatis dengan AI</p>
        </div>

        <div class="category-card" data-target="faq">
            <div class="cat-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <h3>FAQ & Bantuan</h3>
            <p>Pertanyaan umum</p>
        </div>
    </div>

    <!-- Search Results Header (Hidden by default) -->
    <div id="searchResultsHeader" style="display: none; margin-bottom: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #fff;">Hasil Pencarian</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.25rem;">Menampilkan panduan yang cocok dengan kata kunci Anda.</p>
    </div>

    <div id="noResults" style="display: none; text-align: center; padding: 4rem 0;">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 1rem;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><path d="M11 8v2"/><path d="M11 14h.01"/></svg>
        <h3 style="color: #fff; margin-bottom: 0.5rem;">Panduan tidak ditemukan</h3>
        <p style="color: var(--text-muted);">Coba gunakan kata kunci pencarian yang berbeda.</p>
    </div>

    <!-- Konten Panduan -->
    <div class="guide-content-area">
        
        <!-- Daftar & Login Content -->
        <div id="daftar-login-content" class="guide-content active">
            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">📝 Cara Daftar Akun</h3>
                <ol class="guide-steps">
                    <li>Buka halaman awal HematCuy dan klik tombol <strong>Daftar</strong>.</li>
                    <li>Masukkan <strong>Nama Panggilan</strong>, <strong>Alamat Email</strong>, dan buat <strong>Password</strong> Anda.</li>
                    <li>Ulangi password di kolom konfirmasi dengan benar.</li>
                    <li>Klik tombol <strong>Daftar Sekarang</strong> untuk menyelesaikan registrasi.</li>
                    <li>Setelah terdaftar, Anda akan diarahkan masuk ke Dashboard utama.</li>
                </ol>
            </div>

            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">🔑 Cara Login</h3>
                <ol class="guide-steps">
                    <li>Buka halaman awal HematCuy dan klik tombol <strong>Masuk</strong>.</li>
                    <li>Masukkan <strong>Email</strong> dan <strong>Password</strong> akun terdaftar Anda.</li>
                    <li>Centang opsi "Ingat Saya" jika ingin tetap masuk otomatis di browser.</li>
                    <li>Klik tombol <strong>Masuk ke Dashboard</strong>.</li>
                </ol>
            </div>

            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">🔒 Lupa Password</h3>
                <ol class="guide-steps">
                    <li>Di halaman masuk/login, klik tautan <strong>Lupa Password?</strong>.</li>
                    <li>Masukkan email terdaftar Anda pada kolom yang disediakan.</li>
                    <li>Sistem akan mengirimkan email berisi tautan instruksi pengaturan ulang kata sandi.</li>
                    <li>Buka email tersebut, klik tautan, dan buat password baru Anda.</li>
                </ol>
            </div>
        </div>

        <!-- Catat Transaksi Content -->
        <div id="catat-transaksi-content" class="guide-content">
            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">💵 Mencatat Transaksi Manual</h3>
                <ol class="guide-steps">
                    <li>Tekan tombol <strong>Catat Transaksi</strong> di Dashboard (atau tombol melayang <strong>(+)</strong> di mobile).</li>
                    <li>Pilih jenis transaksi: <strong>Pemasukan</strong> (hijau) atau <strong>Pengeluaran</strong> (merah).</li>
                    <li>Ketik <strong>Nominal Uang</strong> yang masuk atau keluar (angka saja, separator ribuan terformat otomatis).</li>
                    <li>Tentukan <strong>Tanggal</strong> transaksi terjadi.</li>
                    <li>Isi <strong>Judul/Keterangan Singkat</strong> (misal: "Makan Bakso Solo", "Gaji Bulanan").</li>
                    <li>Pilih <strong>Kategori</strong> yang relevan (opsional) dan <strong>Sumber Dana</strong> (Tunai/Bank).</li>
                    <li>Klik tombol <strong>Simpan Transaksi</strong> di bagian bawah.</li>
                </ol>
            </div>

            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">📂 Cara Kerja Sumber Dana</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1rem;">Sumber dana membantu Anda memisahkan uang fisik (Dompet) dengan uang digital (Rekening/Bank).</p>
                <ul class="guide-steps" style="list-style-type: disc; padding-left: 1.5rem;">
                    <li><strong>Tunai (Dompet)</strong>: Untuk mencatat transaksi tunai/fisik sehari-hari.</li>
                    <li><strong>Bank / E-Wallet</strong>: Untuk mencatat transaksi digital, transfer rekening, QRIS, atau saldo e-wallet.</li>
                    <li>Saldo masing-masing sumber dana akan dihitung terpisah secara otomatis dan ditampilkan pada ringkasan Dashboard.</li>
                </ul>
            </div>
        </div>

        <!-- Budgeting Content -->
        <div id="budgeting-content" class="guide-content">
            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">📊 Mengatur Budgeting Pos Anggaran</h3>
                <ol class="guide-steps">
                    <li>Masuk ke menu <strong>Budgeting</strong> dari sidebar menu sebelah kiri.</li>
                    <li>Simpan <strong>Total Gaji/Uang Masuk</strong> Anda bulan ini di form <strong>Total Gaji Bulan Ini</strong> sebelah kiri.</li>
                    <li>Di bawahnya, isi form <strong>Buat Pos Pengeluaran</strong> (misal: Kategori "Makanan", Target Rp 1.000.000).</li>
                    <li>Klik <strong>Simpan Alokasi</strong>. Pos baru Anda akan muncul di sebelah kanan.</li>
                    <li><strong>Otomasi</strong>: Setiap kali Anda mencatat transaksi manual dengan kategori yang sama (misal: "Makanan"), sisa anggaran pada kartu budget Anda akan <strong>otomatis berkurang</strong> serta menampilkan persentase secara real-time.</li>
                </ol>
            </div>

            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">🔔 Notifikasi Batas Anggaran & Insight AI</h3>
                <ol class="guide-steps">
                    <li>Pos anggaran akan berubah warna menjadi <strong>Kuning (Warning)</strong> jika pengeluaran Anda menyentuh 80% dari target.</li>
                    <li>Pos anggaran akan berubah menjadi <strong>Merah (Danger)</strong> dan berdenyut jika melampaui 100% (Overbudget).</li>
                    <li><strong>AI Insight</strong>: Sistem secara cerdas akan menganalisis kecepatan pengeluaran harian (*burn rate*) Anda dan memprediksi sisa hari sebelum anggaran habis.</li>
                </ol>
            </div>
        </div>

        <!-- Tabungan Content -->
        <div id="tabungan-content" class="guide-content">
            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">💎 Mengelola Target Tabungan (Wishlist)</h3>
                <ol class="guide-steps">
                    <li>Buka menu <strong>Tabungan</strong> dari sidebar menu.</li>
                    <li>Pada form <strong>Tambah Wishlist Baru</strong>, isi nama barang impian Anda (misal: "Laptop Kerja Baru").</li>
                    <li>Masukkan <strong>Target Harga</strong> barang tersebut (misal: Rp 12.000.000).</li>
                    <li>Klik <strong>Simpan Wishlist</strong> untuk memproses.</li>
                    <li><strong>Kalkulasi Otomatis</strong>: Sistem akan melacak sisa uang Anda saat ini (Total Gaji - Total Pengeluaran) sebagai modal tabungan bulanan.</li>
                    <li>Sistem secara otomatis menghitung <strong>estimasi waktu (berapa bulan lagi)</strong> target tersebut akan tercapai berdasarkan kecepatan menabung Anda.</li>
                </ol>
            </div>
        </div>

        <!-- Catat Struk AI Content -->
        <div id="catat-struk-content" class="guide-content">
            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">📸 Catat Cepat Menggunakan Pemindai Struk AI</h3>
                <ol class="guide-steps">
                    <li>Masuk ke menu <strong>Catat Struk</strong> dari sidebar menu.</li>
                    <li>Klik area seret file untuk mengunggah foto struk belanja Anda (dari galeri HP atau jepret langsung).</li>
                    <li>Tekan tombol <strong>Pindai Struk</strong>.</li>
                    <li>Sinar laser visual pemindai akan berjalan memproses pembacaan gambar.</li>
                    <li>Sistem AI akan mengekstrak daftar barang belanjaan, kuantitas (qty), harga masing-masing barang, pajak, serta total belanjanya secara otomatis.</li>
                    <li>Koreksi hasil bacaan jika ada kesalahan penulisan, nominal total akan otomatis menghitung ulang secara real-time.</li>
                    <li>Klik <strong>Simpan ke Pengeluaran</strong> untuk memasukkan daftar belanjaan tersebut langsung ke riwayat transaksi Anda.</li>
                </ol>
            </div>
        </div>

        <!-- FAQ Content -->
        <div id="faq-content" class="guide-content">
            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">❓ Mengapa progress budget saya tidak terpotong otomatis?</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                    Hal ini terjadi karena <strong>kategori transaksi tidak sama persis</strong> dengan nama pos budgeting. 
                    Pastikan saat mencatat transaksi manual, Anda memasukkan nama kategori yang sama persis huruf besar-kecilnya dengan nama pos pengeluaran di menu Budgeting (contoh: jika nama pos budget adalah <strong>"Makan"</strong>, pastikan kategori transaksi ditulis <strong>"Makan"</strong>, bukan "makanan" atau "makan siang").
                </p>
            </div>

            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">🔒 Apakah data keuangan saya aman di HematCuy?</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                    Keamanan data Anda adalah prioritas kami. Semua informasi transaksi, gaji, dan tabungan Anda diamankan di server database kami yang terenkripsi dan hanya dapat diakses melalui kredensial login akun unik milik Anda.
                </p>
            </div>

            <div class="guide-article premium-glow-card">
                <h3 class="guide-card-title">🖨️ Bagaimana cara mencetak laporan transaksi?</h3>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                    Buka menu <strong>Laporan</strong> atau <strong>Riwayat</strong>, filter rentang tanggal transaksi yang ingin dicetak, lalu tekan tombol merah muda <strong>Cetak PDF</strong> di sudut kanan atas halaman. Sistem akan menghasilkan file dokumen siap cetak.
                </p>
            </div>
        </div>

    </div>
</div>

<style>
    /* Hero Search */
    .guide-hero {
        text-align: center;
        padding: 3rem 1rem 4rem 1rem;
        background: linear-gradient(to bottom, rgba(59, 130, 246, 0.05) 0%, transparent 100%);
        border-radius: var(--radius-xl);
        margin-bottom: 2rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 1rem 0;
        letter-spacing: -0.5px;
        color: #fff;
    }
    
    .hero-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin: 0 0 2.5rem 0;
    }
    
    .search-container {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }
    
    .search-icon {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    
    .search-input {
        width: 100%;
        padding: 1.25rem 1.5rem 1.25rem 3.5rem;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #fff;
        font-size: 1.05rem;
        transition: all 0.3s;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), 0 10px 30px rgba(0,0,0,0.2);
        background: rgba(15, 23, 42, 0.8);
    }

    /* Category Grid */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    
    .category-card {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: var(--radius-xl);
        padding: 1.75rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .category-card:hover {
        background: rgba(15, 23, 42, 0.7);
        border-color: rgba(255,255,255,0.15);
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }
    
    .category-card.active {
        background: rgba(59, 130, 246, 0.05);
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.05), 0 12px 30px rgba(0,0,0,0.2);
    }
    
    .cat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        transition: transform 0.3s;
    }
    
    .category-card:hover .cat-icon {
        transform: scale(1.1);
    }
    
    .cat-icon.blue { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    .cat-icon.green { background: rgba(16, 185, 129, 0.15); color: #34d399; }
    .cat-icon.purple { background: rgba(139, 92, 246, 0.15); color: #a78bfa; }
    .cat-icon.yellow { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    .cat-icon.pink { background: rgba(236, 72, 153, 0.15); color: #f472b6; }
    .cat-icon.orange { background: rgba(249, 115, 22, 0.15); color: #fb923c; }
    
    .category-card h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.15rem;
        color: #fff;
    }
    
    .category-card p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    /* Content Area */
    .guide-content {
        display: none;
        animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .guide-content.active {
        display: block;
    }
    
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .guide-article {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        margin-bottom: 1.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .guide-article:hover {
        border-color: rgba(255,255,255,0.15);
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    .guide-card-title {
        margin-top: 0;
        margin-bottom: 1.25rem;
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .guide-steps {
        padding-left: 1.25rem;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .guide-steps li {
        color: var(--text-muted);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .guide-steps li strong {
        color: #ffffff;
        font-weight: 600;
    }
    
    /* Highlight for search */
    .highlight {
        background-color: rgba(59, 130, 246, 0.3);
        color: #fff;
        padding: 0 2px;
        border-radius: 2px;
    }

    @media (max-width: 768px) {
        .category-grid {
            grid-template-columns: 1fr;
        }
        .hero-title {
            font-size: 1.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const catCards = document.querySelectorAll('.category-card');
        const contents = document.querySelectorAll('.guide-content');
        const searchInput = document.getElementById('guideSearch');
        const articles = document.querySelectorAll('.guide-article');
        const catGrid = document.getElementById('categoryGrid');
        const searchHeader = document.getElementById('searchResultsHeader');
        const noResults = document.getElementById('noResults');

        // Category clicking
        catCards.forEach(card => {
            card.addEventListener('click', function() {
                // If we are in search mode, clear it to go back to category mode
                if (searchInput.value.trim() !== '') {
                    searchInput.value = '';
                    resetSearch();
                }
                
                catCards.forEach(c => c.classList.remove('active'));
                contents.forEach(c => {
                    c.classList.remove('active');
                    // Reset inline display styles from search
                    c.style.display = ''; 
                });

                this.classList.add('active');
                
                const targetId = this.getAttribute('data-target') + '-content';
                const targetEl = document.getElementById(targetId);
                if(targetEl) targetEl.classList.add('active');
                
                // Show all articles in this category (in case they were hidden by search)
                if(targetEl) {
                    targetEl.querySelectorAll('.guide-article').forEach(a => a.style.display = 'block');
                }
            });
        });

        // Search logic
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase().trim();
            
            if (term === '') {
                resetSearch();
                return;
            }
            
            // Search Mode
            catGrid.style.display = 'none';
            searchHeader.style.display = 'block';
            
            let foundAny = false;
            
            // Go through every article in every content section
            contents.forEach(content => {
                let contentHasMatches = false;
                
                const arts = content.querySelectorAll('.guide-article');
                arts.forEach(art => {
                    const text = art.innerText.toLowerCase();
                    if (text.includes(term)) {
                        art.style.display = 'block';
                        contentHasMatches = true;
                        foundAny = true;
                    } else {
                        art.style.display = 'none';
                    }
                });
                
                if (contentHasMatches) {
                    content.classList.add('active');
                    content.style.display = 'block';
                } else {
                    content.classList.remove('active');
                    content.style.display = 'none';
                }
            });
            
            if (!foundAny) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
        
        function resetSearch() {
            catGrid.style.display = 'grid';
            searchHeader.style.display = 'none';
            noResults.style.display = 'none';
            
            // Reset visibility of all articles
            articles.forEach(a => a.style.display = 'block');
            
            // Reactivate the currently selected category tab
            const activeCard = document.querySelector('.category-card.active');
            if (activeCard) {
                contents.forEach(c => {
                    c.classList.remove('active');
                    c.style.display = ''; 
                });
                const targetId = activeCard.getAttribute('data-target') + '-content';
                const targetEl = document.getElementById(targetId);
                if(targetEl) targetEl.classList.add('active');
            }
        }
    });
</script>
@endsection
