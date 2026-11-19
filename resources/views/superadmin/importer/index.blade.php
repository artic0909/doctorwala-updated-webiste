@extends('layouts.superadmin')

@section('title', 'Partner CSV Importer | Super Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fa-solid fa-file-csv text-primary mr-2"></i>Bulk Partner Importer
            </h3>
            <p class="text-muted mb-0">Upload audience CSV to mass-register clinics, generate system credentials, and trigger WhatsApp notifications.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('superadmin.importer.template') }}" class="btn btn-outline-primary font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fa-solid fa-download mr-1"></i> Download CSV Template
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; background: #e0f2fe; color: #0284c7;">
                        <i class="fa-solid fa-cloud-arrow-up fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold text-dark mb-1">Upload Partner CSV</h5>
                        <p class="text-muted mb-0 small">Automatically activates partners and schedules welcome notifications.</p>
                    </div>
                </div>

                <form action="{{ route('superadmin.importer.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark">
                            <i class="fa-solid fa-file-excel text-success mr-1"></i> Choose Spreadsheet / CSV File <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required style="border-radius: 8px; height: auto; padding: 12px;">
                        <small class="text-muted">Ensure headers match the official template format (e.g. Clinic Name, Contact Person, Mobile, Email, State, City, Type).</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block font-weight-bold shadow-sm py-2" style="border-radius: 8px; background: #0284c7; border-color: #0284c7;">
                        <i class="fa-solid fa-upload mr-1"></i> Process & Import Partners
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('results'))
<div class="card border-0 shadow-sm mt-2" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark">
            <i class="fa-solid fa-list-check text-primary mr-2"></i>Import Execution Summary
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3 text-secondary font-weight-bold" style="width: 80px;">Row #</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Clinic Name</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold text-center" style="width: 140px;">Status</th>
                        <th class="py-3 px-3 text-secondary font-weight-bold">Details & Diagnostics</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('results') as $res)
                    <tr>
                        <td class="py-3 px-3 text-muted font-weight-bold">#{{ $res['row'] }}</td>
                        <td class="py-3 px-3 font-weight-bold text-dark">{{ $res['clinic'] }}</td>
                        <td class="py-3 px-3 text-center">
                            @if($res['status'] === 'Success')
                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="background: #dcfce7; color: #15803d; border-radius: 6px;">
                                    <i class="fa-solid fa-check mr-1"></i> Success
                                </span>
                            @elseif($res['status'] === 'Warning')
                                <span class="badge badge-warning px-2 py-1 font-weight-bold" style="background: #fef3c7; color: #b45309; border-radius: 6px;">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> Skipped
                                </span>
                            @else
                                <span class="badge badge-danger px-2 py-1 font-weight-bold" style="background: #fee2e2; color: #b91c1c; border-radius: 6px;">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Error
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-muted">{{ $res['message'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
