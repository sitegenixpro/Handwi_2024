<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Vendor Account Created</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; background-color:#000; color:#000;">
    <div style="padding: 20px; background-color: #000;">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background:#eee; border-radius:10px; overflow:hidden;">
                        <tr>
                            <td align="center" >
                                <img src="{{ asset('admin-assets/assets/img/handwi-logo-blac.png') }}" alt="Handwi" style="max-width: 190px;">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 30px; background: #ffffff;">
                                <h2 style="color: #000; font-size: 20px;">Vendor Registration Received</h2>
                                <p style="color: #000; font-size: 14px;">Hello {{ $name }},</p>
                                <p style="color: #000; font-size: 14px; line-height: 22px;">
                                    Your vendor account has been created successfully on {{ env('APP_NAME') }}.
                                    Our team will review your application and notify you once your account is activated.
                                </p>
                                <p style="color: #000; font-size: 14px;">
                                    Thank you for your interest in partnering with us.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="background:#eee; padding: 20px;">
                            <p style="color: #000; margin-top: 20px;">
                                                                            <a href="{{ route('seller-policy') }}" style=" text-decoration: none; margin-right: 15px;">Seller Policy</a>
                                                                            <a href="{{ route('handwi-payment-policy') }}" style=" text-decoration: none;">Handwi Payment Policy</a>
                                                                        </p>
                                <p style="color: #000;">&copy; {{ date('Y') }} {{ env('APP_NAME') }} . All rights reserved.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
