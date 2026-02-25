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
                    <h1 class="display-5 mb-0">{{$aboutDetail->ab_title}}</h1>
                </div>
                <h4 class="text-body fst-italic mb-4">{{$aboutDetail->ab_b_txt}}</h4>
                <p class="mb-4">{{$aboutDetail->ab_desc}}</p>


                <p><Strong class="text-danger">Our Mission:</Strong> {{$aboutDetail->ab_mission}}</p>

                <p><Strong class="text-danger">Our Vision:</Strong> {{$aboutDetail->ab_vision}}</p>




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
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row g-5 mb-5">
            <div class="col-lg-5 wow zoomIn" data-wow-delay="0.3s" style="min-height: 400px;">
                <div class="twentytwenty-container position-relative h-100 rounded overflow-hidden">
                    <img class="position-absolute w-100 h-100" src="{{asset('img/af.jpg')}}" style="object-fit: cover;">
                    <img class="position-absolute w-100 h-100" src="{{asset('img/be.jpg')}}" style="object-fit: cover;">
                </div>
            </div>



            <div class="col-lg-7">
                <div class="section-title mb-5">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Our Services</h5>
                    <h1 class="display-5 mb-0">We Offer The Best Doctors, OPD & Pathology Services</h1>
                </div>




                <div class="row g-5">
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.6s">
                        <div class="rounded-top overflow-hidden">
                            <img class="img-fluid" src="{{asset('img/himatology.jpg')}}" alt="">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">Hematology Tests</h5>
                        </div>
                    </div>
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.9s">
                        <div class="rounded-top overflow-hidden">
                            <img class="img-fluid" src="{{asset('img/biochemic.jpg')}}" alt="">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">Biochemistry Tests</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-7">
                <div class="row g-5">
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.3s">
                        <div class="rounded-top overflow-hidden">
                            <img class="img-fluid" src="{{asset('img/microbiology.jpg')}}" alt="">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">Microbiology Tests</h5>
                        </div>
                    </div>
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.6s">
                        <div class="rounded-top overflow-hidden">
                            <img class="img-fluid" src="{{asset('img/cytology.jpg')}}" alt="">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">Cytology and More...</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 service-item wow zoomIn" data-wow-delay="0.9s">
                <div class="position-relative rounded h-100 d-flex flex-column align-items-center justify-content-center text-center p-4">
                    <div class="textss" style="background-color: rgba(48, 46, 46, 0.26); padding: 5px;">
                        <h3 class="text-white mb-3">We Offer</h3>
                        <p class="text-white mb-3" style="font-weight: 700;">Our search engine features a wide range
                            of healthcare providers, in- cluding doctors from various specialties such as
                            cardiology, ortho- pedics, dermatology, gynecology, pediatrics, and more.</p>


                        @foreach($aboutDetails as $aboutDetail)
                        <h2 class="text-white mb-0"><a href="tel:{{$aboutDetail->number}}" class="text-white">+91-{{$aboutDetail->number}}</a></h2>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->
@endsection