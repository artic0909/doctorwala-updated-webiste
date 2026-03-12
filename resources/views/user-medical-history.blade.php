@extends('frontend.layout.app')

@section('title', $user->user_name . ' -Medical history - Doctorwala.info')

@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('./css/user-profile.css') }}">
        <style>
            .vm-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .52);
                backdrop-filter: blur(5px);
                z-index: 1000;
                align-items: center;
                justify-content: center;
                padding: 16px;
            }

            .vm-overlay.active {
                display: flex;
            }

            .vm-modal {
                background: #fff;
                border-radius: 18px;
                width: 100%;
                max-width: 520px;
                max-height: 92vh;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                box-shadow: 0 24px 72px rgba(0, 0, 0, .18);
                animation: vmUp .26s cubic-bezier(.34, 1.56, .64, 1);
            }

            @keyframes vmUp {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(.97);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            /* Head */
            .vm-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                border-bottom: 1.5px solid #f0f2f8;
                flex-shrink: 0;
            }

            .vm-title {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 15px;
                font-weight: 700;
                color: #1a1f36;
            }

            .vm-close {
                width: 30px;
                height: 30px;
                border-radius: 8px;
                border: none;
                background: #f5f5f5;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #666;
                transition: all .15s;
            }

            .vm-close:hover {
                background: #fee2e2;
                color: #e53e3e;
            }

            /* Body */
            .vm-body {
                padding: 20px;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
                gap: 14px;
            }

            /* Rows */
            .vm-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }

            .vm-row--single {
                grid-template-columns: 1fr;
            }

            /* Fields */
            .vm-field {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .vm-field label {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 11.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .05em;
                color: #555;
            }

            .vm-field label em {
                font-style: normal;
                font-weight: 400;
                color: #aaa;
                font-size: 10.5px;
                text-transform: none;
                letter-spacing: 0;
            }

            .vm-field__icon {
                width: 20px;
                height: 20px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .vm-field__icon--red {
                background: #fff0f0;
                color: #e53e3e;
            }

            .vm-field__icon--blue {
                background: #eff6ff;
                color: #2563eb;
            }

            .vm-field__icon--orange {
                background: #fff7ed;
                color: #ea580c;
            }

            .vm-field__icon--teal {
                background: #f0fdfa;
                color: #0d9488;
            }

            .vm-field__icon--purple {
                background: #faf5ff;
                color: #9333ea;
            }

            .vm-field__icon--green {
                background: #f0fdf4;
                color: #16a34a;
            }

            .vm-field input[type="text"],
            .vm-field input[type="number"] {
                border: 1.5px solid #e8ecf4;
                border-radius: 10px;
                padding: 10px 13px;
                font-size: 14px;
                color: #1a1f36;
                background: #fafbff;
                outline: none;
                transition: border-color .18s, box-shadow .18s;
                width: 100%;
                -moz-appearance: textfield;
            }

            .vm-field input::-webkit-outer-spin-button,
            .vm-field input::-webkit-inner-spin-button {
                -webkit-appearance: none;
            }

            .vm-field input:focus {
                border-color: #4361ee;
                box-shadow: 0 0 0 3px rgba(67, 97, 238, .12);
                background: #fff;
            }

            .vm-field input[readonly] {
                background: #f7f9ff;
                color: #4361ee;
                font-weight: 600;
                cursor: default;
            }

            .vm-select-wrap {
                position: relative;
            }

            .vm-select-wrap select {
                width: 100%;
                padding: 10px 34px 10px 13px;
                border: 1.5px solid #e8ecf4;
                border-radius: 10px;
                background: #fafbff;
                font-size: 14px;
                color: #1a1f36;
                appearance: none;
                outline: none;
                cursor: pointer;
                transition: border-color .18s;
            }

            .vm-select-wrap select:focus {
                border-color: #4361ee;
            }

            .vm-select-wrap>svg {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                pointer-events: none;
                color: #888;
            }

            /* BMI */
            .vm-bmi-wrap {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .vm-bmi-wrap input {
                flex: 1;
            }

            .vm-bmi-tag {
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 11.5px;
                font-weight: 700;
                white-space: nowrap;
                display: none;
            }

            .vm-bmi-tag.underweight {
                display: inline-flex;
                background: #eff6ff;
                color: #2563eb;
            }

            .vm-bmi-tag.normal {
                display: inline-flex;
                background: #f0fdf4;
                color: #16a34a;
            }

            .vm-bmi-tag.overweight {
                display: inline-flex;
                background: #fff7ed;
                color: #ea580c;
            }

            .vm-bmi-tag.obese {
                display: inline-flex;
                background: #fff0f0;
                color: #e53e3e;
            }

            /* Footer */
            .vm-foot {
                padding: 14px 20px;
                border-top: 1.5px solid #f0f2f8;
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                flex-shrink: 0;
            }

            .vm-btn-cancel {
                padding: 9px 18px;
                border-radius: 10px;
                border: 1.5px solid #e8ecf4;
                background: #fff;
                color: #666;
                font-size: 13.5px;
                font-weight: 500;
                cursor: pointer;
                transition: background .14s;
            }

            .vm-btn-cancel:hover {
                background: #f5f5f5;
            }

            .vm-btn-save {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 9px 20px;
                border-radius: 10px;
                border: none;
                background: #4361ee;
                color: #fff;
                font-size: 13.5px;
                font-weight: 600;
                cursor: pointer;
                transition: background .14s;
            }

            .vm-btn-save:hover {
                background: #3451d1;
            }

            @media (max-width: 768px) {
                .mht-table-wrap {
                    display: none;
                }

                .mht-mobile-cards {
                    display: flex;
                    flex-direction: column;
                    gap: 16px;
                    margin-top: 20px;
                }

                .mht-card {
                    background: #fff;
                    border-radius: 16px;
                    padding: 18px;
                    border: 1px solid #eef2ff;
                    box-shadow: 0 4px 12px rgba(67, 97, 238, 0.05);
                    animation: mhtRowIn .3s ease both;
                }

                .mht-card-top {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 12px;
                }

                .mht-card-heading {
                    margin-bottom: 0px;
                }

                .mht-card-meta {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }

                .mht-card-actions {
                    display: flex;
                    justify-content: flex-end;
                    gap: 12px;
                    margin-top: 0;
                    padding-top: 0;
                    border-top: none;
                }

                /* Optimize Vitals Grid for Mobile */
                .up-vitals {
                    grid-template-columns: repeat(2, 1fr) !important;
                    gap: 12px !important;
                    padding: 0 16px 24px !important;
                }

                .up-vital {
                    padding: 15px 10px !important;
                    height: auto !important;
                }

                .up-vital__ico {
                    font-size: 1.2rem !important;
                    margin-bottom: 6px !important;
                }

                .up-vital__val {
                    font-size: 1.1rem !important;
                }

                .up-vital__unit {
                    font-size: 0.6rem !important;
                }

                .up-vital__lbl {
                    font-size: 0.65rem !important;
                }

                .up-hero__btn {
                    padding: 9px 12px !important;
                    font-size: 0.72rem !important;
                    width: 100%;
                    justify-content: center;
                }
            }

            @media (min-width: 769px) {
                .mht-mobile-cards {
                    display: none;
                }
            }
            @media (max-width: 460px) {
                .vm-row {
                    grid-template-columns: 1fr;
                }
            }

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

            /* ── Wrap ── */
            .mht-wrap {
                font-family: 'Outfit', 'Segoe UI', sans-serif;
                display: flex;
                flex-direction: column;
                gap: 0;
            }

            /* ── Header ── */
            .mht-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 18px 0 14px;
                border-bottom: 2px solid #f0f2f8;
                margin-bottom: 0;
            }

            .mht-header__left {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 15px;
                font-weight: 700;
                color: #1a1f36;
            }

            .mht-header__count {
                background: #eef2ff;
                color: #4361ee;
                font-size: 11px;
                font-weight: 600;
                padding: 2px 8px;
                border-radius: 20px;
            }

            .mht-add-btn {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 9px 16px;
                border-radius: 10px;
                border: none;
                background: #4361ee;
                color: #fff;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                transition: background .15s, transform .12s;
            }

            .mht-add-btn:hover {
                background: #3451d1;
                transform: translateY(-1px);
            }

            /* ── Alert ── */
            .mht-alert {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 14px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 500;
                margin-top: 12px;
            }

            .mht-alert--success {
                background: #ecfdf5;
                color: #059669;
                border: 1px solid #a7f3d0;
            }

            /* ── Table wrap ── */
            .mht-table-wrap {
                width: 100%;
                overflow-x: auto;
                border-radius: 14px;
                border: 1.5px solid #f0f2f8;
                margin-top: 16px;
                box-shadow: 0 2px 20px rgba(67, 97, 238, .06);
            }

            /* ── Table ── */
            .mht-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13.5px;
                color: #2d3148;
            }

            .mht-table thead tr {
                background: #f7f9ff;
                border-bottom: 1.5px solid #e8ecf8;
            }

            .mht-table th {
                padding: 13px 16px;
                text-align: left;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .06em;
                color: #8892b0;
                white-space: nowrap;
            }

            .mht-row {
                border-bottom: 1px solid #f4f5fb;
                transition: background .14s;
                animation: mhtRowIn .3s ease both;
                animation-delay: var(--row-delay, 0ms);
            }

            @keyframes mhtRowIn {
                from {
                    opacity: 0;
                    transform: translateY(6px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .mht-row:last-child {
                border-bottom: none;
            }

            .mht-row:hover {
                background: #f7f9ff;
            }

            .mht-table td {
                padding: 13px 16px;
                vertical-align: middle;
            }

            .mht-td--num {
                color: #b0b8d0;
                font-weight: 600;
                font-size: 12px;
                width: 40px;
            }

            .mht-td--heading {
                padding: 16px !important;
                max-width: 300px;
            }

            .mht-heading-val {
                display: block;
                font-size: 14px;
                font-weight: 700;
                color: #1a1f36;
                margin-bottom: 6px;
                text-transform: capitalize;
            }

            .mht-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                margin-top: 4px;
            }

            .mht-tag {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 3px 10px;
                border-radius: 6px;
                font-size: 11px;
                font-weight: 600;
                white-space: nowrap;
                border: 1px solid transparent;
            }

            .mht-tag--clinic {
                background: #fff1f2;
                color: #e11d48;
                border-color: #fecaca;
            }

            .mht-tag--doctor {
                background: #eff6ff;
                color: #2563eb;
                border-color: #bfdbfe;
            }

            .mht-td--date {
                display: flex;
                align-items: center;
                gap: 5px;
                color: #5a6282;
                white-space: nowrap;
                font-size: 13px;
            }

            /* ── Badges ── */
            .mht-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 11.5px;
                font-weight: 600;
                white-space: nowrap;
            }

            .mht-badge--report {
                background: #eff6ff;
                color: #2563eb;
            }

            .mht-badge--prescription {
                background: #fdf4ff;
                color: #9333ea;
            }

            /* ── Files pill ── */
            .mht-files-pill {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 10px;
                border-radius: 20px;
                background: #f0fdf4;
                color: #16a34a;
                font-size: 12px;
                font-weight: 600;
                text-decoration: none;
                border: 1px solid #bbf7d0;
                transition: background .14s;
            }

            .mht-files-pill:hover {
                background: #dcfce7;
            }

            .mht-no-files {
                color: #cbd5e1;
                font-size: 13px;
            }

            /* ── Action buttons ── */
            .mht-td--actions {
                display: flex;
                gap: 6px;
                align-items: center;
            }

            .mht-action-btn {
                width: 30px;
                height: 30px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all .15s;
            }

            .mht-action-btn--edit {
                background: #eef2ff;
                color: #4361ee;
            }

            .mht-action-btn--edit:hover {
                background: #4361ee;
                color: #fff;
            }

            .mht-action-btn--del {
                background: #fff1f1;
                color: #e53e3e;
            }

            .mht-action-btn--del:hover {
                background: #e53e3e;
                color: #fff;
            }

            /* ── Empty ── */
            .mht-empty {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 10px;
                padding: 56px 24px;
                color: #c0c8e0;
            }

            .mht-empty p {
                font-size: 14px;
                margin: 0;
            }

            /* ── Pagination ── */
            .mht-pagination {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 4px;
                padding: 18px 0 4px;
                flex-wrap: wrap;
            }

            .mht-page-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 34px;
                height: 34px;
                padding: 0 10px;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                color: #5a6282;
                background: #f7f9ff;
                border: 1.5px solid #e8ecf8;
                text-decoration: none;
                transition: all .15s;
                cursor: pointer;
            }

            .mht-page-btn:hover {
                background: #eef2ff;
                border-color: #c7d2fe;
                color: #4361ee;
            }

            .mht-page-btn--active {
                background: #4361ee;
                color: #fff;
                border-color: #4361ee;
                cursor: default;
                box-shadow: 0 2px 10px rgba(67, 97, 238, .3);
            }

            .mht-page-btn--disabled {
                opacity: .38;
                cursor: default;
                pointer-events: none;
            }

            .mht-page-ellipsis {
                color: #b0b8d0;
                font-size: 14px;
                padding: 0 4px;
            }

            /* ── Responsive ── */
            @media (max-width: 640px) {

                .mht-table th:nth-child(4),
                .mht-table td:nth-child(4) {
                    display: none;
                }

                /* hide date on tiny screens */
                .mht-td--heading {
                    max-width: 120px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                .mht-header__left span.mht-header__count {
                    display: none;
                }
            }

            /* ── TABS ── */
            .mht-tabs {
                display: flex;
                gap: 12px;
                margin-bottom: 0;
                border-bottom: 2px solid #f0f2f8;
                padding-bottom: 0;
                overflow-x: auto;
                scrollbar-width: none;
            }
            .mht-tabs::-webkit-scrollbar { display: none; }
            .mht-tab {
                padding: 12px 20px;
                font-size: 14px;
                font-weight: 600;
                color: #64748b;
                cursor: pointer;
                border-bottom: 3px solid transparent;
                transition: all 0.2s;
                white-space: nowrap;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .mht-tab:hover { color: #4361ee; background: #f8fafc; }
            .mht-tab.active {
                color: #4361ee;
                border-bottom-color: #4361ee;
            }
            .tab-content { display: none; width: 100%; animation: mhtFadeIn 0.3s ease; }
            .tab-content.active { display: block; }

            @keyframes mhtFadeIn {
                from { opacity: 0; transform: translateY(5px); }
                to { opacity: 1; transform: translateY(0); }
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
                            @if(Auth::user()->image ?? null)
                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                    alt="{{ Auth::user()->user_name ?? '' }}">
                            @else
                                {{ strtoupper(substr(Auth::user()->user_name ?? 'U', 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->user_name ?? '', ' '), 1, 1)) }}
                            @endif
                        </div>
                        <span class="up-hero__status-dot"></span>
                    </div>
                    <div class="up-hero__info">
                        <h1 class="up-hero__name" style="text-transform: capitalize;">{{ Auth::user()->user_name ?? '—' }}
                        </h1>
                        <p class="up-hero__email">{{ Auth::user()->user_email ?? '—' }}</p>
                        <div class="up-hero__badges">
                            <span class="up-hero__badge">
                                <span class="dot" style="background-color: red"></span> Not Verified
                            </span>
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
                <div class="up-card">
                    <div class="up-card__head">
                        <div class="up-card__title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                            Health Overview
                        </div>
                    </div>
                    <div class="up-qstat-grid">

                        <div class="up-qstat up-qstat--mint">
                            <div class="up-qstat__ico">💊</div>
                            <div class="up-qstat__num">{{ $noOfPrescription ?? 0 }}</div>
                            <div class="up-qstat__lbl">Prescriptions</div>
                        </div>

                        <div class="up-qstat up-qstat--coral">
                            <div class="up-qstat__ico">📋</div>
                            <div class="up-qstat__num">{{ $noOfReport ?? 0 }}</div>
                            <div class="up-qstat__lbl">Reports</div>
                        </div>

                        <button class="up-qstat up-qstat--coral" style="border:none;" onclick="openVitalsModal()">
                            <div class="up-qstat__num">Add Vitals</div>
                        </button>

                        @if($vital ?? null)
                                            <button class="up-qstat up-qstat--mint" style="border:none;" onclick="openEditVitalsModal({{ Js::from([
                                'id' => $vital->id,
                                'heart_rate' => $vital->heart_rate,
                                'blood_pressure' => $vital->blood_pressure,
                                'temparature' => $vital->temparature,
                                'spo' => $vital->spo,
                                'blood_sugar' => $vital->blood_sugar,
                                'weight' => $vital->weight,
                                'height' => $vital->height,
                                'bmi' => $vital->bmi,
                                'blood_group' => $vital->blood_group,
                            ]) }})">
                                                <div class="up-qstat__num">Edit Vitals</div>
                                            </button>
                        @else
                            <button class="up-qstat up-qstat--mint" style="border:none;opacity:.45;cursor:not-allowed;"
                                disabled>
                                <div class="up-qstat__num">Edit Vitals</div>
                            </button>
                        @endif

                    </div>
                </div>
            </aside>


            <!-- ═══════════════ MAIN ═══════════════ -->
            <div class="up-main">

                <div class="mht-wrap">

                    {{-- ── Flash messages ── --}}
                    @if(session('success'))
                        <div class="mht-alert mht-alert--success">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ── TABS ── --}}
                    <div class="mht-tabs" style="margin-top: 20px;">
                        <div class="mht-tab active" onclick="switchTab(event, 'uploaded')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            Uploaded Records
                        </div>
                        <div class="mht-tab" onclick="switchTab(event, 'generated')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                            Generated Prescription
                        </div>
                    </div>

                    {{-- ── TAB 1: Uploaded ── --}}
                    <div id="uploadedRecords" class="tab-content active">
                    <div class="mht-table-wrap">
                        @if(isset($histories) && $histories->count())
                            <table class="mht-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Heading</th>
                                        <th>Date</th>
                                        <th>Files</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($histories as $i => $rec)
                                        <tr class="mht-row" style="--row-delay:{{ $i * 40 }}ms">

                                            <td class="mht-td--num">{{ $histories->firstItem() + $i }}</td>

                                            <td>
                                                <span class="mht-badge mht-badge--{{ $rec->type ?? 'report' }}">
                                                    @if(($rec->type ?? '') === 'report')
                                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5">
                                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                                            <polyline points="14 2 14 8 20 8" />
                                                        </svg>
                                                        Report
                                                    @else
                                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5">
                                                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                                            <polyline points="9 22 9 12 15 12 15 22" />
                                                        </svg>
                                                        Prescription
                                                    @endif
                                                </span>
                                            </td>

                                            <td class="mht-td--heading">
                                                <span class="mht-heading-val">{{ $rec->heading ?? '—' }}</span>
                                                <div class="mht-tags">
                                                    @if(!empty($rec->opd->partner_clinic_name))
                                                        <span class="mht-tag mht-tag--clinic">
                                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                                                <polyline points="9 22 9 12 15 12 15 22" />
                                                            </svg>
                                                            {{ $rec->opd->partner_clinic_name }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($rec->doctor->doctor_name))
                                                        <span class="mht-tag mht-tag--doctor">
                                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                                <circle cx="12" cy="7" r="4" />
                                                            </svg>
                                                            {{ $rec->doctor->doctor_name }} 
                                                            <span style="opacity:0.7; font-weight:400; margin-left:2px;">({{ $rec->doctor->doctor_specialist ?? 'Gen.' }})</span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="mht-td--date">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                                    <line x1="16" y1="2" x2="16" y2="6" />
                                                    <line x1="8" y1="2" x2="8" y2="6" />
                                                    <line x1="3" y1="10" x2="21" y2="10" />
                                                </svg>
                                                {{ $rec->date_of_report ? \Carbon\Carbon::parse($rec->date_of_report)->format('d M Y') : '—' }}
                                            </td>

                                            <td class="mht-td--files">
                                                @if(($rec->images ?? null) && count($rec->images))
                                                    <a href="{{ route('dw.medical-history.view', $rec->id) }}" class="mht-files-pill"
                                                        title="View {{ count($rec->images) }} file(s)">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2">
                                                            <path
                                                                d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48" />
                                                        </svg>
                                                        {{ count($rec->images) }} file{{ count($rec->images) > 1 ? 's' : '' }}
                                                    </a>
                                                @else
                                                    <span class="mht-no-files">—</span>
                                                @endif
                                            </td>

                                            <td class="mht-td--actions">
                                                <button class="mht-action-btn mht-action-btn--edit" onclick="openEditMhModal(
                                                                                {{ $rec->id }},
                                                                                '{{ $rec->type ?? '' }}',
                                                                                '{{ $rec->date_of_report ? \Carbon\Carbon::parse($rec->date_of_report)->format('Y-m-d') : '' }}',
                                                                                '{{ htmlspecialchars(addslashes($rec->heading ?? ''), ENT_QUOTES) }}',
                                                                                {{ Js::from($rec->images ?? []) }}
                                                                            )" title="Edit">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </button>

                                                <form action="{{ route('dw.medical-history.destroy', $rec->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this record?')" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="mht-action-btn mht-action-btn--del" title="Delete">
                                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5">
                                                            <polyline points="3 6 5 6 21 6" />
                                                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                                            <path d="M10 11v6M14 11v6" />
                                                            <path d="M9 6V4h6v2" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="mht-empty">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.2">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                <p>No medical records yet.</p>
                                <button onclick="openMhModal()" class="mht-add-btn">Add your first record</button>
                            </div>
                        @endif
                    </div>

                    {{-- ── Pagination ── --}}
                    {{-- ── Mobile Cards (Visible only on <768px) ── --}}
                    <div class="mht-mobile-cards">
                        @if(isset($histories) && $histories->count())
                            @foreach($histories as $i => $rec)
                                <div class="mht-card" style="--row-delay:{{ $i * 40 }}ms">
                                    <div class="mht-card-top">
                                        <span class="mht-badge mht-badge--{{ $rec->type ?? 'report' }}">
                                            @if(($rec->type ?? '') === 'report')
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                                    <polyline points="14 2 14 8 20 8" />
                                                </svg> Report
                                            @else
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                                    <polyline points="9 22 9 12 15 12 15 22" />
                                                </svg> Prescription
                                            @endif
                                        </span>
                                        <div class="mht-td--date">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                                <line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" />
                                            </svg>
                                            {{ $rec->date_of_report ? \Carbon\Carbon::parse($rec->date_of_report)->format('d M Y') : '—' }}
                                        </div>
                                    </div>

                                    <div class="mht-card-heading">
                                        <span class="mht-heading-val">{{ $rec->heading ?? '—' }}</span>
                                        <div class="mht-tags">
                                            @if(!empty($rec->opd->partner_clinic_name))
                                                <span class="mht-tag mht-tag--clinic">
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /><polyline points="9 22 9 12 15 12 15 22" />
                                                    </svg>
                                                    {{ $rec->opd->partner_clinic_name }}
                                                </span>
                                            @endif
                                            @if(!empty($rec->doctor->doctor_name))
                                                <span class="mht-tag mht-tag--doctor">
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" /><circle cx="12" cy="7" r="4" />
                                                    </svg>
                                                    {{ $rec->doctor->doctor_name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mht-card-bottom" style="display:flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                        <div class="mht-td--files">
                                            @if(($rec->images ?? null) && count($rec->images))
                                                <a href="{{ route('dw.medical-history.view', $rec->id) }}" class="mht-files-pill">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48" />
                                                    </svg>
                                                    {{ count($rec->images) }} file{{ count($rec->images) > 1 ? 's' : '' }}
                                                </a>
                                            @else
                                                <span class="mht-no-files">— No Files</span>
                                            @endif
                                        </div>

                                        <div class="mht-card-actions" style="margin-top:0; padding-top:0; border:none;">
                                            <button class="mht-action-btn mht-action-btn--edit" onclick="openEditMhModal({{ $rec->id }},'{{ $rec->type ?? '' }}','{{ $rec->date_of_report ? \Carbon\Carbon::parse($rec->date_of_report)->format('Y-m-d') : '' }}','{{ htmlspecialchars(addslashes($rec->heading ?? ''), ENT_QUOTES) }}',{{ Js::from($rec->images ?? []) }})" title="Edit">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" /><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>

                                            <form action="{{ route('dw.medical-history.destroy', $rec->id) }}" method="POST" onsubmit="return confirm('Delete this record?')" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="mht-action-btn mht-action-btn--del" title="Delete">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                        <polyline points="3 6 5 6 21 6" /><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" /><path d="M10 11v6M14 11v6" /><path d="M9 6V4h6v2" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @if(isset($histories) && $histories->lastPage() > 1)
                        <div class="mht-pagination">
                            @if($histories->onFirstPage())
                                <span class="mht-page-btn mht-page-btn--disabled">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="15 18 9 12 15 6" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $histories->previousPageUrl() }}" class="mht-page-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="15 18 9 12 15 6" />
                                    </svg>
                                </a>
                            @endif

                            @php
                                $current = $histories->currentPage();
                                $last = $histories->lastPage();
                                $pages = [];
                                $pages[] = 1;
                                if ($current > 4)
                                    $pages[] = '...';
                                for ($p = max(2, $current - 1); $p <= min($last - 1, $current + 1); $p++)
                                    $pages[] = $p;
                                if ($current < $last - 3)
                                    $pages[] = '...';
                                if ($last > 1)
                                    $pages[] = $last;
                            @endphp

                            @foreach($pages as $page)
                                @if($page === '...')
                                    <span class="mht-page-ellipsis">…</span>
                                @elseif($page == $current)
                                    <span class="mht-page-btn mht-page-btn--active">{{ $page }}</span>
                                @else
                                    <a href="{{ $histories->url($page) }}" class="mht-page-btn">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($histories->hasMorePages())
                                <a href="{{ $histories->nextPageUrl() }}" class="mht-page-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="9 18 15 12 9 6" />
                                    </svg>
                                </a>
                            @else
                                <span class="mht-page-btn mht-page-btn--disabled">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="9 18 15 12 9 6" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                    @endif
                    </div>{{-- end uploadedRecords tab --}}

                    {{-- ── TAB 2: Generated ── --}}
                    <div id="generatedRecords" class="tab-content">
                        <div class="mht-table-wrap">
                            @if(isset($systemPrescriptions) && $systemPrescriptions->count())
                                <table class="mht-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Doctor Name</th>
                                            <th>Date</th>
                                            <th>Vitals</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($systemPrescriptions as $i => $rec)
                                            <tr class="mht-row" style="--row-delay:{{ $i * 40 }}ms">
                                                <td class="mht-td--num">{{ $i + 1 }}</td>
                                                <td>
                                                    <span class="mht-badge mht-badge--prescription">
                                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                                                        Digital
                                                    </span>
                                                </td>
                                                <td class="mht-td--heading">
                                                    Dr. {{ $rec->doctor_name ?? 'N/A' }}
                                                </td>
                                                <td class="mht-td--date">
                                                    {{ \Carbon\Carbon::parse($rec->prescription_date)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    <div style="font-size: 11px; color: #64748b;">
                                                        BP: {{ $rec->bp ?? '-' }} | SpO2: {{ $rec->spo2 ?? '-' }}
                                                    </div>
                                                </td>
                                                <td class="mht-td--actions">
                                                    <a href="{{ route('dw.digital.prescription.view', $rec->id) }}" target="_blank" class="mht-files-pill" style="background: #2563eb; color: #fff; border-color: #2563eb; text-decoration: none;">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="mht-empty">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <p>No system generated prescriptions available yet.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Mobile Cards for Generated --}}
                        <div class="mht-mobile-cards">
                            @if(isset($systemPrescriptions) && $systemPrescriptions->count())
                                @foreach($systemPrescriptions as $rec)
                                    <div class="mht-card">
                                        <div class="mht-card-top">
                                            <div class="mht-card-heading">Dr. {{ $rec->doctor_name }}</div>
                                            <span class="mht-badge mht-badge--prescription">Digital</span>
                                        </div>
                                        <div class="mht-card-meta">
                                            <div class="mht-card-info-item">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" /></svg>
                                                {{ \Carbon\Carbon::parse($rec->prescription_date)->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div class="mht-card-actions">
                                            <a href="{{ route('dw.digital.prescription.view', $rec->id) }}" target="_blank" class="mht-files-pill" style="background: #2563eb; color: #fff; width: 100%; justify-content: center; text-decoration: none;">Download PDF</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>{{-- end generatedRecords tab --}}
                </div>


                <!-- ════════════════ EDIT MEDICAL RECORD MODAL ════════════════ -->
                <div class="mh-modal-overlay" id="editMhModal" onclick="handleEditMhOverlay(event)">
                    <div class="mh-modal">
                        <div class="mh-modal__head">
                            <div class="mh-modal__title">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit Medical Record
                            </div>
                            <button class="mh-modal__close" onclick="closeEditMhModal()" type="button">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        <form id="editMhForm" action="" method="POST" enctype="multipart/form-data" class="mh-modal__body">
                            @csrf @method('PUT')
                            <input type="hidden" name="dw_user_id" value="{{ Auth::user()->id ?? '' }}">
                            <div id="editDeletedImagesInputs"></div>

                            <div class="mh-form-row">
                                <div class="mh-field">
                                    <label>Type <span class="mh-req">*</span></label>
                                    <div class="mh-select-wrap">
                                        <select name="type" id="editMhType" required>
                                            <option value="report">Medical Report</option>
                                            <option value="prescription">Prescription</option>
                                        </select>
                                        <svg class="mh-select-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mh-field">
                                    <label>Date of Report <span class="mh-req">*</span></label>
                                    <input type="date" name="date_of_report" id="editMhDate" required
                                        max="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="mh-form-row mh-form-row--single">
                                <div class="mh-field">
                                    <label>Heading / Title <span class="mh-req">*</span></label>
                                    <input type="text" name="heading" id="editMhHeading"
                                        placeholder="e.g. Blood Test Report" required>
                                </div>
                            </div>

                            <div class="mh-form-row mh-form-row--single">
                                <div class="mh-field">
                                    <label>Existing Files <span style="font-weight:400;color:#aaa;font-size:11px;"> — click
                                            ✕ to remove</span></label>
                                    <div class="mh-preview-grid" id="editExistingGrid"></div>
                                    <p class="mh-upload-hint" id="editNoExistingMsg" style="display:none;">No existing
                                        files.</p>
                                </div>
                            </div>

                            <div class="mh-form-row mh-form-row--single">
                                <div class="mh-field">
                                    <label>Add More Files <span
                                            style="font-weight:400;color:#999;">(optional)</span></label>
                                    <div class="mh-upload-sources">
                                        <button type="button" class="mh-src-btn" onclick="triggerEditInput('camera')">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                                                <circle cx="12" cy="13" r="4" />
                                            </svg>
                                            Camera
                                        </button>
                                        <button type="button" class="mh-src-btn" onclick="triggerEditInput('gallery')">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                                <circle cx="8.5" cy="8.5" r="1.5" />
                                                <polyline points="21 15 16 10 5 21" />
                                            </svg>
                                            Gallery
                                        </button>
                                        <button type="button" class="mh-src-btn" onclick="triggerEditInput('file')">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z" />
                                                <polyline points="13 2 13 9 20 9" />
                                            </svg>
                                            File
                                        </button>
                                    </div>
                                    <input type="file" id="editInputCamera" name="new_images[]" accept="image/*"
                                        capture="environment" style="display:none;" onchange="handleEditFiles(this)">
                                    <input type="file" id="editInputGallery" name="new_images[]"
                                        accept="image/jpeg,image/png,image/webp" multiple style="display:none;"
                                        onchange="handleEditFiles(this)">
                                    <input type="file" id="editInputFile" name="new_images[]"
                                        accept="image/jpeg,image/png,image/webp,application/pdf" multiple
                                        style="display:none;" onchange="handleEditFiles(this)">
                                    <div class="mh-preview-grid" id="editNewPreviewGrid"></div>
                                    <p class="mh-upload-hint">Accepted: JPG, PNG, WEBP, PDF — max 5MB each</p>
                                </div>
                            </div>

                            <div class="mh-modal__foot">
                                <button type="button" class="mh-btn-cancel" onclick="closeEditMhModal()">Cancel</button>
                                <button type="submit" class="mh-btn-save">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                    Update Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- ════════════════ VITALS SECTION ════════════════ -->
                <div class="up-card">
                    <div class="up-card__head">
                        <div class="up-card__title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                            Latest Vitals
                        </div>
                        <span style="font-size:.7rem;color:var(--muted);font-weight:700">
                            Updated:
                            {{ ($vital && $vital->updated_at) ? \Carbon\Carbon::parse($vital->updated_at)->format('d M Y') : 'N/A' }}
                        </span>
                    </div>

                    @if($vital ?? null)
                        <div class="up-vitals">

                            <div class="up-vital up-qstat--coral" style="border-color:#fed7aa">
                                <div class="up-vital__ico">🔴</div>
                                <div class="up-vital__val" style="color:#c2410c">{{ $vital->blood_group ?? '—' }}</div>
                                <div class="up-vital__unit">Blood Type</div>
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
                                    @if($vital->bmi ?? null)
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
                    @else
                        <div style="padding:28px 20px;text-align:center;color:#94a3b8;font-size:13.5px;">
                            No vitals recorded yet. Click <strong>Add Vitals</strong> to get started.
                        </div>
                    @endif
                </div>

            </div><!-- end main -->
        </div><!-- end layout -->
    </div><!-- end wrap -->


    <!-- ════════════════════════════════════════════════
                 ADD VITALS MODAL
            ════════════════════════════════════════════════ -->
    <div class="vm-overlay" id="vitalsModal" onclick="handleVmOverlay(event)">
        <div class="vm-modal">
            <div class="vm-head">
                <div class="vm-title">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Add Vitals
                </div>
                <button class="vm-close" onclick="closeVitalsModal()" type="button">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('dw.vitals.add') }}" method="POST" class="vm-body">
                @csrf
                <input type="hidden" name="dw_user_id" value="{{ Auth::id() ?? '' }}">

                <div class="vm-row">
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                            </span>
                            Heart Rate <em>bpm</em>
                        </label>
                        <input type="number" name="heart_rate" placeholder="e.g. 72" min="30" max="250">
                    </div>
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--blue">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg>
                            </span>
                            Blood Pressure <em>mmHg</em>
                        </label>
                        <input type="text" name="blood_pressure" placeholder="e.g. 120/80" required>
                    </div>
                </div>

                <div class="vm-row">
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--orange">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M14 14.76V3.5a2.5 2.5 0 00-5 0v11.26a4.5 4.5 0 105 0z" />
                                </svg>
                            </span>
                            Temperature <em>°C</em>
                        </label>
                        <input type="number" name="temparature" placeholder="e.g. 36.6" step="0.1" min="30" required>
                    </div>
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--teal">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path d="M12 22a10 10 0 110-20 10 10 0 010 20z" />
                                    <path d="M12 8v4l3 3" />
                                </svg>
                            </span>
                            SpO₂ <em>%</em>
                        </label>
                        <input type="number" name="spo" placeholder="e.g. 98" min="50" max="100" required>
                    </div>
                </div>

                <div class="vm-row">
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--purple">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <ellipse cx="12" cy="5" rx="9" ry="3" />
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                                </svg>
                            </span>
                            Blood Sugar <em>mg/dL</em>
                        </label>
                        <input type="number" name="blood_sugar" placeholder="e.g. 90" min="20" max="600" required>
                    </div>
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--red">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg>
                            </span>
                            Blood Group
                        </label>
                        <div class="vm-select-wrap">
                            <select name="blood_group" required>
                                <option value="" disabled selected>Choose</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                    <option value="{{ $bg }}" {{ (Auth::user()->blood_group ?? '') == $bg ? 'selected' : '' }}>
                                        {{ $bg }}
                                    </option>
                                @endforeach
                            </select>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="vm-row">
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--green">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <line x1="12" y1="2" x2="12" y2="22" />
                                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                                </svg>
                            </span>
                            Weight <em>kg</em>
                        </label>
                        <input type="number" name="weight" id="vmWeight" placeholder="e.g. 70" step="0.1" min="1" max="300"
                            oninput="calcVmBmi()" required>
                    </div>
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--blue">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <line x1="12" y1="2" x2="12" y2="22" />
                                    <line x1="2" y1="12" x2="22" y2="12" />
                                </svg>
                            </span>
                            Height <em>cm</em>
                        </label>
                        <input type="number" name="height" id="vmHeight" placeholder="e.g. 170" step="0.1" min="50"
                            max="300" oninput="calcVmBmi()" required>
                    </div>
                </div>

                <div class="vm-row vm-row--single">
                    <div class="vm-field">
                        <label>
                            <span class="vm-field__icon vm-field__icon--teal">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                            </span>
                            BMI <em>auto-calculated</em>
                        </label>
                        <div class="vm-bmi-wrap">
                            <input type="text" name="bmi" id="vmBmi" placeholder="Fill weight & height above" readonly>
                            <span class="vm-bmi-tag" id="vmBmiTag"></span>
                        </div>
                    </div>
                </div>

                <div class="vm-foot">
                    <button type="button" class="vm-btn-cancel" onclick="closeVitalsModal()">Cancel</button>
                    <button type="submit" class="vm-btn-save">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Save Vitals
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- ════════════════════════════════════════════════
                 EDIT VITALS MODAL
            ════════════════════════════════════════════════ -->
    <div class="vm-overlay" id="editVitalsModal" onclick="handleEditVmOverlay(event)">
        <div class="vm-modal">
            <div class="vm-head">
                <div class="vm-title">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Edit Vitals
                </div>
                <button class="vm-close" onclick="closeEditVitalsModal()" type="button">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form id="editVitalsForm" action="" method="POST" class="vm-body">
                @csrf @method('PUT')
                <input type="hidden" name="dw_user_id" value="{{ Auth::id() ?? '' }}">

                <div class="vm-row">
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--red"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg></span>Heart Rate <em>bpm</em></label>
                        <input type="number" name="heart_rate" id="evHeartRate" placeholder="e.g. 72" min="30" max="250">
                    </div>
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--blue"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg></span>Blood Pressure <em>mmHg</em></label>
                        <input type="text" name="blood_pressure" id="evBloodPressure" placeholder="e.g. 120/80">
                    </div>
                </div>

                <div class="vm-row">
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--orange"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M14 14.76V3.5a2.5 2.5 0 00-5 0v11.26a4.5 4.5 0 105 0z" />
                                </svg></span>Temperature <em>°C</em></label>
                        <input type="number" name="temparature" id="evTemparature" placeholder="e.g. 36.6" step="0.1"
                            min="30">
                    </div>
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--teal"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M12 22a10 10 0 110-20 10 10 0 010 20z" />
                                    <path d="M12 8v4l3 3" />
                                </svg></span>SpO₂ <em>%</em></label>
                        <input type="number" name="spo" id="evSpo" placeholder="e.g. 98" min="50" max="100">
                    </div>
                </div>

                <div class="vm-row">
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--purple"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <ellipse cx="12" cy="5" rx="9" ry="3" />
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                                </svg></span>Blood Sugar <em>mg/dL</em></label>
                        <input type="number" name="blood_sugar" id="evBloodSugar" placeholder="e.g. 90" min="20" max="600">
                    </div>
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--red"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg></span>Blood Group</label>
                        <div class="vm-select-wrap">
                            <select name="blood_group" id="evBloodGroup">
                                <option value="" disabled>Choose</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                    <option value="{{ $bg }}">{{ $bg }}</option>
                                @endforeach
                            </select>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="vm-row">
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--green"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="12" y1="2" x2="12" y2="22" />
                                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                                </svg></span>Weight <em>kg</em></label>
                        <input type="number" name="weight" id="evWeight" placeholder="e.g. 70" step="0.1" min="1" max="300"
                            oninput="calcEvBmi()">
                    </div>
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--blue"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="12" y1="2" x2="12" y2="22" />
                                    <line x1="2" y1="12" x2="22" y2="12" />
                                </svg></span>Height <em>cm</em></label>
                        <input type="number" name="height" id="evHeight" placeholder="e.g. 170" step="0.1" min="50"
                            max="300" oninput="calcEvBmi()">
                    </div>
                </div>

                <div class="vm-row vm-row--single">
                    <div class="vm-field">
                        <label><span class="vm-field__icon vm-field__icon--teal"><svg width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg></span>BMI <em>auto-calculated</em></label>
                        <div class="vm-bmi-wrap">
                            <input type="text" name="bmi" id="evBmi" placeholder="Fill weight & height above" readonly>
                            <span class="vm-bmi-tag" id="evBmiTag"></span>
                        </div>
                    </div>
                </div>

                <div class="vm-foot">
                    <button type="button" class="vm-btn-cancel" onclick="closeEditVitalsModal()">Cancel</button>
                    <button type="submit" class="vm-btn-save">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Update Vitals
                    </button>
                </div>
            </form>
        </div>
    </div>


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

            <form action="{{ route('dw.medical-history.add') }}" method="POST" enctype="multipart/form-data"
                class="mh-modal__body" id="medicalHistoryForm">
                @csrf
                <input type="hidden" name="dw_user_id" value="{{ Auth::user()->id ?? '' }}">

                <div class="mh-form-row">
                    <div class="mh-field">
                        <label>Type <span class="mh-req">*</span></label>
                        <div class="mh-select-wrap">
                            <select name="type" required>
                                <option value="" disabled selected>Select type</option>
                                <option value="report">Medical Report</option>
                                <option value="prescription">Prescription</option>
                            </select>
                            <svg class="mh-select-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                    <div class="mh-field">
                        <label>Date of Report <span class="mh-req">*</span></label>
                        <input type="date" name="date_of_report" required max="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="mh-form-row mh-form-row--single">
                    <div class="mh-field">
                        <label>Heading / Title <span class="mh-req">*</span></label>
                        <input type="text" name="heading" placeholder="e.g. Blood Test Report – June 2025" required>
                    </div>
                </div>

                <div class="mh-form-row mh-form-row--single">
                    <div class="mh-field">
                        <label>Images <span class="mh-req">*</span></label>
                        <div class="mh-upload-sources">
                            <button type="button" class="mh-src-btn" onclick="triggerMhInput('camera')" title="Take Photo">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                                    <circle cx="12" cy="13" r="4" />
                                </svg>
                                Camera
                            </button>
                            <button type="button" class="mh-src-btn" onclick="triggerMhInput('gallery')"
                                title="Choose from Gallery">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                                Gallery
                            </button>
                            <button type="button" class="mh-src-btn" onclick="triggerMhInput('file')" title="Choose File">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z" />
                                    <polyline points="13 2 13 9 20 9" />
                                </svg>
                                PDF File
                            </button>
                        </div>

                        <input type="file" id="mhInputCamera" name="images[]" accept="image/*" capture="environment"
                            style="display:none;" onchange="handleMhFiles(this)">
                        <input type="file" id="mhInputGallery" name="images[]" accept="image/jpeg,image/png,image/webp"
                            multiple style="display:none;" onchange="handleMhFiles(this)">
                        <input type="file" id="mhInputFile" name="images[]"
                            accept="image/jpeg,image/png,image/webp,application/pdf" multiple style="display:none;"
                            onchange="handleMhFiles(this)">

                        <div class="mh-preview-grid" id="mhPreviewGrid"></div>

                        <button type="button" class="mh-add-more" id="mhAddMoreBtn" style="display:none;"
                            onclick="showMhAddMoreOptions()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add More Images
                        </button>

                        <div class="mh-upload-sources mh-add-more-sources" id="mhAddMoreSources" style="display:none;">
                            <button type="button" class="mh-src-btn mh-src-btn--sm"
                                onclick="triggerMhInput('camera'); hideMhAddMoreOptions()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                                    <circle cx="12" cy="13" r="4" />
                                </svg>Camera
                            </button>
                            <button type="button" class="mh-src-btn mh-src-btn--sm"
                                onclick="triggerMhInput('gallery'); hideMhAddMoreOptions()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>Gallery
                            </button>
                            <button type="button" class="mh-src-btn mh-src-btn--sm"
                                onclick="triggerMhInput('file'); hideMhAddMoreOptions()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z" />
                                    <polyline points="13 2 13 9 20 9" />
                                </svg>File
                            </button>
                            <button type="button" class="mh-src-btn mh-src-btn--sm mh-src-btn--cancel"
                                onclick="hideMhAddMoreOptions()">Cancel</button>
                        </div>

                        <p class="mh-upload-hint">Accepted: JPG, PNG, WEBP, PDF &mdash; max 5MB each</p>
                    </div>
                </div>

                <div class="mh-modal__foot">
                    <button type="button" class="mh-btn-cancel" onclick="closeMhModal()">Cancel</button>
                    <button type="submit" class="mh-btn-save">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
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


    <!-- {{-- ════════════════ JS (Edit modal helpers) ════════════════ --}} -->
    <script>
        let editNewFiles = []; // newly picked files
        let editDeletedPaths = []; // existing paths marked for removal

        // ── Open modal ────────────────────────────────────────────────
        // Call from table row:
        function openEditMhModal(id, type, date, heading, existingImages) {
            editNewFiles = [];
            editDeletedPaths = [];

            // Set form action
            document.getElementById('editMhForm').action =
                '/dw/medical-history/' + id + '/update'; // adjust prefix if needed

            // Populate text fields
            document.getElementById('editMhType').value = type;
            document.getElementById('editMhDate').value = date;
            document.getElementById('editMhHeading').value = heading;

            // Clear new-file preview & deleted inputs
            document.getElementById('editNewPreviewGrid').innerHTML = '';
            document.getElementById('editDeletedImagesInputs').innerHTML = '';

            // Render existing images
            renderEditExistingImages(existingImages || []);

            document.getElementById('editMhModal').classList.add('active');
        }

        // ── Render existing files ─────────────────────────────────────
        function renderEditExistingImages(paths) {
            const grid = document.getElementById('editExistingGrid');
            const noMsg = document.getElementById('editNoExistingMsg');
            grid.innerHTML = '';

            // Filter out already-deleted ones
            const visible = paths.filter(p => !editDeletedPaths.includes(p));

            if (!visible.length) {
                noMsg.style.display = 'block';
                return;
            }
            noMsg.style.display = 'none';

            visible.forEach(path => {
                const isPdf = path.toLowerCase().endsWith('.pdf');
                const url = '/storage/' + path; // adjust if your APP_URL differs
                const name = path.split('/').pop();

                const item = document.createElement('div');
                item.className = 'mh-preview-item';
                item.dataset.path = path;

                if (isPdf) {
                    item.innerHTML = `
                            <a href="${url}" target="_blank" style="display:flex;width:100%;height:100%;align-items:center;justify-content:center;flex-direction:column;gap:4px;color:#e53e3e;font-size:10px;font-weight:700;text-decoration:none;">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                PDF
                            </a>
                            <button type="button" class="mh-remove-btn" onclick="removeExistingFile('${path}', this)" title="Remove">✕</button>`;
                } else {
                    item.innerHTML = `
                            <img src="${url}" alt="${name}" style="width:100%;height:100%;object-fit:cover;">
                            <button type="button" class="mh-remove-btn" onclick="removeExistingFile('${path}', this)" title="Remove">✕</button>`;
                }

                grid.appendChild(item);
            });
        }

        // ── Remove an existing file (marks for deletion on submit) ────
        function removeExistingFile(path, btn) {
            editDeletedPaths.push(path);

            // Add hidden input so controller knows what to delete
            const container = document.getElementById('editDeletedImagesInputs');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_images[]';
            input.value = path;
            container.appendChild(input);

            // Animate & remove card
            const card = btn.closest('.mh-preview-item');
            card.style.transition = 'opacity .2s, transform .2s';
            card.style.opacity = '0';
            card.style.transform = 'scale(.85)';
            setTimeout(() => card.remove(), 200);

            // Show "no existing files" if all removed
            if (!document.getElementById('editExistingGrid').children.length) {
                document.getElementById('editNoExistingMsg').style.display = 'block';
            }
        }

        // ── New file pickers ──────────────────────────────────────────
        function triggerEditInput(source) {
            const map = {
                camera: 'editInputCamera',
                gallery: 'editInputGallery',
                file: 'editInputFile'
            };
            document.getElementById(map[source]).click();
        }

        function handleEditFiles(input) {
            Array.from(input.files).forEach(f => {
                if (!editNewFiles.some(x => x.name === f.name && x.size === f.size))
                    editNewFiles.push(f);
            });
            input.value = '';
            renderEditNewPreviews();
            syncEditNewFiles();
        }

        function renderEditNewPreviews() {
            const grid = document.getElementById('editNewPreviewGrid');
            grid.innerHTML = '';
            editNewFiles.forEach((file, idx) => {
                const item = document.createElement('div');
                item.className = 'mh-preview-item';
                if (file.type === 'application/pdf') {
                    item.innerHTML = `
                            <div class="mh-pdf-thumb">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                PDF
                            </div>
                            <button type="button" class="mh-remove-btn" onclick="removeEditNewFile(${idx})">✕</button>`;
                } else {
                    const url = URL.createObjectURL(file);
                    item.innerHTML = `
                            <img src="${url}" onload="URL.revokeObjectURL(this.src)">
                            <button type="button" class="mh-remove-btn" onclick="removeEditNewFile(${idx})">✕</button>`;
                }
                grid.appendChild(item);
            });
        }

        function removeEditNewFile(idx) {
            editNewFiles.splice(idx, 1);
            renderEditNewPreviews();
            syncEditNewFiles();
        }

        function syncEditNewFiles() {
            const dt = new DataTransfer();
            editNewFiles.forEach(f => dt.items.add(f));
            const gallery = document.getElementById('editInputGallery');
            gallery.files = dt.files;
            gallery.name = 'new_images[]';
        }

        // ── Close ─────────────────────────────────────────────────────
        function closeEditMhModal() {
            document.getElementById('editMhModal').classList.remove('active');
        }

        function handleEditMhOverlay(e) {
            if (e.target === document.getElementById('editMhModal')) closeEditMhModal();
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
        document.getElementById('completeModalOverlay').addEventListener('click', function (e) {
            if (e.target === this) closeCompleteModal();
        });
        document.getElementById('cancelModalOverlay').addEventListener('click', function (e) {
            if (e.target === this) closeCancelModal();
        });

        /* ── CLOSE ON ESCAPE KEY ── */
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCompleteModal();
                closeCancelModal();
            }
        });
    </script>

    <!-- {{-- ════════════════ Vitals JS ════════════════ --}} -->
    <script>
        // ── Add modal ───────────────────────────────────────────
        function openVitalsModal() {
            document.getElementById('vitalsModal').classList.add('active');
        }

        function closeVitalsModal() {
            document.getElementById('vitalsModal').classList.remove('active');
        }

        function handleVmOverlay(e) {
            if (e.target === document.getElementById('vitalsModal')) closeVitalsModal();
        }

        // ── Edit modal ──────────────────────────────────────────
        // Call: openEditVitalsModal({{ Js::from($vital) }})
        function openEditVitalsModal(v) {
            const form = document.getElementById('editVitalsForm');
            form.action = '/dw/vitals/' + v.id + '/update'; // adjust prefix

            document.getElementById('evHeartRate').value = v.heart_rate ?? '';
            document.getElementById('evBloodPressure').value = v.blood_pressure ?? '';
            document.getElementById('evTemparature').value = v.temparature ?? '';
            document.getElementById('evSpo').value = v.spo ?? '';
            document.getElementById('evBloodSugar').value = v.blood_sugar ?? '';
            document.getElementById('evBloodGroup').value = v.blood_group ?? '';
            document.getElementById('evWeight').value = v.weight ?? '';
            document.getElementById('evHeight').value = v.height ?? '';
            document.getElementById('evBmi').value = v.bmi ?? '';

            // Show BMI tag for existing value
            setBmiTag(parseFloat(v.bmi), document.getElementById('evBmi'), document.getElementById('evBmiTag'));

            document.getElementById('editVitalsModal').classList.add('active');
        }

        function closeEditVitalsModal() {
            document.getElementById('editVitalsModal').classList.remove('active');
        }

        function handleEditVmOverlay(e) {
            if (e.target === document.getElementById('editVitalsModal')) closeEditVitalsModal();
        }

        // ── BMI calculator ───────────────────────────────────────
        function calcVmBmi() {
            const w = parseFloat(document.getElementById('vmWeight').value);
            const h = parseFloat(document.getElementById('vmHeight').value) / 100;
            const bmiInput = document.getElementById('vmBmi');
            const bmiTag = document.getElementById('vmBmiTag');
            if (w > 0 && h > 0) {
                const bmi = (w / (h * h)).toFixed(1);
                bmiInput.value = bmi;
                setBmiTag(parseFloat(bmi), bmiInput, bmiTag);
            } else {
                bmiInput.value = '';
                bmiTag.className = 'vm-bmi-tag';
                bmiTag.textContent = '';
            }
        }

        function calcEvBmi() {
            const w = parseFloat(document.getElementById('evWeight').value);
            const h = parseFloat(document.getElementById('evHeight').value) / 100;
            const bmiInput = document.getElementById('evBmi');
            const bmiTag = document.getElementById('evBmiTag');
            if (w > 0 && h > 0) {
                const bmi = (w / (h * h)).toFixed(1);
                bmiInput.value = bmi;
                setBmiTag(parseFloat(bmi), bmiInput, bmiTag);
            } else {
                bmiInput.value = '';
                bmiTag.className = 'vm-bmi-tag';
                bmiTag.textContent = '';
            }
        }

        function setBmiTag(bmi, input, tag) {
            tag.className = 'vm-bmi-tag';
            if (!bmi || isNaN(bmi)) {
                tag.textContent = '';
                return;
            }
            if (bmi < 18.5) {
                tag.classList.add('underweight');
                tag.textContent = 'Underweight';
            } else if (bmi < 25) {
                tag.classList.add('normal');
                tag.textContent = 'Normal';
            } else if (bmi < 30) {
                tag.classList.add('overweight');
                tag.textContent = 'Overweight';
            } else {
                tag.classList.add('obese');
                tag.textContent = 'Obese';
            }
        }
    </script>


    <script>
        function switchTab(event, tabId) {
            document.querySelectorAll('.mht-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            if (tabId === 'uploaded') {
                document.getElementById('uploadedRecords').classList.add('active');
            } else {
                document.getElementById('generatedRecords').classList.add('active');
            }
        }
    </script>
@endsection