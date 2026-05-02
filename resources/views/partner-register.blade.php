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
                        <iframe src="https://www.youtube.com/embed/Ttfr1gwk6BQ?si=N18uMtv42zTac9zb&autoplay=1&mute=1" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin" 
                            allowfullscreen></iframe>
                    </div>
                    <div class="mt-3">
                        <a href="https://www.youtube.com/watch?v=Ttfr1gwk6BQ&t=7s" target="_blank" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold shadow-sm">
                            <i class="fab fa-youtube me-2"></i>Watch Full Video
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn"
                    data-wow-delay="0.6s">
                    <h1 class="text-white mb-4">Partner Registration</h1>
                    <form action="{{route('partnerRegForm')}}" method="POST" enctype="multipart/form-data">
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
                                <input type="password" class="form-control bg-light border-0"
                                    placeholder="Password *" style="height: 55px;" name="partner_password"
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



<!-- profile registration success modal start -->
<div class="modal fade" id="profileRegistrationSuccessModal" tabindex="-1" aria-labelledby="profileRegistrationSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h2 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> SUCCESS <span class="text-primary">+</span></h2>
                <h2 class="text-primary">Thank You For Register</h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- profile registration success modal end -->

<!-- profile registration Unsuccess modal start -->
<div class="modal fade" id="profileRegistrationUnsuccessModal" tabindex="-1" aria-labelledby="profileRegistrationUnsuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-middle justify-center align-items-center">
                <h3 class="modal-title" id="profileUpdateSuccessModalLabel"><span class="text-primary">+</span> ERROR <span class="text-primary">+</span></h3>
                <h4 class="text-danger">Profile Is Not Registered</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn p-2 btn-primary w-100" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<!-- profile registration Unsuccess modal end -->







@if(session('success') == 'success')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successModal = new bootstrap.Modal(document.getElementById('profileRegistrationSuccessModal'));
        successModal.show();
    });
</script>
@elseif(session('unsuccess') == 'unsuccess')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const failureModal = new bootstrap.Modal(document.getElementById('profileRegistrationSuccessModal'));
        failureModal.show();
    });
</script>
@endif



<div id="alertPlaceholder"></div>



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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Form validation
        const form = document.querySelector("form");
        const passwordField = document.getElementById("partner_password");
        const confirmPasswordField = document.querySelector("input[placeholder='Confirm Password *']");
        const opdCheckbox = document.getElementById("opd");
        const pathologyCheckbox = document.getElementById("pathology");
        const doctorCheckbox = document.getElementById("doctor");

        // Validate form before submission
        form.addEventListener("submit", function(e) {
            let valid = true;

            // Check password and confirm password
            if (passwordField.value !== confirmPasswordField.value) {
                alert("Passwords do not match!");
                valid = false;
            }

            // If not valid, prevent form submission
            if (!valid) {
                e.preventDefault();
            }
        });

        // Handle registration type logic
        opdCheckbox.addEventListener("change", function() {
            if (this.checked) {
                doctorCheckbox.checked = false;
            }
        });

        pathologyCheckbox.addEventListener("change", function() {
            if (this.checked) {
                doctorCheckbox.checked = false;
            }
        });

        doctorCheckbox.addEventListener("change", function() {
            if (this.checked) {
                opdCheckbox.checked = false;
                pathologyCheckbox.checked = false;
            }
        });
    });
</script>

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

@endsection