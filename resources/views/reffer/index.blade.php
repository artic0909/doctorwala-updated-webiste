@extends('frontend.layout.app')

@section('title', 'Referral Complete - Share & Earn')

@section('content')
<style>
    .success-container {
        max-width: 700px;
        margin: 60px auto;
        padding: 0 15px;
    }
    .celebrate-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        padding: 40px;
        text-align: center;
        position: relative;
    }
    .success-badge {
        width: 80px;
        height: 80px;
        background-color: #e8f5e9;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: #2e7d32;
        font-size: 2.5rem;
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.15);
        animation: scalePop 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes scalePop {
        0% { transform: scale(0.3); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .referral-box {
        background-color: #f8f9fa;
        border: 1.5px solid #dee2e6;
        border-radius: 16px;
        padding: 25px;
        margin: 30px 0;
        text-align: left;
    }
    .referral-code-badge {
        background-color: #e0f7fa;
        color: #00838f;
        font-weight: 700;
        font-size: 1.2rem;
        letter-spacing: 2px;
        padding: 8px 18px;
        border-radius: 8px;
        display: inline-block;
        border: 1px dashed #00acc1;
    }
    .copy-group {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    .copy-input {
        flex-grow: 1;
        border-radius: 10px;
        border: 1.5px solid #ced4da;
        padding: 10px 15px;
        font-size: 0.95rem;
        background-color: #ffffff;
        color: #495057;
        font-family: monospace;
        outline: none;
        text-overflow: ellipsis;
    }
    .copy-btn {
        background-color: #07a1cf;
        border: none;
        color: #ffffff;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .copy-btn:hover {
        background-color: #0d6efd;
        color: #ffffff;
    }
    .share-whatsapp-btn {
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        color: #ffffff;
        border: none;
        border-radius: 50px;
        padding: 16px 40px;
        font-size: 1.15rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        width: 100%;
        justify-content: center;
    }
    .share-whatsapp-btn:hover {
        background: linear-gradient(135deg, #128c7e 0%, #25d366 100%);
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(37, 211, 102, 0.45);
    }
    /* Toast Pager Notification */
    .toast-custom {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(100px);
        background-color: #333;
        color: #fff;
        padding: 12px 25px;
        border-radius: 30px;
        font-size: 0.95rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        z-index: 9999;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s;
        opacity: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .toast-custom.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
    .earnings-banner {
        background-color: #fffde7;
        border: 1px solid #fff59d;
        border-radius: 12px;
        padding: 15px;
        color: #f57f17;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
</style>

<div class="success-container">
    <div class="celebrate-card">
        <div class="success-badge">
            <i class="fa fa-check"></i>
        </div>
        
        <h2 class="font-weight-bold text-dark mb-2">Registration Complete!</h2>
        <p class="text-muted">Thank you for joining the Doctorwala Referral Program. You have been successfully registered.</p>

        @if(session('success'))
            <div class="alert alert-success alert-premium my-3">
                <i class="fa fa-info-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="referral-box">
            <h6 class="text-muted text-uppercase font-weight-bold mb-3" style="letter-spacing: 0.5px; font-size: 0.75rem;">Your Referral Details</h6>
            
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <span class="font-weight-bold text-dark">Referral Code:</span>
                <span class="referral-code-badge">{{ $reffer->referral_code }}</span>
            </div>
            
            <div>
                <span class="font-weight-bold text-dark">Unique Referral Link:</span>
                <div class="copy-group">
                    <input type="text" class="copy-input" id="referral-link-input" value="{{ $referralLink }}" readonly>
                    <button class="copy-btn" id="copy-link-btn">
                        <i class="fa fa-copy" id="copy-icon"></i>
                        <span id="copy-btn-text">Copy</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="my-4">
            <a href="https://api.whatsapp.com/send?text={{ rawurlencode($whatsappMessage) }}" 
               target="_blank" 
               class="share-whatsapp-btn">
                <i class="fab fa-whatsapp" style="font-size: 1.4rem;"></i>
                Share Referral Link on WhatsApp
            </a>
        </div>

        <div class="earnings-banner">
            <i class="fa fa-gift" style="font-size: 1.2rem;"></i>
            Get ₹20 instantly in your UPI account for every friend who registers using your link!
        </div>
    </div>
</div>

<!-- Custom Copy Toast -->
<div class="toast-custom" id="copy-toast">
    <i class="fa fa-check-circle text-success"></i> Link copied to clipboard successfully!
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyBtn = document.getElementById('copy-link-btn');
        const copyInput = document.getElementById('referral-link-input');
        const copyIcon = document.getElementById('copy-icon');
        const copyText = document.getElementById('copy-btn-text');
        const toast = document.getElementById('copy-toast');

        copyBtn.addEventListener('click', function () {
            // Select output link text
            copyInput.select();
            copyInput.setSelectionRange(0, 99999); // For mobile devices

            // Copy to clipboard
            navigator.clipboard.writeText(copyInput.value).then(function() {
                // Change copy button state
                copyText.textContent = 'Copied!';
                copyIcon.className = 'fa fa-check';
                copyBtn.style.backgroundColor = '#2e7d32'; // Change to green

                // Show toast
                toast.classList.add('show');

                // Reset button and toast states after timeout
                setTimeout(function () {
                    copyText.textContent = 'Copy';
                    copyIcon.className = 'fa fa-copy';
                    copyBtn.style.backgroundColor = '#07a1cf';
                    toast.classList.remove('show');
                }, 2500);
            }).catch(function(err) {
                console.error('Could not copy link: ', err);
            });
        });
    });
</script>
@endsection
