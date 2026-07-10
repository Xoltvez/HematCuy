@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding-top: 2rem;">
    
    <div style="margin-bottom: 2rem;">
        <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700;">Ubah Password 🔒</h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem;">Pastikan akun Anda tetap aman dengan menggunakan kombinasi password yang kuat.</p>
    </div>

    @if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        
        <form method="POST" action="{{ route('password.change') }}" onsubmit="return validateForm(this, event)">
            @csrf

            <!-- Current Password -->
            <div style="margin-bottom: 1.5rem;">
                <label for="current_password" style="display: block; font-size: 0.9rem; font-weight: 500; color: var(--text-muted); margin-bottom: 0.5rem;">Password Saat Ini</label>
                <div style="position: relative;">
                    <input type="password" id="current_password" name="current_password" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: var(--text-main); font-size: 0.95rem; outline: none; transition: all 0.2s;" required>
                    <span onclick="togglePassword('current_password', this)" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #a1a1aa; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </span>
                </div>
                @error('current_password')
                    <div style="color: #fb7185; font-size: 0.8rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- New Password -->
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; font-size: 0.9rem; font-weight: 500; color: var(--text-muted); margin-bottom: 0.5rem;">Password Baru</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: var(--text-main); font-size: 0.95rem; outline: none; transition: all 0.2s;" required onkeyup="checkPassword(this.value)">
                    <span onclick="togglePassword('password', this)" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #a1a1aa; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </span>
                </div>
                <div id="password-checklist" style="margin-top: 10px; font-size: 0.75rem; color: #a1a1aa; display: flex; flex-wrap: wrap; row-gap: 8px; column-gap: 12px;">
                    <div id="check-length" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Minimal 8 karakter</div>
                    <div id="check-upper" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Huruf Besar & Kecil</div>
                    <div id="check-number" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Angka</div>
                    <div id="check-symbol" style="display: flex; align-items: center; gap: 6px; transition: 0.3s;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg> Simbol (@, #, !)</div>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div style="margin-bottom: 2rem;">
                <label for="password_confirmation" style="display: block; font-size: 0.9rem; font-weight: 500; color: var(--text-muted); margin-bottom: 0.5rem;">Ulangi Password Baru</label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: var(--text-main); font-size: 0.95rem; outline: none; transition: all 0.2s;" required>
                    <span onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #a1a1aa; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; border-radius: var(--radius-md); font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.5rem; border: none; cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                Simpan Password Baru
            </button>
        </form>

    </div>
</div>

<script>
    function togglePassword(inputId, el) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            el.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>';
        } else {
            input.type = 'password';
            el.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>';
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
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Menyimpan...';
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

<style>
    .form-control:focus {
        border-color: #3b82f6 !important;
        background: rgba(59, 130, 246, 0.05) !important;
    }
</style>
@endsection
