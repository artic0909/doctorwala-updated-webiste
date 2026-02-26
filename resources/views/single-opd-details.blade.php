@extends('frontend.layout.app')

@section('title', $opd->clinic_name . ' - ' . $opd->clinic_contact_person_name . ' - ' . $opd->clinic_address . ' - DoctorWala.info')

@section('content')

<head>
    @foreach($doctors as $doctor)
    <meta name="doctor-{{$doctor->id}}-title" content="Find Top Doctor - {{$doctor->doctor_name}} | Specialization: {{$doctor->doctor_specialist}}">
    <meta name="doctor-{{$doctor->id}}-description" content="Consult with {{$doctor->doctor_name}}, a {{$doctor->doctor_specialist}}. Fees: ₹{{$doctor->doctor_fees}}. Check availability and clinic hours.">
    <meta name="doctor-{{$doctor->id}}-keywords" content="Doctor, doctorwala, doctorwala.info, {{$doctor->doctor_name}}, {{$doctor->doctor_specialist}}, Consultation, Fees, {{$doctor->clinic_city ?? 'Unknown City'}}, {{$doctor->clinic_state ?? 'Unknown State'}}">
    <meta name="doctor-{{$doctor->id}}-author" content="{{$doctor->doctor_name}}">

    <!-- Open Graph Tags -->
    <meta property="og:doctor-{{$doctor->id}}-title" content="{{$doctor->doctor_name}} - {{$doctor->doctor_specialist}}">
    <meta property="og:doctor-{{$doctor->id}}-description" content="Consult {{$doctor->doctor_name}}, a specialist in {{$doctor->doctor_specialist}}. Fees: ₹{{$doctor->doctor_fees}}.">
    <meta property="og:doctor-{{$doctor->id}}-image" content="{{ asset('img/doctor.png') }}">
    <meta property="og:doctor-{{$doctor->id}}-url" content="{{ url()->current() }}/doctor/{{$doctor->id}}">
    @endforeach

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">
    <link href="{{asset('./css/single-opd.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">
    <link href="{{asset('./css/all-opd-pathology-doctor-details.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/allopdpathdoc_responsive.css')}}" rel="stylesheet">

    <style>
        .footer-content {
            display: none !important;
        }
        .partner-login {
            display: none !important;
        }
    </style>

</head>


{{-- ══ COMPACT HERO STRIP ══════════════════════════════════════ --}}
<div class="hero-strip">
    <div class="hero-inner">
        @guest
        <div class="bc">
            <a href="/">Home</a><span>›</span>
            <a href="/opd">OPD</a><span>›</span>
            <span>{{ $opd->clinic_name }}</span>
        </div>
        @endguest
        @auth
        <div class="bc">
            <a href="/dw">Home</a><span>›</span>
            <a href="/dw/opd">OPD</a><span>›</span>
            <span>{{ $opd->clinic_name }}</span>
        </div>
        @endauth

        <div class="clinic-row">
            {{-- Clinic thumb --}}
            <div class="clinic-thumb">
                @if($opd->banner && $opd->banner->opdbanner)
                <img src="{{ asset('storage/' . $opd->banner->opdbanner) }}" alt="{{ $opd->clinic_name }}">
                @else
                <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="">
                @endif
            </div>

            {{-- Info --}}
            <div class="clinic-info">
                <div class="clinic-tag">✦ Jio Ji Bharka · Doctorwala.info</div>
                <div class="clinic-name">{{ $opd->clinic_name }}</div>
                <div class="clinic-meta-row">
                    <span>
                        <i class="fa fa-map-marker-alt"></i>
                        {{ $opd->clinic_address }}{{ $opd->clinic_landmark ? ', '.$opd->clinic_landmark : '' }} — {{ $opd->clinic_state }}, {{ $opd->clinic_city }}
                    </span>
                    <span>
                        <i class="fa fa-phone"></i>
                        <a href="tel:{{ $opd->clinic_mobile_number }}">+91-{{ $opd->clinic_mobile_number }}</a>
                    </span>
                    @if($opd->clinic_email)
                    <span>
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:{{ $opd->clinic_email }}">{{ $opd->clinic_email }}</a>
                    </span>
                    @endif
                    @if($opd->clinic_contact_person_name)
                    <span><i class="fa fa-user"></i> {{ $opd->clinic_contact_person_name }}</span>
                    @endif
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="clinic-actions">
                <button class="btn btn-book" onclick="openM('inquiryModal{{ $opd->id }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Book
                </button>
                <a href="tel:{{ $opd->clinic_mobile_number }}" class="btn btn-call">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                    </svg>
                    Call
                </a>
                @if($opd->clinic_google_map_link)
                <a href="{{ $opd->clinic_google_map_link }}" target="_blank" class="btn btn-ghost">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="3 11 22 2 13 21 11 13 3 11" />
                    </svg>
                    Map
                </a>
                @endif
                <button class="btn btn-ghost" onclick="openM('feedbackModal{{ $opd->id }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                    Feedback
                </button>
            </div>
        </div>
    </div>

    <svg class="hero-wave" viewBox="0 0 1440 32" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,16 C360,32 720,0 1080,20 C1260,28 1360,14 1440,16 L1440,32 H0Z" fill="#edf6fb" />
    </svg>
</div>

{{-- ══ TABS ════════════════════════════════════════════════════ --}}
<div class="tabs-wrap">
    <div class="tabs-scroll">
        <button class="tab-btn active" data-tab="opd">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
            </svg>
            OPD
            @if(!$doctors->isEmpty())
            <span class="tab-pill">{{ $doctors->count() }}</span>
            @endif
        </button>
        <button class="tab-btn" data-tab="services">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="16" />
                <line x1="8" y1="12" x2="16" y2="12" />
            </svg>
            Services
        </button>
        <button class="tab-btn" data-tab="photos">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <polyline points="21 15 16 10 5 21" />
            </svg>
            Photos
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

{{-- ══ CONTENT ═════════════════════════════════════════════════ --}}
<div class="content">

    {{-- ── OPD TAB ────────────────────────────────────────── --}}
    <div class="tab-panel active" id="tab-opd">
        <div class="sec-label">OPD Details</div>

        @if($doctors->isEmpty())
        <div class="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                <circle cx="9" cy="7" r="4" />
            </svg>
            <p>No doctors found. Please try again later.</p>
        </div>
        @else
        <div class="doc-list">
            @foreach($doctors as $doctor)
            <div class="doc-card" id="dc-{{ $doctor->id }}">

                {{-- Always-visible top bar — click to expand --}}
                <div class="doc-top" onclick="toggleDoc('dc-{{ $doctor->id }}')">
                    <div class="doc-avatar">
                        <img src="{{ asset('img/doctor.png') }}" alt="Dr">
                    </div>

                    <div class="doc-head">
                        <div class="doc-name">{{ $doctor->doctor_designation }}. {{ $doctor->doctor_name }}</div>
                        <div class="doc-chips">
                            <span class="chip chip-spec">
                                <svg style="width:10px;height:10px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                                </svg>
                                {{ $doctor->doctor_specialist }}
                            </span>
                            <span class="chip chip-fee">₹ {{ $doctor->doctor_fees }}</span>
                            @php
                            $statusChip = 'chip-stat-def';
                            if($doctor->status == 'Available') $statusChip = 'chip-stat-ok';
                            elseif($doctor->status == 'Unavailable') $statusChip = 'chip-stat-no';
                            @endphp
                            <span class="chip {{ $statusChip }}">
                                <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block"></span>
                                {{ $doctor->status ?? 'Status N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="doc-toggle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </div>
                </div>

                {{-- Expandable body — schedule + info + actions --}}
                <div class="doc-body">
                    <div class="doc-body-inner">

                        {{-- Schedule --}}
                        <div class="schedule-wrap">
                            <div class="schedule-label">📅 Weekly Schedule</div>
                            @if(!empty($doctor->visit_day_time) && is_array($doctor->visit_day_time))
                            <table class="sch-table">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>From</th>
                                        <th>To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctor->visit_day_time as $visit)
                                    <tr>
                                        <td><strong style="color:var(--navy)">{{ $visit['day'] }}</strong></td>
                                        <td>
                                            @if(!empty($visit['start_time']))
                                            {{ \Carbon\Carbon::parse($visit['start_time'])->format('h:i A') }}
                                            @else
                                            <span style="color:var(--muted)">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($visit['end_time']))
                                            {{ \Carbon\Carbon::parse($visit['end_time'])->format('h:i A') }}
                                            @else
                                            <span style="color:var(--muted)">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p style="color:var(--muted);font-size:13px;padding:8px 0">No schedule available.</p>
                            @endif
                        </div>

                        {{-- Info + actions --}}
                        <div class="doc-aside">
                            <div class="doc-info-block">
                                <div class="dib-label">Specialization</div>
                                <div class="dib-val"><strong>{{ $doctor->doctor_specialist }}</strong></div>
                            </div>
                            <div class="doc-info-block">
                                <div class="dib-label">Qualification</div>
                                <div class="dib-val">{{ $doctor->doctor_more }}</div>
                            </div>
                            <div class="doc-info-block">
                                <div class="dib-label">Consultation Fee</div>
                                <div class="dib-val" style="color:var(--teal);font-size:16px">₹ {{ $doctor->doctor_fees }}</div>
                            </div>
                            @if($doctor->doctor_more)
                            <div class="doc-info-block">
                                <div class="dib-label">About / Qualifications</div>
                                <div class="dib-val dib-val--note">{{ $doctor->doctor_more }}</div>
                            </div>
                            @endif

                            <div class="doc-btns">
                                <button class="btn-appt" onclick="openM('inquiryModal{{ $opd->id }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    Book Appointment
                                </button>
                                <a href="tel:{{ $opd->clinic_mobile_number }}" class="btn-appt-call">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                                    </svg>
                                    Call Clinic
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
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
            <p>No services found. Please try again later.</p>
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
            @endif
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── PHOTOS TAB ──────────────────────────────────────── --}}
    <div class="tab-panel" id="tab-photos">
        <div class="sec-label">Clinic Photos</div>
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
            @endif
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── ABOUT TAB ───────────────────────────────────────── --}}
    <div class="tab-panel" id="tab-about">
        <div class="sec-label">About Clinic</div>
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
                <span class="ab-tag">About Us</span>
                <h3>Our Story</h3>
                <p>{{ $ac->about_details }}</p>
            </div>
            <div class="about-block about-block--teal">
                <span class="ab-tag ab-tag--teal">Mission</span>
                <h3>Our Mission</h3>
                <p>{{ $ac->mission_details }}</p>
            </div>
            <div class="about-block about-block--red">
                <span class="ab-tag ab-tag--red">Vision</span>
                <h3>Our Vision</h3>
                <p>{{ $ac->vision_details }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>

</div>{{-- /content --}}

{{-- ══ MODALS ══════════════════════════════════════════════════ --}}

{{-- Book Appointment --}}
<div class="modal-ov" id="inquiryModal{{ $opd->id }}">
    <div class="modal-box">
        <div class="mhead">
            <h3><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>Book Appointment</h3>
            <button class="mclose" onclick="closeM('inquiryModal{{ $opd->id }}')">&times;</button>
        </div>
        <div class="mbody">
            <form action="{{ route('dw.opd.inquiry.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="currently_loggedin_partner_id" value="{{ $opd->currently_loggedin_partner_id }}">
                <input type="hidden" name="clinic_type" value="OPD">
                <div class="fg">
                    <div class="fgrp"><label class="flbl">Clinic</label><input class="fc" name="clinic_name" value="{{ $opd->clinic_name }}" readonly></div>
                    <div class="fr">
                        <div class="fgrp"><label class="flbl">Name</label>
                            @auth<input class="fc" name="user_name" value="{{ $user->user_name }}" readonly>@endauth
                            @guest<input class="fc" name="user_name" value="Guest" readonly>@endguest
                        </div>
                        <div class="fgrp"><label class="flbl">Mobile *</label>
                            @auth<input class="fc" name="user_mobile" type="tel" value="{{ $user->user_mobile }}">@endauth
                            @guest<input class="fc" name="user_mobile" type="tel" placeholder="Mobile number" required>@endguest
                        </div>
                    </div>
                    <div class="fgrp"><label class="flbl">Email</label>
                        @auth<input class="fc" name="user_email" type="email" value="{{ $user->user_email }}" readonly>@endauth
                        @guest<input class="fc" name="user_email" type="email" placeholder="Email address" required>@endguest
                    </div>
                    <div class="fgrp"><label class="flbl">Message *</label>
                        <textarea class="fc" name="user_inquiry" rows="3" placeholder="Describe your concern..." required></textarea>
                    </div>
                    <button type="submit" class="btn-sub btn-sub-red">Book Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Feedback --}}
<div class="modal-ov" id="feedbackModal{{ $opd->id }}">
    <div class="modal-box">
        <div class="mhead">
            <h3><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                </svg>Your Feedback</h3>
            <button class="mclose" onclick="closeM('feedbackModal{{ $opd->id }}')">&times;</button>
        </div>
        <div class="mbody">
            <form action="{{ route('dw.opd.rating.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="currently_loggedin_partner_id" value="{{ $opd->currently_loggedin_partner_id }}">
                <input type="hidden" name="clinic_type" value="OPD">
                <input type="hidden" name="clinic_name" value="{{ $opd->clinic_name }}">
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
                        <div class="fgrp"><label class="flbl">Name</label>
                            @auth<input class="fc" name="user_name" value="{{ $user->user_name }}" readonly>@endauth
                            @guest<input class="fc" name="user_name" value="Guest" readonly>@endguest
                        </div>
                        <div class="fgrp"><label class="flbl">Email</label>
                            @auth<input class="fc" name="user_email" value="{{ $user->user_email }}">@endauth
                            @guest<input class="fc" name="user_email" placeholder="Your email">@endguest
                        </div>
                    </div>
                    <div class="fgrp"><label class="flbl">Feedback *</label>
                        <textarea class="fc" name="feedback" rows="3" placeholder="Share your experience..." required></textarea>
                    </div>
                    <button type="submit" class="btn-sub btn-sub-teal">Send Feedback</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Photo Viewer --}}
<div class="modal-ov" id="photoViewer">
    <div class="modal-box">
        <div class="mhead">
            <h3><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                </svg>Photo</h3>
            <button class="mclose" onclick="closeM('photoViewer')">&times;</button>
        </div>
        <div class="mbody"><img id="pvImg" class="pv-img" src="" alt="Photo"></div>
    </div>
</div>

{{-- Result modals --}}
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
                <button class="btn-sub btn-sub-red" onclick="closeM('inqurySendUnsuccessModal')">Close</button>
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
                <button class="btn-sub btn-sub-red" onclick="closeM('feedSendUnsuccessModal')">Close</button>
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


<!-- {{-- ══ JS ═══════════════════════════════════════════════════════ --}} -->
<script>
    // Doctor accordion — expand inline
    function toggleDoc(id) {
        const card = document.getElementById(id);
        const isOpen = card.classList.contains('open');
        // Close all others
        document.querySelectorAll('.doc-card.open').forEach(c => c.classList.remove('open'));
        if (!isOpen) card.classList.add('open');
    }

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

@endsection