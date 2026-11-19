@extends('layouts.superadmin')

@section('title', 'All Pathology Centers | Doctorwala Super Admin')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #fef3c7; color: #d97706;">
                <i class="fa-solid fa-flask-vial fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Pathology & Diagnostic Labs</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Manage diagnostic labs, test packages, sample collection & pricing</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
        <span class="badge badge-light border font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.88rem; color: #d97706;">
            <i class="fa-solid fa-vial-virus mr-1"></i> Total Labs: {{ number_format($paths->total()) }}
        </span>
        <a href="{{ route('superadmin.export.path') }}" class="btn btn-outline-success font-weight-bold shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-file-excel mr-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Pathology Table Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Registered Pathology Labs</h5>
            <small class="text-muted">Showing {{ $paths->firstItem() ?? 0 }} - {{ $paths->lastItem() ?? 0 }} of {{ $paths->total() }} labs</small>
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
                    <th>Lab / Center Name</th>
                    <th>Contact Person</th>
                    <th>Contact Info</th>
                    <th>Location Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paths as $path)
                <tr>
                    <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                        {{ ($paths->currentPage() - 1) * $paths->perPage() + $loop->iteration }}
                    </td>

                    <td>
                        @if($path->status == 'Active')
                        <a href="javascript:void(0)" data-target="#myActiveInactiveModal{{$path->id}}" data-toggle="modal" class="badge badge-success px-2 py-1 shadow-xs" title="Click to change status" style="font-size: 0.78rem; text-decoration: none;">
                            <i class="fa-solid fa-circle-check mr-1"></i>Active
                        </a>
                        @else
                        <a href="javascript:void(0)" data-target="#myActiveInactiveModal{{$path->id}}" data-toggle="modal" class="badge badge-danger px-2 py-1 shadow-xs" title="Click to activate" style="font-size: 0.78rem; text-decoration: none;">
                            <i class="fa-solid fa-circle-xmark mr-1"></i>Inactive
                        </a>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center" style="gap: 6px;">
                            <a href="/superadmin/super-addpath-test/{{$path->pid}}" class="btn btn-sm btn-outline-success" title="Add Diagnostic Test" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-vial-circle-check"></i>
                            </a>
                            <a href="/superadmin/super-edit-pathology-details/{{$path->id}}" class="btn btn-sm btn-outline-primary" title="Edit Lab Details" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="javascript:void(0)" data-target="#myDeleteModal{{$path->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" title="Delete Lab" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </td>

                    <td>
                        <span class="badge badge-light border text-monospace font-weight-bold" style="font-size: 0.82rem; color: #d97706;">
                            #{{ $path->partner_id }}
                        </span>
                    </td>

                    <td>
                        <div class="font-weight-bold text-dark text-capitalize" style="font-size: 0.92rem;">
                            <i class="fa-solid fa-flask-vial text-warning mr-1" style="font-size: 0.85rem;"></i>
                            {{ $path->clinic_name }}
                        </div>
                        <small class="text-muted"><i class="fa-solid fa-fingerprint mr-1"></i>PID: {{ $path->pid }}</small>
                    </td>

                    <td>
                        <div class="font-weight-bold text-capitalize" style="font-size: 0.88rem; color: #334155;">
                            {{ $path->clinic_contact_person_name }}
                        </div>
                    </td>

                    <td>
                        @if($path->clinic_mobile_number)
                            <a href="tel:{{ $path->clinic_mobile_number }}" class="text-dark font-weight-bold d-block" style="font-size: 0.85rem; text-decoration: none;">
                                <i class="fa-solid fa-phone text-success mr-1" style="font-size: 0.75rem;"></i>{{ $path->clinic_mobile_number }}
                            </a>
                        @endif
                        @if($path->clinic_email)
                            <small class="text-muted"><i class="fa-solid fa-envelope mr-1"></i>{{ $path->clinic_email }}</small>
                        @endif
                    </td>

                    <td>
                        <div class="text-dark font-weight-bold" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-location-dot text-danger mr-1" style="font-size: 0.75rem;"></i>
                            {{ $path->clinic_city }}, {{ $path->clinic_state }}
                        </div>
                        <small class="text-muted">{{ Str::limit($path->clinic_address, 35) }} ({{ $path->clinic_pincode }})</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-flask fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                            <h5>No Pathology Labs Found</h5>
                            <p class="small mb-0">No active or registered diagnostic lab records in the database.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="doc-card-footer d-flex justify-content-between align-items-center flex-wrap">
        <div class="text-muted small mb-2 mb-md-0">
            Showing {{ $paths->firstItem() ?? 0 }} to {{ $paths->lastItem() ?? 0 }} of {{ $paths->total() }} labs
        </div>
        <div>
            {{ $paths->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Status Toggle Modals -->
@foreach ($paths as $path)
<div class="modal fade" id="myActiveInactiveModal{{$path->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1rem;">
                    <i class="fa-solid fa-toggle-on text-primary mr-2"></i>Update Lab Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.status.path.edit', $path->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Lab: <strong>{{ $path->clinic_name }}</strong></p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark small mb-2">Diagnostic Center Status</label>
                        <select name="status" class="form-control" style="height: 44px; border-radius: 8px;">
                            <option value="Active" {{ $path->status == 'Active' ? 'selected' : '' }}>Active (Visible to Patients)</option>
                            <option value="Inactive" {{ $path->status == 'Inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
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
@foreach($paths as $path)
<div class="modal fade" id="myDeleteModal{{$path->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{route('superadmin.path.contact.delete', $path->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Delete Pathology Lab?</h5>
                    <p class="text-muted small mb-1">Are you sure you want to delete <strong>{{ $path->clinic_name }}</strong>?</p>
                    <p class="text-danger small mb-0 font-weight-bold">This will remove the lab and unlink tests and sample packages.</p>
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
