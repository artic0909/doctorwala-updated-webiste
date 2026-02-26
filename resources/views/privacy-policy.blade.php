@extends('frontend.layout.app')

@section('title', 'Privacy & Policies | Doctorwala.info')

@section('content')

<head>
    <meta content="privacy, policies, doctorwala, doctorwala.info, Information We Collect, Use of Information,Data Security,Links to Third-Party Websites,Children's Privacy,Changes to this Privacy Policy,Contact Us, Personal Information,Usage Data,Provide Services,Communication,Analytics and Improvements" name="keywords">
    <meta content="We may collect personal information such as your name, email address, contact number, and other relevant information when you voluntarily provide it to us through forms or by contacting us, We may collect non-personal information about your interaction with our Website, such as your IP address, browser type, referring/exit pages, and the date and time of your visit. We may use cookies and similar technologies to collect this information, We may use the personal information you provide to us to provide and improve our services, such as facilitating appointments with doctors, displaying relevant search results, and delivering personalized content, We may use your contact information to communicate with you regarding your inquiries, appointments, service updates, and promotional offers. You may opt out of receiving promotional communications at any time, We may use the non-personal information and usage data to analyze trends, administer the Website, and improve our services, features, and user experience, We take reasonable precautions to protect the personal information we collect from unauthorized access, use, disclosure, or alteration. However, no method of transmission over the internet or electronic storage is completely secure. Therefore, we cannot guarantee absolute security of your personal information, Our Website may contain links to third-party websites or services. This Privacy Policy does not apply to those third-party websites. We recommend reviewing the privacy policies of those websites for information about their data collection, use, and disclosure practices, Our Website is not intended for children under the age of 13. We do not knowingly collect personal information from children under the age of 13. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us, and we will promptly remove the information, We reserve the right to update or modify this Privacy Policy at any time. Any changes will be effective immediately upon posting the updated Privacy Policy on our Website. We encourage you to review this Privacy Policy periodically, If you have any questions, concerns, or requests regarding this Privacy Policy or our privacy practices, please contact us at info.doctorwala@gmail.com" name="description">
</head>



<!-- Hero Start -->
<div class="container-fluid bg-primary py-5 hero-header mb-5">
    <div class="row py-3">
        <div class="col-12 text-center">
            <h1 class="display-3 text-white animated zoomIn">Our Privacy Policy</h1>
            @guest
            <a href="/" class="h4 text-white" style="text-decoration: underline;">Home</a>
            @endguest

            @auth
            <a href="/dw" class="h4 text-white" style="text-decoration: underline;">Home</a>
            @endauth
            <i class="fa fa-plus text-dark px-2" style="font-size: 2rem; font-weight: 700;"></i>
            <a href="" class="h4 text-white">Policies</a>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- Privacy Policy Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 wow slideInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded h-100 p-5">
                    <div class="section-title">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">Privacy Policy</h5>
                        <h1 class="display-6 mb-4">Welcome to our site</h1>
                    </div>

                    <div class="d-flex align-items-center mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start bg-white p-3" style="color: #051225; font-style: italic;">
                            <p class="mb-0 fw-bold fs-5"><i class="fa-solid fa-quote-left"></i>&nbsp;This
                                Privacy Policy explains how Sumatra Sales Private Limited ("we" or "us")
                                collects, uses, and protects the personal information of users ("you" or "users") on
                                our website www.doctorwala.info (the "Website"). By using our Website, you consent
                                to the collection, use, and disclosure of your personal information as described in
                                this Privacy Policy.&nbsp;<i class="fa-solid fa-quote-right"></i></p>
                        </div>
                    </div>


                    <div class="d-flex align-items-center mb-2 wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start">
                            <h5 class="mb-0">Information We Collect</h5>
                            <span>1.1 Personal Information: We may collect personal information such as your name,
                                email address, contact number, and other relevant information when you voluntarily
                                provide it to us through forms or by contacting us.</span> <br> <br>

                            <p>1.2 Usage Data: We may collect non-personal information about your interaction with
                                our Website, such as your IP address, browser type, referring/exit pages, and the
                                date and time of your visit. We may use cookies and similar technologies to collect
                                this information.</p>
                        </div>
                    </div>




                    <div class="d-flex align-items-center wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start">
                            <h5 class="mb-0">Use of Information</h5>
                            <span>2.1 Provide Services: We may use the personal information you provide to us to
                                provide and improve our services, such as facilitating appointments with doctors,
                                displaying relevant search results, and delivering personalized content.</span>
                            <br>
                            <br>
                            <p>2.2 Communication: We may use your contact information to communicate with you
                                regarding your inquiries, appointments, service updates, and promotional offers. You
                                may opt out of receiving promotional communications at any time.</p>

                            <p>2.3 Analytics and Improvements: We may use the non-personal information and usage
                                data to analyze trends, administer the Website, and improve our services, features,
                                and user experience.</p>
                        </div>
                    </div>



                    <div class="d-flex align-items-center mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start">
                            <h5 class="mb-0">Data Security</h5>

                            <span>
                                We take reasonable precautions to protect the personal information we collect from
                                unauthorized access, use, disclosure, or alteration. However, no method of
                                transmission over the internet or electronic storage is completely secure.
                                Therefore, we cannot guarantee absolute security of your personal information.
                            </span>
                        </div>
                    </div>




                    <div class="d-flex align-items-center mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start">
                            <h5 class="mb-0">Links to Third-Party Websites</h5>

                            <span>
                                Our Website may contain links to third-party websites or services. This Privacy
                                Policy does not apply to those third-party websites. We recommend reviewing the
                                privacy policies of those websites for information about their data collection, use,
                                and disclosure practices.
                            </span>
                        </div>
                    </div>





                    <div class="d-flex align-items-center mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start">
                            <h5 class="mb-0">Children's Privacy</h5>

                            <span>
                                Our Website is not intended for children under the age of 13. We do not knowingly
                                collect personal information from children under the age of 13. If you are a parent
                                or guardian and believe that your child has provided us with personal information,
                                please contact us, and we will promptly remove the information.
                            </span>
                        </div>
                    </div>




                    <div class="d-flex align-items-center mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start">
                            <h5 class="mb-0">Changes to this Privacy Policy</h5>

                            <span>
                                We reserve the right to update or modify this Privacy Policy at any time. Any
                                changes will be effective immediately upon posting the updated Privacy Policy on our
                                Website. We encourage you to review this Privacy Policy periodically.
                            </span>
                        </div>
                    </div>




                    <div class="d-flex align-items-center wow slideInUp" data-wow-delay="0.1s">
                        <div class="text-start">
                            <h5 class="mb-0">Contact Us</h5>

                            <span>
                                If you have any questions, concerns, or requests regarding this Privacy Policy or
                                our privacy practices, please contact us at <strong>info.doctorwala@gmail.com</strong>
                            </span>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</div>
<!-- Privacy Policy End -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('gsOpenBtn').click();
    });
</script>
@endsection