@extends('frontend.layout.app')

@section('title', $user->user_name . ' -Medical history - Doctorwala.info')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('./css/user-profile.css') }}">
    <style>
        .mh-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .mh-modal-overlay.active {
            display: flex;
        }

        .mh-modal {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 64px rgba(0, 0, 0, .18);
            animation: mhSlideUp .28s cubic-bezier(.34, 1.56, .64, 1);
        }

        @keyframes mhSlideUp {
            from {
                opacity: 0;
                transform: translateY(24px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Head */
        .mh-modal__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid #f0f0f0;
            flex-shrink: 0;
        }

        .mh-modal__title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .mh-modal__close {
            background: #f5f5f5;
            border: none;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #666;
            transition: background .15s;
        }

        .mh-modal__close:hover {
            background: #ffe0e0;
            color: #e53e3e;
        }

        /* Body */
        .mh-modal__body {
            padding: 22px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Form rows */
        .mh-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .mh-form-row--single {
            grid-template-columns: 1fr;
        }

        .mh-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .mh-field label {
            font-size: 12.5px;
            font-weight: 600;
            color: #444;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .mh-req {
            color: #e53e3e;
        }

        .mh-field input[type="text"],
        .mh-field input[type="date"],
        .mh-select-wrap select {
            border: 1.5px solid #e8e8e8;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #1a1a2e;
            background: #fafafa;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }

        .mh-field input:focus,
        .mh-select-wrap select:focus {
            border-color: #4f8ef7;
            box-shadow: 0 0 0 3px rgba(79, 142, 247, .12);
            background: #fff;
        }

        .mh-select-wrap {
            position: relative;
        }

        .mh-select-wrap select {
            appearance: none;
            padding-right: 36px;
            cursor: pointer;
        }

        .mh-select-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #888;
        }

        /* Upload Sources */
        .mh-upload-sources {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .mh-src-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 10px;
            border: 1.5px solid #e0e7ff;
            background: #f0f4ff;
            color: #3b5bdb;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .18s;
        }

        .mh-src-btn:hover {
            background: #3b5bdb;
            color: #fff;
            border-color: #3b5bdb;
        }

        .mh-src-btn--sm {
            padding: 7px 12px;
            font-size: 12px;
        }

        .mh-src-btn--cancel {
            background: #fff5f5;
            border-color: #fecaca;
            color: #e53e3e;
        }

        .mh-src-btn--cancel:hover {
            background: #e53e3e;
            color: #fff;
            border-color: #e53e3e;
        }

        /* Preview Grid */
        .mh-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 10px;
            margin-bottom: 10px;
        }

        .mh-preview-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 1;
            background: #f5f5f5;
            border: 2px solid #e8e8e8;
            animation: mhFadeIn .2s ease;
        }

        @keyframes mhFadeIn {
            from {
                opacity: 0;
                transform: scale(.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .mh-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mh-preview-item .mh-pdf-thumb {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            color: #e53e3e;
            font-size: 11px;
            font-weight: 600;
        }

        .mh-preview-item .mh-remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(0, 0, 0, .6);
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            line-height: 1;
            transition: background .15s;
        }

        .mh-preview-item .mh-remove-btn:hover {
            background: #e53e3e;
        }

        /* Add more */
        .mh-add-more {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            border: 1.5px dashed #b0c4ff;
            background: #f7f9ff;
            color: #3b5bdb;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .18s;
            margin-bottom: 8px;
        }

        .mh-add-more:hover {
            background: #e8edff;
        }

        .mh-upload-hint {
            font-size: 11.5px;
            color: #aaa;
            margin: 0;
        }

        /* Footer */
        .mh-modal__foot {
            padding: 16px 22px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-shrink: 0;
        }

        .mh-btn-cancel {
            padding: 10px 20px;
            border-radius: 10px;
            border: 1.5px solid #e8e8e8;
            background: #fff;
            color: #666;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
        }

        .mh-btn-cancel:hover {
            background: #f5f5f5;
        }

        .mh-btn-save {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 10px 22px;
            border-radius: 10px;
            border: none;
            background: #3b5bdb;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }

        .mh-btn-save:hover {
            background: #2f4ac4;
        }

        @media (max-width: 480px) {
            .mh-form-row {
                grid-template-columns: 1fr;
            }

            .mh-upload-sources {
                gap: 8px;
            }
        }

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
                <button class="up-hero__btn up-hero__btn--white" onclick="openMhModal()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Add medical Report or Prescription
                </button>
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
                    <div class="up-qstat up-qstat--mint">
                        <div class="up-qstat__ico">💊</div>
                        <div class="up-qstat__num">8</div>
                        <div class="up-qstat__lbl">Prescriptions</div>
                    </div>
                    <div class="up-qstat up-qstat--coral">
                        <div class="up-qstat__ico">📋</div>
                        <div class="up-qstat__num">5</div>
                        <div class="up-qstat__lbl">Reports</div>
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
                    <a href="{{route('dw.profile')}}" style="background:var(--p-lt);border:none;color:var(--p);border-radius:8px;padding:5px 10px;font-size:.7rem;font-weight:800;cursor:pointer;display:flex;align-items:center;gap:4px">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4z" />
                        </svg>
                        Edit
                    </a>
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

        </aside>


        <!-- ═══════════════ MAIN ═══════════════ -->
        <div class="up-main">

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
                        {{ Auth::user()->medical_card_no ?? 'DW** **** *01' }}
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

                    <a href="" class="up-med-card__btn up-med-card__btn--white" onclick="switchTab('history')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                        View Medical History
                    </a>
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

        </div><!-- end main -->

    </div><!-- end layout -->
</div><!-- end wrap -->


<!-- ════════════════════════════════
    ADD MEDICAL HISTORY MODAL
════════════════════════════════ -->
<div class="mh-modal-overlay" id="medicalHistoryModal" onclick="handleMhOverlayClick(event)">
    <div class="mh-modal">

        <div class="mh-modal__head">
            <div class="mh-modal__title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="12" y1="18" x2="12" y2="12" />
                    <line x1="9" y1="15" x2="15" y2="15" />
                </svg>
                Add Medical Report / Prescription
            </div>
            <button class="mh-modal__close" onclick="closeMhModal()" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <form action="{{ route('dw.medical-history.add') }}" method="POST" enctype="multipart/form-data" class="mh-modal__body" id="medicalHistoryForm">
            @csrf

            {{-- Hidden user ID --}}
            <input type="hidden" name="dw_user_id" value="{{ Auth::user()->id }}">

            {{-- Type --}}
            <div class="mh-form-row">
                <div class="mh-field">
                    <label>Type <span class="mh-req">*</span></label>
                    <div class="mh-select-wrap">
                        <select name="type" required>
                            <option value="" disabled selected>Select type</option>
                            <option value="report">Medical Report</option>
                            <option value="prescription">Prescription</option>
                        </select>
                        <svg class="mh-select-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </div>
                </div>

                {{-- Date --}}
                <div class="mh-field">
                    <label>Date of Report <span class="mh-req">*</span></label>
                    <input type="date" name="date_of_report" required max="{{ date('Y-m-d') }}">
                </div>
            </div>

            {{-- Heading --}}
            <div class="mh-form-row mh-form-row--single">
                <div class="mh-field">
                    <label>Heading / Title <span class="mh-req">*</span></label>
                    <input type="text" name="heading" placeholder="e.g. Blood Test Report – June 2025" required>
                </div>
            </div>

            {{-- Images Upload --}}
            <div class="mh-form-row mh-form-row--single">
                <div class="mh-field">
                    <label>Images <span class="mh-req">*</span></label>

                    {{-- Upload Source Buttons --}}
                    <div class="mh-upload-sources">
                        <button type="button" class="mh-src-btn" onclick="triggerMhInput('camera')" title="Take Photo">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                                <circle cx="12" cy="13" r="4" />
                            </svg>
                            Camera
                        </button>
                        <button type="button" class="mh-src-btn" onclick="triggerMhInput('gallery')" title="Choose from Gallery">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            Gallery
                        </button>
                        <button type="button" class="mh-src-btn" onclick="triggerMhInput('file')" title="Choose File">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z" />
                                <polyline points="13 2 13 9 20 9" />
                            </svg>
                            PDF File
                        </button>
                    </div>

                    {{-- Hidden file inputs --}}
                    <input type="file" id="mhInputCamera" name="images[]" accept="image/*" capture="environment" style="display:none;" onchange="handleMhFiles(this)">
                    <input type="file" id="mhInputGallery" name="images[]" accept="image/jpeg,image/png,image/webp" multiple style="display:none;" onchange="handleMhFiles(this)">
                    <input type="file" id="mhInputFile" name="images[]" accept="image/jpeg,image/png,image/webp,application/pdf" multiple style="display:none;" onchange="handleMhFiles(this)">

                    {{-- Preview Grid --}}
                    <div class="mh-preview-grid" id="mhPreviewGrid"></div>

                    {{-- Add More (shown after first upload) --}}
                    <button type="button" class="mh-add-more" id="mhAddMoreBtn" style="display:none;" onclick="showMhAddMoreOptions()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Add More Images
                    </button>

                    {{-- Add More Source picker (hidden by default) --}}
                    <div class="mh-upload-sources mh-add-more-sources" id="mhAddMoreSources" style="display:none;">
                        <button type="button" class="mh-src-btn mh-src-btn--sm" onclick="triggerMhInput('camera'); hideMhAddMoreOptions()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                                <circle cx="12" cy="13" r="4" />
                            </svg>Camera
                        </button>
                        <button type="button" class="mh-src-btn mh-src-btn--sm" onclick="triggerMhInput('gallery'); hideMhAddMoreOptions()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>Gallery
                        </button>
                        <button type="button" class="mh-src-btn mh-src-btn--sm" onclick="triggerMhInput('file'); hideMhAddMoreOptions()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z" />
                                <polyline points="13 2 13 9 20 9" />
                            </svg>File
                        </button>
                        <button type="button" class="mh-src-btn mh-src-btn--sm mh-src-btn--cancel" onclick="hideMhAddMoreOptions()">Cancel</button>
                    </div>

                    <p class="mh-upload-hint">Accepted: JPG, PNG, WEBP, PDF &mdash; max 5MB each</p>
                </div>
            </div>

            <div class="mh-modal__foot">
                <button type="button" class="mh-btn-cancel" onclick="closeMhModal()">Cancel</button>
                <button type="submit" class="mh-btn-save">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Save Record
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Holds all selected File objects across multiple picks
    let mhSelectedFiles = [];

    function openMhModal() {
        document.getElementById('medicalHistoryModal').classList.add('active');
    }

    function closeMhModal() {
        document.getElementById('medicalHistoryModal').classList.remove('active');
    }

    function handleMhOverlayClick(e) {
        if (e.target === document.getElementById('medicalHistoryModal')) closeMhModal();
    }

    function triggerMhInput(source) {
        const map = {
            camera: 'mhInputCamera',
            gallery: 'mhInputGallery',
            file: 'mhInputFile'
        };
        document.getElementById(map[source]).click();
    }

    function handleMhFiles(input) {
        const files = Array.from(input.files);
        files.forEach(file => {
            // Avoid exact duplicates by name+size
            const exists = mhSelectedFiles.some(f => f.name === file.name && f.size === file.size);
            if (!exists) mhSelectedFiles.push(file);
        });
        input.value = ''; // reset so same file can be re-picked if removed
        renderMhPreviews();
        syncMhFilesToForm();
    }

    function renderMhPreviews() {
        const grid = document.getElementById('mhPreviewGrid');
        grid.innerHTML = '';

        mhSelectedFiles.forEach((file, idx) => {
            const item = document.createElement('div');
            item.className = 'mh-preview-item';

            if (file.type === 'application/pdf') {
                item.innerHTML = `
                <div class="mh-pdf-thumb">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/>
                        <polyline points="14 2 14 9 20 9"/>
                    </svg>
                    PDF
                </div>
                <button type="button" class="mh-remove-btn" onclick="removeMhFile(${idx})">✕</button>`;
            } else {
                const url = URL.createObjectURL(file);
                item.innerHTML = `
                <img src="${url}" alt="Preview" onload="URL.revokeObjectURL(this.src)">
                <button type="button" class="mh-remove-btn" onclick="removeMhFile(${idx})">✕</button>`;
            }
            grid.appendChild(item);
        });

        const addMoreBtn = document.getElementById('mhAddMoreBtn');
        addMoreBtn.style.display = mhSelectedFiles.length > 0 ? 'flex' : 'none';
    }

    function removeMhFile(idx) {
        mhSelectedFiles.splice(idx, 1);
        renderMhPreviews();
        syncMhFilesToForm();
        if (mhSelectedFiles.length === 0) hideMhAddMoreOptions();
    }

    function syncMhFilesToForm() {
        // Build a fresh DataTransfer to attach all files to a single <input name="images[]">
        const dt = new DataTransfer();
        mhSelectedFiles.forEach(f => dt.items.add(f));

        // Use the gallery input as the canonical submission input
        const canonical = document.getElementById('mhInputGallery');
        canonical.files = dt.files;
        // Give it a stable name for the form
        canonical.name = 'images[]';
    }

    function showMhAddMoreOptions() {
        document.getElementById('mhAddMoreSources').style.display = 'flex';
        document.getElementById('mhAddMoreBtn').style.display = 'none';
    }

    function hideMhAddMoreOptions() {
        document.getElementById('mhAddMoreSources').style.display = 'none';
        if (mhSelectedFiles.length > 0)
            document.getElementById('mhAddMoreBtn').style.display = 'flex';
    }

    // Reset state when modal opens fresh
    function openMhModal() {
        mhSelectedFiles = [];
        renderMhPreviews();
        document.getElementById('medicalHistoryForm').reset();
        hideMhAddMoreOptions();
        document.getElementById('medicalHistoryModal').classList.add('active');
    }
</script>



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