@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="margin-bottom: 2rem;">
        <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #ffffff;">Panduan Penggunaan</h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem;">Pelajari cara memaksimalkan seluruh fitur-fitur pintar di HematCuy.</p>
    </div>

    <div class="guide-layout">
        <!-- Sidebar Menu Panduan -->
        <div class="guide-sidebar">
            <ul id="guide-menu" style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.5rem;">
                <li>
                    <button class="guide-tab-btn active" data-target="daftar-login">
                        Daftar & Login
                    </button>
                </li>
                <li>
                    <button class="guide-tab-btn" data-target="catat-transaksi">
                        Catat Transaksi
                    </button>
                </li>
                <li>
                    <button class="guide-tab-btn" data-target="budgeting">
                        Budgeting (Pos Anggaran)
                    </button>
                </li>
                <li>
                    <button class="guide-tab-btn" data-target="tabungan">
                        Tabungan & Wishlist
                    </button>
                </li>
                <li>
                    <button class="guide-tab-btn" data-target="catat-struk">
                        Catat Struk AI
                    </button>
                </li>

                <li>
                    <button class="guide-tab-btn" data-target="faq">
                        FAQ & Bantuan
                    </button>
                </li>
            </ul>
        </div>

        <!-- Konten Panduan -->
        <div class="guide-content-area">
            
            <!-- Daftar & Login Content -->
            <div id="daftar-login-content" class="guide-content" style="display: block;">
                <div class="guide-card premium-glow-card">
                    <h3 class="guide-card-title">📝 Cara Daftar Akun</h3>
                    <ol class="guide-steps">
                        <li>Buka halaman awal HematCuy dan klik tombol <strong>Daftar</strong>.</li>
                        <li>Masukkan <strong>Nama Panggilan</strong>, <strong>Alamat Email</strong>, dan buat <strong>Password</strong> Anda.</li>
                        <li>Ulangi password di kolom konfirmasi dengan benar.</li>
                        <li>Klik tombol <strong>Daftar Sekarang</strong> untuk menyelesaikan registrasi.</li>
                        <li>Setelah terdaftar, Anda akan diarahkan masuk ke Dashboard utama.</li>
                    </ol>
                </div>

                <div class="guide-card premium-glow-card">
                    <h3 class="guide-card-title">🔑 Cara Login</h3>
                    <ol class="guide-steps">
                        <li>Buka halaman awal HematCuy dan klik tombol <strong>Masuk</strong>.</li>
                        <li>Masukkan <strong>Email</strong> dan <strong>Password</strong> akun terdaftar Anda.</li>
                        <li>Centang opsi "Ingat Saya" jika ingin tetap masuk otomatis di browser.</li>
                        <li>Klik tombol <strong>Masuk ke Dashboard</strong>.</li>
                    </ol>
                </div>

                <div class="guide-card premium-glow-card">
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
            <div id="catat-transaksi-content" class="guide-content" style="display: none;">
                <div class="guide-card premium-glow-card">
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

                <div class="guide-card premium-glow-card">
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
            <div id="budgeting-content" class="guide-content" style="display: none;">
                <div class="guide-card premium-glow-card">
                    <h3 class="guide-card-title">📊 Mengatur Budgeting Pos Anggaran</h3>
                    <ol class="guide-steps">
                        <li>Masuk ke menu <strong>Budgeting</strong> dari sidebar menu sebelah kiri.</li>
                        <li>Simpan <strong>Total Gaji/Uang Masuk</strong> Anda bulan ini di form <strong>Total Gaji Bulan Ini</strong> sebelah kiri.</li>
                        <li>Di bawahnya, isi form <strong>Buat Pos Pengeluaran</strong> (misal: Kategori "Makanan", Target Rp 1.000.000).</li>
                        <li>Klik <strong>Simpan Alokasi</strong>. Pos baru Anda akan muncul di sebelah kanan.</li>
                        <li><strong>Otomasi</strong>: Setiap kali Anda mencatat transaksi manual dengan kategori yang sama (misal: "Makanan"), sisa anggaran pada kartu budget Anda akan <strong>otomatis berkurang</strong> serta menampilkan persentase secara real-time.</li>
                    </ol>
                </div>

                <div class="guide-card premium-glow-card">
                    <h3 class="guide-card-title">🔔 Notifikasi Batas Anggaran & Insight AI</h3>
                    <ol class="guide-steps">
                        <li>Pos anggaran akan berubah warna menjadi <strong>Kuning (Warning)</strong> jika pengeluaran Anda menyentuh 80% dari target.</li>
                        <li>Pos anggaran akan berubah menjadi <strong>Merah (Danger)</strong> dan berdenyut jika melampaui 100% (Overbudget).</li>
                        <li><strong>AI Insight</strong>: Sistem secara cerdas akan menganalisis kecepatan pengeluaran harian (*burn rate*) Anda dan memprediksi sisa hari sebelum anggaran habis.</li>
                    </ol>
                </div>
            </div>

            <!-- Tabungan & Wishlist Content -->
            <div id="tabungan-content" class="guide-content" style="display: none;">
                <div class="guide-card premium-glow-card">
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
            <div id="catat-struk-content" class="guide-content" style="display: none;">
                <div class="guide-card premium-glow-card">
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
            <div id="faq-content" class="guide-content" style="display: none;">
                <div class="guide-card premium-glow-card">
                    <h3 class="guide-card-title">❓ Mengapa progress budget saya tidak terpotong otomatis?</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                        Hal ini terjadi karena <strong>kategori transaksi tidak sama persis</strong> dengan nama pos budgeting. 
                        Pastikan saat mencatat transaksi manual, Anda memasukkan nama kategori yang sama persis huruf besar-kecilnya dengan nama pos pengeluaran di menu Budgeting (contoh: jika nama pos budget adalah <strong>"Makan"</strong>, pastikan kategori transaksi ditulis <strong>"Makan"</strong>, bukan "makanan" atau "makan siang").
                    </p>
                </div>

                <div class="guide-card premium-glow-card">
                    <h3 class="guide-card-title">🔒 Apakah data keuangan saya aman di HematCuy?</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                        Keamanan data Anda adalah prioritas kami. Semua informasi transaksi, gaji, dan tabungan Anda diamankan di server database kami yang terenkripsi dan hanya dapat diakses melalui kredensial login akun unik milik Anda.
                    </p>
                </div>

                <div class="guide-card premium-glow-card">
                    <h3 class="guide-card-title">🖨️ Bagaimana cara mencetak laporan transaksi?</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                        Buka menu <strong>Laporan</strong> atau <strong>Riwayat</strong>, filter rentang tanggal transaksi yang ingin dicetak, lalu tekan tombol merah muda <strong>Cetak PDF</strong> di sudut kanan atas halaman. Sistem akan menghasilkan file dokumen siap cetak.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Layout styling untuk Guide Split-Page */
    .guide-layout {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .guide-sidebar {
        width: 280px;
        flex-shrink: 0;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1rem;
        align-self: flex-start;
        position: sticky;
        top: 100px;
    }

    .guide-tab-btn {
        width: 100%;
        text-align: left;
        padding: 0.8rem 1rem;
        border-radius: var(--radius-md);
        border: none;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .guide-tab-btn:hover {
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-main);
    }

    .guide-tab-btn.active {
        background: #3b82f6;
        color: #fff;
    }

    .guide-content-area {
        flex: 1;
        min-width: 320px;
    }

    .guide-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
    }

    .guide-card-title {
        margin-top: 0;
        margin-bottom: 1.25rem;
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff;
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

    @media (max-width: 768px) {
        .guide-layout {
            flex-direction: column;
            gap: 1.5rem;
        }

        .guide-sidebar {
            width: 100%;
            position: static;
        }
        
        .guide-card {
            padding: 1.5rem;
        }
    }
</style>

<script>
    // Tab switcher logic
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.guide-tab-btn');
        const contents = document.querySelectorAll('.guide-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active classes
                tabBtns.forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');

                // Hide all contents
                contents.forEach(c => c.style.display = 'none');

                // Show target content
                const targetId = this.getAttribute('data-target') + '-content';
                const targetContent = document.getElementById(targetId);
                if (targetContent) {
                    targetContent.style.display = 'block';
                }
            });
        });
    });
</script>
@endsection
