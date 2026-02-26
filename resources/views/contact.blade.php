@extends('frontend.layout.app')

@section('title', 'Contact Us - Doctorwala.info')

@section('content')

<head>
    @foreach($aboutDetails as $aboutDetail)
    <meta name="description" content="{{ $aboutDetail->ab_b_txt }}">
    <meta name="keywords" content="about us, doctorwala.info, doctorwala, doctorwala.in, doctorwala.com, doctorwala.com.in, doctorwala.com.info, doctorwala.in.info, doctorwala.info.in, doctorwala.info.com, doctorwala.info.com.in, doctorwala.info.in.com, doctorwala.info.com.in.info, doctorwala.info.in.com.info, ranihati, howrah, 711302, panchla, statebank, medical, opd, pathology, doctors, partners, users, get in touch, contact us, inquiry, query, enquary, feedback, feedback form">
    <meta property="og:title" content="About Doctorwala">
    <meta property="og:description" content="{{ $aboutDetail->ab_desc }}">
    <meta property="og:url" content="{{ url('/about') }}">
    <meta name="twitter:title" content="About Doctorwala">
    <meta name="twitter:description" content="{{ $aboutDetail->ab_desc }}">
    <meta name="twitter:email" content="{{ $aboutDetail->email }}">
    <meta name="twitter:phone" content="{{ $aboutDetail->number }}">
    @endforeach
</head>





<!-- Hero Start -->
<div class="container-fluid bg-primary py-5 hero-header mb-5">
    <div class="row py-3">
        <div class="col-12 text-center">
            <h1 class="display-3 text-white animated zoomIn">Contact Us</h1>

            <a href="#" class="h4 text-white" style="text-decoration: underline;">Submit a Ticket | FAQ | Help Center</a>

            <i class="fa fa-plus text-dark px-2" style="font-size: 2rem; font-weight: 700;"></i>
            <a href="" class="h4 text-white">Send Us A Message</a>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-xl-4 col-lg-6 wow slideInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="section-title">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">Contact Us</h5>
                        <h1 class="display-6 mb-4">Feel Free To Contact Us</h1>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-geo-alt fs-1 text-primary me-3"></i>
                        <div class="text-start">
                            <h5 class="mb-0">Our Office</h5>
                            <span><a href="https://maps.app.goo.gl/jctrujK2YmutCgiD6" style="color: gray;">Ranihati, Amta Road, Panchla, Howrah-711302</a></span>
                        </div>
                    </div>
                    @foreach($aboutDetails as $aboutDetail)
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-envelope-open fs-1 text-primary me-3"></i>
                        <div class="text-start">
                            <h5 class="mb-0">Email Us</h5>
                            <span><a href="mailto:{{$aboutDetail->email}}" style="color: gray;">{{$aboutDetail->email}}</a></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-phone-vibrate fs-1 text-primary me-3"></i>
                        <div class="text-start">
                            <h5 class="mb-0">Call Us</h5>
                            <span><a href="tel:{{$aboutDetail->number}}" style="color: gray;">{{$aboutDetail->number}}</a></span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 wow slideInUp" data-wow-delay="0.3s">
                @guest
                <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <input type="text" class="form-control border-0 bg-light px-4" placeholder="Your Name"
                                style="height: 55px;" name="name" id="name">
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control border-0 bg-light px-4" placeholder="Your Email"
                                style="height: 55px;" name="email" id="email">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control border-0 bg-light px-4" placeholder="Subject"
                                style="height: 55px;" name="subject" id="subject">
                        </div>
                        <div class="col-12">
                            <textarea class="form-control border-0 bg-light px-4 py-3" rows="6"
                                placeholder="Message" name="message" id="message"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                        </div>
                    </div>
                </form>
                @endguest

                @auth
                <form action="{{ route('restricted-contact.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <input type="text" class="form-control border-0 bg-light px-4" placeholder="Your Name"
                                style="height: 55px;" name="name" id="name">
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control border-0 bg-light px-4" placeholder="Your Email"
                                style="height: 55px;" name="email" id="email">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control border-0 bg-light px-4" placeholder="Subject"
                                style="height: 55px;" name="subject" id="subject">
                        </div>
                        <div class="col-12">
                            <textarea class="form-control border-0 bg-light px-4 py-3" rows="6"
                                placeholder="Message" name="message" id="message"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                        </div>
                    </div>
                </form>
                @endauth

            </div>
            <div class="col-xl-4 col-lg-12 wow slideInUp" data-wow-delay="0.6s">

                <iframe class="position-relative rounded w-100 h-100"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4571.920519621659!2d88.15360417530022!3d22.564069079497806!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a028142cd118f05%3A0x573fefde2b8f0953!2sRANIHATI%20CONSTRUCTION%20PVT.%20LTD.!5e1!3m2!1sen!2sin!4v1732015654255!5m2!1sen!2sin"
                    frameborder="0" style="min-height: 400px; border:0;" allowfullscreen="" aria-hidden="false"
                    tabindex="0"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<!-- success modal start -->
<div class="modal fade" id="contactFormSubmitSuccessModal" tabindex="-1" aria-labelledby="contactFormSubmitSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h3>
                <h4 class="text-primary">Your Message Sent Successfully</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- success modal end -->

<!-- Unsuccess modal start -->
<div class="modal fade" id="contactFormSubmitUnsuccessModal" tabindex="-1" aria-labelledby="contactFormSubmitUnsuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                <h4 class="text-danger">Your Message Sent Unsuccessfully !!</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- Unsuccess modal end -->




<!-- Include this script block below your modals -->
@if(session('success'))
<script>
    // Automatically trigger the success modal
    const successModal = new bootstrap.Modal(document.getElementById('contactFormSubmitSuccessModal'));
    successModal.show();
</script>
@endif

@if(session('error'))
<script>
    // Automatically trigger the error modal
    const errorModal = new bootstrap.Modal(document.getElementById('contactFormSubmitUnsuccessModal'));
    errorModal.show();
</script>
@endif


@if(session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalId = "{{ session('success') ? 'contactFormSubmitSuccessModal' : 'contactFormSubmitUnsuccessModal' }}";
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    });
</script>
@endif


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('gsOpenBtn').click();
    });
</script>


@endsection