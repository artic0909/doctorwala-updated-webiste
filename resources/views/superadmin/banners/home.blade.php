@extends('layouts.superadmin')

@section('title', 'Home Banners | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-images text-primary mr-2"></i>Home Page Banners
            </h3>
            <p class="text-muted mb-0">Manage promotional slides displayed on the main patient application homepage.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <button type="button" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;" data-toggle="modal" data-target="#myAddModal">
                <i class="fa-solid fa-plus mr-1"></i> Add Home Banner
            </button>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            All Home Banners
            <span class="badge badge-secondary ml-2">{{ count($banners) }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 60px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Banner Preview</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Title</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Short Description</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banners as $banner)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-3 px-3">
                            <img src="{{ asset('storage/' . $banner->banner_image) }}" alt="Banner"
                                 style="width: 140px; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                        </td>
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $banner->title }}
                        </td>
                        <td class="py-3 px-3 text-muted">
                            {{ $banner->desc ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myEditModal{{$banner->id}}" data-toggle="modal" class="btn btn-sm btn-outline-primary mr-1" style="border-radius: 6px; padding: 4px 8px;" title="Edit Banner">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" data-target="#myDeleteModal{{$banner->id}}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Banner">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-images fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Home Banners Found</h5>
                            <p class="text-muted small">Click "Add Home Banner" above to publish your first banner.</p>
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
                    <i class="fa-solid fa-plus mr-2"></i> Add Home Banner
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.homebanner.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Banner Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="banner_image" accept="image/*" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-heading text-primary mr-1"></i> Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Banner Headline" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-align-left text-primary mr-1"></i> Short Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="desc" rows="3" placeholder="Brief subtitle or offer text" style="border-radius: 8px;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold" style="border-radius: 8px;">Upload Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach ($banners as $banner)
<div class="modal fade" id="myEditModal{{$banner->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-dark text-white" style="border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h5 class="modal-title font-weight-bold">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Home Banner
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('superadmin.homebanner.update' , $banner->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $banner->banner_image) }}" alt="Preview" style="max-height: 120px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-image text-primary mr-1"></i> Replace Image <small class="text-muted">(Optional)</small></label>
                        <input type="file" class="form-control" name="banner_image" accept="image/*" style="border-radius: 8px;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-heading text-primary mr-1"></i> Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{$banner->title}}" style="border-radius: 8px;" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark"><i class="fa-solid fa-align-left text-primary mr-1"></i> Short Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="desc" rows="3" style="border-radius: 8px;" required>{{$banner->desc}}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                    <button type="button" class="btn btn-secondary" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold" style="border-radius: 8px;">Update Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modals -->
<div class="modal fade" id="myDeleteModal{{$banner->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{route('superadmin.homebanner.delete', $banner->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444;">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </div>
                    <h4 class="font-weight-bold mb-2 text-dark">Delete Home Banner?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete this banner? This action cannot be undone.</p>
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
