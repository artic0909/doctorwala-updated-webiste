@extends('layouts.superadmin')

@section('title', 'Partner Details - ' . ($partner->partner_clinic_name ?: $partner->partner_contact_person_name) . ' | Super Admin')

@push('styles')
<style>
    .partner-detail-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .partner-detail-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .partner-detail-body {
        padding: 24px;
    }
    .info-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }
    .login-direct-box {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: #ffffff;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Top Action Bar -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
            <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                <a href="{{ route('superadmin.super-all-partner.get') }}" class="btn btn-light border font-weight-bold" style="border-radius: 8px;">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back to Partners
                </a>
                <h4 class="font-weight-bold text-dark mb-0">
                    {{ $partner->partner_clinic_name ?: $partner->partner_contact_person_name }}
                </h4>
                <span class="badge badge-light border text-monospace font-weight-bold" style="font-size: 0.9rem; color: #0284c7;">
                    #{{ $partner->partner_id ?? $partner->id }}
                </span>
                @if(strtolower($partner->status ?? '') == 'active')
                    <span class="badge badge-success px-2 py-1"><i class="fa-solid fa-circle-check mr-1"></i>Active</span>
                @else
                    <span class="badge badge-danger px-2 py-1"><i class="fa-solid fa-circle-xmark mr-1"></i>Inactive</span>
                @endif
            </div>
        </div>

        <div class="col-md-6 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $partner->partner_mobile_number);
                if(strlen($cleanPhone) == 10) {
                    $cleanPhone = '91' . $cleanPhone;
                }
                $waUrl = "https://wa.me/" . $cleanPhone;
            @endphp
            <a href="{{ $waUrl }}" target="_blank" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp
            </a>

            <!-- Direct Login Button as Partner -->
            <a href="{{ route('superadmin.partner.login-direct', $partner->id) }}" target="_blank" class="btn btn-success font-weight-bold shadow-sm px-3 py-2" style="border-radius: 8px; font-size: 0.95rem;">
                <i class="fa-solid fa-right-to-bracket mr-2"></i> Login to Partner Panel
            </a>
        </div>
    </div>

    <!-- Quick Stat Overview -->
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-2">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 10px;">
                <span class="info-label">Account Status</span>
                <div class="d-flex align-items-center mt-1">
                    <span class="badge {{ strtolower($partner->status ?? '') == 'active' ? 'badge-success' : 'badge-danger' }} px-2 py-1">
                        {{ ucfirst($partner->status ?? 'Active') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 10px;">
                <span class="info-label">Registration Types</span>
                <div class="mt-1">
                    @if(is_array($partner->registration_type))
                        @foreach($partner->registration_type as $type)
                            <span class="badge badge-info px-2 py-1 mb-1">{{ $type }}</span>
                        @endforeach
                    @else
                        <span class="badge badge-secondary">N/A</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 10px;">
                <span class="info-label">Registered On</span>
                <div class="font-weight-bold text-dark mt-1" style="font-size: 0.95rem;">
                    {{ $partner->created_at ? $partner->created_at->format('d M, Y') : 'N/A' }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 10px;">
                <span class="info-label">Patient Inquiries</span>
                <div class="font-weight-bold text-primary mt-1" style="font-size: 1.1rem;">
                    <i class="fa-solid fa-inbox mr-1"></i> {{ $inquiriesCount ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row">
        <!-- Left: Account Details -->
        <div class="col-lg-8">
            <!-- Partner Details Card -->
            <div class="partner-detail-card">
                <div class="partner-detail-header">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-id-card text-primary mr-2"></i> Partner Account Details
                    </h5>
                    <button type="button" data-toggle="modal" data-target="#editPartnerModal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Info
                    </button>
                </div>
                <div class="partner-detail-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Partner Code / ID</div>
                            <div class="info-value text-primary font-weight-bold">
                                #{{ $partner->partner_id ?? ('DWPTR' . $partner->id) }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Mobile Number</div>
                            <div class="info-value">
                                <a href="tel:{{ $partner->partner_mobile_number }}" class="text-dark font-weight-bold">
                                    <i class="fa-solid fa-phone text-success mr-1"></i> {{ $partner->partner_mobile_number }}
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Facility / Clinic Name</div>
                            <div class="info-value">
                                <i class="fa-solid fa-hospital text-muted mr-1"></i> {{ $partner->partner_clinic_name ?: 'N/A' }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Contact Person Name</div>
                            <div class="info-value">
                                <i class="fa-solid fa-user text-muted mr-1"></i> {{ $partner->partner_contact_person_name ?: 'N/A' }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">
                                @if($partner->partner_email)
                                    <a href="mailto:{{ $partner->partner_email }}" class="text-dark">
                                        <i class="fa-solid fa-envelope text-primary mr-1"></i> {{ $partner->partner_email }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Executive Partner (EP)</div>
                            <div class="info-value">
                                @if($partner->ep)
                                    <span class="badge badge-light border text-dark font-weight-bold">
                                        <i class="fa-solid fa-user-tie text-info mr-1"></i> {{ $partner->ep->code }} - {{ $partner->ep->name }}
                                    </span>
                                @else
                                    <span class="text-muted">Direct (No EP)</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">City & State</div>
                            <div class="info-value">
                                {{ $partner->partner_city ?? 'N/A' }}, {{ $partner->partner_state ?? 'N/A' }} (PIN: {{ $partner->partner_pincode ?? 'N/A' }})
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Landmark</div>
                            <div class="info-value">
                                {{ $partner->partner_landmark ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-label">Full Address</div>
                            <div class="info-value">
                                <i class="fa-solid fa-location-dot text-danger mr-1"></i> {{ $partner->partner_address ?? 'N/A' }}
                            </div>
                        </div>

                        @if($partner->clinic_google_map_link)
                        <div class="col-12">
                            <div class="info-label">Google Maps Location</div>
                            <div class="info-value">
                                <a href="{{ $partner->clinic_google_map_link }}" target="_blank" class="btn btn-sm btn-outline-info" style="border-radius: 6px;">
                                    <i class="fa-solid fa-map-location-dot mr-1"></i> View on Google Maps
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Details for Associated Services -->
            @if($opd)
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-stethoscope text-info mr-2"></i> OPD Chamber Profile
                    </h5>
                    <span class="badge badge-info px-2 py-1">OPD Active</span>
                </div>
                <div class="partner-detail-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Chamber / OPD Name</div>
                            <div class="info-value">{{ $opd->clinic_name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">OPD Mobile Number</div>
                            <div class="info-value">{{ $opd->clinic_mobile_number }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Doctors Listed</div>
                            <div class="info-value">
                                <span class="badge badge-primary">{{ $opd->doctors ? $opd->doctors->count() : 0 }} Doctors</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge badge-success">{{ $opd->status ?? 'Active' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($pathology)
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-microscope text-warning mr-2"></i> Pathology Lab Profile
                    </h5>
                    <span class="badge badge-warning text-white px-2 py-1">Pathology Active</span>
                </div>
                <div class="partner-detail-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Lab Name</div>
                            <div class="info-value">{{ $pathology->clinic_name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Lab Mobile Number</div>
                            <div class="info-value">{{ $pathology->clinic_mobile_number }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Diagnostic Tests Listed</div>
                            <div class="info-value">
                                <span class="badge badge-warning text-white">{{ $pathology->tests ? $pathology->tests->count() : 0 }} Tests</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge badge-success">{{ $pathology->status ?? 'Active' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($doctor)
            <div class="partner-detail-card">
                <div class="partner-detail-header bg-light">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-user-doctor text-primary mr-2"></i> Doctor Profile
                    </h5>
                    <span class="badge badge-primary px-2 py-1">Doctor Active</span>
                </div>
                <div class="partner-detail-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Doctor Name</div>
                            <div class="info-value">{{ $doctor->partner_doctor_name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Specialist</div>
                            <div class="info-value">{{ $doctor->partner_doctor_specialist ?? 'General Physician' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Designation / Degree</div>
                            <div class="info-value">{{ $doctor->partner_doctor_designation ?? 'Doctor' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-label">Consultation Fees</div>
                            <div class="info-value text-success font-weight-bold">₹ {{ $doctor->partner_doctor_fees ?? '500' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right: Actions & Direct Login -->
        <div class="col-lg-4">
            <!-- Direct Login Box -->
            <div class="login-direct-box">
                <h5 class="font-weight-bold mb-2">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Direct Admin Login
                </h5>
                <p class="mb-3 text-white-50" style="font-size: 0.88rem; line-height: 1.5;">
                    Sign in to this partner's dashboard directly from Super Admin without needing their password.
                </p>
                <a href="{{ route('superadmin.partner.login-direct', $partner->id) }}" target="_blank" class="btn btn-light btn-block font-weight-bold text-success shadow py-2" style="border-radius: 8px; font-size: 1rem;">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Login to Partner Panel
                </a>
            </div>

            <!-- Status Card -->
            <div class="partner-detail-card">
                <div class="partner-detail-header">
                    <h6 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-toggle-on text-primary mr-2"></i> Status Management
                    </h6>
                </div>
                <div class="partner-detail-body">
                    <p class="text-muted small mb-3">Set active or inactive state for this partner account:</p>
                    <form action="{{ route('superadmin.status.edit', $partner->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <select name="status" class="form-control" style="border-radius: 8px;">
                                <option value="Active" {{ strtolower($partner->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ strtolower($partner->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="border-radius: 8px;">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Follow-up Tracking -->
            <div class="partner-detail-card">
                <div class="partner-detail-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 font-weight-bold text-dark">
                        <i class="fa-solid fa-phone-volume text-info mr-2"></i> Follow-up Logs
                    </h6>
                    <a href="{{ route('superadmin.followup.index', ['dw_partner_id' => $partner->id]) }}" class="btn btn-xs btn-outline-info" style="border-radius: 6px; font-size: 0.78rem;">
                        View All ({{ $partner->followups ? $partner->followups->count() : 0 }})
                    </a>
                </div>
                <div class="partner-detail-body p-3">
                    @if($partner->followups && $partner->followups->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($partner->followups->take(3) as $followup)
                                <li class="mb-2 pb-2 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="font-weight-bold text-dark">{{ $followup->created_at ? $followup->created_at->format('d M, Y') : '' }}</small>
                                        <span class="badge badge-light border">{{ $followup->status ?? 'Logged' }}</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">{{ Str::limit($followup->note ?? 'Follow-up call recorded', 60) }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small mb-0">No follow-ups tracked yet.</p>
                    @endif
                    <a href="{{ route('superadmin.followup.index', ['dw_partner_id' => $partner->id]) }}" class="btn btn-light btn-sm btn-block mt-3 border font-weight-bold" style="border-radius: 8px;">
                        <i class="fa-solid fa-plus mr-1"></i> Add Follow-up
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Partner Modal -->
<div class="modal fade" id="editPartnerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 580px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-0 pb-0 pt-4 px-4 bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 42px; height: 42px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.05rem;">Edit Partner Profile</h5>
                        <small class="text-muted font-weight-500">{{ $partner->partner_clinic_name }}</small>
                    </div>
                </div>
                <button type="button" class="close text-muted p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 1.4rem;">&times;</span>
                </button>
            </div>

            <form action="{{ route('superadmin.update.partner', $partner->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <!-- Service Type Checkboxes -->
                    <div class="p-3 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <label class="font-weight-bold text-dark small mb-2 d-block">
                            <i class="fa-solid fa-sitemap text-primary mr-1"></i> Registration Type <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
                            @php
                                $regTypes = is_array($partner->registration_type) ? $partner->registration_type : (json_decode($partner->registration_type, true) ?? []);
                            @endphp
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="view_opd" value="OPD" {{ in_array('OPD', $regTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="view_opd">OPD Chamber</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="view_path" value="Pathology" {{ in_array('Pathology', $regTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="view_path">Pathology Lab</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="view_doc" value="Doctor" {{ in_array('Doctor', $regTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="view_doc">Doctor</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa fa-hospital text-primary mr-1"></i> Clinic / Facility <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_clinic_name" value="{{ $partner->partner_clinic_name }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-user text-primary mr-1"></i> Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_contact_person_name" value="{{ $partner->partner_contact_person_name }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_mobile_number" value="{{ $partner->partner_mobile_number }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-envelope text-primary mr-1"></i> Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" name="partner_email" value="{{ $partner->partner_email }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_state" value="{{ $partner->partner_state }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-city text-primary mr-1"></i> City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_city" value="{{ $partner->partner_city }}" required style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-map-pin text-primary mr-1"></i> Landmark</label>
                            <input type="text" class="form-control form-control-sm" name="partner_landmark" value="{{ $partner->partner_landmark }}" style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-location-pin-lock text-primary mr-1"></i> Pin Code</label>
                            <input type="text" class="form-control form-control-sm" name="partner_pincode" value="{{ $partner->partner_pincode }}" style="height: 38px; border-radius: 8px;">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Full Address <span class="text-danger">*</span></label>
                            <textarea name="partner_address" class="form-control form-control-sm" rows="2" style="border-radius: 8px;">{{ $partner->partner_address }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 py-3 bg-light d-flex justify-content-end" style="gap: 10px;">
                    <button type="button" class="btn btn-light font-weight-bold px-3 py-2" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-check mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
