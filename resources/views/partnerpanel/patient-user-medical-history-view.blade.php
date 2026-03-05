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
        @media (max-width: 640px) {

            .mht-table th:nth-child(4),
            .mht-table td:nth-child(4) {
                display: none;
            }

            .mht-td--heading {
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
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
            <a href="{{ route('partner.patient.profile', ['encryptedId' => $encryptedPatientId]) }}" class="pp-back-btn">
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
                        <h1 class="up-hero__name" style="text-transform:capitalize;color:#fff">{{ $patient->user_name }}</h1>
                        <p class="up-hero__email" style="color:rgba(255,255,255,.72)">{{ $patient->user_email }}</p>
                        <div class="up-hero__badges">
                            <span class="up-hero__badge" style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:#fff">
                                <span class="dot" style="background:#a5f3fc"></span>
                                Medical History — Read Only
                            </span>
                        </div>
                    </div>
                </div>

                {{-- No add button — partner cannot add records --}}
                <div class="up-hero__actions">
                    <span class="up-hero__btn up-hero__btn--white" style="opacity:.55;cursor:default">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                        View Only
                    </span>
                </div>
            </div>
        </div>
    </div>


    {{-- ══════════════ MAIN ══════════════ --}}
    <div class="up-wrap">

        <div class="up-layout">

            {{-- ═════ SIDEBAR ═════ --}}
            <aside class="up-sidebar">
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
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                                <div class="up-info-val">{{ $vital->heart_rate ?? '—' }} <small style="color:var(--muted)">bpm</small></div>
                            </div>
                        </div>
                        <div class="up-info-row">
                            <div class="up-info-ico">🩸</div>
                            <div>
                                <div class="up-info-lbl">Blood Pressure</div>
                                <div class="up-info-val">{{ $vital->blood_pressure ?? '—' }} <small style="color:var(--muted)">mmHg</small></div>
                            </div>
                        </div>
                        <div class="up-info-row">
                            <div class="up-info-ico">🌡️</div>
                            <div>
                                <div class="up-info-lbl">Temperature</div>
                                <div class="up-info-val">{{ $vital->temparature ?? '—' }} <small style="color:var(--muted)">°C</small></div>
                            </div>
                        </div>
                        <div class="up-info-row">
                            <div class="up-info-ico">🫁</div>
                            <div>
                                <div class="up-info-lbl">SpO₂</div>
                                <div class="up-info-val">{{ $vital->spo ?? '—' }} <small style="color:var(--muted)">%</small></div>
                            </div>
                        </div>
                        <div class="up-info-row">
                            <div class="up-info-ico">🧪</div>
                            <div>
                                <div class="up-info-lbl">Blood Sugar</div>
                                <div class="up-info-val">{{ $vital->blood_sugar ?? '—' }} <small style="color:var(--muted)">mg/dL</small></div>
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
                                <div class="up-info-val">{{ $vital->weight ?? '—' }} kg / {{ $vital->height ?? '—' }} cm</div>
                            </div>
                        </div>
                        <div class="up-info-row">
                            <div class="up-info-ico">🔴</div>
                            <div>
                                <div class="up-info-lbl">Blood Group</div>
                                <div class="up-info-val" style="color:var(--rose)">{{ $vital->blood_group ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="up-card">
                    <div style="padding:22px;text-align:center;color:#94a3b8;font-size:13px;">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".4" style="display:block;margin:0 auto 10px">
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
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- ── Table ── --}}
                    <div class="mht-table-wrap">
                        @if($histories->count())
                        <table class="mht-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Heading</th>
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
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                                <polyline points="14 2 14 8 20 8" />
                                            </svg>
                                            Report
                                            @else
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                                <polyline points="9 22 9 12 15 12 15 22" />
                                            </svg>
                                            Prescription
                                            @endif
                                        </span>
                                    </td>

                                    <td class="mht-td--heading" style="text-transform:capitalize">
                                        {{ $rec->heading ?? '—' }}
                                    </td>

                                    <td class="mht-td--date">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                                            class="mht-files-pill"
                                            title="View {{ count($rec->images) }} file(s)"
                                            target="_blank">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48" />
                                            </svg>
                                            {{ count($rec->images) }} file{{ count($rec->images) > 1 ? 's' : '' }}
                                        </a>
                                        @else
                                        <span class="mht-no-files">—</span>
                                        @endif
                                    </td>

                                    {{-- NO action column — partner cannot edit/delete --}}

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="mht-empty">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            <p>No medical records found for this patient.</p>
                        </div>
                        @endif
                    </div>

                    {{-- ── Pagination ── --}}
                    @if($histories->lastPage() > 1)
                    <div class="mht-pagination">
                        @if($histories->onFirstPage())
                        <span class="mht-page-btn mht-page-btn--disabled">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="15 18 9 12 15 6" />
                            </svg>
                        </span>
                        @else
                        <a href="{{ $histories->previousPageUrl() }}" class="mht-page-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="15 18 9 12 15 6" />
                            </svg>
                        </a>
                        @endif

                        @php
                        $current = $histories->currentPage();
                        $last = $histories->lastPage();
                        $pages = [];
                        $pages[] = 1;
                        if ($current > 4) $pages[] = '...';
                        for ($p = max(2, $current - 1); $p <= min($last - 1, $current + 1); $p++) $pages[]=$p;
                            if ($current < $last - 3) $pages[]='...' ;
                            if ($last> 1) $pages[] = $last;
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
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </a>
                            @else
                            <span class="mht-page-btn mht-page-btn--disabled">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </span>
                            @endif
                    </div>
                    @endif

                </div>{{-- end mht-wrap --}}


                {{-- ── Full Vitals Card (read-only) ── --}}
                <div class="up-card" style="margin-top:20px">
                    <div class="up-card__head">
                        <div class="up-card__title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                            Patient Vitals (Full View)
                        </div>
                        <span style="font-size:.7rem;color:var(--muted);font-weight:700">
                            Updated: {{ ($vital && $vital->updated_at) ? \Carbon\Carbon::parse($vital->updated_at)->format('d M Y') : 'N/A' }}
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
</body>

</html>