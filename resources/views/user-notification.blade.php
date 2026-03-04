@extends('frontend.layout.app')

@section('title', $user->user_name . ' - My Notifications - Doctorwala.info')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --t1: #0077b6;
            --t2: #00b4d8;
            --t3: #caf0f8;
            --tdk: #005f8e;
            --grn: #10b981;
            --red: #ef4444;
            --c1: #0f1c2e;
            --c2: #4b5c6b;
            --c3: #94a3b8;
            --bd: #e2eaf3;
            --bg: #f0f7fb;
            --wh: #fff;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .nf-btn--access-off {
            background: #fff1f2;
            color: #9f1239;
            border: 1.5px solid #fca5a5;
        }

        .nf-btn--access-off:hover {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            border-color: #ef4444;
            box-shadow: 0 4px 14px rgba(239, 68, 68, .3);
        }

        .nf-btn--access-on {
            background: #f0fdf4;
            color: #065f46;
            border: 1.5px solid #6ee7b7;
        }

        .nf-btn--access-on:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            border-color: #10b981;
            box-shadow: 0 4px 14px rgba(16, 185, 129, .3);
        }

        .nf-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
            padding: 13px 18px;
            border-radius: 12px;
            margin: 12px 16px;
            font-size: 13.5px;
            font-weight: 500;
            animation: pprIn .3s ease;
        }

        .nf-alert--success {
            background: #ecfdf5;
            border: 1.5px solid #6ee7b7;
            color: #065f46;
        }

        .nf-alert--error {
            background: #fff1f2;
            border: 1.5px solid #fca5a5;
            color: #9f1239;
        }

        .nf-alert button {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: inherit;
            opacity: .6;
        }

        .nf-alert button:hover {
            opacity: 1;
        }

        @keyframes pprIn {
            from {
                opacity: 0;
                transform: translateY(-8px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .nf-wrap {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            min-height: 80vh;
            padding-bottom: 60px;
        }

        /* hero */
        .nf-hero {
            position: relative;
            background: linear-gradient(115deg, var(--t1) 0%, var(--t2) 100%);
            padding: clamp(24px, 5vw, 40px) clamp(16px, 4vw, 32px);
        }

        .nf-hero__bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .nf-hero__bg::before,
        .nf-hero__bg::after {
            content: '';
            position: absolute;
            border-radius: 50%;
        }

        .nf-hero__bg::before {
            width: 320px;
            height: 320px;
            right: -80px;
            top: -80px;
            border: 50px solid rgba(255, 255, 255, .07);
        }

        .nf-hero__bg::after {
            width: 200px;
            height: 200px;
            left: -50px;
            bottom: -60px;
            border: 35px solid rgba(255, 255, 255, .05);
        }

        .nf-hero__content {
            position: relative;
            z-index: 1;
            max-width: 860px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .nf-hero__left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nf-hero__bell {
            position: relative;
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(255, 255, 255, .28);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
        }

        .nf-hero__dot {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #fbbf24;
            border: 2.5px solid var(--t1);
            animation: dotPop 2s infinite;
        }

        @keyframes dotPop {

            0%,
            100% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.35)
            }
        }

        .nf-hero__title {
            font-size: clamp(18px, 4vw, 24px);
            font-weight: 800;
            color: #fff;
            letter-spacing: -.3px;
        }

        .nf-hero__sub {
            font-size: clamp(11px, 2.5vw, 12.5px);
            color: rgba(255, 255, 255, .75);
            margin-top: 4px;
        }

        .nf-hero__pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .nf-pill {
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            backdrop-filter: blur(8px);
        }

        .nf-pill--amber {
            background: rgba(251, 191, 36, .22);
            border: 1.5px solid rgba(251, 191, 36, .4);
            color: #fef3c7;
        }

        .nf-pill--white {
            background: rgba(255, 255, 255, .15);
            border: 1.5px solid rgba(255, 255, 255, .25);
            color: #fff;
        }

        /* toolbar */
        .nf-toolbar-wrap {
            background: #fff;
            border-bottom: 1.5px solid var(--bd);
            box-shadow: 0 2px 12px rgba(0, 119, 182, .05);
        }

        .nf-toolbar {
            max-width: 860px;
            margin: 0 auto;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nf-tabs {
            display: flex;
            gap: 4px;
            background: #f4f8fc;
            border-radius: 10px;
            padding: 4px;
            border: 1.5px solid var(--bd);
        }

        .nf-tab {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 7px;
            border: none;
            background: transparent;
            color: var(--c2);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .18s;
        }

        .nf-tab--on {
            background: linear-gradient(135deg, var(--t1), var(--t2));
            color: #fff;
            box-shadow: 0 3px 12px rgba(0, 119, 182, .28);
        }

        .nf-tab__pip {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #fbbf24;
            animation: dotPop 2s infinite;
        }

        .nf-tab--on .nf-tab__pip {
            background: rgba(255, 255, 255, .8);
        }

        .nf-tab__badge {
            font-size: 10px;
            font-weight: 800;
            padding: 1px 7px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .25);
            color: #fff;
            min-width: 20px;
            text-align: center;
        }

        .nf-tab:not(.nf-tab--on) .nf-tab__badge {
            background: var(--t3);
            color: var(--t1);
        }

        .nf-tab__badge--grey {
            background: #f1f5f9 !important;
            color: var(--c3) !important;
        }

        .nf-search {
            flex: 1;
            min-width: 180px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f4f8fc;
            border: 1.5px solid var(--bd);
            border-radius: 10px;
            padding: 9px 13px;
            transition: border-color .18s, box-shadow .18s;
        }

        .nf-search:focus-within {
            background: #fff;
            border-color: var(--t2);
            box-shadow: 0 0 0 3px rgba(0, 180, 216, .1);
        }

        .nf-search svg {
            color: var(--c3);
            flex-shrink: 0;
        }

        .nf-search input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            color: var(--c1);
        }

        .nf-search input::placeholder {
            color: var(--c3);
        }

        .nf-search__x {
            background: none;
            border: none;
            color: var(--c3);
            cursor: pointer;
            display: flex;
            transition: color .15s;
            padding: 0;
        }

        .nf-search__x:hover {
            color: var(--red);
        }

        /* list */
        .nf-list {
            max-width: 860px;
            margin: 0 auto;
            padding: 20px 16px 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* card */
        .nf-card {
            background: var(--wh);
            border-radius: 18px;
            border: 1.5px solid var(--bd);
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0, 119, 182, .06);
            transition: transform .2s, box-shadow .2s;
            animation: cardIn .3s ease both;
        }

        .nf-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(0, 119, 182, .12);
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .nf-card--unread {
            border-left: 4px solid var(--t1);
        }

        .nf-card--done {
            border-left: 4px solid #d1d9e6;
            opacity: .84;
        }

        /* shimmer top bar */
        .nf-card__glow {
            height: 3px;
            background: linear-gradient(90deg, var(--t1), var(--t2), var(--t1));
            background-size: 200%;
            animation: shimmer 2.5s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200%
            }

            100% {
                background-position: -200%
            }
        }

        .nf-card__inner {
            padding: 16px 18px 15px;
        }

        .nf-card__row--head {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 13px;
        }

        .nf-avatar {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            letter-spacing: .5px;
            background: linear-gradient(135deg, var(--av), var(--av2));
            box-shadow: 0 4px 14px rgba(0, 0, 0, .15);
        }

        .nf-card__titles {
            flex: 1;
            min-width: 0;
        }

        .nf-card__clinic {
            font-size: 15px;
            font-weight: 700;
            color: var(--c1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nf-card__dr {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--c2);
            margin-top: 3px;
        }

        .nf-card__when {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
        }

        .nf-live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--t2);
            box-shadow: 0 0 0 3px rgba(0, 180, 216, .2);
            animation: dotPop 2s infinite;
        }

        .nf-card__when>span:last-child {
            font-size: 11px;
            color: var(--c3);
            white-space: nowrap;
        }

        /* request chip */
        .nf-req-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #e0f7fc, #caf0f8);
            border: 1px solid #a5d8e8;
            border-radius: 10px;
            padding: 9px 13px;
            font-size: 12.5px;
            color: var(--tdk);
            margin-bottom: 14px;
        }

        .nf-req-chip strong {
            color: #004e6e;
        }

        .nf-req-chip--muted {
            background: #f7f9fb;
            border-color: var(--bd);
            color: var(--c3);
        }

        .nf-req-chip--muted strong {
            color: var(--c3);
        }

        /* facts */
        .nf-facts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px 18px;
            margin-bottom: 16px;
        }

        .nf-fact {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            color: var(--c2);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .nf-fact--full {
            grid-column: 1/-1;
            white-space: normal;
        }

        .nf-ico {
            width: 22px;
            height: 22px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-style: normal;
        }

        .nf-ico--g {
            background: #dcfce7;
            color: #15803d;
        }

        .nf-ico--b {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .nf-ico--y {
            background: #fef9c3;
            color: #a16207;
        }

        .nf-ico--p {
            background: #f3e8ff;
            color: #7e22ce;
        }

        /* action btns */
        .nf-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .nf-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 22px;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all .16s;
        }

        .nf-btn--yes {
            background: #d1fae5;
            color: #064e3b;
            border: 1.5px solid #6ee7b7;
        }

        .nf-btn--yes:hover {
            background: linear-gradient(135deg, var(--grn), #059669);
            color: #fff;
            border-color: var(--grn);
            box-shadow: 0 4px 14px rgba(16, 185, 129, .3);
        }

        .nf-btn--no {
            background: #fee2e2;
            color: #7f1d1d;
            border: 1.5px solid #fca5a5;
        }

        .nf-btn--no:hover {
            background: linear-gradient(135deg, var(--red), #dc2626);
            color: #fff;
            border-color: var(--red);
            box-shadow: 0 4px 14px rgba(239, 68, 68, .3);
        }

        /* status tags */
        .nf-tag {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .nf-tag--yes {
            background: #d1fae5;
            color: #065f46;
        }

        .nf-tag--no {
            background: #fee2e2;
            color: #991b1b;
        }

        /* responded inline tag */
        .nf-inline-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
        }

        .nf-inline-tag--yes {
            background: #d1fae5;
            color: #064e3b;
        }

        .nf-inline-tag--no {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .nf-card--faded {
            opacity: .45;
            pointer-events: none;
            transition: opacity .4s;
        }

        /* empty */
        .nf-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 24px;
            gap: 10px;
        }

        .nf-empty__ico {
            font-size: 44px;
        }

        .nf-empty__t {
            font-size: 15px;
            font-weight: 700;
            color: #94a3b8;
        }

        .nf-empty__s {
            font-size: 13px;
            color: #cbd5e1;
        }

        /* responsive */
        @media(max-width:600px) {
            .nf-hero__pills {
                display: none;
            }

            .nf-facts {
                grid-template-columns: 1fr;
            }

            .nf-card__when {
                flex-direction: row;
                align-items: center;
                gap: 8px;
            }

            .nf-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .nf-search {
                max-width: 100%;
            }

            .nf-btn {
                flex: 1;
                justify-content: center;
            }

            .nf-card__inner {
                padding: 14px;
            }
        }

        @media(max-width:360px) {
            .nf-card__clinic {
                font-size: 13px;
            }

            .nf-hero__title {
                font-size: 17px;
            }
        }
    </style>

</head>


<div class="nf-wrap">

    {{-- ── HERO HEADER ── --}}
    <div class="nf-hero">
        <div class="nf-hero__bg"></div>
        <div class="nf-hero__content">
            <div class="nf-hero__left">
                <div class="nf-hero__bell">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 01-3.46 0" />
                    </svg>
                    <span class="nf-hero__dot"></span>
                </div>
                <div>
                    <h1 class="nf-hero__title">Notifications</h1>
                    <p class="nf-hero__sub">Doctors requesting access to your medical profile &amp; history</p>
                </div>
            </div>
            <div class="nf-hero__pills">
                <div class="nf-pill nf-pill--amber">
                    <span id="heroUnreadNum">{{ $requests->where('read_status','unread')->count() }}</span> Unread
                </div>
                <div class="nf-pill nf-pill--white">{{ $requests->count() }} Total</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="nf-toolbar-wrap">
        <div class="nf-toolbar">
            <div class="nf-tabs">
                <button class="nf-tab nf-tab--on" onclick="nfTab('unread',this)">
                    <span class="nf-tab__pip"></span>
                    Unread
                    <span class="nf-tab__badge" id="tabBadgeUnread">{{ $requests->where('read_status','unread')->count() }}</span>
                </button>
                <button class="nf-tab" onclick="nfTab('read',this)">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Read
                    <span class="nf-tab__badge nf-tab__badge--grey" id="tabBadgeRead">{{ $requests->where('read_status','read')->count() }}</span>
                </button>
            </div>

            <label class="nf-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" id="nfQ" placeholder="Search clinic, doctor, email, city…" oninput="nfFilter(this.value)">
                <button type="button" class="nf-search__x" id="nfClearBtn" onclick="nfClear()" style="display:none">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </label>
        </div>
    </div>

    {{-- session alerts --}}
    @if(session('success'))
    <div class="nf-alert nf-alert--success">
        <i class="fa fa-check-circle"></i> {{ session('success') }}
        <button onclick="this.parentElement.remove()">×</button>
    </div>
    @endif
    @if(session('error'))
    <div class="nf-alert nf-alert--error">
        <i class="fa fa-times-circle"></i> {{ session('error') }}
        <button onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- ══════ UNREAD LIST ══════ --}}
    <div id="list-unread" class="nf-list">

        @forelse($requests->where('read_status','unread')->values() as $req)
        @php
        $initials = strtoupper(substr($req->partner_clinic_name ?? 'C', 0, 2));
        $search = strtolower(
        ($req->partner_clinic_name ?? '') . ' ' .
        ($req->doctor->doctor_name ?? '') . ' ' .
        ($req->doctor->doctor_specialist ?? '') . ' ' .
        ($req->partner_mobile_number ?? '') . ' ' .
        ($req->partner_email ?? '') . ' ' .
        ($req->partner_city ?? '')
        );
        @endphp
        <div class="nf-card nf-card--unread" data-tab="unread" data-s="{{ $search }}">
            <div class="nf-card__glow"></div>
            <div class="nf-card__inner">

                <div class="nf-card__row nf-card__row--head">
                    <div class="nf-avatar" style="--av:#0077b6;--av2:#00b4d8">{{ $initials }}</div>
                    <div class="nf-card__titles">
                        <div class="nf-card__clinic">{{ $req->partner_clinic_name }}</div>
                        <div class="nf-card__dr">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            {{ $req->doctor->doctor_name ?? '—' }}
                            @if(!empty($req->doctor->doctor_specialist)) · {{ $req->doctor->doctor_specialist }} @endif
                        </div>
                    </div>
                    <div class="nf-card__when">
                        <span class="nf-live-dot"></span>
                        <span>{{ \Carbon\Carbon::parse($req->created_at)->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="nf-req-chip">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Requesting access to your <strong>medical profile &amp; history</strong>
                </div>

                <div class="nf-facts">
                    <div class="nf-fact">
                        <i class="nf-ico nf-ico--g"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 13.5 19.79 19.79 0 01.12 5.18 2 2 0 012.12 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 10.91A16 16 0 0013 17.91l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 18v1h-.08z" />
                            </svg></i>
                        {{ $req->partner_mobile_number }}
                    </div>
                    <div class="nf-fact">
                        <i class="nf-ico nf-ico--b"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg></i>
                        {{ $req->partner_email }}
                    </div>
                    <div class="nf-fact nf-fact--full">
                        <i class="nf-ico nf-ico--y"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg></i>
                        {{ implode(', ', array_filter([$req->partner_landmark, $req->partner_city, $req->partner_state])) }} – {{ $req->partner_pincode }}
                    </div>
                    <div class="nf-fact">
                        <i class="nf-ico nf-ico--p"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg></i>
                        {{ \Carbon\Carbon::parse($req->created_at)->format('d M Y, h:i A') }}
                    </div>
                </div>

                <div class="nf-actions">
                    <form action="{{ route('dw.notification.accept', $req->id) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="nf-btn nf-btn--yes">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Accept
                        </button>
                    </form>
                    <form action="{{ route('dw.notification.reject', $req->id) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="nf-btn nf-btn--no">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                            Reject
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @empty
        <div class="nf-empty" id="emptyUnread">
            <div class="nf-empty__ico">🔔</div>
            <div class="nf-empty__t">All caught up!</div>
            <div class="nf-empty__s">No unread notifications right now.</div>
        </div>
        @endforelse

        <div class="nf-empty" id="emptyUnread" style="display:none">
            <div class="nf-empty__ico">🔔</div>
            <div class="nf-empty__t">All caught up!</div>
            <div class="nf-empty__s">No unread notifications right now.</div>
        </div>
    </div>

    {{-- ══════ READ LIST ══════ --}}
    <div id="list-read" class="nf-list" style="display:none">

        @forelse($requests->where('read_status','read')->values() as $req)
        @php
        $initials = strtoupper(substr($req->partner_clinic_name ?? 'C', 0, 2));
        $search = strtolower(
        ($req->partner_clinic_name ?? '') . ' ' .
        ($req->doctor->doctor_name ?? '') . ' ' .
        ($req->partner_mobile_number ?? '') . ' ' .
        ($req->partner_email ?? '') . ' ' .
        ($req->partner_city ?? '')
        );
        @endphp
        <div class="nf-card nf-card--done" data-tab="read" data-s="{{ $search }}">
            <div class="nf-card__inner">

                <div class="nf-card__row nf-card__row--head">
                    <div class="nf-avatar" style="--av:{{ $req->req_status === 'accepted' ? '#0077b6' : '#ef4444' }};--av2:{{ $req->req_status === 'accepted' ? '#00b4d8' : '#f97316' }}">{{ $initials }}</div>
                    <div class="nf-card__titles">
                        <div class="nf-card__clinic">{{ $req->partner_clinic_name }}</div>
                        <div class="nf-card__dr">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            {{ $req->doctor->doctor_name ?? '—' }}
                            @if(!empty($req->doctor->doctor_specialist)) · {{ $req->doctor->doctor_specialist }} @endif
                        </div>
                    </div>
                    <div class="nf-card__when">
                        @if($req->req_status === 'accepted')
                        <span class="nf-tag nf-tag--yes">✓ Accepted</span>
                        @elseif($req->req_status === 'rejected')
                        <span class="nf-tag nf-tag--no">✕ Rejected</span>
                        @else
                        <span class="nf-tag" style="background:#fef9c3;color:#854d0e">⏳ Pending</span>
                        @endif
                        <span>{{ \Carbon\Carbon::parse($req->created_at)->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="nf-req-chip nf-req-chip--muted">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Requested access to your <strong>medical profile &amp; history</strong>
                </div>

                <div class="nf-facts">
                    <div class="nf-fact">
                        <i class="nf-ico nf-ico--g"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 13.5 19.79 19.79 0 01.12 5.18 2 2 0 012.12 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 10.91A16 16 0 0013 17.91l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 18v1h-.08z" />
                            </svg></i>
                        {{ $req->partner_mobile_number }}
                    </div>
                    <div class="nf-fact">
                        <i class="nf-ico nf-ico--b"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg></i>
                        {{ $req->partner_email }}
                    </div>
                    <div class="nf-fact nf-fact--full">
                        <i class="nf-ico nf-ico--y"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg></i>
                        {{ implode(', ', array_filter([$req->partner_landmark, $req->partner_city, $req->partner_state])) }} – {{ $req->partner_pincode }}
                    </div>
                    <div class="nf-fact">
                        <i class="nf-ico nf-ico--p"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg></i>
                        {{ \Carbon\Carbon::parse($req->created_at)->format('d M Y, h:i A') }}
                    </div>
                </div>

                {{-- ── Access Toggle Button ── --}}
                <div class="nf-actions" style="margin-top:12px;">
                    @if($req->access_status === 'on')
                    <form action="{{ route('dw.notification.permission.off', $req->id) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="nf-btn nf-btn--access-off"
                            onclick="return confirm('Revoke this clinic\'s access to your medical profile?')">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                            Turn Off Access
                        </button>
                    </form>
                    @else
                    <form action="{{ route('dw.notification.permission.on', $req->id) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="nf-btn nf-btn--access-on"
                            onclick="return confirm('Grant this clinic access to your medical profile again?')">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                                <line x1="12" y1="14" x2="12" y2="17" />
                            </svg>
                            Turn On Access
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="nf-empty" id="emptyRead">
            <div class="nf-empty__ico">📭</div>
            <div class="nf-empty__t">Nothing here yet</div>
            <div class="nf-empty__s">Your read notifications will appear here.</div>
        </div>
        @endforelse

        <div class="nf-empty" id="emptyRead" style="display:none">
            <div class="nf-empty__ico">📭</div>
            <div class="nf-empty__t">Nothing here yet</div>
            <div class="nf-empty__s">Your read notifications will appear here.</div>
        </div>
    </div>

</div>



<script>
    function nfTab(tab, btn) {
        document.querySelectorAll('.nf-tab').forEach(t => t.classList.remove('nf-tab--on'));
        btn.classList.add('nf-tab--on');
        document.getElementById('list-unread').style.display = tab === 'unread' ? 'flex' : 'none';
        document.getElementById('list-read').style.display = tab === 'read' ? 'flex' : 'none';
        nfFilter(document.getElementById('nfQ').value);
    }

    function nfFilter(q) {
        q = (q || '').toLowerCase().trim();
        document.getElementById('nfClearBtn').style.display = q ? 'flex' : 'none';
        document.querySelectorAll('.nf-card').forEach(c => {
            c.style.display = (!q || (c.dataset.s || '').includes(q)) ? '' : 'none';
        });
        chkEmpty('list-unread', 'emptyUnread');
        chkEmpty('list-read', 'emptyRead');
    }

    function nfClear() {
        document.getElementById('nfQ').value = '';
        nfFilter('');
    }

    function chkEmpty(lid, eid) {
        const l = document.getElementById(lid);
        const e = document.getElementById(eid);
        if (!l || !e) return;
        const v = [...l.querySelectorAll('.nf-card')].filter(c => c.style.display !== 'none');
        e.style.display = v.length ? 'none' : 'flex';
    }

    // Auto dismiss alerts
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nf-alert').forEach(function(el) {
            setTimeout(function() {
                el.style.transition = 'opacity .4s';
                el.style.opacity = '0';
                setTimeout(function() {
                    el.remove();
                }, 400);
            }, 5000);
        });
    });
</script>

@endsection