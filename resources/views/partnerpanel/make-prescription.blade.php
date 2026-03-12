<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$patient->user_name}} - Make Prescription | Partner Panel</title>

    <link href="{{asset('fav5.png')}}" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/user-profile.css') }}">
    <link href="{{asset('fav5.png')}}" rel="icon">

    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .pp-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .15);
            border: 1.5px solid rgba(255, 255, 255, .25);
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .18s ease;
            margin-bottom: 16px;
        }

        .pp-back-btn:hover {
            background: rgba(255, 255, 255, .25);
            transform: translateX(-2px);
        }

        /* Hero tweaks */
        .up-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 55%, #1e40af 100%);
            padding-bottom: 7rem; /* Increased padding */
            position: relative;
        }

        .up-hero__wave {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 80px; /* Increased height */
        }

        .up-hero__inner {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: flex-start; /* Ensure it stays left-aligned */
        }

        /* General Container */
        .mp-container {
            max-width: 1200px;
            margin: -70px auto 40px; /* Better alignment with wave */
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        /* Patient Info Banner */
        .mp-patient-info {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 24px;
            margin-bottom: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            border: 1px solid #e2e8f0;
        }

        .mp-info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .mp-info-lbl {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .mp-info-val {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
        }

        .mp-info-val.highlight {
            color: #4338ca;
            background: #f5f3ff;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
        }

        .mp-info-val.danger {
            color: #be123c;
            background: #fff1f2;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
        }

        .mp-info-val.success {
            color: #15803d;
            background: #f0fdf4;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
        }

        .mp-info-val.warning {
            color: #b45309;
            background: #fffbeb;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
        }

        /* Tabs */
        .mp-tabs-wrapper {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .mp-tabs-header {
            display: flex;
            border-bottom: 2px solid #f1f5f9;
            background: #f8fafc;
        }

        .mp-tab-btn {
            flex: 1;
            padding: 18px 24px;
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            font-size: 15px;
            font-weight: 700;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: inherit;
        }

        .mp-tab-btn:hover {
            color: #334155;
            background: #f1f5f9;
        }

        .mp-tab-btn.active {
            color: #4338ca;
            border-bottom-color: #4338ca;
            background: #fff;
        }

        .mp-tab-btn svg {
            width: 18px;
            height: 18px;
        }

        /* Tab Content */
        .mp-tab-content {
            display: none;
            padding: 32px;
            animation: fadeIn 0.3s ease;
        }

        .mp-tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Styles */
        .mp-form-group {
            margin-bottom: 24px;
        }

        .mp-form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 8px;
        }

        .mp-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            font-family: inherit;
            font-size: 14px;
            color: #334155;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fff;
            box-sizing: border-box;
        }

        .mp-input:focus {
            outline: none;
            border-color: #4338ca;
            box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.1);
        }

        .mp-file-upload {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            position: relative;
        }

        .mp-file-upload:hover {
            border-color: #6366f1;
            background: #eef2ff;
        }

        .mp-file-upload input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .mp-file-upload-icon {
            width: 48px;
            height: 48px;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .mp-file-upload-text {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
        }

        .mp-file-upload-hint {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 8px;
        }

        .mp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .mp-btn-primary {
            background: #4338ca;
            color: #fff;
            box-shadow: 0 4px 12px rgba(67, 56, 202, 0.2);
            width: 100%;
        }

        .mp-btn-primary:hover {
            background: #3730a3;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(67, 56, 202, 0.3);
        }

        /* Coming Soon overlay */
        .mp-coming-soon {
            text-align: center;
            padding: 60px 20px;
        }

        .mp-coming-soon svg {
            width: 64px;
            height: 64px;
            color: #94a3b8;
            margin-bottom: 20px;
        }

        .mp-coming-soon h3 {
            font-size: 20px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 10px;
        }

        .mp-coming-soon p {
            color: #64748b;
            font-size: 15px;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .up-hero {
                padding-top: 20px;
            }

            .mp-container {
                margin-top: -20px;
            }

            .mp-tabs-header {
                flex-direction: row;
            }

            .mp-tab-btn {
                padding: 14px 10px;
                font-size: 13px;
                gap: 6px;
            }

            .mp-tab-btn svg {
                width: 16px;
                height: 16px;
            }

            .mp-tab-content {
                padding: 24px 16px;
            }
        }

        /* Prescription Table Styles */
        .prescription-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .prescription-table th {
            background: #f8fafc;
            padding: 12px 15px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            border-bottom: 2px solid #f1f5f9;
        }

        .prescription-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .prescription-table .mp-input {
            padding: 8px 12px;
            border-width: 1px;
            font-size: 13px;
        }

        .add-row-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: #4338ca;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .add-row-btn:hover {
            background: #3730a3;
            transform: translateY(-1px);
        }

        .remove-row-btn {
            color: #ef4444;
            background: #fef2f2;
            border: 1.5px solid #fee2e2;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .remove-row-btn:hover {
            background: #ef4444;
            color: #fff;
        }

        /* Advanced Symptoms Styles */
        .symptoms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .symptom-item {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s;
            background: #fff;
            border: 1px solid #e2e8f0;
        }

        .symptom-item:hover {
            border-color: #4338ca;
            background: #f5f3ff;
        }

        .symptom-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #4338ca;
        }

        .symptom-label {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
        }

        .other-symptoms-wrapper {
            display: none;
            margin-top: 15px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .timing-select-grid {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .timing-box {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 6px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .timing-box.selected {
            background: #4338ca;
            color: #fff;
            border-color: #4338ca;
        }

        .dose-helper {
            display: flex;
            gap: 4px;
            margin-top: 5px;
        }

        .dose-chip {
            font-size: 10px;
            padding: 2px 6px;
            background: #eef2ff;
            color: #4338ca;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 700;
            border: 1px solid #c7d2fe;
        }

        .dose-chip:hover {
            background: #4338ca;
            color: #fff;
        }

        /* Print Styles */
        @media print {
            body * {
                visibility: hidden;
            }
            #tab-system, #tab-system * {
                visibility: visible;
            }
            #tab-system {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .add-row-btn, .remove-row-btn, .mp-btn, .mp-tab-btn, header, nav, footer {
                display: none !important;
            }
            .prescription-table th, .prescription-table td {
                border: 1px solid #cbd5e1 !important;
            }
            .mp-input {
                border: none !important;
                background: none !important;
                padding: 0 !important;
            }
            select {
                appearance: none;
                -webkit-appearance: none;
                background: none !important;
            }
        }
    </style>
</head>

<body>
    {{-- ══════════════════════════════════
    HERO BANNER
    ══════════════════════════════════ --}}
    <div class="up-hero">
        <div class="up-wrap" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2;">
            <a href="{{ route('partner.patient.profile', ['encryptedId' => $encryptedPatientId]) }}" class="pp-back-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back To Patient
            </a>

            <div class="up-hero__inner">
                <div class="up-hero__av-wrap">
                    <div class="up-hero__av"
                        style="width:64px;height:64px;border-radius:16px;background:#fff;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;color:#4338ca;box-shadow:0 4px 12px rgba(0,0,0,.1)">
                        @if($patient->image)
                            <img src="{{ asset('storage/' . $patient->image) }}" alt="{{ $patient->user_name }}"
                                style="width:100%;height:100%;object-fit:cover;border-radius:16px;">
                        @else
                            {{ strtoupper(substr($patient->user_name, 0, 1)) }}{{ strtoupper(substr(strstr($patient->user_name, ' '), 1, 1)) }}
                        @endif
                    </div>
                </div>
                <div>
                    <h1
                        style="color:#fff; font-size:24px; font-weight:800; margin:0 0 4px 0; text-transform:capitalize;">
                        Make Prescription for {{ $patient->user_name }}</h1>
                    <p style="color:rgba(255,255,255,.8); margin:0; font-size:14px;">Select the prescription method
                        below.</p>
                </div>
            </div>
        </div>

        <div class="up-hero__wave">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                style="width:100%;height:100%">
                <path d="M0,60 C480,0 960,80 1440,30 L1440,80 L0,80 Z" fill="#f8fafc" />
            </svg>
        </div>
    </div>

    {{-- ══════════════════════════════════
    MAIN CONTAINER
    ══════════════════════════════════ --}}
    <div class="mp-container">

        {{-- Alerts --}}
        @if(session('success'))
            <div
                style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; display:flex; gap:10px; align-items:center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div
                style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
                <div style="display:flex; gap:10px; align-items:center; margin-bottom:8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    Please fix the following errors:
                </div>
                <ul style="margin:0; padding-left:30px; font-size:14px; font-weight:500;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Patient Info Banner --}}
        <div class="mp-patient-info" style="grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));">
            <div class="mp-info-item">
                <span class="mp-info-lbl">Medical Card No.</span>
                <span class="mp-info-val highlight">{{ $patient->medical_card_no ?? 'N/A' }}</span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">Mobile</span>
                <span class="mp-info-val">{{ $patient->user_mobile ?? 'N/A' }}</span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">Age / Gender</span>
                <span class="mp-info-val">
                    {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age . ' Yrs' : 'N/A' }} /
                    {{ $patient->gender ?? 'N/A' }}
                </span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">Blood Group</span>
                <span class="mp-info-val danger">{{ $patient->blood_group ?? ($vital->blood_group ?? 'N/A') }}</span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">Weight</span>
                <span class="mp-info-val warning">{{ $vital->weight ?? '—' }} kg</span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">Height</span>
                <span class="mp-info-val success">{{ $vital->height ?? '—' }} cm</span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">Heart Rate</span>
                <span class="mp-info-val danger">{{ $vital->heart_rate ?? '—' }} bpm</span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">BP</span>
                <span class="mp-info-val highlight">{{ $vital->blood_pressure ?? '—' }}</span>
            </div>
            <div class="mp-info-item">
                <span class="mp-info-lbl">SpO2</span>
                <span class="mp-info-val success">{{ $vital->spo ?? '—' }}%</span>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="mp-tabs-wrapper">
            <div class="mp-tabs-header">
                <button class="mp-tab-btn active" onclick="openTab('tab-handwritten', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                    Add Hand Written
                </button>
                <button class="mp-tab-btn" onclick="openTab('tab-system', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="3" y1="9" x2="21" y2="9"></line>
                        <line x1="9" y1="21" x2="9" y2="9"></line>
                    </svg>
                    Make System Prescription
                </button>
            </div>

            {{-- Handwritten Form Content --}}
            <div id="tab-handwritten" class="mp-tab-content active">
                <form action="{{ isset($record) ? route('partner.patient.prescription.update.image', $record->id) : route('partner.patient.prescription.store.image') }}" method="POST"
                    enctype="multipart/form-data" id="prescriptionForm">
                    @csrf
                    <input type="hidden" name="dw_user_id" value="{{ $dwUserId }}">

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        <div class="mp-form-group">
                            <label class="mp-form-label">Type <span style="color:#e11d48">*</span></label>
                            <select name="type" class="mp-input" required>
                                <option value="prescription" selected>Prescription</option>
                            </select>
                        </div>
                        <div class="mp-form-group">
                            <label class="mp-form-label">Date of Report <span style="color:#e11d48">*</span></label>
                            <input type="date" name="date_of_report" class="mp-input" 
                                value="{{ isset($record) ? \Carbon\Carbon::parse($record->date_of_report)->format('Y-m-d') : date('Y-m-d') }}" 
                                max="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        <div class="mp-form-group">
                            <label class="mp-form-label">Clinic Name (Readonly)</label>
                            <input type="text" class="mp-input" value="{{ $clinicName }}" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="mp-form-group">
                            <label class="mp-form-label">OPD Doctor <span style="color:#e11d48">*</span></label>
                            <select name="opd_doctor_id" class="mp-input select2-doctor" required style="width: 100%;">
                                <option value="" disabled {{ !isset($record) ? 'selected' : '' }}>Select Doctor</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}" {{ (isset($record) && $record->opd_doctor_id == $doc->id) ? 'selected' : '' }}>
                                        {{ $doc->doctor_name }} - {{ $doc->doctor_specialist }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mp-form-group">
                        <label class="mp-form-label">Heading / Title <span style="color:#e11d48">*</span></label>
                        <input type="text" name="heading" class="mp-input" placeholder="e.g. Blood Test Report - June 2025" 
                            value="{{ $record->heading ?? '' }}" required>
                    </div>

                    <div class="mp-form-group">
                        <label class="mp-form-label">{{ isset($record) ? 'Attach New Images' : 'Images' }} <span style="color:#e11d48">*</span></label>
                        
                        {{-- Custom Upload Buttons --}}
                        <div style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
                            <label class="upload-btn-custom">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                                Camera
                                <input type="file" id="cameraInput" accept="image/*" capture="environment" multiple style="display: none;">
                            </label>

                            <label class="upload-btn-custom">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                Gallery
                                <input type="file" id="galleryInput" accept="image/*" multiple style="display: none;">
                            </label>

                            <label class="upload-btn-custom">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                PDF File
                                <input type="file" id="pdfInput" accept=".pdf" multiple style="display: none;">
                            </label>
                        </div>

                        {{-- Final File Input (Hidden, updated by JS) --}}
                        <input type="file" name="{{ isset($record) ? 'new_images[]' : 'images[]' }}" id="finalFileInput" multiple style="display: none;" accept=".jpg,.jpeg,.png,.webp,.pdf">

                        {{-- Previews --}}
                        <div id="fileList" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 8px;">
                            @if(isset($record) && $record->images)
                                @foreach($record->images as $imgPath)
                                    <div class="preview-card existing-img" data-path="{{ $imgPath }}">
                                        @if(Str::endsWith($imgPath, '.pdf'))
                                            <div class="pdf-icon">
                                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                PDF
                                            </div>
                                        @else
                                            <img src="{{ asset('storage/' . $imgPath) }}">
                                        @endif
                                        <button type="button" class="preview-remove" onclick="removeExistingFile(this, '{{ $imgPath }}')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <div id="deletedImagesContainer"></div>
                        
                        <div class="mp-file-upload-hint" style="margin-top: 12px;">Accepted: JPG, PNG, WEBP, PDF — max 5MB each</div>
                    </div>

                    <div style="text-align: right; margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                        <button type="submit" class="mp-btn mp-btn-primary" style="width: auto;">
                            Save Record
                        </button>
                    </div>
                </form>
            </div>

            {{-- System Prescription Content --}}
            <div id="tab-system" class="mp-tab-content">
                <form action="{{ route('partner.patient.prescription.store.system') }}" method="POST" id="systemPrescriptionForm">
                    @csrf
                    <input type="hidden" name="dw_user_id" value="{{ $dwUserId }}">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                        <h2 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #1e1b4b;">DOCTORWALA – DIGITAL PRESCRIPTION PANEL</h2>
                        <div class="mp-form-group" style="margin: 0; min-width: 200px;">
                            <label class="mp-form-label">Prescription Date</label>
                            <input type="date" name="prescription_date" class="mp-input" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
                        <div class="mp-form-group" style="margin: 0;">
                            <label class="mp-form-label">Clinic Name (Readonly)</label>
                            <input type="text" class="mp-input" value="{{ $clinicName }}" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="mp-form-group" style="margin: 0;">
                            <label class="mp-form-label">OPD Doctor <span style="color:#e11d48">*</span></label>
                            <select name="opd_doctor_id" class="mp-input select2-doctor" required style="width: 100%;">
                                <option value="" disabled selected>Select Doctor</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}">
                                        {{ $doc->doctor_name }} - {{ $doc->doctor_specialist }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Health Parameters --}}
                    <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px;">
                        <h3 style="margin: 0 0 16px 0; font-size: 0.9rem; font-weight: 800; color: #4338ca; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                            Health PARAMETERS
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                            <div class="mp-form-group" style="margin: 0;">
                                <label class="mp-form-label">BP (mmHg)</label>
                                <input type="text" name="bp" class="mp-input" placeholder="120/80" value="{{ $vital->blood_pressure ?? '' }}">
                            </div>
                            <div class="mp-form-group" style="margin: 0;">
                                <label class="mp-form-label">Pulse (bpm)</label>
                                <input type="text" name="pulse" class="mp-input" placeholder="72" value="{{ $vital->heart_rate ?? '' }}">
                            </div>
                            <div class="mp-form-group" style="margin: 0;">
                                <label class="mp-form-label">Oxygen (SpO2 %)</label>
                                <input type="text" name="spo2" class="mp-input" placeholder="98" value="{{ $vital->spo ?? '' }}">
                            </div>
                            <div class="mp-form-group" style="margin: 0;">
                                <label class="mp-form-label">Temperature (°F)</label>
                                <input type="text" name="temperature" class="mp-input" placeholder="98.6">
                            </div>
                            <div class="mp-form-group" style="margin: 0;">
                                <label class="mp-form-label">Weight (kg)</label>
                                <input type="text" name="weight" class="mp-input" placeholder="70" value="{{ $vital->weight ?? '' }}">
                            </div>
                        </div>
                    </div>

                    {{-- Symptoms/Complaints --}}
                    <div class="mp-form-group">
                        <label class="mp-form-label" style="display: flex; align-items: center; gap: 8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M2 12h20"></path><path d="m19 9-7 7-7-7"></path></svg>
                            SYMPTOMS / COMPLAINT
                            <span style="font-size: 11px; color: #64748b; font-weight: 500;">(Select common or type other)</span>
                        </label>
                        <div class="symptoms-grid">
                            @php
                                $commonSymptoms = ['Fever', 'Cough', 'Cold', 'Headache', 'Body Pain', 'Weakness', 'Dizziness', 'Nausea', 'Vomiting', 'Sore Throat', 'Abdominal Pain', 'Shortness of Breath'];
                            @endphp
                            @foreach($commonSymptoms as $symptom)
                                <label class="symptom-item">
                                    <input type="checkbox" name="symptoms[]" value="{{ $symptom }}">
                                    <span class="symptom-label">{{ $symptom }}</span>
                                </label>
                            @endforeach
                            <label class="symptom-item" style="border-style: dashed; border-color: #4338ca;">
                                <input type="checkbox" id="otherSymptomCheck" onclick="toggleOtherSymptoms()">
                                <span class="symptom-label" style="color: #4338ca;">Other...</span>
                            </label>
                        </div>
                        <div class="other-symptoms-wrapper" id="otherSymptomsDiv">
                            <textarea name="other_symptoms" class="mp-input" rows="3" placeholder="Specify other symptoms here..."></textarea>
                        </div>
                    </div>

                    {{-- Recommended Tests --}}
                    <div style="margin-bottom: 32px;">
                        <h3 style="margin: 0 0 12px 0; font-size: 0.9rem; font-weight: 800; color: #4338ca; text-transform: uppercase; display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            RECOMMENDED TESTS
                        </h3>
                        <div style="overflow-x: auto;">
                            <table class="prescription-table" id="testsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">SL</th>
                                        <th>Test Name</th>
                                        <th style="width: 150px;">Priority</th>
                                        <th>Notes</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Dynamic Rows --}}
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="add-row-btn" onclick="addTestRow()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Add Test
                        </button>
                    </div>

                    {{-- Medicine Prescription --}}
                    <div style="margin-bottom: 32px;">
                        <h3 style="margin: 0 0 12px 0; font-size: 0.9rem; font-weight: 800; color: #4338ca; text-transform: uppercase; display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path></svg>
                            MEDICINE PRESCRIPTION
                        </h3>
                        <div style="overflow-x: auto;">
                            <table class="prescription-table" id="medicinesTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">SL</th>
                                        <th>Medicine Name</th>
                                        <th>Chemical</th>
                                        <th>Brand</th>
                                        <th style="width: 120px;">Dose (1-0-1)</th>
                                        <th style="width: 180px;">Timing / Eating</th>
                                        <th style="width: 80px;">Days</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Dynamic Rows --}}
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="add-row-btn" onclick="addMedicineRow()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Add Medicine
                        </button>
                        <div style="margin-top: 10px; font-size: 11px; color: #64748b; font-weight: 600;">
                            Time Codes: M=Morning, A=Afternoon, E=Evening, N=Night
                        </div>
                    </div>

                    {{-- Instructions --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div class="mp-form-group" style="margin: 0;">
                            <label class="mp-form-label">MEDICAL INSTRUCTIONS</label>
                            <textarea name="medical_instructions" class="mp-input" rows="4" placeholder="- Take complete rest&#10;- Drink warm water&#10;- Monitor temperature twice daily"></textarea>
                        </div>
                        <div class="mp-form-group" style="margin: 0;">
                            <label class="mp-form-label">DIET INSTRUCTIONS</label>
                            <textarea name="diet_instructions" class="mp-input" rows="4" placeholder="- Light food&#10;- Avoid oily food&#10;- Drink sufficient fluids"></textarea>
                        </div>
                    </div>

                    {{-- Follow up --}}
                    <div style="background: #f1f5f9; padding: 20px; border-radius: 12px;">
                        <h3 style="margin: 0 0 16px 0; font-size: 0.9rem; font-weight: 800; color: #1e293b; text-transform: uppercase;">FOLLOW UP</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; align-items: end;">
                            <div class="mp-form-group" style="margin: 0;">
                                <label class="mp-form-label">Next Visit Date</label>
                                <input type="date" name="next_visit_date" class="mp-input">
                            </div>
                            <div class="mp-form-group" style="margin: 0;">
                                <label class="mp-form-label">Repeat Tests Required?</label>
                                <div style="display: flex; gap: 20px; padding: 10px 0;">
                                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
                                        <input type="radio" name="repeat_tests_required" value="yes" style="width: 18px; height: 18px;"> Yes
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
                                        <input type="radio" name="repeat_tests_required" value="no" checked style="width: 18px; height: 18px;"> No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mp-form-group" style="margin-top: 20px;">
                            <label class="mp-form-label" style="color: #be123c;">EMERGENCY NOTE</label>
                            <textarea name="emergency_note" class="mp-input" rows="2" style="border-color: #fecaca;" placeholder="If fever > 103°F contact doctor immediately"></textarea>
                        </div>
                    </div>

                    <div style="text-align: right; margin-top: 32px; border-top: 1px solid #e2e8f0; padding-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
                        <button type="button" class="mp-btn" onclick="window.print()" style="width: auto; background: #64748b;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 8px;"><path d="M6 9V2h12v7"></path><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            PRINT PREVIEW
                        </button>
                        <button type="submit" class="mp-btn mp-btn-primary" style="width: auto; padding-left: 40px; padding-right: 40px; background: #059669; border-color: #059669;">
                            SAVE PRESCRIPTION
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- jQuery and Select2 for Dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .upload-btn-custom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            border: 1.5px solid #e0e7ff;
            background: #f8fafc;
            color: #4338ca;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .upload-btn-custom:hover {
            background: #eef2ff;
            border-color: #c7d2fe;
        }
        
        .preview-card {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
        }
        
        .preview-card img, .preview-card canvas {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-card .pdf-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ef4444;
            font-size: 12px;
            font-weight: 700;
        }
        
        .preview-remove {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 24px;
            height: 24px;
            background: rgba(0,0,0,0.6);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            backdrop-filter: blur(2px);
            transition: background 0.2s;
        }
        
        .preview-remove:hover {
            background: rgba(220, 38, 38, 0.9);
        }

        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--single {
            height: 44px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }
        .select2-container--default .select2-selection--single:focus {
            outline: none;
            border-color: #4338ca;
            box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.1);
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.select2-doctor').select2({
                placeholder: "Select Doctor",
                allowClear: true
            });
        });

        function openTab(tabId, btnElement) {
            document.querySelectorAll('.mp-tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.mp-tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            btnElement.classList.add('active');
        }

        let selectedFiles = [];

        function handleFiles(files) {
            Array.from(files).forEach(file => {
                if(file.size > 5 * 1024 * 1024) {
                    alert(file.name + ' exceeds 5MB limit.');
                    return;
                }
                
                const fileId = Date.now() + Math.random().toString(36).substr(2, 9);
                selectedFiles.push({ id: fileId, file: file });
                renderPreview(file, fileId);
            });
            updateFinalInput();
        }

        function renderPreview(file, fileId) {
            const list = document.getElementById('fileList');
            const card = document.createElement('div');
            card.className = 'preview-card';
            card.dataset.id = fileId;

            const removeBtn = document.createElement('button');
            removeBtn.className = 'preview-remove';
            removeBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
            removeBtn.onclick = (e) => {
                e.preventDefault();
                removeFile(fileId);
                card.remove();
            };

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                const reader = new FileReader();
                reader.onload = (e) => img.src = e.target.result;
                reader.readAsDataURL(file);
                card.appendChild(img);
            } else if (file.type === 'application/pdf') {
                const icon = document.createElement('div');
                icon.className = 'pdf-icon';
                icon.innerHTML = `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>PDF`;
                card.appendChild(icon);
            }

            card.appendChild(removeBtn);
            list.appendChild(card);
        }

        function removeFile(fileId) {
            selectedFiles = selectedFiles.filter(item => item.id !== fileId);
            updateFinalInput();
        }

        function updateFinalInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(item => dt.items.add(item.file));
            document.getElementById('finalFileInput').files = dt.files;
        }

        function removeExistingFile(btn, path) {
            if(confirm('Are you sure you want to remove this file? It will be deleted permanently when you save.')) {
                const container = document.getElementById('deletedImagesContainer');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'deleted_images[]';
                input.value = path;
                container.appendChild(input);
                btn.closest('.preview-card').remove();
            }
        }

        document.getElementById('cameraInput').addEventListener('change', function() { handleFiles(this.files); this.value = ''; });
        document.getElementById('galleryInput').addEventListener('change', function() { handleFiles(this.files); this.value = ''; });
        document.getElementById('pdfInput').addEventListener('change', function() { handleFiles(this.files); this.value = ''; });

        const testList = [
            { text: "Blood Tests (Pathology/Hematology)", children: [
                { id: "CBC (Complete Blood Count)", text: "CBC (Complete Blood Count): (Hb, TLC, DLC, Platelets, MCV, MCH, MCHC, RDW)" },
                { id: "ESR (Erythrocyte Sedimentation Rate)", text: "ESR (Erythrocyte Sedimentation Rate)" },
                { id: "Absolute Eosinophil Count (AEC)", text: "Absolute Eosinophil Count (AEC)" },
                { id: "Peripheral Blood Smear (P/S)", text: "Peripheral Blood Smear (P/S)" },
                { id: "Reticulocyte Count", text: "Reticulocyte Count" },
                { id: "Blood Grouping & Rh Typing", text: "Blood Grouping & Rh Typing" },
                { id: "Bleeding Time & Clotting Time (BT/CT)", text: "Bleeding Time & Clotting Time (BT/CT)" },
                { id: "PT / INR", text: "PT / INR" },
                { id: "Liver Function Test (LFT)", text: "Liver Function Test (LFT)" },
                { id: "Kidney Function Test (KFT/RFT)", text: "Kidney Function Test (KFT/RFT)" },
                { id: "Lipid Profile (Heart)", text: "Lipid Profile (Heart)" },
                { id: "Thyroid Profile", text: "Thyroid Profile" },
                { id: "Diabetic Profile", text: "Diabetic Profile" },
                { id: "Electrolytes", text: "Electrolytes" },
                { id: "Vitamins", text: "Vitamins" },
                { id: "Iron Profile", text: "Iron Profile" },
                { id: "Widal Test", text: "Widal Test" },
                { id: "Dengue Profile", text: "Dengue Profile" },
                { id: "Malaria", text: "Malaria" },
                { id: "CRP (C-Reactive Protein)", text: "CRP (C-Reactive Protein)" },
                { id: "RA Factor", text: "RA Factor" },
                { id: "Viral Markers", text: "Viral Markers" }
            ]},
            { text: "Urine Tests (Urinalysis)", children: [
                { id: "Urine RE/ME", text: "Urine RE/ME" },
                { id: "Urine Culture & Sensitivity", text: "Urine Culture & Sensitivity" },
                { id: "Urine Pregnancy Test (UPT)", text: "Urine Pregnancy Test (UPT)" },
                { id: "Microalbuminuria", text: "Microalbuminuria" },
                { id: "24-Hour Urine Protein", text: "24-Hour Urine Protein" },
                { id: "Urine Ketones", text: "Urine Ketones" }
            ]},
            { text: "Stool & Body Fluids", children: [
                { id: "Stool RE/ME", text: "Stool RE/ME" },
                { id: "Stool Occult Blood", text: "Stool Occult Blood" },
                { id: "Sputum for AFB", text: "Sputum for AFB" },
                { id: "Semen Analysis", text: "Semen Analysis" },
                { id: "FNAC / Biopsy", text: "FNAC / Biopsy" }
            ]},
            { text: "Radiology (Imaging)", children: [
                { id: "Chest X-Ray (PA/Lateral)", text: "Chest X-Ray (PA/Lateral)" },
                { id: "KUB X-Ray", text: "KUB X-Ray" },
                { id: "Spine X-Ray", text: "Spine X-Ray" },
                { id: "USG Whole Abdomen", text: "USG Whole Abdomen" },
                { id: "USG KUB & Prostate", text: "USG KUB & Prostate" },
                { id: "Obstetric USG", text: "Obstetric USG" },
                { id: "CT Brain / Head", text: "CT Brain / Head" },
                { id: "MRI Brain / Spine", text: "MRI Brain / Spine" }
            ]},
            { text: "Cardiology (Heart)", children: [
                { id: "ECG", text: "ECG" },
                { id: "Echocardiography (2D Echo)", text: "Echocardiography (2D Echo)" },
                { id: "TMT (Treadmill Test)", text: "TMT (Treadmill Test)" }
            ]},
            { text: "Pulmonary (Lungs) & ENT", children: [
                { id: "PFT (Pulmonary Function Test)", text: "PFT (Pulmonary Function Test)" },
                { id: "Audiometry", text: "Audiometry" }
            ]},
            { text: "Specialized Cancer & Hormone Tests", children: [
                { id: "PSA", text: "PSA" },
                { id: "CA-125", text: "CA-125" },
                { id: "AMH (Anti-Müllerian Hormone)", text: "AMH (Anti-Müllerian Hormone)" }
            ]}
        ];

        let testCount = 0;
        function addTestRow() {
            testCount++;
            const tbody = document.querySelector('#testsTable tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="font-weight: 700;">${testCount}</td>
                <td>
                    <select name="tests[${testCount}][name]" class="mp-input test-select" required style="width: 100%;">
                        <option value=""></option>
                    </select>
                </td>
                <td>
                    <select name="tests[${testCount}][priority]" class="mp-input">
                        <option value="Normal">Normal</option>
                        <option value="Urgent">Urgent</option>
                        <option value="Critical">Critical</option>
                    </select>
                </td>
                <td><input type="text" name="tests[${testCount}][notes]" class="mp-input" placeholder="Notes"></td>
                <td>
                    <button type="button" class="remove-row-btn" onclick="this.closest('tr').remove(); reorderRows('testsTable');">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            
            $(row).find('.test-select').select2({
                data: testList,
                placeholder: "Search Test...",
                allowClear: true,
                tags: true // Allow custom tests
            });
        }

        let medicineCount = 0;
        function addMedicineRow() {
            medicineCount++;
            const tbody = document.querySelector('#medicinesTable tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="font-weight: 700;">${medicineCount}</td>
                <td>
                    <input type="text" name="medicines[${medicineCount}][name]" class="mp-input" placeholder="Medicine Name" required>
                </td>
                <td><input type="text" name="medicines[${medicineCount}][chemical]" class="mp-input" placeholder="Chemical"></td>
                <td><input type="text" name="medicines[${medicineCount}][brand]" class="mp-input" placeholder="Brand"></td>
                <td>
                    <input type="text" name="medicines[${medicineCount}][dose]" class="mp-input dose-input" placeholder="e.g. 1-0-1">
                    <div class="dose-helper">
                        <span class="dose-chip" onclick="setDose(this, '1-0-1')">1-0-1</span>
                        <span class="dose-chip" onclick="setDose(this, '1-1-1')">1-1-1</span>
                        <span class="dose-chip" onclick="setDose(this, '0-0-1')">0-0-1</span>
                    </div>
                </td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <select name="medicines[${medicineCount}][timing][]" class="mp-input select2-timing" multiple style="width: 100%;">
                            <option value="Morning">Morning</option>
                            <option value="Afternoon">Afternoon</option>
                            <option value="Evening">Evening</option>
                            <option value="Night">Night</option>
                        </select>
                        <select name="medicines[${medicineCount}][eating]" class="mp-input">
                            <option value="After Food">After Food</option>
                            <option value="Before Food">Before Food</option>
                        </select>
                    </div>
                </td>
                <td><input type="text" name="medicines[${medicineCount}][days]" class="mp-input" placeholder="7"></td>
                <td>
                    <button type="button" class="remove-row-btn" onclick="this.closest('tr').remove(); reorderRows('medicinesTable');">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            
            $(row).find('.select2-timing').select2({
                placeholder: "Timing",
                allowClear: true
            });
        }

        function setDose(el, val) {
            const input = el.closest('td').querySelector('.dose-input');
            input.value = val;
        }

        function toggleOtherSymptoms() {
            const check = document.getElementById('otherSymptomCheck');
            const div = document.getElementById('otherSymptomsDiv');
            div.style.display = check.checked ? 'block' : 'none';
        }

        function reorderRows(tableId) {
            const tbody = document.querySelector(`#${tableId} tbody`);
            Array.from(tbody.rows).forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
            if(tableId === 'testsTable') testCount = tbody.rows.length;
            if(tableId === 'medicinesTable') medicineCount = tbody.rows.length;
        }

        // Initialize first rows
        $(document).ready(function() {
            addTestRow();
            addMedicineRow();
        });

        document.getElementById('prescriptionForm').addEventListener('submit', function(e) {
            // ... existing validation ...
        });
    </script>
</body>

</html>