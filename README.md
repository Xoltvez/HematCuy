# 💸 HematCuy

**HematCuy** adalah aplikasi pencatatan keuangan pribadi berbasis web yang dikembangkan menggunakan **Laravel**. Aplikasi ini didesain dengan antarmuka modern, elegan, dan *user-friendly* untuk membantu pengguna melacak pengeluaran, merencanakan anggaran bulanan, dan mencapai tujuan finansial (wishlist) dengan lebih mudah.

![HematCuy Dashboard](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)
*(Ganti gambar ini dengan screenshot dashboard aplikasi Anda)*

---

## 🌟 Fitur Utama

- **📊 Dashboard Analitik**: Tampilan ringkas berisi total saldo (Tunai & Bank), grafik pengeluaran mingguan/bulanan, serta riwayat transaksi terbaru.
- **📝 Catat Transaksi**: Catat setiap arus kas masuk (Pemasukan) dan arus kas keluar (Pengeluaran) secara detail berdasarkan kategori.
- **🎯 Budgeting (Alokasi Dana)**: Tetapkan alokasi anggaran bulanan untuk setiap kategori (makanan, transportasi, dll) dan pantau persentase penggunaannya.
- **📖 Hutang & Piutang**: Kelola uang yang dipinjamkan ke orang lain (Piutang) dan uang pinjaman Anda (Hutang), lengkap dengan sistem pembayaran cicilan.
- **🎁 Wishlist (Tabungan Impian)**: Rencanakan pembelian barang impian Anda. Anda dapat mencicil tabungan ke dalam wishlist hingga target tercapai.
- **📑 Laporan Keuangan**: Unduh atau lihat laporan pengeluaran & pemasukan secara detail untuk mengevaluasi kondisi finansial.
- **📒 Catatan Keuangan**: Tulis catatan ringan atau pengingat seputar keuangan Anda (misal: "Bayar listrik tanggal 20!").

---

## 🚀 Teknologi yang Digunakan

- **Framework**: [Laravel 11](https://laravel.com)
- **Database**: MySQL / SQLite (Sesuai konfigurasi env)
- **Styling**: Custom CSS dengan desain *Glassmorphism* & *Modern Dark-Mode* UI.
- **Icons**: SVG & FeatherIcons.

---

## 🛠️ Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan HematCuy di komputer lokal Anda:

### Persyaratan
- PHP >= 8.2
- Composer
- Node.js & NPM (Opsional jika ingin memodifikasi aset)
- Database Server (MySQL/MariaDB)

### Langkah Instalasi

1. **Clone repositori ini**
   ```bash
   git clone https://github.com/Xoltvez/HematCuy.git
   cd HematCuy
   ```

2. **Install dependensi PHP via Composer**
   ```bash
   composer install
   ```

3. **Salin file environment & generate key**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Buka file `.env` dan sesuaikan kredensial database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hematcuy
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *Note: Pastikan Anda sudah membuat database kosong bernama `hematcuy` di MySQL Anda.*

5. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate
   ```

6. **Jalankan Development Server**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada `http://localhost:8000`.

---

## 💡 Keunggulan HematCuy

- **Sistem Saldo Terintegrasi**: Mencatat pengeluaran, hutang-piutang, maupun wishlist secara otomatis akan langsung memotong/menambah Saldo Kas & Bank Anda, sehingga Anda selalu mendapatkan data *real-time*.
- **Peringatan Saldo Minus**: Mencegah input transaksi yang melampaui sisa uang Anda, memastikan validitas cash-flow.
- **Desain Premium**: Pendekatan UI/UX yang *clean*, tidak membosankan, dilengkapi dengan *micro-animations* untuk pengalaman pengguna yang interaktif.

---

## 📄 Lisensi

Aplikasi ini bersifat *open-sourced* dan dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
