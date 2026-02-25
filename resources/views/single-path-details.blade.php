<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$path->clinic_name}} | {{$path->clinic_contact_person_name}} | {{$path->clinic_address}} | Doctorwla</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


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

    <!-- Favicon -->
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
    <link href="{{asset('../lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('../lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />
    <link href="{{asset('../lib/twentytwenty/twentytwenty.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">
    <link href="{{asset('../css/all-opd-pathology-doctor-details.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/index_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/service_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/allopdpathdoc_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('./css/topbar.css')}}" rel="stylesheet">
    <link href="{{asset('./css/single-path.css')}}" rel="stylesheet">


    <style>
        .a-not {
            color: #6b6a75;

            &:hover {
                color: red;
            }
        }

        .btn-primaryy {
            background: linear-gradient(135deg, #3bc7fe, #006eff);
            color: white;
            border: none;
            transition: all 100ms ease-in;

            &:hover {
                color: white;
                scale: 1.05;
            }
        }

        .rating-a {
            img {
                transition: all 150ms ease-in-out;
            }

            &:hover {
                img {
                    scale: 1.3;
                }
            }

        }


        @media (max-width:496px) {
            .d-texts {
                font-size: 0.82rem !important;

                img {
                    width: 20px;
                }
            }
        }

        .txt-cap {
            text-transform: capitalize !important;
        }


        .rating-a.selected img {
            scale: 1.1;
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



    @guest
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="/" class="navbar-brand p-0">

            <img class="m-0 nav-bar-logo" src="{{asset('img/logoo.png')}}" width="300" alt="DoctorWala">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="/" class="nav-item nav-link ">Home</a>
                <a href="/about" class="nav-item nav-link ">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Search</a>
                    <div class="dropdown-menu m-0">
                        <a href="/opd" class="dropdown-item">OPD Details</a>
                        <a href="/doctor" class="dropdown-item">Doctor Details</a>
                        <a href="/pathology" class="dropdown-item">Pathology Details</a>
                        <!-- <a href="/coupons" class="dropdown-item">Coupon Details </a> -->
                    </div>
                </div>
                <a href="/blog" class="nav-item nav-link ">Blogs</a>

                <a href="/contact" class="nav-item nav-link ">Contact</a>
                <a href="/privacy-policy" class="nav-item nav-link">Privacy Policy</a>
            </div>
            <!-- <button type="button" class="btn text-dark" data-bs-toggle="modal" data-bs-target="#searchModal"><i
                    class="fa fa-search"></i></button> -->


            <a href="/dw/user-auth" class="btn btn-primary py-2 px-4 ms-3">Login</a>



            <!-- <a href="" data-bs-toggle="modal" data-bs-target="#userProfileModal" class="btn btn-primary ms-3"><i
                    class="fa fa-user" aria-hidden="true"></i></a> -->

        </div>
    </nav>
    <!-- Navbar End -->
    @endguest


    @auth
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="/dw" class="navbar-brand p-0">

            <img class="m-0 nav-bar-logo" src="{{asset('img/logoo.png')}}" width="300" alt="DoctorWala">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="/dw" class="nav-item nav-link">Home</a>
                <a href="/dw/about" class="nav-item nav-link ">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Search</a>
                    <div class="dropdown-menu m-0">
                        <a href="/dw/opd" class="dropdown-item">OPD Details</a>
                        <a href="/dw/doctor" class="dropdown-item">Doctor Details</a>
                        <a href="/dw/pathology" class="dropdown-item">Pathology Details</a>
                        <!-- <a href="/dw/coupons" class="dropdown-item">Coupon Details </a> -->
                    </div>
                </div>
                <a href="/dw/blog" class="nav-item nav-link">Blogs</a>

                <a href="/dw/contact" class="nav-item nav-link">Contact</a>
                <a href="/dw/privacy-policy" class="nav-item nav-link">Privacy Policy</a>
            </div>
            <!-- <button type="button" class="btn text-dark" data-bs-toggle="modal" data-bs-target="#searchModal"><i
                    class="fa fa-search"></i></button> -->


            <!-- <a href="/dw/user-auth" class="btn btn-primary py-2 px-4 ms-3">Login</a> -->



            <a href="" data-bs-toggle="modal" data-bs-target="#userProfileModal" class="btn btn-primary ms-3"><i
                    class="fa fa-user" aria-hidden="true"></i></a>

        </div>
    </nav>
    <!-- Navbar End -->
    @endauth







    @auth
    <!-- User Profile & Password Edit Modal -->
    <div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body position-relative">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>



                    <form class="text-center" method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        <h4 class="modal-title" id="userProfileModalLabel">User Profile</h4>
                        <p class="mb-4">Update your profile details</p>
                        <div class="row">


                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="user_name" name="user_name"
                                        value="{{ $user->user_name }}">
                                    <label for="user_name">Name</label>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="user_email" name="user_email"
                                        value="{{ $user->user_email }}">
                                    <label for="user_email">Email</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="user_mobile" name="user_mobile"
                                        value="{{ $user->user_mobile }}">
                                    <label for="user_mobile">Mobile</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="user_city" name="user_city"
                                        value="{{ $user->user_city }}">
                                    <label for="user_city">City</label>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <button type="submit" class="btn btn-primary py-3 col-md-12">Update Profile</button>
                                </div>
                            </div>



                        </div>
                    </form>



                    <form class="text-center form password-update" method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        <h4 class="modal-title" id="userProfileModalLabel">Security Privacy</h4>
                        <p class="mb-4">Update your account password</p>
                        <div class="row">


                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="user_old_password"
                                        value="*************">
                                    <label for="user_old_password">Existing Password</label>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="user_password"
                                        name="user_password" placeholder="New Password">
                                    <label for="user_password">New Password</label>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                    <label for="user_password">Confirm Password</label>
                                </div>
                            </div>







                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <button type="submit" class="btn btn-primary py-3 col-md-12">Save Changes</button>
                                </div>
                            </div>



                        </div>
                    </form>


                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <form method="POST" action="{{ route('user.logout') }}">
                                @csrf
                                <a class="btn btn-danger py-3 col-md-12" :href="route('user.logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Logout
                                </a>
                            </form>

                        </div>
                    </div>






                </div>

            </div>
        </div>
    </div>
    @endauth







    <!-- profile update success modal start -->
    <div class="modal fade" id="profileUpdateSuccessModal" tabindex="-1" aria-labelledby="profileUpdateSuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h2 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h2>
                    <h2 class="text-primary">Profile Updated Successfully</h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- profile update success modal end -->

    <!-- profile update Unsuccess modal start -->
    <div class="modal fade" id="profileUpdateUnsuccessModal" tabindex="-1" aria-labelledby="profileUpdateUnsuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                    <h4 class="text-danger">Profile Is Not Updated</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- profile update Unsuccess modal end -->


    <!-- password update success modal start -->
    <div class="modal fade" id="passwordUpdateSuccessModal" tabindex="-1" aria-labelledby="passwordUpdateSuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h3>
                    <h4 class="text-primary">Password Updated Successfully</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- password update success modal end -->

    <!-- password update Unsuccess modal start -->
    <div class="modal fade" id="passwordUpdateUnsuccessModal" tabindex="-1" aria-labelledby="passwordUpdateUnsuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                    <h4 class="text-danger">Password Is Not Updated</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- password update Unsuccess modal end -->
     


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
                    <button class="btn btn-book" onclick="openM('inquiryModal{{ $path->id }}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        Book
                    </button>
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
                                    <button class="btn-appt" onclick="openM('inquiryModal{{ $path->id }}')">
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
                        <div class="fgrp">
                            <label class="flbl">Message *</label>
                            <textarea class="fc" name="user_inquiry" rows="3" placeholder="Describe your requirement..." required></textarea>
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





















    <!-- marquee text start -->
    <marquee id="marqueeText"
        style="background: #051225; color: white; padding: 10px; position: fixed; bottom: 0; width: 100%; z-index: 1000;">
        Welcome to <b>Doctorwala.info</b> !! In addition
        to doctors, we also connect you with pathologists and OPDs. If you require diagnostic services or need to visit
        an OPD for consultation, DoctorWala.info is your go-to platform. We collaborate with trusted pathologists and
        OPDs to ensure that you receive accurate and timely medical tests and consultations. for more information feel
        free to call us or write us directly at <b>info.doctorwala@gmail.com</b>
    </marquee>
    <!-- marquee text end -->





    <!-- Footer Start -->
    <div class="container-fluid text-light py-4 footer-content"
        style="background: #051225; position: relative; z-index: 1001;">
        <div class="">
            <div class="footer-content-inner">

                <div class="text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white border-bottom"
                            href="doctorwala.info">DoctorWala.info</a>. All
                        Rights Reserved.</p>
                </div>

                <!-- <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Designed by <a class="text-white border-bottom" href="https://htmlcodex.com">HTML
                            Codex</a><br>
                        Distributed by <a class="text-white border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </p>
                </div> -->

                <div class="">
                    <div class="d-flex">
                        <a class="btn btn-lg btn-dark btn-lg-square rounded me-2 btn-footer" href="#"><i
                                class="fab fa-twitter fw-normal"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square rounded me-2 btn-footer" href="#"><i
                                class="fab fa-facebook-f fw-normal"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square rounded me-2 btn-footer" href="#"><i
                                class="fab fa-linkedin-in fw-normal"></i></a>
                        <a class="btn btn-lg btn-dark btn-lg-square rounded btn-footer" href="#"><i
                                class="fab fa-instagram fw-normal"></i></a>
                    </div>
                </div>


                <div class="login-partner">
                    @guest
                    <a href="/partner-login" class="btn btn-dark btn-lg rounded me-2">Login As Partner</a>
                    @endguest

                    @auth
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <a class="btn btn-dark btn-lg rounded me-2" :href="route('user.logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            Logout
                        </a>
                    </form>
                    @endauth
                </div>


            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Global Search Section========================================================================================= -->
    <!-- ── Floating Search FAB ── -->
    <button class="gs-fab" id="gsOpenBtn" title="Search Everything">
        <i class="bi bi-search"></i>
        <span class="gs-fab-ring"></span>
    </button>

    <!-- ── Global Search Modal Overlay ── -->
    <div class="gs-overlay" id="gsOverlay">
        <div class="gs-modal" id="gsModal" role="dialog" aria-modal="true" aria-label="Global Search">

            <!-- Header -->
            <div class="gs-modal-header">
                <div class="gs-modal-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div class="gs-modal-title">
                    <h4>Search Your Nearby Doctors</h4>
                    <p>Doctor's name · Clinic's Name · Using Location</p>
                </div>
                <button class="gs-modal-close" id="gsCloseBtn" aria-label="Close">
                    <i class="bi bi-x-lg">X</i>
                </button>
            </div>

            <!-- Search Form — submits to search-result page -->
            @guest
            <form action="{{ route('search.result') }}" method="GET" class="gs-form" id="gsForm">
                <div class="gs-input-group">
                    <i class="bi bi-search gs-input-icon"></i>
                    <input
                        type="text"
                        name="query"
                        id="gsInput"
                        class="gs-input"
                        placeholder="Type doctor name, clinic, test, city..."
                        autocomplete="off"
                        spellcheck="false"
                        required />
                    <button type="submit" class="gs-search-btn">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </button>
                </div>

                <!-- Category chips -->
                <div class="gs-chips-row">
                    <span class="gs-chip-label">Filter:</span>
                    <label class="gs-chip gs-chip-all active-chip">
                        <input type="radio" name="category" value="all" checked hidden> All
                    </label>
                    <label class="gs-chip gs-chip-doc">
                        <input type="radio" name="category" value="doctor" hidden>
                        <i class="bi bi-person-heart-fill"></i> Direct to Doctors
                    </label>
                    <label class="gs-chip gs-chip-opd">
                        <input type="radio" name="category" value="opd" hidden>
                        <i class="bi bi-hospital-fill"></i> OPD Doctors
                    </label>
                    <label class="gs-chip gs-chip-path">
                        <input type="radio" name="category" value="pathology" hidden>
                        <i class="bi bi-flask-fill"></i> Test Pathology
                    </label>
                </div>
            </form>
            @endguest
            @auth
            <form action="{{ route('dw.search.result') }}" method="GET" class="gs-form" id="gsForm">
                <div class="gs-input-group">
                    <i class="bi bi-search gs-input-icon"></i>
                    <input
                        type="text"
                        name="query"
                        id="gsInput"
                        class="gs-input"
                        placeholder="Type doctor name, clinic, test, city..."
                        autocomplete="off"
                        spellcheck="false"
                        required />
                    <button type="submit" class="gs-search-btn">
                        <i class="bi bi-arrow-right-circle-fill"></i>
                    </button>
                </div>

                <!-- Category chips -->
                <div class="gs-chips-row">
                    <span class="gs-chip-label">Filter:</span>
                    <label class="gs-chip gs-chip-all active-chip">
                        <input type="radio" name="category" value="all" checked hidden> All
                    </label>
                    <label class="gs-chip gs-chip-doc">
                        <input type="radio" name="category" value="doctor" hidden>
                        <i class="bi bi-person-heart-fill"></i> Doctors
                    </label>
                    <label class="gs-chip gs-chip-opd">
                        <input type="radio" name="category" value="opd" hidden>
                        <i class="bi bi-hospital-fill"></i> OPD
                    </label>
                    <label class="gs-chip gs-chip-path">
                        <input type="radio" name="category" value="pathology" hidden>
                        <i class="bi bi-flask-fill"></i> Pathology
                    </label>
                </div>
            </form>
            @endauth

            <!-- Quick tags -->
            <div class="gs-quick-tags">
                <span class="gs-quick-label">Popular:</span>
                <button type="button" class="gs-quick-tag" data-val="Cardiologist">Cardiologist</button>
                <button type="button" class="gs-quick-tag" data-val="Blood Test">Blood Test</button>
                <button type="button" class="gs-quick-tag" data-val="Urine Test">Urine Test</button>
                <button type="button" class="gs-quick-tag" data-val="Eye Specialist">Eye Specialist</button>
                <button type="button" class="gs-quick-tag" data-val="X-Ray">X-Ray</button>
                <button type="button" class="gs-quick-tag" data-val="Skin">Skin Doctor</button>
                <button type="button" class="gs-quick-tag" data-val="Dentist">Dentist</button>
                <button type="button" class="gs-quick-tag" data-val="Orthopedic">Orthopedic</button>
                <button type="button" class="gs-quick-tag" data-val="Pediatrician">Pediatrician</button>
                <button type="button" class="gs-quick-tag" data-val="General Physician">General Physician</button>
                <button type="button" class="gs-quick-tag" data-val="General Surgeon">General Surgeon</button>
                <button type="button" class="gs-quick-tag" data-val="Gynecologist">Gynecologist</button>

            </div>

            <!-- ESC hint -->
            <p class="gs-esc-hint">Press <kbd>ESC</kbd> to close &nbsp;·&nbsp; <kbd>Enter</kbd> to search</p>


            <!-- Branding logo -->
            <div class="gs-brand-logo">
                <img src="{{asset('../img/logoo.png')}}" alt="Logo" class="gs-brand-img">
            </div>
        </div>
    </div>
    <!-- Global Search Section========================================================================================= -->




    <!-- PARTNER REGISTER BUTTON -->
    @guest
    <a href="/partner-register" class="btn btn-lg btn-dark2 btn-lg-square rounded partner-login">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <span class="showing-text"> Partner Register</span>
    </a>
    @endguest
    @auth
    @endauth





















    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('../lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('../lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('../lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('../lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('../lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('../lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('../lib/twentytwenty/jquery.event.move.js')}}"></script>
    <script src="{{asset('../lib/twentytwenty/jquery.twentytwenty.js')}}"></script>

    <script src="{{asset('../js/main.js')}}"></script>
    <script src="{{asset('./js/float-btn.js')}}"></script>

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


    <script>
        document.addEventListener('DOMContentLoaded', async () => {

            // 1. Parse browser & OS from userAgent
            const ua = navigator.userAgent;
            const browser = ua.includes('Chrome') ? 'Chrome' :
                ua.includes('Firefox') ? 'Firefox' :
                ua.includes('Safari') ? 'Safari' :
                ua.includes('Edge') ? 'Edge' :
                'Other';

            const os = ua.includes('Windows') ? 'Windows' :
                ua.includes('Mac') ? 'MacOS' :
                ua.includes('Android') ? 'Android' :
                ua.includes('iPhone') || ua.includes('iPad') ? 'iOS' :
                ua.includes('Linux') ? 'Linux' :
                'Other';

            const deviceType = /Mobi|Android|iPhone|iPad/i.test(ua) ? 'Mobile' : 'Desktop';

            // 2. Get approx location from IP (free, no key needed)
            let country = null,
                city = null;
            try {
                const geo = await fetch('https://ipapi.co/json/');
                const geoData = await geo.json();
                country = geoData.country_name;
                city = geoData.city;
            } catch (e) {}

            // 3. Send to Laravel
            fetch('{{ route("visitor.track") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    page_url: window.location.href,
                    referrer: document.referrer || null,
                    browser: browser,
                    os: os,
                    device_type: deviceType,
                    screen_size: `${screen.width}x${screen.height}`,
                    language: navigator.language,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    country: country,
                    city: city,
                })
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

</body>

</html>