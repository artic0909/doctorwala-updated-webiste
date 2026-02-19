<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Partner Login | Doctorwala</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


    <!-- SEO Meta Tags for Clinic/Partner login page -->
    <meta name="description" content="Partner Login Page for Doctorwala">
    <meta name="keywords" content="Partner Login, Doctorwala, Login">
    <meta name="author" content="Doctorwala">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="yandex-verification" content="yandex-verification-code">
    <meta name="copyright" content="Doctorwala">
    <meta name="distribution" content="Global">

    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

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
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="../lib/twentytwenty/twentytwenty.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/cards-css.css" rel="stylesheet">
    <link href="../css/partner-btn.css" rel="stylesheet">
    <link href="../responsive/index_responsive.css" rel="stylesheet">
    <link href="../responsive/partner_responsive.css" rel="stylesheet">



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
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Search</a>
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












    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 hero-header mb-5">
        <div class="row py-3">
            <div class="col-12 text-center">
                <h1 class="display-3 text-white animated zoomIn">Partner Login</h1>
                <a href="/" class="h4 text-white" style="text-decoration: underline;">Home</a>
                <i class="fa fa-plus text-dark px-2" style="font-size: 2rem; font-weight: 700;"></i>
                <a href="" class="h4 text-white">Login</a>
            </div>
        </div>
    </div>
    <!-- Hero End -->
















    <!-- Partner Login Start -->
    <div class="container-fluid bg-primary bg-appointment mb-5 wow fadeInUp" data-wow-delay="0.1s"
        style="margin-top: 90px;">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-6 py-5">
                    <div class="py-5">
                        <h1 class="display-5 text-white mb-4">Why Clinics Partner with DoctorWala.info</h1>
                        <p class="text-white mb-0">Clinics join DoctorWala.info to expand their digital presence, reach more local patients, and simplify their service promotion. By partnering with us, they get a dedicated profile, can showcase their doctors, OPD schedules, pathology services, and receive direct inquiries from patients. It’s a powerful way to grow trust, visibility, and patient engagement — all in one platform.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn"
                        data-wow-delay="0.6s">
                        <h1 class="text-white mb-4">Partner Login</h1>
                        <form action="{{route('partnerpanel.partner-login')}}" method="POST">
                            @csrf
                            <div class="row g-3">



                                <div class="col-12">
                                    <input type="email" class="form-control bg-light border-0"
                                        placeholder="Enter Registered Email *" style="height: 55px;" name="partner_email"
                                        id="partner_email" required value="{{ old('partner_email') }}">
                                </div>




                                <div class="col-12">
                                    <input type="password" class="form-control bg-light border-0"
                                        placeholder="Enter Password *" style="height: 55px;" name="partner_password"
                                        id="partner_password" required value="{{ old('partner_password') }}">
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="cap-back" style="background: url('../img/captcha.jpg'); background-repeat: no-repeat; background-position: center; background-size: cover; border-radius: 2px;" data-captcha="{{ $captcha }}">
                                        <canvas id="captchaCanvas" width="150" height="49" style="cursor: pointer;"></canvas>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control bg-light border-0"
                                        placeholder="Enter Captcha *" style="height: 55px;" name="captcha" id="captcha" required>
                                    @error('captcha')
                                    <small class="text-white">{{ $message }}</small>
                                    @enderror
                                </div>




                                <div class="col-12">
                                    <button class="btn btn-dark w-100 py-3" type="submit">LOGIN</button>
                                </div>




                                <p style="margin-bottom: 0; padding-bottom: 0;">
                                    <a href="#" class="text-white fw-bold" style="text-decoration: none;">Create New
                                        account ?</a>
                                    <span><a href="/partner-register" class="text-white "
                                            style="text-decoration: underline;">Sign Up</a></span>
                                </p>

                                <p>
                                    <a href="#" class="text-white fw-bold" style="text-decoration: none;">Forget
                                        Password ?</a>
                                    <span><a href="/partner-otp" class="text-white "
                                            style="text-decoration: underline;">Login with OTP</a></span>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Partner Login End -->










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
                    <a href="/partner-register" class="btn btn-dark btn-lg rounded me-2">Register As Partner</a>
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
    <a href="/partner-register" class="btn btn-lg btn-dark2 btn-lg-square rounded partner-login">
        <i class="fa fa-plus" aria-hidden="true"></i>
        <span class="showing-text"> Partner Register</span>
    </a>




















    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../lib/twentytwenty/jquery.event.move.js"></script>
    <script src="../lib/twentytwenty/jquery.twentytwenty.js"></script>
    <script src="../js/main.js"></script>


    <script>
        // Render captcha on canvas
        const captcha = @json($captcha); // Pass captcha value from controller
        const canvas = document.getElementById('captchaCanvas');
        const ctx = canvas.getContext('2d');
        ctx.font = '23px Arial';
        ctx.fillText(captcha, 10, 35);

        // Reload captcha on click
        canvas.addEventListener('click', () => location.reload());
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