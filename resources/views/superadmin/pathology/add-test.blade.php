@extends('layouts.superadmin')

@section('title', 'Manage Pathology Tests & Banner | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-flask-vial text-primary mr-2"></i>Pathology Tests & Lab Banner
            </h3>
            <p class="text-muted mb-0">Partner ID: <span class="badge badge-primary px-2 py-1 font-weight-bold">#{{ $pid }}</span> &bull; Manage lab investigations, pricing, timings, and promotional banner.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/superadmin/super-all-pathology" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to All Pathology Labs
            </a>
        </div>
    </div>
</div>

<!-- Banner Upload Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-image text-primary mr-2"></i>Pathology Lab Banner
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('superadmin.super-addpath.banner') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currently_loggedin_partner_id" value="{{ $pid }}">

            <div class="row align-items-center">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    @if($pathBanner && isset($pathBanner->pathologybanner))
                        <img src="{{ asset('storage/' . $pathBanner->pathologybanner) }}" alt="Pathology Banner" class="img-fluid rounded shadow-sm" style="max-height: 140px; border: 1px solid #e2e8f0; object-fit: cover;">
                        <div class="small text-muted mt-1">Current Active Banner</div>
                    @else
                        <div class="rounded p-4 d-flex flex-column align-items-center justify-content-center text-muted" style="background: #f8fafc; border: 2px dashed #cbd5e1; height: 140px;">
                            <i class="fa-solid fa-image fa-2x mb-2 text-secondary"></i>
                            <span class="small">No banner uploaded yet</span>
                        </div>
                    @endif
                </div>

                <div class="col-md-5 mb-3 mb-md-0">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-upload text-primary mr-1"></i> Upload New Banner</label>
                    <input type="file" class="form-control" name="pathologybanner" style="height: 48px; border-radius: 8px;" accept="image/*" required>
                    <small class="text-muted">Recommended: 1200x500 px (JPEG, PNG, JPG, Max 2MB).</small>
                </div>

                <div class="col-md-3 text-md-right">
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2 shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Update Banner
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Test Form Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-vials text-primary mr-2"></i>Add Pathology Test / Investigation
        </h5>
    </div>
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('superadmin.super-addpath.test') }}" method="POST">
            @csrf
            <input type="hidden" name="currently_loggedin_partner_id" value="{{ $pid }}">

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-syringe text-primary mr-1"></i> Test Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="test_name" placeholder="e.g. Complete Blood Count (CBC)" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa fa-sitemap text-primary mr-1"></i> Test Category / Type <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="test_type" placeholder="e.g. Hematology, Biochemistry" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-4 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa fa-indian-rupee-sign text-primary mr-1"></i> Test Price (₹) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="test_price" placeholder="₹ Amount" style="height: 48px; border-radius: 8px;" required>
                </div>
            </div>

            <!-- Schedule Repeater -->
            <div class="p-3 mb-4 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-weight-bold text-dark mb-0">
                        <i class="fa-solid fa-calendar-days text-primary mr-1"></i> Sample Collection / Test Timing <span class="text-danger">*</span>
                    </label>
                    <button type="button" id="add-schedule-btn" class="btn btn-sm btn-outline-primary font-weight-bold" style="border-radius: 6px;">
                        <i class="fa-solid fa-plus mr-1"></i> Add Another Slot
                    </button>
                </div>
                <div id="schedule-container">
                    <div class="row align-items-end mb-2 schedule-row">
                        <div class="col-md-4 form-group mb-2">
                            <label class="small font-weight-bold text-muted">Operating Day</label>
                            <select name="test_day[]" class="form-control" style="height: 44px; border-radius: 6px;" required>
                                <option value="All Day">All Days</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                                <option value="None">None</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-2">
                            <label class="small font-weight-bold text-muted">Start Time</label>
                            <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="test_start_time[]" required>
                        </div>
                        <div class="col-md-3 form-group mb-2">
                            <label class="small font-weight-bold text-muted">End Time</label>
                            <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="test_end_time[]" required>
                        </div>
                        <div class="col-md-2 form-group mb-2">
                            <span class="text-muted small d-block mb-1">&nbsp;</span>
                            <span class="badge badge-light px-2 py-2 text-muted" style="border: 1px solid #e2e8f0; display: block; text-align: center;">Primary</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-plus mr-1"></i> Save Pathology Test
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tests List Card -->
<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-list-check text-primary mr-2"></i>Offered Tests in this Pathology Lab
            <span class="badge badge-secondary ml-2">{{ count($pathTests) }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Test Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Category</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Price</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Schedule</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pathTests as $pathTest)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">{{ $loop->iteration }}</td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $pathTest->test_name }}
                        </td>
                        <td class="py-3 px-3">
                            <span class="badge badge-info px-2 py-1 font-weight-bold" style="background: #e0f2fe; color: #0369a1; border-radius: 6px;">
                                {{ $pathTest->test_type }}
                            </span>
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-success">
                            ₹ {{ number_format($pathTest->test_price, 2) }}
                        </td>
                        <td class="py-3 px-3">
                            @if(!empty($pathTest->test_day_time) && is_array($pathTest->test_day_time))
                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                @foreach($pathTest->test_day_time as $visit)
                                    <span class="badge badge-light px-2 py-1 font-weight-bold" style="border: 1px solid #cbd5e1; font-size: 0.78rem;">
                                        <i class="fa-regular fa-clock text-primary mr-1"></i>{{ $visit['day'] }}: {{ $visit['start_time'] }} - {{ $visit['end_time'] }}
                                    </span>
                                @endforeach
                                </div>
                            @else
                                <span class="text-muted small">No schedule set</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($pathTest->status == 'Available')
                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 6px;">Available</span>
                            @else
                                <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 6px;">Unavailable</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="d-flex justify-content-center" style="gap: 8px;">
                                <button type="button" data-target="#myActiveInactiveModal{{$pathTest->id}}" data-toggle="modal" class="btn btn-sm btn-outline-info" style="border-radius: 6px; padding: 4px 8px;" title="Change Status">
                                    <i class="fa-solid fa-sliders"></i>
                                </button>
                                <button type="button" data-target="#myDeleteModal{{ $pathTest->id }}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Test">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-vials fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Tests Configured in this Lab</h5>
                            <p class="text-muted small mb-0">Use the form above to register blood tests, scans, and diagnostic procedures.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Status Modals -->
@foreach ($pathTests as $pathTest)
<div class="modal fade" id="myActiveInactiveModal{{$pathTest->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-sliders text-primary mr-2"></i>Change Test Availability
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.status.pathTest.edit', $pathTest->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted">Update status for <b>{{ $pathTest->test_name }}</b>:</p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Select Availability <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" style="height: 48px; border-radius: 8px;" required>
                            <option value="Available" {{ $pathTest->status == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Unavailable" {{ $pathTest->status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">Save Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Modals -->
@foreach ($pathTests as $pathTest)
<div class="modal fade" id="myDeleteModal{{ $pathTest->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.super-deletepath.test', $pathTest->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                    </div>
                    <h4 class="font-weight-bold text-dark">Delete Test Record?</h4>
                    <p class="text-muted mb-4">Are you sure you want to remove <b>{{ $pathTest->test_name }}</b>? This cannot be undone.</p>
                    <div class="d-flex justify-content-center" style="gap: 12px;">
                        <button type="button" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4 font-weight-bold" style="border-radius: 8px;">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("schedule-container");
        const addBtn = document.getElementById("add-schedule-btn");

        if (addBtn && container) {
            addBtn.addEventListener("click", function() {
                const newRow = document.createElement("div");
                newRow.className = "row align-items-end mb-2 schedule-row";
                newRow.innerHTML = `
                    <div class="col-md-4 form-group mb-2">
                        <label class="small font-weight-bold text-muted">Operating Day</label>
                        <select name="test_day[]" class="form-control" style="height: 44px; border-radius: 6px;" required>
                            <option value="All Day">All Days</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="None">None</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <label class="small font-weight-bold text-muted">Start Time</label>
                        <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="test_start_time[]" required>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <label class="small font-weight-bold text-muted">End Time</label>
                        <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="test_end_time[]" required>
                    </div>
                    <div class="col-md-2 form-group mb-2">
                        <button type="button" class="btn btn-outline-danger btn-block remove-slot-btn" style="height: 44px; border-radius: 6px;">
                            <i class="fa-solid fa-trash-can"></i> Remove
                        </button>
                    </div>
                `;
                container.appendChild(newRow);

                newRow.querySelector(".remove-slot-btn").addEventListener("click", function() {
                    newRow.remove();
                });
            });
        }
    });
</script>
@endpush
