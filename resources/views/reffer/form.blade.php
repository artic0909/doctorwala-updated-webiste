@extends('frontend.layout.app')

@section('title', 'Doctorwala Referral Program - Download & Register')

@section('content')
<style>
    .referral-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 15px;
    }
    .referrer-card {
        background: linear-gradient(135deg, #e0f7fa 0%, #80deea 100%);
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(7, 161, 207, 0.15);
        color: #006064;
        transition: all 0.3s ease;
    }
    .referrer-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(7, 161, 207, 0.25);
    }
    .step-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        transition: all 0.4s ease;
    }
    .step-badge {
        background-color: #07a1cf;
        color: #fff;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.85rem;
        display: inline-block;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .playstore-btn {
        background: linear-gradient(135deg, #07a1cf 0%, #0d6efd 100%);
        color: #ffffff;
        border: none;
        padding: 16px 32px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    .playstore-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -50%;
        width: 200%;
        height: 100%;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
        transform: skewX(-25deg);
        transition: 0.75s;
        animation: shiner 3s infinite;
    }
    @keyframes shiner {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    .playstore-btn:hover {
        background: linear-gradient(135deg, #0d6efd 0%, #07a1cf 100%);
        color: #ffffff;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 25px rgba(13, 110, 253, 0.45);
    }
    .playstore-btn.completed {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
    }
    .playstore-btn.completed::after {
        display: none;
    }
    /* Locked state styling */
    .locked-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(5px);
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: all 0.5s ease;
        text-align: center;
        padding: 20px;
    }
    .locked-icon {
        font-size: 3.5rem;
        color: #6c757d;
        margin-bottom: 15px;
        animation: floaty 3s ease-in-out infinite;
    }
    @keyframes floaty {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    .form-group-custom {
        margin-bottom: 20px;
    }
    .form-group-custom label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }
    .form-control-custom {
        border-radius: 12px;
        border: 1.5px solid #dee2e6;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
        outline: none;
    }
    .form-control-custom:focus {
        border-color: #07a1cf;
        box-shadow: 0 0 0 4px rgba(7, 161, 207, 0.15);
    }
    .file-upload-wrapper {
        border: 2px dashed #07a1cf;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        background-color: #f8fdff;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }
    .file-upload-wrapper:hover {
        background-color: #f0faff;
        border-color: #0d6efd;
    }
    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .upload-icon {
        font-size: 2.5rem;
        color: #07a1cf;
        margin-bottom: 10px;
    }
    .preview-container {
        margin-top: 15px;
        display: none;
        justify-content: center;
    }
    .preview-img {
        max-width: 150px;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        object-fit: contain;
        border: 2px solid #dee2e6;
    }
    .submit-btn {
        background: linear-gradient(135deg, #07a1cf 0%, #0d6efd 100%);
        border: none;
        border-radius: 12px;
        color: #fff;
        padding: 14px 28px;
        font-size: 1.1rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(7, 161, 207, 0.2);
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(7, 161, 207, 0.35);
        color: #fff;
    }
    .alert-premium {
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 0.95rem;
        border: none;
    }
</style>

<div class="referral-container">
    <div class="text-center mb-5">
        <h1 class="display-6 font-weight-bold text-dark">Doctorwala Referral Program</h1>
        <p class="text-muted lead">Refer friends, earn money. Get <strong>₹20</strong> for every successful signup!</p>
    </div>

    <!-- Referral Alert Banner -->
    @if($referrer)
    <div class="card referrer-card mb-4">
        <div class="card-body d-flex align-items-center gap-3 p-4">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="fa fa-user-check text-cyan" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h6 class="mb-1 text-uppercase font-weight-bold" style="letter-spacing: 0.5px; font-size: 0.8rem;">You were invited by</h6>
                <h5 class="mb-0 font-weight-bold">{{ $referrer->name }}</h5>
            </div>
        </div>
    </div>
    @endif

    <!-- Error/Success Feedbacks -->
    @if ($errors->any())
        <div class="alert alert-danger alert-premium mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fa fa-exclamation-triangle"></i>
                <strong>Please fix the errors below:</strong>
            </div>
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Step 1: Download & Register -->
    <div class="step-card">
        <div class="step-badge">Step 1</div>
        <h4 class="font-weight-bold text-dark mb-3">Download Doctorwala & Register</h4>
        <p class="text-muted mb-4">
            To participate and qualify for referral rewards, you must first install the Doctorwala Mobile App and register your profile. Click the button below to get redirected to the Google Play Store.
        </p>
        <div class="text-center py-2">
            <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" 
               target="_blank" 
               id="playstore-redirect-btn" 
               class="playstore-btn">
                <i class="fab fa-google-play"></i>
                <span id="btn-text">Download App & Register</span>
            </a>
        </div>
    </div>

    <!-- Step 2: Complete Referral Application Form -->
    <div class="step-card" id="form-step-card">
        <!-- Locked Overlay -->
        <div class="locked-overlay" id="locked-overlay">
            <div class="locked-icon">
                <i class="fa fa-lock"></i>
            </div>
            <h5 class="font-weight-bold text-dark mb-2">Form Locked</h5>
            <p class="text-muted max-width-400 mb-0">
                You must click the **Download App & Register** button in Step 1 to unlock this form and complete your registration.
            </p>
        </div>

        <div class="step-badge">Step 2</div>
        <h4 class="font-weight-bold text-dark mb-4">Referral Payout Details</h4>
        
        <form action="{{ route('reffer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Hidden Referrer Code Field -->
            <input type="hidden" name="referred_by_code" value="{{ $referrer ? $referrer->referral_code : '' }}">

            <div class="row">
                <div class="col-md-6 form-group-custom">
                    <label for="name">Full Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-control-custom" 
                           placeholder="Enter your full name" 
                           value="{{ old('name') }}" 
                           required>
                </div>

                <div class="col-md-6 form-group-custom">
                    <label for="phone">Phone Number</label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           class="form-control-custom" 
                           placeholder="Enter registered mobile number" 
                           value="{{ old('phone') }}" 
                           required>
                </div>
            </div>

            <div class="form-group-custom">
                <label for="upi">Bank Details / UPI ID / UPI Phone Number</label>
                <input type="text" 
                       id="upi" 
                       name="upi" 
                       class="form-control-custom" 
                       placeholder="e.g. UPI ID (9876543210@ybl) or Bank Details" 
                       value="{{ old('upi') }}" 
                       required>
                </div>

            <div class="form-group-custom">
                <label for="medical_card_number">Medical Card Number</label>
                <input type="text" 
                       id="medical_card_number" 
                       name="medical_card_number" 
                       class="form-control-custom" 
                       placeholder="Enter your Doctorwala medical card number" 
                       value="{{ old('medical_card_number') }}" 
                       required>
            </div>

            <div class="form-group-custom">
                <label>Profile Screenshot (SS)</label>
                <p class="text-muted small mb-2">Upload a screenshot of your app profile page as registration proof.</p>
                <div class="file-upload-wrapper">
                    <div class="upload-icon">
                        <i class="fa fa-cloud-upload-alt"></i>
                    </div>
                    <h6 class="mb-1 text-dark font-weight-bold" id="upload-label-title">Choose image file or drag here</h6>
                    <p class="text-muted small mb-0">Supports JPG, PNG, WEBP (Max 5MB)</p>
                    <input type="file" 
                           name="profile_screenshot" 
                           id="profile_screenshot" 
                           class="file-upload-input" 
                           accept="image/*" 
                           required>
                </div>
                <div class="preview-container" id="preview-container">
                    <img src="#" alt="Screenshot Preview" class="preview-img" id="preview-img">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn submit-btn">
                    <i class="fa fa-paper-plane mr-2"></i> Register & Generate Referral Link
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const playstoreBtn = document.getElementById('playstore-redirect-btn');
        const btnText = document.getElementById('btn-text');
        const lockedOverlay = document.getElementById('locked-overlay');
        const formStepCard = document.getElementById('form-step-card');
        const inputs = formStepCard.querySelectorAll('input, button[type="submit"]');
        const screenshotInput = document.getElementById('profile_screenshot');
        const previewContainer = document.getElementById('preview-container');
        const previewImg = document.getElementById('preview-img');
        const uploadTitle = document.getElementById('upload-label-title');

        // Helper function to lock form inputs
        function setFormLockedState(locked) {
            inputs.forEach(input => {
                if (input.name !== 'referred_by_code' && input.name !== '_token') {
                    input.disabled = locked;
                }
            });
            if (locked) {
                lockedOverlay.style.display = 'flex';
                lockedOverlay.style.opacity = '1';
            } else {
                // Fade out transition
                lockedOverlay.style.opacity = '0';
                setTimeout(() => {
                    lockedOverlay.style.display = 'none';
                }, 400);
            }
        }

        // Helper to update play store button style
        function setBtnCompleted() {
            playstoreBtn.classList.add('completed');
            btnText.textContent = 'App Download Initiated ✓';
        }

        // Initial load check from localStorage
        const isDownloaded = localStorage.getItem('doctorwala_app_downloaded') === 'true';
        if (isDownloaded) {
            setFormLockedState(false);
            setBtnCompleted();
        } else {
            setFormLockedState(true);
        }

        // Listen for Play Store redirect click
        playstoreBtn.addEventListener('click', function () {
            localStorage.setItem('doctorwala_app_downloaded', 'true');
            setFormLockedState(false);
            setBtnCompleted();
        });

        // Screenshot upload preview handler
        screenshotInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                uploadTitle.textContent = file.name;
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewContainer.style.display = 'flex';
                }
                reader.readAsDataURL(file);
            } else {
                uploadTitle.textContent = "Choose image file or drag here";
                previewContainer.style.display = 'none';
                previewImg.src = "#";
            }
        });
    });
</script>
@endsection
