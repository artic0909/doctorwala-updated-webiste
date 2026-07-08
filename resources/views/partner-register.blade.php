@extends('frontend.layout.app')

@section('title', 'Create | To Display Your Clinic & Labs & Doctors Profile' . ' - DoctorWala.info')

@section('content')

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register as a partner on Doctorwala and access our healthcare network.">
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

<!-- Partner Register Start -->
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
                        <iframe src="https://www.youtube.com/embed/rtWdQz1Kmjk?si=lUWDuibF2wXeHp8s&autoplay=0&mute=0" 
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
                    <h1 class="text-white mb-4">Partner Registration</h1>
                    <form id="partnerRegisterForm" action="{{route('partnerRegForm')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">



                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control bg-light border-0"
                                    placeholder="Clinic Name *" style="height: 55px;" name="partner_clinic_name"
                                    id="partner_clinic_name" required value="{{old('partner_clinic_name')}}">
                            </div>



                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control bg-light border-0"
                                    placeholder="Contact Person *" style="height: 55px;" name="partner_contact_person_name"
                                    id="partner_contact_person_name" required value="{{old('partner_contact_person_name')}}">
                            </div>



                            <div class="col-12 col-sm-6">
                                <input type="number" class="form-control bg-light border-0"
                                    placeholder="Mobile Number *" style="height: 55px;" name="partner_mobile_number"
                                    id="partner_mobile_number" required value="{{old('partner_mobile_number')}}">
                            </div>




                            <div class="col-12 col-sm-6">
                                <input type="email" class="form-control bg-light border-0" placeholder="Email ID *"
                                    style="height: 55px;" name="partner_email" id="partner_email" required value="{{old('partner_email')}}">
                            </div>


                            <div class="col-12 col-sm-6">
                                <select class="form-select bg-light border-0" style="height: 55px;" name="partner_state"
                                    id="partner_state" required>
                                    <option value="">Select State</option>
                                    <option value="Andaman and Nicobar Islands" {{ old('partner_state') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                    <option value="Andhra Pradesh" {{ old('partner_state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                    <option value="Arunachal Pradesh" {{ old('partner_state') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                    <option value="Assam" {{ old('partner_state') == 'Assam' ? 'selected' : '' }}>Assam</option>
                                    <option value="Bihar" {{ old('partner_state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                    <option value="Chandigarh" {{ old('partner_state') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                    <option value="Chhattisgarh" {{ old('partner_state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                    <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('partner_state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                    <option value="Delhi" {{ old('partner_state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                    <option value="Goa" {{ old('partner_state') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                    <option value="Gujarat" {{ old('partner_state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                    <option value="Haryana" {{ old('partner_state') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                    <option value="Himachal Pradesh" {{ old('partner_state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                    <option value="Jammu and Kashmir" {{ old('partner_state') == 'Jammu and Kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
                                    <option value="Jharkhand" {{ old('partner_state') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                    <option value="Karnataka" {{ old('partner_state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                    <option value="Kerala" {{ old('partner_state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                    <option value="Ladakh" {{ old('partner_state') == 'Ladakh' ? 'selected' : '' }}>Ladakh</option>
                                    <option value="Lakshadweep" {{ old('partner_state') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                    <option value="Madhya Pradesh" {{ old('partner_state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                    <option value="Maharashtra" {{ old('partner_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                    <option value="Manipur" {{ old('partner_state') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                    <option value="Meghalaya" {{ old('partner_state') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                    <option value="Mizoram" {{ old('partner_state') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                    <option value="Nagaland" {{ old('partner_state') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                    <option value="Odisha" {{ old('partner_state') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                    <option value="Puducherry" {{ old('partner_state') == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                                    <option value="Punjab" {{ old('partner_state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                    <option value="Rajasthan" {{ old('partner_state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                    <option value="Sikkim" {{ old('partner_state') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                    <option value="Tamil Nadu" {{ old('partner_state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                    <option value="Telangana" {{ old('partner_state') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                    <option value="Tripura" {{ old('partner_state') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                    <option value="Uttar Pradesh" {{ old('partner_state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                    <option value="Uttarakhand" {{ old('partner_state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                    <option value="West Bengal" {{ old('partner_state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                </select>
                            </div>


                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control bg-light border-0" placeholder="City *" style="height: 55px;" name="partner_city" id="partner_city" required value="{{ old('partner_city') }}">
                            </div>


                            <div class="col-12 col-sm-6">
                                <input type="number" class="form-control bg-light border-0" placeholder="Pin Code *"
                                    style="height: 55px;" name="partner_pincode" id="partner_pincode" required value="{{ old('partner_pincode') }}">
                            </div>


                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control bg-light border-0" placeholder="Landmark *"
                                    style="height: 55px;" name="partner_landmark" id="partner_landmark" required value="{{ old('partner_landmark') }}">
                            </div>





                            <div class="col-12">
                                <textarea name="partner_address" class="form-control bg-light border-0" rows="5"
                                    id="partner_address" placeholder="Full Address *" required>{{ old('partner_address') }}</textarea>
                            </div>







                            <div class="col-12">
                                <div class="input-group">
                                    <input type="password" class="form-control bg-light border-0"
                                        placeholder="Password *" style="height: 55px;" name="partner_password"
                                        id="partner_password" required value="{{ old('partner_password') ?: '12345678' }}">
                                    <span class="input-group-text bg-light border-0" id="togglePassword" style="cursor: pointer;">
                                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>











                            <!-- 
                                <div class="col-12">
                                    <p class="text-white fw-bold" style="text-align: left;">Registration Type <span
                                            class="text-dark">*</span></p>

                                    <div class="form-check form-check-inline"
                                        style="display: flex;  justify-content: space-between; align-items: center;">

                                        <p>
                                            <label for="opd" class="form-check-label text-white"
                                                style="font-size: 1.3rem; font-weight: 700;">OPD&nbsp;</label>
                                            <input type="checkbox" name="registration_type[]" id="opd" value="OPD" style="transform: scale(1.5); cursor: pointer;">&nbsp;
                                        </p>

                                        <p>
                                            <label for="pathology" class="form-check-label text-white"
                                                style="font-size: 1.3rem; font-weight: 700;">Path&nbsp;</label>
                                            <input type="checkbox" name="registration_type[]" id="pathology" value="Pathology" style="transform: scale(1.5); cursor: pointer;">&nbsp;
                                        </p>

                                        <p>
                                            <label for="doctor" class="form-check-label text-white"
                                                style="font-size: 1.3rem; font-weight: 700;">Doctor&nbsp;</label>
                                            <input type="checkbox" name="registration_type[]" id="doctor" value="Doctor" style="transform: scale(1.5); cursor: pointer;">&nbsp;
                                        </p>

                                    </div>
                                </div> -->

                            <div class="col-12">
                                <p class="text-white fw-bold" style="text-align: left;">Registration Type <span
                                        class="text-dark">*</span></p>

                                <div class="form-check form-check-inline"
                                    style="display: flex;  justify-content: space-between; align-items: center;">

                                    <p>
                                        <label for="opd" class="form-check-label text-white"
                                            style="font-size: 1.3rem; font-weight: 700;">OPD&nbsp;</label>
                                        <input type="checkbox" name="registration_type[]" id="opd" value="OPD"
                                            style="transform: scale(1.5); cursor: pointer;"
                                            {{ is_array(old('registration_type')) && in_array('OPD', old('registration_type')) ? 'checked' : '' }}>&nbsp;
                                    </p>

                                    <p>
                                        <label for="pathology" class="form-check-label text-white"
                                            style="font-size: 1.3rem; font-weight: 700;">Path&nbsp;</label>
                                        <input type="checkbox" name="registration_type[]" id="pathology" value="Pathology"
                                            style="transform: scale(1.5); cursor: pointer;"
                                            {{ is_array(old('registration_type')) && in_array('Pathology', old('registration_type')) ? 'checked' : '' }}>&nbsp;
                                    </p>

                                    <p>
                                        <label for="doctor" class="form-check-label text-white"
                                            style="font-size: 1.3rem; font-weight: 700;">Doctor&nbsp;</label>
                                        <input type="checkbox" name="registration_type[]" id="doctor" value="Doctor"
                                            style="transform: scale(1.5); cursor: pointer;"
                                            {{ is_array(old('registration_type')) && in_array('Doctor', old('registration_type')) ? 'checked' : '' }}>&nbsp;
                                    </p>

                                </div>
                            </div>


                            <div class="col-12">
                                <button class="btn btn-dark w-100 py-3" type="submit">REGISTER</button>
                            </div>


                            <p>
                                <a href="#" class="text-white fw-bold" style="text-decoration: none;">Already have
                                    an account ?</a>
                                <span><a href="/partner-login" class="text-white "
                                        style="text-decoration: underline;">Login</a></span>
                            </p>
                        </div>
                    </form>
                </div>
            </div>


            
        </div>
    </div>
</div>
<!-- Partner Register End -->







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

<!-- jQuery Validate & SweetAlert -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Registration Type Logic
    $('#opd, #pathology').on('change', function() {
        if ($(this).is(':checked')) {
            $('#doctor').prop('checked', false);
        }
    });
    $('#doctor').on('change', function() {
        if ($(this).is(':checked')) {
            $('#opd, #pathology').prop('checked', false);
        }
    });

    // jQuery Validation
    $("#partnerRegisterForm").validate({
        rules: {
            partner_clinic_name: { required: true },
            partner_contact_person_name: { required: true },
            partner_mobile_number: { required: true, digits: true, minlength: 10, maxlength: 15 },
            partner_email: { required: true, email: true },
            partner_state: { required: true },
            partner_city: { required: true },
            partner_pincode: { required: true, digits: true, minlength: 6, maxlength: 6 },
            partner_landmark: { required: true },
            partner_address: { required: true },
            partner_password: { required: true, minlength: 6 },
            'registration_type[]': { required: true }
        },
        messages: {
            'registration_type[]': { required: "Please select at least one Registration Type" }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('text-danger fw-bold text-start d-block mt-1');
            if(element.attr("name") == "registration_type[]") {
                error.insertAfter(element.closest('.form-check-inline'));
            } else {
                element.closest('.col-12').append(error);
            }
        },
        highlight: function(element) { $(element).addClass('is-invalid'); },
        unhighlight: function(element) { $(element).removeClass('is-invalid'); },
        submitHandler: function(form) {
            var submitBtn = $(form).find('button[type="submit"]');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Thank You For Registering',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).text(originalText);
                    var errorMessage = 'Profile Is Not Registered. Please try again.';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if(xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).map(e => e.join('<br>')).join('<br>');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        html: errorMessage,
                    });
                }
            });
            return false;
        }
    });

    // SweetAlerts for Backend Errors & Success
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '{!! implode("<br>", $errors->all()) !!}',
        });
    @elseif (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{!! session("success") == "success" ? "Thank You For Registering" : addslashes(session("success")) !!}',
        }).then(() => {
            window.location.href = '/partner-login';
        });
    @elseif (session('unsuccess'))
        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: 'Profile Is Not Registered. Please try again.',
        });
    @endif
});
</script>

<!-- Force App Download Modal -->
<div class="modal fade" id="forcePartnerAppModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden relative">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10; background-color: rgba(255,255,255,0.8); border-radius: 50%; padding: 10px;"></button>
            <div class="modal-body p-0 text-center">
                <img src="{{ asset('img/partner-banner.png') }}" alt="Download Partner App" class="img-fluid w-100">
                <div class="p-4 bg-light">
                    <h3 class="mb-3">Download Doctorwala Partner App</h3>
                    <p class="text-muted mb-4">Your clinic, your pocket. Download the Doctorwala Partner App to creation, login, and manage everything — anytime, anywhere.</p>
                    <a href="https://play.google.com/store/apps/details?id=info.doctorwala.partner" target="_blank" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                        <i class="fab fa-google-play me-2"></i> Download Partner App
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


    // Show Force App Download Modal only once per session
    document.addEventListener("DOMContentLoaded", function() {
        if (!sessionStorage.getItem('partnerRegisterModalShown')) {
            var forceModal = new bootstrap.Modal(document.getElementById('forcePartnerAppModal'));
            forceModal.show();
            sessionStorage.setItem('partnerRegisterModalShown', 'true');
        }

        // Toggle password visibility
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#partner_password");
        const eyeIcon = document.querySelector("#eyeIcon");

        if(togglePassword && password) {
            togglePassword.addEventListener("click", function () {
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                
                if (type === "password") {
                    eyeIcon.classList.remove("fa-eye-slash");
                    eyeIcon.classList.add("fa-eye");
                } else {
                    eyeIcon.classList.remove("fa-eye");
                    eyeIcon.classList.add("fa-eye-slash");
                }
            });
        }
    });
</script>

@endsection