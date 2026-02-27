@extends('frontend.layout.app')

@section('title', 'My Profile & Medical history - Doctorwala.info')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('./css/user-profile.css') }}">
    <style>
        .up-appt-table-wrap {
            overflow-x: auto;
        }

        /* Filter count badges */
        .up-filter-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 20px;
            background: rgba(13, 141, 227, .12);
            color: var(--p, #0d8de3);
            font-size: .68rem;
            font-weight: 800;
            margin-left: 5px;
            line-height: 1;
        }

        .up-filter-btn.active .up-filter-count {
            background: rgba(255, 255, 255, .25);
            color: #fff;
        }

        /* Row index # */
        .up-appt-num {
            font-size: .78rem;
            font-weight: 700;
            color: var(--muted, #94a3b8);
            width: 32px;
        }

        /* Time */
        .up-appt-time {
            color: var(--muted, #94a3b8);
            font-size: .75rem;
        }

        /* Service type chips */
        .up-appt-type {
            font-size: .72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .type--doctor {
            color: #0d8de3;
            background: rgba(13, 141, 227, .08);
        }

        .type--opd {
            color: #06c4ae;
            background: rgba(6, 196, 174, .08);
        }

        .type--path {
            color: #8b5cf6;
            background: rgba(139, 92, 246, .08);
        }

        /* Mode */
        .mode--online {
            color: var(--p, #0d8de3);
            font-weight: 700;
        }

        .mode--inperson {
            color: var(--mint, #06c4ae);
            font-weight: 700;
        }

        /* Action buttons in table */
        .up-appt-actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .up-action-btn--complete,
        .up-action-btn--cancel {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: .73rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all .18s ease;
            font-family: inherit;
            line-height: 1.4;
            white-space: nowrap;
        }

        .up-action-btn--complete {
            background: rgba(16, 185, 129, .1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, .2);
        }

        .up-action-btn--complete:hover {
            background: rgba(16, 185, 129, .18);
            transform: translateY(-1px);
        }

        .up-action-btn--cancel {
            background: rgba(244, 63, 94, .08);
            color: #e11d48;
            border: 1px solid rgba(244, 63, 94, .18);
        }

        .up-action-btn--cancel:hover {
            background: rgba(244, 63, 94, .15);
            transform: translateY(-1px);
        }

        .up-action-done {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .73rem;
            font-weight: 700;
            color: #10b981;
            opacity: .7;
        }

        .up-action-na {
            color: var(--muted, #94a3b8);
            font-size: .8rem;
        }

        /* Empty state */
        .up-appt-empty {
            text-align: center;
            padding: 52px 20px;
            color: var(--muted, #94a3b8);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .up-appt-empty p {
            font-size: .9rem;
            font-weight: 500;
        }

        /* Hidden row (filtered out) */
        .appt-row.is-hidden {
            display: none;
        }

        marquee {
            display: none !important;
        }

        .complete-modal-overlay,
        .cancel-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(10, 18, 35, 0.55);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            opacity: 0;
            visibility: hidden;
            transition: opacity .25s ease, visibility .25s ease;
        }

        .complete-modal-overlay.is-open,
        .cancel-modal-overlay.is-open {
            opacity: 1;
            visibility: visible;
        }

        .complete-modal-overlay.is-open .complete-modal-box,
        .cancel-modal-overlay.is-open .cancel-modal-box {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        /* ════════════════════════════════
   COMPLETE MODAL
════════════════════════════════ */
        .complete-modal-box {
            background: #fff;
            border-radius: 22px;
            padding: 36px 32px 30px;
            width: 100%;
            max-width: 420px;
            box-shadow:
                0 24px 60px rgba(13, 141, 100, .15),
                0 4px 20px rgba(0, 0, 0, .12),
                0 0 0 1px rgba(16, 185, 129, .12);
            transform: translateY(28px) scale(.96);
            opacity: 0;
            transition: transform .32s cubic-bezier(.34, 1.4, .64, 1), opacity .28s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .complete-modal-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #06c4ae);
            border-radius: 22px 22px 0 0;
        }

        /* Icon */
        .complete-modal-icon-wrap {
            position: relative;
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .complete-modal-icon-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid rgba(16, 185, 129, .25);
            animation: completeRingPulse 2.4s ease-out infinite;
        }

        .complete-modal-icon-ring--2 {
            animation-delay: 1.2s;
        }

        @keyframes completeRingPulse {
            0% {
                transform: scale(.7);
                opacity: .8;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .complete-modal-icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #06c4ae);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 8px 24px rgba(16, 185, 129, .35);
            position: relative;
            z-index: 1;
            animation: completeIconBounce .5s cubic-bezier(.34, 1.56, .64, 1) both;
            animation-delay: .1s;
        }

        @keyframes completeIconBounce {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        /* Text */
        .complete-modal-title {
            font-family: 'Outfit', 'DM Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f2415;
            margin-bottom: 8px;
            letter-spacing: -.02em;
        }

        .complete-modal-desc {
            font-size: .875rem;
            color: #5a7165;
            line-height: 1.55;
            margin-bottom: 18px;
        }

        .complete-modal-desc strong {
            color: #10b981;
        }

        /* Appt preview badge */
        .complete-modal-appt-preview {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(16, 185, 129, .08);
            border: 1.5px solid rgba(16, 185, 129, .2);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: .82rem;
            font-weight: 600;
            color: #059669;
            margin-bottom: 24px;
        }

        .complete-modal-appt-preview i {
            font-size: .8rem;
        }

        /* Actions */
        .complete-modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .complete-modal-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 16px;
            border-radius: 11px;
            font-family: 'Outfit', 'DM Sans', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all .2s ease;
            letter-spacing: .02em;
        }

        .complete-modal-btn--cancel {
            background: #f1f5f2;
            color: #4a6657;
            border: 1.5px solid #d1e8dc;
        }

        .complete-modal-btn--cancel:hover {
            background: #e2ede7;
            border-color: #b8d9c5;
        }

        .complete-modal-btn--confirm {
            background: linear-gradient(120deg, #10b981, #06c4ae);
            color: #fff;
            box-shadow: 0 4px 16px rgba(16, 185, 129, .3);
        }

        .complete-modal-btn--confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(16, 185, 129, .4);
        }

        .complete-modal-btn--confirm:active {
            transform: translateY(0);
        }


        /* ════════════════════════════════
   CANCEL MODAL
════════════════════════════════ */
        .cancel-modal-box {
            background: #fff;
            border-radius: 22px;
            padding: 36px 32px 30px;
            width: 100%;
            max-width: 440px;
            box-shadow:
                0 24px 60px rgba(220, 38, 38, .12),
                0 4px 20px rgba(0, 0, 0, .12),
                0 0 0 1px rgba(244, 63, 94, .1);
            transform: translateY(28px) scale(.96);
            opacity: 0;
            transition: transform .32s cubic-bezier(.34, 1.4, .64, 1), opacity .28s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .cancel-modal-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f43f5e, #ef4444);
            border-radius: 22px 22px 0 0;
        }

        /* Icon */
        .cancel-modal-icon-wrap {
            position: relative;
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cancel-modal-icon-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid rgba(244, 63, 94, .25);
            animation: cancelRingPulse 2.4s ease-out infinite;
        }

        .cancel-modal-icon-ring--2 {
            animation-delay: 1.2s;
        }

        @keyframes cancelRingPulse {
            0% {
                transform: scale(.7);
                opacity: .8;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .cancel-modal-icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f43f5e, #ef4444);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 8px 24px rgba(244, 63, 94, .35);
            position: relative;
            z-index: 1;
            animation: cancelIconBounce .5s cubic-bezier(.34, 1.56, .64, 1) both;
            animation-delay: .1s;
        }

        @keyframes cancelIconBounce {
            from {
                transform: scale(0) rotate(-20deg);
            }

            to {
                transform: scale(1) rotate(0deg);
            }
        }

        /* Text */
        .cancel-modal-title {
            font-family: 'Outfit', 'DM Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: #1f0a0e;
            margin-bottom: 8px;
            letter-spacing: -.02em;
        }

        .cancel-modal-desc {
            font-size: .875rem;
            color: #7a5560;
            line-height: 1.55;
            margin-bottom: 18px;
        }

        .cancel-modal-desc strong {
            color: #f43f5e;
        }

        /* Appt preview badge */
        .cancel-modal-appt-preview {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(244, 63, 94, .07);
            border: 1.5px solid rgba(244, 63, 94, .18);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: .82rem;
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 20px;
        }

        .cancel-modal-appt-preview i {
            font-size: .8rem;
        }

        /* Reason textarea */
        .cancel-modal-reason-wrap {
            text-align: left;
            margin-bottom: 20px;
        }

        .cancel-modal-reason-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .76rem;
            font-weight: 700;
            color: #7a5560;
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 6px;
        }

        .cancel-modal-reason-label i {
            color: #f43f5e;
            font-size: .7rem;
        }

        .cancel-modal-reason-label span {
            color: #b0adb0;
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
        }

        .cancel-modal-reason-input {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #fecdd3;
            border-radius: 10px;
            background: #fff5f7;
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            color: #1f0a0e;
            resize: vertical;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
            min-height: 76px;
        }

        .cancel-modal-reason-input::placeholder {
            color: #d4a0ab;
        }

        .cancel-modal-reason-input:focus {
            border-color: #f43f5e;
            background: #fff;
            box-shadow: 0 0 0 3.5px rgba(244, 63, 94, .1);
        }

        /* Actions */
        .cancel-modal-actions {
            display: flex;
            gap: 10px;
        }

        .cancel-modal-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 16px;
            border-radius: 11px;
            font-family: 'Outfit', 'DM Sans', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all .2s ease;
            letter-spacing: .02em;
        }

        .cancel-modal-btn--keep {
            background: #f9f1f2;
            color: #7a5560;
            border: 1.5px solid #f5d0d6;
        }

        .cancel-modal-btn--keep:hover {
            background: #f5e6e8;
            border-color: #f0bdc5;
        }

        .cancel-modal-btn--confirm {
            background: linear-gradient(120deg, #f43f5e, #ef4444);
            color: #fff;
            box-shadow: 0 4px 16px rgba(244, 63, 94, .3);
        }

        .cancel-modal-btn--confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(244, 63, 94, .42);
        }

        .cancel-modal-btn--confirm:active {
            transform: translateY(0);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {

            .complete-modal-box,
            .cancel-modal-box {
                padding: 28px 20px 24px;
                border-radius: 18px;
            }

            .complete-modal-actions,
            .cancel-modal-actions {
                flex-direction: column-reverse;
            }
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
            @if($latestSingleBooking)
            <div class="up-next-appt">
                <div class="up-next-appt__ico">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                </div>
                <div class="up-next-appt__info">
                    <div class="up-next-appt__label">Upcoming Appointment</div>

                    @if ($latestSingleBooking->clinic_type === 'OPD' && $latestSingleBooking->doctor)
                    <div class="up-next-appt__title">{{$latestSingleBooking->doctor->doctor_name}}</div>
                    <div class="up-next-appt__title" style="color: yellow;">{{$latestSingleBooking->doctor->doctor_specialist}} | {{$latestSingleBooking->opdContact->clinic_name}}</div>
                    <small class="up-next-appt__sub">{{$latestSingleBooking->doctor->doctor_more}}</small>
                    <br>
                    <small class="up-next-appt__sub">{{$latestSingleBooking->opdContact->clinic_city}}, {{$latestSingleBooking->opdContact->clinic_state}}, {{$latestSingleBooking->opdContact->clinic_pincode}}</small>

                    @elseif ($latestSingleBooking->clinic_type === 'Pathology' && $latestSingleBooking->test)
                    <div class="up-next-appt__title">{{$latestSingleBooking->test->test_name}}</div>
                    <div class="up-next-appt__title" style="color: yellow;">{{$latestSingleBooking->test->test_type}} | {{$latestSingleBooking->pathologyContact->clinic_name}}</div>
                    <small class="up-next-appt__sub"><svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            style="display:inline;vertical-align:middle">

                            <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>

                        </svg>
                        {{$latestSingleBooking->pathologyContact->clinic_city}}, {{$latestSingleBooking->pathologyContact->clinic_state}}, {{$latestSingleBooking->pathologyContact->clinic_pincode}}
                    </small>


                    @elseif ($latestSingleBooking->clinic_type === 'Doctor' && $latestSingleBooking->doctorContact)
                    <div class="up-next-appt__title">{{$latestSingleBooking->doctorContact->partner_doctor_name}}</div>
                    <div class="up-next-appt__title" style="color: yellow;">{{$latestSingleBooking->doctorContact->partner_doctor_specialist}}</div>
                    <small class="up-next-appt__sub"><svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            style="display:inline;vertical-align:middle">

                            <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>

                        </svg>
                        {{$latestSingleBooking->doctorContact->partner_doctor_city}}, {{$latestSingleBooking->doctorContact->partner_doctor_state}}, {{$latestSingleBooking->doctorContact->partner_doctor_pincode}}
                    </small>
                    @endif

                    <div class="up-next-appt__sub">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        {{ \Carbon\Carbon::parse($latestSingleBooking->booking_date)->isTomorrow() 
    ? 'Tomorrow, ' . \Carbon\Carbon::parse($latestSingleBooking->booking_date)->format('d M Y')
    : \Carbon\Carbon::parse($latestSingleBooking->booking_date)->format('l, d M Y') }} &bull; {{ \Carbon\Carbon::parse($latestSingleBooking->booking_time)->format('h:i A') }} &bull; <span style="text-transform: capitalize;">{{ $latestSingleBooking->visit_mode }}</span> Consultation
                    </div>
                </div>

                <!-- Action -->
                @if ($latestSingleBooking->clinic_type === 'OPD' && $latestSingleBooking->doctor)
                <a href="{{ $latestSingleBooking->opdContact->clinic_google_map_link }}" target="_blank" class="up-next-appt__action" style="color: #1B9AAA;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        style="display:inline;vertical-align:middle">

                        <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>

                    </svg>
                    MAP
                </a>
                @elseif ($latestSingleBooking->clinic_type === 'Pathology' && $latestSingleBooking->test)
                <a href="{{ $latestSingleBooking->pathologyContact->clinic_google_map_link }}" target="_blank" class="up-next-appt__action" style="color: #1B9AAA;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        style="display:inline;vertical-align:middle">

                        <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>

                    </svg>
                    MAP
                </a>
                @elseif ($latestSingleBooking->clinic_type === 'Doctor' && $latestSingleBooking->doctorContact)
                <a href="{{ $latestSingleBooking->doctorContact->partner_doctor_google_map_link }}" target="_blank" class="up-next-appt__action" style="color: #1B9AAA;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2"
                        style="display:inline;vertical-align:middle">

                        <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>

                    </svg>
                    MAP
                </a>
                @endif

                @if ($latestSingleBooking->status === 'Upcoming')

                <button
                    type="button"
                    class="up-next-appt__action"
                    onclick="openCompleteModal({{ $latestSingleBooking->id }})">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                    Complete
                </button>

                <button
                    type="button"
                    class="up-next-appt__action"
                    style="color: red;"
                    onclick="openCancelModal({{ $latestSingleBooking->id }})">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="5" y1="5" x2="19" y2="19"></line>
                    </svg>
                    Cancel
                </button>

                @endif


            </div>
            @endif


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
                            <img src="{{ asset('./img/fav5.png') }}" alt="Doctorwala">
                        </div>
                        <div>
                            <div class="up-med-card__brand">
                                Doctorwala
                                <span>MEDICAL CARD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="up-med-card__mid">
                    <div class="up-med-card__number">
                        {{ Auth::user()->medical_card_no ?? 'DW** **** ***' }}
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
                        <span class="up-tab-count">{{ $bookings->count() }}</span>
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


                {{-- ── TAB: APPOINTMENTS ── --}}
                <div id="content-appointments" class="up-tab-content active">
                    <div class="up-appt-wrap">

                        <div class="up-appt-filters">
                            <button class="up-filter-btn active" onclick="filterAppts(this, 'all')">
                                All <span class="up-filter-count" id="count-all">{{ $bookings->count() }}</span>
                            </button>
                            <button class="up-filter-btn" onclick="filterAppts(this, 'Upcoming')">
                                Upcoming <span class="up-filter-count" id="count-upcoming">{{ $bookings->where('status', 'Upcoming')->count() }}</span>
                            </button>
                            <button class="up-filter-btn" onclick="filterAppts(this, 'Completed')">
                                Completed <span class="up-filter-count" id="count-completed">{{ $bookings->where('status', 'Completed')->count() }}</span>
                            </button>
                            <button class="up-filter-btn" onclick="filterAppts(this, 'Cancelled')">
                                Cancelled <span class="up-filter-count" id="count-cancelled">{{ $bookings->where('status', 'Cancelled')->count() }}</span>
                            </button>
                        </div>

                        @if($bookings->isEmpty())
                        <div class="up-appt-empty">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity=".3">
                                <rect x="3" y="4" width="18" height="18" rx="3" />
                                <path d="M16 2v4M8 2v4M3 10h18" />
                            </svg>
                            <p>No appointments found</p>
                        </div>
                        @else
                        <div class="up-appt-table-wrap">
                            <table class="up-appt-table">
                                <thead>
                                    <tr>
                                        <th>OPD / Test / Doctor</th>
                                        <th>Date &amp; Time</th>
                                        <th>Visit</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody id="apptTableBody">

                                    @foreach($bookings as $index => $booking)
                                    @php
                                    $status = $booking->status ?? 'Upcoming';
                                    $statusMap = [
                                    'Upcoming' => ['class' => 'up-status--upcoming', 'label' => 'Upcoming'],
                                    'Completed' => ['class' => 'up-status--done', 'label' => 'Completed'],
                                    'Cancelled' => ['class' => 'up-status--cancelled','label' => 'Cancelled'],
                                    ];
                                    $statusInfo = $statusMap[$status] ?? ['class' => 'up-status--upcoming', 'label' => $status];
                                    @endphp

                                    <tr class="appt-row" data-status="{{ $status }}">


                                        <td>
                                            @if ($booking->clinic_type === 'OPD' && $booking->doctor)
                                            <div class="up-appt-doc">
                                                <div class="up-appt-av">{{ strtoupper(substr($booking->doctor->doctor_name, 0, 1)) }}{{ strtoupper(substr(strstr($booking->doctor->doctor_name, ' '), 1, 1)) }}</div>
                                                <div>
                                                    <div class="up-appt-dname">Dr. {{ $booking->doctor->doctor_name }}</div>
                                                    <div class="up-appt-dname" style="color: red;">{{ $booking->doctor->doctor_specialist }}</div>
                                                    <div class="up-appt-subname" style="color: #5E807F;">{{ $booking->opdContact->clinic_name }}</div>
                                                </div>
                                            </div>

                                            @elseif ($booking->clinic_type === 'Pathology' && $booking->test)
                                            <div class="up-appt-doc">
                                                <div class="up-appt-av">{{ strtoupper(substr($booking->test->test_name, 0, 1)) }}{{ strtoupper(substr(strstr($booking->test->test_name, ' '), 1, 1)) }}</div>
                                                <div>
                                                    <div class="up-appt-dname">{{ $booking->test->test_name }}</div>
                                                    <div class="up-appt-dname" style="color: green;">{{ $booking->test->test_type }}</div>
                                                    <div class="up-appt-subname" style="color: #5E807F;">{{ $booking->pathologyContact->clinic_name }}</div>
                                                </div>
                                            </div>

                                            @elseif ($booking->clinic_type === 'Doctor' && $booking->doctorContact)
                                            <div class="up-appt-doc">
                                                <div class="up-appt-av">{{ strtoupper(substr($booking->doctorContact->partner_doctor_name, 0, 1)) }}{{ strtoupper(substr(strstr($booking->doctorContact->partner_doctor_name, ' '), 1, 1)) }}</div>
                                                <div>
                                                    <div class="up-appt-dname">Dr. {{ $booking->doctorContact->partner_doctor_name }}</div>
                                                    <div class="up-appt-dname" style="color: #1B9AAA;">{{ $booking->doctorContact->partner_doctor_specialist }}</div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>


                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br><span style="color:var(--muted);font-size:.75rem">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span></td>


                                        <td><span style="font-size:.74rem;font-weight:700;color:var(--p); text-transform:capitalize">{{ $booking->visit_mode }}</span></td>


                                        <td>
                                            <span class="up-status {{ $statusInfo['class'] }}">
                                                <span class="dot"></span>{{ $statusInfo['label'] }}
                                            </span>
                                        </td>


                                        <td>
                                            @if ($booking->clinic_type === 'OPD' && $booking->doctor)
                                            <a href="{{$booking->opdContact->clinic_google_map_link}}" target="_blank" class="up-action-done">
                                                Map Link
                                            </a>
                                            @elseif ($booking->clinic_type === 'Pathology' && $booking->test)
                                            <a href="{{$booking->pathologyContact->clinic_google_map_link}}" target="_blank" class="up-action-done">
                                                Map Link
                                            </a>
                                            @elseif ($booking->clinic_type === 'Doctor' && $booking->doctorContact)
                                            <a href="{{$booking->doctorContact->partner_doctor_google_map_link}}" target="_blank" class="up-action-done">
                                                Map Link
                                            </a>
                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @endif

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




<!-- {{-- ============================================================
     COMPLETE MODAL
============================================================ --}} -->
<div class="complete-modal-overlay" id="completeModalOverlay" role="dialog" aria-modal="true" aria-labelledby="completeModalTitle">
    <div class="complete-modal-box">

        <div class="complete-modal-icon-wrap">
            <div class="complete-modal-icon-ring"></div>
            <div class="complete-modal-icon-ring complete-modal-icon-ring--2"></div>
            <div class="complete-modal-icon-circle">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M20 6L9 17l-5-5" />
                </svg>
            </div>
        </div>

        <h2 class="complete-modal-title" id="completeModalTitle">Mark as Completed?</h2>
        <p class="complete-modal-desc">
            This will mark the appointment as <strong>Completed</strong>. This action cannot be undone.
        </p>

        <div class="complete-modal-appt-preview">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Appointment #<strong id="completeApptId">—</strong></span>
        </div>

        <form
            action=""
            method="POST"
            id="completeForm"
            novalidate>
            @csrf
            <input type="hidden" name="status" value="Completed">

            <div class="complete-modal-actions">
                <button type="button" class="complete-modal-btn complete-modal-btn--cancel" onclick="closeCompleteModal()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                    Cancel
                </button>
                <button type="submit" class="complete-modal-btn complete-modal-btn--confirm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                    Yes, Complete It
                </button>
            </div>
        </form>

    </div>
</div>


<!-- {{-- ============================================================
     CANCEL MODAL
============================================================ --}} -->
<div class="cancel-modal-overlay" id="cancelModalOverlay" role="dialog" aria-modal="true" aria-labelledby="cancelModalTitle">
    <div class="cancel-modal-box">

        <div class="cancel-modal-icon-wrap">
            <div class="cancel-modal-icon-ring"></div>
            <div class="cancel-modal-icon-ring cancel-modal-icon-ring--2"></div>
            <div class="cancel-modal-icon-circle">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="5" y1="5" x2="19" y2="19"></line>
                </svg>
            </div>
        </div>

        <h2 class="cancel-modal-title" id="cancelModalTitle">Cancel Appointment?</h2>
        <p class="cancel-modal-desc">
            This will mark the appointment as <strong>Cancelled</strong>. The patient will be notified. This action cannot be undone.
        </p>

        <div class="cancel-modal-appt-preview">
            <i class="fa-solid fa-calendar-xmark"></i>
            <span>Appointment #<strong id="cancelApptId">—</strong></span>
        </div>

        <form
            action=""
            method="POST"
            id="cancelForm"
            novalidate>
            @csrf
            <input type="hidden" name="status" value="Cancelled">

            <div class="cancel-modal-actions">
                <button type="button" class="cancel-modal-btn cancel-modal-btn--keep" onclick="closeCancelModal()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                    Cancel
                </button>
                <button type="submit" class="cancel-modal-btn cancel-modal-btn--confirm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="5" y1="5" x2="19" y2="19"></line>
                    </svg>
                    Yes, Cancel It
                </button>
            </div>
        </form>

    </div>
</div>



<script>
    /* ── Modal ── */
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

    /* ── Tabs ── */
    function switchTab(name) {
        document.querySelectorAll('.up-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.up-tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById('tab-' + name).classList.add('active');
        document.getElementById('content-' + name).classList.add('active');
    }

    /* ── Filter appointments by status ── */
    function filterAppts(clickedBtn, filter) {
        // Update active button
        document.querySelectorAll('.up-appt-filters .up-filter-btn').forEach(b => b.classList.remove('active'));
        clickedBtn.classList.add('active');

        // Show/hide rows
        document.querySelectorAll('#apptTableBody .appt-row').forEach(row => {
            if (filter === 'all') {
                row.classList.remove('is-hidden');
            } else {
                const rowStatus = row.getAttribute('data-status');
                row.classList.toggle('is-hidden', rowStatus !== filter);
            }
        });

        // Show empty state if no visible rows
        const visibleRows = document.querySelectorAll('#apptTableBody .appt-row:not(.is-hidden)');
        const emptyEl = document.querySelector('.up-appt-empty');
        const tableWrap = document.querySelector('.up-appt-table-wrap');

        if (emptyEl && tableWrap) {
            if (visibleRows.length === 0) {
                tableWrap.style.display = 'none';
                emptyEl.style.display = 'flex';
                emptyEl.querySelector('p').textContent = 'No ' + (filter === 'all' ? '' : filter.toLowerCase() + ' ') + 'appointments found';
            } else {
                tableWrap.style.display = '';
                emptyEl.style.display = 'none';
            }
        }
    }
</script>


<script>
    /* ── COMPLETE MODAL ── */
    function openCompleteModal(bookingId) {
        document.getElementById('completeForm').action = '/dw/profile/appointment-complete/' + bookingId;
        document.getElementById('completeApptId').textContent = bookingId;
        document.getElementById('completeModalOverlay').classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeCompleteModal() {
        document.getElementById('completeModalOverlay').classList.remove('is-open');
        document.body.style.overflow = '';
    }

    /* ── CANCEL MODAL ── */
    function openCancelModal(bookingId) {
        document.getElementById('cancelForm').action = '/dw/profile/appointment-cancel/' + bookingId;
        document.getElementById('cancelApptId').textContent = bookingId;
        document.getElementById('cancelModalOverlay').classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeCancelModal() {
        document.getElementById('cancelModalOverlay').classList.remove('is-open');
        document.getElementById('cancelReason').value = '';
        document.body.style.overflow = '';
    }

    /* ── CLOSE ON BACKDROP CLICK ── */
    document.getElementById('completeModalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeCompleteModal();
    });
    document.getElementById('cancelModalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeCancelModal();
    });

    /* ── CLOSE ON ESCAPE KEY ── */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCompleteModal();
            closeCancelModal();
        }
    });
</script>


@endsection