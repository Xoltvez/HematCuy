<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - HematCuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0A0A0A;
            --text-main: #FFFFFF;
            --text-muted: #A1A1AA;
            --accent-blue: #3b82f6;
            --surface: #111111;
            --border-color: #27272A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 40px;
            margin-top: 20px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #fff;
        }

        h2 {
            font-size: 1.5rem;
            margin-top: 30px;
            margin-bottom: 15px;
            color: var(--accent-blue);
        }

        p {
            margin-bottom: 15px;
            color: var(--text-muted);
        }

        ul {
            margin-left: 20px;
            margin-bottom: 15px;
            color: var(--text-muted);
        }

        li {
            margin-bottom: 5px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .back-btn:hover {
            opacity: 0.8;
            transform: translateX(-5px);
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="/" class="back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Kembali ke Beranda
        </a>
        <h1>Privacy Policy</h1>
        <p>Terakhir diperbarui: {{ date('d F Y') }}</p>

        <div class="card">
            <h2>1. Informasi yang Kami Kumpulkan</h2>
            <p>Untuk memberikan pengalaman terbaik di HematCuy, kami mungkin mengumpulkan informasi berikut:</p>
            <ul>
                <li><strong>Informasi Akun:</strong> Nama, alamat email, dan kata sandi saat Anda mendaftar.</li>
                <li><strong>Data Keuangan:</strong> Nominal transaksi, kategori pengeluaran/pemasukan, dan daftar keinginan (wishlist) yang Anda input secara sadar ke dalam website.</li>
                <li><strong>Data Teknis:</strong> Alamat IP, jenis peramban (browser), dan data log sistem untuk keperluan keamanan.</li>
            </ul>

            <h2>2. Bagaimana Kami Menggunakan Informasi Anda</h2>
            <p>Data yang kami kumpulkan hanya digunakan untuk:</p>
            <ul>
                <li>Mengoperasikan dan mengelola fitur pencatatan keuangan pribadi Anda di dalam website HematCuy.</li>
                <li>Meningkatkan pengalaman pengguna dan memantau kinerja keamanan website.</li>
                <li>Mengirimkan email terkait akun (seperti kode OTP dan reset password).</li>
            </ul>

            <h2>3. Perlindungan dan Keamanan Data</h2>
            <p>Kami sangat menghargai privasi Anda. Kata sandi Anda dienkripsi secara ketat di dalam sistem kami. Kami menerapkan langkah-langkah keamanan teknis standar industri untuk melindungi data keuangan Anda dari akses yang tidak sah, pengubahan, atau kebocoran.</p>

            <h2>4. Berbagi Data dengan Pihak Ketiga</h2>
            <p>Kami <strong>tidak pernah menjual, menyewakan, atau membagikan</strong> data keuangan pribadi Anda kepada pihak ketiga untuk tujuan pemasaran. Kami hanya akan mengungkapkan informasi jika diwajibkan oleh hukum atau permintaan resmi otoritas pemerintah.</p>

            <h2>5. Hak Anda atas Data</h2>
            <p>Anda memegang kendali penuh atas data Anda. Anda berhak untuk mengedit atau menghapus seluruh catatan keuangan Anda. Jika Anda ingin menghapus akun dan semua data Anda secara permanen dari server kami, Anda dapat menghubungi tim dukungan kami.</p>

            <h2>6. Hubungi Kami</h2>
            <p>Jika Anda memiliki pertanyaan lebih lanjut mengenai kebijakan privasi ini, jangan ragu untuk menghubungi kami melalui email di hematcuy@gmail.com.</p>
        </div>
    </div>
</body>

</html>