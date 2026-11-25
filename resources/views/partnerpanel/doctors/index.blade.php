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
                                    <div class="mr-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px; background: #e0f2fe; color: #0284c7;">
                                        <i class="fa-regular fa-calendar-days"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.05rem;">Visiting Schedule (Day-wise & Date-wise)</h5>
                                        <small class="text-muted">Set up Morning, Afternoon & Evening consultation timing slots by Day or specific Calendar Date</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary btn-sm font-weight-bold mr-2" onclick="addScheduleCard('day')" style="border-radius: 8px; padding: 7px 14px; background: #0284c7; border-color: #0284c7;">
                                        <i class="fa-solid fa-plus mr-1"></i> Add Day Schedule
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm font-weight-bold" onclick="addScheduleCard('date')" style="border-radius: 8px; padding: 7px 14px;">
                                        <i class="fa-regular fa-calendar-plus mr-1"></i> Add Specific Date
                                    </button>
                                </div>
                            </div>

                            @php
                                $rawVisitData = $contactDetails->visit_day_time ?? [];
                                $normalizedSchedule = \App\Models\PartnerDoctorContactModel::normalizeSchedule($rawVisitData);
                                if (empty($normalizedSchedule)) {
                                    $normalizedSchedule = [
                                        [
                                            'type' => 'day',
                                            'day' => 'Monday',
                                            'date' => null,
                                            'morning_enabled' => true,
                                            'morning_start' => '09:00',
                                            'morning_end' => '12:00',
                                            'afternoon_enabled' => true,
                                            'afternoon_start' => '13:00',
                                            'afternoon_end' => '16:00',
                                            'evening_enabled' => true,
                                            'evening_start' => '17:00',
                                            'evening_end' => '20:00',
                                        ]
                                    ];
                                }
                            @endphp

                            <!-- Hidden field containing serialized JSON schedule -->
                            <input type="hidden" name="schedule_data_json" id="scheduleDataJson">

                            <div id="doctorScheduleContainer">
                                @foreach($normalizedSchedule as $index => $slot)
                                    @php
                                        $sType = $slot['type'] ?? 'day';
                                        $sDay = $slot['day'] ?? 'Monday';
                                        $sDate = $slot['date'] ?? '';
                                        $mOn = !empty($slot['morning_enabled']);
                                        $mStart = $slot['morning_start'] ?? '09:00';
                                        $mEnd = $slot['morning_end'] ?? '12:00';

                                        $aOn = !empty($slot['afternoon_enabled']);
                                        $aStart = $slot['afternoon_start'] ?? '13:00';
                                        $aEnd = $slot['afternoon_end'] ?? '16:00';

                                        $eOn = !empty($slot['evening_enabled']);
                                        $eStart = $slot['evening_start'] ?? '17:00';
                                        $eEnd = $slot['evening_end'] ?? '20:00';
                                    @endphp
                                    <div class="schedule-slot-card p-3 p-md-4 mb-3 rounded border" data-type="{{ $sType }}" style="background: #f8fafc; border-color: #cbd5e1 !important; border-radius: 12px;">
                                        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap" style="gap: 10px;">
                                            <div class="d-flex align-items-center flex-grow-1 flex-wrap" style="gap: 12px;">
                                                <span class="badge {{ $sType === 'date' ? 'badge-info' : 'badge-primary' }} px-2 py-1 font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">
                                                    <i class="fa-solid {{ $sType === 'date' ? 'fa-calendar-day' : 'fa-repeat' }} mr-1"></i>
                                                    {{ $sType === 'date' ? 'Specific Date Schedule' : 'Weekly Recurring Day' }}
                                                </span>

                                                @if($sType === 'date')
                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                    <label class="small font-weight-bold text-dark mb-0"><i class="fa-regular fa-calendar mr-1 text-primary"></i> Date:</label>
                                                    <input type="date" class="form-control form-control-sm slot-date-input" value="{{ $sDate }}" min="{{ date('Y-m-d') }}" style="width: 170px; border-radius: 8px; font-weight: 600;" required>
                                                </div>
                                                @else
                                                <div class="d-flex align-items-center" style="gap: 8px;">
                                                    <label class="small font-weight-bold text-dark mb-0"><i class="fa-regular fa-calendar-check mr-1 text-primary"></i> Day:</label>
                                                    <select class="form-control form-control-sm slot-day-input" style="width: 160px; border-radius: 8px; font-weight: 600;">
                                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'All Day'] as $dName)
                                                            <option value="{{ $dName }}" {{ strtolower($sDay) == strtolower($dName) ? 'selected' : '' }}>{{ $dName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endif
                                            </div>

                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeDoctorScheduleSlot(this)" title="Delete Slot" style="border-radius: 8px; padding: 4px 10px;">
                                                <i class="fa-solid fa-trash-can mr-1"></i> Remove
                                            </button>
                                        </div>

                                        <!-- 3 Shift Slots Grid -->
                                        <div class="row g-3">
                                            <!-- Morning Slot -->
                                            <div class="col-lg-4 col-md-12 mb-2 mb-lg-0">
                                                <div class="p-3 rounded border h-100" style="background: #ffffff; border-color: #e2e8f0 !important; border-radius: 10px;">
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input slot-morning-check" id="mCheck{{ $index }}" {{ $mOn ? 'checked' : '' }} onchange="toggleSlotFields(this)">
                                                        <label class="custom-control-label font-weight-bold text-dark" for="mCheck{{ $index }}">
                                                            🌅 Morning Slot
                                                        </label>
                                                    </div>
                                                    <div class="slot-fields row g-1 {{ $mOn ? '' : 'd-none' }}">
                                                        <div class="col-6">
                                                            <label class="small text-muted font-weight-bold mb-1">From</label>
                                                            <input type="time" class="form-control form-control-sm slot-morning-start" value="{{ $mStart }}" style="border-radius: 6px;">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="small text-muted font-weight-bold mb-1">To</label>
                                                            <input type="time" class="form-control form-control-sm slot-morning-end" value="{{ $mEnd }}" style="border-radius: 6px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Afternoon Slot -->
                                            <div class="col-lg-4 col-md-12 mb-2 mb-lg-0">
                                                <div class="p-3 rounded border h-100" style="background: #ffffff; border-color: #e2e8f0 !important; border-radius: 10px;">
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input slot-afternoon-check" id="aCheck{{ $index }}" {{ $aOn ? 'checked' : '' }} onchange="toggleSlotFields(this)">
                                                        <label class="custom-control-label font-weight-bold text-dark" for="aCheck{{ $index }}">
                                                            ☀️ Afternoon Slot
                                                        </label>
                                                    </div>
                                                    <div class="slot-fields row g-1 {{ $aOn ? '' : 'd-none' }}">
                                                        <div class="col-6">
                                                            <label class="small text-muted font-weight-bold mb-1">From</label>
                                                            <input type="time" class="form-control form-control-sm slot-afternoon-start" value="{{ $aStart }}" style="border-radius: 6px;">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="small text-muted font-weight-bold mb-1">To</label>
                                                            <input type="time" class="form-control form-control-sm slot-afternoon-end" value="{{ $aEnd }}" style="border-radius: 6px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Evening Slot -->
                                            <div class="col-lg-4 col-md-12">
                                                <div class="p-3 rounded border h-100" style="background: #ffffff; border-color: #e2e8f0 !important; border-radius: 10px;">
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox" class="custom-control-input slot-evening-check" id="eCheck{{ $index }}" {{ $eOn ? 'checked' : '' }} onchange="toggleSlotFields(this)">
                                                        <label class="custom-control-label font-weight-bold text-dark" for="eCheck{{ $index }}">
                                                            🌙 Evening Slot
                                                        </label>
                                                    </div>
                                                    <div class="slot-fields row g-1 {{ $eOn ? '' : 'd-none' }}">
                                                        <div class="col-6">
                                                            <label class="small text-muted font-weight-bold mb-1">From</label>
                                                            <input type="time" class="form-control form-control-sm slot-evening-start" value="{{ $eStart }}" style="border-radius: 6px;">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="small text-muted font-weight-bold mb-1">To</label>
                                                            <input type="time" class="form-control form-control-sm slot-evening-end" value="{{ $eEnd }}" style="border-radius: 6px;">
                                                        </div>
                                                    </div>
                                                </div>
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
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-floppy-disk mr-2"></i>Save Doctor Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let slotUidCounter = {{ count($normalizedSchedule) + 10 }};

    function toggleSlotFields(checkbox) {
        const container = checkbox.closest('.border').querySelector('.slot-fields');
        if (container) {
            if (checkbox.checked) {
                container.classList.remove('d-none');
            } else {
                container.classList.add('d-none');
            }
        }
    }

    function addScheduleCard(type) {
        const container = document.getElementById('doctorScheduleContainer');
        if (!container) return;

        slotUidCounter++;
        const card = document.createElement('div');
        card.className = 'schedule-slot-card p-3 p-md-4 mb-3 rounded border';
        card.setAttribute('data-type', type);
        card.style = 'background: #f8fafc; border-color: #cbd5e1 !important; border-radius: 12px;';

        const isDate = type === 'date';
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tomorrowStr = tomorrow.toISOString().split('T')[0];

        card.innerHTML = `
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap" style="gap: 10px;">
                <div class="d-flex align-items-center flex-grow-1 flex-wrap" style="gap: 12px;">
                    <span class="badge ${isDate ? 'badge-info' : 'badge-primary'} px-2 py-1 font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase;">
                        <i class="fa-solid ${isDate ? 'fa-calendar-day' : 'fa-repeat'} mr-1"></i>
                        ${isDate ? 'Specific Date Schedule' : 'Weekly Recurring Day'}
                    </span>

                    ${isDate ? `
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <label class="small font-weight-bold text-dark mb-0"><i class="fa-regular fa-calendar mr-1 text-primary"></i> Date:</label>
                        <input type="date" class="form-control form-control-sm slot-date-input" value="${tomorrowStr}" min="${new Date().toISOString().split('T')[0]}" style="width: 170px; border-radius: 8px; font-weight: 600;" required>
                    </div>
                    ` : `
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <label class="small font-weight-bold text-dark mb-0"><i class="fa-regular fa-calendar-check mr-1 text-primary"></i> Day:</label>
                        <select class="form-control form-control-sm slot-day-input" style="width: 160px; border-radius: 8px; font-weight: 600;">
                            <option value="Monday" selected>Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="All Day">All Day</option>
                        </select>
                    </div>
                    `}
                </div>

                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeDoctorScheduleSlot(this)" title="Delete Slot" style="border-radius: 8px; padding: 4px 10px;">
                    <i class="fa-solid fa-trash-can mr-1"></i> Remove
                </button>
            </div>

            <div class="row g-3">
                <!-- Morning Slot -->
                <div class="col-lg-4 col-md-12 mb-2 mb-lg-0">
                    <div class="p-3 rounded border h-100" style="background: #ffffff; border-color: #e2e8f0 !important; border-radius: 10px;">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input slot-morning-check" id="mCheck${slotUidCounter}" checked onchange="toggleSlotFields(this)">
                            <label class="custom-control-label font-weight-bold text-dark" for="mCheck${slotUidCounter}">
                                🌅 Morning Slot
                            </label>
                        </div>
                        <div class="slot-fields row g-1">
                            <div class="col-6">
                                <label class="small text-muted font-weight-bold mb-1">From</label>
                                <input type="time" class="form-control form-control-sm slot-morning-start" value="09:00" style="border-radius: 6px;">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted font-weight-bold mb-1">To</label>
                                <input type="time" class="form-control form-control-sm slot-morning-end" value="12:00" style="border-radius: 6px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Afternoon Slot -->
                <div class="col-lg-4 col-md-12 mb-2 mb-lg-0">
                    <div class="p-3 rounded border h-100" style="background: #ffffff; border-color: #e2e8f0 !important; border-radius: 10px;">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input slot-afternoon-check" id="aCheck${slotUidCounter}" checked onchange="toggleSlotFields(this)">
                            <label class="custom-control-label font-weight-bold text-dark" for="aCheck${slotUidCounter}">
                                ☀️ Afternoon Slot
                            </label>
                        </div>
                        <div class="slot-fields row g-1">
                            <div class="col-6">
                                <label class="small text-muted font-weight-bold mb-1">From</label>
                                <input type="time" class="form-control form-control-sm slot-afternoon-start" value="13:00" style="border-radius: 6px;">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted font-weight-bold mb-1">To</label>
                                <input type="time" class="form-control form-control-sm slot-afternoon-end" value="16:00" style="border-radius: 6px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Evening Slot -->
                <div class="col-lg-4 col-md-12">
                    <div class="p-3 rounded border h-100" style="background: #ffffff; border-color: #e2e8f0 !important; border-radius: 10px;">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input slot-evening-check" id="eCheck${slotUidCounter}" checked onchange="toggleSlotFields(this)">
                            <label class="custom-control-label font-weight-bold text-dark" for="eCheck${slotUidCounter}">
                                🌙 Evening Slot
                            </label>
                        </div>
                        <div class="slot-fields row g-1">
                            <div class="col-6">
                                <label class="small text-muted font-weight-bold mb-1">From</label>
                                <input type="time" class="form-control form-control-sm slot-evening-start" value="17:00" style="border-radius: 6px;">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted font-weight-bold mb-1">To</label>
                                <input type="time" class="form-control form-control-sm slot-evening-end" value="20:00" style="border-radius: 6px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(card);
    }

    function removeDoctorScheduleSlot(btn) {
        const card = btn.closest('.schedule-slot-card');
        const container = card.parentElement;
        if (container.querySelectorAll('.schedule-slot-card').length > 1) {
            card.remove();
        } else {
            alert('At least one visiting schedule entry is required.');
        }
    }

    // Intercept form submit to serialize all schedule cards into JSON
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action*="partner-doctor-contact"]');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            const cards = document.querySelectorAll('.schedule-slot-card');
            const scheduleList = [];

            cards.forEach(card => {
                const type = card.getAttribute('data-type') || 'day';
                let day = null;
                let date = null;

                if (type === 'date') {
                    const dateInput = card.querySelector('.slot-date-input');
                    date = dateInput ? dateInput.value.trim() : null;
                    if (date) {
                        try {
                            const d = new Date(date);
                            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                            day = dayNames[d.getDay()];
                        } catch (_) {}
                    }
                } else {
                    const dayInput = card.querySelector('.slot-day-input');
                    day = dayInput ? dayInput.value.trim() : 'Monday';
                }

                const mCheck = card.querySelector('.slot-morning-check');
                const mStart = card.querySelector('.slot-morning-start');
                const mEnd = card.querySelector('.slot-morning-end');

                const aCheck = card.querySelector('.slot-afternoon-check');
                const aStart = card.querySelector('.slot-afternoon-start');
                const aEnd = card.querySelector('.slot-afternoon-end');

                const eCheck = card.querySelector('.slot-evening-check');
                const eStart = card.querySelector('.slot-evening-start');
                const eEnd = card.querySelector('.slot-evening-end');

                const mOn = mCheck ? mCheck.checked : false;
                const aOn = aCheck ? aCheck.checked : false;
                const eOn = eCheck ? eCheck.checked : false;

                // At least one slot should be enabled for this day/date
                if (!mOn && !aOn && !eOn) {
                    return; // skip completely empty card
                }

                scheduleList.push({
                    type: type,
                    day: day,
                    date: date,
                    morning_enabled: mOn,
                    morning_start: mOn && mStart ? mStart.value : null,
                    morning_end: mOn && mEnd ? mEnd.value : null,
                    afternoon_enabled: aOn,
                    afternoon_start: aOn && aStart ? aStart.value : null,
                    afternoon_end: aOn && aEnd ? aEnd.value : null,
                    evening_enabled: eOn,
                    evening_start: eOn && eStart ? eStart.value : null,
                    evening_end: eOn && eEnd ? eEnd.value : null,
                    start_time: (mOn && mStart ? mStart.value : (aOn && aStart ? aStart.value : (eOn && eStart ? eStart.value : '09:00'))),
                    end_time: (eOn && eEnd ? eEnd.value : (aOn && aEnd ? aEnd.value : (mOn && mEnd ? mEnd.value : '20:00')))
                });
            });

            if (scheduleList.length === 0) {
                e.preventDefault();
                alert('Please configure at least one active visiting schedule slot (Morning, Afternoon, or Evening) before saving.');
                return false;
            }

            document.getElementById('scheduleDataJson').value = JSON.stringify(scheduleList);
        });
    });
</script>
@endpush
@endsection
