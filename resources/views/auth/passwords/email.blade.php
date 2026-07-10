<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - HematCuy</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2360a5fa' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4'/%3E%3Cpath d='M4 6v12c0 1.1.9 2 2 2h14v-4'/%3E%3Cpath d='M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z'/%3E%3C/svg%3E">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #050505;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: radial-gradient(circle at center, #111827 0%, #050505 100%);
            padding: 1rem;
        }

        .card {
            background: #111111;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 3.5rem 3rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .logo-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.6rem;
            font-weight: 800;
            text-decoration: none;
            color: #fff;
            margin-bottom: 2.5rem;
            justify-content: center;
        }

        .title {
            font-size: 1.65rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: #fff;
        }

        .subtitle {
            color: #a1a1aa;
            font-size: 1rem;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
            color: #fff;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.03);
            color: white;
            outline: none;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
        }

        .form-control::placeholder {
            color: #52525b;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0a0a0a inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .btn-primary {
            width: 100%;
            padding: 0.9rem;
            border-radius: 12px;
            background: #3b82f6;
            color: white;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 2rem;
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .back-link {
            color: #a1a1aa;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
        }

        .back-link:hover {
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="card">
        <a href="/" class="logo-nav">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4" />
                <path d="M4 6v12c0 1.1.9 2 2 2h14v-4" />
                <path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z" />
            </svg>
            HematCuy
        </a>

        <h2 class="title">Pulihkan Kata Sandi 👋</h2>
        <p class="subtitle">Lupa kata sandi? Tidak masalah. Cukup masukkan alamat email kamu di bawah ini, dan kami akan mengirimkan tautan pemulihan.</p>

        @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; text-align: left;">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div style="background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #f43f5e; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; text-align: left;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Tunggu sebentar...';">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="masukkan email terdaftar kamu">
            </div>

            <button type="submit" class="btn-primary">
                Kirim Tautan Pemulihan
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            &larr; Kembali ke halaman login
        </a>
    </div>

    @include('components.toast')
</body>

</html>