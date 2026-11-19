@extends('layouts.partner')

@section('title', 'Doctor Profile Setup | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-8 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-user-doctor fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Doctor Consultation Profile</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Setup your specialist details, consulting fee, clinic address and contact information</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-md-right">
        <a href="/partnerpanel/partner-dashboard" class="btn btn-outline-secondary font-weight-bold shadow-xs" style="border-radius: 8px; padding: 8px 16px;">
            <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12">
        <div class="doc-card shadow-sm p-4 p-md-5">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: #f0fdf4; color: #16a34a;">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-0 text-dark">Practitioner Consultation Information</h5>
                    <small class="text-muted">Displays on the Doctorwala app when patients search for doctors</small>
                </div>
            </div>

            <form action="{{ route('partner.doctor.contact.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-sitemap text-primary mr-1"></i> Registration Type</label>
                        <input type="text" class="form-control bg-light" name="clinic_registration_type" value="{{ old('clinic_registration_type', $contactDetails->clinic_registration_type ?? 'Doctor') }}" readonly style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Doctor Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_name" value="{{ old('partner_doctor_name', $contactDetails->partner_doctor_name ?? $partner->partner_contact_person_name ?? '') }}" placeholder="e.g. Dr. Rajesh Roy" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-stethoscope text-primary mr-1"></i> Specialization <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_specialist" value="{{ old('partner_doctor_specialist', $contactDetails->partner_doctor_specialist ?? '') }}" placeholder="e.g. Cardiologist, General Physician" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-graduation-cap text-primary mr-1"></i> Designation <span class="text-danger">*</span></label>
                        <select name="partner_doctor_designation" class="form-control" required style="height: 44px; border-radius: 8px;">
                            <option value="Dr" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'Dr' ? 'selected' : '' }}>Dr</option>
                            <option value="MD" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'MD' ? 'selected' : '' }}>MD</option>
                            <option value="Prof" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'Prof' ? 'selected' : '' }}>Prof</option>
                            <option value="BDS" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'BDS' ? 'selected' : '' }}>BDS</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-indian-rupee-sign text-primary mr-1"></i> Consultation Fee (₹) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="partner_doctor_fees" value="{{ old('partner_doctor_fees', $contactDetails->partner_doctor_fees ?? '500') }}" placeholder="Fee in INR" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="partner_doctor_mobile" value="{{ old('partner_doctor_mobile', $contactDetails->partner_doctor_mobile ?? $partner->partner_mobile_number ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-envelope text-primary mr-1"></i> Email ID <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="partner_doctor_email" value="{{ old('partner_doctor_email', $contactDetails->partner_doctor_email ?? $partner->partner_email ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                        @php
                            $selectedDoctorState = old('partner_doctor_state', $contactDetails->partner_doctor_state ?? $partner->partner_state ?? 'West Bengal');
                        @endphp
                        <select name="partner_doctor_state" class="form-control" required style="height: 44px; border-radius: 8px;">
                            <option value="West Bengal" {{ $selectedDoctorState == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                            <option value="Bihar" {{ $selectedDoctorState == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                            <option value="Jharkhand" {{ $selectedDoctorState == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                            <option value="Odisha" {{ $selectedDoctorState == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                            <option value="Assam" {{ $selectedDoctorState == 'Assam' ? 'selected' : '' }}>Assam</option>
                            <option value="Delhi" {{ $selectedDoctorState == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                            <option value="Maharashtra" {{ $selectedDoctorState == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                            <option value="Uttar Pradesh" {{ $selectedDoctorState == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-city text-primary mr-1"></i> City / Town <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_city" value="{{ old('partner_doctor_city', $contactDetails->partner_doctor_city ?? $partner->partner_city ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-map-pin text-primary mr-1"></i> Landmark</label>
                        <input type="text" class="form-control" name="partner_doctor_landmark" value="{{ old('partner_doctor_landmark', $contactDetails->partner_doctor_landmark ?? $partner->partner_landmark ?? '') }}" style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-location-pin-lock text-primary mr-1"></i> PIN Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_pincode" value="{{ old('partner_doctor_pincode', $contactDetails->partner_doctor_pincode ?? $partner->partner_pincode ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-map-location-dot text-primary mr-1"></i> Google Map Link</label>
                        <input type="text" class="form-control" name="partner_doctor_google_map_link" value="{{ old('partner_doctor_google_map_link', $contactDetails->partner_doctor_google_map_link ?? '') }}" placeholder="https://maps.app.goo.gl/..." style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-12 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Complete Chamber Address <span class="text-danger">*</span></label>
                        <textarea name="partner_doctor_address" class="form-control" rows="3" required style="border-radius: 8px;">{{ old('partner_doctor_address', $contactDetails->partner_doctor_address ?? $partner->partner_address ?? '') }}</textarea>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>Save Doctor Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
