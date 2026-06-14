<x-mail::message>
# Halo!

Terima kasih telah mendaftar di HematCuy. Untuk memverifikasi akun Anda, silakan masukkan kode OTP 6 digit di bawah ini pada halaman verifikasi:

<x-mail::panel>
# {{ $otpCode }}
</x-mail::panel>

Kode ini akan kedaluwarsa dalam 10 menit. Jangan berikan kode ini kepada siapa pun.

Jika Anda tidak merasa mendaftar di aplikasi kami, abaikan saja email ini.

Terima kasih,<br>
Tim {{ config('app.name') }}
</x-mail::message>
