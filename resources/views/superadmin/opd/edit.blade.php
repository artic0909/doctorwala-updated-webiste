@extends('layouts.superadmin')

@section('title', 'Edit OPD Clinic Details | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-pen-to-square text-primary mr-2"></i>Edit OPD Clinic Details
            </h3>
            <p class="text-muted mb-0">Update contact information, authorized person, location, and clinic parameters.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/superadmin/super-all-opd" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to All OPDs
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-hospital text-primary mr-2"></i>Clinic Profile: <span class="text-primary">{{ $opd->clinic_name ?? 'OPD Clinic' }}</span>
        </h5>
    </div>
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('superadmin.super-update-opd-details', $opd->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-sitemap text-primary mr-1"></i> Registration Type</label>
                    <input type="text" class="form-control" id="clinic_registration_type" name="clinic_registration_type" value="{{ $opd->clinic_registration_type ?? 'OPD' }}" style="height: 48px; border-radius: 8px; background: #f8fafc;" readonly>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-user text-primary mr-1"></i> Authorized Person Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="clinic_contact_person_name" name="clinic_contact_person_name" value="{{ $opd->clinic_contact_person_name ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-building text-primary mr-1"></i> Clinic Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="clinic_name" name="clinic_name" value="{{ $opd->clinic_name ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-hashtag text-primary mr-1"></i> GSTIN Number</label>
                    <input type="text" class="form-control" id="clinic_gstin" name="clinic_gstin" value="{{ $opd->clinic_gstin ?? '' }}" placeholder="Enter GST Number if applicable" style="height: 48px; border-radius: 8px;">
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-phone text-primary mr-1"></i> Mobile / Phone Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="clinic_mobile_number" name="clinic_mobile_number" value="{{ $opd->clinic_mobile_number ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-envelope text-primary mr-1"></i> Official Email ID <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="clinic_email" name="clinic_email" value="{{ $opd->clinic_email ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-map-pin text-primary mr-1"></i> Landmark <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="clinic_landmark" name="clinic_landmark" value="{{ $opd->clinic_landmark ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-location-pin-lock text-primary mr-1"></i> Pin Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="clinic_pincode" name="clinic_pincode" value="{{ $opd->clinic_pincode ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-city text-primary mr-1"></i> City / Town <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="clinic_city" name="clinic_city" value="{{ $opd->clinic_city ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                    <select name="clinic_state" id="clinic_state" class="form-control" style="height: 48px; border-radius: 8px;" required>
                        <option value="">--Select State--</option>
                        @php
                            $states = [
                                "Andaman and Nicobar Islands", "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar",
                                "Chandigarh", "Chhattisgarh", "Dadra and Nagar Haveli and Daman and Diu", "Delhi", "Goa",
                                "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and Kashmir", "Jharkhand", "Karnataka",
                                "Kerala", "Ladakh", "Lakshadweep", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya",
                                "Mizoram", "Nagaland", "Odisha", "Puducherry", "Punjab", "Rajasthan", "Sikkim",
                                "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand", "West Bengal"
                            ];
                        @endphp
                        @foreach($states as $state)
                            <option value="{{ $state }}" {{ (isset($opd) && $opd->clinic_state == $state) ? 'selected' : '' }}>{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-map-location-dot text-primary mr-1"></i> Google Maps Link</label>
                    <input type="text" class="form-control" id="clinic_google_map_link" name="clinic_google_map_link" value="{{ $opd->clinic_google_map_link ?? '' }}" placeholder="https://maps.google.com/..." style="height: 48px; border-radius: 8px;">
                </div>

                <div class="col-12 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Full Clinic Address <span class="text-danger">*</span></label>
                    <textarea name="clinic_address" id="clinic_address" class="form-control" rows="4" style="border-radius: 8px;" required>{{ $opd->clinic_address ?? '' }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3" style="gap: 12px;">
                <a href="/superadmin/super-all-opd" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;">Cancel</a>
                <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-check mr-1"></i> Update OPD Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
