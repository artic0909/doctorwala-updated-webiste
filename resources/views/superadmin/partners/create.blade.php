@extends('layouts.superadmin')

@section('title', 'Add New Partner | Doctorwala Super Admin')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-hospital-user fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Add New Healthcare Partner</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Onboard a new clinic, hospital, pathology center or doctor to the Doctorwala network</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-md-right">
        <a href="/superadmin/super-all-partner" class="btn btn-outline-secondary font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back to All Partners
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="doc-card shadow-sm p-4 p-md-5">
            <form action="{{ route('superadmin.register.partners') }}" method="POST" enctype="multipart/form-data" id="partnerAddForm">
                @csrf

                <!-- Section 1: Partner Type Selection -->
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="font-weight-bold mb-2" style="color: var(--doc-text-main);">
                        <i class="fa-solid fa-sitemap text-primary mr-2"></i>1. Registration Type <span class="text-danger">*</span>
                    </h5>
                    <p class="text-muted small mb-3">Select the facility category (Doctor & Physiotherapy are standalone; OPD & Lab Tests can be combined)</p>

                    <div class="row g-3">
                        <!-- 1. Specialist Doctor -->
                        <div class="col-md-4 mb-2">
                            <label class="d-flex align-items-center p-3 rounded border cursor-pointer w-100 mb-0 shadow-xs h-100" style="background: #f8fafc; border-color: #e2e8f0; cursor: pointer;">
                                <input type="checkbox" name="registration_type[]" id="type_doctor" value="Doctor" class="mr-3" style="width: 18px; height: 18px; cursor: pointer;">
                                <div>
                                    <div class="font-weight-bold text-dark"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Specialist Doctor</div>
                                    <small class="text-muted">Individual Doctor Practitioner</small>
                                </div>
                            </label>
                        </div>

                        <!-- 2. Physiotherapist & Allied Care -->
                        <div class="col-md-4 mb-2">
                            <label class="d-flex align-items-center p-3 rounded border cursor-pointer w-100 mb-0 shadow-xs h-100" style="background: #f8fafc; border-color: #e2e8f0; cursor: pointer;">
                                <input type="checkbox" name="registration_type[]" id="type_physio" value="Others" class="mr-3" style="width: 18px; height: 18px; cursor: pointer;">
                                <div>
                                    <div class="font-weight-bold text-dark"><i class="fa-solid fa-hand-holding-medical text-primary mr-1"></i> Physiotherapist & Allied Care</div>
                                    <small class="text-muted">Therapy & Allied Healthcare Clinic</small>
                                </div>
                            </label>
                        </div>

                        <!-- 3. OPD Chamber -->
                        <div class="col-md-4 mb-2">
                            <label class="d-flex align-items-center p-3 rounded border cursor-pointer w-100 mb-0 shadow-xs h-100" style="background: #f8fafc; border-color: #e2e8f0; cursor: pointer;">
                                <input type="checkbox" name="registration_type[]" id="type_opd" value="OPD" class="mr-3" style="width: 18px; height: 18px; cursor: pointer;">
                                <div>
                                    <div class="font-weight-bold text-dark"><i class="fa-solid fa-stethoscope text-info mr-1"></i> OPD Chamber</div>
                                    <small class="text-muted">Out-Patient Department & Chambers</small>
                                </div>
                            </label>
                        </div>

                        <!-- 4. Lab Tests Provider -->
                        <div class="col-md-6 mb-2">
                            <label class="d-flex align-items-center p-3 rounded border cursor-pointer w-100 mb-0 shadow-xs h-100" style="background: #f8fafc; border-color: #e2e8f0; cursor: pointer;">
                                <input type="checkbox" name="registration_type[]" id="type_pathology" value="Pathology" class="mr-3" style="width: 18px; height: 18px; cursor: pointer;">
                                <div>
                                    <div class="font-weight-bold text-dark"><i class="fa-solid fa-flask-vial text-warning mr-1"></i> Lab Tests Provider</div>
                                    <small class="text-muted">Diagnostic & Test Collection Center</small>
                                </div>
                            </label>
                        </div>

                        <!-- 5. Both OPD & Lab Tests Provider -->
                        <div class="col-md-6 mb-2">
                            <label class="d-flex align-items-center p-3 rounded border cursor-pointer w-100 mb-0 shadow-xs h-100" style="background: #f8fafc; border-color: #e2e8f0; cursor: pointer;">
                                <input type="checkbox" name="registration_type[]" id="type_both" value="both" class="mr-3" style="width: 18px; height: 18px; cursor: pointer;">
                                <div>
                                    <div class="font-weight-bold text-dark"><i class="fa-solid fa-hospital text-success mr-1"></i> Both OPD & Lab Tests Provider</div>
                                    <small class="text-muted">Combined Chambers & Diagnostics</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Facility & Contact Information -->
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="font-weight-bold mb-3" style="color: var(--doc-text-main);">
                        <i class="fa-solid fa-hospital text-primary mr-2"></i>2. Facility & Contact Details
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-hospital-alt text-primary mr-1"></i> Clinic / Center Name <span class="text-danger">*</span></label>
                            <input type="text" name="partner_clinic_name" class="form-control" placeholder="e.g. LifeCare Diagnostic & Polyclinic" required style="height: 46px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-user text-primary mr-1"></i> Contact Person Name <span class="text-danger">*</span></label>
                            <input type="text" name="partner_contact_person_name" class="form-control" placeholder="e.g. Dr. Rajesh Sharma or Manager" required style="height: 46px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-phone text-primary mr-1"></i> Mobile Number (Login ID) <span class="text-danger">*</span></label>
                            <input type="tel" name="partner_mobile_number" class="form-control" placeholder="10-digit mobile number" required style="height: 46px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-envelope text-primary mr-1"></i> Official Email ID <span class="text-danger">*</span></label>
                            <input type="email" name="partner_email" class="form-control" placeholder="partner@example.com" required style="height: 46px; border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Location Details -->
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="font-weight-bold mb-3" style="color: var(--doc-text-main);">
                        <i class="fa-solid fa-map-location-dot text-primary mr-2"></i>3. Address & Location
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                            <select name="partner_state" class="form-control" required style="height: 46px; border-radius: 8px;">
                                <option value="West Bengal" selected>West Bengal</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Jharkhand">Jharkhand</option>
                                <option value="Odisha">Odisha</option>
                                <option value="Assam">Assam</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                <option value="Tripura">Tripura</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-city text-primary mr-1"></i> City / Town <span class="text-danger">*</span></label>
                            <input type="text" name="partner_city" class="form-control" placeholder="e.g. Kolkata, Howrah" required style="height: 46px; border-radius: 8px;">
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-location-pin-lock text-primary mr-1"></i> PIN Code <span class="text-danger">*</span></label>
                            <input type="text" name="partner_pincode" class="form-control" placeholder="e.g. 700091" required style="height: 46px; border-radius: 8px;">
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-map-pin text-primary mr-1"></i> Nearby Landmark</label>
                            <input type="text" name="partner_landmark" class="form-control" placeholder="e.g. Near City Center / Beside Metro Station" style="height: 46px; border-radius: 8px;">
                        </div>

                        <div class="col-12 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Full Clinic / Hospital Address <span class="text-danger">*</span></label>
                            <textarea name="partner_address" class="form-control" rows="3" placeholder="Street, Building, Area, Ward/Block details" required style="border-radius: 8px;"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Security & Password -->
                <div class="mb-4">
                    <h5 class="font-weight-bold mb-3" style="color: var(--doc-text-main);">
                        <i class="fa-solid fa-lock text-primary mr-2"></i>4. Partner Portal Credentials
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-key text-primary mr-1"></i> Account Password <span class="text-danger">*</span></label>
                            <input type="password" name="partner_password" id="partner_password" class="form-control" placeholder="Create strong password" required style="height: 46px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-check-double text-primary mr-1"></i> Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" id="confirm_password" class="form-control" placeholder="Confirm password" required style="height: 46px; border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-3">
                    <button type="submit" class="btn btn-primary font-weight-bold px-5 py-3 shadow" style="border-radius: 10px; font-size: 1rem;">
                        <i class="fa-solid fa-hospital-user mr-2"></i>Complete Partner Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("partnerAddForm");
        const passwordField = document.getElementById("partner_password");
        const confirmPasswordField = document.getElementById("confirm_password");
        const opdCheckbox = document.getElementById("type_opd");
        const pathologyCheckbox = document.getElementById("type_pathology");
        const doctorCheckbox = document.getElementById("type_doctor");
        const physioCheckbox = document.getElementById("type_physio");
        const bothCheckbox = document.getElementById("type_both");

        // Doctor / Physio are standalone
        doctorCheckbox.addEventListener("change", function() {
            if (this.checked) {
                physioCheckbox.checked = false;
                opdCheckbox.checked = false;
                pathologyCheckbox.checked = false;
                bothCheckbox.checked = false;
            }
        });

        physioCheckbox.addEventListener("change", function() {
            if (this.checked) {
                doctorCheckbox.checked = false;
                opdCheckbox.checked = false;
                pathologyCheckbox.checked = false;
                bothCheckbox.checked = false;
            }
        });

        bothCheckbox.addEventListener("change", function() {
            if (this.checked) {
                doctorCheckbox.checked = false;
                physioCheckbox.checked = false;
                opdCheckbox.checked = true;
                pathologyCheckbox.checked = true;
            } else {
                opdCheckbox.checked = false;
                pathologyCheckbox.checked = false;
            }
        });

        opdCheckbox.addEventListener("change", function() {
            if (this.checked) {
                doctorCheckbox.checked = false;
                physioCheckbox.checked = false;
            }
            if (opdCheckbox.checked && pathologyCheckbox.checked) {
                bothCheckbox.checked = true;
            } else {
                bothCheckbox.checked = false;
            }
        });

        pathologyCheckbox.addEventListener("change", function() {
            if (this.checked) {
                doctorCheckbox.checked = false;
                physioCheckbox.checked = false;
            }
            if (opdCheckbox.checked && pathologyCheckbox.checked) {
                bothCheckbox.checked = true;
            } else {
                bothCheckbox.checked = false;
            }
        });

        // Form submission verification
        form.addEventListener("submit", function(e) {
            if (!opdCheckbox.checked && !pathologyCheckbox.checked && !doctorCheckbox.checked && !physioCheckbox.checked && !bothCheckbox.checked) {
                alert("Please select at least one Registration Type.");
                e.preventDefault();
                return;
            }

            if (passwordField.value !== confirmPasswordField.value) {
                alert("Passwords do not match! Please check and re-enter.");
                e.preventDefault();
                return;
            }
        });
    });
</script>
@endpush
