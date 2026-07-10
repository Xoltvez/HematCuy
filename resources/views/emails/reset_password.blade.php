<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #050505; color: #ffffff; padding: 40px 20px; margin: 0; -webkit-font-smoothing: antialiased;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #050505;">
        <tr>
            <td align="center">
                <table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #111111; padding: 40px; border-radius: 16px; border: 1px solid #27272a; text-align: left;" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <h2 style="color: #60a5fa; font-size: 26px; font-weight: 800; margin: 0; letter-spacing: -0.5px;">HematCuy</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 16px; color: #ffffff; margin-bottom: 16px; font-weight: 600;">Halo,</p>
                            <p style="font-size: 15px; color: #a1a1aa; line-height: 1.6; margin-bottom: 30px;">
                                Anda menerima email ini karena kami menerima permintaan untuk mereset kata sandi akun HematCuy Anda.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px 0 40px 0;">
                            <a href="{{ url('reset-password/'.$token) }}" style="background-color: #3b82f6; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 12px; font-weight: 600; font-size: 15px; display: inline-block;">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 14px; color: #a1a1aa; line-height: 1.6; margin-bottom: 16px;">
                                Tautan reset password ini akan kedaluwarsa dalam <strong>60 menit</strong>.
                            </p>
                            <p style="font-size: 14px; color: #a1a1aa; line-height: 1.6; margin-bottom: 32px;">
                                Jika Anda tidak merasa membuat permintaan ini, abaikan saja email ini. Akun Anda tetap aman dan tidak ada tindakan lebih lanjut yang diperlukan.
                            </p>
                            <div style="border-top: 1px solid #27272a; margin-bottom: 24px;"></div>
                            <p style="font-size: 15px; color: #ffffff; margin: 0; font-weight: 500;">Salam hangat,</p>
                            <p style="font-size: 15px; color: #60a5fa; margin-top: 6px; font-weight: 600;">Tim HematCuy</p>
                        </td>
                    </tr>
                </table>
                <table style="max-width: 600px; width: 100%; margin: 0 auto;" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" style="padding-top: 24px;">
                            <p style="font-size: 12px; color: #52525b;">© {{ date('Y') }} HematCuy. Hak Cipta Dilindungi.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
