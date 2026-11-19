@extends('layouts.partner')

@section('title', 'Partner Profile | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-8 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-id-card-clip fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Partner Profile & Facility Settings</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Manage your official clinic information, verified contact details and login credentials</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-md-right">
        <span class="badge badge-light border text-monospace font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.88rem; color: #0284c7;">
            <i class="fa-solid fa-fingerprint mr-1"></i> Partner ID: #{{ $partner->partner_id }}
        </span>
    </div>
</div>

<div class="row">
    <!-- Facility Profile Card -->
    <div class="col-12 mb-4">
        <div class="doc-card shadow-sm p-4 p-md-5">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: #f0fdf4; color: #16a34a;">
                    <i class="fa-solid fa-hospital"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-0 text-dark">Facility Information</h5>
                    <small class="text-muted">Public details visible to patients searching on Doctorwala</small>
                </div>
            </div>

            <form method="POST" action="{{ route('partner.profile.update') }}">
                @csrf

                <!-- Registration Type Selection -->
                <div class="form-group mb-4 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <label class="font-weight-bold text-dark small mb-2 d-block">
                        <i class="fa-solid fa-sitemap text-primary mr-1"></i> Facility Type <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 20px;">
                        @if (is_array($registrationTypes))
                            @if (in_array('OPD', $registrationTypes) || in_array('Pathology', $registrationTypes))
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="registration_type[]" id="opd" value="OPD" {{ in_array('OPD', $registrationTypes) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold" for="opd">OPD Chamber</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="registration_type[]" id="pathology" value="Pathology" {{ in_array('Pathology', $registrationTypes) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold" for="pathology">Pathology Lab</label>
                                </div>
                            @endif
                            @if (in_array('Doctor', $registrationTypes))
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="registration_type[]" id="doctor" value="Doctor" {{ in_array('Doctor', $registrationTypes) ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold" for="doctor">Doctor</label>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa fa-hospital text-primary mr-1"></i> Clinic / Hospital Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_clinic_name" value="{{ $partner->partner_clinic_name }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-user text-primary mr-1"></i> Contact Person Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_contact_person_name" value="{{ $partner->partner_contact_person_name }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa fa-phone text-primary mr-1"></i> Official Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="partner_mobile_number" value="{{ $partner->partner_mobile_number }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa fa-envelope text-primary mr-1"></i> Official Email ID <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="partner_email" value="{{ $partner->partner_email }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                        <select name="partner_state" class="form-control" required style="height: 44px; border-radius: 8px;">
                            <option value="{{ $partner->partner_state }}" selected>{{ $partner->partner_state }}</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Assam">Assam</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-city text-primary mr-1"></i> City / Town <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_city" value="{{ $partner->partner_city }}" required style="height: 44px; border-radius: 8px;">
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>Save Profile Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Security & Password Card -->
    <div class="col-12">
        <div class="doc-card shadow-sm p-4 p-md-5">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: #fee2e2; color: #dc2626;">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-0 text-dark">Portal Security & Password</h5>
                    <small class="text-muted">Update your login password to keep your facility account secure</small>
                </div>
            </div>

            <form method="POST" action="{{ route('partner.password.update') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa fa-lock text-muted mr-1"></i> Current Password</label>
                        <input type="text" class="form-control bg-light" value="••••••••••••" readonly style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa fa-key text-primary mr-1"></i> New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="partner_password" required placeholder="Enter new password" style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa fa-check-double text-primary mr-1"></i> Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="confirm_password" required placeholder="Re-enter new password" style="height: 44px; border-radius: 8px;">
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-danger font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        <i class="fa-solid fa-shield-halved mr-2"></i>Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
