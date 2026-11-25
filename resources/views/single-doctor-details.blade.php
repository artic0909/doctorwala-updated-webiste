@extends('frontend.layout.app')

@section('title', $doc->partner_doctor_designation . ' ' . $doc->partner_doctor_name . ' - Specialist in ' . $doc->partner_doctor_specialist . ' | DoctorWala.info')

@section('content')

<head>
    <!-- Meta Description -->
    <meta name="description" content="Learn more about Dr. {{$doc->partner_doctor_name}}, a {{$doc->partner_doctor_designation}} specializing in {{$doc->partner_doctor_specialist}}. Consultation fees: ₹{{$doc->partner_doctor_fees}}. Check availability and schedule an appointment.">

    <!-- Keywords -->
    <meta name="keywords" content="Dr. {{$doc->partner_doctor_name}}, {{$doc->partner_doctor_specialist}}, {{$doc->partner_doctor_designation}}, Doctor Details, Appointment, Fees, Availability">

    <!-- Author -->
    <meta name="author" content="Your Clinic Name">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="Dr. {{$doc->partner_doctor_name}} - {{$doc->partner_doctor_designation}}">
    <meta property="og:description" content="Get detailed information about Dr. {{$doc->partner_doctor_name}}, a {{$doc->partner_doctor_designation}} specializing in {{$doc->partner_doctor_specialist}}. Book your appointment now.">
    <meta property="og:image" content="{{ asset('img/doctor.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="profile">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Dr. {{$doc->partner_doctor_name}} - {{$doc->partner_doctor_designation}}">
    <meta name="twitter:description" content="Learn about Dr. {{$doc->partner_doctor_name}}, a {{$doc->partner_doctor_specialist}}. Book your consultation today.">
    <meta name="twitter:image" content="{{ asset('img/doctor.png') }}">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/allopdpathdoc_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('./css/single-doc.css')}}" rel="stylesheet">

    <style>
        .rating-a {
            img {
                transition: all 150ms ease-in-out;
            }

            &:hover {
                img {
                    scale: 1.3;
                }
            }

        }

        @media (max-width:496px) {
            .d-texts {
                font-size: 0.82rem !important;

                img {
                    width: 20px;
                }
            }
        }
        .txt-cap {
            text-transform: capitalize !important;
        }
        .rating-a.selected img {
            scale: 1.1;
        }
        .footer-content {
            display: none !important;
        }
        .partner-login {
            display: none !important;
        }

        /* 10-Minute Appointment Sub-Slots */
        .subslot-btn {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 9px;
            padding: 7px 10px;
            font-size: 11px;
            color: #334155;
            text-align: left;
            cursor: pointer;
            transition: all 0.18s ease-in-out;
            display: flex;
            flex-direction: column;
            gap: 2px;
            position: relative;
        }
        .subslot-btn:hover:not(.subslot-booked) {
            border-color: #0284c7;
            background: #f0f9ff;
            color: #0369a1;
        }
        .subslot-btn.active {
            background: #0284c7 !important;
            border-color: #0284c7 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.28);
        }
        .subslot-btn.active .subslot-num,
        .subslot-btn.active .subslot-time,
        .subslot-btn.active i {
            color: #ffffff !important;
        }
        .subslot-btn.subslot-booked {
            background: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #94a3b8 !important;
            cursor: not-allowed !important;
            opacity: 0.65;
            pointer-events: none;
            text-decoration: line-through;
        }
        .subslot-num {
            font-weight: 800;
            font-size: 11px;
        }
        .subslot-time {
            font-size: 10px;
            color: #64748b;
            font-weight: 500;
        }
        .subslot-badge-booked {
            font-size: 8.5px;
            font-weight: 800;
            color: #ef4444;
            background: #fee2e2;
            padding: 1px 5px;
            border-radius: 4px;
            letter-spacing: 0.3px;
            text-decoration: none !important;
        }

        /* ══ CLEMENTE WIDE APPOINTMENT MODAL ══ */
        .modal-ov {
            position: fixed !important;
            inset: 0 !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 9999999 !important;
            padding: 16px !important;
            display: none;
            align-items: center !important;
            justify-content: center !important;
            background: rgba(15, 23, 42, 0.75) !important;
            backdrop-filter: blur(8px) !important;
            box-sizing: border-box !important;
        }
        .modal-ov.open {
            display: flex !important;
        }

        .clemente-modal-box {
            background: #ffffff !important;
            border-radius: 20px !important;
            width: 100% !important;
            max-width: 820px !important;
            max-height: 86vh !important;
            height: auto !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.4) !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0 !important;
            margin: auto !important;
            position: relative !important;
            z-index: 10000000 !important;
        }

        .clemente-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 22px;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            flex-shrink: 0;
        }

        .clemente-modal-body {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 18px 22px;
            min-height: 0;
            /* Hide scrollbars across all modern browsers */
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        .clemente-modal-body::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .clemente-modal-footer {
            flex-shrink: 0;
            padding: 12px 22px 14px;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            box-shadow: 0 -4px 16px rgba(15, 23, 42, 0.04);
            border-radius: 0 0 20px 20px;
        }

        .booking-grid-layout {
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            gap: 22px;
        }

        .clemente-input {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: all 0.15s ease-in-out;
            font-family: inherit;
        }
        .clemente-input:focus {
            border-color: #0284c7;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .clemente-label {
            font-size: 11.5px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .doc-date-chip {
            border: 1.5px solid #e2e8f0;
            background: #ffffff;
            color: #1e293b;
            border-radius: 10px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.18s ease;
        }
        .doc-date-chip:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        .doc-date-chip.active {
            border-color: #0284c7 !important;
            background: #eff6ff !important;
            color: #0284c7 !important;
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2);
            font-weight: 700;
        }
        .doc-date-chip.active i {
            color: #0284c7 !important;
        }
        .doc-date-chip.active .date-day-badge {
            background: #0284c7 !important;
            color: #ffffff !important;
        }

        .doc-slot-btn {
            border: 1.5px solid #e2e8f0;
            background: #ffffff;
            color: #334155;
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.18s ease;
        }
        .doc-slot-btn:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        .doc-slot-btn.active {
            border-color: #0284c7 !important;
            background: #0284c7 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);
        }
        .doc-slot-btn.active i {
            color: #ffffff !important;
        }

        @media (max-width: 768px) {
            .modal-ov {
                padding: 10px !important;
            }
            .clemente-modal-box {
                max-width: 540px !important;
                max-height: 92vh !important;
                border-radius: 16px !important;
            }
            .booking-grid-layout {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .clemente-modal-header {
                padding: 12px 16px;
            }
            .clemente-modal-body {
                padding: 14px 16px;
            }
            .clemente-modal-footer {
                padding: 10px 16px 12px;
            }
        }
    </style>
</head>


<!-- {{-- ══ HERO ════════════════════════════════════════════════════ --}} -->
<div class="hero">
    <div class="hero-inner">
        @guest
        <div class="bc">
            <a href="/">Home</a><span>›</span>
            <a href="/doctor">Doctors</a><span>›</span>
            <span>{{ $doc->partner_doctor_name }}</span>
        </div>
        @endguest
        @auth
        <div class="bc">
            <a href="/dw">Home</a><span>›</span>
            <a href="/dw/doctor">Doctors</a><span>›</span>
            <span>{{ $doc->partner_doctor_name }}</span>
        </div>
        @endauth

        <div class="hero-row">
            {{-- Avatar --}}
            <div class="hero-avatar">
                @if($doc->banner && $doc->banner->doctorbanner)
                <img class="full" src="{{ asset('storage/' . $doc->banner->doctorbanner) }}" alt="{{ $doc->partner_doctor_name }}">
                @else
                <img src="{{ asset('img/doctor.png') }}" alt="Doctor">
                @endif
            </div>

            {{-- Info --}}
            <div>
                <div class="hero-tag">✦ Jio Ji Bharka · Doctorwala.info</div>
                <div class="hero-name">{{ $doc->partner_doctor_name }}</div>
                <div class="hero-name">{{ $doc->partner_doctor_specialist }}</div>
                <div>
                    <span class="hero-fee">

                        ₹ {{ $doc->partner_doctor_fees }} Consultation
                    </span>
                </div>
                <div class="hero-meta">
                    <span>
                        <i class="fa fa-map-marker-alt"></i>
                        {{ $doc->partner_doctor_address }}{{ $doc->partner_doctor_landmark ? ', ' . $doc->partner_doctor_landmark : '' }} — {{ $doc->partner_doctor_state }}, {{ $doc->partner_doctor_city }}
                    </span>
                    <span>
                        <i class="fa fa-phone"></i>
                        <a href="tel:{{ $doc->partner_doctor_mobile }}">+91-{{ $doc->partner_doctor_mobile }}</a>
                    </span>
                    @if($doc->partner_doctor_email)
                    <span>
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:{{ $doc->partner_doctor_email }}">{{ $doc->partner_doctor_email }}</a>
                    </span>
                    @endif
                </div>
            </div>

            {{-- Buttons --}}
            <div class="hero-actions">
                <button class="btn btn-book" onclick="openM('inquiryModal{{ $doc->id }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Book
                </button>
                <a href="tel:{{ $doc->partner_doctor_mobile }}" class="btn btn-call">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                    </svg>
                    Call
                </a>
                @if($doc->partner_doctor_google_map_link)
                <a href="{{ $doc->partner_doctor_google_map_link }}" target="_blank" class="btn btn-ghost">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="3 11 22 2 13 21 11 13 3 11" />
                    </svg>
                    Map
                </a>
                @endif
                <button class="btn btn-ghost" onclick="openM('feedbackModal{{ $doc->id }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                    Feedback
                </button>
            </div>
        </div>
    </div>

    <svg class="hero-wave" viewBox="0 0 1440 32" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,16 C360,32 720,0 1080,20 C1260,28 1360,14 1440,16 L1440,32 H0Z" fill="#faf9ff" />
    </svg>
</div>

<!-- {{-- ══ QUICK INFO BAR ══════════════════════════════════════════ --}} -->
<div class="info-bar">
    <div class="info-bar-inner">
        <div class="ibar-chip">
            <div class="ibar-icon ibar-icon--pur">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                </svg>
            </div>
            <div>
                <div class="ibar-lbl">Specialist</div>
                <div class="ibar-val">{{ $doc->partner_doctor_specialist }}</div>
            </div>
        </div>

        <div class="ibar-chip">
            <div class="ibar-icon ibar-icon--amb">
                ₹
            </div>
            <div>
                <div class="ibar-lbl">Consult Fee</div>
                <div class="ibar-val ibar-val--amb">₹ {{ $doc->partner_doctor_fees }}</div>
            </div>
        </div>

        <div class="ibar-chip">
            <div class="ibar-icon ibar-icon--rose">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div>
                <div class="ibar-lbl">Designation</div>
                <div class="ibar-val">{{ $doc->partner_doctor_designation }}</div>
            </div>
        </div>

        <div class="ibar-chip">
            <div class="ibar-icon ibar-icon--teal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4l3 3" />
                </svg>
            </div>
            <div>
                <div class="ibar-lbl">Status</div>
                @if($doc->status == 'Available')
                <div class="ibar-val ibar-val--ok">● Available</div>
                @elseif($doc->status == 'Unavailable')
                <div class="ibar-val ibar-val--no">● Unavailable</div>
                @else
                <div class="ibar-val" style="color:var(--muted)">● {{ $doc->status ?? 'N/A' }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- {{-- ══ TABS ════════════════════════════════════════════════════ --}} -->
<div class="tabs-wrap">
    <div class="tabs-scroll">
        <button class="tab-btn active" data-tab="schedule">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            Schedule & Info
        </button>
        <button class="tab-btn" data-tab="photos">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <polyline points="21 15 16 10 5 21" />
            </svg>
            Photos
        </button>
        <button class="tab-btn" data-tab="services">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="16" />
                <line x1="8" y1="12" x2="16" y2="12" />
            </svg>
            Services
        </button>
        <button class="tab-btn" data-tab="about">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="16" x2="12" y2="12" />
                <line x1="12" y1="8" x2="12.01" y2="8" />
            </svg>
            About
        </button>
    </div>
</div>

<!-- {{-- ══ CONTENT ═════════════════════════════════════════════════ --}} -->
<div class="content">

    <!-- {{-- ── SCHEDULE TAB ────────────────────────────────────── --}} -->
    <div class="tab-panel active" id="tab-schedule">
        <div class="sec-label">Visit Schedule & Details</div>

        <div class="sched-card">
            {{-- Header --}}
            <div class="sched-head">
                <div class="sched-head-avatar">
                    <img src="{{ asset('img/doctor.png') }}" alt="Doctor">
                </div>
                <div>
                    <div class="sched-head-name">{{ $doc->partner_doctor_designation }} {{ $doc->partner_doctor_name }}</div>
                    <div class="sched-head-sub">{{ $doc->partner_doctor_specialist }} · ₹ {{ $doc->partner_doctor_fees }}</div>
                </div>
            </div>

            {{-- Body --}}
            <div class="sched-body">

                {{-- Schedule table --}}
                @php
                    $allSchedule = $doc->normalized_schedule ?? [];
                    if (empty($allSchedule) && !empty($doc->visit_day_time)) {
                        $allSchedule = \App\Models\PartnerDoctorContactModel::normalizeSchedule($doc->visit_day_time);
                    }
                    // Day-wise hidden for now, only date-wise specific dates are shown
                    $dateSchedule = array_values(array_filter($allSchedule, function($s) {
                        return ($s['schedule_type'] ?? $s['type'] ?? '') === 'date' && !empty($s['date']);
                    }));
                @endphp
                <div class="sched-table-wrap">
                    <div class="sched-tbl-label" style="display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-calendar-check text-primary mr-1"></i> Chamber & Visiting Schedule</span>
                        <span class="badge badge-light text-primary font-weight-normal px-2 py-1" style="font-size: 11px; border: 1px solid #dbeafe;">Date Wise</span>
                    </div>

                    @if(!empty($dateSchedule))
                    <div class="schedule-cards-list" style="display: flex; flex-direction: column; gap: 12px; margin-top: 10px;">
                        @foreach($dateSchedule as $i => $visit)
                        @php
                            $visitDate = $visit['date'] ?? null;
                            $visitDay = $visit['day'] ?? ($visitDate ? \Carbon\Carbon::parse($visitDate)->format('l') : 'N/A');
                            $slots = $visit['slots'] ?? [];
                        @endphp
                        <div class="sched-item-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 8px; margin-bottom: 8px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #eff6ff; color: #2563eb; font-size: 15px;">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </span>
                                    <div>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 14px;">
                                            {{ \Carbon\Carbon::parse($visitDate)->format('d M Y') }}
                                            <span style="font-size: 12px; font-weight: 600; color: #059669; margin-left: 4px;">({{ $visitDay }})</span>
                                        </div>
                                        <div style="font-size: 11px; color: #0284c7; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Visiting Date Schedule</div>
                                    </div>
                                </div>
                                <div>
                                    @if($doc->status == 'Available')
                                    <span class="sbadge sbadge-ok" style="font-size: 11px; padding: 3px 8px;">Available</span>
                                    @elseif($doc->status == 'Unavailable')
                                    <span class="sbadge sbadge-no" style="font-size: 11px; padding: 3px 8px;">Unavailable</span>
                                    @else
                                    <span class="sbadge sbadge-def" style="font-size: 11px; padding: 3px 8px;">{{ $doc->status ?? 'Active' }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Slot list for this day/date --}}
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px;">
                                @if(!empty($slots))
                                    @foreach($slots as $slot)
                                    @php
                                        $slotId = $slot['id'] ?? '';
                                        $slotName = $slot['name'] ?? ucfirst($slotId);
                                        $slotBg = '#f8fafc';
                                        $slotBorder = '#e2e8f0';
                                        $slotColor = '#334155';
                                        $slotIcon = 'fa-regular fa-clock';

                                        if ($slotId === 'morning') {
                                            $slotBg = '#fefce8';
                                            $slotBorder = '#fef08a';
                                            $slotColor = '#854d0e';
                                            $slotIcon = 'fa-solid fa-sun';
                                        } elseif ($slotId === 'afternoon') {
                                            $slotBg = '#fff7ed';
                                            $slotBorder = '#fed7aa';
                                            $slotColor = '#9a3412';
                                            $slotIcon = 'fa-solid fa-cloud-sun';
                                        } elseif ($slotId === 'evening') {
                                            $slotBg = '#f5f3ff';
                                            $slotBorder = '#ddd6fe';
                                            $slotColor = '#5b21b6';
                                            $slotIcon = 'fa-solid fa-moon';
                                        }
                                    @endphp
                                    <div style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; background: {{ $slotBg }}; border: 1px solid {{ $slotBorder }}; font-size: 12px; color: {{ $slotColor }}; font-weight: 600;">
                                        <i class="{{ $slotIcon }}"></i>
                                        <span>{{ $slotName }}:</span>
                                        <span style="font-weight: 700;">
                                            @if(!empty($slot['start_time']) && !empty($slot['end_time']))
                                                {{ \Carbon\Carbon::parse($slot['start_time'])->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot['end_time'])->format('h:i A') }}
                                            @elseif(!empty($slot['start_time']))
                                                From {{ \Carbon\Carbon::parse($slot['start_time'])->format('h:i A') }}
                                            @else
                                                Session Active
                                            @endif
                                        </span>
                                    </div>
                                    @endforeach
                                @elseif(!empty($visit['start_time']) || !empty($visit['end_time']))
                                    <div style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; color: #334155; font-weight: 600;">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>Timing:</span>
                                        <span style="font-weight: 700;">
                                            {{ !empty($visit['start_time']) ? \Carbon\Carbon::parse($visit['start_time'])->format('h:i A') : '—' }} - 
                                            {{ !empty($visit['end_time']) ? \Carbon\Carbon::parse($visit['end_time'])->format('h:i A') : '—' }}
                                        </span>
                                    </div>
                                @else
                                    <span style="font-size: 12px; color: #94a3b8;">No slot timings specified</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p style="color:var(--muted);font-size:13px;padding:8px 0">No visiting schedule dates currently available.</p>
                    @endif
                </div>

                {{-- Info + actions --}}
                <div class="sched-aside">
                    <div class="sa-block">
                        <div class="sa-lbl">Specialization</div>
                        <div class="sa-val">{{ $doc->partner_doctor_specialist }}</div>
                    </div>
                    <div class="sa-block">
                        <div class="sa-lbl">Designation</div>
                        <div class="sa-val">{{ $doc->partner_doctor_designation }}</div>
                    </div>
                    <div class="sa-block">
                        <div class="sa-lbl">Consultation Fee</div>
                        <div class="sa-val sa-val--fee">₹ {{ $doc->partner_doctor_fees }}</div>
                    </div>
                    <div class="sa-block">
                        <div class="sa-lbl">Address</div>
                        <div class="sa-val sa-val--sm">
                            {{ $doc->partner_doctor_address }}{{ $doc->partner_doctor_landmark ? ', ' . $doc->partner_doctor_landmark : '' }},
                            {{ $doc->partner_doctor_city }}, {{ $doc->partner_doctor_state }}
                        </div>
                    </div>

                    <div class="sa-btns">
                        <button class="abtn abtn-rose" onclick="openM('inquiryModal{{ $doc->id }}')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            Book Appointment
                        </button>
                        <a href="tel:{{ $doc->partner_doctor_mobile }}" class="abtn abtn-call">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                            </svg>
                            Call Doctor
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── PHOTOS TAB ──────────────────────────────────────── --}}
    <div class="tab-panel" id="tab-photos">
        <div class="sec-label">Photos</div>
        @if($photos->isEmpty())
        <div class="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
            </svg>
            <p>No photos found. Please try again later.</p>
        </div>
        @else
        <div class="photo-grid">
            @foreach($photos as $photo)
            @php $imgs = is_string($photo->images) ? json_decode($photo->images, true) : $photo->images; @endphp
            @if(!empty($imgs) && is_array($imgs))
            @foreach($imgs as $item)
            <div class="photo-item" onclick="openPhoto('{{ asset('storage/' . $item) }}')">
                <img src="{{ asset('storage/' . $item) }}" alt="Photo">
                <div class="photo-over">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7" />
                    </svg>
                </div>
            </div>
            @endforeach
            @else
            <p style="color:var(--muted)">No images for this entry.</p>
            @endif
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── SERVICES TAB ────────────────────────────────────── --}}
    <div class="tab-panel" id="tab-services">
        <div class="sec-label">Service Lists</div>
        @if($services->isEmpty())
        <div class="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
            </svg>
            <p>No Service Lists found. Please try again later.</p>
        </div>
        @else
        <div class="svc-grid">
            @foreach($services as $service)
            @if(!empty($service->service_lists) && is_array($service->service_lists))
            @foreach($service->service_lists as $list)
            <div class="svc-item">
                <div class="svc-dot"></div>{{ $list }}
            </div>
            @endforeach
            @else
            <div class="svc-item" style="color:var(--muted)">No services for this entry.</div>
            @endif
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── ABOUT TAB ───────────────────────────────────────── --}}
    <div class="tab-panel" id="tab-about">
        <div class="sec-label">About Doctor</div>
        @if($aboutClinics->isEmpty())
        <div class="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="16" x2="12" y2="12" />
            </svg>
            <p>No About Details found. Please try again later.</p>
        </div>
        @else
        @foreach($aboutClinics as $ac)
        <div class="about-list">
            <div class="about-block">
                <span class="ab-tag">About</span>
                <h3>About the Doctor</h3>
                <p>{{ $ac->about_details }}</p>
            </div>
            <div class="about-block about-block--amb">
                <span class="ab-tag ab-tag--amb">Mission</span>
                <h3>Mission</h3>
                <p>{{ $ac->mission_details }}</p>
            </div>
            <div class="about-block about-block--rose">
                <span class="ab-tag ab-tag--rose">Vision</span>
                <h3>Vision</h3>
                <p>{{ $ac->vision_details }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>

</div>
<!-- {{-- /content --}} -->

<!-- {{-- ══ MODALS ══════════════════════════════════════════════════ --}} -->

<!-- {{-- Book Appointment --}} -->
<div class="modal-ov" id="inquiryModal{{ $doc->id }}">
    <div class="clemente-modal-box">
        <!-- Fixed Modern Header -->
        <div class="clemente-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <h6 style="margin: 0; font-weight: 700; color: #0f172a; font-size: 15px; letter-spacing: -0.2px;">Book Appointment</h6>
                    <small style="color: #64748b; font-size: 11px;">Instant Doctor Consultation</small>
                </div>
            </div>
            <button class="mclose" onclick="closeM('inquiryModal{{ $doc->id }}')">&times;</button>
        </div>

        <!-- Form wrapping scrollable body and fixed footer -->
        <form id="doctorBookingForm{{ $doc->id }}" action="{{ route('dw.doctor.inquiry.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex: 1 1 auto; min-height: 0; overflow: hidden; margin: 0;">
            @csrf
            <input type="hidden" name="currently_loggedin_partner_id" value="{{ $doc->currently_loggedin_partner_id }}">
            <input type="hidden" name="clinic_type" value="{{ strtolower($doc->clinic_registration_type ?? '') === 'others' ? 'Others' : 'Doctor' }}">
            <input type="hidden" name="dw_user_id" value="{{ $user->id ?? '' }}">
            <input type="hidden" name="clinic_name" value="{{ $doc->partner_doctor_name }}">

            <!-- Scrollable Inner Body without scrollbars -->
            <div class="clemente-modal-body">
                <div class="booking-grid-layout">
                    <!-- LEFT COLUMN: Doctor info, Date & Slot timing -->
                    <div class="booking-col-left">
                        <!-- Doctor Summary Badge Card -->
                        <div class="d-flex align-items-center justify-content-between p-2 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; gap: 10px;">
                            <div class="d-flex align-items-center" style="gap: 10px; min-width: 0;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </div>
                                <div style="min-width: 0;">
                                    <div style="font-weight: 700; color: #0f172a; font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $doc->partner_doctor_name }}</div>
                                    <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">{{ $doc->partner_doctor_specialist }}</div>
                                </div>
                            </div>
                            <span class="badge" style="background: #e0f2fe; color: #0284c7; font-size: 11px; padding: 4px 8px; border-radius: 6px; font-weight: 700; flex-shrink: 0;">
                                <i class="fa-solid fa-video mr-1"></i> Online Video
                            </span>
                        </div>

                        <div id="doctorScheduleNotice{{ $doc->id }}" class="mb-3 p-2 rounded small" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; display: none;"></div>

                        <!-- Available Consultation Dates (Interactive Segment) -->
                        <div class="mb-3" id="docAvailableDatesWrapper{{ $doc->id }}" style="display: none;">
                            <label class="clemente-label d-flex justify-content-between align-items-center mb-1">
                                <span><i class="fa-solid fa-calendar-day text-primary mr-1"></i> Consultation Date <span class="text-danger">*</span></span>
                                <span class="text-primary small" id="docSelectedDateLabel{{ $doc->id }}" style="font-size: 11px; font-weight: 700;"></span>
                            </label>
                            <div id="docAvailableDatesContainer{{ $doc->id }}" style="display: flex; flex-wrap: wrap; gap: 8px;"></div>
                        </div>

                        <div class="mb-3" id="docManualDateField{{ $doc->id }}">
                            <label class="clemente-label">Appointment Booking Date <span class="text-danger">*</span></label>
                            @auth<input class="clemente-input clemente-datepicker" type="text" name="booking_date" id="docBookingDate{{ $doc->id }}" value="{{ $user->booking_date ?? '' }}" placeholder="Select booking date" autocomplete="off" readonly required>@endauth
                            @guest<input class="clemente-input clemente-datepicker" name="booking_date" id="docBookingDate{{ $doc->id }}" type="text" placeholder="Select booking date" autocomplete="off" readonly required>@endguest
                        </div>

                        <!-- Available Timing Shift Slots -->
                        <div id="docSlotSection{{ $doc->id }}" class="mb-3" style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;">
                            <label class="clemente-label d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fa-solid fa-clock text-primary mr-1"></i> Available Shift <span class="text-danger">*</span></span>
                                <span class="text-muted small" id="docSlotNotice{{ $doc->id }}" style="font-size: 11px; font-weight: normal;">Select shift</span>
                            </label>
                            <div id="docSlotList{{ $doc->id }}" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px;"></div>

                            <!-- 10-Minute Appointment Sub-Slots Section -->
                            <div id="docSubSlotSection{{ $doc->id }}" style="display: none; border-top: 1px dashed #cbd5e1; padding-top: 10px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span style="font-size: 11.5px; font-weight: 700; color: #334155;">
                                        <i class="fa-regular fa-calendar-check text-success mr-1"></i> Choose 10-Minute Slot:
                                    </span>
                                    <span id="docSubSlotCount{{ $doc->id }}" class="badge bg-light text-secondary" style="font-size: 10px; border: 1px solid #e2e8f0;"></span>
                                </div>
                                <div id="docSubSlotList{{ $doc->id }}" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 6px;"></div>
                            </div>

                            <input type="hidden" name="booking_slot" id="docBookingSlot{{ $doc->id }}">
                        </div>

                        <div class="mb-2">
                            <label class="clemente-label">Booking Time <span class="text-danger">*</span></label>
                            @auth<input class="clemente-input" name="booking_time" id="docBookingTime{{ $doc->id }}" type="time" value="{{ $user->booking_time ?? '' }}" required>@endauth
                            @guest<input class="clemente-input" name="booking_time" id="docBookingTime{{ $doc->id }}" type="time" required>@endguest
                            <small class="text-muted d-block mt-1" id="docTimeHelp{{ $doc->id }}" style="font-size: 10.5px;">Time auto-aligns with your chosen slot.</small>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Patient info, Concern, Visit Mode -->
                    <div class="booking-col-right">
                        <!-- Patient Contact Information -->
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="clemente-label">Your Name <span class="text-danger">*</span></label>
                                @auth
                                <input class="clemente-input" name="user_name" value="{{ $user->user_name }}" readonly required>
                                @endauth
                                @guest
                                <input class="clemente-input" name="user_name" placeholder="Full name" required>
                                @endguest
                            </div>
                            <div class="col-6">
                                <label class="clemente-label">Mobile Number <span class="text-danger">*</span></label>
                                @auth
                                <input class="clemente-input" name="user_mobile" type="tel" value="{{ $user->user_mobile }}" required>
                                @endauth
                                @guest
                                <input class="clemente-input" name="user_mobile" type="tel" placeholder="Mobile number" required>
                                @endguest
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="clemente-label">Email Address</label>
                            @auth
                            <input class="clemente-input" name="user_email" type="email" value="{{ $user->user_email }}">
                            @endauth
                            @guest
                            <input class="clemente-input" name="user_email" type="email" placeholder="For booking receipt">
                            @endguest
                        </div>

                        @if(strtolower($doc->clinic_registration_type ?? '') === 'others' || str_contains(strtolower($doc->partner_doctor_specialist ?? ''), 'physio'))
                        <div class="mb-2">
                            <label class="clemente-label">Visit Mode <span class="text-danger">*</span></label>
                            <select name="visit_mode" class="clemente-input" required>
                                <option value="offline" {{ old('visit_mode', 'offline') == 'offline' ? 'selected' : '' }}>Physical Visit (Offline)</option>
                                <option value="online" {{ old('visit_mode') == 'online' ? 'selected' : '' }}>Video Calling (Online)</option>
                            </select>
                        </div>
                        @else
                        <input type="hidden" name="visit_mode" value="online">
                        @endif

                        <div class="mb-2">
                            <label class="clemente-label">Reason / Concern <span class="text-danger">*</span></label>
                            <textarea class="clemente-input" name="user_inquiry" rows="3" placeholder="Briefly describe your symptoms or reason for consultation..." required style="resize: none; font-size: 12.5px;"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fixed Bottom Footer (Always Visible, Never Cut Off) -->
            <div class="clemente-modal-footer">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
                    <div class="d-flex align-items-center" style="gap: 12px;">
                        <div>
                            <span class="small font-weight-bold text-secondary d-block" style="font-size: 11px; line-height: 1.2;">Total Payable</span>
                            <span class="font-weight-bold" style="color: #059669; font-size: 1.35rem; line-height: 1;">₹{{ number_format((float) ($doc->partner_doctor_fees ?: 500), 2) }}</span>
                        </div>
                        <div class="d-none d-sm-block border-left pl-3" style="border-color: #e2e8f0 !important;">
                            <small class="text-muted d-block" style="font-size: 10.5px;"><i class="fa-solid fa-shield-halved text-success mr-1"></i> Inclusive of taxes</small>
                            <small class="text-muted d-block" style="font-size: 10.5px;">Powered by Razorpay</small>
                        </div>
                    </div>

                    <button type="submit" id="docPaySubmitBtn{{ $doc->id }}" style="flex: 1; min-width: 200px; max-width: 320px; border: none; border-radius: 12px; background: linear-gradient(135deg, #e11d48 0%, #be123c 100%); color: #ffffff; font-weight: 700; font-size: 14px; padding: 11px 18px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3); transition: all 0.2s;">
                        <i class="fa-solid fa-lock"></i> Pay ₹{{ number_format((float) ($doc->partner_doctor_fees ?: 500), 2) }} & Confirm
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- {{-- Feedback --}} -->
<div class="modal-ov" id="feedbackModal{{ $doc->id }}">
    <div class="modal-box">
        <div class="mhead">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                </svg>
                Your Feedback
            </h3>
            <button class="mclose" onclick="closeM('feedbackModal{{ $doc->id }}')">&times;</button>
        </div>
        <div class="mbody">
            <form action="{{ route('dw.doctor.rating.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="currently_loggedin_partner_id" value="{{ $doc->currently_loggedin_partner_id }}">
                <input type="hidden" name="clinic_type" value="Doctor">
                <input type="hidden" name="clinic_name" value="{{ $doc->partner_doctor_name }}">
                <div class="fg">
                    <div>
                        <div class="flbl" style="margin-bottom:6px">Rate your experience</div>
                        <div class="rat-row">
                            @for($i=1;$i<=5;$i++)
                                <a href="javascript:void(0);" class="rat-a" data-r="{{ $i }}">
                                <img src="{{ asset('img/'.$i.'.png') }}" alt="{{ $i }}">
                                </a>
                                @endfor
                        </div>
                        <input type="hidden" id="feedRating" name="rating" value="0">
                        <div class="rat-txt">Selected: <strong><span id="ratingDisplay">0</span>/5</strong></div>
                    </div>
                    <div class="fr">
                        <div class="fgrp">
                            <label class="flbl">Name</label>
                            @auth
                            <input class="fc" name="user_name" value="{{ $user->user_name }}" readonly>
                            @endauth
                            @guest
                            <input class="fc" name="user_name" value="Guest" readonly>
                            @endguest
                        </div>
                        <div class="fgrp">
                            <label class="flbl">Email</label>
                            @auth
                            <input class="fc" name="user_email" value="{{ $user->user_email }}">
                            @endauth
                            @guest
                            <input class="fc" name="user_email" placeholder="Your email">
                            @endguest
                        </div>
                    </div>
                    <div class="fgrp">
                        <label class="flbl">Feedback *</label>
                        <textarea class="fc" name="feedback" rows="3" placeholder="Share your experience with this doctor..." required></textarea>
                    </div>
                    <button type="submit" class="btn-sub btn-sub-pur">Send Feedback</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- {{-- Photo Viewer --}} -->
<div class="modal-ov" id="photoViewer">
    <div class="modal-box">
        <div class="mhead">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                </svg>
                Photo
            </h3>
            <button class="mclose" onclick="closeM('photoViewer')">&times;</button>
        </div>
        <div class="mbody"><img id="pvImg" class="pv-img" src="" alt="Photo"></div>
    </div>
</div>

<!-- {{-- Result Modals --}} -->
<div class="modal-ov" id="inqurySendSuccessModal">
    <div class="modal-box">
        <div class="mbody">
            <div class="res-wrap">
                <div class="res-icon res-ok"><svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3">
                        <polyline points="20 6 9 17 4 12" />
                    </svg></div>
                <h3>Appointment Booked!</h3>
                <p>
                    @auth Hello {{ $user->user_name }}, your inquiry was sent successfully! @endauth
                    @guest Your inquiry was sent successfully! @endguest
                </p>
                <button class="btn-sub btn-sub-teal" onclick="closeM('inqurySendSuccessModal')">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-ov" id="inqurySendUnsuccessModal">
    <div class="modal-box">
        <div class="mbody">
            <div class="res-wrap">
                <div class="res-icon res-err"><svg viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="3">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg></div>
                <h3>Oops! Something went wrong.</h3>
                <p>Your inquiry could not be sent. Please try again.</p>
                <button class="btn-sub btn-sub-rose" onclick="closeM('inqurySendUnsuccessModal')">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-ov" id="feedSendSuccessModal">
    <div class="modal-box">
        <div class="mbody">
            <div class="res-wrap">
                <div class="res-icon res-ok"><svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3">
                        <polyline points="20 6 9 17 4 12" />
                    </svg></div>
                <h3>Thank You!</h3>
                <p>
                    @auth Hello {{ $user->user_name }}, thanks for your feedback! @endauth
                    @guest Thanks for your feedback! @endguest
                </p>
                <button class="btn-sub btn-sub-teal" onclick="closeM('feedSendSuccessModal')">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal-ov" id="feedSendUnsuccessModal">
    <div class="modal-box">
        <div class="mbody">
            <div class="res-wrap">
                <div class="res-icon res-err"><svg viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="3">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg></div>
                <h3>Error Sending Feedback</h3>
                <p>There was a problem. Please try again later.</p>
                <button class="btn-sub btn-sub-rose" onclick="closeM('feedSendUnsuccessModal')">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    document.querySelectorAll('.rating-a').forEach(function(ratingLink) {
        ratingLink.addEventListener('click', function() {

            const rating = this.getAttribute('data-rating');


            document.querySelectorAll('.rating-a').forEach(function(link) {
                link.classList.remove('selected');
            });

            this.classList.add('selected');

            document.getElementById('user-rating').textContent = rating;

            document.getElementById('rating').value = rating;
        });
    });
</script>

<!-- {{-- ══ JS ════════════════════════════════════════════════════════ --}} -->
<script>
    // Tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        });
    });

    // Modals
    function openM(id) {
        const e = document.getElementById(id);
        if (e) {
            e.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeM(id) {
        const e = document.getElementById(id);
        if (e) {
            e.classList.remove('open');
            document.body.style.overflow = '';
        }
    }
    document.querySelectorAll('.modal-ov').forEach(el => {
        el.addEventListener('click', e => {
            if (e.target === el) closeM(el.id);
        });
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.modal-ov.open').forEach(m => closeM(m.id));
    });

    // Photo viewer
    function openPhoto(src) {
        document.getElementById('pvImg').src = src;
        openM('photoViewer');
    }

    // Rating
    document.querySelectorAll('.rat-a').forEach(a => {
        a.addEventListener('click', () => {
            const v = parseInt(a.dataset.r);
            document.getElementById('feedRating').value = v;
            document.getElementById('ratingDisplay').textContent = v;
            document.querySelectorAll('.rat-a').forEach(r => r.classList.toggle('on', parseInt(r.dataset.r) <= v));
        });
    });

    // Session flashes
    @if(session('success'))
    document.addEventListener('DOMContentLoaded', () => openM('inqurySendSuccessModal'));
    @endif
    @if(session('error'))
    document.addEventListener('DOMContentLoaded', () => openM('inqurySendUnsuccessModal'));
    @endif
    @if(session('successFeed'))
    document.addEventListener('DOMContentLoaded', () => openM('feedSendSuccessModal'));
    @endif
    @if(session('errorFeed'))
    document.addEventListener('DOMContentLoaded', () => openM('feedSendUnsuccessModal'));
    @endif
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
function parseScheduleData(rawSchedule) {
    if (!rawSchedule) return { days: {}, dates: {}, isAllDays: false, summary: '' };
    let parsed = rawSchedule;
    if (typeof rawSchedule === 'string') {
        let s = rawSchedule.trim();
        while ((s.startsWith('"') && s.endsWith('"')) || (s.startsWith("'") && s.endsWith("'"))) {
            s = s.substring(1, s.length - 1).trim();
        }
        s = s.replace(/\\"/g, '"').replace(/\\'/g, "'");
        try {
            parsed = JSON.parse(s);
        } catch (e) {
            return { days: {}, dates: {}, isAllDays: false, summary: '' };
        }
    }
    if (!Array.isArray(parsed)) return { days: {}, dates: {}, isAllDays: false, summary: '' };

    const daysMap = {};
    const datesMap = {};
    let isAllDays = false;
    const summaryParts = [];

    const dayNameToNum = {
        'sunday': 0, 'sun': 0,
        'monday': 1, 'mon': 1,
        'tuesday': 2, 'tue': 2,
        'wednesday': 3, 'wed': 3,
        'thursday': 4, 'thu': 4,
        'friday': 5, 'fri': 5,
        'saturday': 6, 'sat': 6
    };
    const numToDayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    const format12h = (t) => {
        if (!t) return '';
        const p = t.split(':');
        let h = parseInt(p[0], 10);
        let m = p[1] || '00';
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12 || 12;
        return (h < 10 ? '0' + h : h) + ':' + m + ' ' + ampm;
    };

    parsed.forEach(item => {
        if (!item) return;
        const schedType = (item.schedule_type || 'day').toString().trim().toLowerCase();
        const dateStr = item.date ? item.date.trim() : null;
        const rawDay = (item.day || item.test_day || '').toString().trim().toLowerCase();

        // Extract slots
        let itemSlots = [];
        if (Array.isArray(item.slots) && item.slots.length > 0) {
            itemSlots = item.slots.map(s => ({
                id: s.id || 'slot',
                name: s.name || (s.id ? (s.id.charAt(0).toUpperCase() + s.id.slice(1)) : 'Slot'),
                start: s.start_time ? s.start_time.trim() : null,
                end: s.end_time ? s.end_time.trim() : null
            }));
        } else if (item.start_time || item.end_time) {
            itemSlots.push({
                id: 'regular',
                name: 'Visiting Hours',
                start: item.start_time ? item.start_time.trim() : null,
                end: item.end_time ? item.end_time.trim() : null
            });
        }

        const slotLabels = itemSlots.map(s => {
            if (s.start && s.end) return `${s.name} (${format12h(s.start)} - ${format12h(s.end)})`;
            if (s.start) return `${s.name} (From ${format12h(s.start)})`;
            return s.name;
        }).join(', ');

        if (schedType === 'date' && dateStr) {
            datesMap[dateStr] = itemSlots;
            summaryParts.push(`${dateStr} [${slotLabels || 'Available'}]`);
            return;
        }
        // Day-wise schedules are hidden for online booking for now
    });

    return {
        days: daysMap,
        dates: datesMap,
        isAllDays: false,
        summary: summaryParts.join(' | ')
    };
}

function attachScheduleValidation(dateInput, timeInput, scheduleNoticeEl, slotSectionEl, slotListEl, slotInputEl, rawSchedule, doctorOrTestName, dateWrapperEl, dateContainerEl, selectedDateLabelEl, manualDateFieldEl) {
    if (!dateInput || !timeInput) return null;
    const sched = parseScheduleData(rawSchedule);
    const availableDates = Object.keys(sched.dates).sort();

    if (dateContainerEl && availableDates.length > 0) {
        if (dateWrapperEl) dateWrapperEl.style.display = 'block';
        if (manualDateFieldEl) manualDateFieldEl.style.display = 'block';
        if (scheduleNoticeEl) scheduleNoticeEl.style.display = 'none';

        dateContainerEl.innerHTML = '';
        availableDates.forEach((dateStr, idx) => {
            const parts = dateStr.split('-');
            const d = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const formatted = `${d.getDate()} ${monthNames[d.getMonth()]} ${d.getFullYear()}`;
            const dayName = dayNames[d.getDay()];

            const pill = document.createElement('button');
            pill.type = 'button';
            pill.className = 'doc-date-chip';
            pill.dataset.date = dateStr;
            pill.innerHTML = `<i class="fa-regular fa-calendar-check text-primary"></i> <span><strong>${formatted}</strong></span> <span class="date-day-badge" style="background: #f1f5f9; color: #64748b; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; transition: all 0.18s;">${dayName}</span>`;

            pill.onclick = function () {
                dateContainerEl.querySelectorAll('.doc-date-chip').forEach(p => {
                    p.classList.remove('active');
                    const icon = p.querySelector('i');
                    if (icon) icon.className = 'fa-regular fa-calendar-check text-primary';
                });

                pill.classList.add('active');
                const icon = pill.querySelector('i');
                if (icon) icon.className = 'fa-solid fa-calendar-check';

                if (selectedDateLabelEl) {
                    selectedDateLabelEl.textContent = `${formatted} (${dayName})`;
                }

                if (dateInput._flatpickr) {
                    dateInput._flatpickr.setDate(dateStr, false);
                }
                dateInput.value = dateStr;
                syncDocSelectedDate(dateStr);
            };

            dateContainerEl.appendChild(pill);

            if (idx === 0) {
                pill.click();
            }
        });
    } else {
        if (dateWrapperEl) dateWrapperEl.style.display = 'none';
        if (manualDateFieldEl) manualDateFieldEl.style.display = 'block';
        if (scheduleNoticeEl) {
            if (sched.summary) {
                scheduleNoticeEl.innerHTML = `<i class="fa-solid fa-calendar-check text-primary mr-1"></i> Available Scheduled Dates: <strong>${sched.summary}</strong>`;
                scheduleNoticeEl.style.display = 'block';
            } else {
                scheduleNoticeEl.style.display = 'none';
            }
        }
    }

    const todayStr = new Date().toISOString().split('T')[0];
    dateInput.min = todayStr;

    // Initialize Flatpickr with physical date restrictions in calendar popup
    if (dateInput._flatpickr) {
        dateInput._flatpickr.destroy();
    }
    if (window.flatpickr) {
        const fpConfig = {
            dateFormat: "Y-m-d",
            minDate: "today",
            maxDate: new Date().fp_incr(90),
            disableMobile: true,
            onChange: function(selectedDates, dateStr) {
                dateInput.value = dateStr;
                syncDocSelectedDate(dateStr);
            }
        };

        if (availableDates.length > 0) {
            fpConfig.enable = availableDates;
        } else if (Object.keys(sched.days).length > 0) {
            fpConfig.disable = [
                function(date) {
                    if (sched.isAllDays) return false;
                    const dayNum = date.getDay();
                    return !(sched.days[dayNum] && sched.days[dayNum].length > 0);
                }
            ];
        }

        flatpickr(dateInput, fpConfig);
    }

    function getSlotsForDate(dateStr, dateObj) {
        if (dateStr && sched.dates[dateStr] && sched.dates[dateStr].length > 0) {
            return sched.dates[dateStr];
        }
        return null;
    }

    function isDateAvailable(dateStr, dateObj) {
        if (!dateStr) return false;
        if (availableDates.length > 0) {
            return Boolean(sched.dates[dateStr] && sched.dates[dateStr].length > 0);
        }
        if (Object.keys(sched.days).length > 0) {
            if (sched.isAllDays) return true;
            return Boolean(dateObj && sched.days[dateObj.getDay()] && sched.days[dateObj.getDay()].length > 0);
        }
        return true;
    }

    let selectedSlotObj = null;
    let currentBookedSlots = [];

    async function fetchBookedSlots(dateStr) {
        if (!dateStr) {
            currentBookedSlots = [];
            return [];
        }
        try {
            const partnerId = "{{ $doc->currently_loggedin_partner_id }}";
            const docId = "{{ $doc->id }}";
            const url = `/api/appointment-booked-slots?partner_id=${encodeURIComponent(partnerId)}&doctor_id=${encodeURIComponent(docId)}&date=${encodeURIComponent(dateStr)}`;
            const res = await fetch(url);
            const data = await res.json();
            if (data.status && Array.isArray(data.booked_slots)) {
                currentBookedSlots = data.booked_slots;
            } else {
                currentBookedSlots = [];
            }
        } catch (e) {
            currentBookedSlots = [];
        }
        return currentBookedSlots;
    }

    function renderSlots(slots) {
        if (!slotSectionEl || !slotListEl) return;
        slotListEl.innerHTML = '';
        selectedSlotObj = null;
        if (!slots || slots.length === 0) {
            slotSectionEl.style.display = 'none';
            if (slotInputEl) slotInputEl.value = '';
            timeInput.removeAttribute('min');
            timeInput.removeAttribute('max');
            const subSec = document.getElementById('docSubSlotSection{{ $doc->id }}');
            if (subSec) subSec.style.display = 'none';
            return;
        }

        slotSectionEl.style.display = 'block';
        const format12h = (t) => {
            if (!t) return '';
            const p = t.split(':');
            let h = parseInt(p[0], 10);
            let m = p[1] || '00';
            const ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
            return (h < 10 ? '0' + h : h) + ':' + m + ' ' + ampm;
        };

        slots.forEach((slot, idx) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'doc-slot-btn';
            btn.dataset.slotId = slot.id || slot.name || '';

            let iconHtml = '<i class="fa-regular fa-clock text-primary"></i>';
            if (slot.id === 'morning') iconHtml = '<i class="fa-solid fa-sun text-warning"></i>';
            else if (slot.id === 'afternoon') iconHtml = '<i class="fa-solid fa-cloud-sun text-warning"></i>';
            else if (slot.id === 'evening') iconHtml = '<i class="fa-solid fa-moon text-primary"></i>';

            let timeLabel = '';
            if (slot.start && slot.end) timeLabel = ` (${format12h(slot.start)} - ${format12h(slot.end)})`;
            else if (slot.start) timeLabel = ` (${format12h(slot.start)})`;

            btn.innerHTML = `${iconHtml} <span>${slot.name}${timeLabel}</span>`;

            btn.onclick = function () {
                slotListEl.querySelectorAll('.doc-slot-btn').forEach(b => {
                    b.classList.remove('active');
                });
                btn.classList.add('active');

                selectedSlotObj = slot;
                if (slotInputEl) slotInputEl.value = slot.id || slot.name;
                if (slot.start) {
                    timeInput.value = slot.start;
                    timeInput.min = slot.start;
                } else {
                    timeInput.removeAttribute('min');
                }
                if (slot.end) {
                    timeInput.max = slot.end;
                } else {
                    timeInput.removeAttribute('max');
                }

                // Sub-divide the chosen shift into 10-minute appointment slots
                renderSubSlots(slot);
            };

            slotListEl.appendChild(btn);

            // Select the first slot by default
            if (idx === 0) {
                btn.click();
            }
        });
    }

    function renderSubSlots(shiftSlot) {
        const subSlotSection = document.getElementById('docSubSlotSection{{ $doc->id }}');
        const subSlotList = document.getElementById('docSubSlotList{{ $doc->id }}');
        const subSlotCount = document.getElementById('docSubSlotCount{{ $doc->id }}');
        if (!subSlotSection || !subSlotList) return;

        subSlotList.innerHTML = '';
        if (!shiftSlot || !shiftSlot.start) {
            subSlotSection.style.display = 'none';
            return;
        }

        const parseTimeToMin = (t) => {
            if (!t) return 0;
            const p = t.split(':');
            return parseInt(p[0], 10) * 60 + parseInt(p[1] || '0', 10);
        };

        const minToTimeStr = (min) => {
            const h = Math.floor(min / 60);
            const m = min % 60;
            return (h < 10 ? '0' + h : h) + ':' + (m < 10 ? '0' + m : m);
        };

        const format12h = (t) => {
            if (!t) return '';
            const p = t.split(':');
            let h = parseInt(p[0], 10);
            let m = p[1] || '00';
            const ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
            return (h < 10 ? '0' + h : h) + ':' + m + ' ' + ampm;
        };

        const startMin = parseTimeToMin(shiftSlot.start);
        let endMin = shiftSlot.end ? parseTimeToMin(shiftSlot.end) : (startMin + 60);
        if (endMin <= startMin) endMin = startMin + 60;

        const subSlots = [];
        let slotNum = 1;
        for (let m = startMin; m < endMin; m += 10) {
            const subStart = minToTimeStr(m);
            const subEndMin = Math.min(m + 10, endMin);
            const subEnd = minToTimeStr(subEndMin);
            const isBooked = currentBookedSlots.includes(subStart);
            subSlots.push({
                number: slotNum,
                start: subStart,
                end: subEnd,
                label: `Slot ${slotNum} (${format12h(subStart)} - ${format12h(subEnd)})`,
                isBooked: isBooked
            });
            slotNum++;
        }

        if (subSlots.length === 0) {
            subSlotSection.style.display = 'none';
            return;
        }

        subSlotSection.style.display = 'block';
        if (subSlotCount) {
            const avail = subSlots.filter(s => !s.isBooked).length;
            subSlotCount.innerHTML = `<span class="text-success font-weight-bold">${avail}</span> / ${subSlots.length} available`;
        }

        let firstSelectableBtn = null;

        subSlots.forEach((sub) => {
            const subBtn = document.createElement('button');
            subBtn.type = 'button';
            subBtn.className = 'subslot-btn';
            subBtn.dataset.time = sub.start;

            if (sub.isBooked) {
                subBtn.classList.add('subslot-booked');
                subBtn.disabled = true;
                subBtn.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <span class="subslot-num">Slot ${sub.number}</span>
                        <span class="subslot-badge-booked">Booked</span>
                    </div>
                    <span class="subslot-time">${format12h(sub.start)} - ${format12h(sub.end)}</span>
                `;
            } else {
                subBtn.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <span class="subslot-num">Slot ${sub.number}</span>
                        <i class="fa-regular fa-clock text-primary" style="font-size: 10px;"></i>
                    </div>
                    <span class="subslot-time">${format12h(sub.start)} - ${format12h(sub.end)}</span>
                `;

                subBtn.onclick = function () {
                    subSlotList.querySelectorAll('.subslot-btn').forEach(b => b.classList.remove('active'));
                    subBtn.classList.add('active');

                    timeInput.value = sub.start;
                    if (slotInputEl) {
                        slotInputEl.value = `${shiftSlot.name} - ${sub.label}`;
                    }
                };

                if (!firstSelectableBtn) {
                    firstSelectableBtn = subBtn;
                }
            }

            subSlotList.appendChild(subBtn);
        });

        // Automatically select the first available subslot
        if (firstSelectableBtn) {
            firstSelectableBtn.click();
        } else {
            timeInput.value = '';
        }
    }

    function validateSelectedTime(dateObj, timeStr, showAlert) {
        if (!timeStr) return true;
        const dateStr = dateInput.value;
        const slots = getSlotsForDate(dateStr, dateObj);
        if (!slots || slots.length === 0) return true;

        const timeParts = timeStr.split(':');
        const pickedMin = parseInt(timeParts[0], 10) * 60 + parseInt(timeParts[1] || '0', 10);

        for (let s of slots) {
            if (!s.start && !s.end) return true;
            let startMin = s.start ? (parseInt(s.start.split(':')[0], 10) * 60 + parseInt(s.start.split(':')[1] || '0', 10)) : 0;
            let endMin = s.end ? (parseInt(s.end.split(':')[0], 10) * 60 + parseInt(s.end.split(':')[1] || '0', 10)) : 1439;

            if (pickedMin >= startMin && pickedMin <= endMin) {
                // Sync selected slot pill if user manually picked a time in another valid slot
                if (slotListEl && (!selectedSlotObj || (selectedSlotObj.id || selectedSlotObj.name) !== (s.id || s.name))) {
                    const targetBtn = Array.from(slotListEl.querySelectorAll('.doc-slot-btn')).find(
                        b => b.dataset.slotId === (s.id || s.name || '')
                    );
                    if (targetBtn) {
                        slotListEl.querySelectorAll('.doc-slot-btn').forEach(b => b.classList.remove('active'));
                        targetBtn.classList.add('active');
                        selectedSlotObj = s;
                        if (slotInputEl) slotInputEl.value = s.id || s.name;
                        if (s.start) timeInput.min = s.start; else timeInput.removeAttribute('min');
                        if (s.end) timeInput.max = s.end; else timeInput.removeAttribute('max');
                    }
                }
                return true;
            }
        }

        if (showAlert) {
            const format12h = (t) => {
                if (!t) return '';
                const p = t.split(':');
                let h = parseInt(p[0], 10);
                let m = p[1] || '00';
                const ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12 || 12;
                return (h < 10 ? '0' + h : h) + ':' + m + ' ' + ampm;
            };
            const slotDescs = slots.map(s => s.start && s.end ? `${s.name}: ${format12h(s.start)} - ${format12h(s.end)}` : (s.start ? `${s.name}: From ${format12h(s.start)}` : s.name)).join(', ');
            alert(`Selected time (${timeStr}) is outside the visiting hours for this date.\nAvailable slots: ${slotDescs}`);
        }
        return false;
    }

    async function syncDocSelectedDate(dateVal) {
        if (!dateVal) {
            if (slotSectionEl) slotSectionEl.style.display = 'none';
            selectedSlotObj = null;
            return;
        }
        const parts = dateVal.split('-');
        const dateObj = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));

        if (!isDateAvailable(dateVal, dateObj)) {
            alert(`Specialist is not available on this date (${dateVal}).\nPlease select an available scheduled date.`);
            if (dateInput._flatpickr) dateInput._flatpickr.clear();
            dateInput.value = '';
            timeInput.value = '';
            selectedSlotObj = null;
            if (slotSectionEl) slotSectionEl.style.display = 'none';
            if (slotInputEl) slotInputEl.value = '';
            if (selectedDateLabelEl) selectedDateLabelEl.textContent = '';
            if (dateContainerEl) {
                dateContainerEl.querySelectorAll('.doc-date-chip').forEach(p => p.classList.remove('active'));
            }
            return;
        }

        // Sync date chip if matches
        if (dateContainerEl) {
            dateContainerEl.querySelectorAll('.doc-date-chip').forEach(p => {
                if (p.dataset.date === dateVal) {
                    p.classList.add('active');
                    const icon = p.querySelector('i');
                    if (icon) icon.className = 'fa-solid fa-calendar-check';
                    if (selectedDateLabelEl) {
                        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        selectedDateLabelEl.textContent = `${dateObj.getDate()} ${monthNames[dateObj.getMonth()]} ${dateObj.getFullYear()} (${dayNames[dateObj.getDay()]})`;
                    }
                } else {
                    p.classList.remove('active');
                    const icon = p.querySelector('i');
                    if (icon) icon.className = 'fa-regular fa-calendar-check text-primary';
                }
            });
        }

        // Fetch already booked slots for this date to disable booked 10-min slots
        await fetchBookedSlots(dateVal);

        const slots = getSlotsForDate(dateVal, dateObj);
        renderSlots(slots);
    }

    dateInput.onchange = function () {
        syncDocSelectedDate(this.value);
    };

    timeInput.onchange = function () {
        if (!dateInput.value) {
            alert('Please select an appointment date first.');
            this.value = '';
            return;
        }
        const parts = dateInput.value.split('-');
        const dateObj = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
        if (!validateSelectedTime(dateObj, this.value, true)) {
            const slots = getSlotsForDate(dateInput.value, dateObj);
            if (selectedSlotObj && selectedSlotObj.start) {
                this.value = selectedSlotObj.start;
            } else if (slots && slots[0] && slots[0].start) {
                this.value = slots[0].start;
            } else {
                this.value = '';
            }
        }
    };

    return { sched, validateSelectedTime, isDateAvailable, getSlotsForDate, getCurrentBookedSlots: () => currentBookedSlots };
}

document.addEventListener('DOMContentLoaded', function () {
    const bookingForm = document.getElementById('doctorBookingForm{{ $doc->id }}');
    if (!bookingForm) return;

    const dateInput = document.getElementById('docBookingDate{{ $doc->id }}');
    const timeInput = document.getElementById('docBookingTime{{ $doc->id }}');
    const noticeEl = document.getElementById('doctorScheduleNotice{{ $doc->id }}');
    const slotSection = document.getElementById('docSlotSection{{ $doc->id }}');
    const slotList = document.getElementById('docSlotList{{ $doc->id }}');
    const slotInput = document.getElementById('docBookingSlot{{ $doc->id }}');
    const dateWrapper = document.getElementById('docAvailableDatesWrapper{{ $doc->id }}');
    const dateContainer = document.getElementById('docAvailableDatesContainer{{ $doc->id }}');
    const selectedDateLabel = document.getElementById('docSelectedDateLabel{{ $doc->id }}');
    const manualDateField = document.getElementById('docManualDateField{{ $doc->id }}');

    const validator = attachScheduleValidation(
        dateInput,
        timeInput,
        noticeEl,
        slotSection,
        slotList,
        slotInput,
        @json($doc->normalized_schedule ?: ($doc->visit_day_time ?? [])),
        "{{ $doc->partner_doctor_name }}",
        dateWrapper,
        dateContainer,
        selectedDateLabel,
        manualDateField
    );

    bookingForm.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!dateInput || !dateInput.value) {
            alert('Please select an appointment consultation date.');
            if (dateInput) dateInput.focus();
            return;
        }

        if (!timeInput || !timeInput.value) {
            alert('Please select an available appointment slot.');
            if (timeInput) timeInput.focus();
            return;
        }

        // Validate schedule restrictions & already booked slot
        if (validator && dateInput && dateInput.value) {
            const parts = dateInput.value.split('-');
            const dateObj = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));

            if (!validator.isDateAvailable(dateInput.value, dateObj)) {
                alert(`Appointment is not available on this date (${dateInput.value}). Please select an available scheduled date.`);
                dateInput.focus();
                return;
            }

            const activeBookedSlots = validator.getCurrentBookedSlots ? validator.getCurrentBookedSlots() : [];
            if (activeBookedSlots.includes(timeInput.value)) {
                alert(`This 10-minute slot (${timeInput.value}) has already been booked by another patient for this date. Please select an available slot.`);
                timeInput.focus();
                return;
            }

            if (!validator.validateSelectedTime(dateObj, timeInput.value, true)) {
                timeInput.focus();
                return;
            }
        }

        const submitBtn = document.getElementById('docPaySubmitBtn{{ $doc->id }}');
        const origText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Securing order...';

        const formData = new FormData(bookingForm);
        const bookingPayload = {
            currently_loggedin_partner_id: formData.get('currently_loggedin_partner_id'),
            clinic_type: formData.get('clinic_type') || 'Doctor',
            clinic_name: formData.get('clinic_name') || '{{ $doc->partner_doctor_name }}',
            doctor_id: '{{ $doc->id }}',
            dw_user_id: formData.get('dw_user_id') || '',
            user_name: (formData.get('user_name') || '').trim(),
            user_mobile: (formData.get('user_mobile') || '').trim(),
            user_email: (formData.get('user_email') || '').trim(),
            booking_date: formData.get('booking_date'),
            booking_time: formData.get('booking_time'),
            booking_slot: (formData.get('booking_slot') || '').trim(),
            visit_mode: formData.get('visit_mode') || 'online',
            user_inquiry: (formData.get('user_inquiry') || '').trim(),
            amount: '{{ $doc->partner_doctor_fees ?: 500 }}'
        };

        if (!bookingPayload.user_name || !bookingPayload.user_mobile || !bookingPayload.booking_date || !bookingPayload.booking_time) {
            alert('Please fill in all required appointment fields.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = origText;
            return;
        }

        // Step 1: Initialize payment order with backend
        fetch("{{ route('payment.create.order') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(bookingPayload)
        })
        .then(function (res) { return res.json(); })
        .then(function (orderData) {
            if (!orderData.status) {
                throw new Error(orderData.message || 'Unable to initialize payment.');
            }

            // Step 2: Open Razorpay checkout sheet
            const options = {
                key: orderData.key,
                amount: orderData.amount,
                currency: orderData.currency || 'INR',
                name: 'Doctorwala Health',
                description: 'Consultation with {{ $doc->partner_doctor_name }}',
                order_id: orderData.order_id,
                prefill: {
                    name: bookingPayload.user_name,
                    contact: bookingPayload.user_mobile,
                    email: bookingPayload.user_email
                },
                theme: {
                    color: '#0284c7'
                },
                handler: function (rzpResponse) {
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Verifying & Confirming...';

                    // Step 3: Verify HMAC signature and save appointment
                    fetch("{{ route('payment.verify') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ...bookingPayload,
                            razorpay_order_id: rzpResponse.razorpay_order_id,
                            razorpay_payment_id: rzpResponse.razorpay_payment_id,
                            razorpay_signature: rzpResponse.razorpay_signature
                        })
                    })
                    .then(function (res) { return res.json(); })
                    .then(function (verifyData) {
                        if (verifyData.status) {
                            closeM('inquiryModal{{ $doc->id }}');
                            openM('inqurySendSuccessModal');
                            bookingForm.reset();
                        } else {
                            alert(verifyData.message || 'Payment received but verification failed. Please contact support.');
                        }
                    })
                    .catch(function (err) {
                        alert('Error confirming payment: ' + err.message);
                    })
                    .finally(function () {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = origText;
                    });
                },
                modal: {
                    ondismiss: function () {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = origText;
                    }
                }
            };

            const rzpInstance = new Razorpay(options);
            rzpInstance.on('payment.failed', function (resp) {
                alert('Payment Failed: ' + (resp.error.description || 'Payment was declined or cancelled.'));
                submitBtn.disabled = false;
                submitBtn.innerHTML = origText;
            });
            rzpInstance.open();
        })
        .catch(function (err) {
            alert(err.message || 'Payment initiation failed. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = origText;
        });
    });
});
</script>
@endsection