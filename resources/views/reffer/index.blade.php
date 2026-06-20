<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Share & Earn | Doctorwala & Doctorvibes</title>
    
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
            --success-glow: rgba(46, 125, 50, 0.15);
            --dark: #0f172a;
            --light-bg: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(0, 0, 0, 0.05);
            --text-main: #1e293b;
            --text-mute: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --glow: 0 20px 40px -15px rgba(7, 161, 207, 0.15);
            --whatsapp-grad: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
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

        /* Subtle Background Aura Blobs */
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

        .success-container {
            max-width: 550px;
            width: 100%;
            margin: 0 auto;
            padding: 10px 18px 50px;
        }

        .celebrate-card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: 24px;
            padding: 40px 30px;
            box-shadow: var(--glow);
            text-align: center;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            animation: zoomIn 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .success-badge {
            width: 76px;
            height: 76px;
            background-color: #e8f5e9;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            color: #2e7d32;
            font-size: 2.3rem;
            box-shadow: 0 8px 18px rgba(46, 125, 50, 0.1);
            animation: popScale 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popScale {
            0% { transform: scale(0.3); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .title {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .desc {
            color: var(--text-mute);
            font-size: 0.95rem;
            margin-bottom: 28px;
        }

        .info-box {
            background-color: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 28px;
            text-align: left;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 10px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 12px;
        }

        .info-label {
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-mute);
        }

        .code-badge {
            background-color: #e0f7fa;
            color: #006064;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 1px;
            padding: 6px 16px;
            border-radius: 8px;
            border: 1px dashed #00acc1;
        }

        .link-label {
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-mute);
            margin-bottom: 8px;
            display: block;
        }

        .copy-group {
            display: flex;
            gap: 8px;
        }

        .copy-input {
            flex-grow: 1;
            border-radius: 10px;
            border: 1.5px solid var(--input-border);
            padding: 11px 14px;
            font-size: 0.9rem;
            background-color: #f8fafc;
            color: var(--dark);
            font-family: monospace;
            outline: none;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            width: 10px; /* Force flex shrinking */
            min-width: 0;
        }

        .copy-btn {
            background-color: var(--primary);
            border: none;
            color: #fff;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .copy-btn:hover {
            background-color: var(--primary-dark);
        }

        .share-whatsapp-btn {
            background: var(--whatsapp-grad);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px 30px;
            font-size: 1.05rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 22px rgba(37, 211, 102, 0.25);
            text-decoration: none;
            width: 100%;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .share-whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(37, 211, 102, 0.4);
            color: #fff;
        }

        .earnings-banner {
            background-color: #fffde7;
            border: 1.5px solid #fff59d;
            border-radius: 14px;
            padding: 14px 18px;
            color: #e65100;
            font-weight: 700;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            animation: pulseBanner 2.5s infinite alternate ease-in-out;
        }

        @keyframes pulseBanner {
            0% { transform: scale(1); }
            100% { transform: scale(1.015); }
        }

        /* Custom Notification Toast */
        .toast-custom {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background-color: var(--dark);
            color: #fff;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 0.9rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            z-index: 9999;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s;
            opacity: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .toast-custom.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* Keyframes */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
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

        @media (max-width: 576px) {
            .celebrate-card {
                padding: 24px 16px;
            }
            .title {
                font-size: 1.4rem;
            }
            .info-box {
                padding: 16px;
                margin-bottom: 20px;
            }
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
            .code-badge {
                width: 100%;
                text-align: center;
            }
            .copy-group {
                flex-direction: column;
                width: 100%;
            }
            .copy-btn {
                width: 100%;
                justify-content: center;
            }
            .copy-input {
                width: 100%;
            }
            .share-whatsapp-btn {
                padding: 14px 20px;
                font-size: 0.98rem;
            }
        }
    </style>
</head>
<body>

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

    <div class="success-container">
        <div class="celebrate-card">
            <div class="success-badge">
                <i class="fa fa-check"></i>
            </div>
            
            <h2 class="title">Registration Successful!</h2>
            <p class="desc">Your referral profile is active. You can now invite friends to earn rewards.</p>

            @if(session('success'))
                <div style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 12px; padding: 12px 16px; font-size: 0.88rem; margin-bottom: 20px; text-align: left;">
                    <i class="fa fa-info-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Your Referral Code</span>
                    <span class="code-badge">{{ $reffer->referral_code }}</span>
                </div>
                
                <div>
                    <span class="link-label">Your Unique Sharing Link</span>
                    <div class="copy-group">
                        <input type="text" class="copy-input" id="referral-link-input" value="{{ $referralLink }}" readonly>
                        <button class="copy-btn" id="copy-link-btn">
                            <i class="fa fa-copy" id="copy-icon"></i>
                            <span id="copy-btn-text">Copy</span>
                        </button>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <a href="https://api.whatsapp.com/send?text={{ rawurlencode($whatsappMessage) }}" 
                   target="_blank" 
                   class="share-whatsapp-btn">
                    <i class="fab fa-whatsapp" style="font-size: 1.3rem;"></i>
                    Share Invite on WhatsApp
                </a>
            </div>

            <div class="earnings-banner">
                <i class="fa fa-gift" style="font-size: 1.15rem;"></i>
                Earn ₹20 instantly in your UPI account for every friend who registers!
            </div> -->
        </div>
    </div>

    <!-- Notification Toast -->
    <div class="toast-custom" id="copy-toast">
        <i class="fa-solid fa-circle-check text-success"></i> Link successfully copied to clipboard!
    </div>

    <footer>
        <p>&copy; 2026 <a href="https://doctorwala.info" target="_blank">Doctorwala.info</a>. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyBtn = document.getElementById('copy-link-btn');
            const copyInput = document.getElementById('referral-link-input');
            const copyIcon = document.getElementById('copy-icon');
            const copyText = document.getElementById('copy-btn-text');
            const toast = document.getElementById('copy-toast');

            copyBtn.addEventListener('click', function() {
                // Select input
                copyInput.select();
                copyInput.setSelectionRange(0, 9999);

                // Write to clipboard
                navigator.clipboard.writeText(copyInput.value).then(function() {
                    // Update state
                    copyText.textContent = 'Copied!';
                    copyIcon.className = 'fa-solid fa-check';
                    copyBtn.style.backgroundColor = '#2e7d32'; // Success Green

                    // Show toast
                    toast.classList.add('show');

                    // Reset state
                    setTimeout(function() {
                        copyText.textContent = 'Copy';
                        copyIcon.className = 'fa fa-copy';
                        copyBtn.style.backgroundColor = '#07a1cf'; // Original Blue
                        toast.classList.remove('show');
                    }, 2500);
                }).catch(function(err) {
                    console.error('Error copying link to clipboard: ', err);
                });
            });
        });
    </script>
</body>
</html>
