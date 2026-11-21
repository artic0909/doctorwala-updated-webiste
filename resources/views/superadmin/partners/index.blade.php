@extends('layouts.superadmin')

@section('title', 'All Partners | Doctorwala Super Admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 42px !important;
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        background-color: #ffffff;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        top: 0;
        right: 10px;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
        color: var(--doc-text-main);
        font-weight: 500;
        font-size: 0.88rem;
    }
    .select2-dropdown {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }
    .partner-row-followup {
        background-color: #f0fdf4 !important;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-hospital-user fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Healthcare Partners</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Manage verified medical chambers, pathology centers & doctor clinics</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
        <a href="{{ route('superadmin.export.partner', request()->query()) }}" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-file-excel mr-2"></i>Export Excel
        </a>
        <a href="/superadmin/super-add-partners" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-plus-circle mr-2"></i>Add New Partner
        </a>
    </div>
</div>

<!-- Filter Bar Card -->
<div class="filter-card">
    <form action="{{ route('superadmin.super-all-partner.get') }}" method="GET" class="row align-items-end g-2">
        <div class="col-12 col-md-3 mb-2">
            <label><i class="fa-solid fa-magnifying-glass text-primary mr-1"></i> Search Partner</label>
            <input type="search" name="search" class="form-control" placeholder="Name, Clinic, Phone, PID..." value="{{ request('search') }}">
        </div>

        <div class="col-12 col-md-2 mb-2">
            <label><i class="fa-solid fa-calendar-day text-primary mr-1"></i> From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-12 col-md-2 mb-2">
            <label><i class="fa-solid fa-calendar-check text-primary mr-1"></i> To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-12 col-md-2 mb-2">
            <label><i class="fa-solid fa-city text-primary mr-1"></i> City</label>
            <select name="city" id="city-filter" class="form-control w-100">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-1 mb-2">
            <label><i class="fa-solid fa-toggle-on text-primary mr-1"></i> Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="col-12 col-md-2 mb-2 d-flex">
            <button type="submit" class="btn btn-primary font-weight-bold flex-fill mr-1" style="height: 42px; border-radius: 8px;">
                <i class="fa fa-filter mr-1"></i> Filter
            </button>
            @if(request('from_date') || request('to_date') || request('city') || request('status') || request('search'))
                <a href="{{ route('superadmin.super-all-partner.get') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="height: 42px; width: 42px; border-radius: 8px;" title="Reset Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Partner List Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Registered Healthcare Partners</h5>
            <small class="text-muted">Showing {{ $partners->firstItem() ?? 0 }} - {{ $partners->lastItem() ?? 0 }} of {{ $partners->total() }} partners</small>
        </div>
        <div class="d-none d-sm-block">
            <span class="badge badge-light border px-2 py-1"><i class="fa-solid fa-circle text-success mr-1" style="font-size: 8px;"></i> Active Green: Follow-up Tracked</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table doc-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">SL</th>
                    <th>Partner Code</th>
                    <th>Mobile Number</th>
                    <th>Registration Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($partners as $partner)
                <tr class="{{ $partner->followups_count > 0 ? 'partner-row-followup' : '' }}">
                    <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                        {{ ($partners->currentPage() - 1) * $partners->perPage() + $loop->iteration }}
                    </td>

                    <td>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <a href="{{ route('superadmin.partner.view', $partner->id) }}" class="badge badge-light border text-monospace font-weight-bold" style="font-size: 0.88rem; color: #0284c7; text-decoration: none;">
                                #{{ $partner->partner_id ?? ('DWPTR' . $partner->id) }}
                            </a>
                            @if(strtolower($partner->status ?? '') == 'active')
                                <span class="badge badge-success px-1" style="font-size: 0.7rem;">Active</span>
                            @else
                                <span class="badge badge-danger px-1" style="font-size: 0.7rem;">Inactive</span>
                            @endif
                        </div>
                    </td>

                    <td>
                        <a href="tel:{{ $partner->partner_mobile_number }}" class="text-dark font-weight-bold" style="font-size: 0.9rem; text-decoration: none;">
                            <i class="fa-solid fa-phone text-muted mr-1" style="font-size: 0.8rem;"></i>
                            {{ $partner->partner_mobile_number }}
                        </a>
                    </td>

                    <td>
                        @if(is_array($partner->registration_type))
                            @foreach($partner->registration_type as $type)
                                @if($type === 'OPD')
                                    <span class="badge badge-info px-2 py-1 mb-1" style="font-size: 0.75rem;">OPD</span>
                                @elseif($type === 'Pathology')
                                    <span class="badge badge-warning px-2 py-1 mb-1" style="font-size: 0.75rem; color: #fff;">Pathology</span>
                                @elseif($type === 'Doctor')
                                    <span class="badge badge-primary px-2 py-1 mb-1" style="font-size: 0.75rem;">Doctor</span>
                                @elseif($type === 'Others')
                                    <span class="badge badge-success px-2 py-1 mb-1" style="font-size: 0.75rem; background: #0d9488; border-color: #0d9488;">Physiotherapy & Allied</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1 mb-1" style="font-size: 0.75rem;">{{ $type }}</span>
                                @endif
                            @endforeach
                        @else
                            <span class="badge badge-light border" style="font-size: 0.75rem;">N/A</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
                            <!-- View Details Button -->
                            <a href="{{ route('superadmin.partner.view', $partner->id) }}" class="btn btn-sm btn-info text-white font-weight-bold" style="border-radius: 6px; padding: 4px 10px;" title="View Partner Account Details">
                                <i class="fa-solid fa-eye mr-1"></i> View
                            </a>

                            <!-- Direct Login as Partner Button -->
                            <a href="{{ route('superadmin.partner.login-direct', $partner->id) }}" target="_blank" class="btn btn-sm btn-success font-weight-bold shadow-xs" style="border-radius: 6px; padding: 4px 10px;" title="Direct Login to Partner Dashboard">
                                <i class="fa-solid fa-right-to-bracket mr-1"></i> Login
                            </a>

                            @php
                                $waMessage = "“You are the director / owner of the *" . $partner->partner_clinic_name . "* ?”\n" .
                                            "We are from *Doctorwala Medical Ecosystem*.\n" .
                                            "*Our vision:* all unorganized sector healthcare service holders get advantage of big technical opportunities.\n" .
                                            "Developed a healthy medical system.";
                                
                                $cleanPhone = preg_replace('/[^0-9]/', '', $partner->partner_mobile_number);
                                if(strlen($cleanPhone) == 10) {
                                    $cleanPhone = '91' . $cleanPhone;
                                } elseif (strlen($cleanPhone) > 10 && strpos($cleanPhone, '91') !== 0 && strpos($cleanPhone, '0') === 0) {
                                    $cleanPhone = '91' . ltrim($cleanPhone, '0');
                                }
                                $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($waMessage);
                            @endphp

                            <a href="{{ $waUrl }}" target="_blank" class="btn btn-sm btn-outline-success" title="WhatsApp Message" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>

                            <a href="{{ route('superadmin.followup.index', ['dw_partner_id' => $partner->id]) }}" class="btn btn-sm btn-outline-secondary" title="Follow-up Logs" style="border-radius: 6px; padding: 4px 8px; color: #7c3aed; border-color: #ddd6fe;">
                                <i class="fa-solid fa-phone-volume"></i>
                            </a>

                            <a href="javascript:void(0)" data-target="#myEditModal{{$partner->id}}" data-toggle="modal" class="btn btn-sm btn-outline-primary" title="Edit Partner" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <a href="javascript:void(0)" data-target="#myDeleteModal{{$partner->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" title="Delete" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-hospital-slash fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                            <h5>No Partners Found</h5>
                            <p class="small mb-0">No healthcare partners matched your current filter criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $partners->firstItem() ?? 0 }} to {{ $partners->lastItem() ?? 0 }} of {{ $partners->total() }} partners
        </div>
        <div>
            {{ $partners->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Status Toggle Modals -->
@foreach ($partners as $partner)
<div class="modal fade" id="myActiveInactiveModal{{$partner->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1rem;">
                    <i class="fa-solid fa-toggle-on text-primary mr-2"></i>Update Partner Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.status.edit', $partner->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Facility: <strong>{{ $partner->partner_clinic_name }}</strong></p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark small mb-2">Partner Status</label>
                        <select name="status" class="form-control" style="height: 44px; border-radius: 8px;">
                            <option value="Active" {{ $partner->status == 'Active' ? 'selected' : '' }}>Active (Visible & Verified)</option>
                            <option value="Inactive" {{ $partner->status == 'Inactive' ? 'selected' : '' }}>Inactive (Suspended)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-secondary font-weight-bold px-3" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius: 8px;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Modals -->
@foreach($partners as $partner)
<div class="modal fade" id="myDeleteModal{{$partner->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{ route('superadmin.status.delete', $partner->id )}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Delete Partner?</h5>
                    <p class="text-muted small mb-1">Are you sure you want to delete <strong>{{ $partner->partner_clinic_name }}</strong>?</p>
                    <p class="text-danger small mb-0 font-weight-bold">This action cannot be undone and will delete linked data.</p>
                </div>
                <div class="modal-footer bg-light border-0 py-3 justify-content-center">
                    <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4" style="border-radius: 8px;">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Edit Partner Modals -->
@foreach($partners as $partner)
<div class="modal fade" id="myEditModal{{$partner->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 580px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-0 pb-0 pt-4 px-4 bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 42px; height: 42px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.05rem;">Edit Partner Details</h5>
                        <small class="text-muted font-weight-500">ID: <span class="badge badge-light border text-primary font-weight-bold">{{ $partner->partner_id ?? 'DWPTR' . $partner->id }}</span></small>
                    </div>
                </div>
                <button type="button" class="close text-muted p-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 1.4rem;">&times;</span>
                </button>
            </div>

            <form action="{{route('superadmin.update.partner', $partner->id)}}" method="POST" enctype="multipart/form-data">
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
                                $rTypes = is_array($partner->registration_type) ? $partner->registration_type : (json_decode($partner->registration_type, true) ?? []);
                            @endphp
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="opd_{{$partner->id}}" value="OPD" {{ in_array('OPD', $rTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="opd_{{$partner->id}}">OPD Chamber</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="pathology_{{$partner->id}}" value="Pathology" {{ in_array('Pathology', $rTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="pathology_{{$partner->id}}">Pathology Lab</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="doctor_{{$partner->id}}" value="Doctor" {{ in_array('Doctor', $rTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="doctor_{{$partner->id}}">Doctor</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="registration_type[]" id="others_{{$partner->id}}" value="Others" {{ in_array('Others', $rTypes) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold text-dark small" for="others_{{$partner->id}}">Physiotherapist & Allied Care</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa fa-hospital text-primary mr-1"></i> Clinic / Hospital <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_clinic_name" value="{{$partner->partner_clinic_name}}" required style="height: 38px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-user text-primary mr-1"></i> Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_contact_person_name" value="{{$partner->partner_contact_person_name}}" required style="height: 38px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="partner_mobile_number" value="{{$partner->partner_mobile_number}}" required style="height: 38px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa fa-envelope text-primary mr-1"></i> Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" name="partner_email" value="{{$partner->partner_email}}" required style="height: 38px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                            <select name="partner_state" class="form-control form-control-sm" style="height: 38px; border-radius: 8px;">
                                <option value="{{$partner->partner_state}}" selected>{{$partner->partner_state}}</option>
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

                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-city text-primary mr-1"></i> City <span class="text-danger">*</span></label>
                            <input type="text" name="partner_city" class="form-control form-control-sm" value="{{$partner->partner_city}}" required style="height: 38px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-map-pin text-primary mr-1"></i> Landmark</label>
                            <input type="text" class="form-control form-control-sm" name="partner_landmark" value="{{$partner->partner_landmark}}" style="height: 38px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-location-pin-lock text-primary mr-1"></i> Pin Code</label>
                            <input type="text" class="form-control form-control-sm" name="partner_pincode" value="{{$partner->partner_pincode}}" style="height: 38px; border-radius: 8px;">
                        </div>

                        <div class="col-12 form-group mb-2">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Full Address <span class="text-danger">*</span></label>
                            <textarea name="partner_address" class="form-control form-control-sm" rows="2" style="border-radius: 8px;">{{$partner->partner_address}}</textarea>
                        </div>

                        <div class="col-12 form-group mb-0">
                            <label class="font-weight-bold text-secondary small mb-1"><i class="fa-solid fa-key text-primary mr-1"></i> Reset Password <small class="text-muted">(Leave blank to keep existing)</small></label>
                            <input type="password" class="form-control form-control-sm" name="partner_password" placeholder="Enter new password to change" style="height: 38px; border-radius: 8px;">
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
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#city-filter').select2({
            placeholder: "All Cities",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
