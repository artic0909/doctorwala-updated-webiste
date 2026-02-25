@extends('frontend.layout.app')

@section('title', 'Doctorwala | Your Medical Ecosystem')

@section('content')

<head>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Search for doctors, specialists, and pathology types. Find the best healthcare options tailored to your needs.">
    <meta name="keywords" content="{{ implode(',', $specialists->toArray()) }}, {{ implode(',', $types->toArray()) }}, doctor, specialist, pathology, doctorwala.info, doctor wala, DoctorWala, Doctorwala, doctorwala">

    <meta property="og:title" content="Search for Doctors, Specialists, and Pathology">
    <meta property="og:description" content="Explore various healthcare options. Search for doctors, specialists, or pathology types on our platform.">
    <meta property="og:url" content="{{ url('/') }}">

    <meta name="twitter:title" content="Search for Doctors, Specialists, and Pathology">
    <meta name="twitter:description" content="Explore various healthcare options. Search for doctors, specialists, or pathology types on our platform.">






    <!-- SEO Meta Tags for about us -->
    @foreach($aboutDetails as $aboutDetail)
    <meta name="description" content="{{ $aboutDetail->ab_b_txt }}">
    <meta name="keywords" content="about us, doctorwala, mission, healthcare options, doctorwala.info, doctorwala.in, doctorwala.com, doctorwala, doctor wala, DoctorWala, Doctorwala, doctorwala">
    <meta property="og:title" content="About Doctorwala">
    <meta property="og:description" content="{{ $aboutDetail->ab_desc }}">
    <meta property="og:url" content="{{ url('/about') }}">
    <meta name="twitter:title" content="About Doctorwala">
    <meta name="twitter:description" content="{{ $aboutDetail->ab_desc }}">
    <meta name="twitter:email" content="{{ $aboutDetail->email }}">
    <meta name="twitter:phone" content="{{ $aboutDetail->number }}">
    @endforeach



    <!-- SEO Meta Tags for all OPD -->
    @foreach($opds as $opd)
    <meta name="description" content="{{$opd->clinic_city}}, {{$opd->clinic_landmark}} - Doctorwala">
    <meta name="keywords" content="{{$opd->clinic_name}}, {{$opd->clinic_city}}, {{$opd->clinic_pincode}}, {{$opd->clinic_landmark}}, doctorwala, doctorwala.info, doctorwala.in, doctorwala.com, doctorwala">
    <meta property="og:title" content="{{$opd->clinic_name}} - Doctorwala">
    <meta property="og:description" content="{{$opd->clinic_city}}, {{$opd->clinic_landmark}} - Doctorwala">
    <meta property="og:url" content="{{url('/opd/'.$opd->slug)}}">
    <meta name="twitter:title" content="{{$opd->clinic_name}} - Doctorwala">
    <meta name="twitter:description" content="{{$opd->clinic_city}},{{$opd->clinic_pincode}} - Doctorwala">
    @endforeach



    <!-- SEO Meta Tags for all Pathology -->
    @foreach($paths as $path)
    <meta name="description" content="{{$path->clinic_city}}, {{$path->clinic_landmark}} - Doctorwala">
    <meta name="keywords" content="{{$path->clinic_name}}, {{$path->clinic_city}}, {{$path->clinic_pincode}}, {{$path->clinic_landmark}}, doctorwala, doctorwala.info, doctorwala.in, doctorwala.com, doctorwala">
    <meta property="og:title" content="{{$path->clinic_name}} - Doctorwala">
    <meta property="og:description" content="{{$path->clinic_city}}, {{$path->clinic_landmark}} - Doctorwala">
    <meta property="og:url" content="{{url('/path/'.$path->slug)}}">
    <meta name="twitter:title" content="{{$path->clinic_name}} - Doctorwala">
    <meta name="twitter:description" content="{{$path->clinic_city}},{{$path->clinic_pincode}} - Doctorwala">
    @endforeach



    <!-- SEO Meta Tags for all Doctor -->
    @foreach($docs as $doc)
    <meta name="description" content="{{$doc->partner_doctor_city}},{{$doc->partner_doctor_pincode}}, {{$doc->partner_doctor_landmark}} - Doctorwala">
    <meta name="keywords" content="{{$doc->partner_doctor_name}}, {{$doc->partner_doctor_city}},{{$doc->partner_doctor_pincode}}, {{$doc->partner_doctor_landmark}}, doctorwala, doctorwala.info, doctorwala.in, doctorwala.com, doctorwala">
    <meta property="og:title" content="{{$doc->partner_doctor_name}} - Doctorwala">
    <meta property="og:description" content="{{$doc->partner_doctor_city}},{{$doc->partner_doctor_pincode}}, {{$doc->partner_doctor_landmark}} - Doctorwala">
    <meta property="og:url" content="{{url('/doctor/'.$doc->slug)}}">
    <meta name="twitter:title" content="{{$doc->partner_doctor_name}} - Doctorwala">
    <meta name="twitter:description" content="{{$doc->partner_doctor_city}},{{$doc->partner_doctor_pincode}} - Doctorwala">
    @endforeach



    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">


    <!-- Favicon -->
    <style>
        .doctor-item {
            border-bottom: 1px solid #07a1cf;
            padding: 6px 0;
            color: black;
        }

        .doctor-name,
        .doctor-specialist {
            white-space: nowrap;
            /* Force single line */
            overflow: hidden;
            /* Hide extra text */
            text-overflow: ellipsis;
            /* Add ... */
            width: 100%;
            display: block;
        }

        .doctor-specialist {
            color: #0D6EFD;
            font-size: 0.85rem;
        }
    </style>

</head>





<!-- Search Banner -->
@guest
<div class="container search-banner-section">
    <div class="search-cards-row">

        <!-- {{-- Card 1: Search All --}} -->
        <form action="{{ route('search.result') }}" method="GET" class="search-card search-card-all wow zoomIn" data-wow-delay="0.1s">
            <div class="search-card-header">
                <div class="search-card-icon">
                    <i class="fa fa-magnifying-glass"></i>
                </div>
                <div>
                    <h3>Search Your Direct to Doctor</h3>
                    <p>Doctor's name, Address, OPD, Pathology & All</p>
                </div>
            </div>

            <input type="hidden" name="category" value="all">

            <div class="search-input-wrap">
                <i class="fa fa-search"></i>
                <input type="text" name="query" class="form-control"
                    placeholder="Search for Doctor / Path / OPD">
            </div>

            <button type="submit" class="btn btn-search">
                <i class="fa fa-search"></i> Search Now
            </button>

        </form>

        <!-- {{-- Card 2: Search OPD --}} -->
        <form action="{{ route('search.result') }}" method="GET" class="search-card search-card-opd wow zoomIn" data-wow-delay="0.2s">
            <div class="search-card-header">
                <div class="search-card-icon">
                    <i class="fa fa-hospital"></i>
                </div>
                <div>
                    <h3>Search Your OPD Doctor</h3>
                    <p>Find by specialist and type</p>
                </div>
            </div>
            <div class="search-input-wrap">
                <i class="fa fa-stethoscope"></i>
                <input type="hidden" name="category" value="opd">

                <select name="query" class="form-select">
                    <option selected disabled>Select Specialist</option>
                    @foreach($specialists as $specialist)
                    <option value="{{ $specialist }}">
                        {{ ucfirst($specialist) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button id="searchOpdButton" class="btn btn-search">
                <span class="spinner"></span>
                <span class="btn-text"><i class="fa fa-user-doctor"></i> Search OPD</span>
            </button>
        </form>

        <!-- {{-- Card 3: Search Pathology --}} -->
        <form action="{{ route('search.result') }}" method="GET" class="search-card search-card-path wow zoomIn" data-wow-delay="0.3s">
            <div class="search-card-header">
                <div class="search-card-icon">
                    <i class="fa fa-flask"></i>
                </div>
                <div>
                    <h3>Search Your Test Pathology</h3>
                    <p>Find by test type & name</p>
                </div>
            </div>
            <div class="search-input-wrap">
                <i class="fa fa-syringe"></i>
                <input type="hidden" name="category" value="pathology">

                <select name="query" class="form-select">
                    <option selected disabled>Select Type</option>
                    @foreach($types as $type)
                    <option value="{{ $type }}">
                        {{ ucfirst($type) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button id="searchPathologyButton" class="btn btn-search">
                <span class="spinner"></span>
                <span class="btn-text"><i class="fa fa-syringe"></i> Search Pathology</span>
            </button>
        </form>

    </div>
</div>
@endguest

@auth
<div class="container search-banner-section">
    <div class="search-cards-row">

        <!-- {{-- Card 1: Search All --}} -->
        <form action="{{ route('dw.search.result') }}" method="GET" class="search-card search-card-all wow zoomIn" data-wow-delay="0.1s">
            <div class="search-card-header">
                <div class="search-card-icon">
                    <i class="fa fa-magnifying-glass"></i>
                </div>
                <div>
                    <h3>Search Your Direct to Doctor</h3>
                    <p>Doctor's name, Address, OPD, Pathology & All</p>
                </div>
            </div>

            <input type="hidden" name="category" value="all">

            <div class="search-input-wrap">
                <i class="fa fa-search"></i>
                <input type="text" name="query" class="form-control"
                    placeholder="Search for Doctor / Path / OPD">
            </div>

            <button type="submit" class="btn btn-search">
                <i class="fa fa-search"></i> Search Now
            </button>

        </form>

        <!-- {{-- Card 2: Search OPD --}} -->
        <form action="{{ route('dw.search.result') }}" method="GET" class="search-card search-card-opd wow zoomIn" data-wow-delay="0.2s">
            <div class="search-card-header">
                <div class="search-card-icon">
                    <i class="fa fa-hospital"></i>
                </div>
                <div>
                    <h3>Search Your OPD Doctor</h3>
                    <p>Find by specialist and type</p>
                </div>
            </div>
            <div class="search-input-wrap">
                <i class="fa fa-stethoscope"></i>
                <input type="hidden" name="category" value="opd">

                <select name="query" class="form-select">
                    <option selected disabled>Select Specialist</option>
                    @foreach($specialists as $specialist)
                    <option value="{{ $specialist }}">
                        {{ ucfirst($specialist) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button id="searchOpdButton" class="btn btn-search">
                <span class="spinner"></span>
                <span class="btn-text"><i class="fa fa-user-doctor"></i> Search OPD</span>
            </button>
        </form>

        <!-- {{-- Card 3: Search Pathology --}} -->
        <form action="{{ route('dw.search.result') }}" method="GET" class="search-card search-card-path wow zoomIn" data-wow-delay="0.3s">
            <div class="search-card-header">
                <div class="search-card-icon">
                    <i class="fa fa-flask"></i>
                </div>
                <div>
                    <h3>Search Your Test Pathology</h3>
                    <p>Find by test type & name</p>
                </div>
            </div>
            <div class="search-input-wrap">
                <i class="fa fa-syringe"></i>
                <input type="hidden" name="category" value="pathology">

                <select name="query" class="form-select">
                    <option selected disabled>Select Type</option>
                    @foreach($types as $type)
                    <option value="{{ $type }}">
                        {{ ucfirst($type) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button id="searchPathologyButton" class="btn btn-search">
                <span class="spinner"></span>
                <span class="btn-text"><i class="fa fa-syringe"></i> Search Pathology</span>
            </button>
        </form>

    </div>
</div>
@endauth
<!-- Search Banner End -->



<!-- OPD Cards Start -->
<div class="container-fluid bg-primary bg-appointment my-2 wow fadeInUp opd-section" data-wow-delay="0.1s" style="margin-top: -30px;">
    <div class="container">

        <!-- Header + Buttons -->
        <div class="opd-controls">
            <div>
                <div class="section-badge">Available OPD</div>
                <h1>Display Your OPD / Clinics</h1>
            </div>
            <div class="opd-btn-group">
                <button class="opd-btn btn-prev-opd" aria-label="Previous" id="opdBtnPrev">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button class="opd-btn btn-next-opd" aria-label="Next" id="opdBtnNext">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Cards -->
        <div class="row overflow-hidden">
            <div class="col-12">
                <div class="scrolling-wrapper-opd" id="opdScrollWrapper">
                    @foreach($opds as $opd)
                    <div class="opd-card">

                        <!-- Image -->
                        <div class="opd-card-img-wrap">
                            @if($opd->banner && $opd->banner->opdbanner)
                            <img src="{{ asset('storage/' . $opd->banner->opdbanner) }}" alt="{{ $opd->clinic_name }}">
                            @else
                            <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="Default">
                            @endif
                            <span class="img-badge">OPD</span>
                        </div>

                        <!-- Body -->
                        <div class="opd-card-body">
                            @auth
                            <a href="{{ url('/dw/opd/'.$opd->slug) }}">
                                @endauth
                                @guest
                                <a href="{{ url('/opd/'.$opd->slug) }}">
                                    @endguest

                                    <p class="opd-card-title">{{ $opd->clinic_name }}</p>
                                    <div class="opd-card-divider"></div>

                                    <div class="opd-meta-row">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span>{{ $opd->clinic_city }}, {{ $opd->clinic_state }}, {{ $opd->clinic_pincode }}</span>
                                    </div>

                                    <div class="opd-meta-row">
                                        @if($opd->doctors && $opd->doctors->count())

                                        <ul style="margin:0; padding-left:18px; list-style:disc;">
                                            @foreach($opd->doctors->shuffle()->take(3) as $doctor)
                                            <li class="doctor-item">
                                                <div class="doctor-name">
                                                    {{ $doctor->doctor_name }}
                                                </div>
                                                <div class="doctor-specialist">
                                                    {{ $doctor->doctor_specialist }}
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <p>No Doctors Listed Yet</p>
                                        @endif
                                    </div>

                                    <div class="opd-meta-row">
                                        <i class="bi bi-cursor-fill"></i>
                                        <span>Click to view all doctors</span>
                                    </div>

                                </a>
                            </a>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Scroll Progress -->
        <div class="opd-progress-bar">
            <div class="opd-progress-fill" id="opdProgressFill"></div>
        </div>

    </div>
</div>
<!-- OPD Cards End -->


<!-- Pathology Cards Start -->
<div class="container-fluid bg-primary bg-appointment2 my-5 wow fadeInUp p-3 path-section" data-wow-delay="0.1s">
    <div class="container">

        <!-- Header + Buttons -->
        <div class="path-controls">
            <div>
                <div class="section-badge-path">Available Pathology</div>
                <h1>Display Your Test Pathology</h1>
            </div>
            <div class="path-btn-group">
                <button class="path-btn" id="pathBtnPrev" aria-label="Previous" id="pathBtnPrev">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button class="path-btn" id="pathBtnNext" aria-label="Next" id="pathBtnNext">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Cards -->
        <div class="row overflow-hidden">
            <div class="col-12">
                <div id="pathScrollWrapper" class="scrolling-wrapper-path" id="pathScrollWrapper">
                    @foreach($paths as $path)
                    <div class="path-card">

                        <div class="path-card-img-wrap">
                            @if($path->banner && $path->banner->pathologybanner)
                            <img src="{{ asset('storage/' . $path->banner->pathologybanner) }}" alt="{{ $path->clinic_name }}">
                            @else
                            <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="Default">
                            @endif
                            <span class="img-badge-path">Pathology</span>
                        </div>

                        <div class="path-card-body">
                            @auth
                            <a href="{{ url('/dw/pathology/'.$path->slug) }}">
                                @endauth
                                @guest
                                <a href="{{ url('/pathology/'.$path->slug) }}">
                                    @endguest
                                    <p class="path-card-title">{{ $path->clinic_name }}</p>
                                    <div class="path-card-divider"></div>
                                    <div class="path-meta-row">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span>{{ $path->clinic_city }}, {{ $path->clinic_state }}, {{ $path->clinic_pincode }}</span>
                                    </div>

                                    <div class="path-meta-row">
                                        @if($path->tests && $path->tests->count())

                                        <ul style="margin:0; padding-left:18px; list-style:disc;">
                                            @foreach($path->tests->shuffle()->take(3) as $test)
                                            <li class="doctor-item">
                                                <div class="doctor-name">
                                                    {{ $test->test_name }}
                                                </div>
                                                <div class="doctor-specialist">
                                                    {{ $test->test_type }}
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <p>No Tests Listed Yet</p>
                                        @endif
                                    </div>
                                    <div class="path-meta-row">
                                        <i class="bi bi-cursor-fill"></i>
                                        <span>Click to view all test pathology</span>
                                    </div>
                                </a>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Scroll Progress -->
        <div class="path-progress-bar">
            <div class="path-progress-fill" id="pathProgressFill"></div>
        </div>

    </div>
</div>
<!-- Pathology Cards End -->


<!-- Doctors Cards Start -->
<div class="container-fluid bg-primary bg-appointment3 my-5 wow fadeInUp p-3 doc-section" data-wow-delay="0.1s">
    <div class="container">

        <!-- Header + Buttons -->
        <div class="doc-controls">
            <div>
                <div class="section-badge-doc">Available Doctors</div>
                <h1>Direct to Doctors</h1>
            </div>
            <div class="doc-btn-group">
                <button class="doc-btn" id="docBtnPrev" aria-label="Previous">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button class="doc-btn" id="docBtnNext" aria-label="Next">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Cards -->
        <div class="row overflow-hidden">
            <div class="col-12">
                <div id="docScrollWrapper" class="scrolling-wrapper-doc">
                    @foreach($docs as $doc)
                    <div class="doc-card">

                        <!-- Image -->
                        <div class="doc-card-img-wrap">
                            @if($doc->banner && $doc->banner->doctorbanner)
                            <img src="{{ asset('storage/' . $doc->banner->doctorbanner) }}" alt="{{ $doc->partner_doctor_name }}">
                            @else
                            <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="Default">
                            @endif
                            <span class="img-badge-doc">Doctor</span>
                        </div>

                        <!-- Body -->
                        <div class="doc-card-body">
                            @auth
                            <a href="{{ url('/dw/doctor/'.$doc->slug) }}">
                                @endauth
                                @guest
                                <a href="{{ url('/doctor/'.$doc->slug) }}">
                                    @endguest

                                    <p class="doc-card-title">{{ $doc->partner_doctor_name }}</p>
                                    <div class="doc-card-divider"></div>

                                    <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-address">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span style="text-transform: capitalize; color:#0D6EFD; font-size: 0.8rem;">{{ $doc->partner_doctor_city }}, {{ $doc->partner_doctor_state}}, {{ $doc->partner_doctor_pincode }}</span>
                                    </a>
                                    <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-address">
                                        <i class="fa-solid fa-stethoscope"></i>
                                        <span style="color: black; font-size: 0.8rem; font-weight: 600;">{{$doc->partner_doctor_specialist}}</span>
                                    </a>

                                    <table class="table" style="font-size: 0.7rem;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Day</th>
                                                <th scope="col">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($doc->visit_day_time) && is_array($doc->visit_day_time))

                                            @php
                                            $limitedVisits = array_slice($doc->visit_day_time, 0, 3);
                                            $totalVisits = count($doc->visit_day_time);
                                            @endphp

                                            {{-- First 3 rows --}}
                                            @foreach($limitedVisits as $index => $visit)
                                            <tr>

                                                <td>{{ $visit['day'] ?? 'N/A' }}</td>

                                                <td>
                                                    @if(!empty($visit['start_time']) && !empty($visit['end_time']))
                                                    {{ \Carbon\Carbon::parse($visit['start_time'])->format('h:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($visit['end_time'])->format('h:i A') }}
                                                    @else
                                                    No time available
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                            {{-- 4th row message --}}
                                            @if($totalVisits > 3)
                                            <tr>
                                                <td colspan="4" class="text-center text-primary fw-semibold">
                                                    <a href="{{ url('/doctor/'.$doc->slug) }}">Click to see full timings →</a>
                                                </td>
                                            </tr>
                                            @endif

                                            @else
                                            <tr class="text-muted">
                                                <td colspan="4">No data found</td>
                                            </tr>
                                            @endif
                                        </tbody>


                                    </table>

                                </a>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Scroll Progress -->
        <div class="doc-progress-bar">
            <div class="doc-progress-fill" id="docProgressFill"></div>
        </div>

    </div>
</div>
<!-- Doctors Cards End -->




@guest
<!-- Join As Partner Start -->
<div class="container-fluid bg-offer my-4 py-4 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 wow zoomIn" data-wow-delay="0.6s">
                <div class="offer-text text-center rounded p-5">
                    <h1 class="display-5 text-white off-texts">Partner with Doctorwala.info to expand your services nationwide</h1>
                    <div class="d-flex g-3 flex-wrap justify-content-center ">
                        <a href="/partner-register" class="btn btn-dark py-3 px-5 me-3 mb-2">Join As Partner(Clinics)</a>
                        <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank" class="btn btn-light py-3 px-5 mb-2"><i class="fab fa-google-play me-2" style="font-size: 1.2rem;"></i>Download Doctorwala Mobile App</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Join As Partner End -->
@endguest

@auth
<!-- Join As Partner Start -->
<div class="container-fluid bg-offer my-4 py-4 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 wow zoomIn" data-wow-delay="0.6s">
                <div class="offer-text text-center rounded p-5">
                    <h1 class="display-5 text-white off-texts">Learn About Our Privacy Policy or Download Our App</h1>
                    <div class="d-flex g-3 flex-wrap justify-content-center ">
                        <a href="/dw/privacy-policy" class="btn btn-dark py-3 px-5 me-3 mb-2">Privacy Policy</a>
                        <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank" class="btn btn-light py-3 px-5 mb-2"><i class="fab fa-google-play me-2" style="font-size: 1.2rem;"></i>Download Doctorwala Mobile App</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Join As Partner End -->
@endauth




<!-- About Start -->
@foreach($aboutDetails as $aboutDetail)
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="section-title mb-4">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Jio Ji Bharka</h5>
                    <h1 class="display-5 mb-0">{{$aboutDetail->ab_title}}</h1>
                </div>
                <h4 class="text-body fst-italic mb-4">{{$aboutDetail->ab_b_txt}}</h4>
                <p class="mb-4">{{$aboutDetail->ab_desc}}</p>
                <div class="row g-3">
                    <div class="col-sm-6 wow zoomIn" data-wow-delay="0.3s">
                        <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Find Best Doctors</h5>
                        <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Find Best Pathologists
                        </h5>
                        <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Find Best Clinics</h5>
                    </div>
                    <div class="col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                        <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Single Call</h5>
                        <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>24/7 Opened</h5>
                        <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Fair Prices</h5>
                    </div>
                </div>
                @guest
                <a href="/partner-register" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn"
                    data-wow-delay="0.6s">Join As Partners</a>
                @endguest

                @auth
                <a href="/dw/about" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn"
                    data-wow-delay="0.6s">About Doctorwala</a>
                @endauth
            </div>
            <div class="col-lg-5" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s"
                        src="{{ asset('storage/' . $aboutDetail->about_image) }}" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- About End -->








<!-- Service Start -->
<div class="service-section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">

        {{-- Row 1 --}}
        <div class="row g-4 mb-0 align-items-stretch">

            {{-- Before/After Image --}}
            <div class="col-lg-5 wow zoomIn" data-wow-delay="0.3s">
                <div class="service-img-container twentytwenty-container">
                    <img class="position-absolute w-100 h-100" src="{{ asset('img/af.jpg') }}" style="object-fit: cover;">
                    <img class="position-absolute w-100 h-100" src="{{ asset('img/be.jpg') }}" style="object-fit: cover;">
                    <div class="img-badge-floating">
                        <i class="bi bi-shield-check"></i> Trusted Healthcare
                    </div>
                </div>
            </div>

            {{-- Right: Heading + 2 Service Cards --}}
            <div class="col-lg-7">
                <div class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="section-label">Our Services</div>
                    <h2 class="section-heading">
                        We Offer The Best <span>Doctors, OPD</span><br>& Pathology Services
                    </h2>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 wow zoomIn" data-wow-delay="0.4s">
                        <div class="service-card">
                            <div class="service-card-img-wrap">
                                <img class="service-card-img" src="{{ asset('img/himatology.jpg') }}" alt="Hematology">
                            </div>
                            <div class="service-card-body">
                                <div class="service-card-icon">
                                    <i class="fa fa-droplet"></i>
                                </div>
                                <h5>Hematology Tests</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 wow zoomIn" data-wow-delay="0.5s">
                        <div class="service-card">
                            <div class="service-card-img-wrap">
                                <img class="service-card-img" src="{{ asset('img/biochemic.jpg') }}" alt="Biochemistry">
                            </div>
                            <div class="service-card-body">
                                <div class="service-card-icon">
                                    <i class="fa fa-flask"></i>
                                </div>
                                <h5>Biochemistry Tests</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="service-row-divider"></div>

        {{-- Row 2 --}}
        <div class="row g-4 align-items-stretch wow fadeInUp" data-wow-delay="0.1s">

            {{-- Left: 2 Service Cards --}}
            <div class="col-lg-7">
                <div class="row g-4">
                    <div class="col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div class="service-card">
                            <div class="service-card-img-wrap">
                                <img class="service-card-img" src="{{ asset('img/microbiology.jpg') }}" alt="Microbiology">
                            </div>
                            <div class="service-card-body">
                                <div class="service-card-icon">
                                    <i class="fa fa-microscope"></i>
                                </div>
                                <h5>Microbiology Tests</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 wow zoomIn" data-wow-delay="0.4s">
                        <div class="service-card">
                            <div class="service-card-img-wrap">
                                <img class="service-card-img" src="{{ asset('img/cytology.jpg') }}" alt="Cytology">
                            </div>
                            <div class="service-card-body">
                                <div class="service-card-icon">
                                    <i class="fa fa-dna"></i>
                                </div>
                                <h5>Cytology & More...</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Offer Card --}}
            <div class="col-lg-5 wow zoomIn" data-wow-delay="0.5s">
                <div class="offer-card">
                    <div class="offer-card-badge">
                        <i class="fa fa-star"></i> What We Offer
                    </div>
                    <h3>Complete Healthcare at Your Fingertips</h3>
                    <p>Our platform connects you with doctors across all specialties — cardiology, orthopedics, dermatology, gynecology, pediatrics, and more. Find the right care, fast.</p>
                    <div class="offer-card-divider"></div>
                    @foreach($aboutDetails as $aboutDetail)
                    <div class="offer-card-phone">
                        <div class="offer-card-phone-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="offer-card-phone-text">
                            <small>Call Us Anytime</small>
                            <a href="tel:+91{{ $aboutDetail->number }}">+91-{{ $aboutDetail->number }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Service End -->















<!-- Testimonial Start -->
<div class="container-fluid bg-primary bg-testimonial py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="owl-carousel testimonial-carousel rounded p-5 wow zoomIn" data-wow-delay="0.6s">

                    @foreach($testi as $t)
                    <div class="testimonial-item text-center text-white">
                        <img class="img-fluid mx-auto rounded mb-4 testi-logo" src="{{asset('img/testilogo.png')}}" alt="">

                        <p class="testi-text"
                            style="color: white; opacity: 1; font-weight: 700; font-size: 1.3rem;">

                            <i class="fa-solid fa-2x fa-quote-left"></i>&nbsp;{{$t->feedback}}&nbsp;
                            <i class="fa-solid fa-2x fa-quote-right"></i>
                        </p>
                        <hr class="mx-auto w-25">
                        <h4 class="text-white mb-0 testi-text">{{$t->user_name}}</h4>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->


@endsection