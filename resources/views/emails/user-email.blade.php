<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Security Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f7fafc; font-family: 'Inter', -apple-system, system-ui, sans-serif;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f7fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="500" border="0" cellspacing="0" cellpadding="0" style="max-width: 500px; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                    
                    <!-- Top Gradient Accent -->
                    <tr>
                        <td style="height: 6px; background: linear-gradient(to right, #0d6efd, #00d2ff);"></td>
                    </tr>

                    <!-- Logo Area -->
                    <tr>
                        <td style="padding: 40px 40px 20px 40px; text-align: center;">
                            <h2 style="color: #0d6efd; margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">Doctorwala</h2>
                            <div style="height: 2px; width: 40px; background: #e2e8f0; margin: 15px auto;"></div>
                        </td>
                    </tr>

                    <!-- Main Message -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <h3 style="color: #1a202c; font-size: 20px; font-weight: 700; margin-bottom: 10px;">Security Verification</h3>
                            <p style="color: #4a5568; font-size: 15px; line-height: 1.6; margin-bottom: 30px;">
                                Hello,<br>
                                To complete your login, please enter the one-time verification code below.
                            </p>

                            <!-- Premium OTP Display -->
                            <div style="background: #f1f5ff; border: 1px dashed #0d6efd; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                                <div style="font-size: 11px; text-transform: uppercase; color: #718096; letter-spacing: 2px; margin-bottom: 10px; font-weight: 600;">Your Verification Code</div>
                                <div style="font-size: 36px; font-weight: 800; color: #0d6efd; letter-spacing: 8px; font-family: 'Courier New', monospace;">{{ $otp }}</div>
                            </div>

                            <p style="color: #a0aec0; font-size: 13px; line-height: 1.6;">
                                This code will expire in 10 minutes. <br>
                                If you didn't request this, please ignore this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f8fafc; padding: 25px; text-align: center;">
                            <p style="color: #cbd5e0; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Doctorwala.info &bull; Secure Health Network
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
