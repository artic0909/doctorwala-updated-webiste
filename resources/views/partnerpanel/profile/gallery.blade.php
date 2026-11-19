@extends('layouts.partner')

@section('title', 'Clinic Photo Gallery | Partner Panel')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-images text-primary mr-2"></i>Clinic Photo Gallery
            </h3>
            <p class="text-muted mb-0">Upload photos of clinic reception, patient chambers, medical equipment, and diagnostic facilities.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <button type="button" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;" data-toggle="modal" data-target="#myAddModal">
                <i class="fa-solid fa-plus mr-1"></i> Add Photos
            </button>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-photo-film text-primary mr-2"></i>Uploaded Photos
            <span class="badge badge-secondary ml-2">{{ count($images) }}</span>
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row">
            @forelse($images as $index => $image)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card border shadow-none h-100 overflow-hidden" style="border-radius: 12px; border-color: #e2e8f0 !important;">
                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="img-fluid" style="height: 160px; width: 100%; object-fit: cover;">
                    <div class="card-body p-2 d-flex justify-content-between align-items-center bg-white border-top">
                        <span class="small font-weight-bold text-muted ml-1">Photo #{{ $loop->iteration }}</span>
                        <div class="d-flex" style="gap: 6px;">
                            <button type="button" data-toggle="modal" data-target="#myEditModal{{ $index }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 3px 8px;" title="Replace Photo">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#myDeleteModal{{ $index }}" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 3px 8px;" title="Delete Photo">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="myEditModal{{ $index }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
                        <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                            <h5 class="modal-title font-weight-bold text-dark">
                                <i class="fa-solid fa-pen-to-square text-primary mr-2"></i>Replace Photo #{{ $loop->iteration }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('partner.gallery.update', $index) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4 text-center">
                                <img src="{{ asset('storage/' . $image) }}" alt="Preview" class="img-fluid rounded shadow-sm mb-3" style="max-height: 160px;">
                                <div class="form-group text-left mb-0">
                                    <label class="font-weight-bold text-dark">Select Replacement Image <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="image" accept="image/*" style="height: 48px; border-radius: 8px;" required>
                                </div>
                            </div>
                            <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">Upload Replacement</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="myDeleteModal{{ $index }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow" style="border-radius: 14px;">
                        <div class="modal-body text-center p-4">
                            <div class="mb-3">
                                <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark">Delete Photo?</h4>
                            <p class="text-muted mb-4">Are you sure you want to remove this image from your clinic gallery?</p>
                            <form action="{{ route('partner.gallery.delete', $index) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="d-flex justify-content-center" style="gap: 12px;">
                                    <button type="button" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger px-4 font-weight-bold" style="border-radius: 8px;">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fa-solid fa-images fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                <h5 class="text-muted font-weight-bold">No Photos in Gallery</h5>
                <p class="text-muted small mb-0">Click the "Add Photos" button above to upload clinic premises images.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myAddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-cloud-arrow-up text-primary mr-2"></i>Upload Photos to Gallery
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('partner.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Choose Photos <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="images[]" multiple accept="image/*" style="height: auto; padding: 10px; border-radius: 8px;" required>
                        <small class="text-muted d-block mt-2">You can select multiple images (JPEG, PNG, JPG, Max 2MB each).</small>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">Upload Photos</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
