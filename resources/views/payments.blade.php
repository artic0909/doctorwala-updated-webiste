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
                        <h1 class="display-5 text-white mb-4">Why Partner with DoctorWala.info</h1>
                        <p class="text-white mb-0">Clinics join DoctorWala.info to expand their digital presence, reach more local patients, and simplify their service promotion. By partnering with us, they get a dedicated profile, can showcase their doctors, OPD schedules, pathology services, and receive direct inquiries from patients. It’s a powerful way to grow trust, visibility, and patient engagement — all in one platform.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn"
                        data-wow-delay="0.6s">
                        <h1 class="text-white mb-4">Add Coupon</h1>

                        <form action="{{route('partner.coupon.code.add')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">



                                <!-- <div class="col-12">
                                    <p for="subciption_amount" class="form-label text-white fw-bolder fs-5"
                                        style="text-align: left;">Subscribe Now</p>
                                    <a href="/partnerpanel/partner-subscription" class="btn btn-dark w-100 py-3">Go With Subscription</a>
                                    <a href="" class="btn btn-dark w-100 py-3">Coming Soon</a>
                                </div> -->


                                <div class="col-12">
                                    <p for="currently_loggedin_partner_id" class="form-label text-white fw-bolder fs-5"
                                        style="text-align: left;">Partner ID*</p>
                                    <input type="text" class="form-control bg-light border-0"
                                        value="{{$partnerID->id}}" style="height: 55px;" name="currently_loggedin_partner_id"
                                        id="currently_loggedin_partner_id">
                                </div>



                                <div class="col-12">
                                    <p for="coupon_code" class="form-label text-white fw-bolder fs-5" style="text-align: left;">Coupon Code (if any)*</p>
                                    <p for="coupon_code" class="form-label text-white fw-bolder fs-5" style="text-align: left;">Write the Code below : " DWCPNFREE01 "</p>
                                    <input type="text" class="form-control bg-light border-0" placeholder="Enter Coupon Code"
                                        style="height: 55px;" name="coupon_code" id="coupon_code" value="DWCPNFREE01">

                                </div>

                                <div class="col-4">
                                    <p for="coupon_amount" class="form-label text-white fw-bolder fs-5" style="text-align: left;">Amount</p>
                                    <input type="text" class="form-control bg-light border-0" value="" style="height: 55px;" name="coupon_amount" id="coupon_amount" readonly>
                                </div>

                                <div class="col-4">
                                    <p for="coupon_start_date" class="form-label text-white fw-bolder fs-5" style="text-align: left;">From</p>
                                    <input type="text" class="form-control bg-light border-0" value="" style="height: 55px;" name="coupon_start_date" id="coupon_start_date" readonly>
                                </div>

                                <div class="col-4">
                                    <p for="coupon_end_date" class="form-label text-white fw-bolder fs-5" style="text-align: left;">Expire</p>
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




    <script>
        function fetchCouponDetails(couponCode) {
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
                            if (couponEndDate >= currentDate) {
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
        }

        document.addEventListener('DOMContentLoaded', function() {
            const couponInput = document.getElementById('coupon_code');
            
            // Fetch immediately on load for the prefilled value
            fetchCouponDetails(couponInput.value);

            // Fetch when changed manually
            couponInput.addEventListener('change', function() {
                fetchCouponDetails(this.value);
            });
        });
    </script>

@endsection