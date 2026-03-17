<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Verification - Doctorwala</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7fa; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f7fa; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="550" border="0" cellspacing="0" cellpadding="0" style="max-width: 550px; background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    
                    <!-- Partner Branding Header -->
                    <tr>
                        <td style="background: #0d6efd; padding: 40px; text-align: center;">
                            <h2 style="color: #ffffff; margin: 0; font-size: 26px; font-weight: 800;">Doctorwala Partner</h2>
                            <p style="color: rgba(255,255,255,0.8); margin-top: 8px; font-size: 14px; letter-spacing: 1px; text-transform: uppercase;">Professional Network Verification</p>
                        </td>
                    </tr>

                    <!-- content content -->
                    <tr>
                        <td style="padding: 45px 40px;">
                            <h3 style="color: #1a202c; font-size: 22px; font-weight: 700; margin-top: 0; text-align: center;">Partner Account Verification</h3>
                            
                            <p style="color: #4a5568; font-size: 15px; line-height: 1.7; text-align: center; margin-bottom: 35px;">
                                Welcome to the healthcare professional network. <br>
                                Confirm your identity as a <strong>Partner</strong> by using the following secure token.
                            </p>

                            <!-- Professional OTP Token Display -->
                            <div style="text-align: center; margin: 30px 0;">
                                <div style="display: inline-block; background: #eef2ff; border: 2px solid #0d6efd; border-radius: 16px; padding: 30px 50px;">
                                    <div style="font-size: 42px; font-weight: 800; color: #0d6efd; letter-spacing: 10px; font-family: 'Courier New', monospace;">{{ $otp }}</div>
                                    <div style="margin-top: 10px; font-size: 12px; color: #6366f1; text-transform: uppercase; font-weight: 700;">Partner Access Token</div>
                                </div>
                            </div>

                            <div style="background-color: #f9fafb; border-left: 4px solid #0d6efd; padding: 20px; border-radius: 4px; margin-top: 30px;">
                                <p style="margin: 0; color: #4b5563; font-size: 13px; line-height: 1.6;">
                                    <strong>Important Note:</strong> This token is for verified partners (Doctors, Clinics, Labs). Do not share this with anyone outside your institution.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Institutional Footer -->
                    <tr>
                        <td style="background: #111827; padding: 35px; text-align: center;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Doctorwala Partner Network &bull; Integrated Healthcare Solutions
                            </p>
                            <div style="margin-top: 15px;">
                                <a href="mailto:info.doctorwala@gmail.com" style="color: #3b82f6; text-decoration: none; font-size: 12px; font-weight: 600;">Contact Institutional Support</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>