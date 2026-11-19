<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Super Admin Sign In | DoctorWala</title>

    <link rel="icon" type="image/png" href="{{ asset('fav5.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --brand-primary: #0284c7;
            --brand-primary-hover: #0369a1;
            --brand-dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(2, 132, 199, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(14, 165, 233, 0.08) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(241, 245, 249, 0.5) 0px, transparent 100%);
            margin: 0;
            padding: 24px 16px;
        }

        .login-card-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
            padding: 40px 36px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0284c7 0%, #38bdf8 100%);
        }

        .brand-logo-wrap {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo {
            max-height: 52px;
            width: auto;
            object-fit: contain;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            background: #f0f9ff;
            color: #0369a1;
            border: 1px solid #bae6fd;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 20px;
            margin-top: 12px;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
        }

        .custom-input-group {
            position: relative;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s;
            z-index: 4;
        }

        .form-control-custom {
            height: 48px;
            padding-left: 42px;
            padding-right: 42px;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            font-size: 0.92rem;
            font-weight: 500;
            color: #0f172a;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
        }

        .form-control-custom:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.12);
            outline: none;
        }

        .form-control-custom:focus + .input-icon-left,
        .custom-input-group:focus-within .input-icon-left {
            color: var(--brand-primary);
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            padding: 6px;
            cursor: pointer;
            z-index: 5;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: #334155;
        }

        .btn-brand-login {
            height: 48px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
            transition: all 0.2s ease-in-out;
        }

        .btn-brand-login:hover {
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
            color: #ffffff;
        }

        .btn-brand-login:active {
            transform: translateY(0);
        }

        .form-check-input:checked {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }

        .auth-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
        }

        .security-badge {
            font-size: 0.75rem;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
            margin-top: 18px;
        }

        .back-link:hover {
            color: var(--brand-primary);
        }
    </style>
</head>
<body>

<div class="login-card-wrapper">
    <div class="login-card">
        <!-- Logo & Title -->
        <div class="brand-logo-wrap">
            <a href="/">
                <img src="{{ asset('img/logo.png') }}" alt="DoctorWala" class="brand-logo">
            </a>
            <div>
                <span class="admin-badge">
                    <i class="fa-solid fa-shield-halved me-1"></i> Super Admin Portal
                </span>
            </div>
            <h4 class="mt-3 mb-1 fw-bold text-dark" style="letter-spacing: -0.3px;">Sign In</h4>
            <p class="text-muted small mb-0">Enter your credentials to access system control</p>
        </div>

        <!-- Session Status Alert -->
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center py-2 px-3 mb-3" role="alert" style="border-radius: 8px; font-size: 0.85rem;">
                <i class="fa-solid fa-circle-check me-2"></i>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        <!-- Validation Errors Alert -->
        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3" role="alert" style="border-radius: 8px; font-size: 0.85rem;">
                <div class="d-flex align-items-center fw-bold mb-1">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Authentication Error
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('superadmin.login') }}" autocomplete="on">
            @csrf

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    Email Address <span class="text-danger ms-1">*</span>
                </label>
                <div class="custom-input-group">
                    <i class="fa-solid fa-envelope input-icon-left"></i>
                    <input id="email" 
                           type="email" 
                           class="form-control form-control-custom @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="admin@doctorwala.info" 
                           required 
                           autofocus 
                           autocomplete="username">
                </div>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    Password <span class="text-danger ms-1">*</span>
                </label>
                <div class="custom-input-group">
                    <i class="fa-solid fa-lock input-icon-left"></i>
                    <input id="password" 
                           type="password" 
                           class="form-control form-control-custom @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="••••••••••••" 
                           required 
                           autocomplete="current-password">
                    <button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="Toggle password visibility">
                        <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small text-decoration-none fw-semibold" style="color: var(--brand-primary);">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-brand-login w-100">
                <span>Sign In to Super Admin</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <!-- Security Footer -->
        <div class="auth-footer">
            <div class="security-badge">
                <i class="fa-solid fa-lock text-success"></i>
                <span>Authorized Personnel Only • 256-bit SSL Encrypted</span>
            </div>
            <div>
                <a href="/" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to DoctorWala Home</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');

    if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
        togglePasswordBtn.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            togglePasswordIcon.className = isPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
        });
    }
</script>

</body>
</html>
