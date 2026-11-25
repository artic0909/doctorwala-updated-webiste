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
    <div class="modal-box">
        <div class="mhead">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                Book Appointment
            </h3>
            <button class="mclose" onclick="closeM('inquiryModal{{ $doc->id }}')">&times;</button>
        </div>
        <div class="mbody">
            <form id="doctorBookingForm{{ $doc->id }}" action="{{ route('dw.doctor.inquiry.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="currently_loggedin_partner_id" value="{{ $doc->currently_loggedin_partner_id }}">
                <input type="hidden" name="clinic_type" value="{{ strtolower($doc->clinic_registration_type ?? '') === 'others' ? 'Others' : 'Doctor' }}">
                <input type="hidden" name="dw_user_id" value="{{ $user->id ?? '' }}">
                <div class="fg">
                    <div class="fgrp">
                        <label class="flbl">Inquiry About</label>
                        <input class="fc" name="clinic_name" value="{{ $doc->partner_doctor_name }}" readonly>
                    </div>
                    <div class="fr">
                        <div class="fgrp">
                            <label class="flbl">Your Name *</label>
                            @auth
                            <input class="fc" name="user_name" value="{{ $user->user_name }}" readonly required>
                            @endauth
                            @guest
                            <input class="fc" name="user_name" placeholder="Your name" required>
                            @endguest
                        </div>
                        <div class="fgrp">
                            <label class="flbl">Mobile *</label>
                            @auth
                            <input class="fc" name="user_mobile" type="tel" value="{{ $user->user_mobile }}" required>
                            @endauth
                            @guest
                            <input class="fc" name="user_mobile" type="tel" placeholder="Mobile number" required>
                            @endguest
                        </div>
                    </div>
                    <div class="fgrp">
                        <label class="flbl">Email</label>
                        @auth
                        <input class="fc" name="user_email" type="email" value="{{ $user->user_email }}">
                        @endauth
                        @guest
                        <input class="fc" name="user_email" type="email" placeholder="Email address (for booking receipt)">
                        @endguest
                    </div>
                    <div id="doctorScheduleNotice{{ $doc->id }}" class="mb-3 p-2 rounded small" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; display: none;"></div>
                    <div class="fgrp">
                        <label class="flbl">Appointment Booking Date *</label>
                        @auth<input class="fc" type="date" name="booking_date" id="docBookingDate{{ $doc->id }}" value="{{ $user->booking_date ?? '' }}" required>@endauth
                        @guest<input class="fc" name="booking_date" id="docBookingDate{{ $doc->id }}" type="date" required>@endguest
                    </div>

                    {{-- Dynamic Slot Selection Section --}}
                    <div id="docSlotSection{{ $doc->id }}" class="mb-3" style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px;">
                        <label class="flbl" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span><i class="fa-solid fa-clock text-primary mr-1"></i> Available Slot (Select One) *</span>
                            <span class="text-muted small" id="docSlotNotice{{ $doc->id }}" style="font-size: 11px;">Select a slot</span>
                        </label>
                        <div id="docSlotList{{ $doc->id }}" style="display: flex; flex-wrap: wrap; gap: 8px;"></div>
                        <input type="hidden" name="booking_slot" id="docBookingSlot{{ $doc->id }}">
                    </div>

                    <div class="fgrp">
                        <label class="flbl">Appointment Booking Time *</label>
                        @auth<input class="fc" name="booking_time" id="docBookingTime{{ $doc->id }}" type="time" value="{{ $user->booking_time ?? '' }}" required>@endauth
                        @guest<input class="fc" name="booking_time" id="docBookingTime{{ $doc->id }}" type="time" required>@endguest
                        <small class="text-muted d-block mt-1" id="docTimeHelp{{ $doc->id }}" style="font-size: 11px;">Time will auto-align with your selected visiting slot.</small>
                    </div>

                    @if(strtolower($doc->clinic_registration_type ?? '') === 'others' || str_contains(strtolower($doc->partner_doctor_specialist ?? ''), 'physio'))
                    <div class="fgrp">
                        <label class="flbl">Visit Mode *</label>
                        <select name="visit_mode" class="fc" required>
                            <option value="offline" {{ old('visit_mode', 'offline') == 'offline' ? 'selected' : '' }}>Physical Visit (Offline)</option>
                            <option value="online" {{ old('visit_mode') == 'online' ? 'selected' : '' }}>Video Calling (Online)</option>
                        </select>
                    </div>
                    @else
                    {{-- Doctor registration type is directly online (video calling) --}}
                    <input type="hidden" name="visit_mode" value="online">
                    <div class="fgrp">
                        <div class="p-2 rounded bg-light border text-muted small">
                            <i class="fa-solid fa-video text-primary mr-1"></i> Consultation Mode: <strong>Online Video Call</strong>
                        </div>
                    </div>
                    @endif
                    <div class="fgrp">
                        <label class="flbl">Describe your concern *</label>
                        <textarea class="fc" name="user_inquiry" rows="3" placeholder="Describe your health issue or reason for visit..." required></textarea>
                    </div>

                    <div class="p-3 mb-2 rounded" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small font-weight-bold text-dark"><i class="fa-solid fa-shield-halved text-success mr-1"></i> Consultation Fee:</span>
                            <span class="font-weight-bold text-success" style="font-size: 1.15rem;">₹{{ number_format((float) ($doc->partner_doctor_fees ?: 500), 2) }}</span>
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">Secure online payment powered by Razorpay</small>
                    </div>

                    <button type="submit" id="docPaySubmitBtn{{ $doc->id }}" class="btn-sub btn-sub-rose" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid fa-lock"></i> Pay ₹{{ number_format((float) ($doc->partner_doctor_fees ?: 500), 2) }} & Confirm Booking
                    </button>
                </div>
            </form>
        </div>
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

function attachScheduleValidation(dateInput, timeInput, scheduleNoticeEl, slotSectionEl, slotListEl, slotInputEl, rawSchedule, doctorOrTestName) {
    if (!dateInput || !timeInput) return null;
    const sched = parseScheduleData(rawSchedule);

    if (scheduleNoticeEl) {
        if (sched.summary) {
            scheduleNoticeEl.innerHTML = `<i class="fa-solid fa-calendar-check text-primary mr-1"></i> Available Scheduled Dates: <strong>${sched.summary}</strong>`;
            scheduleNoticeEl.style.display = 'block';
        } else {
            scheduleNoticeEl.style.display = 'none';
        }
    }

    const todayStr = new Date().toISOString().split('T')[0];
    dateInput.min = todayStr;

    function getSlotsForDate(dateStr, dateObj) {
        if (dateStr && sched.dates[dateStr] && sched.dates[dateStr].length > 0) {
            return sched.dates[dateStr];
        }
        return null;
    }

    function isDateAvailable(dateStr, dateObj) {
        if (!dateStr) return false;
        return Boolean(sched.dates[dateStr] && sched.dates[dateStr].length > 0);
    }

    function renderSlots(slots) {
        if (!slotSectionEl || !slotListEl) return;
        slotListEl.innerHTML = '';
        if (!slots || slots.length === 0) {
            slotSectionEl.style.display = 'none';
            if (slotInputEl) slotInputEl.value = '';
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
            btn.className = 'btn btn-sm slot-pill-btn';
            btn.style.cssText = 'border-radius: 8px; font-weight: 600; font-size: 12px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; border: 1.5px solid #cbd5e1; background: #ffffff; color: #334155; transition: all 0.2s;';

            let iconHtml = '<i class="fa-regular fa-clock"></i>';
            if (slot.id === 'morning') iconHtml = '<i class="fa-solid fa-sun text-warning"></i>';
            else if (slot.id === 'afternoon') iconHtml = '<i class="fa-solid fa-cloud-sun text-warning"></i>';
            else if (slot.id === 'evening') iconHtml = '<i class="fa-solid fa-moon text-primary"></i>';

            let timeLabel = '';
            if (slot.start && slot.end) timeLabel = ` (${format12h(slot.start)} - ${format12h(slot.end)})`;
            else if (slot.start) timeLabel = ` (${format12h(slot.start)})`;

            btn.innerHTML = `${iconHtml} <span>${slot.name}${timeLabel}</span>`;

            btn.onclick = function () {
                slotListEl.querySelectorAll('.slot-pill-btn').forEach(b => {
                    b.style.borderColor = '#cbd5e1';
                    b.style.background = '#ffffff';
                    b.style.color = '#334155';
                });
                btn.style.borderColor = '#2563eb';
                btn.style.background = '#eff6ff';
                btn.style.color = '#1d4ed8';

                if (slotInputEl) slotInputEl.value = slot.id || slot.name;
                if (slot.start) {
                    timeInput.value = slot.start;
                    timeInput.min = slot.start;
                    if (slot.end) timeInput.max = slot.end;
                }
            };

            slotListEl.appendChild(btn);

            // Select the first slot by default
            if (idx === 0) {
                btn.click();
            }
        });
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

    dateInput.onchange = function () {
        if (!this.value) {
            if (slotSectionEl) slotSectionEl.style.display = 'none';
            return;
        }
        const parts = this.value.split('-');
        const dateObj = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));

        if (!isDateAvailable(this.value, dateObj)) {
            alert(`Specialist is not available on this date (${this.value}).\nPlease select an available scheduled date.`);
            this.value = '';
            timeInput.value = '';
            if (slotSectionEl) slotSectionEl.style.display = 'none';
            if (slotInputEl) slotInputEl.value = '';
            return;
        }

        const slots = getSlotsForDate(this.value, dateObj);
        renderSlots(slots);
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
            if (slots && slots[0] && slots[0].start) {
                this.value = slots[0].start;
            } else {
                this.value = '';
            }
        }
    };

    return { sched, validateSelectedTime, isDateAvailable, getSlotsForDate };
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

    const validator = attachScheduleValidation(
        dateInput,
        timeInput,
        noticeEl,
        slotSection,
        slotList,
        slotInput,
        @json($doc->normalized_schedule ?: ($doc->visit_day_time ?? [])),
        "{{ $doc->partner_doctor_name }}"
    );

    bookingForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate schedule restrictions before submitting
        if (validator && dateInput && dateInput.value) {
            const parts = dateInput.value.split('-');
            const dateObj = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
            const dayNum = dateObj.getDay();
            const numToDayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

            if (!validator.isDateAvailable(dateInput.value, dateObj)) {
                alert(`Appointment is not available on this date (${dateInput.value}). Please select an available scheduled date.`);
                dateInput.focus();
                return;
            }

            if (timeInput && timeInput.value) {
                if (!validator.validateSelectedTime(dateObj, timeInput.value, true)) {
                    timeInput.focus();
                    return;
                }
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