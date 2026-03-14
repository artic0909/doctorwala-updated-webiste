<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$patient->user_name}} - Patient Profile |Partner Panel</title>

    <link href="{{asset('fav5.png')}}" rel="icon">

    <link rel="stylesheet" href="{{ asset('./css/user-profile.css') }}">

    <style>
        /* ─── PARTNER READ-ONLY BANNER ─── */
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

        /* ─── MHT TABLE STYLES ─── */
        .mht-wrap {
            font-family: 'Outfit', 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .mht-table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
            border: 1.5px solid #f0f2f8;
            margin-top: 16px;
            box-shadow: 0 2px 20px rgba(67, 97, 238, .06);
        }

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
            font-weight: 600;
            color: #1a1f36;
            max-width: 220px;
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

        .mht-edit-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            background: #f8fafc;
            color: #4338ca;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid #e0e7ff;
            transition: all .15s;
        }

        .mht-edit-btn:hover {
            background: #eef2ff;
            border-color: #c7d2fe;
            transform: translateY(-1px);
        }

        .mht-no-files {
            color: #cbd5e1;
            font-size: 13px;
        }

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

        /* ─── PAGINATION ─── */
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

        /* ─── ALERT ─── */
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

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .up-hero {
                padding-bottom: 20px !important;
            }

            .up-hero__inner {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 20px;
            }

            .up-hero__actions {
                flex-direction: column;
                width: 100%;
                gap: 12px !important;
            }

            .up-hero__btn {
                width: 100% !important;
                justify-content: center;
                padding: 10px 14px !important;
                font-size: 0.75rem !important;
            }

            .up-layout {
                flex-direction: column;
                gap: 20px;
            }

            .up-sidebar {
                order: 2;
            }

            .up-main {
                order: 1;
            }

            /* Hide Desktop Table */
            .mht-table-wrap {
                display: none;
            }

            /* Mobile Cards */
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
                font-weight: 700;
                color: #1a1f36;
                font-size: 14px;
                line-height: 1.4;
                margin-bottom: 0px;
            }

            .mht-card-meta {
                display: flex;
                flex-direction: column;
                gap: 10px;
                margin-bottom: 14px;
            }

            .mht-card-info-item {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #5a6282;
                font-size: 12.5px;
            }

            .mht-card-actions {
                display: flex;
                justify-content: flex-end;
                gap: 12px;
                border-top: 1px solid #f8fafc;
                padding-top: 14px;
            }

            /* Vitals Optimization */
            .up-vitals {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
                padding: 16px !important;
            }

            .up-vital {
                padding: 12px 8px !important;
                height: auto !important;
            }

            .up-vital__val {
                font-size: 1rem !important;
            }

            .up-vital__lbl {
                font-size: 0.62rem !important;
            }

            .up-vital__unit {
                font-size: 0.58rem !important;
            }

            .pp-readonly-banner {
                font-size: 0.72rem;
                padding: 8px 12px;
            }
        }

        @media (max-width: 480px) {
            .up-vitals {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        @media (min-width: 769px) {
            .mht-mobile-cards {
                display: none;
            }
        }

        /* ─── TABS STYLES ─── */
        .mht-tabs-container {
            background: #f8fafc;
            border-radius: 12px;
            padding: 6px;
            margin-bottom: 24px;
            display: inline-flex;
            border: 1px solid #e2e8f0;
        }

        .mht-tab {
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.2s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mht-tab:hover {
            color: #1e40af;
            background: rgba(255,255,255,0.5);
        }

        .mht-tab.active {
            color: #fff;
            background: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }

        @media screen and (max-width: 768px) {
            .mht-tabs-container {
                display: flex;
                width: 100%;
            }
            .mht-tab {
                padding: 10px 10px;
                font-size: 11px;
                flex: 1;
                justify-content: center;
                gap: 5px;
            }
            .mht-tab svg {
                width: 14px;
                height: 14px;
            }
        }
    </style>
</head>

<body>



    {{-- ══════════════ HERO ══════════════ --}}
    <div class="up-hero" style="background:linear-gradient(135deg,#1e1b4b 0%,#312e81 55%,#1e40af 100%)">
        <div class="up-hero__wave">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,60 C480,0 960,80 1440,30 L1440,80 L0,80 Z" fill="#f0f9ff" />
            </svg>
        </div>

        <div class="up-wrap">
            <a href="{{ route('partner.patient.profile', ['encryptedId' => $encryptedPatientId]) }}"
                class="pp-back-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Back to Patient Profile
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
                        <h1 class="up-hero__name" style="text-transform:capitalize;color:#fff">{{ $patient->user_name }}
                        </h1>
                        <p class="up-hero__email" style="color:rgba(255,255,255,.72)">{{ $patient->user_email }}</p>
                        <div class="up-hero__badges">
                            <span class="up-hero__badge"
                                style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:#fff">
                                <span class="dot" style="background:#a5f3fc"></span>
                                Medical History — Read Only
                            </span>
                        </div>
                    </div>
                </div>

                {{-- No add button — partner cannot add records --}}
                <div class="up-hero__actions" style="display:flex; gap:10px;">
                    <a href="{{ route('partner.patient.prescription', ['encryptedId' => $encryptedPatientId]) }}"
                        style="text-decoration:none;">
                        <span class="up-hero__btn up-hero__btn--white"
                            style="cursor:pointer; background:#10b981; color:#fff; border-color:#10b981;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                            Create Prescription
                        </span>
                    </a>

                </div>
            </div>
        </div>
    </div>


    {{-- ══════════════ MAIN ══════════════ --}}
    <div class="up-wrap" style="margin-top: 10px;">

        <div class="up-layout">

            {{-- ═════ SIDEBAR ═════ --}}
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
                            <div class="up-qstat__num">{{ $noOfPrescription }}</div>
                            <div class="up-qstat__lbl">Prescriptions</div>
                        </div>
                        <div class="up-qstat up-qstat--coral">
                            <div class="up-qstat__ico">📋</div>
                            <div class="up-qstat__num">{{ $noOfReport }}</div>
                            <div class="up-qstat__lbl">Reports</div>
                        </div>
                        <div class="up-qstat up-qstat--teal">
                            <div class="up-qstat__ico">📁</div>
                            <div class="up-qstat__num">{{ $noOfPrescription + $noOfReport }}</div>
                            <div class="up-qstat__lbl">Total Records</div>
                        </div>
                        <div class="up-qstat up-qstat--amber">
                            <div class="up-qstat__ico">🗓️</div>
                            <div class="up-qstat__num">{{ $histories->total() }}</div>
                            <div class="up-qstat__lbl">All Entries</div>
                        </div>
                    </div>
                </div>

                {{-- Vitals Summary (read-only) --}}
                @if($vital)
                    <div class="up-card">
                        <div class="up-card__head">
                            <div class="up-card__title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                                Latest Vitals
                            </div>
                            <span style="font-size:.68rem;color:var(--muted);font-weight:700">
                                {{ \Carbon\Carbon::parse($vital->updated_at)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="up-info-list">
                            <div class="up-info-row">
                                <div class="up-info-ico">❤️</div>
                                <div>
                                    <div class="up-info-lbl">Heart Rate</div>
                                    <div class="up-info-val">{{ $vital->heart_rate ?? '—' }} <small
                                            style="color:var(--muted)">bpm</small></div>
                                </div>
                            </div>
                            <div class="up-info-row">
                                <div class="up-info-ico">🩸</div>
                                <div>
                                    <div class="up-info-lbl">Blood Pressure</div>
                                    <div class="up-info-val">{{ $vital->blood_pressure ?? '—' }} <small
                                            style="color:var(--muted)">mmHg</small></div>
                                </div>
                            </div>
                            <div class="up-info-row">
                                <div class="up-info-ico">🌡️</div>
                                <div>
                                    <div class="up-info-lbl">Temperature</div>
                                    <div class="up-info-val">{{ $vital->temparature ?? '—' }} <small
                                            style="color:var(--muted)">°C</small></div>
                                </div>
                            </div>
                            <div class="up-info-row">
                                <div class="up-info-ico">🫁</div>
                                <div>
                                    <div class="up-info-lbl">SpO₂</div>
                                    <div class="up-info-val">{{ $vital->spo ?? '—' }} <small
                                            style="color:var(--muted)">%</small></div>
                                </div>
                            </div>
                            <div class="up-info-row">
                                <div class="up-info-ico">🧪</div>
                                <div>
                                    <div class="up-info-lbl">Blood Sugar</div>
                                    <div class="up-info-val">{{ $vital->blood_sugar ?? '—' }} <small
                                            style="color:var(--muted)">mg/dL</small></div>
                                </div>
                            </div>
                            <div class="up-info-row">
                                <div class="up-info-ico">📊</div>
                                <div>
                                    <div class="up-info-lbl">BMI</div>
                                    <div class="up-info-val">
                                        {{ $vital->bmi ?? '—' }}
                                        @if($vital->bmi)
                                            <small style="color:var(--muted)">
                                                @if($vital->bmi < 18.5) · Underweight
                                                @elseif($vital->bmi < 25) · Normal
                                                @elseif($vital->bmi < 30) · Overweight
                                                @else · Obese
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="up-info-row">
                                <div class="up-info-ico">⚖️</div>
                                <div>
                                    <div class="up-info-lbl">Weight / Height</div>
                                    <div class="up-info-val">{{ $vital->weight ?? '—' }} kg / {{ $vital->height ?? '—' }} cm
                                    </div>
                                </div>
                            </div>
                            <div class="up-info-row">
                                <div class="up-info-ico">🔴</div>
                                <div>
                                    <div class="up-info-lbl">Blood Group</div>
                                    <div class="up-info-val" style="color:var(--rose)">{{ $vital->blood_group ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="up-card">
                        <div style="padding:22px;text-align:center;color:#94a3b8;font-size:13px;">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.2" opacity=".4" style="display:block;margin:0 auto 10px">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                            No vitals recorded for this patient.
                        </div>
                    </div>
                @endif
            </aside>

            {{-- ═════ MAIN ═════ --}}
            <div class="up-main">
                <div class="mht-wrap">

                    @if(session('success'))
                        <div class="mht-alert mht-alert--success">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ── Tabs Header ── --}}
                    <div class="mht-tabs-container" style="margin-top: 15px;">
                        <div class="mht-tab active" onclick="switchTab(event, 'uploaded')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            Uploaded Records
                        </div>
                        <div class="mht-tab" onclick="switchTab(event, 'generated')">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            System Generated
                        </div>
                    </div>

                    {{-- ── TAB 1: Uploaded ── --}}
                    <div id="uploadedRecords" class="tab-content active">
                        <div class="mht-table-wrap">
                        @if($histories->count())
                            <table class="mht-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Date</th>
                                        <th>Files</th>
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

                                            <td class="mht-td--heading" style="text-transform:capitalize">
                                                {{ $rec->heading ?? '—' }}
                                                <div class="mht-tags">
                                                    @if(!empty($rec->opd->partner_clinic_name))
                                                        <span class="mht-tag mht-tag--clinic">
                                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2.5">
                                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                                                <polyline points="9 22 9 12 15 12 15 22" />
                                                            </svg>
                                                            {{ $rec->opd->partner_clinic_name }}
                                                        </span>
                                                    @endif
                                                    @if(!empty($rec->doctor->doctor_name))
                                                        <span class="mht-tag mht-tag--doctor">
                                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2.5">
                                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                                <circle cx="12" cy="7" r="4" />
                                                            </svg>
                                                            {{ $rec->doctor->doctor_name }}
                                                            <span
                                                                style="opacity:0.7; font-weight:400; margin-left:2px;">({{ $rec->doctor->doctor_specialist ?? 'Gen.' }})</span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="mht-td--date">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                                    <line x1="16" y1="2" x2="16" y2="6" />
                                                    <line x1="8" y1="2" x2="8" y2="6" />
                                                    <line x1="3" y1="10" x2="21" y2="10" />
                                                </svg>
                                                {{ $rec->date_of_report ? \Carbon\Carbon::parse($rec->date_of_report)->format('d M Y') : '—' }}
                                            </td>

                                            <td class="mht-td--files">
                                                @if(($rec->images ?? null) && count($rec->images))
                                                    <a href="{{ route('partner.patient.report.files', ['encryptedId' => Crypt::encryptString($rec->id)]) }}"
                                                        class="mht-files-pill" title="View {{ count($rec->images) }} file(s)"
                                                        target="_blank">
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    {{-- ── Mobile Cards ── --}}
                    <div class="mht-mobile-cards">
                        @forelse($histories as $i => $rec)
                            <div class="mht-card" style="--row-delay:{{ $i * 50 }}ms">
                                <div class="mht-card-top">
                                    <span class="mht-badge mht-badge--{{ $rec->type ?? 'report' }}">
                                        @if(($rec->type ?? '') === 'report')
                                            Report
                                        @else
                                            Prescription
                                        @endif
                                    </span>
                                    <span class="mht-td--num">#{{ $histories->firstItem() + $i }}</span>
                                </div>

                                <h3 class="mht-card-heading" style="text-transform:capitalize">
                                    {{ $rec->heading ?? '—' }}
                                    <div class="mht-tags">
                                        @if(!empty($rec->opd->partner_clinic_name))
                                            <span class="mht-tag mht-tag--clinic">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                                    <polyline points="9 22 9 12 15 12 15 22" />
                                                </svg>
                                                {{ $rec->opd->partner_clinic_name }}
                                            </span>
                                        @endif
                                        @if(!empty($rec->doctor->doctor_name))
                                            <span class="mht-tag mht-tag--doctor">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                                {{ $rec->doctor->doctor_name }}
                                                <span
                                                    style="opacity:0.7; font-weight:400; margin-left:2px;">({{ $rec->doctor->doctor_specialist ?? 'Gen.' }})</span>
                                            </span>
                                        @endif
                                    </div>
                                </h3>

                                <div class="mht-card-meta">
                                    <div class="mht-card-info-item">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" />
                                        </svg>
                                        {{ $rec->date_of_report ? \Carbon\Carbon::parse($rec->date_of_report)->format('d M Y') : '—' }}
                                    </div>

                                    @if(($rec->images ?? null) && count($rec->images))
                                        <div class="mht-card-info-item">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path
                                                    d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48" />
                                            </svg>
                                            <a href="{{ route('partner.patient.report.files', ['encryptedId' => Crypt::encryptString($rec->id)]) }}"
                                                style="color: #16a34a; font-weight: 600; text-decoration: none;"
                                                target="_blank">
                                                {{ count($rec->images) }} file{{ count($rec->images) > 1 ? 's' : '' }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="mht-card-actions">
                                    @if(Auth::guard('partner')->user() && $rec->partner_id == Auth::guard('partner')->user()->partner_id)
                                        <a href="{{ route('partner.patient.prescription.edit', ['encryptedId' => Crypt::encryptString($rec->id)]) }}"
                                            class="mht-edit-btn">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2.5">
                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            Edit Record
                                        </a>
                                    @else
                                        <span style="color:#cbd5e1; font-size:12px; font-weight: 600;">View Only</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="mht-empty">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.2">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                <p>No medical records found for this patient.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- ── Pagination ── --}}
                    @if($histories->lastPage() > 1)
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
                    </div>{{-- Close uploadedRecords --}}

                    {{-- ── TAB 2: Generated ── --}}
                    <div id="generatedRecords" class="tab-content">
                        <div class="mht-table-wrap">
                            @if(isset($systemPrescriptions) && $systemPrescriptions->count())
                                <table class="mht-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Details</th>
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
                                                    <span class="mht-heading-val">Dr. {{ $rec->doctor_name ?? 'N/A' }}</span>
                                                    <div class="mht-tags">
                                                        @php $cName = $rec->clinic_name ?? $rec->opd->clinic_name ?? null; @endphp
                                                        @if(!empty($cName))
                                                            <span class="mht-tag mht-tag--clinic">
                                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2.5">
                                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                                                    <polyline points="9 22 9 12 15 12 15 22" />
                                                                </svg>
                                                                {{ $cName }}
                                                            </span>
                                                        @endif
                                                        @if(!empty($rec->doctor->doctor_specialist))
                                                            <span class="mht-tag mht-tag--doctor">
                                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2.5">
                                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                                    <circle cx="12" cy="7" r="4" />
                                                                </svg>
                                                                {{ $rec->doctor->doctor_specialist }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="mht-td--date">
                                                    {{ \Carbon\Carbon::parse($rec->prescription_date)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    <div style="font-size: 14px; font-weight: 500; color: #000000ff;">
                                                        <span class="mht-heading-val"><strong>{{ $rec->heading ?? '—' }}</strong></span>
                                                    </div>
                                                </td>
                                                <td class="mht-td--actions">
                                                    <a href="{{ route('partner.digital.prescription.view', Crypt::encryptString($rec->id)) }}" target="_blank" class="mht-edit-btn" style="background: #2563eb; color: #fff; border-color: #2563eb; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
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
                                        <div class="mht-card-heading">
                                            <span class="mht-heading-val">{{ $rec->heading ?? '—' }}</span> <br>
                                            <span class="mht-heading-val">Dr. {{ $rec->doctor_name }}</span>
                                            <div class="mht-tags">
                                                @php $cNameMobile = $rec->clinic_name ?? $rec->opd->clinic_name ?? null; @endphp
                                                @if(!empty($cNameMobile))
                                                    <span class="mht-tag mht-tag--clinic">
                                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5">
                                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                                            <polyline points="9 22 9 12 15 12 15 22" />
                                                        </svg>
                                                        {{ $cNameMobile }}
                                                    </span>
                                                @endif
                                                @if(!empty($rec->doctor->doctor_specialist))
                                                    <span class="mht-tag mht-tag--doctor">
                                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                            <circle cx="12" cy="7" r="4" />
                                                        </svg>
                                                        {{ $rec->doctor->doctor_specialist }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="mht-badge mht-badge--prescription">Digital</span>
                                    </div>
                                    <div class="mht-card-meta">
                                        <div class="mht-card-info-item">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" /><line x1="16" y1="2" x2="16" y2="6" /><line x1="8" y1="2" x2="8" y2="6" /><line x1="3" y1="10" x2="21" y2="10" /></svg>
                                            {{ \Carbon\Carbon::parse($rec->prescription_date)->format('d M Y') }}
                                        </div>
                                    </div>
                                    <div class="mht-card-actions">
                                        <a href="{{ route('partner.digital.prescription.view', Crypt::encryptString($rec->id)) }}" target="_blank" class="mht-edit-btn" style="background: #2563eb; color: #fff; width: 100%; justify-content: center;">Download PDF</a>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                </div>{{-- end mht-wrap --}}


                {{-- ── Full Vitals Card (read-only) ── --}}
                <div class="up-card" style="margin-top:20px">
                    <div class="up-card__head">
                        <div class="up-card__title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                            Patient Vitals (Full View)
                        </div>
                        <span style="font-size:.7rem;color:var(--muted);font-weight:700">
                            Updated:
                            {{ ($vital && $vital->updated_at) ? \Carbon\Carbon::parse($vital->updated_at)->format('d M Y') : 'N/A' }}
                        </span>
                    </div>

                    @if($vital)
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
                                <div class="up-vital__val" style="color:var(--rose)">{{ $vital->blood_pressure ?? '—' }}
                                </div>
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
                                    @if($vital->bmi)
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
                            No vitals recorded for this patient.
                        </div>
                    @endif
                </div>

            </div>{{-- end up-main --}}
        </div>{{-- end up-layout --}}
    </div>{{-- end up-wrap --}}
    <script>
        function switchTab(event, tabId) {
            // Update tabs
            document.querySelectorAll('.mht-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.currentTarget.classList.add('active');

            // Update content
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
</body>

</html>