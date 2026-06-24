@extends('frontend.layout.app')

@section('title', 'Download Doctorwala Apps - Patient & Partner Apps | Doctorwala.info')

@section('content')

<head>
    <meta name="description" content="Download the Doctorwala User App for patients to find doctors and the Doctorwala Partner App for medical shops, clinics, doctors, and pathology labs.">
    <meta name="keywords" content="download app, doctorwala app, patient app, partner app, healthcare app, medical app">
    <meta property="og:title" content="Download Doctorwala Apps - Patient & Partner Apps">
    <meta property="og:description" content="Download the Doctorwala User App for patients to find doctors and the Doctorwala Partner App for medical shops, clinics, doctors, and pathology labs.">
    <meta property="og:url" content="{{ url('/appdownload') }}">
    <meta name="twitter:title" content="Download Doctorwala Apps - Patient & Partner Apps">
    <meta name="twitter:description" content="Download the Doctorwala User App for patients to find doctors and the Doctorwala Partner App for medical shops, clinics, doctors, and pathology labs.">
    <style>
        .app-download-section {
            background-color: #f8f9fa;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        .app-download-section::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }
        .app-download-section::after {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(25, 135, 84, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }
        .app-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 50px 40px;
            transition: all 0.4s ease;
            position: relative;
            z-index: 10;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .app-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.12);
        }
        .app-card-partner:hover {
            box-shadow: 0 20px 40px rgba(25, 135, 84, 0.12);
        }
        .app-icon-wrap {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            border-radius: 24px;
            padding: 15px;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transition: transform 0.4s ease;
            border: 1px solid #f1f5f9;
        }
        .app-card:hover .app-icon-wrap {
            transform: scale(1.1) rotate(5deg);
        }
        .app-icon-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .feature-list {
            text-align: left;
            margin-bottom: 40px;
            flex-grow: 1;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            font-size: 1.05rem;
            color: #495057;
            font-weight: 500;
        }
        .feature-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            font-size: 0.9rem;
        }
        .icon-primary { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
        .icon-success { background: rgba(25, 135, 84, 0.1); color: #198754; }
        
        .btn-download {
            position: absolute;
            top: 25px;
            right: 25px;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            z-index: 20;
        }
        .btn-download-primary {
            background: #0d6efd;
            color: white;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25);
        }
        .btn-download-primary:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(13, 110, 253, 0.35);
            color: white;
        }
        .btn-download-success {
            background: #198754;
            color: white;
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.25);
        }
        .btn-download-success:hover {
            background: #157347;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(25, 135, 84, 0.35);
            color: white;
        }
        .header-title {
            font-weight: 800;
            color: #212529;
            margin-bottom: 20px;
        }
        .header-subtitle {
            font-size: 1.25rem;
            color: #6c757d;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }
    </style>
</head>

<div class="app-download-section wow fadeIn" data-wow-delay="0.1s">
    <div class="container position-relative" style="z-index: 10;">
        <div class="row text-center mb-5 pb-3">
            <div class="col-12">
                <div class="section-title mb-4">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Mobile Apps</h5>
                </div>
                <h1 class="header-title display-4">Experience Healthcare in Your Hands</h1>
                <p class="header-subtitle">Select the right app designed specifically for your needs. A seamless, secure, and smart healthcare ecosystem for patients and providers alike.</p>
            </div>
        </div>

        <div class="row g-5 justify-content-center">
            <!-- Patient App -->
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="app-card text-center">
                    <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth&pcampaignid=web_share" target="_blank" class="btn-download btn-download-primary">
                        <i class="fab fa-google-play"></i> Download
                    </a>
                    
                    <div class="app-icon-wrap mt-2">
                        <img src="{{ asset('img/logos/user-logo.png') }}" alt="User App Logo">
                    </div>
                    <h2 class="h3 mb-3 fw-bold text-dark">User App</h2>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.6;">Empowering patients with 24/7 access to the finest doctors, labs, and clinics.</p>
                    
                    <div class="feature-list mb-0">
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-user-md"></i></div>
                            Find & Book Top Doctors & Specialists
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-calendar-plus"></i></div>
                            Book Doctor Appointments
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-flask"></i></div>
                            Schedule Pathology Tests Easily
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-shield-alt"></i></div>
                            Secure Digital Medical Records
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-file-medical"></i></div>
                            Upload & Manage Past Prescriptions
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-microscope"></i></div>
                            View Lab Reports Digitally
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-clock"></i></div>
                            Easy Cancellation & Rescheduling
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-users"></i></div>
                            Manage Family Member Profiles
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-primary"><i class="fa fa-search-location"></i></div>
                            24/7 Access to Local Healthcare
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partner App -->
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="app-card app-card-partner text-center">
                    <a href="https://play.google.com/store/apps/details?id=info.doctorwala.partner" target="_blank" class="btn-download btn-download-success">
                        <i class="fab fa-google-play"></i> Download
                    </a>
                    
                    <div class="app-icon-wrap mt-2">
                        <img src="{{ asset('img/logos/partner-logo.png') }}" alt="Partner App Logo">
                    </div>
                    <h2 class="h3 mb-3 fw-bold text-dark">Partner App</h2>
                    <p class="text-muted mb-4" style="font-size: 1rem; line-height: 1.6;">Grow your practice and manage your bookings effortlessly with our powerful tools.</p>
                    
                    <div class="feature-list mb-0">
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-calendar-check"></i></div>
                            Manage OPD & Clinic Appointments
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-bell"></i></div>
                            Receive Patient Appointments Directly
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-chart-line"></i></div>
                            Boost Online Visibility & Growth
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-pen-fancy"></i></div>
                            Prescription Making (Hand Written & System Generated)
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-notes-medical"></i></div>
                            Manage Patient Medical Records
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-vial"></i></div>
                            Receive Pathology Test Inquiries
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-share-nodes"></i></div>
                            Share Digital Prescriptions Instantly
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-file-upload"></i></div>
                            Upload Patient Reports Seamlessly
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon icon-success"><i class="fa fa-user-clock"></i></div>
                            Complete Control Over Clinic Timings
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
