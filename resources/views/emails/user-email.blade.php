<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctorwala OTP</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f7fb; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fb; padding:20px 0;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="100%" max-width="500px" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0D6EFD; padding:20px; text-align:center; color:#ffffff;">
                            <h2 style="margin:0;">Doctorwala</h2>
                            <p style="margin:5px 0 0; font-size:13px;">Your Trusted Healthcare Partner</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px 25px; text-align:center; color:#333;">
                            
                            <h3 style="margin-bottom:10px;">Verify Your Account</h3>
                            <p style="font-size:14px; color:#555;">
                                Hello,<br>
                                Use the following OTP to complete your registration.
                            </p>

                            <!-- OTP Box -->
                            <div style="margin:25px 0;">
                                <span style="
                                    display:inline-block;
                                    padding:15px 30px;
                                    font-size:24px;
                                    letter-spacing:4px;
                                    background:#f1f5ff;
                                    color:#0D6EFD;
                                    border-radius:8px;
                                    font-weight:bold;
                                ">
                                    {{ $otp }}
                                </span>
                            </div>

                            <p style="font-size:13px; color:#777;">
                                This OTP is valid for a limited time. Do not share it with anyone.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafc; padding:20px; text-align:center; font-size:12px; color:#888;">
                            <p style="margin:0;">© {{ date('Y') }} Doctorwala.info</p>
                            <p style="margin:5px 0 0;">Need help? Contact support</p>
                        </td>
                    </tr>

                </table>

                <!-- Bottom spacing -->
                <div style="height:20px;"></div>

            </td>
        </tr>
    </table>

</body>
</html>
