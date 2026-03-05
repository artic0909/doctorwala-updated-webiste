<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$patient->user_name}} - Patient Profile |Partner Panel</title>

    <link href="{{asset('fav5.png')}}" rel="icon">

    <link rel="stylesheet" href="{{ asset('./css/user-profile.css') }}">
    <style>
        /* ─── PARTNER-PANEL BADGE ─── */
        .pp-partner-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            background: linear-gradient(135deg, #4361ee22, #7c3aed22);
            border: 1.5px solid #c4b5fd;
            color: #7c3aed;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .pp-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 10px;
            background: #f1f5f9;
            border: 1.5px solid #e2e8f0;
            color: #475569;
            font-size: .8rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .18s ease;
            margin-bottom: 16px;
        }

        .pp-back-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
            transform: translateX(-2px);
        }

        /* ─── READ-ONLY OVERLAY ─── */
        .pp-readonly-banner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 10px;
            background: linear-gradient(135deg, #fefce8, #fffbeb);
            border: 1.5px solid #fde68a;
            color: #92400e;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        /* appointment modal styles (reuse from user-profile) */
        .up-pwd-alert {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 11px 15px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .up-pwd-alert--success {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .up-pwd-alert--error {
            background: #fff1f1;
            color: #e53e3e;
            border: 1px solid #fecaca;
        }

        .up-appt-table-wrap {
            overflow-x: auto;
        }

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

        .up-appt-time {
            color: var(--muted, #94a3b8);
            font-size: .75rem;
        }

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

        .mode--online {
            color: var(--p, #0d8de3);
            font-weight: 700;
        }

        .mode--inperson {
            color: var(--mint, #06c4ae);
            font-weight: 700;
        }

        .up-appt-actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
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

        .appt-row.is-hidden {
            display: none;
        }

        marquee {
            display: none !important;
        }

        /* ─── COMPLETE MODAL ─── */
        .complete-modal-overlay,
        .cancel-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(10, 18, 35, .55);
            backdrop-filter: blur(6px);
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

        .complete-modal-box {
            background: #fff;
            border-radius: 22px;
            padding: 36px 32px 30px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 60px rgba(13, 141, 100, .15), 0 4px 20px rgba(0, 0, 0, .12), 0 0 0 1px rgba(16, 185, 129, .12);
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

        .complete-modal-title {
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
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all .2s ease;
        }

        .complete-modal-btn--cancel {
            background: #f1f5f2;
            color: #4a6657;
            border: 1.5px solid #d1e8dc;
        }

        .complete-modal-btn--cancel:hover {
            background: #e2ede7;
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

        /* ─── CANCEL MODAL ─── */
        .cancel-modal-box {
            background: #fff;
            border-radius: 22px;
            padding: 36px 32px 30px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 24px 60px rgba(220, 38, 38, .12), 0 4px 20px rgba(0, 0, 0, .12), 0 0 0 1px rgba(244, 63, 94, .1);
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

        .cancel-modal-title {
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
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all .2s ease;
        }

        .cancel-modal-btn--keep {
            background: #f9f1f2;
            color: #7a5560;
            border: 1.5px solid #f5d0d6;
        }

        .cancel-modal-btn--keep:hover {
            background: #f5e6e8;
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

        /* ─── PARTNER HERO OVERRIDE — purple accent ─── */
        .up-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e40af 100%);
        }

        .up-hero__name {
            color: #fff;
        }

        .up-hero__email {
            color: rgba(255, 255, 255, .7);
        }

        .up-hero__badge {
            background: rgba(255, 255, 255, .15);
            color: rgba(255, 255, 255, .9);
            border-color: rgba(255, 255, 255, .25);
        }

        .pp-stat-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 18px;
        }

        .pp-stat-card__ico {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .pp-stat-card__num {
            font-size: 1.35rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        .pp-stat-card__lbl {
            font-size: .72rem;
            color: #94a3b8;
            font-weight: 600;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    {{-- ══════════════════════════════════
     HERO BANNER
══════════════════════════════════ --}}
    <div class="up-hero" style="background: linear-gradient(135deg,#1e1b4b 0%,#312e81 55%,#1e40af 100%)">
        <div class="up-hero__wave">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,60 C480,0 960,80 1440,30 L1440,80 L0,80 Z" fill="#f0f9ff" />
            </svg>
        </div>

        <div class="up-wrap">
            <a href="{{ url()->previous() }}" class="pp-back-btn" style="color:#fff;background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.25)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back to Patients
            </a>

            <div class="up-hero__inner">
                <div class="up-hero__left">
                    <div class="up-hero__av-wrap">
                        <div class="up-hero__av">
                            @if($patient->image)
                            <img src="{{ asset('storage/' . $patient->image) }}" alt="{{ $patient->user_name }}">
                            @else
                            {{ strtoupper(substr($patient->user_name, 0, 1)) }}{{ strtoupper(substr(strstr($patient->user_name, ' '), 1, 1)) }}
                            @endif
                        </div>
                        <span class="up-hero__status-dot"></span>
                    </div>
                    <div class="up-hero__info">
                        <h1 class="up-hero__name" style="text-transform:capitalize;color:#fff">{{ $patient->user_name }}</h1>
                        <p class="up-hero__email" style="color:rgba(255,255,255,.72)">{{ $patient->user_email }}</p>
                        <div class="up-hero__badges">
                            <span class="up-hero__badge" style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:#fff">
                                <span class="dot" style="background:#a5f3fc"></span>
                                Medical Card: {{ $patient->medical_card_no }}
                            </span>
                            <span class="up-hero__badge" style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:#fff">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg>
                                Member ID: {{ $patient->memberid }}
                            </span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('partner.patient.medical-history', ['encryptedId' => $encryptedPatientId]) }}"
                    class="up-hero__actions" style="text-decoration:none;">
                    <span class="up-hero__btn up-hero__btn--white" style="cursor:pointer;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                        View Medical History
                    </span>
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════
     MAIN LAYOUT
══════════════════════════════════ --}}
    <div class="up-wrap">


        <div class="up-layout">

            {{-- ════════ SIDEBAR ════════ --}}
            <aside class="up-sidebar">

                {{-- Quick Stats --}}
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
                        <div class="up-qstat up-qstat--mint">
                            <div class="up-qstat__ico">💊</div>
                            <div class="up-qstat__num">{{ $noOfPrescription }}</div>
                            <div class="up-qstat__lbl">Prescriptions</div>
                        </div>
                        <div class="up-qstat up-qstat--coral">
                            <div class="up-qstat__ico">📋</div>
                            <div class="up-qstat__num">{{ $noOfReport }}</div>
                            <div class="up-qstat__lbl">Reports</div>
                        </div>
                        <div class="up-qstat up-qstat--teal">
                            <div class="up-qstat__ico">🔔</div>
                            <div class="up-qstat__num">{{ $noOfRequest }}</div>
                            <div class="up-qstat__lbl">Notifications</div>
                        </div>
                        <div class="up-qstat up-qstat--amber">
                            <div class="up-qstat__ico">📅</div>
                            <div class="up-qstat__num">{{ $bookings->count() }}</div>
                            <div class="up-qstat__lbl">Bookings</div>
                        </div>
                    </div>
                </div>

                {{-- Profile Info --}}
                <div class="up-card">
                    <div class="up-card__head" style="padding-bottom:0">
                        <div class="up-card__title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                            Personal Info
                        </div>
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
                                <div class="up-info-val">{{ $patient->dob ? date('M d, Y', strtotime($patient->dob)) : 'N/A' }}</div>
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
                                <div class="up-info-val" style="color:var(--rose);font-size:.95rem">{{ $patient->blood_group ?? 'N/A' }}</div>
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
                                <div class="up-info-val">{{ $patient->user_mobile ?? 'N/A' }}</div>
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
                                <div class="up-info-val">{{ $patient->user_city ?? 'N/A' }}</div>
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
                                <div class="up-info-val">{{ $patient->gender ?? 'N/A' }}</div>
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
                                <div class="up-info-val">{{ $patient->allergies ?? 'None' }}</div>
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
                                <div class="up-info-val">{{ $patient->created_at ? date('M Y', strtotime($patient->created_at)) : 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Health Score Ring --}}
                <div class="up-card">
                    <div class="up-card__head">
                        <div class="up-card__title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                            </svg>
                            Health Score
                        </div>
                    </div>

                    @php
                    $scores = [];

                    if (!empty($vital->heart_rate)) {
                    $hr = (float) $vital->heart_rate;
                    if ($hr >= 60 && $hr <= 100) $scores['Heart Rate']=100;
                        elseif ($hr>= 50 && $hr <= 110) $scores['Heart Rate']=75;
                            elseif ($hr>= 40 && $hr <= 130) $scores['Heart Rate']=50;
                                else $scores['Heart Rate']=25;
                                }

                                if (!empty($vital->blood_pressure)) {
                                $parts = explode('/', $vital->blood_pressure);
                                $sys = (float) ($parts[0] ?? 0);
                                if ($sys >= 90 && $sys <= 120) $scores['Blood Pressure']=100;
                                    elseif ($sys>= 80 && $sys <= 139) $scores['Blood Pressure']=70;
                                        elseif ($sys>= 70 && $sys <= 159) $scores['Blood Pressure']=45;
                                            else $scores['Blood Pressure']=20;
                                            }

                                            if (!empty($vital->temparature)) {
                                            $temp = (float) $vital->temparature;
                                            if ($temp >= 36.1 && $temp <= 37.2) $scores['Temperature']=100;
                                                elseif ($temp>= 35.5 && $temp <= 38.0) $scores['Temperature']=65;
                                                    else $scores['Temperature']=30;
                                                    }

                                                    if (!empty($vital->spo)) {
                                                    $spo = (float) $vital->spo;
                                                    if ($spo >= 95) $scores['SpO₂'] = 100;
                                                    elseif ($spo >= 90) $scores['SpO₂'] = 65;
                                                    elseif ($spo >= 85) $scores['SpO₂'] = 35;
                                                    else $scores['SpO₂'] = 15;
                                                    }

                                                    if (!empty($vital->blood_sugar)) {
                                                    $bs = (float) $vital->blood_sugar;
                                                    if ($bs >= 70 && $bs <= 99) $scores['Blood Sugar']=100;
                                                        elseif ($bs>= 60 && $bs <= 125) $scores['Blood Sugar']=70;
                                                            elseif ($bs>= 50 && $bs <= 199) $scores['Blood Sugar']=40;
                                                                else $scores['Blood Sugar']=15;
                                                                }

                                                                if (!empty($vital->bmi)) {
                                                                $bmi = (float) $vital->bmi;
                                                                if ($bmi >= 18.5 && $bmi <= 24.9) $scores['BMI']=100;
                                                                    elseif ($bmi>= 17 && $bmi <= 29.9) $scores['BMI']=70;
                                                                        elseif ($bmi>= 15 && $bmi <= 34.9) $scores['BMI']=45;
                                                                            else $scores['BMI']=20;
                                                                            }

                                                                            $overallScore=count($scores)> 0 ? (int) round(array_sum($scores) / count($scores)) : 0;
                                                                            $dashOffset = 314 - (314 * $overallScore / 100);

                                                                            if ($overallScore >= 85) $scoreLabel = 'Excellent Health';
                                                                            elseif ($overallScore >= 70) $scoreLabel = 'Good Health';
                                                                            elseif ($overallScore >= 50) $scoreLabel = 'Fair Health';
                                                                            elseif ($overallScore >= 30) $scoreLabel = 'Poor Health';
                                                                            else $scoreLabel = 'No Data';

                                                                            if ($overallScore >= 85) $ringColor = 'var(--mint)';
                                                                            elseif ($overallScore >= 70) $ringColor = 'var(--p)';
                                                                            elseif ($overallScore >= 50) $ringColor = 'var(--amber)';
                                                                            else $ringColor = 'var(--coral)';

                                                                            $barColors = [
                                                                            'Heart Rate' => 'var(--coral)',
                                                                            'Blood Pressure' => 'var(--p)',
                                                                            'Temperature' => 'var(--amber)',
                                                                            'SpO₂' => 'var(--mint)',
                                                                            'Blood Sugar' => '#a855f7',
                                                                            'BMI' => '#0ea5e9',
                                                                            ];
                                                                            @endphp

                                                                            <div class="up-health-score">
                                                                                <div class="up-score-ring">
                                                                                    <svg width="120" height="120" viewBox="0 0 120 120">
                                                                                        <circle cx="60" cy="60" r="50" fill="none" stroke="var(--border)" stroke-width="10" />
                                                                                        <circle cx="60" cy="60" r="50" fill="none"
                                                                                            stroke="{{ $ringColor }}"
                                                                                            stroke-width="10"
                                                                                            stroke-dasharray="314"
                                                                                            stroke-dashoffset="{{ $dashOffset }}"
                                                                                            stroke-linecap="round"
                                                                                            style="transition:stroke-dashoffset 1s ease;" />
                                                                                    </svg>
                                                                                    <div class="up-score-ring__text">
                                                                                        <span class="up-score-ring__num">{{ $overallScore }}</span>
                                                                                        <span class="up-score-ring__sub">/100</span>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="up-score-label">{{ $scoreLabel }}</div>
                                                                                <div class="up-score-sub">Based on patient vitals data</div>

                                                                                @if(count($scores))
                                                                                <div class="up-score-bars">
                                                                                    @foreach($scores as $label => $pct)
                                                                                    <div class="up-sbar-row">
                                                                                        <div class="up-sbar-top">
                                                                                            <span>{{ $label }}</span>
                                                                                            <span style="color:{{ $barColors[$label] ?? 'var(--p)' }};font-weight:800">{{ $pct }}%</span>
                                                                                        </div>
                                                                                        <div class="up-sbar-track">
                                                                                            <div class="up-sbar-fill" style="width:{{ $pct }}%;background:{{ $barColors[$label] ?? 'var(--p)' }}"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                @else
                                                                                <p style="font-size:13px;color:#aaa;text-align:center;margin-top:8px;">
                                                                                    No vitals recorded for this patient yet.
                                                                                </p>
                                                                                @endif
                                                                            </div>
                </div>

            </aside>{{-- end sidebar --}}


            {{-- ════════ MAIN CONTENT ════════ --}}
            <div class="up-main">

                {{-- ── Next Appointment Banner ── --}}
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
                        <div class="up-next-appt__title">{{ $latestSingleBooking->doctor->doctor_name }}</div>
                        <div class="up-next-appt__title" style="color:yellow">{{ $latestSingleBooking->doctor->doctor_specialist }} | {{ $latestSingleBooking->opdContact->clinic_name }}</div>
                        <small class="up-next-appt__sub">{{ $latestSingleBooking->doctor->doctor_more }}</small><br>
                        <small class="up-next-appt__sub">{{ $latestSingleBooking->opdContact->clinic_city }}, {{ $latestSingleBooking->opdContact->clinic_state }}, {{ $latestSingleBooking->opdContact->clinic_pincode }}</small>

                        @elseif ($latestSingleBooking->clinic_type === 'Pathology' && $latestSingleBooking->test)
                        <div class="up-next-appt__title">{{ $latestSingleBooking->test->test_name }}</div>
                        <div class="up-next-appt__title" style="color:yellow">{{ $latestSingleBooking->test->test_type }} | {{ $latestSingleBooking->pathologyContact->clinic_name }}</div>
                        <small class="up-next-appt__sub">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                                <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ $latestSingleBooking->pathologyContact->clinic_city }}, {{ $latestSingleBooking->pathologyContact->clinic_state }}, {{ $latestSingleBooking->pathologyContact->clinic_pincode }}
                        </small>

                        @elseif ($latestSingleBooking->clinic_type === 'Doctor' && $latestSingleBooking->doctorContact)
                        <div class="up-next-appt__title">{{ $latestSingleBooking->doctorContact->partner_doctor_name }}</div>
                        <div class="up-next-appt__title" style="color:yellow">{{ $latestSingleBooking->doctorContact->partner_doctor_specialist }}</div>
                        <small class="up-next-appt__sub">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                                <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ $latestSingleBooking->doctorContact->partner_doctor_city }}, {{ $latestSingleBooking->doctorContact->partner_doctor_state }}, {{ $latestSingleBooking->doctorContact->partner_doctor_pincode }}
                        </small>
                        @endif

                        <div class="up-next-appt__sub">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                            {{ \Carbon\Carbon::parse($latestSingleBooking->booking_date)->isTomorrow()
                            ? 'Tomorrow, ' . \Carbon\Carbon::parse($latestSingleBooking->booking_date)->format('d M Y')
                            : \Carbon\Carbon::parse($latestSingleBooking->booking_date)->format('l, d M Y') }}
                            &bull; {{ \Carbon\Carbon::parse($latestSingleBooking->booking_time)->format('h:i A') }}
                            &bull; <span style="text-transform:capitalize">{{ $latestSingleBooking->visit_mode }}</span> Consultation
                        </div>
                    </div>

                    {{-- Map link --}}
                    @if ($latestSingleBooking->clinic_type === 'OPD' && $latestSingleBooking->doctor)
                    <a href="{{ $latestSingleBooking->opdContact->clinic_google_map_link }}" target="_blank" class="up-next-appt__action" style="color:#1B9AAA;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                            <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg> MAP
                    </a>
                    @elseif ($latestSingleBooking->clinic_type === 'Pathology' && $latestSingleBooking->test)
                    <a href="{{ $latestSingleBooking->pathologyContact->clinic_google_map_link }}" target="_blank" class="up-next-appt__action" style="color:#1B9AAA;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                            <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg> MAP
                    </a>
                    @elseif ($latestSingleBooking->clinic_type === 'Doctor' && $latestSingleBooking->doctorContact)
                    <a href="{{ $latestSingleBooking->doctorContact->partner_doctor_google_map_link }}" target="_blank" class="up-next-appt__action" style="color:#1B9AAA;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle">
                            <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 1 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg> MAP
                    </a>
                    @endif
                </div>
                @endif


                {{-- ── Vitals ── --}}
                <div class="up-card">
                    <div class="up-card__head">
                        <div class="up-card__title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                            Latest Vitals
                        </div>
                        <span style="font-size:.7rem;color:var(--muted);font-weight:700">
                            Updated: {{ $vital && $vital->updated_at ? \Carbon\Carbon::parse($vital->updated_at)->format('d M Y') : '—' }}
                        </span>
                    </div>
                    <div class="up-vitals">
                        <div class="up-vital up-qstat--coral" style="border-color:#fed7aa">
                            <div class="up-vital__ico">🔴</div>
                            <div class="up-vital__val" style="color:#c2410c">{{ $vital->blood_group ?? '—' }}</div>
                            <div class="up-vital__unit">Group</div>
                            <div class="up-vital__lbl">Blood Group</div>
                        </div>
                        <div class="up-vital up-qstat--teal" style="border-color:#bae6fd">
                            <div class="up-vital__ico">❤️</div>
                            <div class="up-vital__val" style="color:var(--p-dk)">{{ $vital->heart_rate ?? '—' }}</div>
                            <div class="up-vital__unit">bpm</div>
                            <div class="up-vital__lbl">Heart Rate</div>
                        </div>
                        <div class="up-vital up-qstat--rose" style="border-color:#fecdd3;background:var(--rose-lt)">
                            <div class="up-vital__ico">🩸</div>
                            <div class="up-vital__val" style="color:var(--rose)">{{ $vital->blood_pressure ?? '—' }}</div>
                            <div class="up-vital__unit">mmHg</div>
                            <div class="up-vital__lbl">Blood Pressure</div>
                        </div>
                        <div class="up-vital up-qstat--mint" style="border-color:#a7f3d0">
                            <div class="up-vital__ico">🌡️</div>
                            <div class="up-vital__val" style="color:#047857">{{ $vital->temparature ?? '—' }}</div>
                            <div class="up-vital__unit">°C</div>
                            <div class="up-vital__lbl">Temperature</div>
                        </div>
                        <div class="up-vital up-qstat--amber" style="border-color:#fde68a">
                            <div class="up-vital__ico">⚖️</div>
                            <div class="up-vital__val" style="color:#b45309">{{ $vital->weight ?? '—' }}</div>
                            <div class="up-vital__unit">kg</div>
                            <div class="up-vital__lbl">Weight</div>
                        </div>
                        <div class="up-vital up-qstat--mint" style="border-color:#fde68a">
                            <div class="up-vital__ico">📏</div>
                            <div class="up-vital__val" style="color:#b45309">{{ $vital->height ?? '—' }}</div>
                            <div class="up-vital__unit">cm</div>
                            <div class="up-vital__lbl">Height</div>
                        </div>
                        <div class="up-vital up-qstat--coral" style="border-color:#fed7aa">
                            <div class="up-vital__ico">📊</div>
                            <div class="up-vital__val" style="color:#c2410c">{{ $vital->bmi ?? '—' }}</div>
                            <div class="up-vital__unit">
                                @if($vital && $vital->bmi)
                                @if($vital->bmi < 18.5) Underweight
                                    @elseif($vital->bmi < 25) Normal
                                        @elseif($vital->bmi < 30) Overweight
                                            @else Obese
                                            @endif
                                            @else —
                                            @endif
                                            </div>
                                            <div class="up-vital__lbl">BMI</div>
                            </div>
                            <div class="up-vital up-qstat--violet" style="border-color:#ddd6fe;background:var(--violet-lt)">
                                <div class="up-vital__ico">🫁</div>
                                <div class="up-vital__val" style="color:var(--violet)">{{ $vital->spo ?? '—' }}</div>
                                <div class="up-vital__unit">SpO₂ %</div>
                                <div class="up-vital__lbl">Oxygen</div>
                            </div>
                            <div class="up-vital up-qstat--amber" style="border-color:#fed7aa">
                                <div class="up-vital__ico">🧪</div>
                                <div class="up-vital__val" style="color:#c2410c">{{ $vital->blood_sugar ?? '—' }}</div>
                                <div class="up-vital__unit">mg/dL</div>
                                <div class="up-vital__lbl">Blood Sugar</div>
                            </div>
                        </div>
                    </div>


                    {{-- ── Appointments Tab ── --}}
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
                            <button class="up-tab" onclick="switchTab('chronic')" id="tab-chronic">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12h6M9 16h6M9 8h6M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                </svg>
                                Medical Notes
                            </button>
                        </div>

                        {{-- ── Appointments Content ── --}}
                        <div id="content-appointments" class="up-tab-content active">
                            <div class="up-appt-wrap">
                                <div class="up-appt-filters">
                                    <button class="up-filter-btn active" onclick="filterAppts(this,'all')">
                                        All <span class="up-filter-count" id="count-all">{{ $bookings->count() }}</span>
                                    </button>
                                    <button class="up-filter-btn" onclick="filterAppts(this,'Upcoming')">
                                        Upcoming <span class="up-filter-count" id="count-upcoming">{{ $bookings->where('status','Upcoming')->count() }}</span>
                                    </button>
                                    <button class="up-filter-btn" onclick="filterAppts(this,'Completed')">
                                        Completed <span class="up-filter-count" id="count-completed">{{ $bookings->where('status','Completed')->count() }}</span>
                                    </button>
                                    <button class="up-filter-btn" onclick="filterAppts(this,'Cancelled')">
                                        Cancelled <span class="up-filter-count" id="count-cancelled">{{ $bookings->where('status','Cancelled')->count() }}</span>
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
                                            @foreach($bookings as $booking)
                                            @php
                                            $status = $booking->status ?? 'Upcoming';
                                            $statusMap = [
                                            'Upcoming' => ['class' => 'up-status--upcoming', 'label' => 'Upcoming'],
                                            'Completed' => ['class' => 'up-status--done', 'label' => 'Completed'],
                                            'Cancelled' => ['class' => 'up-status--cancelled', 'label' => 'Cancelled'],
                                            ];
                                            $statusInfo = $statusMap[$status] ?? ['class' => 'up-status--upcoming', 'label' => $status];
                                            @endphp
                                            <tr class="appt-row" data-status="{{ $status }}">
                                                <td>
                                                    @if ($booking->clinic_type === 'OPD' && $booking->doctor)
                                                    <div class="up-appt-doc">
                                                        <div class="up-appt-av">{{ strtoupper(substr($booking->doctor->doctor_name,0,1)) }}{{ strtoupper(substr(strstr($booking->doctor->doctor_name,' '),1,1)) }}</div>
                                                        <div>
                                                            <div class="up-appt-dname">Dr. {{ $booking->doctor->doctor_name }}</div>
                                                            <div class="up-appt-dname" style="color:red">{{ $booking->doctor->doctor_specialist }}</div>
                                                            <div class="up-appt-subname" style="color:#5E807F">{{ $booking->opdContact->clinic_name }}</div>
                                                        </div>
                                                    </div>
                                                    @elseif ($booking->clinic_type === 'Pathology' && $booking->test)
                                                    <div class="up-appt-doc">
                                                        <div class="up-appt-av">{{ strtoupper(substr($booking->test->test_name,0,1)) }}{{ strtoupper(substr(strstr($booking->test->test_name,' '),1,1)) }}</div>
                                                        <div>
                                                            <div class="up-appt-dname">{{ $booking->test->test_name }}</div>
                                                            <div class="up-appt-dname" style="color:green">{{ $booking->test->test_type }}</div>
                                                            <div class="up-appt-subname" style="color:#5E807F">{{ $booking->pathologyContact->clinic_name }}</div>
                                                        </div>
                                                    </div>
                                                    @elseif ($booking->clinic_type === 'Doctor' && $booking->doctorContact)
                                                    <div class="up-appt-doc">
                                                        <div class="up-appt-av">{{ strtoupper(substr($booking->doctorContact->partner_doctor_name,0,1)) }}{{ strtoupper(substr(strstr($booking->doctorContact->partner_doctor_name,' '),1,1)) }}</div>
                                                        <div>
                                                            <div class="up-appt-dname">Dr. {{ $booking->doctorContact->partner_doctor_name }}</div>
                                                            <div class="up-appt-dname" style="color:#1B9AAA">{{ $booking->doctorContact->partner_doctor_specialist }}</div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}<br>
                                                    <span style="color:var(--muted);font-size:.75rem">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                                                </td>
                                                <td><span style="font-size:.74rem;font-weight:700;color:var(--p);text-transform:capitalize">{{ $booking->visit_mode }}</span></td>
                                                <td>
                                                    <span class="up-status {{ $statusInfo['class'] }}">
                                                        <span class="dot"></span>{{ $statusInfo['label'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($booking->clinic_type === 'OPD' && $booking->doctor)
                                                    <a href="{{ $booking->opdContact->clinic_google_map_link }}" target="_blank" class="up-action-done">Map Link</a>
                                                    @elseif ($booking->clinic_type === 'Pathology' && $booking->test)
                                                    <a href="{{ $booking->pathologyContact->clinic_google_map_link }}" target="_blank" class="up-action-done">Map Link</a>
                                                    @elseif ($booking->clinic_type === 'Doctor' && $booking->doctorContact)
                                                    <a href="{{ $booking->doctorContact->partner_doctor_google_map_link }}" target="_blank" class="up-action-done">Map Link</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>{{-- end appointments --}}

                        {{-- ── Medical Notes Content ── --}}
                        <div id="content-chronic" class="up-tab-content">
                            <div style="padding:20px">
                                @if($patient->chronic_conditions || $patient->allergies)
                                <div style="display:grid;gap:16px">
                                    @if($patient->chronic_conditions)
                                    <div style="background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;padding:16px">
                                        <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#b45309;margin-bottom:8px;display:flex;align-items:center;gap:6px">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zM12 8v4M12 16h.01" />
                                            </svg>
                                            Chronic Conditions
                                        </div>
                                        <p style="font-size:.875rem;color:#1e293b;line-height:1.6">{{ $patient->chronic_conditions }}</p>
                                    </div>
                                    @endif
                                    @if($patient->allergies)
                                    <div style="background:#fff1f2;border:1.5px solid #fecdd3;border-radius:12px;padding:16px">
                                        <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#e11d48;margin-bottom:8px;display:flex;align-items:center;gap:6px">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                            </svg>
                                            Known Allergies
                                        </div>
                                        <p style="font-size:.875rem;color:#1e293b;line-height:1.6">{{ $patient->allergies }}</p>
                                    </div>
                                    @endif
                                </div>
                                @else
                                <div class="up-appt-empty">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity=".3">
                                        <path d="M9 12h6M9 16h6M9 8h6M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                    </svg>
                                    <p>No medical notes on record for this patient.</p>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>{{-- end tabs card --}}

                </div>{{-- end main --}}
            </div>{{-- end layout --}}
        </div>{{-- end wrap --}}


        {{-- ═══════ COMPLETE MODAL ═══════ --}}
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
                <p class="complete-modal-desc">This will mark the appointment as <strong>Completed</strong>. This action cannot be undone.</p>
                <div class="complete-modal-appt-preview">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Appointment #<strong id="completeApptId">—</strong></span>
                </div>
                <form action="" method="POST" id="completeForm" novalidate>
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

        {{-- ═══════ CANCEL MODAL ═══════ --}}
        <div class="cancel-modal-overlay" id="cancelModalOverlay" role="dialog" aria-modal="true" aria-labelledby="cancelModalTitle">
            <div class="cancel-modal-box">
                <div class="cancel-modal-icon-wrap">
                    <div class="cancel-modal-icon-ring"></div>
                    <div class="cancel-modal-icon-ring cancel-modal-icon-ring--2"></div>
                    <div class="cancel-modal-icon-circle">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="9" />
                            <line x1="5" y1="5" x2="19" y2="19" />
                        </svg>
                    </div>
                </div>
                <h2 class="cancel-modal-title" id="cancelModalTitle">Cancel Appointment?</h2>
                <p class="cancel-modal-desc">This will mark the appointment as <strong>Cancelled</strong>. This action cannot be undone.</p>
                <div class="cancel-modal-appt-preview">
                    <i class="fa-solid fa-calendar-xmark"></i>
                    <span>Appointment #<strong id="cancelApptId">—</strong></span>
                </div>
                <form action="" method="POST" id="cancelForm" novalidate>
                    @csrf
                    <input type="hidden" name="status" value="Cancelled">
                    <div class="cancel-modal-actions">
                        <button type="button" class="cancel-modal-btn cancel-modal-btn--keep" onclick="closeCancelModal()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M18 6L6 18M6 6l12 12" />
                            </svg>
                            Keep
                        </button>
                        <button type="submit" class="cancel-modal-btn cancel-modal-btn--confirm">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="9" />
                                <line x1="5" y1="5" x2="19" y2="19" />
                            </svg>
                            Yes, Cancel It
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <script>
            /* ── Tabs ── */
            function switchTab(name) {
                document.querySelectorAll('.up-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.up-tab-content').forEach(c => c.classList.remove('active'));
                document.getElementById('tab-' + name).classList.add('active');
                document.getElementById('content-' + name).classList.add('active');
            }

            /* ── Filter ── */
            function filterAppts(btn, filter) {
                document.querySelectorAll('.up-appt-filters .up-filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.querySelectorAll('#apptTableBody .appt-row').forEach(row => {
                    if (filter === 'all') row.classList.remove('is-hidden');
                    else row.classList.toggle('is-hidden', row.getAttribute('data-status') !== filter);
                });
                const visible = document.querySelectorAll('#apptTableBody .appt-row:not(.is-hidden)');
                const emptyEl = document.querySelector('.up-appt-empty');
                const tableWrap = document.querySelector('.up-appt-table-wrap');
                if (emptyEl && tableWrap) {
                    if (visible.length === 0) {
                        tableWrap.style.display = 'none';
                        emptyEl.style.display = 'flex';
                        emptyEl.querySelector('p').textContent = 'No ' + (filter === 'all' ? '' : filter.toLowerCase() + ' ') + 'appointments found';
                    } else {
                        tableWrap.style.display = '';
                        emptyEl.style.display = 'none';
                    }
                }
            }

            /* ── Complete Modal ── */
            function openCompleteModal(id) {
                document.getElementById('completeForm').action = '/dw/profile/appointment-complete/' + id;
                document.getElementById('completeApptId').textContent = id;
                document.getElementById('completeModalOverlay').classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeCompleteModal() {
                document.getElementById('completeModalOverlay').classList.remove('is-open');
                document.body.style.overflow = '';
            }

            /* ── Cancel Modal ── */
            function openCancelModal(id) {
                document.getElementById('cancelForm').action = '/dw/profile/appointment-cancel/' + id;
                document.getElementById('cancelApptId').textContent = id;
                document.getElementById('cancelModalOverlay').classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeCancelModal() {
                document.getElementById('cancelModalOverlay').classList.remove('is-open');
                document.body.style.overflow = '';
            }

            /* ── Backdrop + Escape ── */
            document.getElementById('completeModalOverlay').addEventListener('click', e => {
                if (e.target === e.currentTarget) closeCompleteModal();
            });
            document.getElementById('cancelModalOverlay').addEventListener('click', e => {
                if (e.target === e.currentTarget) closeCancelModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    closeCompleteModal();
                    closeCancelModal();
                }
            });
        </script>
</body>

</html>