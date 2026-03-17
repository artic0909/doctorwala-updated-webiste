<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Doctorwala.info</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Inter', system-ui, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f3f4f6; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="500" border="0" cellspacing="0" cellpadding="0" style="max-width: 500px; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: #1e293b; padding: 30px 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 800;">Doctorwala.info</h1>
                            <p style="color: #94a3b8; margin: 5px 0 0; font-size: 11px; text-transform: uppercase; letter-spacing: 2px;">Official Welcome Pack</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #111827; margin-top: 0; font-size: 20px; font-weight: 700;">Welcome, {{ $user->user_name }}!</h2>
                            <p style="color: #4b5563; line-height: 1.6; font-size: 14px; margin-bottom: 20px;">
                                Your digital healthcare profile is ready. Your exclusive **Medical Card** has been issued.
                            </p>

                            <!-- Compact Masked Card -->
                            <div style="margin: 20px 0;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); border-radius: 12px; color: #ffffff; height: 180px; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);">
                                    <tr>
                                        <td style="padding: 20px; vertical-align: top;">
                                            <div style="font-size: 14px; font-weight: 800;">Doctorwala</div>
                                        </td>
                                        <td align="right" style="padding: 20px;">
                                            <div style="width: 35px; height: 25px; background: #fbbf24; border-radius: 4px;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 0 20px; text-align: center;">
                                            <div style="font-size: 16px; letter-spacing: 4px; font-family: monospace;">
                                                DW **** **** ****
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px; vertical-align: bottom;">
                                            <div style="font-size: 9px; color: rgba(255,255,255,0.6);">CARD HOLDER</div>
                                            <div style="font-size: 12px; font-weight: 600; text-transform: uppercase;">{{ substr($user->user_name, 0, 3) }}********</div>
                                        </td>
                                        <td align="right" style="padding: 20px; vertical-align: bottom;">
                                            <div style="font-size: 9px; color: rgba(255,255,255,0.6);">VALIDATION</div>
                                            <div style="font-size: 12px; font-weight: 600; color: #60a5fa;">DW** **** **</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <p style="color: #6b7280; font-size: 12px; text-align: center; margin-bottom: 25px;">
                                📎 Find your full-detail high-res PNG card attached.
                            </p>

                            <!-- Action -->
                            <div style="text-align: center;">
                                <a href="{{ route('dw.user-auth') }}" style="display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 8px; font-weight: 700; font-size: 14px;">
                                    Access Dashboard
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f8fafc; padding: 20px; text-align: center;">
                            <p style="color: #94a3b8; font-size: 11px; margin: 0;">
                                &copy; {{ date('Y') }} Doctorwala.info &bull; Secure Healthcare
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
