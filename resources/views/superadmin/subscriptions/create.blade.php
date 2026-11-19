@extends('layouts.superadmin')

@section('title', 'Add Subscription Plan | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-shield-halved text-primary mr-2"></i>Create New Subscription Plan
            </h3>
            <p class="text-muted mb-0">Configure partner subscription plans, pricing, validity periods, and included features.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.super-subs.show') }}" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-list mr-1"></i> View All Subscriptions
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('superadmin.super-subs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5 class="font-weight-bold text-dark border-bottom pb-2 mb-4">
                        <i class="fa-solid fa-file-invoice-dollar text-primary mr-2"></i>Plan Information
                    </h5>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-heading text-primary mr-1"></i> Plan Title / Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="subs_title" value="{{ old('subs_title') }}" placeholder="e.g. Premium Medical Partner" style="border-radius: 8px;" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa fa-indian-rupee-sign text-primary mr-1"></i> Subscription Amount (₹) <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" class="form-control" name="subs_amount" value="{{ old('subs_amount') }}" placeholder="e.g. 4999" style="border-radius: 8px;" required>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-image text-primary mr-1"></i> Subscription Banner / Badge <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" name="subs_image" accept="image/*" style="border-radius: 8px;" required>
                            <small class="text-muted">Recommended: 600x400 PNG or JPG badge image.</small>
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa-solid fa-calendar-days text-primary mr-1"></i> Opening Date
                            </label>
                            <input type="date" class="form-control" name="opening_date" value="{{ old('opening_date', date('Y-m-d')) }}" style="border-radius: 8px;">
                            <small class="text-muted">Defaults to today if unselected.</small>
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label class="font-weight-bold text-dark">
                                <i class="fa fa-calendar-xmark text-primary mr-1"></i> Validity Duration <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" name="closing_date" style="border-radius: 8px;" required>
                                <option value="" selected>Select Duration</option>
                                <option value="6 Months" {{ old('closing_date') == '6 Months' ? 'selected' : '' }}>6 Months</option>
                                <option value="1 Year" {{ old('closing_date') == '1 Year' ? 'selected' : '' }}>1 Year</option>
                                <option value="2 Years" {{ old('closing_date') == '2 Years' ? 'selected' : '' }}>2 Years</option>
                                <option value="5 Years" {{ old('closing_date') == '5 Years' ? 'selected' : '' }}>5 Years</option>
                            </select>
                        </div>
                    </div>

                    <h5 class="font-weight-bold text-dark border-bottom pb-2 mt-4 mb-3">
                        <i class="fa-solid fa-list-check text-primary mr-2"></i>Included Features & Benefits
                    </h5>

                    <div id="add-same-section">
                        <div class="row align-items-center mb-3 feature-row">
                            <div class="col-md-9 mb-2 mb-md-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i class="fa-solid fa-check text-success"></i></span>
                                    </div>
                                    <input type="text" class="form-control border-left-0" name="features[]" placeholder="e.g. Unlimited OPD doctor profiles" style="border-radius: 0 8px 8px 0;" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="add-section-button" class="btn btn-outline-primary font-weight-bold w-100 shadow-sm" style="border-radius: 8px;">
                                    <i class="fa-solid fa-plus mr-1"></i> Add Feature
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                        <a href="{{ route('superadmin.super-subs.show') }}" class="btn btn-light px-4 mr-2" style="border-radius: 8px;">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                            <i class="fa-solid fa-check mr-2"></i> Save Subscription Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBtn = document.getElementById('add-section-button');
        const container = document.getElementById('add-same-section');

        if (addBtn && container) {
            addBtn.addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.className = 'row align-items-center mb-3 feature-row';
                newRow.innerHTML = `
                    <div class="col-md-9 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"><i class="fa-solid fa-check text-success"></i></span>
                            </div>
                            <input type="text" class="form-control border-left-0" name="features[]" placeholder="Enter feature description..." style="border-radius: 0 8px 8px 0;" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-danger font-weight-bold w-100 remove-feature-btn" style="border-radius: 8px;">
                            <i class="fa-solid fa-trash-can mr-1"></i> Remove
                        </button>
                    </div>
                `;
                container.appendChild(newRow);

                newRow.querySelector('.remove-feature-btn').addEventListener('click', function () {
                    newRow.remove();
                });
            });
        }
    });
</script>
@endpush
