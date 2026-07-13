<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Doctorwala | Your Medical Ecosystem')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="{{asset('fav5.png')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
        integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Libraries Stylesheet -->
    <link href="{{asset('./lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('./lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('./lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('./lib/twentytwenty/twentytwenty.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('./css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('./css/style.css')}}" rel="stylesheet">
    <link href="{{asset('./css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('./css/service.css')}}" rel="stylesheet">

    <!-- Search Area -->
    <link href="{{asset('./css/serach-banner.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <link href="{{asset('./css/partner-btn.css')}}" rel="stylesheet">
    <link href="{{asset('./responsive/index_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('./responsive/service_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('./css/topbar.css')}}" rel="stylesheet">



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

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-dark m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->





    <!-- ====== TOPBAR ====== -->
    <div class="topbar">
        <div class="topbar-inner">

            <!-- LEFT -->
            <div class="topbar-left">
                <div class="hours-pill">
                    <span class="live-dot"><span></span></span>
                    <i class="far fa-clock"></i>
                    24/7 Open
                </div>
                <div class="ticker-wrap">
                    <div class="ticker-track">
                        <span class="t-item"><i class="fa fa-heart-pulse"></i> Expert doctors, trusted care</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-calendar-check"></i> Easy online appointment booking</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-stethoscope"></i> Quality healthcare for your family</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-leaf"></i> Your health, our priority</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-shield-halved"></i> Mon to Sun — always available</span>
                        <span class="t-sep">✦</span>
                        <!-- duplicate -->
                        <span class="t-item"><i class="fa fa-heart-pulse"></i> Expert doctors, trusted care</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-calendar-check"></i> Easy online appointment booking</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-stethoscope"></i> Quality healthcare for your family</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-leaf"></i> Your health, our priority</span>
                        <span class="t-sep">✦</span>
                        <span class="t-item"><i class="fa fa-shield-halved"></i> Mon to Sun — always available</span>
                        <span class="t-sep">✦</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="topbar-right">
                @foreach($aboutDetails as $aboutDetail)
                <a href="mailto:{{$aboutDetail->email}}" class="c-chip">
                    <span class="c-ico"><i class="fa fa-envelope"></i></span>
                    {{$aboutDetail->email}}
                </a>
                <a href="tel:{{$aboutDetail->number}}" class="c-chip">
                    <span class="c-ico"><i class="fa fa-phone"></i></span>
                    +91-{{$aboutDetail->number}}
                </a>
                @endforeach
            </div>

        </div>
    </div>
    <!-- ====== TOPBAR ====== -->

    @include('frontend.includes.header')

    @yield('content')


    @include('frontend.includes.footer')
    @include('frontend.includes.scripts')
    @yield('scripts')
</body>

</html>