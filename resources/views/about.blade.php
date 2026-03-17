@extends('frontend.layout.app')

@section('title', 'About Doctorwala - Your Trusted Healthcare Companion | Doctorwala.info')

@section('content')

<head>
    @foreach($aboutDetails as $aboutDetail)
    <meta name="description" content="{{ $aboutDetail->ab_b_txt }}">
    <meta name="keywords" content="about us, doctorwala, mission, healthcare options, doctorwala.info, doctorwala.in, doctorwala.com, doctorwala">
    <meta property="og:title" content="About Doctorwala">
    <meta property="og:description" content="{{ $aboutDetail->ab_desc }}">
    <meta property="og:url" content="{{ url('/about') }}">
    <meta name="twitter:title" content="About Doctorwala">
    <meta name="twitter:description" content="{{ $aboutDetail->ab_desc }}">
    <meta name="twitter:email" content="{{ $aboutDetail->email }}">
    <meta name="twitter:phone" content="{{ $aboutDetail->number }}">
    @endforeach
</head>


<!-- About Start -->
@foreach($aboutDetails as $aboutDetail)
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="section-title mb-4">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Jio Ji Bharka</h5>
                    <h1 class="display-5 mb-0">Doctorwala – Medical Ecosystem</h1>
                </div>
                <h4 class="text-body fst-italic mb-4">When someone in your family needs a doctor, every second feels important. Searching, calling, waiting — it shouldn’t be this hard.</h4>
                <p class="mb-4">Doctorwala connects you to nearby doctors, clinics, OPDs, and medical shops across India — from busy cities to the smallest villages. With just a few clicks, patients can find the right doctor and connect instantly.</p>
                <p class="mb-4">We also provide a secure Personal Medical ID, so your medical history stays organized and accessible whenever you need it. Because better records mean better diagnosis. And better diagnosis means better care.</p>


                <p><Strong class="text-danger">Our Mission:</Strong> Our mission is simple — to make healthcare reachable, reliable, and timely for everyone.</p>

                <p><Strong class="text-danger">We are not just building a platform.</Strong></p>
                <p><Strong class="text-danger">We are building a healthier future.</Strong></p>
                <p><Strong class="text-danger">Doctorwala — Your Health. Your Records. Your Lifeline.</Strong></p>




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

                <a href="/contact" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn"
                    data-wow-delay="0.6s">Contact Us</a>

                <a href="/privacy-policy" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn"
                    data-wow-delay="0.6s">Privacy Policy</a>
                @endguest

                @auth
                <a href="/dw/contact" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn"
                    data-wow-delay="0.6s">Contact Us</a>

                <a href="/dw/blog" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn"
                    data-wow-delay="0.6s">Blogs</a>

                <a href="/dw/privacy-policy" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn"
                    data-wow-delay="0.6s">Privacy Policy</a>
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
@endsection