@extends('frontend.layout.app')

@section('title')
    Search For "{{ $query }}" - DoctorWala.info
@endsection

@section('content')

<head>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/opd-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/path-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/doctor-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">


    <style>
        .partner-login {
            display: none !important;
        }
        /* ══════════════════════════════
   SEARCH RESULT PAGE — HERO
══════════════════════════════ */
        .sr-hero {
            position: relative;
            background: linear-gradient(135deg, #0d1e3a 0%, #0d6efd 100%);
            padding: 56px 0 0;
            overflow: hidden;
        }

        .sr-hero-bg {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 10% 80%, rgba(255, 255, 255, 0.04) 0%, transparent 40%);
            pointer-events: none;
        }

        .sr-hero-inner {
            position: relative;
            z-index: 1;
        }

        .sr-hero-text {
            text-align: center;
            margin-bottom: 28px;
        }

        .sr-hero-text h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
        }

        .sr-hero-text h1 span {
            color: #7dd3fc;
            font-style: italic;
        }

        .sr-hero-text p {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.65);
            margin: 0;
        }

        .sr-hero-text p strong {
            color: #fff;
        }

        /* Hero inline search bar */
        .sr-hero-form {
            max-width: 560px;
            margin: 0 auto 28px;
        }

        .sr-hero-input-wrap {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.12);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            padding: 0 6px 0 16px;
            backdrop-filter: blur(8px);
            transition: border-color 0.2s, background 0.2s;
        }

        .sr-hero-input-wrap:focus-within {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .sr-hero-input-wrap i {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .sr-hero-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 13px 0;
            font-size: 0.94rem;
            font-weight: 500;
            color: #fff;
            outline: none;
        }

        .sr-hero-input::placeholder {
            color: rgba(255, 255, 255, 0.45);
        }

        .sr-hero-btn {
            background: #fff;
            color: #0d6efd;
            border: none;
            border-radius: 10px;
            padding: 8px 18px;
            font-size: 0.82rem;
            font-weight: 800;
            cursor: pointer;
            flex-shrink: 0;
            transition: opacity 0.2s;
        }

        .sr-hero-btn:hover {
            opacity: 0.88;
        }

        /* Category tabs */
        .sr-category-tabs {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            flex-wrap: wrap;
            padding-bottom: 0;
        }

        .sr-tab {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            font-size: 0.82rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-radius: 12px 12px 0 0;
            border: 1.5px solid transparent;
            border-bottom: none;
            transition: all 0.2s;
            position: relative;
            bottom: -1px;
        }

        .sr-tab:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }

        .sr-tab.active {
            background: #f4f7ff;
            color: #0d6efd;
            border-color: rgba(255, 255, 255, 0.15);
        }

        .sr-tab-doc.active {
            color: #dc3545;
        }

        .sr-tab-path.active {
            color: #0d6e6e;
        }

        .sr-tab-count {
            background: rgba(255, 255, 255, 0.15);
            color: inherit;
            font-size: 0.68rem;
            padding: 2px 7px;
            border-radius: 10px;
            font-weight: 800;
        }

        .sr-tab.active .sr-tab-count {
            background: rgba(13, 110, 253, 0.12);
        }

        .sr-tab-doc.active .sr-tab-count {
            background: rgba(220, 53, 69, 0.1);
        }

        .sr-tab-path.active .sr-tab-count {
            background: rgba(13, 110, 110, 0.1);
        }

        /* ══════════════════════════════
   RESULTS BODY
══════════════════════════════ */
        .sr-body {
            background: #f4f7ff;
            padding: 40px 0 60px;
            min-height: 50vh;
        }

        /* ── Section Block ── */
        .sr-section {
            margin-bottom: 52px;
        }

        .sr-section-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
            padding: 16px 20px;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 3px 14px rgba(0, 0, 0, 0.06);
            border-left: 5px solid #0d6efd;
        }

        .sr-section-opd {
            border-left-color: #0d6efd;
        }

        .sr-section-path {
            border-left-color: #0d6e6e;
        }

        .sr-section-doc {
            border-left-color: #dc3545;
        }

        .sr-section-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
            flex-shrink: 0;
        }

        .sr-section-opd .sr-section-icon {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
        }

        .sr-section-path .sr-section-icon {
            background: linear-gradient(135deg, #0d6e6e, #00c9a7);
        }

        .sr-section-doc .sr-section-icon {
            background: linear-gradient(135deg, #dc3545, #b02a37);
        }

        .sr-section-header h2 {
            font-size: 1rem;
            font-weight: 800;
            color: #0d1e3a;
            margin: 0 0 2px;
        }

        .sr-section-header p {
            font-size: 0.75rem;
            color: #94a3b8;
            margin: 0;
        }

        .sr-section-badge {
            margin-left: auto;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            flex-shrink: 0;
        }

        .sr-badge-opd {
            background: #e9f0ff;
            color: #0d6efd;
        }

        .sr-badge-path {
            background: #e0f5f5;
            color: #0d6e6e;
        }

        .sr-badge-doc {
            background: #fde8ea;
            color: #dc3545;
        }

        /* ── Empty State ── */
        .sr-empty {
            text-align: center;
            padding: 80px 20px;
        }

        .sr-empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #e9f0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #0d6efd;
            margin: 0 auto 20px;
        }

        .sr-empty h3 {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0d1e3a;
            margin-bottom: 10px;
        }

        .sr-empty p {
            font-size: 0.9rem;
            color: #8899aa;
            margin-bottom: 24px;
            line-height: 1.7;
        }

        .sr-empty-suggestions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .sr-empty-suggestions span {
            font-size: 0.78rem;
            color: #aab4c4;
            font-weight: 600;
        }

        .sr-empty-suggestions a {
            padding: 5px 14px;
            border-radius: 20px;
            border: 1.5px solid #c8d8ff;
            color: #0d6efd;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.18s;
        }

        .sr-empty-suggestions a:hover {
            background: #e9f0ff;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sr-hero {
                padding: 40px 0 0;
            }

            .sr-hero-text h1 {
                font-size: 1.4rem;
            }

            .sr-category-tabs {
                justify-content: flex-start;
                overflow-x: auto;
                flex-wrap: nowrap;
                padding: 0 12px;
            }

            .sr-tab {
                white-space: nowrap;
                font-size: 0.75rem;
                padding: 8px 14px;
            }
        }
    </style>

</head>

    @guest
    <!-- Hero Section -->
    <div class="sr-hero">
        <div class="sr-hero-bg"></div>
        <div class="container sr-hero-inner">

            <div class="sr-hero-text">
                <h1>
                    @if($query)
                    Results for <span>"{{ $query }}"</span>
                    @else
                    Search Results
                    @endif
                </h1>
                <p>
                    @if($totalResults > 0)
                    Found <strong>{{ $totalResults }}</strong> result{{ $totalResults > 1 ? 's' : '' }}
                    @if($category !== 'all') in <strong>{{ ucfirst($category) }}</strong>@endif
                    @else
                    No results found. Try a different keyword.
                    @endif
                </p>
            </div>

            {{-- Inline search bar (re-search without opening modal) --}}
            <form action="{{ route('search.result') }}" method="GET" class="sr-hero-form">
                <input type="hidden" name="category" value="{{ $category }}">
                <div class="sr-hero-input-wrap">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        name="query"
                        value="{{ $query }}"
                        placeholder="Search again..."
                        class="sr-hero-input" />
                    <button type="submit" class="sr-hero-btn">Search</button>
                </div>
            </form>

            {{-- Category tabs --}}
            <div class="sr-category-tabs">
                <a href="{{ route('search.result', ['query' => $query, 'category' => 'all']) }}"
                    class="sr-tab {{ $category === 'all' ? 'active' : '' }}">
                    All <span class="sr-tab-count">{{ $totalResults }}</span>
                </a>
                <a href="{{ route('search.result', ['query' => $query, 'category' => 'doctor']) }}"
                    class="sr-tab sr-tab-doc {{ $category === 'doctor' ? 'active' : '' }}">
                    <i class="bi bi-person-heart-fill"></i> Doctors
                    <span class="sr-tab-count">{{ $docs->count() }}</span>
                </a>
                <a href="{{ route('search.result', ['query' => $query, 'category' => 'opd']) }}"
                    class="sr-tab sr-tab-opd {{ $category === 'opd' ? 'active' : '' }}">
                    <i class="bi bi-hospital-fill"></i> OPD
                    <span class="sr-tab-count">{{ $opds->count() }}</span>
                </a>
                <a href="{{ route('search.result', ['query' => $query, 'category' => 'pathology']) }}"
                    class="sr-tab sr-tab-path {{ $category === 'pathology' ? 'active' : '' }}">
                    <i class="bi bi-flask-fill"></i> Pathology
                    <span class="sr-tab-count">{{ $paths->count() }}</span>
                </a>
            </div>

        </div>
    </div>
    @endguest

    @auth
    <!-- Hero Section -->
    <div class="sr-hero">
        <div class="sr-hero-bg"></div>
        <div class="container sr-hero-inner">

            <div class="sr-hero-text">
                <h1>
                    @if($query)
                    Results for <span>"{{ $query }}"</span>
                    @else
                    Search Results
                    @endif
                </h1>
                <p>
                    @if($totalResults > 0)
                    Found <strong>{{ $totalResults }}</strong> result{{ $totalResults > 1 ? 's' : '' }}
                    @if($category !== 'all') in <strong>{{ ucfirst($category) }}</strong>@endif
                    @else
                    No results found. Try a different keyword.
                    @endif
                </p>
            </div>

            {{-- Inline search bar (re-search without opening modal) --}}
            <form action="{{ route('dw.search.result') }}" method="GET" class="sr-hero-form">
                <input type="hidden" name="category" value="{{ $category }}">
                <div class="sr-hero-input-wrap">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        name="query"
                        value="{{ $query }}"
                        placeholder="Search again..."
                        class="sr-hero-input" />
                    <button type="submit" class="sr-hero-btn">Search</button>
                </div>
            </form>

            {{-- Category tabs --}}
            <div class="sr-category-tabs">
                <a href="{{ route('dw.search.result', ['query' => $query, 'category' => 'all']) }}"
                    class="sr-tab {{ $category === 'all' ? 'active' : '' }}">
                    All <span class="sr-tab-count">{{ $totalResults }}</span>
                </a>
                <a href="{{ route('dw.search.result', ['query' => $query, 'category' => 'doctor']) }}"
                    class="sr-tab sr-tab-doc {{ $category === 'doctor' ? 'active' : '' }}">
                    <i class="bi bi-person-heart-fill"></i> Doctors
                    <span class="sr-tab-count">{{ $docs->count() }}</span>
                </a>
                <a href="{{ route('dw.search.result', ['query' => $query, 'category' => 'opd']) }}"
                    class="sr-tab sr-tab-opd {{ $category === 'opd' ? 'active' : '' }}">
                    <i class="bi bi-hospital-fill"></i> OPD
                    <span class="sr-tab-count">{{ $opds->count() }}</span>
                </a>
                <a href="{{ route('dw.search.result', ['query' => $query, 'category' => 'pathology']) }}"
                    class="sr-tab sr-tab-path {{ $category === 'pathology' ? 'active' : '' }}">
                    <i class="bi bi-flask-fill"></i> Pathology
                    <span class="sr-tab-count">{{ $paths->count() }}</span>
                </a>
            </div>

        </div>
    </div>
    @endauth
    <!-- ══════════════════════════════════════════ RESULTS BODY ══════════════════════════════════════════ -->
    <div class="sr-body">
        <div class="container">

            @if($totalResults === 0)
            <!-- ── Empty State ── -->
            <div class="sr-empty wow fadeIn">
                <div class="sr-empty-icon"><i class="bi bi-search"></i></div>
                <h3>No results found</h3>
                <p>We couldn't find anything matching <strong>"{{ $query }}"</strong>.<br>Try checking your spelling or use a more general term.</p>
                @guest
                <div class="sr-empty-suggestions">
                    <span>Try:</span>
                    <a href="{{ route('search.result', ['query' => 'Cardiologist', 'category' => 'all']) }}">Cardiologist</a>
                    <a href="{{ route('search.result', ['query' => 'Blood Test', 'category' => 'all']) }}">Blood Test</a>
                    <a href="{{ route('search.result', ['query' => 'Eye Specialist', 'category' => 'all']) }}">Eye Specialist</a>
                </div>
                @endguest
                @auth
                <div class="sr-empty-suggestions">
                    <span>Try:</span>
                    <a href="{{ route('dw.search.result', ['query' => 'Cardiologist', 'category' => 'all']) }}">Cardiologist</a>
                    <a href="{{ route('dw.search.result', ['query' => 'Blood Test', 'category' => 'all']) }}">Blood Test</a>
                    <a href="{{ route('dw.search.result', ['query' => 'Eye Specialist', 'category' => 'all']) }}">Eye Specialist</a>
                </div>
                @endauth
            </div>

            @else

            {{-- ══ DOCTORS SECTION ══ --}}
            @if($docs->count() > 0)
            <div class="sr-section wow fadeInUp" data-wow-delay="0.05s">
                <div class="sr-section-header sr-section-doc">
                    <div class="sr-section-icon"><i class="bi bi-person-heart-fill"></i></div>
                    <div>
                        <h2>Doctors</h2>
                        <p>{{ $docs->count() }} result{{ $docs->count() > 1 ? 's' : '' }} found</p>
                    </div>
                    <span class="sr-section-badge sr-badge-doc">{{ $docs->count() }}</span>
                </div>
                <div class="row g-4">
                    @foreach($docs as $doc)
                    <div class="col-lg-4 col-md-6 wow slideInUp" data-wow-delay="0.05s">
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
                                <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-name">{{ $doc->partner_doctor_name }}</a>
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
                                <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-listing-name">{{ $doc->partner_doctor_name }}</a>
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
            </div>
            @endif

            {{-- ══ OPD SECTION ══ --}}
            @if($opds->count() > 0)
            <div class="sr-section wow fadeInUp" data-wow-delay="0.1s">
                <div class="sr-section-header sr-section-opd">
                    <div class="sr-section-icon"><i class="bi bi-hospital-fill"></i></div>
                    <div>
                        <h2>OPD Clinics</h2>
                        <p>{{ $opds->count() }} result{{ $opds->count() > 1 ? 's' : '' }} found</p>
                    </div>
                    <span class="sr-section-badge sr-badge-opd">{{ $opds->count() }}</span>
                </div>
                <div class="row g-4">
                    @foreach($opds as $opd)
                    <div class="col-lg-4 col-md-6 wow slideInUp" data-wow-delay="0.05s">
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
            </div>
            @endif

            {{-- ══ PATHOLOGY SECTION ══ --}}
            @if($paths->count() > 0)
            <div class="sr-section wow fadeInUp" data-wow-delay="0.15s">
                <div class="sr-section-header sr-section-path">
                    <div class="sr-section-icon"><i class="bi bi-flask-fill"></i></div>
                    <div>
                        <h2>Pathology Labs</h2>
                        <p>{{ $paths->count() }} result{{ $paths->count() > 1 ? 's' : '' }} found</p>
                    </div>
                    <span class="sr-section-badge sr-badge-path">{{ $paths->count() }}</span>
                </div>
                <div class="row g-4">
                    @foreach($paths as $path)
                    <div class="col-lg-4 col-md-6 wow slideInUp" data-wow-delay="0.05s">
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
                                    <a href="tel:{{$path->clinic_mobile_number}}"><i class="fab fa-instagram"></i></a>
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
            </div>
            @endif

            @endif {{-- end totalResults check --}}

        </div>
    </div>

    <!-- Template Javascript -->
    <script src="{{asset('../js/main.js')}}"></script>
    <script src="{{asset('../js/cards-scroll.js')}}"></script>
    <script src="{{asset('../js/captcha.js')}}"></script>

    @endsection