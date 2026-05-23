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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
            --primary: #07a1cf;
            --primary-dark: #0582a8;
            --secondary: #0d6efd;
            --success: #25d366;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            --card-bg: rgba(255, 255, 255, 0.95);
            --gradient: linear-gradient(135deg, #07a1cf 0%, #0d6efd 100%);
            --whatsapp-grad: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            background-color: #0b1329;
            background-image: 
                radial-gradient(at 10% 20%, rgba(7, 161, 207, 0.15) 0px, transparent 50%),
                radial-gradient(at 90% 80%, rgba(13, 110, 253, 0.12) 0px, transparent 50%);
            background-attachment: fixed;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            line-height: 1.6;
        }

        header {
            padding: 25px 20px;
            text-align: center;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .logo-img {
            max-height: 50px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(7, 161, 207, 0.3));
        }

        .brand-badge {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #07a1cf;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .brand-badge span {
            color: #fff;
        }

        .success-container {
            max-width: 550px;
            width: 100%;
            margin: 0 auto;
            padding: 20px 15px 40px;
        }

        .celebrate-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 35px 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            text-align: center;
            color: var(--dark);
            position: relative;
        }

        .success-badge {
            width: 76px;
            height: 76px;
            background-color: #e8f5e9;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: #2e7d32;
            font-size: 2.2rem;
            box-shadow: 0 8px 18px rgba(46, 125, 50, 0.12);
            animation: popScale 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popScale {
            0% { transform: scale(0.4); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .desc {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        .info-box {
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: left;
        }

        .info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .info-label {
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray);
        }

        .code-badge {
            background-color: #e0f7fa;
            color: #006064;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 1.5px;
            padding: 6px 16px;
            border-radius: 8px;
            border: 1px dashed #00acc1;
        }

        .link-label {
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray);
            margin-bottom: 6px;
            display: block;
        }

        .copy-group {
            display: flex;
            gap: 8px;
        }

        .copy-input {
            flex-grow: 1;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            padding: 10px 14px;
            font-size: 0.9rem;
            background-color: #fff;
            color: var(--dark);
            font-family: monospace;
            outline: none;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            width: 10px; /* Force flex shrinking */
        }

        .copy-btn {
            background-color: var(--primary);
            border: none;
            color: #fff;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .copy-btn:hover {
            background-color: var(--secondary);
        }

        .share-whatsapp-btn {
            background: var(--whatsapp-grad);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 14px 30px;
            font-size: 1.05rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
            text-decoration: none;
            width: 100%;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .share-whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(37, 211, 102, 0.5);
            color: #fff;
        }

        .earnings-banner {
            background-color: #fffde7;
            border: 1px solid #fff59d;
            border-radius: 12px;
            padding: 12px 16px;
            color: #f57f17;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        /* Custom Notification Toast */
        .toast-custom {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background-color: #1e293b;
            color: #fff;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 0.9rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
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

        footer {
            text-align: center;
            padding: 20px;
            font-size: 0.8rem;
            color: #64748b;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        footer a {
            color: #07a1cf;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .celebrate-card {
                padding: 25px 18px;
            }
            .title {
                font-size: 1.4rem;
            }
            .share-whatsapp-btn {
                padding: 12px 20px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-container">
            @if(file_exists(public_path('img/logo3.png')))
                <img src="{{ asset('img/logo3.png') }}" class="logo-img" alt="Doctorwala Logo">
            @else
                <h2 style="color: #fff; font-weight: 800; letter-spacing: -1px;">Doctor<span style="color:#07a1cf;">wala</span></h2>
            @endif
            <div class="brand-badge">
                <i class="fa fa-bolt"></i> <span>Doctorvibes</span> program
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
                <div style="background-color: #f0fdf4; color: #15803d; border-radius: 10px; padding: 12px; font-size: 0.85rem; margin-bottom: 20px; text-align: left;">
                    <i class="fa fa-info-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="info-box">
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
                <i class="fa fa-gift" style="font-size: 1.1rem;"></i>
                Earn ₹20 instantly in your UPI account for every friend who registers!
            </div>
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
