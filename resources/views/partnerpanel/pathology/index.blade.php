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

<!-- Filter Bar Card -->
<div class="filter-card">
    <form action="{{ route('partner.pathology.show') }}" method="GET" class="row align-items-end g-2">
        <div class="col-12 col-md-4 mb-2">
            <label><i class="fa-solid fa-magnifying-glass text-warning mr-1"></i> Search Diagnostic Test</label>
            <input type="text" name="search" class="form-control" placeholder="Test name, category, notes..." value="{{ request('search') }}">
        </div>
        <div class="col-6 col-md-2 mb-2">
            <label><i class="fa-solid fa-toggle-on text-warning mr-1"></i> Status</label>
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="Available" {{ request('status') === 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Unavailable" {{ request('status') === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>
        <div class="col-6 col-md-2 mb-2">
            <label><i class="fa-regular fa-calendar text-warning mr-1"></i> From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-6 col-md-2 mb-2">
            <label><i class="fa-regular fa-calendar text-warning mr-1"></i> To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
        <div class="col-6 col-md-2 mb-2 d-flex">
            <button type="submit" class="btn btn-warning text-white flex-grow-1 mr-1 font-weight-bold" style="border-radius: 8px;">
                <i class="fa-solid fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('partner.pathology.show') }}" class="btn btn-outline-secondary font-weight-bold" style="border-radius: 8px;" title="Reset Filters">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>
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
    <div class="table-pagination-footer d-flex justify-content-between align-items-center flex-wrap">
        <div class="text-muted small mb-2 mb-md-0">
            Showing <b>{{ $storedData->firstItem() ?? 0 }}</b> to <b>{{ $storedData->lastItem() ?? 0 }}</b> of <b>{{ $storedData->total() }}</b> tests
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
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 560px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header border-0 py-3 px-3 px-sm-4" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-bottom: 1px solid #fed7aa;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-xs" style="width: 42px; height: 42px; background: #ffffff; color: #d97706; font-size: 1.15rem; border: 1px solid #fde68a;">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0" style="font-size: 1.05rem;">Edit Diagnostic Test</h5>
                        <small class="text-muted font-weight-bold" style="font-size: 0.82rem;">
                            {{ $data->test_name }} • <span class="text-warning" style="color: #d97706 !important;">{{ $data->test_type ?: 'General Test' }}</span>
                        </small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 0.7; transition: opacity 0.2s;">
                    <span aria-hidden="true" style="font-size: 1.4rem;">&times;</span>
                </button>
            </div>

            <form action="{{ route('partner.pathology.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-3 p-sm-4" style="background: #ffffff; max-height: calc(85vh - 120px); overflow-y: auto;">
                    <!-- Section 1: Test Details & Pricing -->
                    <div class="mb-3 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <i class="fa-solid fa-microscope text-warning mr-2"></i>
                            <h6 class="font-weight-bold text-dark mb-0" style="font-size: 0.9rem;">Test Details & Pricing</h6>
                        </div>

                        <div class="row g-2">
                            <div class="col-sm-6 form-group mb-2">
                                <label class="font-weight-bold small text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-toggle-on text-primary mr-1"></i> Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-control font-weight-bold" name="status" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.88rem;">
                                    <option value="Available" {{ $data->status == 'Available' ? 'selected' : '' }}>🟢 Available</option>
                                    <option value="Unavailable" {{ $data->status == 'Unavailable' ? 'selected' : '' }}>🔴 Unavailable</option>
                                </select>
                            </div>

                            <div class="col-sm-6 form-group mb-2">
                                <label class="font-weight-bold small text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-tags text-primary mr-1"></i> Specimen Category
                                </label>
                                <input type="text" class="form-control font-weight-bold" name="test_type" value="{{ $data->test_type }}" placeholder="e.g. Blood, Urine, Imaging" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.88rem;">
                            </div>

                            <div class="col-12 form-group mb-2">
                                <label class="font-weight-bold small text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-flask-vial text-warning mr-1"></i> Diagnostic Test Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control font-weight-bold" name="test_name" value="{{ $data->test_name }}" required placeholder="e.g. Complete Blood Count (CBC)" style="height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.9rem;">
                            </div>

                            <div class="col-12 form-group mb-0">
                                <label class="font-weight-bold small text-muted text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-indian-rupee-sign text-success mr-1"></i> Test Price (₹) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0" style="border-radius: 8px 0 0 8px; border-color: #cbd5e1; font-weight: bold; color: #16a34a; font-size: 0.88rem;">₹</span>
                                    </div>
                                    <input type="number" step="1" class="form-control border-left-0 font-weight-bold" name="test_price" value="{{ $data->test_price }}" required style="height: 40px; border-radius: 0 8px 8px 0; border-color: #cbd5e1; font-size: 0.9rem;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Sample Collection Schedules -->
                    <div class="p-3 rounded" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="fa-regular fa-clock text-warning mr-2"></i>
                                <h6 class="font-weight-bold text-dark mb-0" style="font-size: 0.9rem;">Collection Timings</h6>
                            </div>
                            <button type="button" class="btn btn-xs btn-outline-warning font-weight-bold" onclick="addPathologyScheduleSlot('{{ $data->id }}')" style="border-radius: 6px; padding: 3px 8px; font-size: 0.78rem; color: #d97706; border-color: #f59e0b;">
                                <i class="fa-solid fa-plus mr-1"></i> Add Slot
                            </button>
                        </div>

                        <div id="pathologyScheduleContainer{{ $data->id }}">
                            @php
                                $slots = is_array($data->test_day_time) && count($data->test_day_time) > 0 
                                    ? $data->test_day_time 
                                    : [['day' => 'All Day', 'start_time' => '08:00', 'end_time' => '12:00']];
                            @endphp

                            @foreach($slots as $index => $test)
                            <div class="schedule-slot-card p-2 mb-2 rounded border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small font-weight-bold text-muted" style="font-size: 0.75rem;">
                                        <i class="fa-regular fa-calendar-check text-warning mr-1"></i> Slot #{{ $loop->iteration }}
                                    </span>
                                    <button type="button" class="btn btn-sm text-danger p-0 border-0" onclick="removePathologySlot(this)" title="Remove Slot" style="font-size: 0.75rem; background: transparent;">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Remove
                                    </button>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-sm-5 mb-1 mb-sm-0">
                                        @php $currentDay = $test['day'] ?? 'All Day'; @endphp
                                        <select class="form-control font-weight-bold" name="test_day[]" style="height: 38px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.82rem;">
                                            <option value="All Day" {{ $currentDay == 'All Day' ? 'selected' : '' }}>🗓️ All Day</option>
                                            <option value="Monday" {{ $currentDay == 'Monday' ? 'selected' : '' }}>Monday</option>
                                            <option value="Tuesday" {{ $currentDay == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                            <option value="Wednesday" {{ $currentDay == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                            <option value="Thursday" {{ $currentDay == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                            <option value="Friday" {{ $currentDay == 'Friday' ? 'selected' : '' }}>Friday</option>
                                            <option value="Saturday" {{ $currentDay == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                            <option value="Sunday" {{ $currentDay == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <input type="time" class="form-control font-weight-bold text-center px-1" name="test_start_time[]" value="{{ $test['start_time'] ?? '08:00' }}" style="height: 38px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.82rem;">
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <input type="time" class="form-control font-weight-bold text-center px-1" name="test_end_time[]" value="{{ $test['end_time'] ?? '12:00' }}" style="height: 38px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.82rem;">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0 py-3 px-3 px-sm-4 d-flex justify-content-between align-items-center" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-light border font-weight-bold px-3 py-2" data-dismiss="modal" style="border-radius: 8px; font-size: 0.88rem;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-3 py-2 shadow-sm" style="border-radius: 8px; font-size: 0.88rem; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Save Changes
                    </button>
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

@push('scripts')
<script>
    function addPathologyScheduleSlot(testId) {
        var container = document.getElementById('pathologyScheduleContainer' + testId);
        if (!container) return;

        var slotCard = document.createElement('div');
        slotCard.className = 'schedule-slot-card p-3 mb-2 rounded border';
        slotCard.style = 'background: #f8fafc; border-color: #e2e8f0 !important;';
        slotCard.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted mb-1 d-block">
                        <i class="fa-regular fa-calendar text-warning mr-1"></i> Collection Day
                    </label>
                    <select class="form-control font-weight-bold" name="test_day[]" style="height: 42px; border-radius: 6px; border: 1px solid #cbd5e1;">
                        <option value="All Day" selected>🗓️ All Day (Everyday)</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="col-5 col-md-3 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted mb-1 d-block">
                        <i class="fa-regular fa-clock text-warning mr-1"></i> From Time
                    </label>
                    <input type="time" class="form-control font-weight-bold" name="test_start_time[]" value="08:00" style="height: 42px; border-radius: 6px; border: 1px solid #cbd5e1;">
                </div>
                <div class="col-5 col-md-3 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted mb-1 d-block">
                        <i class="fa-regular fa-clock text-warning mr-1"></i> To Time
                    </label>
                    <input type="time" class="form-control font-weight-bold" name="test_end_time[]" value="12:00" style="height: 42px; border-radius: 6px; border: 1px solid #cbd5e1;">
                </div>
                <div class="col-2 col-md-2 text-right pt-md-3">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePathologySlot(this)" title="Remove Slot" style="border-radius: 6px; height: 38px; width: 38px; padding: 0;">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(slotCard);
    }

    function removePathologySlot(btn) {
        var card = btn.closest('.schedule-slot-card');
        var container = card.parentElement;
        if (container.querySelectorAll('.schedule-slot-card').length > 1) {
            card.remove();
        } else {
            alert('At least one collection schedule slot is required.');
        }
    }
</script>
@endpush

@endsection
