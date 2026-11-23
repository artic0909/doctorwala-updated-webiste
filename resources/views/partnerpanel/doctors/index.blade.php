@extends('layouts.partner')

@section('title', 'Doctor Profile Setup | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-8 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-user-doctor fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Doctor Consultation Profile</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Setup your specialist details, consulting fee, clinic address and contact information</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-md-right">
        <a href="/partnerpanel/partner-dashboard" class="btn btn-outline-secondary font-weight-bold shadow-xs" style="border-radius: 8px; padding: 8px 16px;">
            <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12">
        <div class="doc-card shadow-sm p-4 p-md-5">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 42px; height: 42px; background: #f0fdf4; color: #16a34a;">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-0 text-dark">Practitioner Consultation Information</h5>
                    <small class="text-muted">Displays on the Doctorwala app when patients search for doctors</small>
                </div>
            </div>

            <form action="{{ route('partner.doctor.contact.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-sitemap text-primary mr-1"></i> Registration Type</label>
                        <input type="text" class="form-control bg-light" name="clinic_registration_type" value="{{ old('clinic_registration_type', $contactDetails->clinic_registration_type ?? 'Doctor') }}" readonly style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-user-doctor text-primary mr-1"></i> Doctor Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_name" value="{{ old('partner_doctor_name', $contactDetails->partner_doctor_name ?? $partner->partner_contact_person_name ?? '') }}" placeholder="e.g. Dr. Rajesh Roy" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-stethoscope text-primary mr-1"></i> Specialization <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_specialist" value="{{ old('partner_doctor_specialist', $contactDetails->partner_doctor_specialist ?? '') }}" placeholder="e.g. Cardiologist, General Physician" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-graduation-cap text-primary mr-1"></i> Designation <span class="text-danger">*</span></label>
                        <select name="partner_doctor_designation" class="form-control" required style="height: 44px; border-radius: 8px;">
                            <option value="Dr" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'Dr' ? 'selected' : '' }}>Dr</option>
                            <option value="MD" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'MD' ? 'selected' : '' }}>MD</option>
                            <option value="Prof" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'Prof' ? 'selected' : '' }}>Prof</option>
                            <option value="BDS" {{ old('partner_doctor_designation', $contactDetails->partner_doctor_designation ?? '') == 'BDS' ? 'selected' : '' }}>BDS</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-indian-rupee-sign text-primary mr-1"></i> Consultation Fee (₹) <span class="text-danger">*</span></label>
                        @php
                            $currentFee = $contactDetails->partner_doctor_fees ?? '';
                            $displayFee = ($currentFee === '' || $currentFee === '500') ? '000' : $currentFee;
                        @endphp
                        <input type="text" class="form-control" name="partner_doctor_fees" value="{{ old('partner_doctor_fees', $displayFee) }}" placeholder="Fee in INR (e.g. 000)" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-phone text-primary mr-1"></i> Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="partner_doctor_mobile" value="{{ old('partner_doctor_mobile', $contactDetails->partner_doctor_mobile ?? $partner->partner_mobile_number ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-envelope text-primary mr-1"></i> Email ID <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="partner_doctor_email" value="{{ old('partner_doctor_email', $contactDetails->partner_doctor_email ?? $partner->partner_email ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-globe text-primary mr-1"></i> State <span class="text-danger">*</span></label>
                        @php
                            $selectedDoctorState = old('partner_doctor_state', $contactDetails->partner_doctor_state ?? $partner->partner_state ?? 'West Bengal');
                        @endphp
                        <select name="partner_doctor_state" class="form-control" required style="height: 44px; border-radius: 8px;">
                            <option value="West Bengal" {{ $selectedDoctorState == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                            <option value="Bihar" {{ $selectedDoctorState == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                            <option value="Jharkhand" {{ $selectedDoctorState == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                            <option value="Odisha" {{ $selectedDoctorState == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                            <option value="Assam" {{ $selectedDoctorState == 'Assam' ? 'selected' : '' }}>Assam</option>
                            <option value="Delhi" {{ $selectedDoctorState == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                            <option value="Maharashtra" {{ $selectedDoctorState == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                            <option value="Uttar Pradesh" {{ $selectedDoctorState == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-city text-primary mr-1"></i> City / Town <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_city" value="{{ old('partner_doctor_city', $contactDetails->partner_doctor_city ?? $partner->partner_city ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-map-pin text-primary mr-1"></i> Landmark</label>
                        <input type="text" class="form-control" name="partner_doctor_landmark" value="{{ old('partner_doctor_landmark', $contactDetails->partner_doctor_landmark ?? $partner->partner_landmark ?? '') }}" style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-location-pin-lock text-primary mr-1"></i> PIN Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_doctor_pincode" value="{{ old('partner_doctor_pincode', $contactDetails->partner_doctor_pincode ?? $partner->partner_pincode ?? '') }}" required style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-map-location-dot text-primary mr-1"></i> Google Map Link</label>
                        <input type="text" class="form-control" name="partner_doctor_google_map_link" value="{{ old('partner_doctor_google_map_link', $contactDetails->partner_doctor_google_map_link ?? '') }}" placeholder="https://maps.app.goo.gl/..." style="height: 44px; border-radius: 8px;">
                    </div>

                    <div class="col-12 form-group">
                        <label class="font-weight-bold small text-dark"><i class="fa-solid fa-location-dot text-primary mr-1"></i> Complete Chamber Address <span class="text-danger">*</span></label>
                        <textarea name="partner_doctor_address" class="form-control" rows="3" required style="border-radius: 8px;">{{ old('partner_doctor_address', $contactDetails->partner_doctor_address ?? $partner->partner_address ?? '') }}</textarea>
                    </div>

                    <!-- Visiting Hours & Chamber Schedule Section -->
                    <div class="col-12 mt-3">
                        <div class="p-3 p-md-4 rounded" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap" style="gap: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: #e0f2fe; color: #0284c7;">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1rem;">Visiting Hours & Chamber Schedule</h5>
                                        <small class="text-muted">Set up consultation days and chamber timing slots</small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold" onclick="addDoctorScheduleSlot()" style="border-radius: 8px; padding: 6px 14px;">
                                    <i class="fa-solid fa-plus mr-1"></i> Add Slot
                                </button>
                            </div>

                            <div id="doctorScheduleContainer">
                                @php
                                    $rawVisitData = $contactDetails->visit_day_time ?? [];
                                    if (is_string($rawVisitData)) {
                                        $rawVisitData = json_decode($rawVisitData, true) ?: [];
                                    }
                                    $scheduleSlots = is_array($rawVisitData) && count($rawVisitData) > 0 
                                        ? $rawVisitData 
                                        : [['day' => 'Monday', 'start_time' => '10:00', 'end_time' => '13:00']];
                                @endphp

                                @foreach($scheduleSlots as $index => $slot)
                                    @php
                                        $slotDay = $slot['day'] ?? $slot['partner_doctor_visit_day'] ?? 'Monday';
                                        $slotStart = $slot['start_time'] ?? $slot['partner_doctor_visit_start_time'] ?? '';
                                        $slotEnd = $slot['end_time'] ?? $slot['partner_doctor_visit_end_time'] ?? '';
                                    @endphp
                                    <div class="schedule-slot-card p-3 mb-3 rounded border" style="background: #f8fafc; border-color: #e2e8f0 !important; border-radius: 10px;">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-md-4 mb-2 mb-md-0">
                                                <label class="small font-weight-bold text-muted mb-1 d-block">
                                                    <i class="fa-regular fa-calendar-days text-primary mr-1"></i> Visiting Day
                                                </label>
                                                <select name="partner_doctor_visit_day[]" class="form-control" style="height: 44px; border-radius: 8px; border: 1px solid #cbd5e1;" required>
                                                    @foreach(['All Day', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $dayName)
                                                        <option value="{{ $dayName }}" {{ strtolower($slotDay) == strtolower($dayName) ? 'selected' : '' }}>{{ $dayName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2 mb-md-0">
                                                <label class="small font-weight-bold text-muted mb-1 d-block">
                                                    <i class="fa-regular fa-clock text-primary mr-1"></i> From Time
                                                </label>
                                                <input type="time" name="partner_doctor_visit_start_time[]" class="form-control" value="{{ $slotStart }}" style="height: 44px; border-radius: 8px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-3 mb-2 mb-md-0">
                                                <label class="small font-weight-bold text-muted mb-1 d-block">
                                                    <i class="fa-regular fa-clock text-primary mr-1"></i> To Time
                                                </label>
                                                <input type="time" name="partner_doctor_visit_end_time[]" class="form-control" value="{{ $slotEnd }}" style="height: 44px; border-radius: 8px; border: 1px solid #cbd5e1;">
                                            </div>
                                            <div class="col-md-2 text-right text-md-center pt-md-4">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeDoctorScheduleSlot(this)" title="Delete Slot" style="border-radius: 8px; height: 42px; width: 44px; display: inline-flex; align-items: center; justify-content: center; border-color: #fca5a5; color: #ef4444;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-4 pt-3 border-top" style="gap: 12px;">
                    <a href="/partnerpanel/partner-dashboard" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>Save Doctor Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addDoctorScheduleSlot() {
        var container = document.getElementById('doctorScheduleContainer');
        if (!container) return;

        var slotCard = document.createElement('div');
        slotCard.className = 'schedule-slot-card p-3 mb-3 rounded border';
        slotCard.style = 'background: #f8fafc; border-color: #e2e8f0 !important; border-radius: 10px;';
        slotCard.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted mb-1 d-block">
                        <i class="fa-regular fa-calendar-days text-primary mr-1"></i> Visiting Day
                    </label>
                    <select name="partner_doctor_visit_day[]" class="form-control" style="height: 44px; border-radius: 8px; border: 1px solid #cbd5e1;" required>
                        <option value="All Day">All Day</option>
                        <option value="Monday" selected>Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted mb-1 d-block">
                        <i class="fa-regular fa-clock text-primary mr-1"></i> From Time
                    </label>
                    <input type="time" name="partner_doctor_visit_start_time[]" class="form-control" value="10:00" style="height: 44px; border-radius: 8px; border: 1px solid #cbd5e1;">
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <label class="small font-weight-bold text-muted mb-1 d-block">
                        <i class="fa-regular fa-clock text-primary mr-1"></i> To Time
                    </label>
                    <input type="time" name="partner_doctor_visit_end_time[]" class="form-control" value="13:00" style="height: 44px; border-radius: 8px; border: 1px solid #cbd5e1;">
                </div>
                <div class="col-md-2 text-right text-md-center pt-md-4">
                    <button type="button" class="btn btn-outline-danger" onclick="removeDoctorScheduleSlot(this)" title="Delete Slot" style="border-radius: 8px; height: 42px; width: 44px; display: inline-flex; align-items: center; justify-content: center; border-color: #fca5a5; color: #ef4444;">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(slotCard);
    }

    function removeDoctorScheduleSlot(btn) {
        var card = btn.closest('.schedule-slot-card');
        var container = card.parentElement;
        if (container.querySelectorAll('.schedule-slot-card').length > 1) {
            card.remove();
        } else {
            alert('At least one visiting schedule slot is required.');
        }
    }
</script>
@endpush
@endsection
