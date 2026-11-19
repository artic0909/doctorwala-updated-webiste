@extends('layouts.superadmin')

@section('title', 'Add Coupon | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-ticket-simple text-primary mr-2"></i>Create New Coupon
            </h3>
            <p class="text-muted mb-0">Create promotional discount coupons, set validity ranges, and define discount values.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.super-coupon.show') }}" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-list mr-1"></i> View All Coupons
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('superadmin.super-coupon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-4">
                        <i class="fa-solid fa-ticket text-primary mr-2"></i>Coupon Configuration
                    </h5>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-barcode text-primary mr-1"></i> Coupon Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="e.g. WELCOME500" style="border-radius: 8px; text-transform: uppercase;" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa fa-indian-rupee-sign text-primary mr-1"></i> Discount Amount (₹) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" class="form-control" name="coupon_amount" value="{{ old('coupon_amount') }}" placeholder="e.g. 500" style="border-radius: 8px;" required>
                        </div>

                        <div class="col-md-12 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-image text-primary mr-1"></i> Coupon Image / Artwork <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" name="coupon_image" accept="image/*" style="border-radius: 8px;" required>
                            <small class="text-muted">Recommended: 600x300 PNG or JPG banner image.</small>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-calendar-days text-primary mr-1"></i> Start Date
                            </label>
                            <input type="date" class="form-control" name="coupon_start_date" value="{{ old('coupon_start_date', date('Y-m-d')) }}" style="border-radius: 8px;">
                            <small class="text-muted">Defaults to today if unselected.</small>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-calendar-xmark text-primary mr-1"></i> Expiry / Closing Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" name="coupon_end_date" value="{{ old('coupon_end_date') }}" style="border-radius: 8px;" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <a href="{{ route('superadmin.super-coupon.show') }}" class="btn btn-light px-4 mr-2" style="border-radius: 8px;">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                            <i class="fa-solid fa-check mr-2"></i> Save Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
