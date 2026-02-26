@extends('frontend.layout.app')

@section('title', 'Find Your Nearby Individual Doctors | Doctorwala.info')

@section('content')

<head>
    @foreach ($docs as $doc)
    <meta name="description" content="Find {{ ucfirst($doc->partner_doctor_name) }} at {{ ucfirst($doc->partner_doctor_address) }}. Book your consultation with a trusted doctor today.">
    <meta name="keywords" content="{{ ucfirst($doc->partner_doctor_name) }}, doctor, healthcare, specialist, {{ ucfirst($doc->partner_doctor_address) }}, {{ ucfirst($doc->partner_doctor_specialist) }},  {{ ucfirst($doc->partner_doctor_designation) }},  {{ ucfirst($doc->partner_doctor_fees) }},  {{ ucfirst($doc->partner_doctor_address) }},  {{ ucfirst($doc->partner_doctor_landmark) }},  {{ ucfirst($doc->partner_doctor_state) }},  {{ ucfirst($doc->partner_doctor_google_map_link) }}, consultation">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ ucfirst($doc->partner_doctor_name) }} - Find Doctors | Doctorwala">
    <meta property="og:description" content="Find {{ ucfirst($doc->partner_doctor_name) }} at {{ ucfirst($doc->partner_doctor_address) }}. Book your consultation with a trusted doctor today.">
    <meta property="og:url" content="{{ url('/dw/doctor/' . $doc->slug) }}">

    <!-- Twitter Card Tags -->
    <meta name="twitter:title" content="{{ ucfirst($doc->partner_doctor_name) }} - Find Doctors | Doctorwala">
    <meta name="twitter:description" content="Find {{ ucfirst($doc->partner_doctor_name) }} at {{ ucfirst($doc->partner_doctor_address) }}. Book your consultation with a trusted doctor today.">
    @endforeach

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/doctor-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">

    <style>
        .partner-login {
            display: none !important;
        }
    </style>

</head>


@guest
<!-- Filter Bar Start -->
<div class="container doc-filter-section wow fadeInDown" data-wow-delay="0.1s">
    <div class="doc-filter-card">
        <div class="doc-filter-top">
            <div class="doc-filter-top-icon">
                <i class="bi bi-funnel-fill"></i>
            </div>
            <div>
                <h3>Sort Results By</h3>
                <p>Filter doctors by state and city</p>
            </div>
        </div>
        <form action="{{ route('filter.search.doc') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="doc-filter-wrap">
                        <i class="bi bi-geo-fill"></i>
                        <select name="state" class="form-select">
                            @foreach($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="doc-filter-wrap">
                        <i class="bi bi-building"></i>
                        <select name="city" class="form-select">
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="doc-filter-btn">
                        <i class="bi bi-search"></i> Search Doctor
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
<div class="container doc-filter-section wow fadeInDown" data-wow-delay="0.1s">
    <div class="doc-filter-card">
        <div class="doc-filter-top">
            <div class="doc-filter-top-icon">
                <i class="bi bi-funnel-fill"></i>
            </div>
            <div>
                <h3>Sort Results By</h3>
                <p>Filter doctors by state and city</p>
            </div>
        </div>
        <form action="{{ route('doc.filter.search') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="doc-filter-wrap">
                        <i class="bi bi-geo-fill"></i>
                        <select name="state" class="form-select">
                            @foreach($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="doc-filter-wrap">
                        <i class="bi bi-building"></i>
                        <select name="city" class="form-select">
                            @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="doc-filter-btn">
                        <i class="bi bi-search"></i> Search Doctor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Filter Bar End -->
@endauth

<!-- Doctor Cards Start -->
<div class="doc-listing-section">
    <div class="container">

        {{-- Results Count Bar --}}
        @if($docs->count() > 0)
        <div class="doc-results-bar wow fadeInUp" data-wow-delay="0.1s">
            <h5>Showing <span>{{ $docs->firstItem() }}–{{ $docs->lastItem() }}</span> of <span>{{ $docs->total() }}</span> Doctors</h5>
            <span class="doc-results-badge">Page {{ $docs->currentPage() }} of {{ $docs->lastPage() }}</span>
        </div>

        <div class="row g-4">
            @foreach($docs as $doc)
            <div class="col-lg-4 col-md-6 wow slideInUp" data-wow-delay="0.1s">
                <div class="doc-listing-card">

                    <div class="doc-listing-img-wrap">
                        @if($doc->banner && $doc->banner->doctorbanner)
                        <img src="{{ asset('storage/' . $doc->banner->doctorbanner) }}" alt="{{ $doc->partner_doctor_name }}">
                        @else
                        <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" alt="Default">
                        @endif
                        <div class="img-overlay"></div>
                        <span class="doc-listing-badge"><i class="bi bi-person-heart-fill me-1"></i>DOCTOR</span>
                        <div class="doc-listing-social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{$doc->partner_doctor_google_map_link}}" target="_blank"><i class="fa-solid fa-location-dot"></i></a>
                            <a href="tel:{{$doc->partner_doctor_mobile}}"><i class="fa-solid fa-phone"></i></a>
                        </div>
                    </div>

                    @guest
                    <div class="doc-listing-body">
                        <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-name">
                            {{ $doc->partner_doctor_name }}
                        </a>
                        <div class="doc-listing-divider"></div>
                        <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-address">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span style="text-transform: capitalize;">{{ $doc->partner_doctor_city }}, {{ $doc->partner_doctor_state}}, {{ $doc->partner_doctor_pincode }}</span>
                        </a>
                        <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-address">
                            <i class="fa-solid fa-stethoscope"></i>
                            <span style="color: black; font-size: 0.8rem; font-weight: 600;">{{$doc->partner_doctor_specialist}}</span>
                        </a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
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
                                    <th scope="row">{{ $index + 1 }}</th>

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

                                    <td>
                                        @if($doc->status == 'Available')
                                        <span class="badge bg-success">{{ $doc->status }}</span>
                                        @elseif($doc->status == 'Unavailable')
                                        <span class="badge bg-danger">{{ $doc->status }}</span>
                                        @else
                                        <span class="badge bg-secondary">{{ $doc->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                {{-- 4th row message --}}
                                @if($totalVisits > 3)
                                <tr>
                                    <td colspan="4" class="text-center text-primary fw-semibold">
                                        <a href="{{ url('/doctor/'.$doc->slug) }}">Continue to see full times & days →</a>
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

                        <div class="doc-listing-footer">
                            <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-open-btn">
                                <i class="bi bi-box-arrow-up-right"></i> Continue
                            </a>
                        </div>
                    </div>
                    @endguest

                    @auth
                    <div class="doc-listing-body">
                        <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-listing-name">
                            {{ $doc->partner_doctor_name }}
                        </a>
                        <div class="doc-listing-divider"></div>
                        <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-listing-address">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span style="text-transform: capitalize;">{{ $doc->partner_doctor_city }}, {{ $doc->partner_doctor_state}}, {{ $doc->partner_doctor_pincode }}</span>
                        </a>
                        <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-listing-address">
                            <i class="fa-solid fa-stethoscope"></i>
                            <span style="color: black; font-size: 0.8rem; font-weight: 600;">{{$doc->partner_doctor_specialist}}</span>
                        </a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
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
                                    <th scope="row">{{ $index + 1 }}</th>

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

                                    <td>
                                        @if($doc->status == 'Available')
                                        <span class="badge bg-success">{{ $doc->status }}</span>
                                        @elseif($doc->status == 'Unavailable')
                                        <span class="badge bg-danger">{{ $doc->status }}</span>
                                        @else
                                        <span class="badge bg-secondary">{{ $doc->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                {{-- 4th row message --}}
                                @if($totalVisits > 3)
                                <tr>
                                    <td colspan="4" class="text-center text-primary fw-semibold">
                                        <a href="{{ url('/dw/doctor/'.$doc->slug) }}">Continue to see full times & days →</a>
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


                        <div class="doc-listing-footer">
                            <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-open-btn">
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
        <div class="doc-no-results wow fadeIn">
            <i class="bi bi-person-x"></i>
            <p>No doctors found for the selected filters.<br>Try a different state or city.</p>
        </div>
        @endif

    </div>
</div>
<!-- Doctor Cards End -->

<!-- Pagination Start -->
@if($docs->lastPage() > 1)
<div class="doc-pagination-wrap wow fadeInUp" data-wow-delay="0.1s">
    <ul class="doc-pagination">

        {{-- Prev --}}
        <li class="page-item prev-next {{ $docs->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $docs->onFirstPage() ? '#' : $docs->previousPageUrl() }}">
                <i class="bi bi-chevron-left"></i> Prev
            </a>
        </li>

        @php
        $current = $docs->currentPage();
        $last = $docs->lastPage();
        $window = 2;
        @endphp

        {{-- Page 1 always --}}
        <li class="page-item {{ $current == 1 ? 'active' : '' }}">
            <a class="page-link" href="{{ $docs->url(1) }}">1</a>
        </li>

        {{-- Left ellipsis --}}
        @if($current > $window + 2)
        <li class="page-item ellipsis"><span class="page-link">···</span></li>
        @endif

        {{-- Middle window --}}
        @for($i = max(2, $current - $window); $i <= min($last - 1, $current + $window); $i++)
            <li class="page-item {{ $current == $i ? 'active' : '' }}">
            <a class="page-link" href="{{ $docs->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            {{-- Right ellipsis --}}
            @if($current < $last - $window - 1)
                <li class="page-item ellipsis"><span class="page-link">···</span></li>
                @endif

                {{-- Last page always --}}
                @if($last > 1)
                <li class="page-item {{ $current == $last ? 'active' : '' }}">
                    <a class="page-link" href="{{ $docs->url($last) }}">{{ $last }}</a>
                </li>
                @endif

                {{-- Next --}}
                <li class="page-item prev-next {{ !$docs->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $docs->hasMorePages() ? $docs->nextPageUrl() : '#' }}">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                </li>

    </ul>
</div>
@endif
<!-- Pagination End -->


@endsection