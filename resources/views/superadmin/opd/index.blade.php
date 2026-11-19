@extends('layouts.superadmin')

@section('title', 'All OPD Facilities | Doctorwala Super Admin')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-stethoscope fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">OPD Chambers & Clinics</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Manage Out-Patient Department facilities, doctor chambers & schedules</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
        <span class="badge badge-light border font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.88rem; color: #0284c7;">
            <i class="fa-solid fa-hospital mr-1"></i> Total OPDs: {{ number_format($opds->total()) }}
        </span>
        <a href="{{ route('superadmin.export.opd') }}" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-file-excel mr-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Filter Bar Card -->
<div class="filter-card">
    <form action="{{ route('superadmin.super-all-opd') }}" method="GET" class="row align-items-end g-2">
        <div class="col-12 col-md-4 mb-2">
            <label><i class="fa-solid fa-magnifying-glass text-primary mr-1"></i> Search OPD Clinics</label>
            <input type="search" name="search" class="form-control" placeholder="Clinic name, contact, city, phone..." value="{{ request('search') }}">
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
            <button type="submit" class="btn btn-primary font-weight-bold flex-fill mr-1" style="height: 42px; border-radius: 8px;">
                <i class="fa fa-filter mr-1"></i> Filter
            </button>
            @if(request('from_date') || request('to_date') || request('status') || request('search'))
                <a href="{{ route('superadmin.super-all-opd') }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="height: 42px; width: 42px; border-radius: 8px;" title="Reset Filters">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- OPD Table Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Registered OPD Clinics</h5>
            <small class="text-muted">Showing {{ $opds->firstItem() ?? 0 }} - {{ $opds->lastItem() ?? 0 }} of {{ $opds->total() }} clinics</small>
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
                    <th>Clinic / Center Name</th>
                    <th>Contact Person</th>
                    <th>Contact Info</th>
                    <th>Location Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opds as $opd)
                <tr>
                    <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                        {{ ($opds->currentPage() - 1) * $opds->perPage() + $loop->iteration }}
                    </td>

                    <td>
                        @if($opd->status == 'Active')
                        <a href="javascript:void(0)" data-target="#myActiveInactiveModal{{$opd->id}}" data-toggle="modal" class="badge badge-success px-2 py-1 shadow-xs" title="Click to change status" style="font-size: 0.78rem; text-decoration: none;">
                            <i class="fa-solid fa-circle-check mr-1"></i>Active
                        </a>
                        @else
                        <a href="javascript:void(0)" data-target="#myActiveInactiveModal{{$opd->id}}" data-toggle="modal" class="badge badge-danger px-2 py-1 shadow-xs" title="Click to activate" style="font-size: 0.78rem; text-decoration: none;">
                            <i class="fa-solid fa-circle-xmark mr-1"></i>Inactive
                        </a>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center" style="gap: 6px;">
                            <a href="/superadmin/super-addopd-doctor/{{$opd->pid}}" class="btn btn-sm btn-outline-success" title="Add Doctor to OPD" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-user-plus"></i>
                            </a>
                            <a href="/superadmin/super-edit-opd-details/{{$opd->id}}" class="btn btn-sm btn-outline-primary" title="Edit OPD Details" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="javascript:void(0)" data-target="#myDeleteModal{{$opd->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" title="Delete OPD" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </td>

                    <td>
                        <span class="badge badge-light border text-monospace font-weight-bold" style="font-size: 0.82rem; color: #0284c7;">
                            #{{ $opd->partner_id }}
                        </span>
                    </td>

                    <td>
                        <div class="font-weight-bold text-dark text-capitalize" style="font-size: 0.92rem;">
                            <i class="fa-solid fa-clinic-medical text-primary mr-1" style="font-size: 0.85rem;"></i>
                            {{ $opd->clinic_name }}
                        </div>
                        <small class="text-muted"><i class="fa-solid fa-fingerprint mr-1"></i>PID: {{ $opd->pid }}</small>
                    </td>

                    <td>
                        <div class="font-weight-bold text-capitalize" style="font-size: 0.88rem; color: #334155;">
                            {{ $opd->clinic_contact_person_name }}
                        </div>
                    </td>

                    <td>
                        @if($opd->clinic_mobile)
                            <a href="tel:{{ $opd->clinic_mobile }}" class="text-dark font-weight-bold d-block" style="font-size: 0.85rem; text-decoration: none;">
                                <i class="fa-solid fa-phone text-success mr-1" style="font-size: 0.75rem;"></i>{{ $opd->clinic_mobile }}
                            </a>
                        @endif
                        @if($opd->clinic_email)
                            <small class="text-muted"><i class="fa-solid fa-envelope mr-1"></i>{{ $opd->clinic_email }}</small>
                        @endif
                    </td>

                    <td>
                        <div class="text-dark font-weight-bold" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-location-dot text-danger mr-1" style="font-size: 0.75rem;"></i>
                            {{ $opd->clinic_city }}, {{ $opd->clinic_state }}
                        </div>
                        <small class="text-muted">{{ Str::limit($opd->clinic_address, 35) }} ({{ $opd->clinic_pincode }})</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-stethoscope fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                            <h5>No OPD Clinics Found</h5>
                            <p class="small mb-0">No active or registered OPD chamber records in the database.</p>
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
            Showing {{ $opds->firstItem() ?? 0 }} to {{ $opds->lastItem() ?? 0 }} of {{ $opds->total() }} clinics
        </div>
        <div>
            {{ $opds->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Status Toggle Modals -->
@foreach ($opds as $opd)
<div class="modal fade" id="myActiveInactiveModal{{$opd->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1rem;">
                    <i class="fa-solid fa-toggle-on text-primary mr-2"></i>Update OPD Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.status.opd.edit', $opd->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Clinic: <strong>{{ $opd->clinic_name }}</strong></p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark small mb-2">Clinic Status</label>
                        <select name="status" class="form-control" style="height: 44px; border-radius: 8px;">
                            <option value="Active" {{ $opd->status == 'Active' ? 'selected' : '' }}>Active (Visible to Patients)</option>
                            <option value="Inactive" {{ $opd->status == 'Inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
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
@foreach($opds as $opd)
<div class="modal fade" id="myDeleteModal{{$opd->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{route('superadmin.opd.contact.delete', $opd->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Delete OPD Clinic?</h5>
                    <p class="text-muted small mb-1">Are you sure you want to delete <strong>{{ $opd->clinic_name }}</strong>?</p>
                    <p class="text-danger small mb-0 font-weight-bold">This will remove the clinic and unlink associated doctors.</p>
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
