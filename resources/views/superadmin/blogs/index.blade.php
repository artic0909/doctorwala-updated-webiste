@extends('layouts.superadmin')

@section('title', 'Manage Blogs | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-blog text-primary mr-2"></i>Health & Medical Blogs
            </h3>
            <p class="text-muted mb-0">Publish health articles, medical news, and wellness tips to the Doctorwala portal.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <button type="button" class="btn btn-primary font-weight-bold shadow-sm" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;" data-toggle="modal" data-target="#myAddModal">
                <i class="fa-solid fa-plus mr-1"></i> Add New Blog
            </button>
        </div>
    </div>
</div>

<!-- Search & Date Filter Bar -->
<div class="card border-0 shadow-sm mb-4 filter-card" style="border-radius: 12px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ url('/superadmin/super-blogs') }}" class="row g-2 align-items-end">
            <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-search mr-1"></i> Search</label>
                <input type="text" name="search" class="form-control" placeholder="Blog title or content..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-calendar-alt mr-1"></i> From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                <label class="small text-muted font-weight-bold mb-1"><i class="fa fa-calendar-alt mr-1"></i> To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3 col-sm-12 d-flex">
                <button type="submit" class="btn btn-primary font-weight-bold flex-grow-1 mr-2" style="height: 42px; border-radius: 8px;">
                    <i class="fa fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ url('/superadmin/super-blogs') }}" class="btn btn-light font-weight-bold" style="height: 42px; border-radius: 8px; border: 1px solid #cbd5e1;" title="Reset filters">
                    <i class="fa fa-redo text-muted"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-newspaper text-primary mr-2"></i>Published Blogs
            <span class="badge badge-secondary ml-2">{{ $blogs->total() }}</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 50px;">SL.</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Cover Image</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Blog Title</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center">Content</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">
                            {{ ($blogs->currentPage() - 1) * $blogs->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-3 px-3">
                            @if($blog->blg_image)
                                <img src="{{ asset('storage/' . $blog->blg_image) }}" alt="Blog Image" style="width: 110px; height: 65px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 110px; height: 65px; border: 1px solid #e2e8f0;">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-3">
                            <h6 class="font-weight-bold text-dark mb-1 text-capitalize">{{ $blog->blg_title }}</h6>
                            <span class="text-muted small">Added: {{ $blog->created_at ? $blog->created_at->format('d M, Y') : 'N/A' }}</span>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <button type="button" data-target="#myDescModal{{ $blog->id }}" data-toggle="modal" class="btn btn-sm btn-outline-info" style="border-radius: 6px;">
                                <i class="fa-solid fa-eye mr-1"></i> Preview
                            </button>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="d-flex justify-content-center" style="gap: 8px;">
                                <button type="button" data-target="#myEditModal{{ $blog->id }}" data-toggle="modal" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 4px 8px;" title="Edit Blog">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" data-target="#myDeleteModal{{ $blog->id }}" data-toggle="modal" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px;" title="Delete Blog">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-newspaper fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5 class="text-muted font-weight-bold">No Blogs Published Yet</h5>
                            <p class="text-muted small mb-0">Click the "Add New Blog" button above to publish your first health article.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-pagination-footer">
        <div class="text-muted small mb-2 mb-md-0 font-weight-bold">
            Showing {{ $blogs->firstItem() ?? 0 }} to {{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }} published blogs
        </div>
        <div>{{ $blogs->links('pagination::bootstrap-4') }}</div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="myAddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-plus-circle text-primary mr-2"></i>Create New Blog Post
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-blog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-image text-primary mr-1"></i> Cover Image <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" name="blg_image" id="blg_image" accept="image/*" style="border-radius: 8px;" required>
                        <small class="text-muted">Recommended dimension: 1200x630 px (JPEG, PNG, WEBP, Max 2MB).</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-heading text-primary mr-1"></i> Blog Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="blg_title" id="blg_title" placeholder="Enter an engaging blog headline..." style="border-radius: 8px;" required>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-paragraph text-primary mr-1"></i> Content & Details <span class="text-danger">*</span>
                        </label>
                        <textarea name="blg_desc" id="blg_desc" class="form-control editor" rows="8"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-upload mr-1"></i> Publish Blog
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach ($blogs as $blog)
<div class="modal fade" id="myEditModal{{ $blog->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-pen-to-square text-primary mr-2"></i>Edit Blog Post
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.super-blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    @if($blog->blg_image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $blog->blg_image) }}" alt="Cover" style="max-height: 180px; width: auto; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div class="small text-muted mt-1">Current Cover Image</div>
                    </div>
                    @endif

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-image text-primary mr-1"></i> Replace Image (Optional)
                        </label>
                        <input type="file" class="form-control" name="blg_image" accept="image/*" style="border-radius: 8px;">
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-heading text-primary mr-1"></i> Blog Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="blg_title" value="{{ $blog->blg_title }}" style="border-radius: 8px;" required>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-paragraph text-primary mr-1"></i> Content & Details <span class="text-danger">*</span>
                        </label>
                        <textarea name="blg_desc" id="blg_desc_{{ $blog->id }}" class="form-control editor" rows="8">{{ $blog->blg_desc }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 14px 14px;">
                    <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold" style="border-radius: 8px;">
                        <i class="fa-solid fa-check mr-1"></i> Update Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Preview Modals -->
@foreach ($blogs as $blog)
<div class="modal fade" id="myDescModal{{ $blog->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <div class="modal-header bg-light" style="border-radius: 14px 14px 0 0;">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="fa-solid fa-book-open text-primary mr-2"></i>{{ $blog->blg_title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                @if($blog->blg_image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $blog->blg_image) }}" alt="Cover" class="img-fluid rounded shadow-sm" style="max-height: 250px; width: auto;">
                </div>
                @endif
                <div class="blog-preview-content" style="font-size: 0.95rem; line-height: 1.7; color: #334155;">
                    {!! $blog->blg_desc !!}
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-secondary font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Modals -->
@foreach ($blogs as $blog)
<div class="modal fade" id="myDeleteModal{{ $blog->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 14px;">
            <form action="{{ route('superadmin.super-blog.delete', $blog->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-trash-can fa-3x text-danger"></i>
                    </div>
                    <h4 class="font-weight-bold text-dark">Delete Blog Article?</h4>
                    <p class="text-muted mb-4">Are you sure you want to delete "<b>{{ $blog->blg_title }}</b>"? This action cannot be undone.</p>
                    <div class="d-flex justify-content-center" style="gap: 12px;">
                        <button type="button" class="btn btn-light px-4 font-weight-bold" style="border-radius: 8px;" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4 font-weight-bold" style="border-radius: 8px;">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.editor').forEach(textarea => {
            ClassicEditor
                .create(textarea, {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>
@endpush
