@extends('layouts.partner')

@section('title', 'Subscription & Billing | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-8 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #dcfce7; color: #16a34a;">
                <i class="fa-solid fa-shield-halved fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Subscription & Plan Management</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Manage your active facility tier, voucher code redemption and service benefits</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-md-right">
        <a href="/partnerpanel/partner-show-invoice" class="btn btn-outline-secondary font-weight-bold shadow-xs" style="border-radius: 8px; padding: 8px 16px;">
            <i class="fa-solid fa-file-invoice mr-1"></i> View Invoices
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <!-- Active Subscription Status & Coupon Card -->
    <div class="col-lg-10">
        <div class="doc-card shadow-sm p-4 p-md-5 mb-4">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: #e0f2fe; color: #0284c7;">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-0 text-dark">Coupon Code & Tier Activation</h5>
                    <small class="text-muted">Enter a promotional partner coupon to renew or extend your facility membership</small>
                </div>
            </div>

            <form action="{{ route('partner.coupon.code.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="currently_loggedin_partner_id" value="{{ $partner->id }}">
                <input type="hidden" name="partner_id" value="{{ $partner->partner_id }}">
                <input type="hidden" name="partner_contact_person_name" value="{{ $partner->partner_contact_person_name }}">
                <input type="hidden" name="partner_email" value="{{ $partner->partner_email }}">
                <input type="hidden" name="partner_mobile_number" value="{{ $partner->partner_mobile_number }}">

                <div class="row g-3">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-id-card text-primary mr-1"></i> Partner ID</label>
                        <input type="text" class="form-control bg-light" value="{{ $partner->partner_id }}" readonly style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-user text-primary mr-1"></i> Contact Person</label>
                        <input type="text" class="form-control bg-light" value="{{ $partner->partner_contact_person_name }}" readonly style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-phone text-primary mr-1"></i> Mobile Number</label>
                        <input type="text" class="form-control bg-light" value="{{ $partner->partner_mobile_number }}" readonly style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-12">
                        <hr class="my-2">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-ticket text-danger mr-1"></i> Coupon Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control font-weight-bold text-uppercase" id="coupon_code" name="coupon_code" placeholder="ENTER CODE" required style="height: 44px; border-radius: 8px; letter-spacing: 1px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-indian-rupee-sign text-primary mr-1"></i> Coupon Value</label>
                        <input type="text" class="form-control bg-light font-weight-bold" id="coupon_amount" name="coupon_amount" value="{{ $couponExistDetails->coupon_amount ?? '' }}" readonly placeholder="—" style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-calendar-xmark text-primary mr-1"></i> Valid Till</label>
                        <input type="text" class="form-control bg-light" id="coupon_end_date" name="coupon_end_date" value="{{ $couponExistDetails->coupon_end_date ?? '' }}" readonly placeholder="—" style="height: 44px; border-radius: 8px;">
                        <input type="hidden" id="coupon_start_date" name="coupon_start_date" value="{{ $couponExistDetails->coupon_start_date ?? '' }}">
                    </div>
                </div>

                @php
                    $isExpired = isset($couponExistDetails->coupon_end_date)
                        ? \Carbon\Carbon::parse($couponExistDetails->coupon_end_date)->isPast()
                        : true;
                @endphp

                <div class="text-right mt-3">
                    <button id="submitBtn" class="btn btn-primary font-weight-bold px-4 py-2" type="submit" {{ $isExpired ? '' : 'disabled' }} style="border-radius: 8px;">
                        <i class="fa-solid fa-circle-check mr-2"></i>Apply & Activate Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
                body: JSON.stringify({ coupon_code: couponCode }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const coupon = data.data;
                    document.getElementById('coupon_amount').value = '₹ ' + coupon.coupon_amount;
                    document.getElementById('coupon_start_date').value = coupon.coupon_start_date;
                    document.getElementById('coupon_end_date').value = coupon.coupon_end_date;

                    const currentDate = new Date().toISOString().split('T')[0];
                    const couponEndDate = new Date(coupon.coupon_end_date).toISOString().split('T')[0];
                    const submitButton = document.getElementById('submitBtn');

                    if (couponEndDate >= currentDate) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="fa-solid fa-circle-check mr-2"></i>Continue With Code';
                    } else {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-2"></i>Coupon Expired';
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
@endpush
