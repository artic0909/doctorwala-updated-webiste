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

            {{-- System Prescription Content (Coming Soon Placeholder) --}}
            <div id="tab-system" class="mp-tab-content">
                <form action="{{ route('partner.patient.prescription.store.system') }}" method="POST">
                    @csrf
                    <div class="mp-coming-soon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        <h3>System Prescription Builder</h3>
                        <p>This feature will allow you to dynamically build digital prescriptions, add medicines,
                            dosages, and notes. Coming soon in the next update!</p>

                        <div style="margin-top:30px;">
                            <button type="submit" class="mp-btn" style="background:#f1f5f9; color:#475569;"
                                disabled>Create Built-in Form (TBD)</button>
                        </div>
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

        document.getElementById('prescriptionForm').addEventListener('submit', function(e) {
            const hasNewFiles = document.getElementById('finalFileInput').files.length > 0;
            const hasExistingFiles = document.querySelectorAll('.preview-card.existing-img').length > 0;
            
            if(!hasNewFiles && !hasExistingFiles) {
                e.preventDefault();
                alert('Please upload at least one image or PDF.');
            }
        });
    </script>
</body>

</html>