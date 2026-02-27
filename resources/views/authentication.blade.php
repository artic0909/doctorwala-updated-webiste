<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DoctorWala – Login or Create Your Free Digital Medical Card. Secure access to your health records anytime, anywhere.">
    <title>Login & Sign Up | DoctorWala.info – Your Digital Medical Card</title>
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
            --white: #ffffff;
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

        /* ═══ BG BLOBS ═══ */
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

        /* ═══ GRID ═══ */
        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(13, 141, 227, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13, 141, 227, .06) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* ═══ CANVAS PARTICLES ═══ */
        #bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ═══ PULSE RINGS ═══ */
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

        /* ═══ FLOATING ICONS ═══ */
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

        /* ═══ ECG LINE ═══ */
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

        /* ═══════════════════════════════════
       MAIN CARD — split layout
    ═══════════════════════════════════ */
        .auth-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 290px 1fr;
            min-height: 580px;
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

        /* ── LEFT SIDE PANEL ── */
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

        /* rotating ring decoration */
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
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 16px;
        }

        .sp-tagline span {
            color: rgba(255, 255, 255, .65);
            font-weight: 400;
            font-size: 1rem;
            display: block;
            margin-top: 6px;
        }

        .sp-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .sp-features li {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: .81rem;
            color: rgba(255, 255, 255, .88);
            font-weight: 500;
        }

        .sp-features li .feat-icon {
            width: 27px;
            height: 27px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, .18);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .72rem;
        }

        .sp-bottom {
            font-size: .71rem;
            color: rgba(255, 255, 255, .52);
            position: relative;
            z-index: 1;
            line-height: 1.5;
        }

        /* ── RIGHT FORM SIDE ── */
        .form-panel-wrap {
            background: var(--card-bg);
            display: flex;
            flex-direction: column;
        }

        /* Tabs */
        .tab-bar {
            display: flex;
            background: #f1f7fe;
            border-bottom: 2px solid var(--border);
        }

        .tab-btn {
            flex: 1;
            padding: 15px 12px;
            border: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: .87rem;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            letter-spacing: .01em;
        }

        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 18%;
            right: 18%;
            height: 2.5px;
            background: linear-gradient(90deg, var(--blue), var(--teal));
            border-radius: 2px;
            transform: scaleX(0);
            transition: transform var(--transition);
        }

        .tab-btn.active {
            color: var(--blue);
            background: #fff;
        }

        .tab-btn.active::after {
            transform: scaleX(1);
        }

        .tab-btn i {
            margin-right: 6px;
            font-size: .78rem;
        }

        /* Scroll area */
        .form-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 26px 30px 26px;
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

        .form-panel {
            display: none;
        }

        .form-panel.active {
            display: block;
            animation: panelIn .3s ease both;
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

        /* Form header */
        .form-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.3rem;
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

        /* Alerts */
        .alert-box {
            border-radius: 12px;
            padding: 11px 13px;
            font-size: .81rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 16px;
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

        /* 2-col grid for signup */
        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 14px;
        }

        .field-full {
            grid-column: 1/-1;
        }

        /* Fields */
        .field {
            margin-bottom: 13px;
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

        .eye-btn {
            position: absolute;
            right: 11px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 5px;
            font-size: .83rem;
            transition: color var(--transition);
            line-height: 1;
        }

        .eye-btn:hover {
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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Submit */
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
            margin-top: 5px;
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

        /* Footer */
        .form-footer {
            text-align: center;
            margin-top: 14px;
            font-size: .8rem;
            color: var(--slate);
            border-top: 1px solid var(--border);
            padding-top: 13px;
        }

        .link-btn {
            color: var(--blue);
            font-weight: 700;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
            padding: 0;
            text-decoration: underline;
        }

        .link-btn:hover {
            color: var(--blue-d);
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

        /* ── RESPONSIVE ── */
        @media(max-width:780px) {
            .auth-wrap {
                grid-template-columns: 1fr;
                max-width: 460px;
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
                padding: 18px 16px 20px;
            }

            .fields-grid {
                grid-template-columns: 1fr;
            }

            .field-full {
                grid-column: unset;
            }

            .form-header {
                flex-direction: column;
                gap: 6px;
            }
        }

        @media(max-width:360px) {
            .tab-btn {
                font-size: .77rem;
                padding: 12px 8px;
            }

            .side-panel {
                padding: 16px 18px;
            }
        }
    </style>
</head>

<body>

    <!-- BG -->
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
        <i class="fa-solid fa-plus ficon"></i>
        <i class="fa-solid fa-heart-pulse ficon"></i>
        <i class="fa-solid fa-plus ficon"></i>
        <i class="fa-solid fa-capsules ficon"></i>
        <i class="fa-solid fa-plus ficon"></i>
        <i class="fa-solid fa-stethoscope ficon"></i>
        <i class="fa-solid fa-plus ficon"></i>
        <i class="fa-solid fa-heart-pulse ficon"></i>
        <i class="fa-solid fa-dna ficon"></i>
        <i class="fa-solid fa-plus ficon"></i>
    </div>

    <div class="ecg-wrap" aria-hidden="true">
        <svg class="ecg-svg" viewBox="0 0 1200 55" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <polyline
                points="0,28 80,28 100,28 112,4 122,52 132,4 142,52 152,28 165,28
                    240,28 260,28 272,8 282,48 292,8 302,48 312,28 325,28
                    400,28 420,28 432,4 442,52 452,4 462,52 472,28 485,28
                    560,28 580,28 592,8 602,48 612,8 622,48 632,28 645,28
                    720,28 740,28 752,4 762,52 772,4 782,52 792,28 805,28
                    880,28 900,28 912,8 922,48 932,8 942,48 952,28 965,28
                    1040,28 1060,28 1072,4 1082,52 1092,4 1102,52 1112,28 1125,28 1200,28"
                stroke="#0d8de3" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>

    <!-- CARD -->
    <div class="auth-wrap" role="main">

        <!-- Left branding -->
        <aside class="side-panel" aria-label="DoctorWala branding">
            <div class="sp-ring"></div>
            <div class="sp-ring"></div>

            <div class="sp-logo">
                <div class="sp-logo-icon"><i class="fa-solid fa-stethoscope" aria-hidden="true"></i></div>
                <div class="sp-logo-text">
                    <h1>DoctorWala.info</h1>
                    <p>Digital Health Platform</p>
                </div>
            </div>

            <div class="sp-middle">
                <p class="sp-tagline">
                    Your health.<br>Always with you.
                    <span>Secure digital medical cards for every Indian family.</span>
                </p>
                <ul class="sp-features" aria-label="Platform features">
                    <li><span class="feat-icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span> Secure &amp; encrypted records</li>
                    <li><span class="feat-icon"><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i></span> Access anywhere, anytime</li>
                    <li><span class="feat-icon"><i class="fa-solid fa-hospital-user" aria-hidden="true"></i></span> Share with any doctor</li>
                    <li><span class="feat-icon"><i class="fa-solid fa-bell" aria-hidden="true"></i></span> Appointment reminders</li>
                </ul>
            </div>

            <p class="sp-bottom">
                Trusted by thousands of patients across India<br>— 100% free to join
            </p>
        </aside>

        <!-- Right form -->
        <div class="form-panel-wrap">
            <div class="tab-bar" role="tablist" aria-label="Authentication options">
                <button class="tab-btn active" id="tab-login" role="tab" aria-selected="true" aria-controls="panel-login" onclick="switchTab('login')">
                    <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> Sign In
                </button>
                <button class="tab-btn" id="tab-signup" role="tab" aria-selected="false" aria-controls="panel-signup" onclick="switchTab('signup')">
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i> Create Account
                </button>
            </div>

            <div class="form-scroll">

                <!-- LOGIN -->
                <div class="form-panel active" id="panel-login" role="tabpanel" aria-labelledby="tab-login">
                    <div class="form-header">
                        <div>
                            <h2>Welcome back 👋</h2>
                            <p>Sign in to your medical card &amp; health records</p>
                        </div>
                        <span class="form-badge">SECURE LOGIN</span>
                    </div>

                    @if(session('success'))
                    <div class="alert-box alert-success" role="alert">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    @if($errors->has('user_email') || $errors->has('user_password'))
                    <div class="alert-box alert-error" role="alert">
                        <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                        <div>
                            <strong>Login failed —</strong> please check your credentials.
                            <ul class="alert-list">
                                @foreach($errors->get('user_email') as $e)<li>{{ $e }}</li>@endforeach
                                @foreach($errors->get('user_password') as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('dw.user-login') }}" method="POST" novalidate>
                        @csrf
                        <div class="field">
                            <label for="login_email"><i class="fa-solid fa-at" aria-hidden="true"></i> Email Address</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-at input-icon" aria-hidden="true"></i>
                                <input type="email" id="login_email" name="user_email"
                                    placeholder="you@example.com" autocomplete="email" required
                                    value="{{ old('user_email') }}"
                                    class="{{ $errors->has('user_email') ? 'is-invalid' : '' }}">
                            </div>
                            @error('user_email')
                            <p class="field-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="login_password"><i class="fa-solid fa-lock" aria-hidden="true"></i> Password</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-lock input-icon" aria-hidden="true"></i>
                                <input type="password" id="login_password" name="user_password"
                                    placeholder="Enter your password" autocomplete="current-password" required
                                    class="{{ $errors->has('user_password') ? 'is-invalid' : '' }}">
                                <button type="button" class="eye-btn" onclick="togglePwd('login_password',this)" aria-label="Toggle password visibility">
                                    <i class="fa-regular fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('user_password')
                            <p class="field-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> LOGIN TO MY ACCOUNT
                        </button>
                    </form>

                    <div class="form-footer">
                        <a href="/user-otp" style="color:var(--blue);font-weight:600;text-decoration:none;">
                            <i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> Forgot password? Login with OTP
                        </a>
                        <br><br>
                        Don't have an account? <button class="link-btn" onclick="switchTab('signup')">Create one free</button>
                        <br>
                        <a href="/" class="home-link"><i class="fa-solid fa-house" aria-hidden="true"></i> Back to Homepage</a>
                    </div>
                </div>

                <!-- SIGNUP -->
                <div class="form-panel" id="panel-signup" role="tabpanel" aria-labelledby="tab-signup">
                    <div class="form-header">
                        <div>
                            <h2>Create your card ✦</h2>
                            <p>Free digital medical card — takes just 30 seconds</p>
                        </div>
                        <span class="form-badge">100% FREE</span>
                    </div>

                    {{-- SUCCESS: login redirect after registration --}}
                    @if(session('success'))
                    <div class="alert-box alert-success" role="alert">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    {{-- DB / server error from controller catch block --}}
                    @if(session('error'))
                    <div class="alert-box alert-error" role="alert">
                        <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    @endif

                    {{-- VALIDATION errors (required fields, email format, etc.) --}}
                    @if($errors->hasAny(['user_name','user_mobile','user_city','user_email','user_password']))
                    <div class="alert-box alert-error" role="alert">
                        <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                        <div>
                            <strong>Please fix the following errors:</strong>
                            <ul class="alert-list">
                                @foreach(['user_name','user_mobile','user_city','user_email','user_password'] as $f)
                                @foreach($errors->get($f) as $e)<li>{{ $e }}</li>@endforeach
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('dw.user-register') }}" method="POST" novalidate>
                        @csrf
                        <div class="fields-grid">

                            <div class="field">
                                <label for="user_name"><i class="fa-solid fa-user" aria-hidden="true"></i> Full Name</label>
                                <div class="input-wrap">
                                    <i class="fa-solid fa-user input-icon" aria-hidden="true"></i>
                                    <input type="text" id="user_name" name="user_name"
                                        placeholder="Your full name" autocomplete="name" required
                                        value="{{ old('user_name') }}"
                                        class="{{ $errors->has('user_name') ? 'is-invalid' : '' }}">
                                </div>
                                @error('user_name')
                                <p class="field-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="user_mobile"><i class="fa-solid fa-phone" aria-hidden="true"></i> Mobile</label>
                                <div class="input-wrap">
                                    <i class="fa-solid fa-phone input-icon" aria-hidden="true"></i>
                                    <input type="number" id="user_mobile" name="user_mobile"
                                        placeholder="10-digit number" autocomplete="tel" required
                                        value="{{ old('user_mobile') }}"
                                        class="{{ $errors->has('user_mobile') ? 'is-invalid' : '' }}">
                                </div>
                                @error('user_mobile')
                                <p class="field-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field field-full">
                                <label for="user_city"><i class="fa-solid fa-building" aria-hidden="true"></i> Your City</label>
                                <div class="input-wrap">
                                    <i class="fa-solid fa-building input-icon" aria-hidden="true"></i>
                                    <input type="text" id="user_city" name="user_city"
                                        placeholder="e.g. Mumbai, Delhi, Kolkata" autocomplete="address-level2" required
                                        value="{{ old('user_city') }}"
                                        class="{{ $errors->has('user_city') ? 'is-invalid' : '' }}">
                                </div>
                                @error('user_city')
                                <p class="field-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field field-full">
                                <label for="user_email"><i class="fa-solid fa-at" aria-hidden="true"></i> Email Address</label>
                                <div class="input-wrap">
                                    <i class="fa-solid fa-at input-icon" aria-hidden="true"></i>
                                    <input type="email" id="user_email" name="user_email"
                                        placeholder="you@example.com" autocomplete="email" required
                                        value="{{ old('user_email') }}"
                                        class="{{ $errors->has('user_email') ? 'is-invalid' : '' }}">
                                </div>
                                @error('user_email')
                                <p class="field-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field field-full">
                                <label for="user_password"><i class="fa-solid fa-lock" aria-hidden="true"></i> Password</label>
                                <div class="input-wrap">
                                    <i class="fa-solid fa-lock input-icon" aria-hidden="true"></i>
                                    <input type="password" id="user_password" name="user_password"
                                        placeholder="At least 8 characters" autocomplete="new-password" required
                                        class="{{ $errors->has('user_password') ? 'is-invalid' : '' }}">
                                    <button type="button" class="eye-btn" onclick="togglePwd('user_password',this)" aria-label="Toggle password visibility">
                                        <i class="fa-regular fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('user_password')
                                <p class="field-error" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-id-card-clip" aria-hidden="true"></i> CREATE MY MEDICAL CARD
                        </button>
                    </form>

                    <div class="form-footer">
                        Already have an account? <button class="link-btn" onclick="switchTab('login')">Login here</button>
                        <br>
                        <a href="/" class="home-link"><i class="fa-solid fa-house" aria-hidden="true"></i> Back to Homepage</a>
                    </div>
                </div>

            </div><!-- /form-scroll -->
        </div><!-- /form-panel-wrap -->
    </div><!-- /auth-wrap -->

    <script>
        /* ── TAB SWITCH ── */
        function switchTab(tab) {
            ['login', 'signup'].forEach(t => {
                const btn = document.getElementById('tab-' + t);
                const pan = document.getElementById('panel-' + t);
                const on = t === tab;
                btn.classList.toggle('active', on);
                btn.setAttribute('aria-selected', on);
                pan.classList.toggle('active', on);
            });
        }

        /* ── PASSWORD TOGGLE ── */
        function togglePwd(id, btn) {
            const inp = document.getElementById(id);
            const icon = btn.querySelector('i');
            const show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        }

        /* ── AUTO-SWITCH TO SIGNUP IF IT HAS ERRORS/OLD INPUT ── */
        (function() {
            const sFields = ['user_name', 'user_mobile', 'user_city'];
            const hasOld = sFields.some(id => {
                const el = document.getElementById(id);
                return el && el.value.trim() !== '';
            });
            const hasErr = document.querySelectorAll('#panel-signup .field-error, #panel-signup .alert-error').length > 0;
            if (hasOld || hasErr) switchTab('signup');
        })();

        /* ── CANVAS PARTICLE NETWORK ── */
        (function() {
            const canvas = document.getElementById('bg-canvas');
            const ctx = canvas.getContext('2d');
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
                for (let i = 0; i < pts.length; i++) {
                    for (let j = i + 1; j < pts.length; j++) {
                        const dx = pts[i].x - pts[j].x,
                            dy = pts[i].y - pts[j].y;
                        const d = Math.sqrt(dx * dx + dy * dy);
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
    </script>

</body>

</html>