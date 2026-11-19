@extends('layouts.partner')

@section('title', 'Raise Support Ticket | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-headset text-primary mr-2"></i>Raise Support Ticket
            </h3>
            <p class="text-muted mb-0">Submit a query, technical issue, or account assistance request directly to the Doctorwala support desk.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/partnerpanel/partner-show-ticket" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-ticket mr-1"></i> View Ticket History
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fa-solid fa-ticket-simple text-primary mr-2"></i>New Support Ticket
                </h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('partner.inquiries.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="currently_loggedin_partner_id" value="{{ $partner->partner_id }}">

                    <div class="p-3 mb-4 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <span class="text-uppercase font-weight-bold text-muted small" style="font-size: 0.75rem;">Account Information</span>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <span class="text-muted small d-block">Partner ID</span>
                                <span class="font-weight-bold text-primary">#{{ $partner->partner_id }}</span>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted small d-block">Clinic Name</span>
                                <span class="font-weight-bold text-dark">{{ $partner->partner_clinic_name }}</span>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted small d-block">Contact Person</span>
                                <span class="font-weight-bold text-dark">{{ $partner->partner_contact_person_name }}</span>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted small d-block">Phone / Email</span>
                                <span class="font-weight-bold text-dark">{{ $partner->partner_mobile_number }}</span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="partner_clinic_name" value="{{ $partner->partner_clinic_name }}">
                    <input type="hidden" name="partner_contact_person_name" value="{{ $partner->partner_contact_person_name }}">
                    <input type="hidden" name="partner_mobile_number" value="{{ $partner->partner_mobile_number }}">
                    <input type="hidden" name="partner_email" value="{{ $partner->partner_email }}">
                    <input type="hidden" name="partner_state" value="{{ $partner->partner_state }}">
                    <input type="hidden" name="partner_city" value="{{ $partner->partner_city }}">
                    <input type="hidden" name="partner_landmark" value="{{ $partner->partner_landmark }}">
                    <input type="hidden" name="partner_pincode" value="{{ $partner->partner_pincode }}">

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-circle-question text-primary mr-1"></i> Problem Description / Query Details <span class="text-danger">*</span>
                        </label>
                        <textarea name="partner_problem" id="partner_problem" class="form-control" rows="8" placeholder="Please describe your issue, questions about subscriptions, features, or technical bugs in detail..." style="border-radius: 8px;" required>{{ old('partner_problem') }}</textarea>
                        <small class="text-muted">Our support team reviews tickets promptly and responds within 24 hours.</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Submit Support Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
