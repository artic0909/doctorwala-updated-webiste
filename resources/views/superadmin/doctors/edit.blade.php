@extends('layouts.superadmin')

@section('title', 'Edit Doctor Details | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-user-pen text-primary mr-2"></i>Edit Doctor Profile
            </h3>
            <p class="text-muted mb-0">Update credentials, specialization, consultation fees, and practice location.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/superadmin/super-all-doctors" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to All Doctors
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-user-doctor text-primary mr-2"></i>Doctor Profile: <span class="text-primary">{{ $doc->partner_doctor_designation ?? 'Dr' }}. {{ $doc->partner_doctor_name ?? 'Doctor' }}</span>
        </h5>
    </div>
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('superadmin.super-update-doc-details', $doc->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-user text-primary mr-1"></i> Doctor Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="partner_doctor_name" name="partner_doctor_name" value="{{ $doc->partner_doctor_name ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-2 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-graduation-cap text-primary mr-1"></i> Designation <span class="text-danger">*</span></label>
                    <select name="partner_doctor_designation" id="partner_doctor_designation" class="form-control" style="height: 48px; border-radius: 8px;" required>
                        <option value="Dr" {{ (isset($doc) && $doc->partner_doctor_designation == 'Dr') ? 'selected' : '' }}>Dr</option>
                        <option value="MD" {{ (isset($doc) && $doc->partner_doctor_designation == 'MD') ? 'selected' : '' }}>MD</option>
                        <option value="Prof" {{ (isset($doc) && $doc->partner_doctor_designation == 'Prof') ? 'selected' : '' }}>Prof</option>
                        <option value="BDS" {{ (isset($doc) && $doc->partner_doctor_designation == 'BDS') ? 'selected' : '' }}>BDS</option>
                    </select>
                </div>

                <div class="col-md-3 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-stethoscope text-primary mr-1"></i> Specialization <span class="text-danger">*</span></label>
                    <select name="partner_doctor_specialist" id="partner_doctor_specialist" class="form-control" style="height: 48px; border-radius: 8px;" required>
                        <option value="{{ $doc->partner_doctor_specialist ?? '' }}" selected>{{ $doc->partner_doctor_specialist ?? '--Select Specialization--' }}</option>
                        @php
                            $specialities = [
                                "Allergy Immunology", "Anesthesiology", "Cardiology", "Dermatology", "Emergency Medicine",
                                "Endocrinology", "Family Medicine", "Gastroenterology", "General Surgery", "Genetics",
                                "Geriatrics", "Hematology", "Infectious Disease", "Internal Medicine", "Nephrology",
                                "Neurology", "Neurosurgery", "Nuclear Medicine", "Obstetrics Gynecology", "Oncology",
                                "Ophthalmology", "Orthopedics", "Otolaryngology", "Pain Management", "Palliative Care",
                                "Pathology", "Pediatrics", "Pharmacology", "Physical Medicine Rehabilitation", "Plastic Surgery",
                                "Proctology", "Psychiatry", "Pulmonology", "Public Health", "Radiology", "Rheumatology",
                                "Sports Medicine", "Thoracic Surgery", "Urology", "Vascular Surgery"
                            ];
                        @endphp
                        @foreach($specialities as $spec)
                            <option value="{{ $spec }}">{{ $spec }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-indian-rupee-sign text-primary mr-1"></i> Consultation Fee <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="partner_doctor_fees" name="partner_doctor_fees" value="{{ $doc->partner_doctor_fees ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="partner_doctor_mobile" name="partner_doctor_mobile" value="{{ $doc->partner_doctor_mobile ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-envelope text-primary mr-1"></i> Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="partner_doctor_email" name="partner_doctor_email" value="{{ $doc->partner_doctor_email ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-map-pin text-primary mr-1"></i> Landmark <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="partner_doctor_landmark" name="partner_doctor_landmark" value="{{ $doc->partner_doctor_landmark ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-location-pin-lock text-primary mr-1"></i> Pin Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="partner_doctor_pincode" name="partner_doctor_pincode" value="{{ $doc->partner_doctor_pincode ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-city text-primary mr-1"></i> City / Town <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="partner_doctor_city" name="partner_doctor_city" value="{{ $doc->partner_doctor_city ?? '' }}" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                    <select name="partner_doctor_state" id="partner_doctor_state" class="form-control" style="height: 48px; border-radius: 8px;" required>
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
                            <option value="{{ $state }}" {{ (isset($doc) && $doc->partner_doctor_state == $state) ? 'selected' : '' }}>{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-map-location-dot text-primary mr-1"></i> Google Maps Link</label>
                    <input type="text" class="form-control" id="partner_doctor_google_map_link" name="partner_doctor_google_map_link" value="{{ $doc->partner_doctor_google_map_link ?? '' }}" placeholder="https://maps.google.com/..." style="height: 48px; border-radius: 8px;">
                </div>

                <div class="col-12 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Clinic / Chamber Full Address <span class="text-danger">*</span></label>
                    <textarea name="partner_doctor_address" id="partner_doctor_address" class="form-control" rows="4" style="border-radius: 8px;" required>{{ $doc->partner_doctor_address ?? '' }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3" style="gap: 12px;">
                <a href="/superadmin/super-all-doctors" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;">Cancel</a>
                <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-check mr-1"></i> Update Doctor Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
