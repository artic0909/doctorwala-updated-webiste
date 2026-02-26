@extends('frontend.layout.app')

@section('title', 'My Profile & Medical history - DoctorWala.info')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('./css/user-profile.css') }}">
    <style>
        marquee {
            display: none !important;
        }
    </style>
</head>

<div class="up-hero">
    <div class="up-hero__wave">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,60 C480,0 960,80 1440,30 L1440,80 L0,80 Z" fill="#f0f9ff" />
        </svg>
    </div>

    <div class="up-wrap">
        <div class="up-hero__inner">
            <div class="up-hero__left">
                <div class="up-hero__av-wrap">
                    <div class="up-hero__av">
                        @if(Auth::user()->image)
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->user_name }}">
                        @else
                        {{ strtoupper(substr(Auth::user()->user_name, 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->user_name, ' '), 1, 1)) }}
                        @endif
                    </div>
                    <span class="up-hero__status-dot"></span>
                </div>
                <div class="up-hero__info">
                    <h1 class="up-hero__name" style="text-transform: capitalize;">{{ Auth::user()->user_name }}</h1>
                    <p class="up-hero__email">{{ Auth::user()->user_email }}</p>
                    <div class="up-hero__badges">
                        <span class="up-hero__badge"><span class="dot" style="background-color: red"></span> Not Verified</span>
                    </div>
                </div>
            </div>

            <div class="up-hero__actions">
                <button class="up-hero__btn up-hero__btn--white" onclick="openModal()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit Profile
                </button>
                <a href="/book-appointment" class="up-hero__btn up-hero__btn--glass">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="18" height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                    Click to Verify
                </a>
            </div>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════════
     MAIN LAYOUT
══════════════════════════════════════ -->
<div class="up-wrap">
    <div class="up-layout">

        <!-- ═══════════════ SIDEBAR ═══════════════ -->
        <aside class="up-sidebar">

            <!-- Quick Stats -->
            <div class="up-card">
                <div class="up-card__head">
                    <div class="up-card__title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                        Health Overview
                    </div>
                </div>
                <div class="up-qstat-grid">
                    <div class="up-qstat up-qstat--teal">
                        <div class="up-qstat__ico">🏥</div>
                        <div class="up-qstat__num">12</div>
                        <div class="up-qstat__lbl">Visits</div>
                    </div>
                    <div class="up-qstat up-qstat--mint">
                        <div class="up-qstat__ico">💊</div>
                        <div class="up-qstat__num">8</div>
                        <div class="up-qstat__lbl">Medicines</div>
                    </div>
                    <div class="up-qstat up-qstat--coral">
                        <div class="up-qstat__ico">📋</div>
                        <div class="up-qstat__num">5</div>
                        <div class="up-qstat__lbl">Reports</div>
                    </div>
                    <div class="up-qstat up-qstat--amber">
                        <div class="up-qstat__ico">⭐</div>
                        <div class="up-qstat__num">4.9</div>
                        <div class="up-qstat__lbl">Rating</div>
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="up-card">
                <div class="up-card__head" style="padding-bottom:0">
                    <div class="up-card__title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                        Personal Info
                    </div>
                    <button onclick="openModal()" style="background:var(--p-lt);border:none;color:var(--p);border-radius:8px;padding:5px 10px;font-size:.7rem;font-weight:800;cursor:pointer;display:flex;align-items:center;gap:4px">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4z" />
                        </svg>
                        Edit
                    </button>
                </div>
                <div class="up-info-list">
                    <div class="up-info-row">
                        <div class="up-info-ico">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <path d="M16 2v4M8 2v4M3 10h18" />
                            </svg>
                        </div>
                        <div>
                            <div class="up-info-lbl">Date of Birth</div>
                            <div class="up-info-val">{{ Auth::user()->dob ? date('M d, Y', strtotime(Auth::user()->dob)) : 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="up-info-row">
                        <div class="up-info-ico">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20" />
                            </svg>
                        </div>
                        <div>
                            <div class="up-info-lbl">Blood Group</div>
                            <div class="up-info-val" style="color:var(--rose);font-size:.95rem">{{ Auth::user()->blood_group ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="up-info-row">
                        <div class="up-info-ico">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.12.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.09-1.09a2 2 0 012.11-.45c.91.34 1.85.58 2.81.7A2 2 0 0122 16.92z" />
                            </svg>
                        </div>
                        <div>
                            <div class="up-info-lbl">Phone</div>
                            <div class="up-info-val">{{ Auth::user()->user_mobile ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="up-info-row">
                        <div class="up-info-ico">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div>
                            <div class="up-info-lbl">Location</div>
                            <div class="up-info-val">{{ Auth::user()->user_city ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="up-info-row">
                        <div class="up-info-ico">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                            </svg>
                        </div>
                        <div>
                            <div class="up-info-lbl">Gender</div>
                            <div class="up-info-val">{{ Auth::user()->gender ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="up-info-row">
                        <div class="up-info-ico">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                            </svg>
                        </div>
                        <div>
                            <div class="up-info-lbl">Allergies</div>
                            <div class="up-info-val">{{ Auth::user()->allergies ?? 'None' }}</div>
                        </div>
                    </div>
                    <div class="up-info-row">
                        <div class="up-info-ico">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="3" width="20" height="14" rx="2" />
                                <line x1="8" y1="21" x2="16" y2="21" />
                                <line x1="12" y1="17" x2="12" y2="21" />
                            </svg>
                        </div>
                        <div>
                            <div class="up-info-lbl">Member Since</div>
                            <div class="up-info-val">{{ Auth::user()->created_at ? date('M Y', strtotime(Auth::user()->created_at)) : 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Score Ring -->
            <div class="up-card">
                <div class="up-card__head">
                    <div class="up-card__title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                        Health Score
                    </div>
                </div>
                <div class="up-health-score">
                    <div class="up-score-ring">
                        <svg width="120" height="120" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--border)" stroke-width="10" />
                            <circle cx="60" cy="60" r="50" fill="none" stroke="var(--mint)" stroke-width="10"
                                stroke-dasharray="314" stroke-dashoffset="47" stroke-linecap="round" />
                        </svg>
                        <div class="up-score-ring__text">
                            <span class="up-score-ring__num">85</span>
                            <span class="up-score-ring__sub">/100</span>
                        </div>
                    </div>
                    <div class="up-score-label">Excellent Health</div>
                    <div class="up-score-sub">Based on your medical history & vitals</div>

                    <div class="up-score-bars">
                        <div class="up-sbar-row">
                            <div class="up-sbar-top"><span>Diet</span><span style="color:var(--mint);font-weight:800">90%</span></div>
                            <div class="up-sbar-track">
                                <div class="up-sbar-fill" style="width:90%;background:var(--mint)"></div>
                            </div>
                        </div>
                        <div class="up-sbar-row">
                            <div class="up-sbar-top"><span>Exercise</span><span style="color:var(--p);font-weight:800">75%</span></div>
                            <div class="up-sbar-track">
                                <div class="up-sbar-fill" style="width:75%;background:var(--p)"></div>
                            </div>
                        </div>
                        <div class="up-sbar-row">
                            <div class="up-sbar-top"><span>Sleep</span><span style="color:var(--amber);font-weight:800">70%</span></div>
                            <div class="up-sbar-track">
                                <div class="up-sbar-fill" style="width:70%;background:var(--amber)"></div>
                            </div>
                        </div>
                        <div class="up-sbar-row">
                            <div class="up-sbar-top"><span>Stress</span><span style="color:var(--coral);font-weight:800">60%</span></div>
                            <div class="up-sbar-track">
                                <div class="up-sbar-fill" style="width:60%;background:var(--coral)"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </aside>


        <!-- ═══════════════ MAIN ═══════════════ -->
        <div class="up-main">

            <!-- Next Appointment Banner -->
            <div class="up-next-appt">
                <div class="up-next-appt__ico">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                </div>
                <div class="up-next-appt__info">
                    <div class="up-next-appt__label">Upcoming Appointment</div>
                    <div class="up-next-appt__title">Dr. Priya Sharma — Cardiologist</div>
                    <div class="up-next-appt__sub">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        Tomorrow, 28 Feb 2026 &bull; 11:30 AM &bull; Online Consultation
                    </div>
                </div>
                <a href="#" class="up-next-appt__action">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                    View Details
                </a>
            </div>


            <!-- MEDICAL VIRTUAL CARD -->
            <div class="up-med-card">
                <div class="up-med-card__shimmer"></div>
                <div class="up-med-card__chip"></div>
                <div class="up-med-card__wifi">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01" />
                    </svg>
                </div>

                <div class="up-med-card__top">
                    <div class="up-med-card__logo-wrap">
                        <div class="up-med-card__logo-ico">
                            <img src="{{ asset('img/logo.png') }}" alt="DoctorWala">
                        </div>
                        <div>
                            <div class="up-med-card__brand">
                                DoctorWala
                                <span>MEDICAL CARD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="up-med-card__mid">
                    <div class="up-med-card__number">
                        <span>•••• </span> &nbsp;{{ Auth::user()->medical_card_no ?? '******' }}
                    </div>
                </div>

                <div class="up-med-card__bottom">
                    <div class="up-med-card__holder">
                        <div class="up-med-card__field-lbl">Card Holder</div>
                        <div class="up-med-card__field-val">{{ Auth::user()->user_name ?? 'N/A' }}</div>
                    </div>
                    <div class="up-med-card__meta">
                        <div>
                            <div class="up-med-card__field-lbl">Member ID</div>
                            <div class="up-med-card__field-val">{{ Auth::user()->memberid ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="up-med-card__field-lbl">Expiry Date</div>
                            <div class="up-med-card__field-val">12/28</div>
                        </div>
                    </div>
                </div>

                <div class="up-med-card__actions">

                    @if(!Auth::user()->medical_card_no)
    <form action="{{ route('dw.generate.medical-card') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="up-med-card__btn up-med-card__btn--white">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                <polyline points="14 2 14 8 20 8" />
            </svg>
            Create Medical Card
        </button>
    </form>
@else

                    <button class="up-med-card__btn up-med-card__btn--white" onclick="switchTab('history')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        View Medical History
                    </button>
                    @endif


                    <button class="up-med-card__btn up-med-card__btn--light">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3" />
                            <circle cx="6" cy="12" r="3" />
                            <circle cx="18" cy="19" r="3" />
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                        </svg>
                        Share
                    </button>
                </div>
            </div>


            <!-- VITALS -->
            <div class="up-card">
                <div class="up-card__head">
                    <div class="up-card__title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                        Latest Vitals
                    </div>
                    <span style="font-size:.7rem;color:var(--muted);font-weight:700">Updated: 20 Feb 2026</span>
                </div>
                <div class="up-vitals">
                    <div class="up-vital up-qstat--teal" style="border-color:#bae6fd">
                        <div class="up-vital__ico">❤️</div>
                        <div class="up-vital__val" style="color:var(--p-dk)">72</div>
                        <div class="up-vital__unit">bpm</div>
                        <div class="up-vital__lbl">Heart Rate</div>
                    </div>
                    <div class="up-vital up-qstat--rose" style="border-color:#fecdd3;background:var(--rose-lt)">
                        <div class="up-vital__ico">🩸</div>
                        <div class="up-vital__val" style="color:var(--rose)">120/80</div>
                        <div class="up-vital__unit">mmHg</div>
                        <div class="up-vital__lbl">Blood Pressure</div>
                    </div>
                    <div class="up-vital up-qstat--mint" style="border-color:#a7f3d0">
                        <div class="up-vital__ico">🌡️</div>
                        <div class="up-vital__val" style="color:#047857">98.4</div>
                        <div class="up-vital__unit">°F</div>
                        <div class="up-vital__lbl">Temperature</div>
                    </div>
                    <div class="up-vital up-qstat--amber" style="border-color:#fde68a">
                        <div class="up-vital__ico">⚖️</div>
                        <div class="up-vital__val" style="color:#b45309">72</div>
                        <div class="up-vital__unit">kg</div>
                        <div class="up-vital__lbl">Weight</div>
                    </div>
                    <div class="up-vital up-qstat--violet" style="border-color:#ddd6fe;background:var(--violet-lt)">
                        <div class="up-vital__ico">🫁</div>
                        <div class="up-vital__val" style="color:var(--violet)">98</div>
                        <div class="up-vital__unit">SpO₂ %</div>
                        <div class="up-vital__lbl">Oxygen</div>
                    </div>
                    <div class="up-vital up-qstat--coral" style="border-color:#fed7aa">
                        <div class="up-vital__ico">🧪</div>
                        <div class="up-vital__val" style="color:#c2410c">92</div>
                        <div class="up-vital__unit">mg/dL</div>
                        <div class="up-vital__lbl">Blood Sugar</div>
                    </div>
                </div>
            </div>


            <!-- TABS CARD -->
            <div class="up-card">

                <div class="up-tabs">
                    <button class="up-tab active" onclick="switchTab('appointments')" id="tab-appointments">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        Appointments
                        <span class="up-tab-count">6</span>
                    </button>
                    <button class="up-tab" onclick="switchTab('history')" id="tab-history">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        Medical History
                        <span class="up-tab-count">5</span>
                    </button>
                    <button class="up-tab" onclick="switchTab('prescriptions')" id="tab-prescriptions">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v11m0 0H5m4 0h4m4 0h2M9 14v7m0 0H5m4 0h4m4-7v7m0 0h-4" />
                        </svg>
                        Prescriptions
                        <span class="up-tab-count">8</span>
                    </button>
                    <button class="up-tab" onclick="switchTab('settings')" id="tab-settings">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                        </svg>
                        Settings
                    </button>
                </div>


                <!-- ── TAB: APPOINTMENTS ── -->
                <div id="content-appointments" class="up-tab-content active">
                    <div class="up-appt-wrap">

                        <div class="up-appt-filters">
                            <button class="up-filter-btn active">All</button>
                            <button class="up-filter-btn">Upcoming</button>
                            <button class="up-filter-btn">Completed</button>
                            <button class="up-filter-btn">Cancelled</button>
                        </div>

                        <table class="up-appt-table">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Date & Time</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="up-appt-doc">
                                            <div class="up-appt-av">PS</div>
                                            <div>
                                                <div class="up-appt-dname">Dr. Priya Sharma</div>
                                                <div class="up-appt-spec">Cardiologist</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>28 Feb 2026<br><span style="color:var(--muted);font-size:.75rem">11:30 AM</span></td>
                                    <td><span style="font-size:.74rem;font-weight:700;color:var(--p)">Online</span></td>
                                    <td><span class="up-status up-status--upcoming"><span class="dot"></span>Upcoming</span></td>
                                    <td><a href="#" class="up-action-btn">Join Call</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="up-appt-doc">
                                            <div class="up-appt-av up-appt-av--mint">AR</div>
                                            <div>
                                                <div class="up-appt-dname">Dr. Arjun Rao</div>
                                                <div class="up-appt-spec">General Physician</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>20 Feb 2026<br><span style="color:var(--muted);font-size:.75rem">10:00 AM</span></td>
                                    <td><span style="font-size:.74rem;font-weight:700;color:var(--mint)">In-person</span></td>
                                    <td><span class="up-status up-status--done"><span class="dot"></span>Completed</span></td>
                                    <td><a href="#" class="up-action-btn">View Report</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="up-appt-doc">
                                            <div class="up-appt-av up-appt-av--coral">NK</div>
                                            <div>
                                                <div class="up-appt-dname">Dr. Neha Khan</div>
                                                <div class="up-appt-spec">Dermatologist</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>14 Feb 2026<br><span style="color:var(--muted);font-size:.75rem">03:00 PM</span></td>
                                    <td><span style="font-size:.74rem;font-weight:700;color:var(--p)">Online</span></td>
                                    <td><span class="up-status up-status--done"><span class="dot"></span>Completed</span></td>
                                    <td><a href="#" class="up-action-btn">View Report</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="up-appt-doc">
                                            <div class="up-appt-av up-appt-av--violet">SM</div>
                                            <div>
                                                <div class="up-appt-dname">Dr. Suresh Mehta</div>
                                                <div class="up-appt-spec">Orthopedic</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>05 Feb 2026<br><span style="color:var(--muted);font-size:.75rem">09:30 AM</span></td>
                                    <td><span style="font-size:.74rem;font-weight:700;color:var(--mint)">In-person</span></td>
                                    <td><span class="up-status up-status--cancelled"><span class="dot"></span>Cancelled</span></td>
                                    <td><a href="#" class="up-action-btn">Rebook</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="up-appt-doc">
                                            <div class="up-appt-av">RG</div>
                                            <div>
                                                <div class="up-appt-dname">Dr. Ritu Gupta</div>
                                                <div class="up-appt-spec">Gynecologist</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>28 Jan 2026<br><span style="color:var(--muted);font-size:.75rem">02:00 PM</span></td>
                                    <td><span style="font-size:.74rem;font-weight:700;color:var(--p)">Online</span></td>
                                    <td><span class="up-status up-status--done"><span class="dot"></span>Completed</span></td>
                                    <td><a href="#" class="up-action-btn">View Report</a></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>


                <!-- ── TAB: MEDICAL HISTORY ── -->
                <div id="content-history" class="up-tab-content">
                    <div class="up-med-history">
                        <div class="up-med-grid">
                            <div class="up-med-item up-med-item--teal">
                                <div class="up-med-item__ico">🫀</div>
                                <div class="up-med-item__title">Cardiac Checkup</div>
                                <div class="up-med-item__date">20 Feb 2026</div>
                                <div class="up-med-item__status" style="color:var(--p)">Normal</div>
                            </div>
                            <div class="up-med-item up-med-item--mint">
                                <div class="up-med-item__ico">🩻</div>
                                <div class="up-med-item__title">X-Ray Chest</div>
                                <div class="up-med-item__date">14 Jan 2026</div>
                                <div class="up-med-item__status" style="color:var(--mint)">Clear</div>
                            </div>
                            <div class="up-med-item up-med-item--amber">
                                <div class="up-med-item__ico">🧬</div>
                                <div class="up-med-item__title">Blood Panel</div>
                                <div class="up-med-item__date">10 Jan 2026</div>
                                <div class="up-med-item__status" style="color:var(--amber)">Review Needed</div>
                            </div>
                            <div class="up-med-item up-med-item--rose">
                                <div class="up-med-item__ico">💉</div>
                                <div class="up-med-item__title">Vaccination</div>
                                <div class="up-med-item__date">05 Dec 2025</div>
                                <div class="up-med-item__status" style="color:var(--rose)">Completed</div>
                            </div>
                            <div class="up-med-item up-med-item--violet">
                                <div class="up-med-item__ico">🧠</div>
                                <div class="up-med-item__title">Neurology Scan</div>
                                <div class="up-med-item__date">18 Nov 2025</div>
                                <div class="up-med-item__status" style="color:var(--violet)">Normal</div>
                            </div>
                            <div class="up-med-item up-med-item--coral">
                                <div class="up-med-item__ico">🫁</div>
                                <div class="up-med-item__title">Pulmonary Test</div>
                                <div class="up-med-item__date">02 Oct 2025</div>
                                <div class="up-med-item__status" style="color:var(--coral)">Good</div>
                            </div>
                        </div>

                        <button class="up-view-btn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            View Complete Medical History
                        </button>
                    </div>
                </div>


                <!-- ── TAB: PRESCRIPTIONS ── -->
                <div id="content-prescriptions" class="up-tab-content">
                    <div class="up-appt-wrap">
                        <div class="up-rx-list">
                            <div class="up-rx-item">
                                <div class="up-rx-ico" style="background:var(--rose-lt)">💊</div>
                                <div>
                                    <div class="up-rx-name">Amlodipine 5mg</div>
                                    <div class="up-rx-dose">1 tablet daily — Morning &bull; Dr. Priya Sharma</div>
                                </div>
                                <span class="up-rx-status up-rx-status--active">Active</span>
                            </div>
                            <div class="up-rx-item">
                                <div class="up-rx-ico" style="background:var(--mint-lt)">🌿</div>
                                <div>
                                    <div class="up-rx-name">Metformin 500mg</div>
                                    <div class="up-rx-dose">2 tablets daily — After meals &bull; Dr. Arjun Rao</div>
                                </div>
                                <span class="up-rx-status up-rx-status--active">Active</span>
                            </div>
                            <div class="up-rx-item">
                                <div class="up-rx-ico" style="background:var(--p-lt)">💉</div>
                                <div>
                                    <div class="up-rx-name">Vitamin D3 60K IU</div>
                                    <div class="up-rx-dose">1 capsule weekly &bull; Dr. Arjun Rao</div>
                                </div>
                                <span class="up-rx-status up-rx-status--active">Active</span>
                            </div>
                            <div class="up-rx-item">
                                <div class="up-rx-ico" style="background:var(--amber-lt)">🔬</div>
                                <div>
                                    <div class="up-rx-name">Pantoprazole 40mg</div>
                                    <div class="up-rx-dose">1 tablet before breakfast &bull; Dr. Neha Khan</div>
                                </div>
                                <span class="up-rx-status up-rx-status--active">Active</span>
                            </div>
                            <div class="up-rx-item" style="opacity:.6">
                                <div class="up-rx-ico" style="background:var(--border)">💊</div>
                                <div>
                                    <div class="up-rx-name">Azithromycin 500mg</div>
                                    <div class="up-rx-dose">3-day course — Completed &bull; Dr. Ritu Gupta</div>
                                </div>
                                <span class="up-rx-status up-rx-status--done">Completed</span>
                            </div>
                            <div class="up-rx-item" style="opacity:.6">
                                <div class="up-rx-ico" style="background:var(--border)">🌿</div>
                                <div>
                                    <div class="up-rx-name">Cetirizine 10mg</div>
                                    <div class="up-rx-dose">As needed for allergy &bull; Dr. Suresh Mehta</div>
                                </div>
                                <span class="up-rx-status up-rx-status--done">Completed</span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ── TAB: SETTINGS ── -->
                <div id="content-settings" class="up-tab-content">
                    <div class="up-settings">
                        <div class="up-setting-row">
                            <div class="up-setting-left">
                                <div class="up-setting-ico" style="background:var(--p-lt);color:var(--p)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 17H2a3 3 0 000 6h20a3 3 0 000-6zM12 11V3m0 0L8 7m4-4l4 4" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="up-setting-name">Email Notifications</div>
                                    <div class="up-setting-desc">Appointment reminders & health tips</div>
                                </div>
                            </div>
                            <div class="up-toggle on" onclick="this.classList.toggle('on')"></div>
                        </div>
                        <div class="up-setting-row">
                            <div class="up-setting-left">
                                <div class="up-setting-ico" style="background:var(--mint-lt);color:var(--mint)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 0111.19 19a19.5 19.5 0 01-5-5A19.79 19.79 0 012.12 5.18 2 2 0 014 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 10.91A16 16 0 0014 16.91l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 18v1h-.08z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="up-setting-name">SMS Alerts</div>
                                    <div class="up-setting-desc">Get SMS for appointment updates</div>
                                </div>
                            </div>
                            <div class="up-toggle on" onclick="this.classList.toggle('on')"></div>
                        </div>
                        <div class="up-setting-row">
                            <div class="up-setting-left">
                                <div class="up-setting-ico" style="background:var(--amber-lt);color:var(--amber)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="up-setting-name">Push Notifications</div>
                                    <div class="up-setting-desc">Browser & app notifications</div>
                                </div>
                            </div>
                            <div class="up-toggle" onclick="this.classList.toggle('on')"></div>
                        </div>
                        <div class="up-setting-row">
                            <div class="up-setting-left">
                                <div class="up-setting-ico" style="background:var(--violet-lt);color:var(--violet)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0110 0v4" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="up-setting-name">Two-Factor Auth</div>
                                    <div class="up-setting-desc">Extra security for your account</div>
                                </div>
                            </div>
                            <div class="up-toggle on" onclick="this.classList.toggle('on')"></div>
                        </div>
                        <div class="up-setting-row">
                            <div class="up-setting-left">
                                <div class="up-setting-ico" style="background:var(--coral-lt);color:var(--coral)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="up-setting-name">Profile Visibility</div>
                                    <div class="up-setting-desc">Make profile visible to doctors</div>
                                </div>
                            </div>
                            <div class="up-toggle on" onclick="this.classList.toggle('on')"></div>
                        </div>
                        <div class="up-setting-row">
                            <div class="up-setting-left">
                                <div class="up-setting-ico" style="background:var(--rose-lt);color:var(--rose)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14H6L5 6m5 0V4h4v2" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="up-setting-name">Delete Account</div>
                                    <div class="up-setting-desc">Permanently remove your data</div>
                                </div>
                            </div>
                            <button style="padding:7px 16px;border-radius:100px;background:var(--rose-lt);color:var(--rose);border:none;font-size:.74rem;font-weight:800;cursor:pointer;">Delete</button>
                        </div>
                    </div>
                </div>

            </div><!-- end tabs card -->

        </div><!-- end main -->

    </div><!-- end layout -->
</div><!-- end wrap -->


<!-- ════════════════════════════════
     PROFILE EDIT MODAL
════════════════════════════════ -->
<div class="up-modal-overlay" id="profileModal" onclick="handleOverlayClick(event)">
    <div class="up-modal">
        <div class="up-modal__head">
            <div class="up-modal__title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Edit Profile
            </div>
            <button class="up-modal__close" onclick="closeModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form action="{{ route('user.profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data" class="up-modal__body">
            @csrf

            <!-- Avatar Upload -->
            <div class="up-av-upload">
                <div class="up-av-upload__prev">
                    @if(Auth::user()->image)
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->user_name }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    @else
                    {{ strtoupper(substr(Auth::user()->user_name, 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->user_name, ' '), 1, 1)) }}
                    @endif
                </div>
                <div class="up-av-upload__txt" style="cursor: pointer;">
                    <input type="file" name="image" accept="image/png, image/jpeg" style="display:none;" id="avInput">
                    <strong>Change Profile Photo</strong>
                    <label for="avInput">Click to upload JPG or PNG (max 2MB)</label>
                </div>
            </div>

            <div class="up-section-title">Personal Information</div>
            <div class="up-form-row up-form-row--single">
                <div class="up-field">
                    <label>Full Name</label>
                    <input type="text" value="{{ Auth::user()->user_name }}" name="user_name" placeholder="Full name">
                </div>
            </div>
            <div class="up-form-row">
                <div class="up-field">
                    <label>Email Address</label>
                    <input type="email" value="{{ Auth::user()->user_email }}" name="user_email" placeholder="Email">
                </div>
                <div class="up-field">
                    <label>Phone Number</label>
                    <input type="tel" value="{{ Auth::user()->user_mobile }}" name="user_mobile" placeholder="Phone">
                </div>
            </div>
            <div class="up-form-row">
                <div class="up-field">
                    <label>Date of Birth</label>
                    <input type="date" value="{{ Auth::user()->dob }}" name="dob">
                </div>
                <div class="up-field">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="" {{ !Auth::user()->gender ? 'selected' : '' }}>Choose Gender</option>
                        <option value="Male" {{ Auth::user()->gender == 'Male'   ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ Auth::user()->gender == 'Other'  ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
            <div class="up-form-row up-form-row--single">
                <div class="up-field">
                    <label>Address</label>
                    <input type="text" value="{{ Auth::user()->address }}" name="address" placeholder="Full address">
                </div>
            </div>

            <div class="up-section-title">Medical Information</div>
            <div class="up-form-row">
                <div class="up-field">
                    <label>Blood Group</label>
                    <select name="blood_group">
                        <option value="" {{ !Auth::user()->blood_group ? 'selected' : '' }}>Choose</option>
                        <option value="A+" {{ Auth::user()->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ Auth::user()->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ Auth::user()->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ Auth::user()->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="O+" {{ Auth::user()->blood_group == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ Auth::user()->blood_group == 'O-' ? 'selected' : '' }}>O-</option>
                        <option value="AB+" {{ Auth::user()->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ Auth::user()->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                    </select>
                </div>
                <div class="up-field">
                    <label>Height (cm)</label>
                    <input type="number" value="{{ Auth::user()->height }}" name="height" placeholder="Height in cm">
                </div>
            </div>
            <div class="up-form-row">
                <div class="up-field">
                    <label>Weight (kg)</label>
                    <input type="number" value="{{ Auth::user()->weight }}" name="weight" placeholder="Weight in kg">
                </div>
                <div class="up-field">
                    <label>Emergency Contact</label>
                    <input type="tel" value="{{ Auth::user()->emergency_contact }}" name="emergency_contact" placeholder="Emergency phone">
                </div>
            </div>
            <div class="up-form-row up-form-row--single">
                <div class="up-field">
                    <label>Known Allergies</label>
                    <textarea name="allergies" placeholder="List any known allergies...">{{ Auth::user()->allergies }}</textarea>
                </div>
            </div>
            <div class="up-form-row up-form-row--single">
                <div class="up-field">
                    <label>Chronic Conditions</label>
                    <textarea name="chronic_conditions" placeholder="Any chronic health conditions...">{{ Auth::user()->chronic_conditions }}</textarea>
                </div>
            </div>

            <div class="up-modal__foot">
                <button class="up-btn-cancel" onclick="closeModal()">Cancel</button>
                <button class="up-btn-save" type="submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Save Changes
                </button>
            </div>

        </form>
    </div>
</div>


<script>
    // Modal
    function openModal() {
        document.getElementById('profileModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('profileModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function handleOverlayClick(e) {
        if (e.target === document.getElementById('profileModal')) closeModal();
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });

    // Tabs
    function switchTab(name) {
        document.querySelectorAll('.up-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.up-tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById('tab-' + name).classList.add('active');
        document.getElementById('content-' + name).classList.add('active');
    }

    // Filter buttons (demo)
    document.querySelectorAll('.up-appt-filters .up-filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.up-appt-filters .up-filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
</script>

@endsection