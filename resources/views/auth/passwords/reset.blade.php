<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - HematCuy</title>
    <link rel="icon" href="{{ asset('images/logohematcuy.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #050505; color: #fff; overflow-x: hidden; height: 100vh; display: flex; }
        
        .split-left {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            position: relative;
        }
        
        .split-right {
            width: 50%;
            background: radial-gradient(circle at 70% 30%, #0d1e3d 0%, #050505 80%);
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 4rem;
            overflow: hidden;
        }
        
        @keyframes floatAuth {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .right-text {
            position: relative;
            z-index: 10;
        }
        .right-text h2 { font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem; letter-spacing: -1px; }
        .right-text p { font-size: 1.1rem; color: #a1a1aa; }
        
        .auth-container { max-width: 400px; width: 100%; margin: 0 auto; display: flex; flex-direction: column; justify-content: center; height: 100%; }
        
        .logo-nav { 
            display: flex; align-items: center; gap: 0.5rem; 
            font-size: 1.25rem; font-weight: 800; text-decoration: none; color: #fff; 
            margin-bottom: 2rem;
        }
        
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: #d4d4d8; font-weight: 500; }
        
        .form-control { 
            width: 100%; padding: 0.85rem 1rem; border-radius: 12px; 
            border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03); 
            color: white; outline: none; transition: all 0.3s; 
        }
        .form-control:focus { border-color: #3b82f6; background: rgba(59,130,246,0.05); }

        /* Fix Browser Autofill White Background in Dark Mode */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0a0a0a inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        
        .btn-primary { 
            width: 100%; padding: 0.85rem; border-radius: 999px; 
            background: #3b82f6; color: white; border: none; 
            font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.3s; 
        }
        .btn-primary:hover { background: #2563eb; transform: translateY(-2px); box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }
        
        @media (max-width: 1024px) {
            .split-left { width: 100%; padding: 2rem; }
            .split-right { display: none; }
        }
    </style>
</head>
<body>

    <div class="split-left">
        <div class="auth-container">
            <a href="/" class="logo-nav">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                HematCuy
            </a>

            <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Buat Password Baru 🛡️</h2>
            <p style="color: #a1a1aa; font-size: 0.95rem; margin-bottom: 2.5rem;">Silakan buat password baru Anda yang kuat dan mudah diingat.</p>

            @php
                $filteredErrors = collect($errors->messages())->except('password')->flatten();
            @endphp
            @if($filteredErrors->count() > 0)
            <div style="background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #f43f5e; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ $filteredErrors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" onsubmit="return validateForm(this, event)">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label for="email">Email Terdaftar</label>
                    <input id="email" type="email" name="email" value="{{ request('email') ?? old('email') }}" required class="form-control" placeholder="nama@email.com">
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <div style="position: relative;">
                        <input id="password" type="password" name="password" required class="form-control" placeholder="••••••••" onkeyup="checkPassword(this.value)">
                        <span onclick="togglePassword('password', this)" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #a1a1aa; display: flex; align-items: center;">
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </span>
                    </div>
                    <div id="password-checklist" style="margin-top: 10px; font-size: 0.75rem; color: #a1a1aa; display: flex; flex-wrap: wrap; row-gap: 8px; column-gap: 12px;">
                        <div id="check-length" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Minimal 8 karakter</div>
                        <div id="check-upper" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Huruf Besar & Kecil</div>
                        <div id="check-number" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Angka</div>
                        <div id="check-symbol" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Simbol (@, #, !)</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div style="position: relative;">
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control" placeholder="••••••••">
                        <span onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #a1a1aa; display: flex; align-items: center;">
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 1rem;">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
    
    <div class="split-right">
        <!-- Floating UI Elements -->
        <div style="position: absolute; top: 8%; right: 12%; z-index: 20; animation: floatAuth 7s infinite ease-in-out;">
            <div style="background: rgba(20,20,20,0.85); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 0.75rem 1rem; backdrop-filter: blur(10px); width: 220px; box-shadow: 0 15px 30px rgba(0,0,0,0.4); display: flex; align-items: center; gap: 0.75rem;">
                <div style="background: #3b82f6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem; letter-spacing: -0.2px;">Catat Struk</div>
                    <div style="font-size: 0.75rem; color: #a1a1aa; line-height: 1.2;">Scan otomatis, praktis</div>
                </div>
            </div>
        </div>

        <div style="position: absolute; top: 22%; left: 15%; z-index: 20; animation: floatAuth 6s infinite ease-in-out reverse;">
            <div style="background: rgba(20,20,20,0.85); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 0.75rem 1rem; backdrop-filter: blur(10px); width: 220px; box-shadow: 0 15px 30px rgba(0,0,0,0.4); display: flex; align-items: center; gap: 0.75rem;">
                <div style="background: #10b981; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem; letter-spacing: -0.2px;">Alokasi Uang</div>
                    <div style="font-size: 0.75rem; color: #a1a1aa; line-height: 1.2;">Budgeting gaji bulanan</div>
                </div>
            </div>
        </div>

        <div style="position: absolute; top: 35%; right: 18%; z-index: 20; animation: floatAuth 8s infinite ease-in-out;">
            <div style="background: rgba(20,20,20,0.85); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 0.75rem 1rem; backdrop-filter: blur(10px); width: 220px; box-shadow: 0 15px 30px rgba(0,0,0,0.4); display: flex; align-items: center; gap: 0.75rem;">
                <div style="background: #f59e0b; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a10 10 0 0 1 10 10c0 5.5-4.5 10-10 10S2 17.5 2 12 6.5 2 12 2Z"/><path d="M12 12v.01"/><path d="M12 16v.01"/><path d="M12 8v.01"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem; letter-spacing: -0.2px;">Target Harian</div>
                    <div style="font-size: 0.75rem; color: #a1a1aa; line-height: 1.2;">Batasi pengeluaran</div>
                </div>
            </div>
        </div>

        <div style="position: absolute; top: 48%; left: 12%; z-index: 20; animation: floatAuth 7.5s infinite ease-in-out reverse;">
            <div style="background: rgba(20,20,20,0.85); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 0.75rem 1rem; backdrop-filter: blur(10px); width: 220px; box-shadow: 0 15px 30px rgba(0,0,0,0.4); display: flex; align-items: center; gap: 0.75rem;">
                <div style="background: #8b5cf6; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                </div>
                <div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem; letter-spacing: -0.2px;">Laporan Visual</div>
                    <div style="font-size: 0.75rem; color: #a1a1aa; line-height: 1.2;">Grafik arus kas ringkas</div>
                </div>
            </div>
        </div>

        <div class="right-text" style="width: 100%; z-index: 10;">
            <h2 style="font-size: 2.75rem; font-weight: 800; color: #ffffff; line-height: 1.1; margin-bottom: 1.25rem; letter-spacing: -1px;">
                Amankan kembali <br>akun Anda.
            </h2>
            <p style="font-size: 1.2rem; color: #a1a1aa; line-height: 1.6; max-width: 480px;">
                Gunakan kombinasi yang unik agar keuangan Anda tetap aman.
            </p>
        </div>
    </div>

    <script>
    function togglePassword(inputId, iconSpan) {
        const input = document.getElementById(inputId);
        const icon = iconSpan.querySelector('.eye-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
        }
    }

    function checkPassword(val) {
        const length = val.length >= 8;
        const upper = /[A-Z]/.test(val) && /[a-z]/.test(val);
        const number = /[0-9]/.test(val);
        const symbol = /[^A-Za-z0-9]/.test(val);

        updateCheck('check-length', length);
        updateCheck('check-upper', upper);
        updateCheck('check-number', number);
        updateCheck('check-symbol', symbol);
    }

    function updateCheck(id, isValid) {
        const el = document.getElementById(id);
        if (!el) return;
        const svg = el.querySelector('svg');
        if (isValid) {
            el.style.color = '#10b981'; // Green
            svg.innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
            svg.style.stroke = '#10b981';
        } else {
            el.style.color = '#a1a1aa'; // Gray
            svg.innerHTML = '<circle cx="12" cy="12" r="10"/>';
            svg.style.stroke = 'currentColor';
        }
    }

    function validateForm(form, e) {
        const val = document.getElementById('password').value;
        const length = val.length >= 8;
        const upper = /[A-Z]/.test(val) && /[a-z]/.test(val);
        const number = /[0-9]/.test(val);
        const symbol = /[^A-Za-z0-9]/.test(val);

        if (!length || !upper || !number || !symbol) {
            e.preventDefault();
            if (!length) turnRed('check-length');
            if (!upper) turnRed('check-upper');
            if (!number) turnRed('check-number');
            if (!symbol) turnRed('check-symbol');
            
            document.getElementById('password').focus();
            return false;
        }

        const btn = form.querySelector('button[type=submit]');
        btn.disabled = true;
        btn.innerHTML = 'Memeriksa...';
        return true;
    }

    function turnRed(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const svg = el.querySelector('svg');
        el.style.color = '#f43f5e'; // Red
        svg.innerHTML = '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>';
        svg.style.stroke = '#f43f5e';
    }
    </script>
    @include('components.toast')
</body>
</html>
