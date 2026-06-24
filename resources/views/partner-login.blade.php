@extends('frontend.layout.app')

@section('title', 'Login | Display Your Clinic & Labs & Doctors Profile' . ' - DoctorWala.info')

@section('content')

<head>
    <!-- SEO Meta Tags for Clinic/Partner login page -->
    <meta name="description" content="Partner Login Page for Doctorwala">
    <meta name="keywords" content="Partner Login, Doctorwala, Login">
    <meta name="author" content="Doctorwala">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="yandex-verification" content="yandex-verification-code">
    <meta name="copyright" content="Doctorwala">
    <meta name="distribution" content="Global">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/cards-css.css" rel="stylesheet">
    <link href="../css/partner-btn.css" rel="stylesheet">
    <link href="../responsive/partner_responsive.css" rel="stylesheet">
</head>

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
                <div class="video-container mt-4 wow zoomIn" data-wow-delay="0.3s">
                    <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden border border-white border-2">
                        <iframe src="https://www.youtube.com/embed/rtWdQz1Kmjk?si=lUWDuibF2wXeHp8s&autoplay=1&mute=1" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin" 
                            allowfullscreen></iframe>
                    </div>
                    <div class="mt-3">
                        <a href="https://www.youtube.com/embed/rtWdQz1Kmjk?si=lUWDuibF2wXeHp8s" target="_blank" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold shadow-sm">
                            <i class="fab fa-youtube me-2"></i>Watch Full Video
                        </a>
                    </div>
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
<!-- <div class="container-fluid bg-primary bg-testimonial py-5 wow fadeInUp" data-wow-delay="0.1s">
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
</div> -->
<!-- Testimonial End -->


<!-- Force App Download Modal -->
<div class="modal fade" id="forcePartnerAppModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden relative">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10; background-color: rgba(255,255,255,0.8); border-radius: 50%; padding: 10px;"></button>
            <div class="modal-body p-0 text-center">
                <img src="{{ asset('img/logos/partner-banner.png') }}" alt="Download Partner App" class="img-fluid w-100">
                <div class="p-4 bg-light">
                    <h3 class="mb-3">Please Download Our Partner App</h3>
                    <p class="text-muted mb-4">For the best experience, login and manage your clinic through our Doctorwala Partner App.</p>
                    <a href="https://play.google.com/store/apps/details?id=info.doctorwala.partner" target="_blank" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                        <i class="fab fa-google-play me-2"></i> Download Partner App
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Render captcha on canvas
    const captcha = @json($captcha); // Pass captcha value from controller
    const canvas = document.getElementById('captchaCanvas');
    const ctx = canvas.getContext('2d');
    ctx.font = '23px Arial';
    ctx.fillText(captcha, 10, 35);

    // Reload captcha on click
    canvas.addEventListener('click', () => location.reload());

    // Show Force App Download Modal only once per session
    document.addEventListener("DOMContentLoaded", function() {
        if (!sessionStorage.getItem('partnerLoginModalShown')) {
            var forceModal = new bootstrap.Modal(document.getElementById('forcePartnerAppModal'));
            forceModal.show();
            sessionStorage.setItem('partnerLoginModalShown', 'true');
        }
    });
</script>

@endsection