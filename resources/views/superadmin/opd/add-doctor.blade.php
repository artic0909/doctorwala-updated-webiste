@extends('layouts.superadmin')

@section('title', 'Manage OPD Doctors & Banner | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-user-doctor text-primary mr-2"></i>OPD Doctors & Clinic Banner
            </h3>
            <p class="text-muted mb-0">Partner ID: <span class="badge badge-primary px-2 py-1 font-weight-bold">#{{ $pid }}</span> &bull; Manage consulting doctors, schedules, fees, and promotional banner.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/superadmin/super-all-opd" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to All OPDs
            </a>
        </div>
    </div>
</div>

<!-- Banner Upload Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-image text-primary mr-2"></i>OPD Promotional Banner
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('superadmin.super-addopd.banner') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currently_loggedin_partner_id" value="{{ $pid }}">

            <div class="row align-items-center">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    @if($opdBanner && isset($opdBanner->opdbanner))
                        <img src="{{ asset('storage/' . $opdBanner->opdbanner) }}" alt="OPD Banner" class="img-fluid rounded shadow-sm" style="max-height: 140px; border: 1px solid #e2e8f0; object-fit: cover;">
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
                    <input type="file" class="form-control" name="opdbanner" style="height: 48px; border-radius: 8px;" accept="image/*" required>
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

<!-- Add Doctor Form Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-user-plus text-primary mr-2"></i>Add Consulting Doctor
        </h5>
    </div>
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('superadmin.super-addopd.doctor') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currently_loggedin_partner_id" value="{{ $pid }}">

            <div class="row">
                <div class="col-md-4 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Doctor Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="doctor_name" placeholder="Dr. Full Name" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-2 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa fa-graduation-cap text-primary mr-1"></i> Designation <span class="text-danger">*</span></label>
                    <select name="doctor_designation" class="form-control" style="height: 48px; border-radius: 8px;" required>
                        <option value="Dr">Dr</option>
                        <option value="MD">MD</option>
                        <option value="Prof">Prof</option>
                        <option value="BDS">BDS</option>
                    </select>
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa fa-stethoscope text-primary mr-1"></i> Specialization <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="doctor_specialist" placeholder="e.g. Cardiologist, Neurologist" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa fa-indian-rupee-sign text-primary mr-1"></i> Consultation Fee <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="doctor_fees" placeholder="₹ Amount" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-12 form-group mb-3">
                    <label class="font-weight-bold text-dark"><i class="fa fa-info-circle text-primary mr-1"></i> Doctor Biography / Qualifications / Notes</label>
                    <textarea class="form-control" name="doctor_more" placeholder="Degrees, past hospital experience, chamber room..." rows="3" style="border-radius: 8px;"></textarea>
                </div>
            </div>

            <!-- Schedule Repeater -->
            <div class="p-3 mb-4 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-weight-bold text-dark mb-0">
                        <i class="fa-solid fa-calendar-days text-primary mr-1"></i> Consultation Timing & Days <span class="text-danger">*</span>
                    </label>
                    <button type="button" id="add-schedule-btn" class="btn btn-sm btn-outline-primary font-weight-bold" style="border-radius: 6px;">
                        <i class="fa-solid fa-plus mr-1"></i> Add Another Slot
                    </button>
                </div>
                <div id="schedule-container">
                    <div class="row align-items-end mb-2 schedule-row">
                        <div class="col-md-4 form-group mb-2">
                            <label class="small font-weight-bold text-muted">Visiting Day</label>
                            <select name="doctor_visit_day[]" class="form-control" style="height: 44px; border-radius: 6px;" required>
                                <option value="All Day">All Days</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-2">
                            <label class="small font-weight-bold text-muted">Start Time</label>
                            <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="doctor_visit_start_time[]" required>
                        </div>
                        <div class="col-md-3 form-group mb-2">
                            <label class="small font-weight-bold text-muted">End Time</label>
                            <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="doctor_visit_end_time[]" required>
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
                    <i class="fa-solid fa-user-plus mr-1"></i> Add Doctor to Chamber
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Doctors List Card -->
<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-list-check text-primary mr-2"></i>Registered Doctors in this OPD
            <span class="badge badge-secondary ml-2">{{ count($opdDoctors) }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Doctor Info</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Speciality</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Fees</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Visiting Schedule</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($opdDoctors as $opdDoctor)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">{{ $loop->iteration }}</td>
                        <td class="py-3 px-3">
                            <h6 class="font-weight-bold text-dark mb-0">{{ $opdDoctor->doctor_designation }}. {{ $opdDoctor->doctor_name }}</h6>
                            @if($opdDoctor->doctor_more)
                                <span class="small text-muted">{{ Str::limit($opdDoctor->doctor_more, 40) }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-primary">
                            {{ $opdDoctor->doctor_specialist }}
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-success">
                            ₹ {{ number_format($opdDoctor->doctor_fees, 2) }}
                        </td>
                        <td class="py-3 px-3">
                            @if(!empty($opdDoctor->visit_day_time) && is_array($opdDoctor->visit_day_time))
                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                @foreach($opdDoctor->visit_day_time as $visit)
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
                            @if($opdDoctor->status == 'Available')
                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 6px;">Available</span>
                            @else
                                <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 6px;">Unavailable</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="d-flex justify-content-center" style="gap: 8px;">
                                <button type="button" data-target="#myActiveInactiveModal{{$opdDoctor->id}}" data-toggle="modal" class="btn btn-sm btn-outline-info" style="border-radius: 6px; padding: 4px 8px;" title="Change Status">
                                    <i class="fa-solid fa-sliders"></i>
                                </button>
                                <button type="button" data-target="#myDeleteModal{{ $opdDoctor->id }}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Doctor">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-user-doctor fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Doctors Registered in this OPD</h5>
                            <p class="text-muted small mb-0">Use the form above to add doctors and their chamber timings.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Status Modals -->
@foreach ($opdDoctors as $opdDoctor)
<div class="modal fade" id="myActiveInactiveModal{{$opdDoctor->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-sliders text-primary mr-2"></i>Change Doctor Availability
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.status.opdDoctor.edit', $opdDoctor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <p class="text-muted">Update availability status for <b>{{ $opdDoctor->doctor_name }}</b>:</p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Select Availability <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" style="height: 48px; border-radius: 8px;" required>
                            <option value="Available" {{ $opdDoctor->status == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Unavailable" {{ $opdDoctor->status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
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
@foreach ($opdDoctors as $opdDoctor)
<div class="modal fade" id="myDeleteModal{{ $opdDoctor->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.super-deleteopd.doctor', $opdDoctor->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                    </div>
                    <h4 class="font-weight-bold text-dark">Remove Doctor?</h4>
                    <p class="text-muted mb-4">Are you sure you want to remove <b>{{ $opdDoctor->doctor_name }}</b> from this OPD chamber? This cannot be undone.</p>
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
                        <label class="small font-weight-bold text-muted">Visiting Day</label>
                        <select name="doctor_visit_day[]" class="form-control" style="height: 44px; border-radius: 6px;" required>
                            <option value="All Day">All Days</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <label class="small font-weight-bold text-muted">Start Time</label>
                        <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="doctor_visit_start_time[]" required>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <label class="small font-weight-bold text-muted">End Time</label>
                        <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="doctor_visit_end_time[]" required>
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
