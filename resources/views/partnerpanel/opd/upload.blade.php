@extends('layouts.partner')

@section('title', 'Upload OPD Doctor | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-user-doctor text-primary mr-2"></i>Add Consulting Doctor to OPD
            </h3>
            <p class="text-muted mb-0">Total active doctors registered: <span class="badge badge-primary px-2 py-1 font-weight-bold">{{ $allOPDs }}</span> &bull; Specify visiting schedules and consultation charges.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/partnerpanel/partner-opd-show" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-list mr-1"></i> View Registered Doctors
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-user-plus text-primary mr-2"></i>Doctor Details & OPD Schedule
        </h5>
    </div>
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('partner.opd.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-2 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-graduation-cap text-primary mr-1"></i> Designation <span class="text-danger">*</span></label>
                    <select name="doctor_designation" id="doctor_designation" class="form-control" style="height: 48px; border-radius: 8px;" required>
                        <option value="Dr">Dr</option>
                        <option value="MD">MD</option>
                        <option value="Prof">Prof</option>
                        <option value="BDS">BDS</option>
                    </select>
                </div>

                <div class="col-md-4 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Doctor Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="doctor_name" name="doctor_name" placeholder="Full Name" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-3 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-stethoscope text-primary mr-1"></i> Specialization <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="doctor_specialist" name="doctor_specialist" placeholder="e.g. Cardiologist, Dermatologist" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-md-3 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-indian-rupee-sign text-primary mr-1"></i> Consultation Fee <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="doctor_fees" name="doctor_fees" placeholder="₹ Amount" style="height: 48px; border-radius: 8px;" required>
                </div>

                <div class="col-12 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa fa-info-circle text-primary mr-1"></i> Doctor Qualifications & Bio (Optional)</label>
                    <textarea class="form-control" name="doctor_more" id="doctor_more" rows="3" placeholder="Degrees, chamber room details, or special notes for patients..." style="border-radius: 8px;"></textarea>
                </div>
            </div>

            <!-- Schedule Repeater -->
            <div class="p-3 mb-4 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="font-weight-bold text-dark mb-0">
                        <i class="fa-solid fa-calendar-days text-primary mr-1"></i> Visiting Schedule & Timings <span class="text-danger">*</span>
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
                            <label class="small font-weight-bold text-muted">Time From</label>
                            <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="doctor_visit_start_time[]" required>
                        </div>
                        <div class="col-md-3 form-group mb-2">
                            <label class="small font-weight-bold text-muted">Time To</label>
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
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Save Doctor Profile
                </button>
            </div>
        </form>
    </div>
</div>
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
                        <label class="small font-weight-bold text-muted">Time From</label>
                        <input type="time" class="form-control" style="height: 44px; border-radius: 6px;" name="doctor_visit_start_time[]" required>
                    </div>
                    <div class="col-md-3 form-group mb-2">
                        <label class="small font-weight-bold text-muted">Time To</label>
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
