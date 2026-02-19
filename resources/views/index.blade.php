<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Doctorwala Info</title>
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

    <!-- Carousels -->
    <link href="{{asset('./css/opd-carousel-card.css')}}" rel="stylesheet">
    <link href="{{asset('./css/path-carousel-card.css')}}" rel="stylesheet">
    <link href="{{asset('./css/doc-carousel-card.css')}}" rel="stylesheet">

    <!-- Search Area -->
    <link href="{{asset('./css/serach-banner.css')}}" rel="stylesheet">

    <link href="{{asset('./css/partner-btn.css')}}" rel="stylesheet">
    <link href="{{asset('./responsive/index_responsive.css')}}" rel="stylesheet">
    <link href="{{asset('./responsive/service_responsive.css')}}" rel="stylesheet">




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
                <a href="/" class="nav-item nav-link active">Home</a>
                <a href="/about" class="nav-item nav-link ">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Search</a>
                    <div class="dropdown-menu m-0">
                        <a href="/opd" class="dropdown-item">OPD Details</a>
                        <a href="/doctor" class="dropdown-item">Doctor Details</a>
                        <a href="/pathology" class="dropdown-item">Pathology Details</a>
                        <!-- <a href="/coupons" class="dropdown-item">Coupon Details </a> -->
                    </div>
                </div>
                <a href="/blog" class="nav-item nav-link">Blogs</a>

                <a href="/contact" class="nav-item nav-link">Contact</a>
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
                <a href="" class="nav-item nav-link active">Home</a>
                <a href="/dw/about" class="nav-item nav-link ">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Search</a>
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




    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">


            <div class="carousel-inner">


                @foreach($homeBanners as $key => $banner)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img class="w-100" src="{{ asset('storage/' . $banner->banner_image) }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">{{ $banner->title }}</h5>
                            <h1 class="display-1 text-white mb-md-4 animated zoomIn">{{$banner->desc}}</h1>

                            @guest
                            <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank" class="btn btn-dark py-md-3 px-md-5 me-3 animated slideInLeft"><i class="fab fa-google-play me-2"></i>Download</a>
                            <a href="/contact" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Contact Us</a>
                            @endguest

                            @auth
                            <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank" class="btn btn-dark py-md-3 px-md-5 me-3 animated slideInLeft"><i class="fab fa-google-play me-2"></i>Download</a>
                            <a href="/dw/contact" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Contact Us</a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach


            </div>


            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->


    <div class="container search-banner-section">
        <div class="search-cards-row">

            {{-- Card 1: Search All --}}
            <div class="search-card search-card-all wow zoomIn" data-wow-delay="0.1s">
                <div class="search-card-header">
                    <div class="search-card-icon">
                        <i class="fa fa-magnifying-glass"></i>
                    </div>
                    <div>
                        <h3>Search For ALL</h3>
                        <p>Doctors, OPD & Pathology</p>
                    </div>
                </div>
                <div class="search-input-wrap">
                    <i class="fa fa-search"></i>
                    <input type="text" id="globalSearchInput" class="form-control"
                        placeholder="Search for Doctor / Path / OPD">
                </div>
                <button id="globalSearchButton" class="btn btn-search">
                    <span class="spinner"></span>
                    <span class="btn-text"><i class="fa fa-search"></i> Search Now</span>
                </button>
            </div>

            {{-- Card 2: Search OPD --}}
            <div class="search-card search-card-opd wow zoomIn" data-wow-delay="0.2s">
                <div class="search-card-header">
                    <div class="search-card-icon">
                        <i class="fa fa-hospital"></i>
                    </div>
                    <div>
                        <h3>Search For OPD</h3>
                        <p>Find by specialist type</p>
                    </div>
                </div>
                <div class="search-input-wrap">
                    <i class="fa fa-stethoscope"></i>
                    <select id="specialistDropdown" class="form-select">
                        <option selected>Select Specialist</option>
                        @foreach($specialists as $specialist)
                        <option style="text-transform: capitalize;" value="{{ $specialist }}">
                            {{ ucfirst($specialist) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button id="searchOpdButton" class="btn btn-search">
                    <span class="spinner"></span>
                    <span class="btn-text"><i class="fa fa-user-doctor"></i> Search OPD</span>
                </button>
            </div>

            {{-- Card 3: Search Pathology --}}
            <div class="search-card search-card-path wow zoomIn" data-wow-delay="0.3s">
                <div class="search-card-header">
                    <div class="search-card-icon">
                        <i class="fa fa-flask"></i>
                    </div>
                    <div>
                        <h3>Search For Pathology</h3>
                        <p>Find by test type</p>
                    </div>
                </div>
                <div class="search-input-wrap">
                    <i class="fa fa-syringe"></i>
                    <select id="pathologyDropdown" class="form-select">
                        <option selected>Select Type</option>
                        @foreach($types as $type)
                        <option style="text-transform: capitalize;" value="{{ $type }}">
                            {{ ucfirst($type) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button id="searchPathologyButton" class="btn btn-search">
                    <span class="spinner"></span>
                    <span class="btn-text"><i class="fa fa-syringe"></i> Search Pathology</span>
                </button>
            </div>

        </div>
    </div>

    {{-- Results --}}
    <div class="container results-section">
        <div id="opdPathBothResultsShowIFsearchOPDshowOPDIFSearchPathShowPath" class="row g-4">
        </div>
    </div>

    <div class="container results-section">
        <div id="globalResultsContainer" class="row g-4">
        </div>
    </div>



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




    <!-- OPD Cards Start -->
    <div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp opd-section" data-wow-delay="0.1s">
        <div class="container">

            <!-- Header + Buttons -->
            <div class="opd-controls">
                <div>
                    <div class="section-badge">Available OPD</div>
                    <h1>Take The Best Doctors For Best Treatments</h1>
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
                                            <span>{{ $opd->clinic_city }}, {{ $opd->clinic_pincode }}</span>
                                        </div>
                                        <div class="opd-meta-row">
                                            <i class="bi bi-signpost-2-fill"></i>
                                            <span>{{ $opd->clinic_landmark }}</span>
                                        </div>

                                        <div class="opd-card-footer-row">
                                            <span class="opd-view-link">
                                                View Details <i class="bi bi-arrow-right"></i>
                                            </span>
                                        </div>

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



    <!-- Pathology Cards Start -->
    <div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp p-3 path-section" data-wow-delay="0.1s">
        <div class="container">

            <!-- Header + Buttons -->
            <div class="path-controls">
                <div>
                    <div class="section-badge-path">Available Pathology</div>
                    <h1>Get Accurate Pathology Tests for Reliable Results</h1>
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
                                            <span>{{ $path->clinic_city }}, {{ $path->clinic_pincode }}</span>
                                        </div>
                                        <div class="path-meta-row">
                                            <i class="bi bi-signpost-2-fill"></i>
                                            <span>{{ $path->clinic_landmark }}</span>
                                        </div>
                                        <div class="path-card-footer-row">
                                            <span class="path-view-link">
                                                View Details <i class="bi bi-arrow-right"></i>
                                            </span>
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



    @guest
    <!-- Join As Partner Start -->
    <div class="container-fluid bg-offer my-4 py-4 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 wow zoomIn" data-wow-delay="0.6s">
                    <div class="offer-text text-center rounded p-5">
                        <h1 class="display-5 text-white off-texts">Partner with Doctorwala.info to expand your services nationwide</h1>
                        <div class="d-flex g-3 flex-wrap justify-content-center ">
                            <a href="/partner-register" class="btn btn-dark py-3 px-5 me-3 mb-2">Join As Partner</a>
                            <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank" class="btn btn-light py-3 px-5 mb-2"><i class="fab fa-google-play me-2" style="font-size: 1.2rem;"></i>User Download</a>
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
                            <a href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank" class="btn btn-light py-3 px-5 mb-2"><i class="fab fa-google-play me-2" style="font-size: 1.2rem;"></i>Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Join As Partner End -->
    @endauth



    <!-- Doctors Cards Start -->
    <div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp p-3 doc-section" data-wow-delay="0.1s">
        <div class="container">

            <!-- Header + Buttons -->
            <div class="doc-controls">
                <div>
                    <div class="section-badge-doc">Available Doctors</div>
                    <h1>Take The Best Doctors For Best Treatments</h1>
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

                                        <div class="doc-meta-row">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            <span>{{ $doc->partner_doctor_city }}, {{ $doc->partner_doctor_pincode }}</span>
                                        </div>
                                        <div class="doc-meta-row">
                                            <i class="bi bi-signpost-2-fill"></i>
                                            <span>{{ $doc->partner_doctor_landmark }}</span>
                                        </div>

                                        <div class="doc-card-footer-row">
                                            <span class="doc-view-link">
                                                View Details <i class="bi bi-arrow-right"></i>
                                            </span>
                                        </div>

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
                            href="https://play.google.com/store/apps/details?id=com.doctorwala.dochealth" target="_blank">DoctorWala.info</a>. All
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


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>




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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('./lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('./lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('./lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('./lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('./lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('./lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('./lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('./lib/twentytwenty/jquery.event.move.js')}}"></script>
    <script src="{{asset('./lib/twentytwenty/jquery.twentytwenty.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('./js/main.js')}}"></script>
    <script src="{{asset('./js/cards-scroll.js')}}"></script>

    <!-- Carousels -->
    <script src="{{asset('./js/opd-carousel-card.js')}}"></script>
    <script src="{{asset('./js/path-carousel-card.js')}}"></script>
    <script src="{{asset('./js/doc-carousel-card.js')}}"></script>

    <script src="{{asset('./js/global-search.js')}}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const specialistDropdown = document.querySelector('#specialistDropdown');
            const pathologyDropdown = document.querySelector('#pathologyDropdown');
            const searchOpdButton = document.querySelector('#searchOpdButton');
            const searchPathologyButton = document.querySelector('#searchPathologyButton');
            const resultsContainer = document.querySelector('#opdPathBothResultsShowIFsearchOPDshowOPDIFSearchPathShowPath');
            const globalContainer = document.querySelector('#globalResultsContainer');

            // OPD & Pathology cards (slug-based URL)
            const renderResults = (results, type) => {
                results.forEach(item => {
                    const imageUrl = item.banner && (type === 'OPD' ? item.banner.opdbanner : item.banner.pathologybanner) ?
                        `/storage/${type === 'OPD' ? item.banner.opdbanner : item.banner.pathologybanner}` :
                        'https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=';

                    const name = item.clinic_name;
                    const address = item.clinic_address;
                    const detailUrl = type === 'OPD' ?
                        `/opd/${item.slug}` // slug
                        :
                        `/pathology/${item.slug}`; // slug

                    resultsContainer.innerHTML += `
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            <img class="img-fluid rounded-top w-100" src="${imageUrl}" alt="" style="border: 1px solid #ddd;">
                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa-solid fa-location-dot"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-start rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">
                                <a href="${detailUrl}" style="text-decoration: none; text-transform: capitalize;" class="text-dark">${name}</a>
                            </h4>
                            <p class="text-primary mb-2">
                                <a href="${detailUrl}" style="text-decoration: none; text-transform: capitalize;" class="text-primary">${address}</a>
                            </p>
                            <a href="${detailUrl}" class="btn btn-primary p-2 w-100">OPEN NOW</a>
                        </div>
                    </div>
                </div>`;
                });
            };

            // Doctor cards (slug-based URL)
            const renderDoctorResults = (results, container) => {
                results.forEach(item => {
                    const imageUrl = item.banner && item.banner.doctorbanner ?
                        `/storage/${item.banner.doctorbanner}` :
                        'https://media.istockphoto.com/id/1222357475/vector/image-preview-icon-picture-placeholder-for-website-or-ui-ux-design-vector-illustration.jpg?s=612x612&w=0&k=20&c=KuCo-dRBYV7nz2gbk4J9w1WtTAgpTdznHu55W9FjimE=';

                    const name = item.partner_doctor_name;
                    const address = item.partner_doctor_address;
                    const detailUrl = `/doctor/${item.slug}`; // slug

                    container.innerHTML += `
                <div class="col-lg-4 wow slideInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="position-relative rounded-top" style="z-index: 1;">
                            <img class="img-fluid rounded-top w-100" src="${imageUrl}" alt="" style="border: 1px solid #ddd;">
                            <div class="position-absolute top-100 start-50 translate-middle bg-light rounded p-2 d-flex">
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fa-solid fa-location-dot"></i></a>
                                <a class="btn btn-primary btn-square m-1" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                            </div>
                        </div>
                        <div class="team-text position-relative bg-light text-start rounded-bottom p-4 pt-5">
                            <h4 class="mb-2">
                                <a href="${detailUrl}" style="text-decoration: none; text-transform: capitalize;" class="text-dark">${name}</a>
                            </h4>
                            <p class="text-primary mb-2">
                                <a href="${detailUrl}" style="text-decoration: none; text-transform: capitalize;" class="text-primary">${address}</a>
                            </p>
                            <a href="${detailUrl}" class="btn btn-primary p-2 w-100">OPEN NOW</a>
                        </div>
                    </div>
                </div>`;
                });
            };

            // Search OPD by specialist
            searchOpdButton.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedSpecialist = specialistDropdown.value;

                if (selectedSpecialist && selectedSpecialist !== 'Select Specialist') {
                    fetch(`{{ route('opd.search.doctor.specialist') }}?search=${encodeURIComponent(selectedSpecialist)}`)
                        .then(res => res.json())
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            if (data.opd_results.length > 0) {
                                renderResults(data.opd_results, 'OPD');
                            } else {
                                resultsContainer.innerHTML = '<p>No OPD results found for the selected specialist.</p>';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    alert('Please select a valid specialist.');
                }
            });

            // Search Pathology by test type
            searchPathologyButton.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedType = pathologyDropdown.value;

                if (selectedType && selectedType !== 'Select Type') {
                    fetch(`{{ route('opd.search.doctor.specialist') }}?search=${encodeURIComponent(selectedType)}`)
                        .then(res => res.json())
                        .then(data => {
                            resultsContainer.innerHTML = '';
                            if (data.pathology_results.length > 0) {
                                renderResults(data.pathology_results, 'Pathology');
                            } else {
                                resultsContainer.innerHTML = '<p>No Pathology results found for the selected type.</p>';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    alert('Please select a valid type.');
                }
            });

            // Global search (if you have a global search input)
            const globalSearchInput = document.querySelector('#globalSearchInput');
            const globalSearchButton = document.querySelector('#globalSearchButton');

            if (globalSearchButton) {
                globalSearchButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const searchTerm = globalSearchInput.value.trim();

                    if (searchTerm) {
                        fetch(`{{ route('global.search') }}?search=${encodeURIComponent(searchTerm)}`)
                            .then(res => res.json())
                            .then(data => {
                                globalContainer.innerHTML = '';

                                const allOPD = [...data.opd_results, ...data.opd_results_by_ids];
                                const allPath = [...data.pathology_results, ...data.pathology_results_by_ids];

                                // Deduplicate by id
                                const uniqueOPD = allOPD.filter((v, i, a) => a.findIndex(t => t.id === v.id) === i);
                                const uniquePath = allPath.filter((v, i, a) => a.findIndex(t => t.id === v.id) === i);

                                if (uniqueOPD.length) renderResults(uniqueOPD, 'OPD'); // slug
                                if (uniquePath.length) renderResults(uniquePath, 'Pathology'); // slug
                                if (data.doctor_results.length) renderDoctorResults(data.doctor_results, globalContainer); // slug

                                if (!uniqueOPD.length && !uniquePath.length && !data.doctor_results.length) {
                                    globalContainer.innerHTML = '<p>No results found.</p>';
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    } else {
                        alert('Please enter a search term.');
                    }
                });
            }
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


        // ── Loading state helper ──
        document.querySelectorAll('.btn-search').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.classList.add('loading');
                setTimeout(() => btn.classList.remove('loading'), 1500);
            });
        });

        // ── Better no-results messages ──
        const showNoResults = (container, msg) => {
            container.innerHTML = `
        <div class="no-results-msg">
            <i class="fa fa-circle-exclamation" style="color: green"></i>
            ${msg}
        </div>`;
        };
    </script>

</body>

</html>