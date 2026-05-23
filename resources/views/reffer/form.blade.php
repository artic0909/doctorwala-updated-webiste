<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctorwala Referral Program - Earn ₹20 Per Referral</title>
    
    <link href="{{asset('fav5.png')}}" rel="icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
            --primary: #07a1cf;
            --primary-dark: #0582a8;
            --secondary: #0d6efd;
            --success: #2e7d32;
            --dark: #0f172a;
            --light-bg: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(0, 0, 0, 0.05);
            --text-main: #1e293b;
            --text-mute: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --glow: 0 20px 40px -15px rgba(7, 161, 207, 0.15);
            --gradient: linear-gradient(135deg, #07a1cf 0%, #0d6efd 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(7, 161, 207, 0.08) 0px, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(13, 110, 253, 0.06) 0px, transparent 40%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            line-height: 1.6;
        }

        .bg-blob-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        /* Subtle Floating Background Blobs */
        .bg-glow-blob {
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.55;
            pointer-events: none;
            animation: floatBlob 12s infinite alternate ease-in-out;
        }

        .blob-cyan {
            background-color: rgba(7, 161, 207, 0.15);
            top: -100px;
            left: -100px;
        }

        .blob-blue {
            background-color: rgba(13, 110, 253, 0.1);
            bottom: 10%;
            right: -100px;
            animation-delay: -6s;
        }

        @keyframes floatBlob {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.15); }
        }

        header {
            padding: 30px 20px;
            text-align: center;
            animation: fadeInDown 0.8s ease-out;
        }

        .logo-container {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .logo-img {
            max-height: 55px;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(7, 161, 207, 0.15));
        }

        .brand-badge {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(7, 161, 207, 0.25);
            box-shadow: 0 4px 10px rgba(7, 161, 207, 0.08);
            padding: 5px 14px;
            border-radius: 30px;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--primary-dark);
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .brand-badge span {
            color: var(--dark);
        }

        .referral-container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 10px 18px 50px;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero-title {
            font-size: 2.4rem;
            font-weight: 900;
            color: var(--dark);
            margin-bottom: 10px;
            letter-spacing: -0.8px;
        }

        .hero-desc {
            color: var(--text-mute);
            font-size: 1.02rem;
        }

        .promo-banner {
            background: linear-gradient(135deg, rgba(7, 161, 207, 0.1) 0%, rgba(13, 110, 253, 0.1) 100%);
            border: 1.5px solid rgba(7, 161, 207, 0.2);
            box-shadow: 0 8px 20px rgba(7, 161, 207, 0.06);
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            backdrop-filter: blur(10px);
            animation: pulseBanner 3s infinite alternate ease-in-out;
        }

        @keyframes pulseBanner {
            0% { transform: scale(1); }
            100% { transform: scale(1.015); }
        }

        .promo-icon {
            font-size: 1.9rem;
            color: #e65100;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .promo-text {
            font-weight: 800;
            font-size: 1.15rem;
            color: #e65100;
        }

        .referrer-card {
            background: rgba(7, 161, 207, 0.05);
            border: 1px solid rgba(7, 161, 207, 0.15);
            border-radius: 18px;
            padding: 16px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            backdrop-filter: blur(8px);
            animation: fadeInUp 0.8s ease-out;
        }

        .referrer-avatar {
            width: 44px;
            height: 44px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(7, 161, 207, 0.2);
        }

        .referrer-info h6 {
            font-size: 0.72rem;
            text-transform: uppercase;
            color: var(--text-mute);
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .referrer-info h5 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--dark);
        }

        /* Glassmorphism Card Style */
        .step-card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: var(--glow);
            position: relative;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            animation: fadeInUp 0.9s ease-out;
        }

        .step-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -15px rgba(7, 161, 207, 0.22);
        }

        .step-badge {
            background: var(--gradient);
            color: #fff;
            font-weight: 800;
            font-size: 0.72rem;
            padding: 5px 14px;
            border-radius: 30px;
            display: inline-block;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(7, 161, 207, 0.15);
        }

        .step-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .step-desc {
            color: var(--text-mute);
            font-size: 0.92rem;
            margin-bottom: 22px;
        }

        .playstore-btn {
            background: var(--gradient);
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.2);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            width: 100%;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .playstore-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.35) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            animation: shineBtn 2.5s infinite;
        }

        @keyframes shineBtn {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .playstore-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(13, 110, 253, 0.35);
            color: #fff;
        }

        .playstore-btn.completed {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.2);
        }

        .playstore-btn.completed::before {
            display: none;
        }

        /* Glassmorphism Locked Overlay */
        .locked-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 20;
            transition: all 0.4s ease-out;
            text-align: center;
            padding: 20px;
        }

        .locked-icon {
            font-size: 3.5rem;
            color: var(--text-mute);
            margin-bottom: 12px;
            animation: floatLock 3s infinite ease-in-out;
        }

        @keyframes floatLock {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .locked-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .locked-desc {
            font-size: 0.88rem;
            color: var(--text-mute);
            max-width: 300px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.92rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-mute);
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 13px 15px 13px 42px;
            border-radius: 12px;
            border: 1.5px solid var(--input-border);
            font-size: 0.96rem;
            font-family: inherit;
            color: var(--dark);
            transition: all 0.3s ease;
            background: var(--input-bg);
            outline: none;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(7, 161, 207, 0.12);
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .file-upload-zone {
            border: 2px dashed rgba(7, 161, 207, 0.4);
            border-radius: 12px;
            padding: 22px;
            text-align: center;
            background: rgba(7, 161, 207, 0.01);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .file-upload-zone:hover {
            background: rgba(7, 161, 207, 0.04);
            border-color: var(--primary);
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 5;
        }

        .upload-icon {
            font-size: 2.2rem;
            color: var(--primary);
            margin-bottom: 8px;
            transition: transform 0.3s ease;
        }

        .file-upload-zone:hover .upload-icon {
            transform: translateY(-2px);
        }

        .upload-text {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--dark);
        }

        .upload-hint {
            font-size: 0.78rem;
            color: var(--text-mute);
            margin-top: 3px;
        }

        .preview-box {
            margin-top: 15px;
            display: none;
            justify-content: center;
            animation: zoomIn 0.3s ease;
        }

        .preview-img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 8px;
            border: 1.5px solid #cbd5e1;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            object-fit: contain;
        }

        .submit-btn {
            background: var(--gradient);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 800;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(7, 161, 207, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(7, 161, 207, 0.35);
        }

        .error-banner {
            background: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 0.88rem;
            text-align: left;
            animation: shake 0.4s ease;
        }

        .error-banner ul {
            padding-left: 20px;
            margin-top: 6px;
        }

        /* Validation Feedback styles */
        .invalid-feedback {
            color: #c53030;
            font-size: 0.78rem;
            font-weight: 600;
            margin-top: 6px;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .form-control.invalid {
            border-color: #fc8181;
            background-color: #fff5f5;
        }

        /* Keyframes */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        footer {
            text-align: center;
            padding: 30px;
            font-size: 0.82rem;
            color: var(--text-mute);
            border-top: 1px solid rgba(0, 0, 0, 0.04);
            margin-top: auto;
        }

        footer a {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 600;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -10px;
            margin-left: -10px;
        }
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
            padding-right: 10px;
            padding-left: 10px;
        }
        @media (min-width: 576px) {
            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        /* Instructions Modal Styles */
        .instructions-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }

        .instructions-modal-content {
            background: #ffffff;
            border-radius: 24px;
            width: 90%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1.5px solid rgba(255, 255, 255, 0.8);
            display: flex;
            flex-direction: column;
            animation: modalZoomIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.15);
        }

        @keyframes modalZoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            padding: 20px 24px 15px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .modal-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-logo h4 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--dark);
            margin: 0;
        }

        .lang-tabs {
            display: flex;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 30px;
        }

        .lang-tab-btn {
            border: none;
            background: none;
            padding: 6px 16px;
            font-size: 0.82rem;
            font-weight: 700;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-mute);
        }

        .lang-tab-btn:hover {
            color: var(--primary-dark);
        }

        .lang-tab-btn.active {
            background: #ffffff;
            color: var(--primary-dark);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
            flex-grow: 1;
        }

        .intro-text {
            font-size: 0.9rem;
            color: var(--text-main);
            font-weight: 600;
            margin-bottom: 16px;
        }

        .lang-content {
            display: none;
        }

        .lang-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .instruction-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .instruction-list li {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .step-num {
            background: rgba(7, 161, 207, 0.1);
            color: var(--primary-dark);
            font-weight: 800;
            font-size: 0.9rem;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(7, 161, 207, 0.2);
        }

        .step-text {
            font-size: 0.88rem;
            color: var(--text-main);
            line-height: 1.5;
        }

        .step-text strong {
            color: var(--dark);
        }

        .modal-footer {
            padding: 16px 24px 20px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
        }

        .modal-close-btn {
            background: var(--gradient);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(7, 161, 207, 0.2);
        }

        .modal-close-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(7, 161, 207, 0.3);
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            .step-card {
                padding: 24px 18px;
            }
            .instructions-modal-content {
                max-height: 95vh;
            }
            .modal-header {
                padding: 16px 20px 12px;
            }
            .modal-body {
                padding: 20px;
            }
            .modal-footer {
                padding: 12px 20px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Instructions Modal (Bilingual) -->
    <div class="instructions-modal-overlay" id="instructions-modal">
        <div class="instructions-modal-content">
            <div class="modal-header">
                <div class="modal-logo">
                    <i class="fa-solid fa-circle-info" style="color: var(--primary); font-size: 1.5rem;"></i>
                    <h4>Instructions / নির্দেশাবলী</h4>
                </div>
                <div class="lang-tabs">
                    <button type="button" class="lang-tab-btn active" data-lang="bengali">বাংলা</button>
                    <button type="button" class="lang-tab-btn" data-lang="english">English</button>
                </div>
            </div>
            
            <div class="modal-body">
                <!-- Bengali Instructions -->
                <div class="lang-content active" id="lang-bengali">
                    <p class="intro-text">রেফারেল বোনাস পেতে নিচের ধাপগুলো অনুসরণ করুন:</p>
                    <ul class="instruction-list">
                        <li>
                            <span class="step-num">১</span>
                            <div class="step-text">
                                <strong>অ্যাপ ডাউনলোড করুন:</strong> প্রথমে নিচে দেওয়া <strong>"Download & Register"</strong> বাটনে ক্লিক করে গুগল প্লে স্টোর থেকে ডক্টরওয়ালা অ্যাপটি ইনস্টল করুন এবং রেজিস্ট্রেশন সম্পন্ন করুন।
                            </div>
                        </li>
                        <li>
                            <span class="step-num">২</span>
                            <div class="step-text">
                                <strong>প্রোফাইল স্ক্রিনশট নিন:</strong> অ্যাপে সফলভাবে রেজিস্টার করার পর, প্রোফাইল সেকশনে গিয়ে আপনার প্রোফাইলের একটি স্ক্রিনশট (Screenshot) নিন।
                            </div>
                        </li>
                        <li>
                            <span class="step-num">৩</span>
                            <div class="step-text">
                                <strong>ফরমটি পূরণ করুন:</strong> আবার এই পেজে ফিরে এসে আপনার সঠিক নাম, ফোন নম্বর, ইউপিআই আইডি (যেখানে টাকা পেতে চান) ও মেডিকেল কার্ড নম্বর দিন এবং স্ক্রিনশটটি আপলোড করুন।
                            </div>
                        </li>
                        <li>
                            <span class="step-num">৪</span>
                            <div class="step-text">
                                <strong>রেফার লিংক শেয়ার করুন:</strong> ফরম সাবমিট করার পর আপনার একটি ইউনিক রেফার লিংক তৈরি হবে। বন্ধুদের সাথে সেটি শেয়ার করে প্রতি সফল রেফারেলে <strong>২০ টাকা</strong> আয় করুন!
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- English Instructions -->
                <div class="lang-content" id="lang-english">
                    <p class="intro-text">Follow these steps to claim your referral rewards:</p>
                    <ul class="instruction-list">
                        <li>
                            <span class="step-num">1</span>
                            <div class="step-text">
                                <strong>Download the App:</strong> Click the <strong>"Download & Register"</strong> button below to install the Doctorwala app from Google Play Store and complete your registration.
                            </div>
                        </li>
                        <li>
                            <span class="step-num">2</span>
                            <div class="step-text">
                                <strong>Take Profile Screenshot:</strong> After successfully registering on the app, go to your profile section and take a screenshot (SS) of your profile page.
                            </div>
                        </li>
                        <li>
                            <span class="step-num">3</span>
                            <div class="step-text">
                                <strong>Fill up the Form:</strong> Return to this page, enter your Name, Phone Number, UPI ID (for receiving payments), Medical Card Number, and upload the screenshot.
                            </div>
                        </li>
                        <li>
                            <span class="step-num">4</span>
                            <div class="step-text">
                                <strong>Share & Earn:</strong> Submit the form to generate your unique referral link. Share it with friends and earn <strong>₹20</strong> for every successful signup!
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="modal-close-btn" id="close-modal-btn">
                    Close / বন্ধ করুন
                </button>
            </div>
        </div>
    </div>

    <!-- Background blobs wrapper -->
    <div class="bg-blob-wrapper">
        <div class="bg-glow-blob blob-cyan"></div>
        <div class="bg-glow-blob blob-blue"></div>
    </div>

    <header>
        <div class="logo-container">
            @if(file_exists(public_path('img/logo3.png')))
                <img src="{{ asset('img/logo3.png') }}" class="logo-img" alt="Doctorwala Logo">
            @else
                <h2 style="color: var(--dark); font-weight: 900; letter-spacing: -1.2px; font-size: 1.8rem;">Doctor<span style="color:#07a1cf;">wala</span></h2>
            @endif
            <div class="brand-badge">
                <i class="fa fa-bolt"></i> <span>Referral</span> program
            </div>
        </div>
    </header>

    <div class="referral-container">
        
        <div class="hero-section">
            <h1 class="hero-title">Refer & Earn Program</h1>
            <p class="hero-desc">Invite friends to Doctorwala, and claim instant cash rewards!</p>
        </div>

        <div class="promo-banner">
            <i class="fa fa-gift promo-icon"></i>
            <span class="promo-text">Get ₹20 per active referral!</span>
        </div>

        <!-- Referrer Card -->
        @if($referrer)
        <div class="referrer-card">
            <div class="referrer-avatar">
                <i class="fa fa-user-plus"></i>
            </div>
            <div class="referrer-info">
                <h6>You are invited by</h6>
                <h5>{{ $referrer->name }}</h5>
            </div>
        </div>
        @endif

        <!-- Server side validation alerts -->
        @if ($errors->any())
        <div class="error-banner">
            <div style="font-weight: 800; display:flex; align-items:center; gap:6px;">
                <i class="fa fa-exclamation-circle"></i> Submission failed:
            </div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Step 1: Download & Install App -->
        <div class="step-card">
            <span class="step-badge">Step 1</span>
            <h3 class="step-title">Get Doctorwala App</h3>
            <p class="step-desc">Click the button below to download the application from the Google Play Store and complete your account registration.</p>
            
            <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" 
               target="_blank" 
               id="download-app-btn" 
               class="playstore-btn">
                <i class="fab fa-google-play"></i>
                <span id="download-btn-text">Download & Register</span>
            </a>
        </div>

        <!-- Step 2: Referral Verification Form -->
        <div class="step-card" id="form-step-card">
            <!-- Lock Overlay -->
            <div class="locked-overlay" id="form-lock-overlay">
                <div class="locked-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h4 class="locked-title">Form Locked</h4>
                <p class="locked-desc">Please complete Step 1 (Download App) above to unlock your referral application form.</p>
            </div>

            <span class="step-badge">Step 2</span>
            <h3 class="step-title">Enter Payment Details</h3>
            
            <form action="{{ route('reffer.store') }}" method="POST" enctype="multipart/form-data" id="referral-submit-form" novalidate>
                @csrf
                <input type="hidden" name="referred_by_code" value="{{ $referrer ? $referrer->referral_code : '' }}">

                <!-- Full Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-wrapper">
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control" 
                               placeholder="Enter your full name" 
                               value="{{ old('name') }}" 
                               required 
                               minlength="3" 
                               maxlength="100">
                        <i class="fa fa-user input-icon"></i>
                    </div>
                    <div class="invalid-feedback" id="name-error">Please enter your full name (minimum 3 characters).</div>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone">Phone Number (Numbers Only)</label>
                    <div class="input-wrapper">
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               class="form-control" 
                               placeholder="Enter your 10-digit mobile number" 
                               value="{{ old('phone') }}" 
                               inputmode="numeric"
                               required>
                        <i class="fa fa-phone input-icon"></i>
                    </div>
                    <div class="invalid-feedback" id="phone-error">Please enter a valid 10-digit mobile number.</div>
                </div>

                <!-- Payout Details -->
                <div class="form-group">
                    <label for="upi">UPI ID or UPI Phone Number</label>
                    <div class="input-wrapper">
                        <input type="text" 
                               name="upi" 
                               id="upi" 
                               class="form-control" 
                               placeholder="e.g. 9876543210@ybl or phone number" 
                               value="{{ old('upi') }}" 
                               required>
                        <i class="fa fa-credit-card input-icon"></i>
                    </div>
                    <div class="invalid-feedback" id="upi-error">Please enter your UPI ID or UPI phone number.</div>
                </div>

                <!-- Medical Card -->
                <div class="form-group">
                    <label for="medical_card_number">Medical Card Number</label>
                    <div class="input-wrapper">
                        <input type="text" 
                               name="medical_card_number" 
                               id="medical_card_number" 
                               class="form-control" 
                               placeholder="Enter medical card number" 
                               value="{{ old('medical_card_number') }}" 
                               required>
                        <i class="fa fa-id-card input-icon"></i>
                    </div>
                    <div class="invalid-feedback" id="medical_card-error">Please enter your medical card number.</div>
                </div>

                <!-- Profile Screenshot Upload -->
                <div class="form-group">
                    <label>Profile Screenshot (SS)</label>
                    <div class="file-upload-zone">
                        <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                        <div class="upload-text" id="upload-filename">Choose Screenshot Image</div>
                        <div class="upload-hint">Format: JPG, PNG, WEBP (Max 5MB)</div>
                        <input type="file" 
                               name="profile_screenshot" 
                               id="profile_screenshot" 
                               class="file-input" 
                               accept="image/*" 
                               required>
                    </div>
                    <div class="invalid-feedback" id="file-error">Please upload a valid profile screenshot (Max 5MB).</div>
                    <div class="preview-box" id="preview-box">
                        <img src="#" alt="Upload Preview" class="preview-img" id="preview-img">
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn" id="submit-form-btn">
                    <i class="fa fa-share-nodes"></i> Generate Referral Link
                </button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 <a href="https://doctorwala.info" target="_blank">Doctorwala.info</a>. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadBtn = document.getElementById('download-app-btn');
            const downloadBtnText = document.getElementById('download-btn-text');
            const lockOverlay = document.getElementById('form-lock-overlay');
            const formStepCard = document.getElementById('form-step-card');
            const formInputs = formStepCard.querySelectorAll('input, button[type="submit"]');
            
            const form = document.getElementById('referral-submit-form');
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            const upiInput = document.getElementById('upi');
            const medicalCardInput = document.getElementById('medical_card_number');
            const fileInput = document.getElementById('profile_screenshot');
            const uploadLabel = document.getElementById('upload-filename');
            const previewBox = document.getElementById('preview-box');
            const previewImg = document.getElementById('preview-img');

            // 1. Force strict numeric-only on Phone number input & limit to 10 digits
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

            // 2. Lock/Unlock state helpers
            function setFormLock(isLocked) {
                formInputs.forEach(input => {
                    if (input.name !== 'referred_by_code' && input.name !== '_token') {
                        input.disabled = isLocked;
                    }
                });
                
                if (isLocked) {
                    lockOverlay.style.display = 'flex';
                    lockOverlay.style.opacity = '1';
                } else {
                    lockOverlay.style.opacity = '0';
                    setTimeout(() => {
                        lockOverlay.style.display = 'none';
                    }, 400);
                }
            }

            function setBtnCompleted() {
                downloadBtn.classList.add('completed');
                downloadBtnText.textContent = 'App Download Initiated ✓';
            }

            // Check localStorage
            const appDownloaded = localStorage.getItem('doctorwala_app_downloaded') === 'true';
            if (appDownloaded) {
                setFormLock(false);
                setBtnCompleted();
            } else {
                setFormLock(true);
            }

            // Play Store click trigger
            downloadBtn.addEventListener('click', function() {
                localStorage.setItem('doctorwala_app_downloaded', 'true');
                setFormLock(false);
                setBtnCompleted();
            });

            // File input changed preview & size limit check
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                const errorDiv = document.getElementById('file-error');
                
                if (file) {
                    // Check size (5MB = 5 * 1024 * 1024 bytes)
                    if (file.size > 5242880) {
                        errorDiv.textContent = 'Screenshot file size exceeds 5MB limit.';
                        errorDiv.style.display = 'block';
                        this.value = ''; // Reset input
                        uploadLabel.textContent = 'Choose Screenshot Image';
                        previewBox.style.display = 'none';
                        previewImg.src = '#';
                        return;
                    }

                    errorDiv.style.display = 'none';
                    uploadLabel.textContent = file.name;
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewBox.style.display = 'flex';
                    };
                    reader.readAsDataURL(file);
                } else {
                    uploadLabel.textContent = 'Choose Screenshot Image';
                    previewBox.style.display = 'none';
                    previewImg.src = '#';
                }
            });

            // 3. Complete Form Validation on Submit
            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Reset states
                form.querySelectorAll('.form-control').forEach(el => el.classList.remove('invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

                // Validate Name
                if (nameInput.value.trim().length < 3) {
                    nameInput.classList.add('invalid');
                    document.getElementById('name-error').style.display = 'block';
                    isValid = false;
                }

                // Validate Phone (must be numeric and exactly 10 digits)
                const phoneReg = /^[0-9]{10}$/;
                if (!phoneReg.test(phoneInput.value)) {
                    phoneInput.classList.add('invalid');
                    document.getElementById('phone-error').style.display = 'block';
                    isValid = false;
                }

                // Validate UPI
                if (upiInput.value.trim() === '') {
                    upiInput.classList.add('invalid');
                    document.getElementById('upi-error').style.display = 'block';
                    isValid = false;
                }

                // Validate Medical Card
                if (medicalCardInput.value.trim() === '') {
                    medicalCardInput.classList.add('invalid');
                    document.getElementById('medical_card-error').style.display = 'block';
                    isValid = false;
                }

                // Validate Screenshot file
                if (!fileInput.files || fileInput.files.length === 0) {
                    document.getElementById('file-error').textContent = 'Please upload a profile screenshot.';
                    document.getElementById('file-error').style.display = 'block';
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault(); // Stop form submission
                    
                    // Shake the card to indicate failure
                    formStepCard.style.animation = 'none';
                    formStepCard.offsetHeight; // trigger reflow
                    formStepCard.style.animation = 'shake 0.4s ease';
                }
            });

            // --- Instructions Modal Logic ---
            const modal = document.getElementById('instructions-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const tabBtns = document.querySelectorAll('.lang-tab-btn');
            const tabContents = document.querySelectorAll('.lang-content');

            // Handle language tab clicks
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const selectedLang = this.getAttribute('data-lang');
                    
                    // Update active button
                    tabBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Update active content
                    tabContents.forEach(content => {
                        if (content.id === `lang-${selectedLang}`) {
                            content.classList.add('active');
                        } else {
                            content.classList.remove('active');
                        }
                    });
                });
            });

            // Close modal button click
            closeModalBtn.addEventListener('click', function() {
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 350);
            });

            // Prevent closing modal when clicking backdrop (non-closable except by button)
            modal.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Prevent ESC key from closing
            window.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.style.display !== 'none') {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
