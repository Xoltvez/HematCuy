<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP HematCuy</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a; color: #f8fafc;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #0f172a; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="600" cellpadding="0" cellspacing="0" style="background-color: #1e293b; border-radius: 16px; margin: 0 auto; max-width: 600px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
                    <tr>
                        <td align="center" style="padding: 40px 0; background: #2563eb;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 800; letter-spacing: 1px;">HematCuy</h1>
                            <p style="color: rgba(255,255,255,0.8); margin: 5px 0 0 0; font-size: 14px;">Smart Personal Budgeting</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #f8fafc; margin: 0 0 20px 0; font-size: 20px;">Halo! 👋</h2>
                            <p style="color: #cbd5e1; font-size: 16px; line-height: 1.6; margin: 0 0 30px 0;">
                                Terima kasih telah bergabung di HematCuy! Untuk melengkapi proses registrasi dan melindungi akun Anda, silakan masukkan kode verifikasi (OTP) berikut:
                            </p>
                            
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <div style="background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px 40px; display: inline-block;">
                                            <span style="font-family: 'Courier New', Courier, monospace; font-size: 36px; font-weight: bold; color: #38bdf8; letter-spacing: 8px;">{{ $otpCode }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin: 30px 0 0 0; text-align: center;">
                                Kode ini hanya berlaku selama <b>10 menit</b>.<br>
                                Jangan berikan kode ini kepada siapapun demi keamanan akun Anda.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px; background-color: rgba(0,0,0,0.2); border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
                            <p style="color: #64748b; font-size: 12px; margin: 0;">
                                Jika Anda tidak merasa mendaftar di HematCuy, abaikan dan hapus email ini.<br>
                                &copy; {{ date('Y') }} HematCuy. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
