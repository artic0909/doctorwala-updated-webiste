@extends('frontend.layout.app')

@section('title', 'Find Your OPD Doctors & Clinics Near You | Doctorwala.info')

@section('content')

<head>
    @foreach ($opds as $opd)
    <!-- SEO Meta Tags for OPD Page -->
    <meta name="description" content="Find {{ ucfirst($opd->clinic_name) }} at {{ ucfirst($opd->clinic_address) }}. Book your consultation today at a trusted OPD. Doctorwala.info is your one-stop destination for finding the best OPDs in India.">
    <meta name="keywords" content="{{ ucfirst($opd->clinic_name) }}, OPD, clinic, healthcare, {{ ucfirst($opd->clinic_address) }}, outpatient, {{ ucfirst($opd->clinic_registration_type) }}, {{ ucfirst($opd->clinic_clinic_contact_person_name) }}, {{ ucfirst($opd->clinic_mobile_number) }}, {{ ucfirst($opd->clinic_email) }}, {{ ucfirst($opd->clinic_landmark) }}, {{ ucfirst($opd->clinic_state) }}, {{ ucfirst($opd->clinic_pincode) }}, {{ ucfirst($opd->clinic_google_map_link) }}, {{ ucfirst($opd->clinic_) }}, {{ ucfirst($opd->clinic_address) }}, consultation, doctorwala.info, doctorwala">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ ucfirst($opd->clinic_name) }} - Find OPDs | Doctorwala">
    <meta property="og:description" content="Find {{ ucfirst($opd->clinic_name) }} at {{ ucfirst($opd->clinic_address) }}. Book your consultation today at a trusted OPD.">
    <meta property="og:image" content="{{ asset('storage/' . ($opd->banner->opdbanner ?? 'default_image.jpg')) }}">
    <meta property="og:url" content="{{ url('/dw/opd/' . $opd->slug) }}">

    <!-- Twitter Card Tags -->
    <meta name="twitter:title" content="{{ ucfirst($opd->clinic_name) }} - Find OPDs | Doctorwala">
    <meta name="twitter:description" content="Find {{ ucfirst($opd->clinic_name) }} at {{ ucfirst($opd->clinic_address) }}. Book your consultation today at a trusted OPD.">
    <meta name="twitter:image" content="{{ asset('storage/' . ($opd->banner->opdbanner ?? 'default_image.jpg')) }}">
    @endforeach

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/opd-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">

    <style>
        .partner-login {
            display: none !important;
        }
    </style>
</head>

@guest
<!-- Filter Bar Start -->
<div class="container opd-filter-section wow fadeInDown" data-wow-delay="0.1s">
    <div class="opd-filter-card">
        <div class="opd-filter-top">
            <div class="opd-filter-top-icon">
                <i class="bi bi-funnel-fill"></i>
            </div>
            <div>
                <h3>Sort Results By</h3>
                <p>Filter OPD clinics by state and city</p>
            </div>
        </div>
        <form action="{{ route('filter.search') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="opd-filter-wrap">
                        <i class="bi bi-geo-fill"></i>
                        <select name="state" class="form-select">
                            @foreach($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="opd-filter-wrap">
                        <i class="bi bi-building"></i>
                        <select name="city" class="form-select">
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="opd-filter-btn">
                        <i class="bi bi-search"></i> Search OPD
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Filter Bar End -->
@endguest

@auth
<!-- Filter Bar Start -->
<div class="container opd-filter-section wow fadeInDown" data-wow-delay="0.1s">
    <div class="opd-filter-card">
        <div class="opd-filter-top">
            <div class="opd-filter-top-icon">
                <i class="bi bi-funnel-fill"></i>
            </div>
            <div>
                <h3>Sort Results By</h3>
                <p>Filter OPD clinics by state and city</p>
            </div>
        </div>
        <form action="{{ route('opd.filter.search') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="opd-filter-wrap">
                        <i class="bi bi-geo-fill"></i>
                        <select name="state" class="form-select">
                            @foreach($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="opd-filter-wrap">
                        <i class="bi bi-building"></i>
                        <select name="city" class="form-select">
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="opd-filter-btn">
                        <i class="bi bi-search"></i> Search OPD
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Filter Bar End -->
@endauth


<!-- OPD Cards Start -->
<div class="opd-listing-section">
    <div class="container">

        {{-- Results Count Bar --}}
        @if($opds->count() > 0)
        <div class="opd-results-bar wow fadeInUp" data-wow-delay="0.1s">
            <h5>Showing <span>{{ $opds->firstItem() }}–{{ $opds->lastItem() }}</span> of <span>{{ $opds->total() }}</span> OPD Clinics</h5>
            <span class="opd-results-badge">Page {{ $opds->currentPage() }} of {{ $opds->lastPage() }}</span>
        </div>

        <div class="row g-4">
            @foreach($opds as $opd)
            <div class="col-lg-4 col-md-6 wow slideInUp" data-wow-delay="0.1s">
                <div class="opd-listing-card">

                    <div class="opd-listing-img-wrap">
                        @if($opd->banner && $opd->banner->opdbanner)
                        <img src="{{ asset('storage/' . $opd->banner->opdbanner) }}" alt="{{ $opd->clinic_name }}">
                        @else
                        <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="Default">
                        @endif
                        <div class="img-overlay"></div>
                        <span class="opd-listing-badge">OPD</span>
                        <div class="opd-listing-social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{$opd->clinic_google_map_link}}" target="_blank"><i class="fa-solid fa-location-dot"></i></a>
                            <a href="tel:{{ $opd->clinic_mobile_number }}"><i class="fa-solid fa-phone"></i></a>
                        </div>
                    </div>


                    @guest
                    <div class="opd-listing-body">
                        <a href="{{ url('/opd/'.$opd->slug) }}" class="opd-listing-name">
                            {{ $opd->clinic_name }}
                        </a>
                        <div class="opd-listing-divider"></div>
                        <a href="{{ url('/opd/'.$opd->slug) }}" class="opd-listing-address">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span style="text-transform: capitalize;">{{ $opd->clinic_city }}, {{ $opd->clinic_state }}, {{ $opd->clinic_pincode }}</span>
                        </a>
                    </div>
                    @endguest

                    @auth
                    <div class="opd-listing-body">
                        <a href="{{ url('/dw/opd/'.$opd->slug) }}" class="opd-listing-name">
                            {{ $opd->clinic_name }}
                        </a>
                        <div class="opd-listing-divider"></div>
                        <a href="{{ url('/dw/opd/'.$opd->slug) }}" class="opd-listing-address">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span style="text-transform: capitalize;">{{ $opd->clinic_city }}, {{ $opd->clinic_state }}, {{ $opd->clinic_pincode }}</span>
                        </a>
                    </div>
                    @endauth

                    <div class="opd-listing-body">

                        @if($opd->doctors && $opd->doctors->count())

                        <ul style="margin:0; padding-left:18px; list-style:disc;">
                            @foreach($opd->doctors->shuffle()->take(4) as $doctor)
                            <li style="border-bottom:1px solid #07a1cf; padding:6px 0; color:black;">
                                <strong>{{ $doctor->doctor_name }}</strong>
                                <span style="color:#0D6EFD;">
                                    ({{ $doctor->doctor_specialist }})
                                </span>
                            </li>
                            @endforeach
                        </ul>

                        <small style="display:block; margin-top:8px; color:#6c757d;">
                            Click <strong style="color:black;">"Continue"</strong> to see all doctors
                        </small>

                        @else
                        <p>No Doctors Listed Yet</p>
                        @endif

                    </div>


                    @guest
                    <div class="opd-listing-body">
                        <div class="opd-listing-footer">
                            <a href="{{ url('/opd/'.$opd->slug) }}" class="opd-open-btn">
                                <i class="bi bi-box-arrow-up-right"></i> Continue
                            </a>
                        </div>
                    </div>
                    @endguest

                    @auth
                    <div class="opd-listing-body">
                        <div class="opd-listing-footer">
                            <a href="{{ url('/dw/opd/'.$opd->slug) }}" class="opd-open-btn">
                                <i class="bi bi-box-arrow-up-right"></i> Continue
                            </a>
                        </div>
                    </div>
                    @endauth

                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="opd-no-results wow fadeIn">
            <i class="bi bi-hospital"></i>
            <p>No OPD clinics found for the selected filters.<br>Try a different state or city.</p>
        </div>
        @endif

    </div>
</div>
<!-- OPD Cards End -->


<!-- Pagination Start -->
@if($opds->lastPage() > 1)
<div class="opd-pagination-wrap wow fadeInUp" data-wow-delay="0.1s">
    <ul class="opd-pagination">

        {{-- Prev --}}
        <li class="page-item prev-next {{ $opds->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $opds->onFirstPage() ? '#' : $opds->previousPageUrl() }}">
                <i class="bi bi-chevron-left"></i> Prev
            </a>
        </li>

        @php
        $current = $opds->currentPage();
        $last = $opds->lastPage();
        $window = 2;
        @endphp

        {{-- Page 1 always --}}
        <li class="page-item {{ $current == 1 ? 'active' : '' }}">
            <a class="page-link" href="{{ $opds->url(1) }}">1</a>
        </li>

        {{-- Left ellipsis --}}
        @if($current > $window + 2)
        <li class="page-item ellipsis"><span class="page-link">···</span></li>
        @endif

        {{-- Middle window --}}
        @for($i = max(2, $current - $window); $i <= min($last - 1, $current + $window); $i++)
            <li class="page-item {{ $current == $i ? 'active' : '' }}">
            <a class="page-link" href="{{ $opds->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            {{-- Right ellipsis --}}
            @if($current < $last - $window - 1)
                <li class="page-item ellipsis"><span class="page-link">···</span></li>
                @endif

                {{-- Last page always --}}
                @if($last > 1)
                <li class="page-item {{ $current == $last ? 'active' : '' }}">
                    <a class="page-link" href="{{ $opds->url($last) }}">{{ $last }}</a>
                </li>
                @endif

                {{-- Next --}}
                <li class="page-item prev-next {{ !$opds->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $opds->hasMorePages() ? $opds->nextPageUrl() : '#' }}">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                </li>

    </ul>
</div>
@endif
<!-- Pagination End -->


@endsection