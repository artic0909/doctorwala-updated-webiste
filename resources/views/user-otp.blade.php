<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Doctorwala – Login with OTP. Secure one-time password access to your digital medical card.">
    <title>Login with OTP | Doctorwala.info – Your Digital Medical Card</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue: #0d8de3;
            --blue-d: #0a72bb;
            --teal: #06c4ae;
            --card-bg: rgba(255, 255, 255, 0.97);
            --slate: #64748b;
            --muted: #94a3b8;
            --border: #e2e8f0;
            --red: #f43f5e;
            --green: #10b981;
            --inp-bg: #f7fbff;
            --transition: .25s cubic-bezier(.4, 0, .2, 1);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #07162a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            position: relative;
            overflow: hidden;
        }

        .blob-wrap {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .2;
            animation: blobMove 22s ease-in-out infinite alternate;
            will-change: transform;
        }

        .blob:nth-child(1) {
            width: 680px;
            height: 680px;
            background: #0d8de3;
            top: -180px;
            left: -180px;
            animation-duration: 26s;
        }

        .blob:nth-child(2) {
            width: 480px;
            height: 480px;
            background: #06c4ae;
            bottom: -130px;
            right: -130px;
            animation-duration: 18s;
            animation-delay: -7s;
        }

        .blob:nth-child(3) {
            width: 320px;
            height: 320px;
            background: #2550b8;
            top: 38%;
            left: 52%;
            animation-duration: 30s;
            animation-delay: -4s;
        }

        .blob:nth-child(4) {
            width: 240px;
            height: 240px;
            background: #06c4ae;
            top: 8%;
            right: 18%;
            animation-duration: 14s;
            animation-delay: -13s;
        }

        @keyframes blobMove {
            0% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(40px, -28px) scale(1.07);
            }

            66% {
                transform: translate(-22px, 45px) scale(.95);
            }

            100% {
                transform: translate(18px, -14px) scale(1.04);
            }
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(13, 141, 227, .06) 1px, transparent 1px), linear-gradient(90deg, rgba(13, 141, 227, .06) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        #bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .pulse-ring {
            position: fixed;
            border-radius: 50%;
            border: 1px solid rgba(13, 141, 227, .25);
            animation: pulseRing 7s ease-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        .pulse-ring:nth-child(1) {
            width: 90px;
            height: 90px;
            top: 12%;
            left: 6%;
            animation-delay: 0s;
        }

        .pulse-ring:nth-child(2) {
            width: 65px;
            height: 65px;
            top: 72%;
            left: 4%;
            animation-delay: -2.5s;
        }

        .pulse-ring:nth-child(3) {
            width: 110px;
            height: 110px;
            top: 78%;
            right: 8%;
            animation-delay: -1s;
        }

        .pulse-ring:nth-child(4) {
            width: 75px;
            height: 75px;
            top: 4%;
            right: 10%;
            animation-delay: -4s;
        }

        .pulse-ring:nth-child(5) {
            width: 50px;
            height: 50px;
            top: 48%;
            left: 2%;
            animation-delay: -5.5s;
        }

        @keyframes pulseRing {
            0% {
                transform: scale(.4);
                opacity: .8;
            }

            100% {
                transform: scale(3.5);
                opacity: 0;
            }
        }

        .float-icons {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .ficon {
            position: absolute;
            color: rgba(13, 141, 227, .13);
            animation: floatIcon linear infinite;
        }

        .ficon:nth-child(1) {
            left: 3%;
            font-size: .85rem;
            animation-duration: 21s;
            animation-delay: 0s;
        }

        .ficon:nth-child(2) {
            left: 11%;
            font-size: 1.2rem;
            animation-duration: 27s;
            animation-delay: -6s;
        }

        .ficon:nth-child(3) {
            left: 22%;
            font-size: .75rem;
            animation-duration: 17s;
            animation-delay: -11s;
        }

        .ficon:nth-child(4) {
            left: 33%;
            font-size: .95rem;
            animation-duration: 24s;
            animation-delay: -3s;
        }

        .ficon:nth-child(5) {
            left: 56%;
            font-size: 1.3rem;
            animation-duration: 31s;
            animation-delay: -16s;
        }

        .ficon:nth-child(6) {
            left: 68%;
            font-size: .8rem;
            animation-duration: 20s;
            animation-delay: -8s;
        }

        .ficon:nth-child(7) {
            left: 78%;
            font-size: 1.1rem;
            animation-duration: 25s;
            animation-delay: -2s;
        }

        .ficon:nth-child(8) {
            left: 88%;
            font-size: .9rem;
            animation-duration: 19s;
            animation-delay: -19s;
        }

        .ficon:nth-child(9) {
            left: 94%;
            font-size: 1rem;
            animation-duration: 28s;
            animation-delay: -9s;
        }

        .ficon:nth-child(10) {
            left: 44%;
            font-size: .7rem;
            animation-duration: 16s;
            animation-delay: -14s;
        }

        @keyframes floatIcon {
            0% {
                transform: translateY(110vh) rotate(0deg);
                opacity: 0;
            }

            5% {
                opacity: 1;
            }

            90% {
                opacity: .65;
            }

            100% {
                transform: translateY(-12vh) rotate(360deg);
                opacity: 0;
            }
        }

        .ecg-wrap {
            position: fixed;
            bottom: 24px;
            left: 0;
            right: 0;
            z-index: 0;
            pointer-events: none;
            opacity: .2;
            height: 55px;
            overflow: hidden;
        }

        .ecg-svg {
            width: 200%;
            height: 55px;
            animation: ecgScroll 4.5s linear infinite;
        }

        @keyframes ecgScroll {
            from {
                transform: translateX(0)
            }

            to {
                transform: translateX(-50%)
            }
        }

        /* ════ CARD ════ */
        .auth-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 820px;
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 500px;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0, 0, 0, .55), 0 0 0 1px rgba(255, 255, 255, .06);
            animation: wrapIn .65s cubic-bezier(.34, 1.4, .64, 1) both;
        }

        @keyframes wrapIn {
            from {
                opacity: 0;
                transform: translateY(44px) scale(.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* LEFT */
        .side-panel {
            background: linear-gradient(150deg, #0d8de3 0%, #06c4ae 100%);
            padding: 36px 28px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .side-panel::before {
            content: '';
            position: absolute;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
            bottom: -90px;
            left: -90px;
        }

        .side-panel::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            top: -50px;
            right: -60px;
        }

        .sp-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .15);
            animation: spinRing 20s linear infinite;
            pointer-events: none;
        }

        .sp-ring:nth-child(1) {
            width: 180px;
            height: 180px;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-duration: 25s;
        }

        .sp-ring:nth-child(2) {
            width: 260px;
            height: 260px;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(30deg);
            animation-duration: 35s;
            animation-direction: reverse;
        }

        @keyframes spinRing {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .sp-logo {
            display: flex;
            align-items: center;
            gap: 11px;
            position: relative;
            z-index: 1;
        }

        .sp-logo-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, .2);
            backdrop-filter: blur(6px);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .3);
            flex-shrink: 0;
        }

        .sp-logo-text h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.01em;
            line-height: 1.2;
        }

        .sp-logo-text p {
            font-size: .7rem;
            color: rgba(255, 255, 255, .72);
            margin-top: 1px;
        }

        .sp-middle {
            position: relative;
            z-index: 1;
        }

        .sp-tagline {
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 16px;
        }

        .sp-tagline span {
            color: rgba(255, 255, 255, .65);
            font-weight: 400;
            font-size: .95rem;
            display: block;
            margin-top: 6px;
        }

        .sp-steps {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sp-steps li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: .8rem;
            color: rgba(255, 255, 255, .88);
            font-weight: 500;
            line-height: 1.35;
        }

        .sp-steps li .step-num {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, .22);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-size: .72rem;
            font-weight: 800;
            color: #fff;
            margin-top: 1px;
        }

        .sp-bottom {
            font-size: .71rem;
            color: rgba(255, 255, 255, .52);
            position: relative;
            z-index: 1;
            line-height: 1.5;
        }

        /* RIGHT */
        .form-panel-wrap {
            background: var(--card-bg);
            display: flex;
            flex-direction: column;
        }

        .page-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 30px 13px;
            background: #f1f7fe;
            border-bottom: 2px solid var(--border);
        }

        .page-bar-title {
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            font-weight: 700;
            color: var(--blue);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .step-pills {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .step-pill {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: .72rem;
            font-weight: 600;
            color: var(--muted);
            padding: 3px 9px;
            border-radius: 20px;
            border: 1.5px solid var(--border);
            transition: var(--transition);
        }

        .step-pill.active {
            color: var(--blue);
            background: rgba(13, 141, 227, .08);
            border-color: rgba(13, 141, 227, .25);
        }

        .step-pill.done {
            color: var(--green);
            background: rgba(16, 185, 129, .08);
            border-color: rgba(16, 185, 129, .3);
        }

        .step-pill i {
            font-size: .65rem;
        }

        .step-sep {
            color: var(--border);
            font-size: .8rem;
        }

        .form-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 28px 32px 28px;
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }

        .form-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .form-scroll::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        .otp-step {
            display: none;
        }

        .otp-step.active {
            display: block;
            animation: panelIn .35s ease both;
        }

        @keyframes panelIn {
            from {
                opacity: 0;
                transform: translateX(14px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.28rem;
            font-weight: 700;
            color: #18283f;
            letter-spacing: -.02em;
            line-height: 1.2;
        }

        .form-header p {
            font-size: .78rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .form-badge {
            background: linear-gradient(135deg, var(--blue), var(--teal));
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: .67rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: .05em;
            white-space: nowrap;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .alert-box {
            border-radius: 12px;
            padding: 11px 13px;
            font-size: .81rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 18px;
            animation: alertIn .35s ease both;
        }

        @keyframes alertIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-box i {
            flex-shrink: 0;
            margin-top: 1px;
            font-size: .83rem;
        }

        .alert-error {
            background: #fff1f3;
            color: #be123c;
            border: 1.5px solid #fecdd3;
        }

        .alert-success {
            background: #f0fdf6;
            color: #047857;
            border: 1.5px solid #a7f3d0;
        }

        .alert-list {
            list-style: none;
            padding: 0;
            margin: 3px 0 0;
        }

        .alert-list li::before {
            content: '• ';
        }

        .alert-list li+li {
            margin-top: 2px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: .73rem;
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 5px;
            letter-spacing: .025em;
            text-transform: uppercase;
        }

        .field label i {
            color: var(--blue);
            font-size: .66rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: var(--inp-bg);
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            color: #18283f;
            transition: var(--transition);
            outline: none;
            -webkit-appearance: none;
        }

        .input-wrap input::placeholder {
            color: #b0bec5;
        }

        .input-wrap input:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3.5px rgba(13, 141, 227, .1);
        }

        .input-wrap input.is-invalid {
            border-color: var(--red);
            background: #fff5f7;
            box-shadow: 0 0 0 3px rgba(244, 63, 94, .07);
        }

        .input-icon {
            position: absolute;
            left: 13px;
            color: var(--muted);
            font-size: .8rem;
            pointer-events: none;
            transition: color var(--transition);
        }

        .input-wrap:focus-within .input-icon {
            color: var(--blue);
        }

        .field-error {
            font-size: .73rem;
            color: var(--red);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* OTP BOXES — 4 digits */
        .otp-boxes {
            display: flex;
            gap: 14px;
            justify-content: center;
            margin: 6px 0 10px;
        }

        .otp-box {
            width: 66px;
            height: 72px;
            border: 2px solid var(--border);
            border-radius: 14px;
            background: var(--inp-bg);
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: #18283f;
            text-align: center;
            outline: none;
            transition: var(--transition);
            -webkit-appearance: none;
            caret-color: var(--blue);
        }

        .otp-box:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 141, 227, .12);
            transform: translateY(-3px) scale(1.04);
        }

        .otp-box.filled {
            border-color: var(--teal);
            background: rgba(6, 196, 174, .06);
            color: var(--blue-d);
        }

        .otp-box.is-invalid {
            border-color: var(--red);
            background: #fff5f7;
            animation: shake .4s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-5px);
            }

            40% {
                transform: translateX(5px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(4px);
            }
        }

        #otp_hidden {
            display: none;
        }

        .otp-progress {
            height: 3px;
            border-radius: 3px;
            background: var(--border);
            margin-bottom: 16px;
            overflow: hidden;
        }

        .otp-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--blue), var(--teal));
            border-radius: 3px;
            transition: width .2s ease;
        }

        .email-badge {
            display: flex;
            align-items: center;
            gap: 7px;
            background: rgba(13, 141, 227, .07);
            border: 1.5px solid rgba(13, 141, 227, .2);
            border-radius: 10px;
            padding: 9px 14px;
            font-size: .83rem;
            color: var(--blue);
            font-weight: 600;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .email-badge i {
            flex-shrink: 0;
        }

        .email-badge span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        .email-badge .change-link {
            flex-shrink: 0;
            font-size: .73rem;
            color: var(--muted);
            cursor: pointer;
            text-decoration: underline;
            background: none;
            border: none;
            font-family: inherit;
            padding: 0;
            transition: color var(--transition);
        }

        .email-badge .change-link:hover {
            color: var(--blue);
        }

        .timer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
            font-size: .8rem;
            color: var(--slate);
        }

        .timer-count {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--blue);
            font-size: .88rem;
        }

        .timer-count.expired {
            color: var(--red);
        }

        .resend-wrap {
            display: none;
        }

        .resend-wrap.visible {
            display: inline;
        }

        .resend-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--blue);
            font-family: inherit;
            font-size: .8rem;
            font-weight: 700;
            text-decoration: underline;
            padding: 0;
            transition: var(--transition);
        }

        .resend-btn:hover {
            color: var(--blue-d);
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(120deg, var(--blue) 0%, var(--teal) 100%);
            color: #fff;
            border: none;
            border-radius: 11px;
            font-family: 'Outfit', sans-serif;
            font-size: .93rem;
            font-weight: 700;
            letter-spacing: .06em;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 5px 22px rgba(13, 141, 227, .28);
            margin-top: 6px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(255, 255, 255, .13) 0%, transparent 60%);
            border-radius: inherit;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(13, 141, 227, .38);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            margin-right: 8px;
        }

        .btn-submit:disabled {
            opacity: .5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .form-footer {
            text-align: center;
            margin-top: 16px;
            font-size: .8rem;
            color: var(--slate);
            border-top: 1px solid var(--border);
            padding-top: 14px;
        }

        .form-footer a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .home-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: var(--muted);
            font-size: .75rem;
            text-decoration: none;
            margin-top: 8px;
            transition: color var(--transition);
        }

        .home-link:hover {
            color: var(--blue);
        }

        @media(max-width:740px) {
            .auth-wrap {
                grid-template-columns: 1fr;
                max-width: 440px;
                min-height: unset;
            }

            .side-panel {
                padding: 20px 22px;
                flex-direction: row;
                align-items: center;
                gap: 14px;
            }

            .sp-middle,
            .sp-bottom,
            .sp-ring {
                display: none;
            }

            .sp-logo {
                flex: 1;
            }
        }

        @media(max-width:520px) {
            body {
                padding: 10px;
                align-items: flex-start;
                padding-top: 18px;
            }

            .form-scroll {
                padding: 20px 18px 22px;
            }

            .form-header {
                flex-direction: column;
                gap: 6px;
            }

            .otp-box {
                width: 56px;
                height: 62px;
                font-size: 1.6rem;
                border-radius: 12px;
            }

            .otp-boxes {
                gap: 10px;
            }

            .page-bar {
                padding: 12px 18px 11px;
            }
        }

        @media(max-width:360px) {
            .otp-box {
                width: 48px;
                height: 54px;
                font-size: 1.35rem;
            }

            .otp-boxes {
                gap: 7px;
            }

            .step-pill span {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="blob-wrap" aria-hidden="true">
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>
    </div>
    <div class="bg-grid" aria-hidden="true"></div>
    <canvas id="bg-canvas" aria-hidden="true"></canvas>
    <div class="pulse-ring" aria-hidden="true"></div>
    <div class="pulse-ring" aria-hidden="true"></div>
    <div class="pulse-ring" aria-hidden="true"></div>
    <div class="pulse-ring" aria-hidden="true"></div>
    <div class="pulse-ring" aria-hidden="true"></div>
    <div class="float-icons" aria-hidden="true">
        <i class="fa-solid fa-plus ficon"></i><i class="fa-solid fa-heart-pulse ficon"></i>
        <i class="fa-solid fa-plus ficon"></i><i class="fa-solid fa-capsules ficon"></i>
        <i class="fa-solid fa-plus ficon"></i><i class="fa-solid fa-stethoscope ficon"></i>
        <i class="fa-solid fa-plus ficon"></i><i class="fa-solid fa-heart-pulse ficon"></i>
        <i class="fa-solid fa-dna ficon"></i><i class="fa-solid fa-plus ficon"></i>
    </div>
    <div class="ecg-wrap" aria-hidden="true">
        <svg class="ecg-svg" viewBox="0 0 1200 55" fill="none" preserveAspectRatio="none">
            <polyline points="0,28 80,28 100,28 112,4 122,52 132,4 142,52 152,28 165,28 240,28 260,28 272,8 282,48 292,8 302,48 312,28 325,28 400,28 420,28 432,4 442,52 452,4 462,52 472,28 485,28 560,28 580,28 592,8 602,48 612,8 622,48 632,28 645,28 720,28 740,28 752,4 762,52 772,4 782,52 792,28 805,28 880,28 900,28 912,8 922,48 932,8 942,48 952,28 965,28 1040,28 1060,28 1072,4 1082,52 1092,4 1102,52 1112,28 1125,28 1200,28"
                stroke="#0d8de3" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>

    <div class="auth-wrap" role="main">

        <aside class="side-panel" aria-label="Doctorwala branding">
            <div class="sp-ring"></div>
            <div class="sp-ring"></div>
            <div class="sp-logo">
                <div class="sp-logo-icon"><img src="{{asset('./img/fav5.png')}}" width="50" alt="Doctorwala Logo"></div>
                <div class="sp-logo-text">
                    <h1>Doctorwala.info</h1>
                    <p>Your Medical Ecosystem</p>
                </div>
            </div>
            <div class="sp-middle">
                <p class="sp-tagline">Passwordless.<br>Instant. Secure.<span>Login in seconds with a one-time code sent to your email.</span></p>
                <ol class="sp-steps">
                    <li><span class="step-num">1</span> Enter your registered email address</li>
                    <li><span class="step-num">2</span> We'll send a 4-digit OTP to your inbox</li>
                    <li><span class="step-num">3</span> Enter the OTP to access your medical card</li>
                </ol>
            </div>
            <p class="sp-bottom">OTP expires in 3 minutes &mdash; check your spam folder too</p>
        </aside>

        <div class="form-panel-wrap">

            <div class="page-bar">
                <div class="page-bar-title">
                    <i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> OTP Login
                </div>
                <div class="step-pills">
                    @php $otpSent = session('user_mobile_number'); @endphp
                    <div class="step-pill {{ $otpSent ? 'done' : 'active' }}">
                        <i class="fa-solid {{ $otpSent ? 'fa-check' : 'fa-phone' }}" aria-hidden="true"></i>
                        <span>Mobile</span>
                    </div>
                    <span class="step-sep" aria-hidden="true">›</span>
                    <div class="step-pill {{ $otpSent ? 'active' : '' }}">
                        <i class="fa-solid fa-key" aria-hidden="true"></i>
                        <span>OTP</span>
                    </div>
                </div>
            </div>

            <div class="form-scroll">

                {{-- ══ STEP 1: SEND OTP ══ --}}
                <div class="otp-step {{ $otpSent ? '' : 'active' }}" id="step-email">
                    <div class="form-header">
                        <div>
                            <h2>Enter your mobile 📱</h2>
                            <p>We'll send a 4-digit OTP to your registered mobile number</p>
                        </div>
                        <span class="form-badge">STEP 1 / 2</span>
                    </div>

                    @if($errors->has('user_mobile_number'))
                    <div class="alert-box alert-error" role="alert">
                        <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                        <div>
                            <strong>Could not send OTP —</strong>
                            <ul class="alert-list">
                                @foreach($errors->get('user_mobile_number') as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('user.send.otp') }}" method="POST" novalidate>
                        @csrf
                        <div class="field">
                            <label for="send_mobile">
                                <i class="fa-solid fa-phone" aria-hidden="true"></i> Mobile Number
                            </label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-phone input-icon" aria-hidden="true"></i>
                                <input type="tel" id="send_mobile" name="user_mobile_number"
                                    placeholder="Enter your registered mobile number"
                                    autocomplete="tel" required
                                    value="{{ old('user_mobile_number') }}"
                                    class="{{ $errors->has('user_mobile_number') ? 'is-invalid' : '' }}">
                            </div>
                            @error('user_mobile_number')
                            <p class="field-error" role="alert">
                                <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i> SEND OTP TO MY MOBILE
                        </button>
                    </form>

                    <div class="form-footer">
                        Know your password? <a href="{{ route('dw.user-auth') }}">Login with password</a>
                        <br>
                        <a href="/" class="home-link"><i class="fa-solid fa-house" aria-hidden="true"></i> Back to Homepage</a>
                    </div>
                </div>

                {{-- ══ STEP 2: VERIFY OTP ══ --}}
                <div class="otp-step {{ $otpSent ? 'active' : '' }}" id="step-otp">
                    <div class="form-header">
                        <div>
                            <h2>Enter the OTP 🔐</h2>
                            <p>Check your inbox and enter the 4-digit code</p>
                        </div>
                        <span class="form-badge">STEP 2 / 2</span>
                    </div>

                    @if(session('message'))
                    <div class="alert-box alert-success" role="alert">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <span>{{ session('message') }}</span>
                    </div>
                    @endif

                    @if($errors->has('user_otp'))
                    <div class="alert-box alert-error" role="alert">
                        <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                        <div>
                            <strong>OTP verification failed —</strong>
                            <ul class="alert-list">
                                @foreach($errors->get('user_otp') as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($otpSent)
                    <div class="email-badge">
                        <i class="fa-solid fa-mobile-button" aria-hidden="true"></i>
                        <span>OTP sent to: <strong>{{ $otpSent }}</strong></span>
                        <button type="button" class="change-link" onclick="changeMobile()">Change</button>
                    </div>
                    @endif

                    {{-- Resend form: lives OUTSIDE verify form — nested forms break submission --}}
                    <form action="{{ route('user.send.otp') }}" method="POST" id="resend-form" style="display:none">
                        @csrf
                        <input type="hidden" name="user_mobile_number" value="{{ $otpSent }}">
                    </form>

                    <form action="{{ route('user.verify.otp') }}" method="POST" novalidate id="otp-form">
                        @csrf
                        <input type="hidden" name="user_otp" id="otp_hidden">

                        <div class="field">
                            <label><i class="fa-solid fa-key" aria-hidden="true"></i> 4-Digit OTP Code</label>
                            <div class="otp-boxes" role="group" aria-label="Enter 4-digit OTP">
                                <input class="otp-box {{ $errors->has('user_otp') ? 'is-invalid' : '' }}" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]" autocomplete="one-time-code" aria-label="OTP digit 1" id="otp1">
                                <input class="otp-box {{ $errors->has('user_otp') ? 'is-invalid' : '' }}" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]" aria-label="OTP digit 2" id="otp2">
                                <input class="otp-box {{ $errors->has('user_otp') ? 'is-invalid' : '' }}" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]" aria-label="OTP digit 3" id="otp3">
                                <input class="otp-box {{ $errors->has('user_otp') ? 'is-invalid' : '' }}" type="text" inputmode="numeric" maxlength="1" pattern="[0-9]" aria-label="OTP digit 4" id="otp4">
                            </div>
                            <div class="otp-progress" aria-hidden="true">
                                <div class="otp-progress-bar" id="otp-progress-bar"></div>
                            </div>
                        </div>

                        <div class="timer-row">
                            <span>OTP expires in: <span class="timer-count" id="timer-display">03:00</span></span>
                            <span class="resend-wrap" id="resend-wrap">
                                <button type="button" class="resend-btn" onclick="document.getElementById('resend-form').submit()">
                                    <i class="fa-solid fa-rotate-right" aria-hidden="true"></i> Resend OTP
                                </button>
                            </span>
                        </div>

                        <button type="submit" class="btn-submit" id="verify-btn" disabled>
                            <i class="fa-solid fa-circle-check" aria-hidden="true"></i> VERIFY & LOGIN
                        </button>
                    </form>

                    <div class="form-footer">
                        Wrong email? <a href="#" onclick="changeEmail(); return false;">Go back &amp; change</a>
                        &nbsp;·&nbsp; <a href="{{ route('dw.user-auth') }}">Login with password</a>
                        <br>
                        <a href="/" class="home-link"><i class="fa-solid fa-house" aria-hidden="true"></i> Back to Homepage</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function changeEmail() {
            fetch('{{ route("user.otp.reset") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => window.location.reload());
        }

        const otpBoxes = Array.from(document.querySelectorAll('.otp-box'));
        const otpHidden = document.getElementById('otp_hidden');
        const verifyBtn = document.getElementById('verify-btn');
        const progressBar = document.getElementById('otp-progress-bar');

        function updateProgress() {
            const filled = otpBoxes.filter(b => b.value !== '').length;
            if (progressBar) progressBar.style.width = (filled / 4 * 100) + '%';
            otpBoxes.forEach(b => b.classList.toggle('filled', b.value !== ''));
            const otp = otpBoxes.map(b => b.value).join('');
            if (otpHidden) otpHidden.value = otp;
            if (verifyBtn) verifyBtn.disabled = otp.length < 4;
        }

        otpBoxes.forEach((box, idx) => {
            box.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '').slice(-1);
                if (this.value && idx < 3) otpBoxes[idx + 1].focus();
                updateProgress();
            });
            box.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && idx > 0) {
                    otpBoxes[idx - 1].focus();
                    otpBoxes[idx - 1].value = '';
                    updateProgress();
                }
                if (e.key === 'ArrowLeft' && idx > 0) {
                    e.preventDefault();
                    otpBoxes[idx - 1].focus();
                }
                if (e.key === 'ArrowRight' && idx < 3) {
                    e.preventDefault();
                    otpBoxes[idx + 1].focus();
                }
            });
            box.addEventListener('paste', function(e) {
                e.preventDefault();
                const p = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                p.split('').slice(0, 4).forEach((ch, i) => {
                    if (otpBoxes[i]) otpBoxes[i].value = ch;
                });
                otpBoxes[Math.min(p.length, 3)].focus();
                updateProgress();
            });
        });

        if (document.getElementById('step-otp').classList.contains('active')) {
            setTimeout(() => otpBoxes[0]?.focus(), 150);
        }

        (function() {
            const display = document.getElementById('timer-display');
            const resendWrap = document.getElementById('resend-wrap');
            if (!display || !document.getElementById('step-otp').classList.contains('active')) return;
            let total = 3 * 60;
            const interval = setInterval(() => {
                total--;
                if (total <= 0) {
                    clearInterval(interval);
                    display.textContent = 'Expired';
                    display.classList.add('expired');
                    if (resendWrap) resendWrap.classList.add('visible');
                    if (verifyBtn) verifyBtn.disabled = true;
                    return;
                }
                const m = Math.floor(total / 60).toString().padStart(2, '0');
                const s = (total % 60).toString().padStart(2, '0');
                display.textContent = m + ':' + s;
                if (total <= 30) display.classList.add('expired');
            }, 1000);
        })();

        (function() {
            const canvas = document.getElementById('bg-canvas'),
                ctx = canvas.getContext('2d');
            let W, H, pts = [];
            const COLS = ['rgba(13,141,227,', 'rgba(6,196,174,', 'rgba(59,111,200,'];

            function resize() {
                W = canvas.width = window.innerWidth;
                H = canvas.height = window.innerHeight;
            }

            function Pt() {
                this.init();
            }
            Pt.prototype.init = function() {
                this.x = Math.random() * W;
                this.y = Math.random() * H;
                this.r = Math.random() * 1.6 + 0.4;
                this.vx = (Math.random() - .5) * .35;
                this.vy = (Math.random() - .5) * .35;
                this.a = Math.random() * .3 + .08;
                this.c = COLS[Math.floor(Math.random() * COLS.length)];
                this.p = Math.random() * Math.PI * 2;
                this.ps = .018 + Math.random() * .02;
            };
            Pt.prototype.update = function() {
                this.x += this.vx;
                this.y += this.vy;
                this.p += this.ps;
                if (this.x < -10 || this.x > W + 10 || this.y < -10 || this.y > H + 10) this.init();
            };
            Pt.prototype.draw = function() {
                const a = this.a * (.7 + .3 * Math.sin(this.p));
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
                ctx.fillStyle = this.c + a + ')';
                ctx.fill();
            };

            function drawLines() {
                const D = 115;
                for (let i = 0; i < pts.length; i++)
                    for (let j = i + 1; j < pts.length; j++) {
                        const dx = pts[i].x - pts[j].x,
                            dy = pts[i].y - pts[j].y,
                            d = Math.sqrt(dx * dx + dy * dy);
                        if (d < D) {
                            ctx.beginPath();
                            ctx.moveTo(pts[i].x, pts[i].y);
                            ctx.lineTo(pts[j].x, pts[j].y);
                            ctx.strokeStyle = `rgba(13,141,227,${(1-d/D)*.07})`;
                            ctx.lineWidth = .55;
                            ctx.stroke();
                        }
                    }
            }

            function init() {
                resize();
                const n = Math.min(Math.floor(W * H / 13000), 100);
                pts = Array.from({
                    length: n
                }, () => new Pt());
            }

            function loop() {
                ctx.clearRect(0, 0, W, H);
                drawLines();
                pts.forEach(p => {
                    p.update();
                    p.draw();
                });
                requestAnimationFrame(loop);
            }
            window.addEventListener('resize', () => {
                resize();
                init();
            });
            init();
            loop();
        })();

        document.addEventListener('DOMContentLoaded', async () => {
            const ua = navigator.userAgent;
            const browser = ua.includes('Chrome') ? 'Chrome' : ua.includes('Firefox') ? 'Firefox' : ua.includes('Safari') ? 'Safari' : ua.includes('Edge') ? 'Edge' : 'Other';
            const os = ua.includes('Windows') ? 'Windows' : ua.includes('Mac') ? 'MacOS' : ua.includes('Android') ? 'Android' : (ua.includes('iPhone') || ua.includes('iPad')) ? 'iOS' : ua.includes('Linux') ? 'Linux' : 'Other';
            const deviceType = /Mobi|Android|iPhone|iPad/i.test(ua) ? 'Mobile' : 'Desktop';
            let country = null,
                city = null;
            try {
                const geo = await fetch('https://ipapi.co/json/');
                const d = await geo.json();
                country = d.country_name;
                city = d.city;
            } catch (e) {}
            fetch('{{ route("visitor.track") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    page_url: window.location.href,
                    referrer: document.referrer || null,
                    browser,
                    os,
                    device_type: deviceType,
                    screen_size: `${screen.width}x${screen.height}`,
                    language: navigator.language,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    country,
                    city
                })
            });
        });
    </script>
</body>

</html>