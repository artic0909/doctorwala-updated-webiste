<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <title>Doctor Details | Doctorwala</title> -->
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


    <title>Dr. {{$doc->partner_doctor_name}} - {{$doc->partner_doctor_designation}} | Specialist in {{$doc->partner_doctor_specialist}} | Doctorwala</title>

    <!-- Meta Description -->
    <meta name="description" content="Learn more about Dr. {{$doc->partner_doctor_name}}, a {{$doc->partner_doctor_designation}} specializing in {{$doc->partner_doctor_specialist}}. Consultation fees: ₹{{$doc->partner_doctor_fees}}. Check availability and schedule an appointment.">

    <!-- Keywords -->
    <meta name="keywords" content="Dr. {{$doc->partner_doctor_name}}, {{$doc->partner_doctor_specialist}}, {{$doc->partner_doctor_designation}}, Doctor Details, Appointment, Fees, Availability">

    <!-- Author -->
    <meta name="author" content="Your Clinic Name">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="Dr. {{$doc->partner_doctor_name}} - {{$doc->partner_doctor_designation}}">
    <meta property="og:description" content="Get detailed information about Dr. {{$doc->partner_doctor_name}}, a {{$doc->partner_doctor_designation}} specializing in {{$doc->partner_doctor_specialist}}. Book your appointment now.">
    <meta property="og:image" content="{{ asset('img/doctor.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="profile">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Dr. {{$doc->partner_doctor_name}} - {{$doc->partner_doctor_designation}}">
    <meta name="twitter:description" content="Learn about Dr. {{$doc->partner_doctor_name}}, a {{$doc->partner_doctor_specialist}}. Book your consultation today.">
    <meta name="twitter:image" content="{{ asset('img/doctor.png') }}">

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
    <link href="{{asset('../responsive/index_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/service_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/allopdpathdoc_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('./css/topbar.css')}}" rel="stylesheet">
    <link href="{{asset('./css/topbar.css')}}" rel="stylesheet">
    <link href="{{asset('./css/single-doc.css')}}" rel="stylesheet">


    <style>
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



    {{-- ══ HERO ════════════════════════════════════════════════════ --}}
    <div class="hero">
        <div class="hero-inner">
            @guest
            <div class="bc">
                <a href="/">Home</a><span>›</span>
                <a href="/doctor">Doctors</a><span>›</span>
                <span>{{ $doc->partner_doctor_name }}</span>
            </div>
            @endguest
             @auth
             <div class="bc">
                <a href="/dw">Home</a><span>›</span>
                <a href="/dw/doctor">Doctors</a><span>›</span>
                <span>{{ $doc->partner_doctor_name }}</span>
            </div>
             @endauth

            <div class="hero-row">
                {{-- Avatar --}}
                <div class="hero-avatar">
                    @if($doc->banner && $doc->banner->doctorbanner)
                    <img class="full" src="{{ asset('storage/' . $doc->banner->doctorbanner) }}" alt="{{ $doc->partner_doctor_name }}">
                    @else
                    <img src="{{ asset('img/doctor.png') }}" alt="Doctor">
                    @endif
                </div>

                {{-- Info --}}
                <div>
                    <div class="hero-tag">✦ Jio Ji Bharka · Doctorwala.info</div>
                    <div class="hero-name">{{ $doc->partner_doctor_designation }} {{ $doc->partner_doctor_name }}</div>
                    <div>
                        <span class="hero-spec">
                            <svg style="width:10px;height:10px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                            </svg>
                            {{ $doc->partner_doctor_specialist }}
                        </span>
                        <span class="hero-fee">

                            ₹ {{ $doc->partner_doctor_fees }} Consultation
                        </span>
                    </div>
                    <div class="hero-meta">
                        <span>
                            <i class="fa fa-map-marker-alt"></i>
                            {{ $doc->partner_doctor_address }}{{ $doc->partner_doctor_landmark ? ', ' . $doc->partner_doctor_landmark : '' }} — {{ $doc->partner_doctor_state }}, {{ $doc->partner_doctor_city }}
                        </span>
                        <span>
                            <i class="fa fa-phone"></i>
                            <a href="tel:{{ $doc->partner_doctor_mobile }}">+91-{{ $doc->partner_doctor_mobile }}</a>
                        </span>
                        @if($doc->partner_doctor_email)
                        <span>
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:{{ $doc->partner_doctor_email }}">{{ $doc->partner_doctor_email }}</a>
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="hero-actions">
                    <button class="btn btn-book" onclick="openM('inquiryModal{{ $doc->id }}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        Book
                    </button>
                    <a href="tel:{{ $doc->partner_doctor_mobile }}" class="btn btn-call">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                        </svg>
                        Call
                    </a>
                    @if($doc->partner_doctor_google_map_link)
                    <a href="{{ $doc->partner_doctor_google_map_link }}" target="_blank" class="btn btn-ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="3 11 22 2 13 21 11 13 3 11" />
                        </svg>
                        Map
                    </a>
                    @endif
                    <button class="btn btn-ghost" onclick="openM('feedbackModal{{ $doc->id }}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        </svg>
                        Feedback
                    </button>
                </div>
            </div>
        </div>

        <svg class="hero-wave" viewBox="0 0 1440 32" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,16 C360,32 720,0 1080,20 C1260,28 1360,14 1440,16 L1440,32 H0Z" fill="#faf9ff" />
        </svg>
    </div>

    {{-- ══ QUICK INFO BAR ══════════════════════════════════════════ --}}
    <div class="info-bar">
        <div class="info-bar-inner">
            <div class="ibar-chip">
                <div class="ibar-icon ibar-icon--pur">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                </div>
                <div>
                    <div class="ibar-lbl">Specialist</div>
                    <div class="ibar-val">{{ $doc->partner_doctor_specialist }}</div>
                </div>
            </div>

            <div class="ibar-chip">
                <div class="ibar-icon ibar-icon--amb">
                    ₹
                </div>
                <div>
                    <div class="ibar-lbl">Consult Fee</div>
                    <div class="ibar-val ibar-val--amb">₹ {{ $doc->partner_doctor_fees }}</div>
                </div>
            </div>

            <div class="ibar-chip">
                <div class="ibar-icon ibar-icon--rose">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <div>
                    <div class="ibar-lbl">Designation</div>
                    <div class="ibar-val">{{ $doc->partner_doctor_designation }}</div>
                </div>
            </div>

            <div class="ibar-chip">
                <div class="ibar-icon ibar-icon--teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4l3 3" />
                    </svg>
                </div>
                <div>
                    <div class="ibar-lbl">Status</div>
                    @if($doc->status == 'Available')
                    <div class="ibar-val ibar-val--ok">● Available</div>
                    @elseif($doc->status == 'Unavailable')
                    <div class="ibar-val ibar-val--no">● Unavailable</div>
                    @else
                    <div class="ibar-val" style="color:var(--muted)">● {{ $doc->status ?? 'N/A' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ══ TABS ════════════════════════════════════════════════════ --}}
    <div class="tabs-wrap">
        <div class="tabs-scroll">
            <button class="tab-btn active" data-tab="schedule">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                Schedule & Info
            </button>
            <button class="tab-btn" data-tab="photos">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <circle cx="8.5" cy="8.5" r="1.5" />
                    <polyline points="21 15 16 10 5 21" />
                </svg>
                Photos
            </button>
            <button class="tab-btn" data-tab="services">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="16" />
                    <line x1="8" y1="12" x2="16" y2="12" />
                </svg>
                Services
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

        {{-- ── SCHEDULE TAB ────────────────────────────────────── --}}
        <div class="tab-panel active" id="tab-schedule">
            <div class="sec-label">Visit Schedule & Details</div>

            <div class="sched-card">
                {{-- Header --}}
                <div class="sched-head">
                    <div class="sched-head-avatar">
                        <img src="{{ asset('img/doctor.png') }}" alt="Doctor">
                    </div>
                    <div>
                        <div class="sched-head-name">{{ $doc->partner_doctor_designation }} {{ $doc->partner_doctor_name }}</div>
                        <div class="sched-head-sub">{{ $doc->partner_doctor_specialist }} · ₹ {{ $doc->partner_doctor_fees }}</div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="sched-body">

                    {{-- Schedule table --}}
                    <div class="sched-table-wrap">
                        <div class="sched-tbl-label">📅 Weekly Visit Schedule</div>
                        @if(!empty($doc->visit_day_time) && is_array($doc->visit_day_time))
                        <table class="sched-tbl">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Day</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doc->visit_day_time as $i => $visit)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><strong style="color:var(--navy)">{{ $visit['day'] ?? 'N/A' }}</strong></td>
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
                                    <td>
                                        @if($doc->status == 'Available')
                                        <span class="sbadge sbadge-ok">Available</span>
                                        @elseif($doc->status == 'Unavailable')
                                        <span class="sbadge sbadge-no">Unavailable</span>
                                        @else
                                        <span class="sbadge sbadge-def">{{ $doc->status ?? 'N/A' }}</span>
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
                    <div class="sched-aside">
                        <div class="sa-block">
                            <div class="sa-lbl">Specialization</div>
                            <div class="sa-val">{{ $doc->partner_doctor_specialist }}</div>
                        </div>
                        <div class="sa-block">
                            <div class="sa-lbl">Designation</div>
                            <div class="sa-val">{{ $doc->partner_doctor_designation }}</div>
                        </div>
                        <div class="sa-block">
                            <div class="sa-lbl">Consultation Fee</div>
                            <div class="sa-val sa-val--fee">₹ {{ $doc->partner_doctor_fees }}</div>
                        </div>
                        <div class="sa-block">
                            <div class="sa-lbl">Address</div>
                            <div class="sa-val sa-val--sm">
                                {{ $doc->partner_doctor_address }}{{ $doc->partner_doctor_landmark ? ', ' . $doc->partner_doctor_landmark : '' }},
                                {{ $doc->partner_doctor_city }}, {{ $doc->partner_doctor_state }}
                            </div>
                        </div>

                        <div class="sa-btns">
                            <button class="abtn abtn-rose" onclick="openM('inquiryModal{{ $doc->id }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                                Book Appointment
                            </button>
                            <a href="tel:{{ $doc->partner_doctor_mobile }}" class="abtn abtn-call">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
                                </svg>
                                Call Doctor
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── PHOTOS TAB ──────────────────────────────────────── --}}
        <div class="tab-panel" id="tab-photos">
            <div class="sec-label">Photos</div>
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

        {{-- ── ABOUT TAB ───────────────────────────────────────── --}}
        <div class="tab-panel" id="tab-about">
            <div class="sec-label">About Doctor</div>
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
                    <span class="ab-tag">About</span>
                    <h3>About the Doctor</h3>
                    <p>{{ $ac->about_details }}</p>
                </div>
                <div class="about-block about-block--amb">
                    <span class="ab-tag ab-tag--amb">Mission</span>
                    <h3>Mission</h3>
                    <p>{{ $ac->mission_details }}</p>
                </div>
                <div class="about-block about-block--rose">
                    <span class="ab-tag ab-tag--rose">Vision</span>
                    <h3>Vision</h3>
                    <p>{{ $ac->vision_details }}</p>
                </div>
            </div>
            @endforeach
            @endif
        </div>

    </div>{{-- /content --}}

    {{-- ══ MODALS ══════════════════════════════════════════════════ --}}

    {{-- Book Appointment --}}
    <div class="modal-ov" id="inquiryModal{{ $doc->id }}">
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
                <button class="mclose" onclick="closeM('inquiryModal{{ $doc->id }}')">&times;</button>
            </div>
            <div class="mbody">
                <form action="{{ route('dw.doctor.inquiry.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="currently_loggedin_partner_id" value="{{ $doc->currently_loggedin_partner_id }}">
                    <input type="hidden" name="clinic_type" value="Doctor">
                    <div class="fg">
                        <div class="fgrp">
                            <label class="flbl">Inquiry About</label>
                            <input class="fc" name="clinic_name" value="{{ $doc->partner_doctor_name }}" readonly>
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
                            <label class="flbl">Your Message *</label>
                            <textarea class="fc" name="user_inquiry" rows="3" placeholder="Describe your concern..." required></textarea>
                        </div>
                        <button type="submit" class="btn-sub btn-sub-rose">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Feedback --}}
    <div class="modal-ov" id="feedbackModal{{ $doc->id }}">
        <div class="modal-box">
            <div class="mhead">
                <h3>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                    Your Feedback
                </h3>
                <button class="mclose" onclick="closeM('feedbackModal{{ $doc->id }}')">&times;</button>
            </div>
            <div class="mbody">
                <form action="{{ route('dw.doctor.rating.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="currently_loggedin_partner_id" value="{{ $doc->currently_loggedin_partner_id }}">
                    <input type="hidden" name="clinic_type" value="Doctor">
                    <input type="hidden" name="clinic_name" value="{{ $doc->partner_doctor_name }}">
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
                            <textarea class="fc" name="feedback" rows="3" placeholder="Share your experience with this doctor..." required></textarea>
                        </div>
                        <button type="submit" class="btn-sub btn-sub-pur">Send Feedback</button>
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
                    <button class="btn-sub btn-sub-rose" onclick="closeM('inqurySendUnsuccessModal')">Close</button>
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
                    <button class="btn-sub btn-sub-rose" onclick="closeM('feedSendUnsuccessModal')">Close</button>
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

    {{-- ══ JS ════════════════════════════════════════════════════════ --}}
    <script>
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