<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();

            // Cegah login hanya jika user baru mendaftar dan belum verifikasi (masih memiliki otp_code)
            // Ini agar akun-akun lama yang mendaftar sebelum sistem OTP dibuat tetap bisa login.
            if (!is_null($user->otp_code)) {
                Auth::logout();
                session(['otp_email' => $user->email]);
                return redirect()->route('otp.verify')->with('success', 'Silakan verifikasi akun Anda terlebih dahulu untuk melanjutkan.');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            if (!is_null($existingUser->otp_code)) {
                // User belum verifikasi OTP, perbarui data & kirim ulang OTP
                $otpCode = sprintf("%06d", mt_rand(1, 999999));
                $existingUser->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'otp_code' => $otpCode,
                    'otp_expires_at' => now()->addMinutes(10),
                ]);

                \Illuminate\Support\Facades\Mail::to($existingUser->email)->send(new \App\Mail\OtpVerificationMail($otpCode));
                session(['otp_email' => $existingUser->email]);

                return redirect()->route('otp.verify')->with('success', 'Akun Anda telah terdaftar namun belum diverifikasi. Kode OTP baru telah dikirimkan ke email Anda.');
            } else {
                return back()->withErrors(['email' => 'Alamat Email sudah terdaftar. Silakan gunakan yang lain.'])->withInput();
            }
        }

        $otpCode = sprintf("%06d", mt_rand(1, 999999));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Kirim email OTP
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($otpCode));

        // Simpan email di session untuk halaman verifikasi
        session(['otp_email' => $user->email]);

        return redirect()->route('otp.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showVerifyOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('register');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('register');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register');
        }

        if ($user->otp_code !== $request->otp_code) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.']);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp_code' => 'Kode OTP telah kedaluwarsa. Silakan minta kode baru.']);
        }

        // Verifikasi sukses
        $user->update([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        // Jika ini adalah user pertama (ID 1), klaim semua data lama yang belum punya pemilik
        if ($user->id === 1) {
            \App\Models\Transaction::whereNull('user_id')->update(['user_id' => $user->id]);
            \App\Models\Note::whereNull('user_id')->update(['user_id' => $user->id]);
        }

        Auth::login($user);
        session()->forget('otp_email');

        return redirect()->intended(route('dashboard'))->with('success', 'Pendaftaran berhasil, selamat datang!');
    }

    public function resendOtp()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('register');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('register');
        }

        $otpCode = sprintf("%06d", mt_rand(1, 999999));
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($otpCode));

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showChangePasswordForm()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.'
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return back()->with('success', 'Kami telah mengirimkan tautan atur ulang password ke email Anda!');
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'token' => 'required'
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetData) {
            return back()->withErrors(['email' => 'Token atur ulang password tidak valid.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password Anda telah berhasil diubah! Silakan login dengan password baru.');
    }
}
