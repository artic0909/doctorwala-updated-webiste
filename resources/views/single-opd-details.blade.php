<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$opd->clinic_name}} | {{$opd->clinic_contact_person_name}} | {{$opd->clinic_address}} | Doctorwla</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


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


    <style>
        /* =============================================
   TOPBAR — PREMIUM GREEN + WHITE EDITION
   ============================================= */
        .topbar {
            display: none;
            height: 44px;
            position: relative;
            overflow: hidden;
            background: #fff;
            border-bottom: 2px solid #e8f5e9;
            box-shadow: 0 2px 16px rgba(22, 163, 74, 0.10);
        }

        @media (min-width: 992px) {
            .topbar {
                display: block;
            }
        }

        /* Thin animated green top border */
        .topbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg,
                    #064e28, #16a34a, #4ade80, #bbf7d0,
                    #4ade80, #16a34a, #064e28);
            background-size: 300% 100%;
            animation: borderFlow 5s linear infinite;
            z-index: 10;
        }

        @keyframes borderFlow {
            0% {
                background-position: 0% 0;
            }

            100% {
                background-position: 300% 0;
            }
        }

        .topbar-inner {
            position: relative;
            z-index: 2;
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            gap: 0;
        }

        /* ---- LEFT BLOCK ---- */
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0;
            flex: 1;
            overflow: hidden;
            height: 100%;
        }

        /* 24/7 pill - green filled */
        .hours-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, #16a34a, #15803d);
            border-radius: 0 0 14px 0;
            padding: 0 18px 0 0;
            height: 100%;
            padding-left: 0;
            font-size: 0.73rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            white-space: nowrap;
            flex-shrink: 0;
            margin-right: 20px;
            padding: 0 22px;
            box-shadow: 4px 0 14px rgba(22, 163, 74, 0.2);
            animation: slideFromLeft 0.5s cubic-bezier(.34, 1.56, .64, 1) both;
            position: relative;
        }

        .hours-pill::after {
            content: '';
            position: absolute;
            top: 0;
            right: -10px;
            width: 20px;
            height: 100%;
            background: linear-gradient(135deg, #16a34a, #15803d);
            clip-path: polygon(0 0, 0 100%, 100% 100%);
        }

        @keyframes slideFromLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Live pulsing dot */
        .live-dot {
            width: 8px;
            height: 8px;
            position: relative;
            flex-shrink: 0;
        }

        .live-dot span {
            display: block;
            width: 8px;
            height: 8px;
            background: #bbf7d0;
            border-radius: 50%;
        }

        .live-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border: 1.5px solid rgba(187, 247, 208, 0.6);
            border-radius: 50%;
            animation: liveRing 1.8s ease-out infinite;
        }

        @keyframes liveRing {
            0% {
                opacity: 0.9;
                transform: scale(0.5);
            }

            100% {
                opacity: 0;
                transform: scale(2);
            }
        }

        /* Ticker */
        .ticker-wrap {
            flex: 1;
            overflow: hidden;
            min-width: 0;
            mask-image: linear-gradient(90deg, transparent, black 5%, black 95%, transparent);
            -webkit-mask-image: linear-gradient(90deg, transparent, black 5%, black 95%, transparent);
        }

        .ticker-track {
            display: flex;
            width: max-content;
            gap: 50px;
            animation: tick 24s linear infinite;
        }

        .ticker-track:hover {
            animation-play-state: paused;
        }

        @keyframes tick {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .ticker-track .t-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.78rem;
            font-weight: 700;
            color: #166534;
            white-space: nowrap;
        }

        .ticker-track .t-item i {
            font-size: 0.7rem;
            color: #22c55e;
        }

        .ticker-track .t-sep {
            color: #86efac;
            font-size: 0.9rem;
        }

        /* ---- RIGHT BLOCK ---- */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            height: 100%;
        }

        /* Contact chips - outlined green on white */
        .c-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px 6px 7px;
            border-radius: 30px;
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            text-decoration: none;
            font-size: 0.76rem;
            font-weight: 800;
            color: #15803d;
            white-space: nowrap;
            transition: all 0.22s cubic-bezier(.34, 1.56, .64, 1);
        }

        .c-chip:nth-child(1) {
            animation: slideFromRight 0.5s ease 0.1s both;
        }

        .c-chip:nth-child(2) {
            animation: slideFromRight 0.5s ease 0.25s both;
        }

        @keyframes slideFromRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .c-chip:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            border-color: transparent;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(22, 163, 74, 0.28);
        }

        .c-chip .c-ico {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.6rem;
            color: #fff;
            transition: transform 0.22s ease;
            box-shadow: 0 2px 6px rgba(22, 163, 74, 0.3);
        }

        .c-chip:hover .c-ico {
            background: rgba(255, 255, 255, 0.22);
            transform: rotate(-10deg) scale(1.1);
            box-shadow: none;
        }

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

        .txt-cap {
            text-transform: capitalize !important;
        }


        @media (max-width:496px) {
            .d-texts {
                font-size: 0.82rem !important;

                img {
                    width: 20px;
                }
            }
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






    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 hero-header mb-5">
        <div class="row py-3">
            <div class="col-12 text-center">
                <h1 class="display-3 text-white animated zoomIn txt-cap">{{$opd->clinic_name}}</h1>
                <a href="/dw" class="h4 text-white" style="text-decoration: underline;">Home</a>
                <i class="fa fa-plus text-dark px-2" style="font-size: 2rem; font-weight: 700;"></i>
                <a href="#" class="h4 text-white">Details</a>
            </div>
        </div>
    </div>
    <!-- Hero End -->












    <!-- Details Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            @if($opd->banner && $opd->banner->opdbanner)
                            <img class="img-fluid rounded-top w-100" src="{{ asset('storage/' . $opd->banner->opdbanner) }}" alt="">
                            @else
                            <img src="https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=" class="card-img-top" alt="Default Image">
                            @endif
                            <div
                                class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                                <img src="{{asset('img/logo.png')}}" width="80" alt="">
                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-center rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">Doctorwala.info</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="section-title bg-light rounded h-100 p-5">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">jio ji bharka</h5>
                        <h2 class="display-6 mb-4 txt-cap">{{$opd->clinic_name}}</h2>


                        <div class="d-details">
                            <p class="location_d d-texts txt-cap">
                                <strong><i class="fa fa-map-marker-alt me-2"></i>Address: {{$opd->clinic_address}}</strong>
                            </p>

                            <p class="landmark_d d-texts txt-cap">
                                <strong><i class="fa fa-map-pin me-2"></i>Landmark: {{$opd->clinic_landmark}}</strong>
                            </p>

                            <p class="landmark_d d-texts txt-cap">
                                <strong><i class="fa fa-globe me-2"></i>State/City: {{$opd->clinic_state}}-{{$opd->clinic_city}}</strong>
                            </p>

                            <p class="contact_d d-texts">
                                <strong><i class="fa fa-phone me-2"></i>Phone: +91-<a href="tel:{{$opd->clinic_mobile_number}}" class="a-not">{{$opd->clinic_mobile_number}}</a></strong>
                            </p>

                            <p class="email_d d-texts">
                                <strong><i class="fa fa-envelope me-2"></i>Email: <a href="mailto:{{$opd->clinic_email}}" class="a-not">{{$opd->clinic_email}}</a></strong>
                            </p>


                            <p class="contact_person_d d-texts txt-cap">
                                <strong><i class="fa fa-user me-2"></i>Contact Person: {{$opd->clinic_contact_person_name}}</strong>
                            </p>




                        </div>







                        <div class="d-buttons mt-5">
                            <a href="" data-bs-toggle="modal" data-bs-target="#myInquirySendModal{{$opd->id}}"
                                class="btn btn-dark btn-darkk py-md-3 px-md-5 me-3 mb-2 animated slideInLeft">Book Appointment</a>

                            <a href="{{$opd->clinic_google_map_link}}" target="_blank" class="btn btn-secondary py-md-3 px-md-5 me-3 mb-2 animated slideInRight">See
                                Location</a>

                            <a href="" data-bs-toggle="modal" data-bs-target="#myFeedBackModal{{$opd->id}}"
                                class="btn btn-primary py-md-3 px-md-5 mb-2 animated slideInRight">Feedback</a>
                        </div>




                    </div>
                </div>



            </div>
        </div>
    </div>
    <!-- Details End -->










    <!-- Tab bar Start -->
    <div class="d_tab_bar">
        <div class="container">
            <div class="row">





                <!-- Nav tabs -->
                <div class="col-md-12 bg-primaryy p-3 mb-5 my-tab-lists">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-justified d-flex justify-content-between TABLIST row" id="myTab"
                        role="tablist" style="border: none;">
                        <li class="nav-item col-md-2 text-center">
                            <a class="nav-link text-dark bg-white active" id="opd-tab" data-toggle="tab" href="#opd"
                                role="tab" aria-controls="opd" aria-selected="true" style="font-weight: 900;">OPD</a>
                        </li>




                        <li class="nav-item col-md-2 text-center">
                            <a class="nav-link text-dark bg-white" id="service-tab" data-toggle="tab" href="#service"
                                role="tab" aria-controls="service" aria-selected="false"
                                style="font-weight: 900;">Service
                                Lists</a>
                        </li>

                        <li class="nav-item col-md-2 text-center">
                            <a class="nav-link text-dark bg-white" id="photos-tab" data-toggle="tab" href="#photos"
                                role="tab" aria-controls="photos" aria-selected="false"
                                style="font-weight: 900;">Photos</a>
                        </li>

                        <li class="nav-item col-md-2 text-center">
                            <a class="nav-link text-dark bg-white" id="about-tab" data-toggle="tab" href="#about"
                                role="tab" aria-controls="about" aria-selected="false"
                                style="font-weight: 900;">About</a>
                        </li>
                    </ul>

                </div>






                <!-- Tab panes for OPD -->
                <div class="tab-content p-0" id="myTabContent">



                    <!-- OPD Tab -->
                    <div class="tab-pane fade show active" id="opd" role="tabpanel" aria-labelledby="opd-tab">




                        <div class="section-title bg-light rounded h-100 p-5">
                            <h5 class="position-relative d-inline-block text-primary text-uppercase">opd details</h5>



                            <div class="pricing pricing-palden">

                                @if($doctors->isEmpty())

                                <div class="alert alert-primary w-100 mt-2 text-center mx-4">
                                    No doctors found. Please try again later.
                                </div>

                                @else

                                @foreach($doctors as $doctor)
                                <div class="pricing-item features-item ja-animate mx-4"
                                    data-animation="move-from-bottom" data-delay="item-0" style="min-height: 497px;">
                                    <div class="pricing-deco">
                                        <svg class="pricing-deco-img" enable-background="new 0 0 300 100" height="100px"
                                            id="Layer_1" preserveAspectRatio="none" version="1.1" viewBox="0 0 300 100"
                                            width="300px" x="0px" xml:space="preserve" y="0px">
                                            <path class="deco-layer deco-layer--1"
                                                d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z"
                                                fill="#FFFFFF" opacity="0.6"></path>
                                            <path class="deco-layer deco-layer--2"
                                                d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z"
                                                fill="#FFFFFF" opacity="0.6"></path>
                                            <path class="deco-layer deco-layer--3"
                                                d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716H42.401L43.415,98.342z"
                                                fill="#FFFFFF" opacity="0.7"></path>
                                            <path class="deco-layer deco-layer--4"
                                                d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z"
                                                fill="#FFFFFF"></path>
                                        </svg>


                                        <div class="pricing-price">
                                            <img src="{{asset('img/doctor.png')}}" width="80" alt=""
                                                style="filter: drop-shadow(1px 1px 1px rgba(0, 0, 0, 0.411));">
                                        </div>
                                        <h3 class="pricing-title">{{$doctor->doctor_designation}}. {{$doctor->doctor_name}}</h3>
                                    </div>
                                    <p>
                                    <ul class="list-group list-group-flush text-start" style="margin-top: -60px;">
                                        <!-- <li class="list-group-item"><strong style="text-transform: capitalize;">Designation : {{$doctor->doctor_designation}}</strong></li> -->
                                        <li class="list-group-item"><strong style="text-transform: capitalize;" class="d-flex align-items-center gap-2"><img src="{{asset('img/surgeon.png')}}" alt="" width="26"> {{$doctor->doctor_specialist}}</strong></li>
                                        <li class="list-group-item"><strong class="d-flex align-items-center gap-2"><img src="{{asset('img/pay.png')}}" alt="" width="26"> ₹ {{$doctor->doctor_fees}}</strong></li>
                                        @if($doctor->doctor_more)
                                        <li class="list-group-item"><strong class="d-flex align-items-start gap-2"><img src="{{asset('img/ad.png')}}" alt="" width="26"> {{$doctor->doctor_more}}</strong></li>
                                        @endif
                                    </ul>
                                    </p>
                                    <div class="p-4">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#myOPDViewModal{{$doctor->id}}"
                                            class="btn btn-primaryy w-100">View Details</a>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>


                        </div>

                    </div>



                </div>





                <!-- Tab panes for Service Lists -->
                <div class="tab-content p-0 mt-4" id="myTabContent">



                    <!-- Service Tab -->
                    <div class="tab-pane fade show active" id="service" role="tabpanel" aria-labelledby="service-tab">




                        <div class="section-title bg-light rounded h-100 p-5">
                            <h5 class="position-relative d-inline-block text-dark text-uppercase">Service Lists
                            </h5>



                            <ul class="service-lists" style="list-style: number;">


                                @if($services->isEmpty())
                                <div class="alert alert-primary w-100 mt-2 text-center mx-4">
                                    No Service Lists found. Please try again later.
                                </div>
                                @else
                                @foreach($services as $service)
                                @if(!empty($service->service_lists) && is_array($service->service_lists))
                                @foreach($service->service_lists as $list)
                                <li>
                                    <p class="fs-8 fw-bold"><i class="fa fa-stethoscope"></i>
                                        <span class="text-primary text-capitalize">{{ $list }}</span>
                                    </p>
                                </li>
                                @endforeach
                                @else
                                <li>
                                    <p class="fs-8 fw-bold text-muted">No services available for this entry.</p>
                                </li>
                                @endif
                                @endforeach
                                @endif



                            </ul>




                        </div>
                    </div>
                </div>




                <!-- Tab panes for Photos -->
                <div class="tab-content p-0 mt-4" id="myTabContent">



                    <!-- Photos Tab -->
                    <div class="tab-pane fade show active" id="photos" role="tabpanel" aria-labelledby="photos-tab">




                        <div class="section-title bg-light rounded h-100 p-5">
                            <h5 class="position-relative d-inline-block text-dark text-uppercase">Photos
                            </h5>



                            <div
                                class="clinic_photos mt-4 d-flex gap-4 flex-wrap justify-content-start align-items-center">

                                @if($photos->isEmpty())
                                <div class="alert alert-primary w-100 mt-2 text-center mx-4">
                                    No photos found. Please try again later.
                                </div>
                                @else
                                @foreach($photos as $photo)
                                @php

                                $decodedImages = is_string($photo->images) ? json_decode($photo->images, true) : $photo->images;
                                @endphp

                                @if(!empty($decodedImages) && is_array($decodedImages))
                                @foreach($decodedImages as $key => $item)
                                <!-- Trigger for Modal -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal{{ $photo->id }}{{ $key }}">
                                    <img src="{{ asset('storage/' . $item) }}" width="160" alt="Photo">
                                </a>

                                <!-- Dynamic Modal -->
                                <div class="modal fade" id="photoModal{{ $photo->id }}{{ $key }}" tabindex="-1"
                                    aria-labelledby="photoModalLabel{{ $photo->id }}{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="photoModalLabel{{ $photo->id }}{{ $key }}">
                                                    Photo View
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{ asset('storage/' . $item) }}" width="100%" alt="Photo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p>No images available for this entry.</p>
                                @endif
                                @endforeach
                                @endif



                            </div>




                        </div>



                    </div>
                </div>




                <!-- Tab panes for About -->
                <div class="tab-content p-0 mt-4" id="myTabContent">



                    <!-- About Tab -->
                    <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">




                        <div class="section-title bg-light rounded h-100 p-5">
                            <h5 class="position-relative d-inline-block text-primary text-uppercase">About Clinic
                            </h5>

                            @if($aboutClinics->isEmpty())

                            <div class="alert alert-primary w-100 mt-2 text-center mx-4">
                                No About Details found. Please try again later.
                            </div>

                            @else

                            @foreach($aboutClinics as $ac)
                            <div class="about_clinic">
                                <p class="p-3 bg-white" style="text-align: justify;">
                                    {{$ac->about_details}}
                                </p>
                            </div>



                            <h5 class="position-relative d-inline-block text-primary text-uppercase mt-3">Mission
                            </h5>



                            <div class="about_clinic">
                                <p class="p-3 bg-white" style="text-align: justify;">
                                    {{$ac->mission_details}}
                                </p>
                            </div>





                            <h5 class="position-relative d-inline-block text-primary text-uppercase mt-3">Vision
                            </h5>



                            <div class="about_clinic">
                                <p class="p-3 bg-white" style="text-align: justify;">
                                    {{$ac->vision_details}}
                                </p>
                            </div>
                            @endforeach
                            @endif


                        </div>





                    </div>
                </div>








            </div>


            <br><br><br><br><br>
        </div>
    </div>
    <!-- Tab bar End -->











    <!-- opd view modal -->
    @foreach($doctors as $doctor)
    <div class="modal fade" id="myOPDViewModal{{$doctor->id}}" tabindex="-1" aria-labelledby="myOPDViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title text-primary txt-cap" id="exampleModalLabel"><img src="{{asset('img/doctor.png')}}" width="40"
                            alt=""> {{$doctor->doctor_designation}}. {{$doctor->doctor_name}}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color:#051225;">
                    <p class="sp" style="text-transform: capitalize;"><strong>Specialization: </strong>{{$doctor->doctor_specialist}}</p>
                    <p class="fees"><strong>Fees: </strong>₹ {{$doctor->doctor_fees}}</p>

                    @if($doctor->doctor_more)
                    <p class="more"><strong>About: </strong>{{$doctor->doctor_more}}</p>
                    @endif


                    <div class="time">
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
                                @if(!empty($doctor->visit_day_time) && is_array($doctor->visit_day_time))
                                @foreach($doctor->visit_day_time as $visit)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $visit['day'] }}</td>
                                    <td>
                                        @if(!empty($visit['start_time']) || !empty($visit['end_time']))
                                        {{ \Carbon\Carbon::parse($visit['start_time'])->format('h:i A') }} -
                                        {{ !empty($visit['end_time']) ? \Carbon\Carbon::parse($visit['end_time'])->format('h:i A') : 'Not Set' }}
                                        @else
                                        No time available
                                        @endif
                                    </td>
                                    <td>
                                        @if($doctor->status == 'Available')
                                        <span class="badge bg-success">{{ $doctor->status }}</span>
                                        @elseif($doctor->status == 'Unavailable')
                                        <span class="badge bg-danger">{{ $doctor->status }}</span>
                                        @else
                                        <span class="badge bg-secondary">{{ $doctor->status }}</span> <!-- Default for other statuses -->
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="text-muted">
                                    <td colspan="3">No data found</td>
                                </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>



                    <button type="button" class="btn btn-primaryy w-100" data-bs-dismiss="modal">Close It</button>



                </div>
            </div>
        </div>
    </div>
    @endforeach






    <!-- inquiry send modal -->
    <div class="modal fade" id="myInquirySendModal{{$opd->id}}" tabindex="-1" aria-labelledby="myInquirySendModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <h3 class="text-center mb-2 text-primary">Fill this form and get best deals from Doctorwala </h3>

                    <form action="{{route('dw.opd.inquiry.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">


                            <div class="col-12" style="display: none;">
                                <label for="currently_loggedin_partner_id" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Partner ID</label>
                                <input type="text" class="form-control border-0 bg-light px-4" id="currently_loggedin_partner_id"
                                    name="currently_loggedin_partner_id" value="{{ $opd->currently_loggedin_partner_id}}" style="height: 55px;" readonly>
                            </div>

                            <div class="col-12" style="display: none;">
                                <label for="clinic_type" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Clinic Type</label>
                                <input type="text" class="form-control border-0 bg-light px-4" id="clinic_type"
                                    name="clinic_type" value="OPD" style="height: 55px;" readonly>
                            </div>


                            <div class="col-12 mt-2">
                                <label for="clinic_name" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Inquiry
                                    About</label>
                                <input type="text" class="form-control border-0 bg-light px-4" id="clinic_name"
                                    name="clinic_name" value="{{ $opd->clinic_name}}" style="height: 55px;" readonly>
                            </div>


                            <div class="col-6">
                                <label for="user_name" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Your Name</label>
                                @auth
                                <input type="text" class="form-control border-0 bg-light px-4" value="{{ $user->user_name }}"
                                    name="user_name" id="user_name" style="height: 55px;" readonly>
                                @endauth
                                @guest
                                <input type="text" class="form-control border-0 bg-light px-4" value="Guest"
                                    name="user_name" id="user_name" style="height: 55px;" readonly>
                                @endguest
                            </div>

                            <div class="col-6">
                                <label for="user_mobile" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Your Mobile</label>
                                @auth
                                <input type="text" class="form-control border-0 bg-light px-4" value="{{ $user->user_mobile }}"
                                    name="user_mobile" id="user_mobile" style="height: 55px;">
                                @endauth
                                @guest
                                <input type="text" class="form-control border-0 bg-light px-4" placeholder="Mobile"
                                    name="user_mobile" id="user_mobile" style="height: 55px;" required>
                                @endguest
                            </div>

                            <div class="col-12">
                                <label for="user_email" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Your Email</label>
                                @auth
                                <input type="text" class="form-control border-0 bg-light px-4"
                                    value="{{ $user->user_email }}" name="user_email" id="user_email" style="height: 55px;" readonly>
                                @endauth
                                @guest
                                <input type="text" class="form-control border-0 bg-light px-4" value=""
                                    name="user_email" id="user_email" style="height: 55px;" placeholder="Email" required>
                                @endguest
                            </div>


                            <div class="col-12">
                                <label for="user_inquiry" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Your
                                    Inquiry</label>
                                <textarea class="form-control border-0 bg-light px-4 py-3" rows="5"
                                    placeholder="Message" name="user_inquiry" id="user_inquiry" required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Book Appointment</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    @if(session('success'))
    <script>
        const successModal = new bootstrap.Modal(document.getElementById('inqurySendSuccessModal'));
        successModal.show();
    </script>
    @endif

    @if(session('error'))
    <script>
        const errorModal = new bootstrap.Modal(document.getElementById('inqurySendUnsuccessModal'));
        errorModal.show();
    </script>
    @endif

    @if(session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = "{{ session('success') ? 'inqurySendSuccessModal' : 'inqurySendUnsuccessModal' }}";
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        });
    </script>
    @endif

    <!-- inqury send success modal start -->
    <div class="modal fade" id="inqurySendSuccessModal" tabindex="-1" aria-labelledby="inqurySendSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h2 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h2>
                    @auth
                    <h2 class="text-primary text-center">Hello {{ $user->user_name }}, Your Inquiry Is Sent Successfully</h2>
                    @endauth
                    @guest
                    <h2 class="text-primary text-center">Hello Guest User, Your Inquiry Is Sent Successfully</h2>
                    @endguest
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- inqury send success modal end -->

    <!-- inqury send Unsuccess modal start -->
    <div class="modal fade" id="inqurySendUnsuccessModal" tabindex="-1" aria-labelledby="inqurySendUnsuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                    @auth
                    <h4 class="text-danger text-center">Hello {{ $user->user_name }}, Your Inquiry Is Not Sent !!</h4>
                    @endauth
                    @guest
                    <h4 class="text-danger text-center">Hello Guest User, Your Inquiry Is Not Sent !!</h4>
                    @endguest
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- inqury send Unsuccess modal end -->










    <!-- feedback send modal -->
    <div class="modal fade" id="myFeedBackModal{{ $opd->id }}" tabindex="-1" aria-labelledby="myFeedBackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <h3 class="text-center mb-2 text-primary">Give Your Valuable Feedback </h3>

                    <form class="mt-3" action="{{ route('dw.opd.rating.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <p class="ratings d-flex  gap-3 mt-3 align-items-center flex-wrap" style="list-style-type: none;">
                            <span><strong><i class="fa-solid fa-stethoscope text-danger me-2"></i>Rating :</strong></span>
                            <a href="javascript:void(0);" class="rating-a" data-rating="1"><img src="{{asset('img/1.png')}}" width="35" alt="1"></a>
                            <a href="javascript:void(0);" class="rating-a" data-rating="2"><img src="{{asset('img/2.png')}}" width="35" alt="2"></a>
                            <a href="javascript:void(0);" class="rating-a" data-rating="3"><img src="{{asset('img/3.png')}}" width="35" alt="3"></a>
                            <a href="javascript:void(0);" class="rating-a" data-rating="4"><img src="{{asset('img/5.png')}}" width="35" alt="4"></a>
                            <a href="javascript:void(0);" class="rating-a" data-rating="5"><img src="{{asset('img/4.png')}}" width="35" alt="5"></a>
                        </p>

                        <input type="hidden" id="rating" name="rating" value="0" required>
                        <p><i class="fa fa-star text-warning" aria-hidden="true"></i> Your Rating is: <b><span id="user-rating" class="text-danger">0</span> out of 5</b></p>


                        <div class="row g-3">

                            <div class="col-12" style="display: none;">
                                <label for="currently_loggedin_partner_id" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Partner ID</label>
                                <input type="text" class="form-control border-0 bg-light px-4" id="currently_loggedin_partner_id"
                                    name="currently_loggedin_partner_id" value="{{ $opd->currently_loggedin_partner_id}}" style="height: 55px;" readonly>
                            </div>

                            <div class="col-12" style="display: none;">
                                <label for="clinic_type" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Clinic Type</label>
                                <input type="text" class="form-control border-0 bg-light px-4" id="clinic_type"
                                    name="clinic_type" value="OPD" style="height: 55px;" readonly>
                            </div>


                            <div class="col-12 mt-2" style="display: none;">
                                <label for="clinic_name" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Inquiry
                                    About</label>
                                <input type="text" class="form-control border-0 bg-light px-4" id="clinic_name"
                                    name="clinic_name" value="{{ $opd->clinic_name}}" style="height: 55px;" readonly>
                            </div>

                            <div class="col-6">
                                <label for="user_name" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Your Name</label>
                                @auth
                                <input type="text" class="form-control border-0 bg-light px-4" value="{{ $user->user_name }}"
                                    name="user_name" id="user_name" style="height: 55px;" readonly>
                                @endauth
                                @guest
                                <input type="text" class="form-control border-0 bg-light px-4" value="Guest"
                                    name="user_name" id="user_name" style="height: 55px;" readonly>
                                @endguest
                            </div>

                            <div class="col-6">
                                <label for="user_email" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Your Email</label>
                                @auth
                                <input type="text" class="form-control border-0 bg-light px-4"
                                    value="{{ $user->user_email }}" name="user_email" id="user_email" style="height: 55px;">
                                @endauth
                                @guest
                                <input type="text" class="form-control border-0 bg-light px-4" value="Guest"
                                    name="user_email" id="user_email" style="height: 55px;">
                                @endguest
                            </div>

                            <div class="col-12">
                                <label for="feedback" class="form-label fw-bold"><span class="text-danger"><i
                                            class="fa fa-stethoscope" aria-hidden="true"></i></span> Your
                                    Feedback</label>
                                <textarea class="form-control border-0 bg-light px-4 py-3" rows="5"
                                    placeholder="Feedback" name="feedback" id="feedback" required></textarea>
                            </div>


                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Send Feedback</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    @if(session('successFeed'))
    <script>
        const successModalFeed = new bootstrap.Modal(document.getElementById('feedSendSuccessModal'));
        successModal.show();
    </script>
    @endif

    @if(session('errorFeed'))
    <script>
        const errorModalFeed = new bootstrap.Modal(document.getElementById('feedSendUnsuccessModal'));
        errorModal.show();
    </script>
    @endif

    @if(session('successFeed') || session('errorFeed'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = "{{ session('successFeed') ? 'feedSendSuccessModal' : 'feedSendUnsuccessModal' }}";
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        });
    </script>
    @endif

    <!-- feed send success modal start -->
    <div class="modal fade" id="feedSendSuccessModal" tabindex="-1" aria-labelledby="feedSendSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h2 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h2>
                    @auth
                    <h2 class="text-primary text-center">Hello {{ $user->user_name }}, Thanks for Your Feedback</h2>
                    @endauth
                    @guest
                    <h2 class="text-primary text-center">Hello Guest User, Thanks for Your Feedback</h2>
                    @endguest
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- feed send success modal end -->

    <!-- feed send Unsuccess modal start -->
    <div class="modal fade" id="feedSendUnsuccessModal" tabindex="-1" aria-labelledby="feedSendUnsuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                    <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                    @auth
                    <h4 class="text-danger text-center">Hello {{ $user->user_name }}, There was an error in sending your feedback, Please try again!</h4>
                    @endauth
                    @guest
                    <h4 class="text-danger text-center">Hello Guest User, There was an error in sending your feedback, Please try again!</h4>
                    @endguest
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- feed send Unsuccess modal end -->






















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
                    <h4>Search Everything</h4>
                    <p>Doctors · OPD Clinics · Pathology Labs</p>
                </div>
                <button class="gs-modal-close" id="gsCloseBtn" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
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
            </div>

            <!-- ESC hint -->
            <p class="gs-esc-hint">Press <kbd>ESC</kbd> to close &nbsp;·&nbsp; <kbd>Enter</kbd> to search</p>

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
    <script src="{{asset('./js/float-btn.js')}}"></script>
</body>

</html>