@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding-bottom: 5rem;">
    
    <!-- Hero Search Section -->
    <div class="guide-hero">
        <h2 class="hero-title">Apa yang bisa kami bantu hari ini?</h2>
        <p class="hero-subtitle">Cari panduan, tutorial, atau pertanyaan yang sering diajukan.</p>
        
        <div class="search-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="guideSearch" class="search-input" placeholder="Ketik kata kunci (misal: 'lupa password' atau 'struk')...">
        </div>
    </div>

    <!-- Search Results Header (Hidden by default) -->
    <div id="searchResultsHeader" style="display: none; margin-bottom: 1.5rem; margin-top: -1rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #fff;">Hasil Pencarian</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.25rem;">Menampilkan panduan yang cocok dengan kata kunci Anda.</p>
    </div>

    <div id="noResults" style="display: none; text-align: center; padding: 4rem 0;">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 1rem;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><path d="M11 8v2"/><path d="M11 14h.01"/></svg>
        <h3 style="color: #fff; margin-bottom: 0.5rem;">Panduan tidak ditemukan</h3>
        <p style="color: var(--text-muted);">Coba gunakan kata kunci pencarian yang berbeda.</p>
    </div>

    <!-- Accordion Container -->
    <div class="accordion-container" id="categoryGrid">

        <!-- Accordion Item: Daftar & Login -->
        <div class="accordion-item guide-category">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    </div>
                    <span>Daftar & Login</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="guide-article">
                        <h3 class="guide-card-title">📝 Cara Daftar Akun</h3>
                        <ol class="guide-steps">
                            <li>Buka halaman awal HematCuy dan klik tombol <strong>Daftar</strong>.</li>
                            <li>Masukkan <strong>Nama Panggilan</strong>, <strong>Alamat Email</strong>, dan buat <strong>Password</strong> Anda.</li>
                            <li>Ulangi password di kolom konfirmasi dengan benar.</li>
                            <li>Klik tombol <strong>Daftar Sekarang</strong> untuk menyelesaikan registrasi.</li>
                            <li>Setelah terdaftar, Anda akan diarahkan masuk ke Dashboard utama.</li>
                        </ol>
                    </div>

                    <div class="guide-article">
                        <h3 class="guide-card-title">🔑 Cara Login</h3>
                        <ol class="guide-steps">
                            <li>Buka halaman awal HematCuy dan klik tombol <strong>Masuk</strong>.</li>
                            <li>Masukkan <strong>Email</strong> dan <strong>Password</strong> akun terdaftar Anda.</li>
                            <li>Centang opsi "Ingat Saya" jika ingin tetap masuk otomatis di browser.</li>
                            <li>Klik tombol <strong>Masuk ke Dashboard</strong>.</li>
                        </ol>
                    </div>

                    <div class="guide-article">
                        <h3 class="guide-card-title">🔒 Lupa Password</h3>
                        <ol class="guide-steps">
                            <li>Di halaman masuk/login, klik tautan <strong>Lupa Password?</strong>.</li>
                            <li>Masukkan email terdaftar Anda pada kolom yang disediakan.</li>
                            <li>Sistem akan mengirimkan email berisi tautan instruksi pengaturan ulang kata sandi.</li>
                            <li>Buka email tersebut, klik tautan, dan buat password baru Anda.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accordion Item: Catat Transaksi -->
        <div class="accordion-item guide-category">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
                    </div>
                    <span>Catat Transaksi</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="guide-article">
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

                    <div class="guide-article">
                        <h3 class="guide-card-title">📂 Cara Kerja Sumber Dana</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1rem;">Sumber dana membantu Anda memisahkan uang fisik (Dompet) dengan uang digital (Rekening/Bank).</p>
                        <ul class="guide-steps" style="list-style-type: disc; padding-left: 1.5rem;">
                            <li><strong>Tunai (Dompet)</strong>: Untuk mencatat transaksi tunai/fisik sehari-hari.</li>
                            <li><strong>Bank / E-Wallet</strong>: Untuk mencatat transaksi digital, transfer rekening, QRIS, atau saldo e-wallet.</li>
                            <li>Saldo masing-masing sumber dana akan dihitung terpisah secara otomatis dan ditampilkan pada ringkasan Dashboard.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accordion Item: Budgeting -->
        <div class="accordion-item guide-category">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                    </div>
                    <span>Budgeting</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="guide-article">
                        <h3 class="guide-card-title">📊 Mengatur Budgeting Pos Anggaran</h3>
                        <ol class="guide-steps">
                            <li>Masuk ke menu <strong>Budgeting</strong> dari sidebar menu sebelah kiri.</li>
                            <li>Simpan <strong>Total Gaji/Uang Masuk</strong> Anda bulan ini di form <strong>Total Gaji Bulan Ini</strong> sebelah kiri.</li>
                            <li>Di bawahnya, isi form <strong>Buat Pos Pengeluaran</strong> (misal: Kategori "Makanan", Target Rp 1.000.000).</li>
                            <li>Klik <strong>Simpan Alokasi</strong>. Pos baru Anda akan muncul di sebelah kanan.</li>
                            <li><strong>Otomasi</strong>: Setiap kali Anda mencatat transaksi manual dengan kategori yang sama (misal: "Makanan"), sisa anggaran pada kartu budget Anda akan <strong>otomatis berkurang</strong> serta menampilkan persentase secara real-time.</li>
                        </ol>
                    </div>

                    <div class="guide-article">
                        <h3 class="guide-card-title">🔔 Notifikasi Batas Anggaran & Insight AI</h3>
                        <ol class="guide-steps">
                            <li>Pos anggaran akan berubah warna menjadi <strong>Kuning (Warning)</strong> jika pengeluaran Anda menyentuh 80% dari target.</li>
                            <li>Pos anggaran akan berubah menjadi <strong>Merah (Danger)</strong> dan berdenyut jika melampaui 100% (Overbudget).</li>
                            <li><strong>AI Insight</strong>: Sistem secara cerdas akan menganalisis kecepatan pengeluaran harian (*burn rate*) Anda dan memprediksi sisa hari sebelum anggaran habis.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accordion Item: Tabungan -->
        <div class="accordion-item guide-category">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <span>Tabungan & Wishlist</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="guide-article">
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
            </div>
        </div>

        <!-- Accordion Item: Catat Struk AI -->
        <div class="accordion-item guide-category">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon pink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect x="7" y="7" width="10" height="10" rx="1"/></svg>
                    </div>
                    <span>Catat Struk AI</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="guide-article">
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
            </div>
        </div>

        <!-- Accordion Item: FAQ -->
        <div class="accordion-item guide-category">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon orange">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <span>FAQ & Pertanyaan Umum</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="guide-article">
                        <h3 class="guide-card-title">❓ Mengapa progress budget saya tidak terpotong otomatis?</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                            Hal ini terjadi karena <strong>kategori transaksi tidak sama persis</strong> dengan nama pos budgeting. 
                            Pastikan saat mencatat transaksi manual, Anda memasukkan nama kategori yang sama persis huruf besar-kecilnya dengan nama pos pengeluaran di menu Budgeting (contoh: jika nama pos budget adalah <strong>"Makan"</strong>, pastikan kategori transaksi ditulis <strong>"Makan"</strong>, bukan "makanan" atau "makan siang").
                        </p>
                    </div>

                    <div class="guide-article">
                        <h3 class="guide-card-title">🔒 Apakah data keuangan saya aman di HematCuy?</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                            Keamanan data Anda adalah prioritas kami. Semua informasi transaksi, gaji, dan tabungan Anda diamankan di server database kami yang terenkripsi dan hanya dapat diakses melalui kredensial login akun unik milik Anda.
                        </p>
                    </div>

                    <div class="guide-article">
                        <h3 class="guide-card-title">🖨️ Bagaimana cara mencetak laporan transaksi?</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                            Buka menu <strong>Laporan</strong> atau <strong>Riwayat</strong>, filter rentang tanggal transaksi yang ingin dicetak, lalu tekan tombol merah muda <strong>Cetak PDF</strong> di sudut kanan atas halaman. Sistem akan menghasilkan file dokumen siap cetak.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Hero Search */
    .guide-hero {
        text-align: left;
        padding: 0 0 2rem 0;
        background: transparent;
        margin-bottom: 1rem;
    }
    
    .hero-title {
        font-size: 2.25rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.5px;
        color: #fff;
    }
    
    .hero-subtitle {
        color: var(--text-muted);
        font-size: 1.05rem;
        margin: 0 0 1.5rem 0;
    }
    
    .search-container {
        max-width: 500px;
        margin: 0;
        position: relative;
    }
    
    .search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    
    .search-input {
        width: 100%;
        padding: 1rem 1.5rem 1rem 3.5rem;
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), 0 10px 30px rgba(0,0,0,0.2);
        background: rgba(15, 23, 42, 0.8);
    }

    /* Accordion Container */
    .accordion-container {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    /* Accordion Item */
    .accordion-item {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .accordion-item:last-child {
        border-bottom: none;
    }

    /* Accordion Header */
    .accordion-header {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #fff;
        font-size: 1.05rem;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .accordion-header:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }
    
    .accordion-header[aria-expanded="true"] {
        background-color: rgba(255, 255, 255, 0.03);
    }

    .acc-title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .acc-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .acc-icon.blue { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    .acc-icon.green { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
    .acc-icon.purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; }
    .acc-icon.yellow { background: rgba(234, 179, 8, 0.15); color: #facc15; }
    .acc-icon.pink { background: rgba(236, 72, 153, 0.15); color: #f472b6; }
    .acc-icon.orange { background: rgba(249, 115, 22, 0.15); color: #fb923c; }

    .acc-chevron {
        color: var(--text-muted);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
    }

    /* Active State Rotation */
    .accordion-header[aria-expanded="true"] .acc-chevron {
        transform: rotate(180deg);
        color: #fff;
    }

    /* Accordion Content */
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: rgba(0, 0, 0, 0.15);
    }

    .accordion-content-inner {
        padding: 0.5rem 2rem 2rem 4rem; /* Indented padding to align with text */
    }

    /* Guide Articles */
    .guide-article {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .guide-article:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .guide-card-title {
        margin-top: 1rem;
        margin-bottom: 1rem;
        font-size: 1.15rem;
        font-weight: 600;
        color: #ffffff;
    }

    .guide-steps {
        padding-left: 1.25rem;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
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

    @media (max-width: 600px) {
        .accordion-content-inner {
            padding: 0.5rem 1.25rem 1.5rem 1.25rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const headers = document.querySelectorAll('.accordion-header');
        const searchInput = document.getElementById('guideSearch');
        const categories = document.querySelectorAll('.guide-category');
        const articles = document.querySelectorAll('.guide-article');
        const searchHeader = document.getElementById('searchResultsHeader');
        const noResults = document.getElementById('noResults');

        // Optional: Open the first one by default
        if(headers.length > 0) {
            const firstHeader = headers[0];
            const firstContent = firstHeader.nextElementSibling;
            firstHeader.setAttribute('aria-expanded', 'true');
            firstContent.style.maxHeight = firstContent.scrollHeight + 'px';
        }

        // Accordion click logic
        headers.forEach(header => {
            header.addEventListener('click', function() {
                // If searching, ignore accordion fold behavior to keep it visible
                if (searchInput.value.trim() !== '') return;

                const content = this.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Close all others
                document.querySelectorAll('.accordion-header').forEach(otherHeader => {
                    if (otherHeader !== this) {
                        otherHeader.setAttribute('aria-expanded', 'false');
                        otherHeader.nextElementSibling.style.maxHeight = null;
                    }
                });

                // Toggle this one
                if (isExpanded) {
                    this.setAttribute('aria-expanded', 'false');
                    content.style.maxHeight = null;
                } else {
                    this.setAttribute('aria-expanded', 'true');
                    content.style.maxHeight = content.scrollHeight + 'px';
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
            
            searchHeader.style.display = 'block';
            let foundAny = false;
            
            categories.forEach(category => {
                let catHasMatches = false;
                const header = category.querySelector('.accordion-header');
                const content = category.querySelector('.accordion-content');
                const localArticles = category.querySelectorAll('.guide-article');
                
                localArticles.forEach(art => {
                    if (art.innerText.toLowerCase().includes(term)) {
                        art.style.display = 'block';
                        catHasMatches = true;
                        foundAny = true;
                    } else {
                        art.style.display = 'none';
                    }
                });
                
                if (catHasMatches) {
                    category.style.display = 'block';
                    // Force open the accordion to show results
                    header.setAttribute('aria-expanded', 'true');
                    content.style.maxHeight = 'none'; // Auto height for search
                } else {
                    category.style.display = 'none';
                    header.setAttribute('aria-expanded', 'false');
                    content.style.maxHeight = null;
                }
            });
            
            if (!foundAny) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
        
        function resetSearch() {
            searchHeader.style.display = 'none';
            noResults.style.display = 'none';
            
            categories.forEach(category => {
                category.style.display = 'block';
                const header = category.querySelector('.accordion-header');
                const content = category.querySelector('.accordion-content');
                
                // Close all by default
                header.setAttribute('aria-expanded', 'false');
                content.style.maxHeight = null;
            });
            
            // Show all articles
            articles.forEach(a => a.style.display = 'block');
            
            // Re-open first one
            if(headers.length > 0) {
                headers[0].setAttribute('aria-expanded', 'true');
                const firstContent = headers[0].nextElementSibling;
                firstContent.style.maxHeight = firstContent.scrollHeight + 'px';
            }
        }

        // Window resize handler to fix maxHeight if screen size changes
        window.addEventListener('resize', function() {
            if (searchInput.value.trim() === '') {
                document.querySelectorAll('.accordion-header[aria-expanded="true"]').forEach(header => {
                    const content = header.nextElementSibling;
                    content.style.maxHeight = 'none';
                    const newHeight = content.scrollHeight;
                    content.style.maxHeight = newHeight + 'px';
                });
            }
        });
    });
</script>
@endsection
