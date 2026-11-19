@extends('layouts.partner')

@section('title', 'About Clinic | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-circle-info text-primary mr-2"></i>About Clinic & Practice
            </h3>
            <p class="text-muted mb-0">Describe your clinical background, mission, and patient care vision shown on public profiles.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/partnerpanel/partner-profile" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Profile Settings
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-hospital text-primary mr-2"></i>Clinic Vision & Mission Profile
        </h5>
    </div>
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('partner.about.details.store') }}">
            @csrf
            <div class="row">
                <div class="col-12 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-circle-info text-primary mr-1"></i> About Clinic / Practice Story <span class="text-danger">*</span></label>
                    <textarea name="about_details" class="form-control" rows="5" placeholder="Share your clinic history, medical facilities, expertise, and doctor credentials..." style="border-radius: 8px;" required>{{ $aboutDetails->about_details ?? '' }}</textarea>
                </div>

                <div class="col-12 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-users-viewfinder text-success mr-1"></i> Clinic Mission <span class="text-danger">*</span></label>
                    <textarea name="mission_details" class="form-control" rows="4" placeholder="Your commitment to patient care, accessibility, and high clinical standards..." style="border-radius: 8px;" required>{{ $aboutDetails->mission_details ?? '' }}</textarea>
                </div>

                <div class="col-12 form-group mb-4">
                    <label class="font-weight-bold text-dark"><i class="fa-solid fa-eye text-primary mr-1"></i> Clinic Vision <span class="text-danger">*</span></label>
                    <textarea name="vision_details" class="form-control" rows="4" placeholder="Your long-term aspirations for advancing regional healthcare and patient well-being..." style="border-radius: 8px;" required>{{ $aboutDetails->vision_details ?? '' }}</textarea>
                </div>

                <div class="col-12 d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-check mr-1"></i> {{ $aboutDetails ? 'Update Details' : 'Save Details' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
