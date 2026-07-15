<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - HematCuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d1117;
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
        <h1>Terms & Conditions</h1>
        <p>Terakhir diperbarui: {{ date('d F Y') }}</p>

        <div class="card">
            <h2>1. Pendahuluan</h2>
            <p>Selamat datang di HematCuy. Dengan mengakses atau menggunakan website HematCuy, Anda setuju untuk terikat oleh Syarat & Ketentuan ini.</p>

            <h2>2. Penggunaan Website</h2>
            <p>HematCuy adalah perangkat lunak untuk membantu Anda mencatat dan mengelola anggaran keuangan pribadi. Kami tidak menyediakan layanan perbankan, penyimpangan uang tunai, investasi, atau nasihat keuangan profesional.</p>
            <ul>
                <li>Anda bertanggung jawab penuh atas keakuratan data keuangan yang Anda masukkan.</li>
                <li>Anda wajib menjaga kerahasiaan kata sandi dan akun Anda.</li>
                <li>Anda setuju untuk tidak menyalahgunakan sistem kami, seperti melakukan peretasan (hacking) atau merusak server.</li>
            </ul>

            <h2>3. Layanan Pihak Ketiga</h2>
            <p>Website ini mungkin memuat tautan atau layanan dari pihak ketiga. Kami tidak bertanggung jawab atas ketersediaan, isi, atau kebijakan dari pihak ketiga tersebut.</p>

            <h2>4. Batasan Tanggung Jawab</h2>
            <p>HematCuy disediakan "sebagaimana adanya". Kami tidak menjamin bahwa website ini akan selalu bebas dari kesalahan, bug, atau gangguan. Kami tidak bertanggung jawab atas kerugian finansial yang diakibatkan oleh kesalahan pencatatan atau masalah sistem.</p>

            <h2>5. Perubahan Syarat & Ketentuan</h2>
            <p>Kami berhak untuk mengubah Terms & Conditions ini sewaktu-waktu. Perubahan akan berlaku seketika setelah diperbarui di halaman ini. Anda diharapkan untuk mengecek halaman ini secara berkala.</p>

            <h2>6. Kontak</h2>
            <p>Jika Anda memiliki pertanyaan seputar syarat dan ketentuan ini, silakan hubungi kami melalui email di hematcuy@gmail.com.</p>
        </div>
    </div>
</body>

</html>