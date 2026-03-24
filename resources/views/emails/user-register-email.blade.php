<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Doctorwala</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Inter', system-ui, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; padding: 15px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="450" border="0" cellspacing="0" cellpadding="0" style="max-width: 450px; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                    
                    <!-- Clean Header -->
                    <tr>
                        <td style="padding: 20px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            <img src="{{ asset('img/logoo.png') }}" alt="Doctorwala" style="height: 40px; width: auto;">
                            <p style="margin: 5px 0 0; font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Medical Ecosystem</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 25px;">
                            <h2 style="color: #0f172a; margin: 0; font-size: 18px; font-weight: 700;">Welcome, {{ $user->user_name }}!</h2>
                            <p style="color: #475569; line-height: 1.5; font-size: 13px; margin: 10px 0 20px;">
                                Your registration is complete. We've issued your official **Doctorwala Medical Card**.
                            </p>

                            <!-- Masked Preview Card -->
                            <div style="margin: 20px 0; pointer-events: none;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; height: 160px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                    <tr>
                                        <td style="padding: 15px; vertical-align: top;">
                                            <div style="font-size: 12px; font-weight: 800; color: #28a745;">DOCTOR<span style="color: #dc3545;">WALA</span></div>
                                        </td>
                                        <td align="right" style="padding: 15px;">
                                            <div style="width: 30px; height: 20px; background: #f3f4f6; border-radius: 3px; border: 1px solid #e2e8f0;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding: 0 15px;">
                                            <div style="font-size: 14px; font-weight: 700; color: #1e293b; text-transform: uppercase;">
                                                {{ substr($user->user_name, 0, 1) }}******** {{ substr(strrchr($user->user_name, " "), 1, 1) }}***
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 15px; vertical-align: bottom;">
                                            <div style="font-size: 8px; color: #94a3b8;">MEMBER ID</div>
                                            <div style="font-size: 11px; font-weight: 600; color: #475569;">DW-****-***</div>
                                        </td>
                                        <td align="right" style="padding: 15px; vertical-align: bottom;">
                                            <div style="font-size: 8px; color: #94a3b8;">VALIDATION</div>
                                            <div style="font-size: 11px; font-weight: 600; color: #28a745;">DW** **** **</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <p style="color: #64748b; font-size: 11px; text-align: center; margin-bottom: 20px;">
                                📎 **Check attachment** for your high-res printable card.
                            </p>

                            <!-- Action -->
                            <div style="text-align: center;">
                                <a href="{{ route('dw.user-auth') }}" style="display: inline-block; background: #28a745; color: #ffffff; text-decoration: none; padding: 10px 25px; border-radius: 6px; font-weight: 700; font-size: 13px;">
                                    View My Dashboard
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f8fafc; padding: 15px; text-align: center; border-top: 1px solid #f1f5f9;">
                            <p style="color: #94a3b8; font-size: 10px; margin: 0;">
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
