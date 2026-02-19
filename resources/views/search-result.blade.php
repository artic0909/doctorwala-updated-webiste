<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Searched for "{{ $query }}" | Doctorwala</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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
    <link href="{{asset('../css/opd-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/path-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/doctor-search.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">
    <link href="{{asset('../responsive/index_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('responsive/service_responsive.css')}}" rel="stylesheet">


    <style>
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


    <!-- Topbar Start -->
    <div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <small class="py-2"><i class="far fa-clock text-primary me-2"></i>Opening Hours: Mon To Sun : 24/7 Available</small>
                </div>
            </div>
            <div class="col-md-6 text-center text-lg-end">
                <div class="position-relative d-inline-flex align-items-center bg-primary text-white top-shape px-5">
                    @foreach($aboutDetails as $aboutDetail)
                    <div class="me-3 pe-3 border-end py-2">
                        <p class="m-0"><i class="fa fa-envelope-open me-2"></i><a href="mailto:{{$aboutDetail->email}}" class="text-white">{{$aboutDetail->email}}</a></p>
                    </div>
                    <div class="py-2">
                        <p class="m-0"><i class="fa fa-phone me-2"></i><a href="tel:{{$aboutDetail->number}}" class="text-white">+91-{{$aboutDetail->number}}</a></p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->











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
                                    <a href="#"><i class="fa-solid fa-location-dot"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            @guest
                            <div class="doc-listing-body">
                                <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-name">{{ $doc->partner_doctor_name }}</a>
                                <div class="doc-listing-divider"></div>
                                <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-listing-address">
                                    <i class="bi bi-geo-alt-fill"></i><span>{{ $doc->partner_doctor_address }}</span>
                                </a>
                                <div class="doc-listing-footer">
                                    <a href="{{ url('/doctor/'.$doc->slug) }}" class="doc-open-btn"><i class="bi bi-box-arrow-up-right"></i> Open Now</a>
                                </div>
                            </div>
                            @endguest
                            @auth
                            <div class="doc-listing-body">
                                <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-listing-name">{{ $doc->partner_doctor_name }}</a>
                                <div class="doc-listing-divider"></div>
                                <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-listing-address">
                                    <i class="bi bi-geo-alt-fill"></i><span>{{ $doc->partner_doctor_address }}</span>
                                </a>
                                <div class="doc-listing-footer">
                                    <a href="{{ url('/dw/doctor/'.$doc->slug) }}" class="doc-open-btn"><i class="bi bi-box-arrow-up-right"></i> Open Now</a>
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
                                    <a href="#"><i class="fa-solid fa-location-dot"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            @guest
                            <div class="opd-listing-body">
                                <a href="{{ url('/opd/'.$opd->slug) }}" class="opd-listing-name">{{ $opd->clinic_name }}</a>
                                <div class="opd-listing-divider"></div>
                                <a href="{{ url('/opd/'.$opd->slug) }}" class="opd-listing-address">
                                    <i class="bi bi-geo-alt-fill"></i><span>{{ $opd->clinic_address }}</span>
                                </a>
                                <div class="opd-listing-footer">
                                    <a href="{{ url('/opd/'.$opd->slug) }}" class="opd-open-btn"><i class="bi bi-box-arrow-up-right"></i> Open Now</a>
                                </div>
                            </div>
                            @endguest
                            @auth
                            <div class="opd-listing-body">
                                <a href="{{ url('/dw/opd/'.$opd->slug) }}" class="opd-listing-name">{{ $opd->clinic_name }}</a>
                                <div class="opd-listing-divider"></div>
                                <a href="{{ url('/dw/opd/'.$opd->slug) }}" class="opd-listing-address">
                                    <i class="bi bi-geo-alt-fill"></i><span>{{ $opd->clinic_address }}</span>
                                </a>
                                <div class="opd-listing-footer">
                                    <a href="{{ url('/dw/opd/'.$opd->slug) }}" class="opd-open-btn"><i class="bi bi-box-arrow-up-right"></i> Open Now</a>
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
                                    <a href="#"><i class="fa-solid fa-location-dot"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            @guest
                            <div class="path-listing-body">
                                <a href="{{ url('/pathology/'.$path->slug) }}" class="path-listing-name">{{ $path->clinic_name }}</a>
                                <div class="path-listing-divider"></div>
                                <a href="{{ url('/pathology/'.$path->slug) }}" class="path-listing-address">
                                    <i class="bi bi-geo-alt-fill"></i><span>{{ $path->clinic_address }}</span>
                                </a>
                                <div class="path-listing-footer">
                                    <a href="{{ url('/pathology/'.$path->slug) }}" class="path-open-btn"><i class="bi bi-box-arrow-up-right"></i> Open Now</a>
                                </div>
                            </div>
                            @endguest
                            @auth
                            <div class="path-listing-body">
                                <a href="{{ url('/dw/pathology/'.$path->slug) }}" class="path-listing-name">{{ $path->clinic_name }}</a>
                                <div class="path-listing-divider"></div>
                                <a href="{{ url('/dw/pathology/'.$path->slug) }}" class="path-listing-address">
                                    <i class="bi bi-geo-alt-fill"></i><span>{{ $path->clinic_address }}</span>
                                </a>
                                <div class="path-listing-footer">
                                    <a href="{{ url('/dw/pathology/'.$path->slug) }}" class="path-open-btn"><i class="bi bi-box-arrow-up-right"></i> Open Now</a>
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






    <!-- marquee text start -->
    <marquee id="marqueeText"
        style="background: #051225; color: white; padding: 10px; position: fixed; bottom: 0; width: 100%; z-index: 1000;">
        Welcome to <b>Doctorwala.info</b> !! In addition
        to doctors, we also connect you with pathologists and OPDs. If you require diagnostic services or need to
        visit
        an OPD for consultation, DoctorWala.info is your go-to platform. We collaborate with trusted pathologists
        and
        OPDs to ensure that you receive accurate and timely medical tests and consultations. for more information
        feel
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









    @if(session('password_update_status') == 'success')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = new bootstrap.Modal(document.getElementById('passwordUpdateSuccessModal'));
            successModal.show();
        });
    </script>
    @elseif(session('password_update_status') == 'failure')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const failureModal = new bootstrap.Modal(document.getElementById('passwordUpdateUnsuccessModal'));
            failureModal.show();
        });
    </script>
    @endif

    @if(session('profile_update_status') == 'success')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = new bootstrap.Modal(document.getElementById('profileUpdateSuccessModal'));
            successModal.show();
        });
    </script>
    @elseif(session('profile_update_status') == 'failure')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const failureModal = new bootstrap.Modal(document.getElementById('profileUpdateUnsuccessModal'));
            failureModal.show();
        });
    </script>
    @endif










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

    <!-- Template Javascript -->
    <script src="{{asset('../js/main.js')}}"></script>
    <script src="{{asset('../js/cards-scroll.js')}}"></script>
    <script src="{{asset('../js/captcha.js')}}"></script>


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