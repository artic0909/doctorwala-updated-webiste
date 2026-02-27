@extends('frontend.layout.app')

@section('title', $path->clinic_name . ' - ' . $path->clinic_contact_person_name . ' - ' . $path->clinic_address . ' - DoctorWala.info')

@section('content')

<head>
    @foreach($tests as $test)
    <meta name="test-{{$test->id}}-title" content="Get Details of {{$test->test_name}} - Type: {{$test->test_type}} | Affordable Prices">
    <meta name="test-{{$test->id}}-description" content="Check {{$test->test_name}} details, categorized under {{$test->test_type}}. Price: ₹{{$test->test_price}}. Available at convenient timings.">
    <meta name="test-{{$test->id}}-keywords" content="Pathology Test, {{$test->test_name}}, {{$test->test_type}}, Lab Test, Price, Availability">
    <meta name="test-{{$test->id}}-author" content="Pathology Lab">

    <!-- Open Graph Tags -->
    <meta property="og:test-{{$test->id}}-title" content="{{$test->test_name}} - {{$test->test_type}}">
    <meta property="og:test-{{$test->id}}-description" content="Avail {{$test->test_name}} at ₹{{$test->test_price}}. Check timings and availability.">
    <meta property="og:test-{{$test->id}}-image" content="{{ asset('img/path.png') }}">
    <meta property="og:test-{{$test->id}}-url" content="{{ url()->current() }}/test/{{$test->id}}">
    @endforeach

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">
    <link href="{{asset('../css/all-opd-pathology-doctor-details.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/allopdpathdoc_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('./css/single-path.css')}}" rel="stylesheet">


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
            <a href="/pathology">Pathology</a><span>›</span>
            <span>{{ $path->clinic_name }}</span>
        </div>
        @endguest
        @auth
        <div class="bc">
            <a href="/dw">Home</a><span>›</span>
            <a href="/dw/pathology">Pathology</a><span>›</span>
            <span>{{ $path->clinic_name }}</span>
        </div>
        @endauth

        <div class="clinic-row">
            <div class="clinic-thumb">
                @if($path->banner && $path->banner->pathologybanner)
                <img src="{{ asset('storage/' . $path->banner->pathologybanner) }}" alt="{{ $path->clinic_name }}">
                @else
                <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="Default">
                @endif
            </div>

            <div class="clinic-info">
                <div class="clinic-tag">✦ Jio Ji Bharka · Doctorwala.info</div>
                <div class="clinic-name">{{ $path->clinic_name }}</div>
                <div class="clinic-meta-row">
                    <span>
                        <i class="fa fa-map-marker-alt"></i>
                        {{ $path->clinic_address }}{{ $path->clinic_landmark ? ', ' . $path->clinic_landmark : '' }} — {{ $path->clinic_state }}, {{ $path->clinic_city }}
                    </span>
                    <span>
                        <i class="fa fa-phone"></i>
                        <a href="tel:{{ $path->clinic_mobile_number }}">+91-{{ $path->clinic_mobile_number }}</a>
                    </span>
                    @if($path->clinic_email)
                    <span>
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:{{ $path->clinic_email }}">{{ $path->clinic_email }}</a>
                    </span>
                    @endif
                    @if($path->clinic_contact_person_name)
                    <span><i class="fa fa-user"></i> {{ $path->clinic_contact_person_name }}</span>
                    @endif
                </div>
            </div>

            <div class="clinic-actions">
                <!-- <button class="btn btn-book" onclick="openM('inquiryModal{{ $path->id }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    Book
                </button> -->
                <a href="tel:{{ $path->clinic_mobile_number }}" class="btn btn-call">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                    </svg>
                    Call
                </a>
                @if($path->clinic_google_map_link)
                <a href="{{ $path->clinic_google_map_link }}" target="_blank" class="btn btn-ghost">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="3 11 22 2 13 21 11 13 3 11" />
                    </svg>
                    Map
                </a>
                @endif
                <button class="btn btn-ghost" onclick="openM('feedbackModal{{ $path->id }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                    Feedback
                </button>
            </div>
        </div>
    </div>

    <svg class="hero-wave" viewBox="0 0 1440 32" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,16 C360,32 720,0 1080,20 C1260,28 1360,14 1440,16 L1440,32 H0Z" fill="#f7fbfd" />
    </svg>
</div>

{{-- ══ TABS ════════════════════════════════════════════════════ --}}
<div class="tabs-wrap">
    <div class="tabs-scroll">
        <button class="tab-btn active" data-tab="pathology">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" />
            </svg>
            Pathology
            @if(!$tests->isEmpty())
            <span class="tab-pill">{{ $tests->count() }}</span>
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

    {{-- ── PATHOLOGY TAB ───────────────────────────────────── --}}
    <div class="tab-panel active" id="tab-pathology">
        <div class="sec-label">Pathology Details</div>

        @if($tests->isEmpty())
        <div class="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" />
            </svg>
            <p>No tests found. Please try again later.</p>
        </div>
        @else
        <div class="test-list">
            @foreach($tests as $test)
            <div class="test-card" id="tc-{{ $test->id }}">

                {{-- Always-visible top bar --}}
                <div class="test-top" onclick="toggleTest('tc-{{ $test->id }}')">
                    <div class="test-icon">
                        <img src="{{ asset('img/path.png') }}" alt="Test">
                    </div>

                    <div>
                        <div class="test-name">{{ $test->test_name }}</div>
                        <div class="test-chips">
                            <span class="chip chip-type">
                                <svg style="width:10px;height:10px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18" />
                                </svg>
                                {{ $test->test_type }}
                            </span>
                            <span class="chip chip-price">₹ {{ $test->test_price }}</span>
                            @php
                            $sc = 'chip-def';
                            if($test->status == 'Available') $sc = 'chip-ok';
                            elseif($test->status == 'Unavailable') $sc = 'chip-no';
                            @endphp
                            <span class="chip {{ $sc }}">
                                <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block"></span>
                                {{ $test->status ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="test-toggle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </div>
                </div>

                {{-- Expandable body --}}
                <div class="test-body">
                    <div class="test-body-inner">

                        {{-- Schedule --}}
                        <div class="schedule-wrap">
                            <div class="schedule-label">📅 Test Schedule</div>
                            @if(!empty($test->test_day_time) && is_array($test->test_day_time))
                            <table class="sch-table">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>From</th>
                                        <th>To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($test->test_day_time as $slot)
                                    <tr>
                                        <td><strong style="color:var(--navy)">{{ $slot['day'] }}</strong></td>
                                        <td>
                                            @if(!empty($slot['start_time']))
                                            {{ \Carbon\Carbon::parse($slot['start_time'])->format('h:i A') }}
                                            @else
                                            <span style="color:var(--muted)">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($slot['end_time']))
                                            {{ \Carbon\Carbon::parse($slot['end_time'])->format('h:i A') }}
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
                        <div class="test-aside">
                            <div>
                                <div class="dib-label">Test Type</div>
                                <div class="dib-val">{{ $test->test_type }}</div>
                            </div>
                            <div>
                                <div class="dib-label">Test Price</div>
                                <div class="dib-val" style="color:var(--teal);font-size:17px;font-weight:800">₹ {{ $test->test_price }}</div>
                            </div>
                            <div>
                                <div class="dib-label">Availability</div>
                                <div>
                                    @if($test->status == 'Available')
                                    <span class="chip chip-ok">
                                        <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block"></span>
                                        Available
                                    </span>
                                    @elseif($test->status == 'Unavailable')
                                    <span class="chip chip-no">
                                        <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block"></span>
                                        Unavailable
                                    </span>
                                    @else
                                    <span class="chip chip-def">{{ $test->status ?? 'N/A' }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="test-btns">
                                <button class="btn-appt" onclick="openM('inquiryModal{{ $path->id }}', '{{ $test->id }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    Book Appointment
                                </button>
                                <a href="tel:{{ $path->clinic_mobile_number }}" class="btn-appt-call">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                                    </svg>
                                    Call Lab
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

    {{-- ── PHOTOS TAB ──────────────────────────────────────── --}}
    <div class="tab-panel" id="tab-photos">
        <div class="sec-label">Lab Photos</div>
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

    {{-- ── ABOUT TAB ───────────────────────────────────────── --}}
    <div class="tab-panel" id="tab-about">
        <div class="sec-label">About Lab</div>
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
<div class="modal-ov" id="inquiryModal{{ $path->id }}">
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
            <button class="mclose" onclick="closeM('inquiryModal{{ $path->id }}')">&times;</button>
        </div>
        <div class="mbody">
            <form action="{{ route('dw.pathology.inquiry.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="currently_loggedin_partner_id" value="{{ $path->currently_loggedin_partner_id }}">
                <input type="hidden" name="clinic_type" value="Pathology">
                <input type="hidden" name="dw_user_id" value="{{ $user->id ?? '' }}">
                <input type="text" name="test_id" id="test_id_field">
                <div class="fg">
                    <div class="fgrp">
                        <label class="flbl">Inquiry About</label>
                        <input class="fc" name="clinic_name" value="{{ $path->clinic_name }}" readonly>
                    </div>
                    <div class="fr">
                        <div class="fgrp">
                            <label class="flbl">Your Name</label>
                            @auth
                            <input class="fc" name="user_name" value="{{ $user->user_name }}" readonly>
                            @endauth
                            @guest
                            <input class="fc" name="user_name" placeholder="Your name" required>
                            @endguest
                        </div>
                        <div class="fgrp">
                            <label class="flbl">Mobile *</label>
                            @auth
                            <input class="fc" name="user_mobile" type="tel" value="{{ $user->user_mobile }}">
                            @endauth
                            @guest
                            <input class="fc" name="user_mobile" type="tel" placeholder="Mobile number" required>
                            @endguest
                        </div>
                    </div>
                    <div class="fgrp">
                        <label class="flbl">Email</label>
                        @auth
                        <input class="fc" name="user_email" type="email" value="{{ $user->user_email }}" readonly>
                        @endauth
                        @guest
                        <input class="fc" name="user_email" type="email" placeholder="Email address" required>
                        @endguest
                    </div>
                    <div class="fr">
                        <div class="fgrp"><label class="flbl">Appointment Booking Date *</label>
                            @auth<input class="fc" type="date" name="booking_date" value="{{ $user->booking_date ?? '' }}">@endauth
                            @guest<input class="fc" name="booking_date" type="date" required>@endguest
                        </div>
                        <div class="fgrp"><label class="flbl">Appointment Booking Time *</label>
                            @auth<input class="fc" name="booking_time" type="time" value="{{ $user->booking_time ?? '' }}">@endauth
                            @guest<input class="fc" name="booking_time" type="time" required>@endguest
                        </div>
                    </div>
                    <div class="fgrp">
                        <label class="flbl">Visit Mode *</label>

                        <select name="visit_mode" class="fc" required>
                            <option value="">Select Visit Mode</option>

                            <option value="offline"
                                {{ old('visit_mode', auth()->check() ? ($user->visit_mode ?? 'offline') : 'offline') == 'offline' ? 'selected' : '' }}>
                                Offline
                            </option>

                            <option value="online"
                                {{ old('visit_mode', auth()->check() ? ($user->visit_mode ?? 'offline') : 'offline') == 'online' ? 'selected' : '' }}>
                                Online
                            </option>

                        </select>
                    </div>

                    <div class="fgrp"><label class="flbl">Describe your concern *</label>
                        <textarea class="fc" name="user_inquiry" rows="3" placeholder="Describe your concern..." required></textarea>
                    </div>
                    <button type="submit" class="btn-sub btn-sub-red">Book Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Feedback --}}
<div class="modal-ov" id="feedbackModal{{ $path->id }}">
    <div class="modal-box">
        <div class="mhead">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                </svg>
                Your Feedback
            </h3>
            <button class="mclose" onclick="closeM('feedbackModal{{ $path->id }}')">&times;</button>
        </div>
        <div class="mbody">
            <form action="{{ route('dw.pathology.rating.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="currently_loggedin_partner_id" value="{{ $path->currently_loggedin_partner_id }}">
                <input type="hidden" name="clinic_type" value="Pathology">
                <input type="hidden" name="clinic_name" value="{{ $path->clinic_name }}">
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

{{-- Result Modals --}}
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

{{-- ══ JS ═══════════════════════════════════════════════════════ --}}
<script>
    // Test accordion
    function toggleTest(id) {
        const card = document.getElementById(id);
        const isOpen = card.classList.contains('open');
        document.querySelectorAll('.test-card.open').forEach(c => c.classList.remove('open'));
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
    function openM(id, testId = null) {
        const e = document.getElementById(id);

        if (e) {
            e.classList.add('open');
            document.body.style.overflow = 'hidden';

            if (testId) {
                const input = e.querySelector('input[name="test_id"]');
                if (input) {
                    input.value = testId;
                }
            }
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