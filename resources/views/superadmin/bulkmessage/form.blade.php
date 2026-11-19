@extends('layouts.superadmin')

@section('title', 'Bulk Broadcast Messaging | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-bullhorn text-primary mr-2"></i>Bulk Broadcast Messaging
            </h3>
            <p class="text-muted mb-0">Upload audience CSV and promotional template graphic to dispatch bulk communications.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-brands fa-whatsapp fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-1">Broadcast Campaign Setup</h5>
                        <p class="text-muted mb-0 small">Send high-volume WhatsApp campaign updates to patients or partners directly.</p>
                    </div>
                </div>

                <form method="POST" action="{{ url('/superadmin/bulkmessage/send') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-image text-primary mr-1"></i> Broadcast Template Graphic <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" name="image" accept="image/png, image/jpeg, image/jpg" style="border-radius: 8px;" required>
                        <small class="text-muted">Allowed formats: JPEG, PNG, JPG (Max 2MB file size).</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-file-csv text-success mr-1"></i> Recipient Contact CSV <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" name="csv_file" accept=".csv, .txt" style="border-radius: 8px;" required>
                        <small class="text-muted">The CSV should contain phone numbers (e.g. 9876543210). The first column is automatically parsed.</small>
                    </div>

                    <div class="p-3 rounded mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="font-weight-bold text-dark mb-1"><i class="fa-solid fa-circle-info text-info mr-1"></i> Delivery Notice</h6>
                        <p class="text-muted small mb-0">Messages are dispatched asynchronously through official provider APIs. Please ensure your CSV list is properly validated prior to submission.</p>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Send Broadcast
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
