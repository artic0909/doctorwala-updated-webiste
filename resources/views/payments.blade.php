@extends('frontend.layout.app')

@section('title', 'Payment | Doctorwala' . ' - DoctorWala.info')

@section('content')

<head>
    <!-- SEO Meta Tags for Payment Page/ Coupons Page/ Subscriptions -->
    <meta name="description" content="Payment | Doctorwala">
    <meta name="keywords" content="Payment, Doctorwala, Coupons, Subscriptions, Subscribe, Subscription, Coupon, Coupons, Coupons Page, Subscription Page, Subscribe Page, doctorwala.info, doctorwala, doctorwala.com">
    <meta name="author" content="Doctorwala">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="yandex-verification" content="yandex-verification-code">
    <meta name="copyright" content="Doctorwala">
    <meta name="distribution" content="Global">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('../css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('./css/float-btn.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('../css/style.css')}}" rel="stylesheet">
    <link href="{{asset('../css/cards-css.css')}}" rel="stylesheet">
    <link href="{{asset('../css/partner-btn.css')}}" rel="stylesheet">
</head>

    <!-- Payment Start -->
    <div class="container-fluid bg-primary bg-appointment mb-5 wow fadeInUp" data-wow-delay="0.1s"
        style="margin-top: 90px;">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-6 py-5">
                    <div class="py-5">
                        <h1 class="display-5 text-white mb-4">We Are A Certified and Award Winning Dental Clinic You Can
                            Trust</h1>
                        <p class="text-white mb-0">Eirmod sed tempor lorem ut dolores. Aliquyam sit sadipscing kasd
                            ipsum. Dolor ea et dolore et at sea ea at dolor, justo ipsum duo rebum sea invidunt
                            voluptua. Eos vero eos vero ea et dolore eirmod et. Dolores diam duo invidunt lorem. Elitr
                            ut dolores magna sit. Sea dolore sanctus sed et. Takimata takimata sanctus sed.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn"
                        data-wow-delay="0.6s">
                        <h1 class="text-white mb-4">Make Payments</h1>

                        <form action="{{route('partner.coupon.code.add')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">



                                <div class="col-12">
                                    <p for="subciption_amount" class="form-label text-white fw-bolder fs-5"
                                        style="text-align: left;">Subscribe Now</p>
                                    <!-- <a href="/partnerpanel/partner-subscription" class="btn btn-dark w-100 py-3">Go With Subscription</a> -->
                                    <a href="" class="btn btn-dark w-100 py-3">Coming Soon</a>
                                </div>


                                <div class="col-12">
                                    <p for="currently_loggedin_partner_id" class="form-label text-white fw-bolder fs-5"
                                        style="text-align: left;">Partner ID*</p>
                                    <input type="text" class="form-control bg-light border-0"
                                        value="{{$partnerID->id}}" style="height: 55px;" name="currently_loggedin_partner_id"
                                        id="currently_loggedin_partner_id">
                                </div>



                                <div class="col-12">
                                    <p for="coupon_code" class="form-label text-white fw-bolder fs-5" style="text-align: left;">Coupon Code (if any)*</p>
                                    <input type="text" class="form-control bg-light border-0" placeholder="Enter Coupon Code"
                                        style="height: 55px;" name="coupon_code" id="coupon_code">

                                    <div class="btnns d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-dark">Add</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <p for="coupon_amount" class="form-label text-white fw-bolder fs-5" style="text-align: left;">Coupon Code Amount*</p>
                                    <input type="text" class="form-control bg-light border-0" value="" style="height: 55px;" name="coupon_amount" id="coupon_amount" readonly>
                                </div>

                                <div class="col-12">
                                    <p for="coupon_start_date" class="form-label text-white fw-bolder fs-5" style="text-align: left;">Start Date*</p>
                                    <input type="text" class="form-control bg-light border-0" value="" style="height: 55px;" name="coupon_start_date" id="coupon_start_date" readonly>
                                </div>

                                <div class="col-12">
                                    <p for="coupon_end_date" class="form-label text-white fw-bolder fs-5" style="text-align: left;">End Date*</p>
                                    <input type="text" class="form-control bg-light border-0" value="" style="height: 55px;" name="coupon_end_date" id="coupon_end_date" readonly>
                                </div>



                                <div class="col-12">
                                    <button id="submitBtn" class="btn btn-dark w-100 py-3" type="submit">Cotinue With Code</button>
                                </div>



                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment End -->

    <!-- Testimonial Start -->
    <div class="container-fluid bg-primary bg-testimonial py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="owl-carousel testimonial-carousel rounded p-5 wow zoomIn" data-wow-delay="0.6s">
                        <div class="testimonial-item text-center text-white">
                            <img class="img-fluid mx-auto rounded mb-4" src="img/testilogo.png" alt="">

                            <p class="fs-5" style="color: white; opacity: 1; font-weight: 700;">

                                <i class="fa-solid fa-2x fa-quote-left"></i>&nbsp;Dolores sed duo clita justo
                                dolor et stet
                                lorem kasd dolore lorem ipsum. At
                                lorem lorem magna ut et, nonumy labore diam erat. Erat dolor rebum sit ipsum.&nbsp;
                                <i class="fa-solid fa-2x fa-quote-right"></i>
                            </p>
                            <hr class="mx-auto w-25">
                            <h4 class="text-white mb-0">Client Name</h4>
                        </div>
                        <div class="testimonial-item text-center text-white">
                            <img class="img-fluid mx-auto rounded mb-4" src="img/testilogo.png" alt="">

                            <p class="fs-5" style="color: white; opacity: 1; font-weight: 700;">

                                <i class="fa-solid fa-2x fa-quote-left"></i>&nbsp;Dolores sed duo clita justo
                                dolor et stet
                                lorem kasd dolore lorem ipsum. At
                                lorem lorem magna ut et, nonumy labore diam erat. Erat dolor rebum sit ipsum.&nbsp;
                                <i class="fa-solid fa-2x fa-quote-right"></i>
                            </p>
                            <hr class="mx-auto w-25">
                            <h4 class="text-white mb-0">Client Name</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->




    <script>
        document.getElementById('coupon_code').addEventListener('change', function() {
            const couponCode = this.value;

            if (couponCode) {
                fetch('{{ route("get.coupon.details") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            coupon_code: couponCode
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const coupon = data.data;
                            document.getElementById('coupon_amount').value = coupon.coupon_amount;
                            document.getElementById('coupon_start_date').value = coupon.coupon_start_date;
                            document.getElementById('coupon_end_date').value = coupon.coupon_end_date;

                            // Get current date in YYYY-MM-DD format (ignores time)
                            const currentDate = new Date().toISOString().split('T')[0];
                            const couponEndDate = new Date(coupon.coupon_end_date).toISOString().split('T')[0];

                            const submitButton = document.getElementById('submitBtn');

                            // If the coupon's end date is today or in the future, enable the button
                            if (couponEndDate > currentDate) {
                                submitButton.disabled = false; // Enable button
                                submitButton.textContent = 'Continue With Code';
                            } else {
                                submitButton.disabled = true; // Disable button
                                submitButton.textContent = 'Coupon is expired';
                            }
                        } else {
                            alert(data.message);
                            document.getElementById('coupon_amount').value = '';
                            document.getElementById('coupon_start_date').value = '';
                            document.getElementById('coupon_end_date').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching coupon details:', error);
                    });
            }
        });
    </script>

@endsection