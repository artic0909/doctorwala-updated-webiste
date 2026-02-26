@extends('frontend.layout.app')

@section('title', 'Find Your Pathology Tests & Labs Near You | Doctorwala.info')

@section('content')

<head>
    @foreach($paths as $path)
    <meta name="description" content="Explore {{ ucfirst($path->clinic_name) }} located at {{ ucfirst($path->clinic_address) }}. Get reliable pathology tests and healthcare services. Book your appointment today. Doctorwala.info is your one-stop destination for finding the best pathology services in India.">
    <meta name="keywords" content="{{ ucfirst($path->clinic_name) }}, OPD, clinic, healthcare, {{ ucfirst($path->clinic_address) }}, outpatient, {{ ucfirst($path->clinic_registration_type) }}, {{ ucfirst($path->clinic_clinic_contact_person_name) }}, {{ ucfirst($path->clinic_mobile_number) }}, {{ ucfirst($path->clinic_email) }}, {{ ucfirst($path->clinic_landmark) }}, {{ ucfirst($path->clinic_state) }}, {{ ucfirst($path->clinic_pincode) }}, {{ ucfirst($path->clinic_google_map_link) }}, {{ ucfirst($path->clinic_) }}, {{ ucfirst($path->clinic_address) }}, consultation, doctorwala.info, doctorwala">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ ucfirst($path->clinic_name) }} - Pathology Services | Doctorwala">
    <meta property="og:description" content="Explore {{ ucfirst($path->clinic_name) }} located at {{ ucfirst($path->clinic_address) }}. Get reliable pathology tests and healthcare services. Book your appointment today.">
    <meta property="og:image" content="{{ asset('storage/' . ($path->banner->pathologybanner ?? 'default_image.jpg')) }}">
    <meta property="og:url" content="{{ url('/dw/pathology/' . $path->slug) }}">

    <!-- Twitter Card Tags -->
    <meta name="twitter:title" content="{{ ucfirst($path->clinic_name) }} - Pathology Services | Doctorwala">
    <meta name="twitter:description" content="Explore {{ ucfirst($path->clinic_name) }} located at {{ ucfirst($path->clinic_address) }}. Get reliable pathology tests and healthcare services. Book your appointment today.">
    <meta name="twitter:image" content="{{ asset('storage/' . ($path->banner->pathologybanner ?? 'default_image.jpg')) }}">
    @endforeach

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/path-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">

    <style>
        .partner-login {
            display: none !important;
        }
    </style>

</head>



@guest
<!-- Filter Bar Start -->
<div class="container path-filter-section wow fadeInDown" data-wow-delay="0.1s">
    <div class="path-filter-card">
        <div class="path-filter-top">
            <div class="path-filter-top-icon">
                <i class="bi bi-funnel-fill"></i>
            </div>
            <div>
                <h3>Sort Results By</h3>
                <p>Filter pathology labs by state and city</p>
            </div>
        </div>
        <form action="{{ route('filter.search.path') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="path-filter-wrap">
                        <i class="bi bi-geo-fill"></i>
                        <select name="state" class="form-select">
                            @foreach($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="path-filter-wrap">
                        <i class="bi bi-building"></i>
                        <select name="city" class="form-select">
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="path-filter-btn">
                        <i class="bi bi-search"></i> Search Pathology
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
<div class="container path-filter-section wow fadeInDown" data-wow-delay="0.1s">
    <div class="path-filter-card">
        <div class="path-filter-top">
            <div class="path-filter-top-icon">
                <i class="bi bi-funnel-fill"></i>
            </div>
            <div>
                <h3>Sort Results By</h3>
                <p>Filter pathology labs by state and city</p>
            </div>
        </div>
        <form action="{{ route('path.filter.search') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="path-filter-wrap">
                        <i class="bi bi-geo-fill"></i>
                        <select name="state" class="form-select">
                            @foreach($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="path-filter-wrap">
                        <i class="bi bi-building"></i>
                        <select name="city" class="form-select">
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="path-filter-btn">
                        <i class="bi bi-search"></i> Search Pathology
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Filter Bar End -->
@endauth


<!-- Pathology Cards Start -->
<div class="path-listing-section">
    <div class="container">

        {{-- Results Count Bar --}}
        @if($paths->count() > 0)
        <div class="path-results-bar wow fadeInUp" data-wow-delay="0.1s">
            <h5>Showing <span>{{ $paths->firstItem() }}–{{ $paths->lastItem() }}</span> of <span>{{ $paths->total() }}</span> Pathology Labs</h5>
            <span class="path-results-badge">Page {{ $paths->currentPage() }} of {{ $paths->lastPage() }}</span>
        </div>

        <div class="row g-4">
            @foreach($paths as $path)
            <div class="col-lg-4 col-md-6 wow slideInUp" data-wow-delay="0.1s">
                <div class="path-listing-card">

                    <div class="path-listing-img-wrap">
                        @if($path->banner && $path->banner->pathologybanner)
                        <img src="{{ asset('storage/' . $path->banner->pathologybanner) }}" alt="{{ $path->clinic_name }}">
                        @else
                        <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="Default">
                        @endif
                        <div class="img-overlay"></div>
                        <span class="path-listing-badge"><i class="bi bi-flask-fill me-1"></i>PATHOLOGY</span>
                        <div class="path-listing-social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{$path->clinic_google_map_link}}" target="_blank"><i class="fa-solid fa-location-dot"></i></a>
                            <a href="tel:{{ $path->clinic_mobile_number }}"><i class="fa-solid fa-phone"></i></a>
                        </div>
                    </div>


                    @guest
                    <div class="path-listing-body">
                        <a href="{{ url('/pathology/'.$path->slug) }}" class="path-listing-name">
                            {{ $path->clinic_name }}
                        </a>
                        <div class="path-listing-divider"></div>
                        <a href="{{ url('/pathology/'.$path->slug) }}" class="path-listing-address">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span style="text-transform: capitalize;">{{ $path->clinic_city }}, {{ $path->clinic_state }}, {{ $path->clinic_pincode }}</span>
                        </a>
                    </div>
                    @endguest

                    @auth
                    <div class="path-listing-body">
                        <a href="{{ url('/dw/pathology/'.$path->slug) }}" class="path-listing-name">
                            {{ $path->clinic_name }}
                        </a>
                        <div class="path-listing-divider"></div>
                        <a href="{{ url('/dw/pathology/'.$path->slug) }}" class="path-listing-address">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span style="text-transform: capitalize;">{{ $path->clinic_city }}, {{ $path->clinic_state }}, {{ $path->clinic_pincode }}</span>
                        </a>
                    </div>
                    @endauth


                    <div class="path-listing-body">
                        @if($path->tests && $path->tests->count())

                        <ul style="margin:0; padding-left:18px; list-style:disc;">
                            @foreach($path->tests->shuffle()->take(4) as $test)
                            <li style="border-bottom:1px solid #07a1cf; padding:6px 0; color:black;">
                                <strong>{{ $test->test_name }}</strong>
                                <span style="color:#0D6EFD;">
                                    ({{ $test->test_type }})
                                </span>
                            </li>
                            @endforeach
                        </ul>

                        <small style="display:block; margin-top:8px; color:#6c757d;">
                            Click <strong style="color:black;">"Continue"</strong> to see all tests
                        </small>

                        @else
                        <p>No Tests Listed Yet</p>
                        @endif
                    </div>


                    @guest
                    <div class="path-listing-body">
                        <div class="path-listing-footer">
                            <a href="{{ url('/pathology/'.$path->slug) }}" class="path-open-btn">
                                <i class="bi bi-box-arrow-up-right"></i> Continue
                            </a>
                        </div>
                    </div>
                    @endguest


                    @auth
                    <div class="path-listing-body">
                        <div class="path-listing-footer">
                            <a href="{{ url('/dw/pathology/'.$path->slug) }}" class="path-open-btn">
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
        <div class="path-no-results wow fadeIn">
            <i class="bi bi-flask"></i>
            <p>No pathology labs found for the selected filters.<br>Try a different state or city.</p>
        </div>
        @endif

    </div>
</div>
<!-- Pathology Cards End -->


<!-- Pagination Start -->
@if($paths->lastPage() > 1)
<div class="path-pagination-wrap wow fadeInUp" data-wow-delay="0.1s">
    <ul class="path-pagination">

        {{-- Prev --}}
        <li class="page-item prev-next {{ $paths->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paths->onFirstPage() ? '#' : $paths->previousPageUrl() }}">
                <i class="bi bi-chevron-left"></i> Prev
            </a>
        </li>

        @php
        $current = $paths->currentPage();
        $last = $paths->lastPage();
        $window = 2;
        @endphp

        {{-- Page 1 always --}}
        <li class="page-item {{ $current == 1 ? 'active' : '' }}">
            <a class="page-link" href="{{ $paths->url(1) }}">1</a>
        </li>

        {{-- Left ellipsis --}}
        @if($current > $window + 2)
        <li class="page-item ellipsis"><span class="page-link">···</span></li>
        @endif

        {{-- Middle window --}}
        @for($i = max(2, $current - $window); $i <= min($last - 1, $current + $window); $i++)
            <li class="page-item {{ $current == $i ? 'active' : '' }}">
            <a class="page-link" href="{{ $paths->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            {{-- Right ellipsis --}}
            @if($current < $last - $window - 1)
                <li class="page-item ellipsis"><span class="page-link">···</span></li>
                @endif

                {{-- Last page always --}}
                @if($last > 1)
                <li class="page-item {{ $current == $last ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paths->url($last) }}">{{ $last }}</a>
                </li>
                @endif

                {{-- Next --}}
                <li class="page-item prev-next {{ !$paths->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $paths->hasMorePages() ? $paths->nextPageUrl() : '#' }}">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                </li>

    </ul>
</div>
@endif
<!-- Pagination End -->


@endsection