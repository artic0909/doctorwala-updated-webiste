@extends('layouts.partner')

@section('title', 'Request Patient Access | Partner Panel')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    /* Select2 customizations for modern doctor theme */
    .select2-container { width: 100% !important; }
    .select2-container--default .select2-selection--single {
        height: 48px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        display: flex;
        align-items: center;
        padding: 0 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 48px !important;
        color: #334155;
        font-size: 14px;
        padding-left: 4px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 10px;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #0284c7 !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, .15) !important;
    }
    .select2-dropdown {
        border-color: #bae6fd !important;
        border-radius: 8px !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
    }
    .select2-search__field {
        padding: 8px 10px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        outline: none !important;
    }
    .select2-results__option--highlighted[aria-selected] {
        background: #0284c7 !important;
    }

    .ppr-wrap { position: relative; }
    .ppr-ico {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        z-index: 4;
        pointer-events: none;
    }
    .ppr-field {
        padding-left: 42px !important;
        height: 48px !important;
        border-radius: 8px !important;
    }
    .ppr-field:focus {
        border-color: #0284c7 !important;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, .15) !important;
    }

    #pprBtn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 8px;
        background: #0284c7;
        color: #fff;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 2px 6px rgba(2, 132, 199, .25);
    }
    #pprBtn:hover {
        background: #0369a1;
        transform: translateY(-1px);
    }
    #pprBtn:disabled {
        opacity: .6;
        cursor: not-allowed;
        transform: none;
    }

    .ppr-card {
        border: 1px solid #bae6fd;
        border-radius: 14px;
        background: #f0f9ff;
        overflow: hidden;
        animation: pprIn .3s ease;
    }
    @keyframes pprIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .ppr-card__top {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: #0284c7;
        color: #fff;
    }
    .ppr-card__av {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 800;
    }
    .ppr-card__found { font-size: 14px; font-weight: 700; }
    .ppr-card__sub { font-size: 12px; opacity: .85; }
    .ppr-card__badge {
        margin-left: auto;
        background: rgba(255, 255, 255, .2);
        border: 1px solid rgba(255, 255, 255, .4);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 700;
    }
    .ppr-card__grid {
        padding: 18px 20px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .ppr-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .ppr-row__ico {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 13px;
    }
    .ppr-row__ico--b { background: #e0f2fe; color: #0369a1; }
    .ppr-row__ico--t { background: #ccfbf1; color: #0f766e; }
    .ppr-row__ico--g { background: #dcfce7; color: #15803d; }
    .ppr-row__ico--p { background: #f3e8ff; color: #7e22ce; }
    .ppr-row__lbl { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; }
    .ppr-row__val { font-size: 14px; font-weight: 600; color: #0f172a; margin-top: 2px; }
    .ppr-card__foot {
        padding: 10px 20px;
        background: rgba(255, 255, 255, .6);
        border-top: 1px solid #e0f2fe;
        font-size: 12px;
        color: #64748b;
    }

    .ppr-err-box {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        border-radius: 10px;
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        font-size: 13.5px;
        font-weight: 600;
        animation: pprIn .25s ease;
    }
    @media(max-width:600px) {
        .ppr-card__grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-user-lock text-primary mr-2"></i>Request Patient Profile Access
            </h3>
            <p class="text-muted mb-0">Initiate a secure consent request to access your patient's medical records, history, and uploaded lab reports.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/partnerpanel/patient-profile-all-request" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-users mr-1"></i> View Patient Requests
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-shield-halved text-primary mr-2"></i>Patient Lookup & Consent Authorization
                </h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('partner.patient.request.send') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        {{-- 1. Doctor Select --}}
                        <div class="col-12 form-group mb-4">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-user-doctor text-primary mr-1"></i> Consulting Doctor <span class="text-danger">*</span>
                            </label>
                            <select id="pprDoctorSelect" name="doctor_id" style="width:100%" required>
                                @if((in_array('Doctor', $registrationTypes) || in_array('Others', $registrationTypes)) && count($doctors) === 1)
                                    @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}" selected>
                                        {{ $doc->doctor_name }}{{ $doc->doctor_designation ? ' · '.$doc->doctor_designation : '' }}{{ $doc->doctor_specialist ? ' ('.$doc->doctor_specialist.')' : '' }}
                                    </option>
                                    @endforeach
                                @else
                                    <option value="" disabled selected>— Search and select consulting doctor —</option>
                                    @forelse($doctors as $doc)
                                    <option value="{{ $doc->id }}">
                                        {{ $doc->doctor_name }}{{ $doc->doctor_designation ? ' · '.$doc->doctor_designation : '' }}{{ $doc->doctor_specialist ? ' ('.$doc->doctor_specialist.')' : '' }}
                                    </option>
                                    @empty
                                    <option disabled>No active doctors registered yet.</option>
                                    @endforelse
                                @endif
                            </select>
                            <small class="text-muted mt-1 d-block">The selected doctor will receive authorized access once patient approves.</small>
                        </div>

                        {{-- 2. Medical ID --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-id-card text-primary mr-1"></i> Doctorwala Medical ID <span class="text-danger">*</span>
                            </label>
                            <div class="ppr-wrap">
                                <span class="ppr-ico"><i class="fa-solid fa-id-badge text-primary"></i></span>
                                <input type="text" class="form-control ppr-field" id="pprMedId" placeholder="e.g. DW26 7211 03" oninput="pprReset()" name="dw_medical_id" required>
                            </div>
                            <small class="text-muted mt-1 d-block">Found on patient's digital Doctorwala card.</small>
                        </div>

                        {{-- 3. Member ID --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-hashtag text-success mr-1"></i> Member ID <span class="text-danger">*</span>
                            </label>
                            <div class="ppr-wrap">
                                <span class="ppr-ico"><i class="fa-solid fa-key text-success"></i></span>
                                <input type="text" class="form-control ppr-field" id="pprMemId" placeholder="e.g. DW-2026-003" oninput="pprReset()" name="dw_member_id" required>
                            </div>
                            <small class="text-muted mt-1 d-block">Patient's Doctorwala account member identifier.</small>
                        </div>

                        {{-- 4. Lookup Button --}}
                        <div class="col-12 form-group text-right mb-4">
                            <button type="button" id="pprBtn" onclick="pprFetch()">
                                <i class="fa-solid fa-magnifying-glass mr-1"></i> Verify & Preview Patient Details
                            </button>
                        </div>

                        {{-- 5. Preview Card --}}
                        <div class="col-12 mb-4" id="pprPreview" style="display:none">
                            <div class="ppr-card">
                                <div class="ppr-card__top">
                                    <div class="ppr-card__av" id="pprAv">?</div>
                                    <div>
                                        <div class="ppr-card__found">Patient Account Located</div>
                                        <div class="ppr-card__sub">Identity partially masked for patient privacy protection</div>
                                    </div>
                                    <span class="ppr-card__badge" id="pprBadge" style="display:none">
                                        <i class="fa-solid fa-check-circle mr-1"></i> Verified
                                    </span>
                                </div>
                                <div class="ppr-card__grid">
                                    <div class="ppr-row">
                                        <span class="ppr-row__ico ppr-row__ico--b"><i class="fa-solid fa-user"></i></span>
                                        <div>
                                            <div class="ppr-row__lbl">Full Name</div>
                                            <div class="ppr-row__val" id="pV-name">—</div>
                                            <input type="hidden" id="pV-id" name="dw_user_id" value="">
                                        </div>
                                    </div>
                                    <div class="ppr-row">
                                        <span class="ppr-row__ico ppr-row__ico--t"><i class="fa-solid fa-envelope"></i></span>
                                        <div>
                                            <div class="ppr-row__lbl">Email</div>
                                            <div class="ppr-row__val" id="pV-email">—</div>
                                        </div>
                                    </div>
                                    <div class="ppr-row">
                                        <span class="ppr-row__ico ppr-row__ico--g"><i class="fa-solid fa-phone"></i></span>
                                        <div>
                                            <div class="ppr-row__lbl">Mobile Number</div>
                                            <div class="ppr-row__val" id="pV-mobile">—</div>
                                        </div>
                                    </div>
                                    <div class="ppr-row">
                                        <span class="ppr-row__ico ppr-row__ico--p"><i class="fa-solid fa-id-card"></i></span>
                                        <div>
                                            <div class="ppr-row__lbl">Medical Card No.</div>
                                            <div class="ppr-row__val" id="pV-card">—</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ppr-card__foot">
                                    <i class="fa-solid fa-info-circle mr-1"></i> Full medical history, vitals, prescriptions, and report images unlock automatically once the patient approves.
                                </div>
                            </div>
                        </div>

                        {{-- 6. Error Box --}}
                        <div class="col-12 mb-4" id="pprErr" style="display:none">
                            <div class="ppr-err-box">
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                <span id="pprErrMsg">No patient found matching these credentials.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Partner Context -->
                    <input type="hidden" name="currently_loggedin_partner_id" value="{{ $partner->partner_id }}">
                    <input type="hidden" name="partner_clinic_name" value="{{ $partner->partner_clinic_name }}">
                    <input type="hidden" name="partner_contact_person_name" value="{{ $partner->partner_contact_person_name }}">
                    <input type="hidden" name="partner_mobile_number" value="{{ $partner->partner_mobile_number }}">
                    <input type="hidden" name="partner_email" value="{{ $partner->partner_email }}">
                    <input type="hidden" name="partner_state" value="{{ $partner->partner_state }}">
                    <input type="hidden" name="partner_city" value="{{ $partner->partner_city }}">
                    <input type="hidden" name="partner_landmark" value="{{ $partner->partner_landmark }}">
                    <input type="hidden" name="partner_pincode" value="{{ $partner->partner_pincode }}">

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7; font-size: 1rem;">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Send Access Request to Patient
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
            $('#pprDoctorSelect').select2({
                placeholder: '— Search and select consulting doctor —',
                allowClear: true,
                width: '100%',
            });
        }
    });

    function mName(n) {
        if (!n) return '—';
        return n.split(' ').map(function(w) {
            return w.length <= 2 ? w : w.slice(0, 3) + '*'.repeat(Math.max(2, w.length - 3));
        }).join(' ');
    }

    function mEmail(e) {
        if (!e) return '—';
        var p = e.split('@');
        if (p.length < 2) return e;
        return p[0].slice(0, 2) + '*'.repeat(Math.max(3, p[0].length - 2)) + '@' + p[1];
    }

    function mMob(m) {
        if (!m) return '—';
        var s = m.toString().replace(/\s/g, '');
        return s.slice(0, 3) + '*'.repeat(Math.max(4, s.length - 6)) + s.slice(-3);
    }

    function mCard(c) {
        if (!c) return '—';
        return c.toString().slice(0, 4) + ' **** ' + c.toString().slice(-2);
    }

    function inits(n) {
        if (!n) return '?';
        return n.split(' ').map(function(w) {
            return w[0] || '';
        }).slice(0, 2).join('').toUpperCase();
    }

    function pprReset() {
        document.getElementById('pprPreview').style.display = 'none';
        document.getElementById('pprErr').style.display = 'none';
    }

    function pprFetch() {
        var medId = document.getElementById('pprMedId').value.trim();
        var memId = document.getElementById('pprMemId').value.trim();
        pprReset();

        if (!medId || !memId) {
            document.getElementById('pprErrMsg').textContent = 'Please enter both Doctorwala Medical ID and Member ID.';
            document.getElementById('pprErr').style.display = 'block';
            return;
        }

        var btn = document.getElementById('pprBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Verifying…';

        var csrf = '{{ csrf_token() }}';

        fetch('{{ route("partner.patient.lookup") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                dw_medical_id: medId,
                dw_member_id: memId
            })
        })
        .then(function(r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(function(data) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-magnifying-glass mr-1"></i> Verify & Preview Patient Details';

            if (data.found && data.patient) {
                var p = data.patient;
                document.getElementById('pprAv').textContent = inits(p.user_name);
                document.getElementById('pV-name').textContent = mName(p.user_name);
                document.getElementById('pV-id').value = p.id;
                document.getElementById('pV-email').textContent = mEmail(p.user_email);
                document.getElementById('pV-mobile').textContent = mMob(p.user_mobile);
                document.getElementById('pV-card').textContent = mCard(p.medical_card_no);
                document.getElementById('pprBadge').style.display = p.is_verified ? 'inline-flex' : 'none';
                document.getElementById('pprPreview').style.display = 'block';
            } else {
                document.getElementById('pprErrMsg').textContent = data.message || 'No patient record found matching these IDs. Please verify credentials.';
                document.getElementById('pprErr').style.display = 'block';
            }
        })
        .catch(function(err) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-magnifying-glass mr-1"></i> Verify & Preview Patient Details';
            document.getElementById('pprErrMsg').textContent = 'Verification error: ' + err.message;
            document.getElementById('pprErr').style.display = 'block';
        });
    }
</script>
@endpush
