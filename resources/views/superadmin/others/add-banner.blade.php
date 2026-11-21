@extends('layouts.superadmin')

@section('title', 'Physiotherapy Banner | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-image text-primary mr-2" style="color: #0d9488 !important;"></i>Physiotherapy & Allied Care Banner
            </h3>
            <p class="text-muted mb-0">Partner ID: <span class="badge badge-primary px-2 py-1 font-weight-bold" style="background: #0d9488;">#{{ $pid }}</span> &bull; Upload and manage public profile hero banner for this provider.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="/superadmin/super-all-others" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px; color: #0d9488; border-color: #0d9488;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to All Providers
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-cloud-arrow-up mr-2" style="color: #0d9488;"></i>Upload Provider Profile Banner
        </h5>
    </div>
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('superadmin.super-addothers.banner') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currently_loggedin_partner_id" value="{{ $pid }}">

            <div class="row align-items-center">
                <div class="col-md-5 text-center mb-4 mb-md-0">
                    @if($docBanner && isset($docBanner->doctorbanner))
                        <img src="{{ asset('storage/' . $docBanner->doctorbanner) }}" alt="Banner" class="img-fluid rounded shadow-sm" style="max-height: 200px; border: 1px solid #e2e8f0; object-fit: cover;">
                        <div class="small text-muted mt-2 font-weight-bold">Current Active Banner</div>
                    @else
                        <div class="rounded p-5 d-flex flex-column align-items-center justify-content-center text-muted" style="background: #f8fafc; border: 2px dashed #cbd5e1; height: 200px;">
                            <i class="fa-solid fa-image fa-3x mb-2 text-secondary" style="opacity: 0.6;"></i>
                            <span class="font-weight-bold">No banner uploaded yet</span>
                            <span class="small text-muted mt-1">Upload a professional banner to highlight this provider.</span>
                        </div>
                    @endif
                </div>

                <div class="col-md-7">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-upload text-primary mr-1" style="color: #0d9488 !important;"></i> Choose Banner Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="doctorbanner" style="height: 48px; border-radius: 8px;" accept="image/*" required>
                        <small class="text-muted d-block mt-2">Recommended resolution: 1200x500 px. Supported formats: JPEG, PNG, WEBP (Max 2MB).</small>
                    </div>

                    <div class="d-flex" style="gap: 12px;">
                        <a href="/superadmin/super-all-others" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px; background: #0d9488; border-color: #0d9488;">
                            <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Save Banner Image
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
