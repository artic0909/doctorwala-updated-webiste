<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Blocked · Partner Panel</title>
    
    <link href="{{asset('fav5.png')}}" rel="icon">

    <style>
        .ab-wrap {
            min-height: 72vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .ab-card {
            background: #fff;
            border-radius: 22px;
            padding: 52px 40px 44px;
            max-width: 460px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 40px rgba(244, 63, 94, .1), 0 2px 12px rgba(0, 0, 0, .07);
            border: 1.5px solid #fecdd3;
            position: relative;
            overflow: hidden;
        }

        .ab-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f43f5e, #ef4444);
            border-radius: 22px 22px 0 0;
        }

        .ab-icon-wrap {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ab-icon-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid rgba(244, 63, 94, .2);
            animation: abRingPulse 2.4s ease-out infinite;
        }

        .ab-icon-ring--2 {
            animation-delay: 1.2s;
        }

        @keyframes abRingPulse {
            0% {
                transform: scale(.7);
                opacity: .8;
            }

            100% {
                transform: scale(1.7);
                opacity: 0;
            }
        }

        .ab-icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f43f5e, #ef4444);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 8px 24px rgba(244, 63, 94, .35);
            position: relative;
            z-index: 1;
            animation: abIconBounce .5s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes abIconBounce {
            from {
                transform: scale(0) rotate(-15deg);
            }

            to {
                transform: scale(1) rotate(0);
            }
        }

        .ab-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #1f0a0e;
            margin-bottom: 10px;
            letter-spacing: -.02em;
        }

        .ab-desc {
            font-size: .875rem;
            color: #7a5560;
            line-height: 1.65;
            margin-bottom: 28px;
        }

        .ab-desc strong {
            color: #f43f5e;
        }

        .ab-patient-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(244, 63, 94, .06);
            border: 1.5px solid rgba(244, 63, 94, .18);
            border-radius: 10px;
            padding: 9px 18px;
            font-size: .82rem;
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 28px;
        }

        .ab-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .ab-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 11px 22px;
            border-radius: 11px;
            font-size: .85rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .2s ease;
        }

        .ab-btn--back {
            background: #f9f1f2;
            color: #7a5560;
            border: 1.5px solid #f5d0d6;
        }

        .ab-btn--back:hover {
            background: #f5e6e8;
        }

        .ab-notice {
            margin-top: 22px;
            font-size: .75rem;
            color: #b0adb0;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="ab-wrap">
        <div class="ab-card">

            <div class="ab-icon-wrap">
                <div class="ab-icon-ring"></div>
                <div class="ab-icon-ring ab-icon-ring--2"></div>
                <div class="ab-icon-circle">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0110 0v4" />
                    </svg>
                </div>
            </div>

            <h2 class="ab-title">Access Revoked</h2>
            <p class="ab-desc">
                This patient has <strong>turned off</strong> access to their profile.<br>
                You can no longer view their records until they re-enable access.
            </p>

            @if(isset($patient))
            <div class="ab-patient-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
                {{ $patient->user_name }}
            </div>
            @endif

            <div class="ab-actions">
                <a href="{{route('partner.patient.profile.all.request')}}" class="ab-btn ab-btn--back">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Go Back
                </a>
            </div>

            <p class="ab-notice">
                If you believe this is a mistake, please ask the patient to re-enable<br>
                profile access from their account settings.
            </p>

        </div>
    </div>
</body>

</html>