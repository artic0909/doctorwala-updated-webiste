@extends('layouts.superadmin')

@section('title', 'Partner Follow-ups | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-phone-volume text-primary mr-2"></i>Communication & Follow-up Tracking
            </h3>
            <p class="text-muted mb-0">Record and review communication logs, call outcomes, and follow-up notes for partner clinics.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.super-all-partner') }}" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-users mr-1"></i> View All Partners
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left Side: Add Follow-up Form -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4">
                <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-3">
                    <i class="fa-solid fa-plus-circle text-primary mr-2"></i>Log Follow-up
                </h5>

                <form action="{{ route('superadmin.followup.store') }}" method="POST">
                    @csrf
                    @if(isset($selectedPartner) && $selectedPartner)
                        <input type="hidden" name="dw_partner_id" value="{{ $selectedPartner->id }}">

                        <div class="p-3 mb-3 rounded" style="background: #f0f9ff; border-left: 4px solid #0284c7;">
                            <span class="text-uppercase font-weight-bold text-muted small" style="font-size: 0.7rem;">Selected Partner</span>
                            <h6 class="font-weight-bold text-dark mt-1 mb-1">{{ $selectedPartner->partner_clinic_name }}</h6>
                            <div class="small text-muted"><i class="fa-solid fa-user mr-1"></i>{{ $selectedPartner->partner_contact_person_name }}</div>
                            <div class="small text-muted"><i class="fa-solid fa-phone mr-1"></i>{{ $selectedPartner->partner_mobile_number }}</div>
                        </div>
                    @else
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark"><i class="fa-solid fa-hospital-user text-primary mr-1"></i> Select Partner Clinic <span class="text-danger">*</span></label>
                            <select name="dw_partner_id" class="form-control" style="border-radius: 8px;" required>
                                <option value="">-- Choose Partner Clinic --</option>
                                @foreach($allPartners as $p)
                                    <option value="{{ $p->id }}">{{ $p->partner_clinic_name }} ({{ $p->partner_contact_person_name }} - {{ $p->partner_mobile_number }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-headset text-primary mr-1"></i> Communication Channel <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" style="border-radius: 8px;" required>
                            <option value="cll" {{ old('type') == 'cll' ? 'selected' : '' }}>Phone Call</option>
                            <option value="message" {{ old('type') == 'message' ? 'selected' : '' }}>WhatsApp / SMS Message</option>
                            <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both (Call & Message)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-calendar-days text-primary mr-1"></i> Follow-up Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" style="border-radius: 8px;" value="{{ old('date', now()->toDateString()) }}" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-comment-dots text-primary mr-1"></i> Discussion Summary / Remarks <span class="text-danger">*</span></label>
                        <textarea name="remarks" rows="4" class="form-control" placeholder="What was discussed? Next action items..." style="border-radius: 8px;" required>{{ old('remarks') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-2" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-check mr-1"></i> Save Follow-up Log
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Side: Log History -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-clock-rotate-left text-primary mr-2"></i>Communication History
                    <span class="badge badge-secondary ml-2">{{ count($followups) }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                        <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <tr>
                                <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                                <th class="py-3 px-3 text-secondary font-weight-bold">Date</th>
                                <th class="py-3 px-3 text-secondary font-weight-bold">Partner Details</th>
                                <th class="py-3 px-3 text-secondary font-weight-bold text-center">Type</th>
                                <th class="py-3 px-3 text-secondary font-weight-bold">Notes / Discussion</th>
                                <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($followups as $followup)
                            <tr>
                                <td class="py-3 px-3 text-muted font-weight-bold">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3 px-3 font-weight-bold text-dark">
                                    <i class="fa-regular fa-calendar text-primary mr-1"></i>
                                    {{ \Carbon\Carbon::parse($followup->date)->format('d M, Y') }}
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-weight-bold text-dark">{{ $followup->partner->partner_clinic_name ?? 'N/A' }}</div>
                                    <div class="text-muted small"><i class="fa-solid fa-user mr-1"></i>{{ $followup->partner->partner_contact_person_name ?? 'N/A' }}</div>
                                    <div class="text-muted small"><i class="fa-solid fa-phone mr-1"></i>{{ $followup->partner->partner_mobile_number ?? 'N/A' }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($followup->type == 'cll')
                                        <span class="badge badge-info px-2 py-1 font-weight-bold" style="background: #e0f2fe; color: #0369a1; border-radius: 6px;"><i class="fa fa-phone mr-1"></i> Call</span>
                                    @elseif($followup->type == 'message')
                                        <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 6px;"><i class="fa-solid fa-message mr-1"></i> Msg</span>
                                    @else
                                        <span class="badge badge-primary px-2 py-1 font-weight-bold" style="background: #ede9fe; color: #4f46e5; border-radius: 6px;"><i class="fa-solid fa-volume-high mr-1"></i> Both</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-muted">
                                    <div style="line-height: 1.4; max-width: 250px;">{{ $followup->remarks }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button type="button" data-target="#myDeleteModal{{$followup->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Record">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-phone-slash fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                                    <h5 class="text-muted font-weight-bold">No Follow-up Logs Recorded</h5>
                                    <p class="text-muted small mb-0">Use the form on the left to add your first communication entry.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach ($followups as $followup)
<div class="modal fade" id="myDeleteModal{{$followup->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.followup.delete', $followup->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Follow-up Log?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete this follow-up entry? This action cannot be undone.</p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-light px-4 mr-2" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4 font-weight-bold" style="border-radius: 8px;">Confirm Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
