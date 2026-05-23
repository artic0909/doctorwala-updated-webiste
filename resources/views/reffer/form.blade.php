<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctorwala & Doctorvibes Referral Program - Earn ₹20 Per Referral</title>
    
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
            --success: #2e7d32;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            --card-bg: rgba(255, 255, 255, 0.95);
            --gradient: linear-gradient(135deg, #07a1cf 0%, #0d6efd 100%);
            --glow: 0 10px 30px rgba(7, 161, 207, 0.15);
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

        .referral-container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 20px 15px 40px;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, #80deea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .hero-desc {
            color: #94a3b8;
            font-size: 1rem;
        }

        .promo-banner {
            background: linear-gradient(135deg, rgba(7, 161, 207, 0.15) 0%, rgba(13, 110, 253, 0.15) 100%);
            border: 1px solid rgba(7, 161, 207, 0.3);
            border-radius: 16px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            backdrop-filter: blur(10px);
        }

        .promo-icon {
            font-size: 1.8rem;
            color: #ffd700;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .promo-text {
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffd700;
        }

        .referrer-card {
            background: rgba(7, 161, 207, 0.12);
            border: 1.5px solid rgba(7, 161, 207, 0.3);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .referrer-avatar {
            width: 44px;
            height: 44px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #07a1cf;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .referrer-info h6 {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.5px;
        }

        .referrer-info h5 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
        }

        .step-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            position: relative;
            color: var(--dark);
            transition: all 0.3s ease;
        }

        .step-badge {
            background: var(--primary);
            color: #fff;
            font-weight: 800;
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .step-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .step-desc {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .playstore-btn {
            background: var(--gradient);
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
            text-decoration: none;
            transition: all 0.3s ease;
            width: 100%;
            justify-content: center;
        }

        .playstore-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(13, 110, 253, 0.5);
            color: #fff;
        }

        .playstore-btn.completed {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
        }

        .locked-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.93);
            backdrop-filter: blur(6px);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: all 0.4s ease;
            text-align: center;
            padding: 20px;
        }

        .locked-icon {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 12px;
            animation: floaty 3s ease-in-out infinite;
        }

        @keyframes floaty {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .locked-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .locked-desc {
            font-size: 0.85rem;
            color: var(--gray);
            max-width: 280px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 38px;
            border-radius: 12px;
            border: 1.5px solid #cbd5e1;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--dark);
            transition: all 0.3s ease;
            background: #fff;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(7, 161, 207, 0.12);
        }

        .file-upload-zone {
            border: 2px dashed var(--primary);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .file-upload-zone:hover {
            background: #f0f9ff;
            border-color: var(--secondary);
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .upload-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark);
        }

        .upload-hint {
            font-size: 0.75rem;
            color: var(--gray);
            margin-top: 3px;
        }

        .preview-box {
            margin-top: 15px;
            display: none;
            justify-content: center;
        }

        .preview-img {
            max-width: 100%;
            max-height: 140px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            object-fit: contain;
        }

        .submit-btn {
            background: var(--gradient);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(7, 161, 207, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(7, 161, 207, 0.35);
        }

        .error-banner {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 0.85rem;
        }

        .error-banner ul {
            padding-left: 20px;
            margin-top: 5px;
        }

        /* Validation Feedback styles */
        .invalid-feedback {
            color: #dc2626;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 4px;
            display: none;
        }

        .form-control.invalid {
            border-color: #ef4444;
            background-color: #fffafb;
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

        /* Responsive Breakpoints */
        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.8rem;
            }
            .step-card {
                padding: 18px;
            }
            .playstore-btn, .submit-btn {
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
            <div style="font-weight: 700; display:flex; align-items:center; gap:6px;">
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
                        <i class="fa fa-user input-icon"></i>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control" 
                               placeholder="Enter your full name" 
                               value="{{ old('name') }}" 
                               required 
                               minlength="3" 
                               maxlength="100">
                    </div>
                    <div class="invalid-feedback" id="name-error">Please enter your full name (minimum 3 characters).</div>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone">Phone Number (Numbers Only)</label>
                    <div class="input-wrapper">
                        <i class="fa fa-phone input-icon"></i>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               class="form-control" 
                               placeholder="Enter your 10-digit mobile number" 
                               value="{{ old('phone') }}" 
                               inputmode="numeric"
                               required>
                    </div>
                    <div class="invalid-feedback" id="phone-error">Please enter a valid 10-digit mobile number.</div>
                </div>

                <!-- Payout Details -->
                <div class="form-group">
                    <label for="upi">UPI ID or UPI Phone Number</label>
                    <div class="input-wrapper">
                        <i class="fa fa-credit-card input-icon"></i>
                        <input type="text" 
                               name="upi" 
                               id="upi" 
                               class="form-control" 
                               placeholder="e.g. 9876543210@ybl or phone number" 
                               value="{{ old('upi') }}" 
                               required>
                    </div>
                    <div class="invalid-feedback" id="upi-error">Please enter your UPI ID or UPI phone number.</div>
                </div>

                <!-- Medical Card -->
                <div class="form-group">
                    <label for="medical_card_number">Medical Card Number</label>
                    <div class="input-wrapper">
                        <i class="fa fa-id-card input-icon"></i>
                        <input type="text" 
                               name="medical_card_number" 
                               id="medical_card_number" 
                               class="form-control" 
                               placeholder="Enter medical card number" 
                               value="{{ old('medical_card_number') }}" 
                               required>
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
                // Remove any non-digit characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Limit to maximum 10 digits
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
                }
            });
        });
    </script>
</body>
</html>
