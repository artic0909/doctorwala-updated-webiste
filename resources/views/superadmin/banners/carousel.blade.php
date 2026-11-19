@extends('layouts.superadmin')

@section('title', 'Partner Carousel | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-layer-group text-primary mr-2"></i>Partner Carousel Banners
            </h3>
            <p class="text-muted mb-0">Manage slides featured on partner facing landing zones and carousel widgets.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <button type="button" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;" data-toggle="modal" data-target="#myAddModal">
                <i class="fa-solid fa-plus mr-1"></i> Add Carousel Slide
            </button>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            All Carousel Slides
            <span class="badge badge-secondary ml-2">{{ count($carousels) }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Slide Preview</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Title</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Description</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($carousels as $carousel)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-3 px-3">
                            <img src="{{ asset('storage/' . $carousel->image) }}" alt="Carousel Slide"
                                 style="width: 140px; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $carousel->title }}
                        </td>
                        <td class="py-3 px-3 text-muted">
                            {{ $carousel->description ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myEditModal{{$carousel->id}}" data-toggle="modal" class="btn btn-sm btn-outline-primary mr-1" style="border-radius: 6px; padding: 4px 8px;" title="Edit Slide">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" data-target="#myDeleteModal{{$carousel->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Slide">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-layer-group fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Carousel Slides Found</h5>
                            <p class="text-muted small">Click "Add Carousel Slide" above to configure banner slides.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myAddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-plus mr-2"></i> Add Carousel Slide
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.partner.carousel.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Slide Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image" accept="image/*" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-heading text-primary mr-1"></i> Headline Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Slide headline" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-align-left text-primary mr-1"></i> Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Brief slide text" style="border-radius: 8px;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold" style="border-radius: 8px;">Upload Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach ($carousels as $carousel)
<div class="modal fade" id="myEditModal{{$carousel->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-dark text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Carousel Slide
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.partner.carousel.update', $carousel->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $carousel->image) }}" alt="Preview" style="max-height: 120px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Replace Image <small class="text-muted">(Optional)</small></label>
                        <input type="file" class="form-control" name="image" accept="image/*" style="border-radius: 8px;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-heading text-primary mr-1"></i> Headline Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{$carousel->title}}" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-align-left text-primary mr-1"></i> Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="3" style="border-radius: 8px;" required>{{$carousel->description}}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold" style="border-radius: 8px;">Update Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modals -->
<div class="modal fade" id="myDeleteModal{{$carousel->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{route('superadmin.partner.carousel.delete', $carousel->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Carousel Slide?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete this slide? This action cannot be undone.</p>
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
