@extends('layouts.app')

@section('title', 'Verifikasi OTP - HematCuy')

@section('content')
<div class="auth-container" style="max-width: 400px; margin: 2rem auto; padding: 2rem; background: var(--surface-color); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--shadow-md);">
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; background: linear-gradient(135deg, #2563eb, #60a5fa); -webkit-background-clip: text; color: transparent;">Verifikasi OTP</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            Masukkan 6 digit kode yang telah kami kirimkan ke email <strong>{{ session('otp_email') }}</strong>
        </p>
    </div>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; font-size: 0.9rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; font-size: 0.9rem;">
            @foreach ($errors->all() as $error)
                <p style="margin: 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify.submit') }}">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="otp_code" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; text-align: center;">Kode OTP</label>
            <input id="otp_code" type="text" name="otp_code" required autofocus maxlength="6" pattern="\d{6}" placeholder="123456" 
                style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(15, 23, 42, 0.5); color: white; font-size: 1.5rem; letter-spacing: 0.5rem; text-align: center;">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.8rem; border-radius: var(--radius-md); font-weight: 600;">
            Verifikasi Akun
        </button>
    </form>
    
    <form method="POST" action="{{ route('otp.resend') }}" style="margin-top: 1.5rem; text-align: center;">
        @csrf
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">Tidak menerima email atau kode kedaluwarsa?</p>
        <button type="submit" style="background: transparent; border: none; color: #60a5fa; cursor: pointer; text-decoration: underline; font-size: 0.85rem;">
            Kirim Ulang Kode OTP
        </button>
    </form>
    
    <div style="margin-top: 1.5rem; text-align: center; border-top: 1px solid var(--border-color); padding-top: 1rem;">
        <a href="{{ route('login') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; transition: color 0.2s ease;">
            &larr; Kembali ke Login
        </a>
    </div>
</div>
@endsection
