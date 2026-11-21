@extends('layouts.superadmin')

@section('title', 'Physiotherapy & Allied Care Directory | Doctorwala Super Admin')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e6fffa; color: #0d9488;">
                <i class="fa-solid fa-hand-holding-medical fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Physiotherapy & Allied Care Directory</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Registered physiotherapists, occupational therapists & allied healthcare practitioners</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
        <span class="badge badge-light border font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.88rem; color: #0d9488;">
            <i class="fa-solid fa-hand-holding-medical text-teal mr-1"></i> Total Providers: {{ number_format($others->total()) }}
        </span>
        <a href="{{ route('superadmin.export.others') }}" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-file-excel mr-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Filter Bar Card -->
<div class="filter-card">
    <form action="{{ route('superadmin.super-all-others') }}" method="GET" class="row align-items-end g-2">
        <div class="col-12 col-md-4 mb-2">
            <label><i class="fa-solid fa-magnifying-glass text-primary mr-1"></i> Search Providers</label>
            <input type="search" name="search" class="form-control" placeholder="Provider name, specialty, city, phone..." value="{{ request('search') }}">
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
            <label><i class="fa-solid fa-toggle-on text-primary mr-1"></i> Status</label>
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="col-12 col-md-2 mb-2 d-flex">
            <button type="submit" class="btn btn-primary font-weight-bold flex-fill mr-1" style="height: 42px; border-radius: 8px; background: #0d9488; border-color: #0d9488;">
                <i class="fa fa-filter mr-1"></i> Filter
            </button>
            @if(request('from_date') || request('to_date') || request('status') || request('search'))
                <a href="{{ route('superadmin.super-all-others') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="height: 42px; width: 42px; border-radius: 8px;" title="Reset Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Others Table Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Physiotherapy & Allied Care Partners</h5>
            <small class="text-muted">Showing {{ $others->firstItem() ?? 0 }} - {{ $others->lastItem() ?? 0 }} of {{ $others->total() }} providers</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table doc-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">SL</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Partner ID</th>
                    <th>Clinic / Practice Name</th>
                    <th>Practitioner Profile</th>
                    <th>Contact Info</th>
                    <th>Location Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($others as $item)
                <tr>
                    <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                        {{ ($others->currentPage() - 1) * $others->perPage() + $loop->iteration }}
                    </td>

                    <td>
                        @if($item->status == 'Active')
                        <a href="javascript:void(0)" data-target="#myActiveInactiveModal{{$item->id}}" data-toggle="modal" class="badge badge-success px-2 py-1 shadow-xs" title="Click to change status" style="font-size: 0.78rem; text-decoration: none;">
                            <i class="fa-solid fa-circle-check mr-1"></i>Active
                        </a>
                        @else
                        <a href="javascript:void(0)" data-target="#myActiveInactiveModal{{$item->id}}" data-toggle="modal" class="badge badge-danger px-2 py-1 shadow-xs" title="Click to activate" style="font-size: 0.78rem; text-decoration: none;">
                            <i class="fa-solid fa-circle-xmark mr-1"></i>Inactive
                        </a>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center" style="gap: 6px;">
                            <a href="/superadmin/super-addothers-banner/{{$item->pid}}" class="btn btn-sm btn-outline-warning" title="Promotional Banner" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-panorama"></i>
                            </a>
                            <a href="/superadmin/super-edit-others-details/{{$item->id}}" class="btn btn-sm btn-outline-primary" title="Edit Profile Details" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="javascript:void(0)" data-target="#myDeleteModal{{$item->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" title="Delete Profile" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </td>

                    <td>
                        <span class="badge badge-light border text-monospace font-weight-bold" style="font-size: 0.82rem; color: #0d9488;">
                            #{{ $item->partner_id }}
                        </span>
                    </td>

                    <td>
                        <div class="font-weight-bold text-dark text-capitalize" style="font-size: 0.9rem;">
                            <i class="fa-solid fa-hospital-user text-teal mr-1" style="font-size: 0.85rem; color: #0d9488;"></i>
                            {{ $item->partner_clinic_name }}
                        </div>
                        <small class="text-muted"><i class="fa-solid fa-fingerprint mr-1"></i>PID: {{ $item->pid }}</small>
                    </td>

                    <td>
                        <div class="font-weight-bold text-dark text-capitalize" style="font-size: 0.92rem;">
                            <i class="fa-solid fa-user-doctor text-info mr-1"></i>
                            {{ $item->partner_doctor_name }}
                        </div>
                        <div class="mt-1">
                            <span class="badge badge-light border font-weight-bold px-2 py-0" style="font-size: 0.75rem; color: #0d9488; border-color: #99f6e4 !important; background: #f0fdfa;">
                                {{ $item->partner_doctor_specialist ?? 'Physiotherapist' }}
                            </span>
                            @if($item->partner_doctor_designation)
                                <small class="text-muted ml-1 font-weight-bold">({{ $item->partner_doctor_designation }})</small>
                            @endif
                        </div>
                        @if($item->partner_doctor_fees)
                            <div class="small font-weight-bold text-success mt-1">₹{{ $item->partner_doctor_fees }} <span class="text-muted font-weight-normal">(Fee)</span></div>
                        @endif
                    </td>

                    <td>
                        @if($item->partner_doctor_mobile)
                            <a href="tel:{{ $item->partner_doctor_mobile }}" class="text-dark font-weight-bold d-block" style="font-size: 0.85rem; text-decoration: none;">
                                <i class="fa-solid fa-phone text-success mr-1" style="font-size: 0.75rem;"></i>{{ $item->partner_doctor_mobile }}
                            </a>
                        @endif
                        @if($item->partner_doctor_email)
                            <small class="text-muted"><i class="fa-solid fa-envelope mr-1"></i>{{ $item->partner_doctor_email }}</small>
                        @endif
                    </td>

                    <td>
                        <div class="text-dark font-weight-bold" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-location-dot text-danger mr-1" style="font-size: 0.75rem;"></i>
                            {{ $item->partner_doctor_city }}, {{ $item->partner_doctor_state }}
                        </div>
                        <small class="text-muted">{{ Str::limit($item->partner_doctor_address, 35) }} ({{ $item->partner_doctor_pincode }})</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-hand-holding-medical fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                            <h5>No Physiotherapy & Allied Care Partners Found</h5>
                            <p class="small mb-0">No active or registered profiles in the database.</p>
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
            Showing {{ $others->firstItem() ?? 0 }} to {{ $others->lastItem() ?? 0 }} of {{ $others->total() }} providers
        </div>
        <div>
            {{ $others->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Status Toggle Modals -->
@foreach ($others as $item)
<div class="modal fade" id="myActiveInactiveModal{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1rem;">
                    <i class="fa-solid fa-toggle-on text-primary mr-2"></i>Update Provider Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.status.others.edit', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Provider: <strong>{{ $item->partner_doctor_name }}</strong></p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark small mb-2">Availability Status</label>
                        <select name="status" class="form-control" style="height: 44px; border-radius: 8px;">
                            <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active (Available for Appointments)</option>
                            <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive (Unavailable)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-secondary font-weight-bold px-3" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4" style="border-radius: 8px; background: #0d9488; border-color: #0d9488;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Modals -->
@foreach($others as $item)
<div class="modal fade" id="myDeleteModal{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{ route('superadmin.others.contact.delete', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Delete Provider Profile?</h5>
                    <p class="text-muted small mb-1">Are you sure you want to delete <strong>{{ $item->partner_doctor_name }}</strong>?</p>
                    <p class="text-danger small mb-0 font-weight-bold">This will remove this profile and associated schedules.</p>
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

@endsection
