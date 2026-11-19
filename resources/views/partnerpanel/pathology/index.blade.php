@extends('layouts.partner')

@section('title', 'Pathology Tests List | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-7 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #fef3c7; color: #d97706;">
                <i class="fa-solid fa-flask-vial fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Pathology & Diagnostic Tests</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Manage your laboratory test catalog, sample collection schedules & test prices</p>
            </div>
        </div>
    </div>
    <div class="col-md-5 text-md-right d-flex justify-content-md-end align-items-center flex-wrap" style="gap: 10px;">
        <span class="badge badge-light border font-weight-bold px-3 py-2 shadow-xs" style="border-radius: 8px; font-size: 0.88rem; color: #d97706;">
            <i class="fa-solid fa-vial mr-1"></i> Total Tests: {{ $allpaths ?? $storedData->total() }}
        </span>
        <a href="/partnerpanel/partner-pathology" class="btn btn-warning font-weight-bold text-white shadow-sm" style="border-radius: 8px; padding: 9px 18px;">
            <i class="fa-solid fa-plus-circle mr-2"></i>Add Diagnostic Test
        </a>
    </div>
</div>

<!-- Pathology Test List Card -->
<div class="doc-card">
    <div class="doc-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="doc-card-title mb-0">Lab Test Directory</h5>
            <small class="text-muted">Showing {{ $storedData->firstItem() ?? 0 }} - {{ $storedData->lastItem() ?? 0 }} of {{ $storedData->total() }} diagnostic tests</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table doc-table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">SL</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Diagnostic Test</th>
                    <th>Category / Type</th>
                    <th>Collection Days & Hours</th>
                    <th>Price (₹)</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($storedData as $data)
                <tr>
                    <td class="font-weight-bold text-muted" style="font-size: 0.85rem;">
                        {{ ($storedData->currentPage() - 1) * $storedData->perPage() + $loop->iteration }}
                    </td>

                    <td>
                        @if($data->status == 'Available')
                            <span class="badge badge-success px-2 py-1 shadow-xs" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-circle-check mr-1"></i>Available
                            </span>
                        @else
                            <span class="badge badge-danger px-2 py-1 shadow-xs" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-circle-xmark mr-1"></i>Unavailable
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center" style="gap: 6px;">
                            <a href="javascript:void(0)" data-target="#myEditModal{{ $data->id }}" data-toggle="modal" class="btn btn-sm btn-outline-primary" title="Edit Test" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="javascript:void(0)" data-target="#myDeleteModal{{ $data->id }}" data-toggle="modal" class="btn btn-sm btn-outline-danger" title="Delete" style="border-radius: 6px; padding: 4px 8px;">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </td>

                    <td>
                        <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                            <i class="fa-solid fa-flask-vial text-warning mr-1"></i>
                            {{ $data->test_name }}
                        </div>
                    </td>

                    <td>
                        <span class="badge badge-light border text-dark font-weight-bold px-2 py-1" style="font-size: 0.8rem;">
                            {{ $data->test_type ?? 'Diagnostic' }}
                        </span>
                    </td>

                    <td>
                        <div style="font-size: 0.82rem;">
                            @foreach($data->test_day_time as $test)
                                <div class="mb-1">
                                    <span class="font-weight-bold text-dark"><i class="fa-regular fa-clock text-warning mr-1"></i>{{ $test['day'] }}:</span>
                                    <span class="text-muted">{{ $test['start_time'] }} - {{ $test['end_time'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </td>

                    <td>
                        <span class="font-weight-bold text-success" style="font-size: 0.92rem;">
                            ₹ {{ number_format($data->test_price ?? 0) }}
                        </span>
                    </td>

                    <td>
                        <span class="text-dark font-weight-bold" style="font-size: 0.82rem;">
                            {{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('d M, Y') : 'N/A' }}
                        </span>
                        <br>
                        <small class="text-muted">{{ $data->updated_at ? \Carbon\Carbon::parse($data->updated_at)->format('h:i A') : '' }}</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-flask fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                            <h5>No Pathology Tests Listed</h5>
                            <p class="small mb-0">You have not listed any diagnostic or pathology tests yet.</p>
                            <a href="/partnerpanel/partner-pathology" class="btn btn-sm btn-warning text-white mt-3">
                                <i class="fa-solid fa-plus-circle mr-1"></i> Add Test Now
                            </a>
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
            Showing {{ $storedData->firstItem() ?? 0 }} to {{ $storedData->lastItem() ?? 0 }} of {{ $storedData->total() }} tests
        </div>
        <div>
            {{ $storedData->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Edit Modals -->
@foreach($storedData as $data)
<div class="modal fade" id="myEditModal{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header bg-light border-0 py-3">
                <h5 class="modal-title font-weight-bold text-dark" style="font-size: 1.05rem;">
                    <i class="fa-solid fa-pen-to-square text-warning mr-2"></i>Edit Diagnostic Test
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('partner.pathology.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-toggle-on text-primary mr-1"></i> Test Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" style="height: 44px; border-radius: 8px;">
                                <option value="Available" {{ $data->status == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Unavailable" {{ $data->status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-flask-vial text-warning mr-1"></i> Test Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="test_name" value="{{ $data->test_name }}" required style="height: 44px; border-radius: 8px;">
                        </div>

                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-tags text-primary mr-1"></i> Test Category</label>
                            <input type="text" class="form-control" name="test_type" value="{{ $data->test_type }}" placeholder="e.g. Blood, Urine, Imaging" style="height: 44px; border-radius: 8px;">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark"><i class="fa-solid fa-indian-rupee-sign text-primary mr-1"></i> Test Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="test_price" value="{{ $data->test_price }}" required style="height: 44px; border-radius: 8px;">
                        </div>
                    </div>

                    <h6 class="font-weight-bold text-dark mt-3 mb-2">
                        <i class="fa-regular fa-clock text-warning mr-1"></i> Sample Collection Schedules
                    </h6>

                    @foreach($data->test_day_time as $index => $test)
                    <div class="p-3 mb-2 rounded border bg-light">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <label class="small font-weight-bold text-dark mb-1">Collection Day</label>
                                <select class="form-control" name="test_day[]" style="height: 40px; border-radius: 6px;">
                                    <option value="{{ $test['day'] }}" selected>{{ $test['day'] }}</option>
                                    <option value="All Day">All Day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small font-weight-bold text-dark mb-1">From Time</label>
                                <input type="time" class="form-control" name="test_start_time[]" value="{{ $test['start_time'] }}" style="height: 40px; border-radius: 6px;">
                            </div>
                            <div class="col-md-4">
                                <label class="small font-weight-bold text-dark mb-1">To Time</label>
                                <input type="time" class="form-control" name="test_end_time[]" value="{{ $test['end_time'] }}" style="height: 40px; border-radius: 6px;">
                            </div>
                        </div>
                    </div>
                    @endforeach
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
@foreach($storedData as $data)
<div class="modal fade" id="myDeleteModal{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{ route('partner.pathology.delete', $data->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Delete Diagnostic Test?</h5>
                    <p class="text-muted small mb-1">Are you sure you want to delete <strong>{{ $data->test_name }}</strong>?</p>
                    <p class="text-danger small mb-0 font-weight-bold">This will remove this test from patient view on the app.</p>
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
