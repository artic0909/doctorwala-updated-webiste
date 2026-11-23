@extends('layouts.partner')

@section('title', 'Bank Details | Doctorwala')

@section('content')
<!-- Page Header -->
<div class="row align-items-center mb-4">
    <div class="col-md-7 mb-3 mb-md-0">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-building-columns fa-xl"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">Bank Details & Payout Accounts</h3>
                <p class="text-muted mb-0" style="font-size: 0.88rem;">Manage your bank account details for direct consultation fee disbursements and withdrawals</p>
            </div>
        </div>
    </div>
    <div class="col-md-5 text-md-right">
        <a href="{{ route('partner.wallet.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 mr-2" style="border-radius: 8px;">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Wallet
        </a>
        <button type="button" class="btn btn-primary btn-sm px-3 py-2 font-weight-medium" style="border-radius: 8px;" data-toggle="modal" data-target="#addBankModal">
            <i class="fa-solid fa-plus mr-1"></i> Add Bank Account
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
    <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
    <div class="font-weight-bold mb-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Please correct the errors below:</div>
    <ul class="mb-0 pl-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Bank Accounts Grid -->
<div class="row">
    @forelse($bankAccounts as $bank)
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-radius: 14px; {{ $bank->is_primary ? 'border: 2px solid #0284c7 !important;' : 'border: 1px solid #e2e8f0 !important;' }}">
            @if($bank->is_primary)
            <div class="position-absolute" style="top: 0; right: 0; background: #0284c7; color: #fff; font-size: 0.72rem; font-weight: 700; padding: 4px 14px; border-bottom-left-radius: 10px; letter-spacing: 0.5px;">
                <i class="fa-solid fa-circle-check mr-1"></i> PRIMARY ACCOUNT
            </div>
            @endif

            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 44px; height: 44px; background: #f0fdf4; color: #16a34a; font-size: 1.2rem;">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold mb-0 text-dark">{{ $bank->bank_name }}</h5>
                        <small class="text-muted">{{ $bank->branch_name ?: 'Main Branch' }}</small>
                    </div>
                </div>

                <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                    <div class="row mb-2">
                        <div class="col-5 text-muted" style="font-size: 0.82rem;">Account Number</div>
                        <div class="col-7 font-weight-bold font-monospace text-dark" style="font-size: 0.95rem; letter-spacing: 1px;">
                            {{ $bank->masked_account_no }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted" style="font-size: 0.82rem;">IFSC Code</div>
                        <div class="col-7 font-weight-bold font-monospace text-primary" style="font-size: 0.88rem;">
                            {{ $bank->ifsc_code }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted" style="font-size: 0.82rem;">Account Holder</div>
                        <div class="col-7 font-weight-semibold text-dark" style="font-size: 0.88rem;">
                            {{ $bank->account_holder_name ?: $partner->partner_contact_person_name }}
                        </div>
                    </div>
                    @if($bank->upi_id)
                    <div class="row">
                        <div class="col-5 text-muted" style="font-size: 0.82rem;">UPI ID</div>
                        <div class="col-7 font-weight-medium text-info font-monospace" style="font-size: 0.85rem;">
                            {{ $bank->upi_id }}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="d-flex align-items-center justify-content-between pt-2">
                    <div>
                        @if(!$bank->is_primary)
                        <form method="POST" action="{{ route('partner.bank.details.primary', $bank->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; font-size: 0.78rem;">
                                <i class="fa-solid fa-star mr-1"></i> Make Primary
                            </button>
                        </form>
                        @else
                        <span class="badge badge-light text-primary font-weight-bold py-1 px-2" style="font-size: 0.78rem;">
                            <i class="fa-solid fa-lock mr-1"></i> Default Payout
                        </span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-light text-primary mr-2" style="border-radius: 6px;" data-toggle="modal" data-target="#editBankModal{{ $bank->id }}" title="Edit Details">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                        </button>

                        <button type="button" class="btn btn-sm btn-light text-danger" style="border-radius: 6px;" data-toggle="modal" data-target="#deleteBankModal{{ $bank->id }}" title="Delete Account">
                            <i class="fa-solid fa-trash-can mr-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Bank Modal -->
    <div class="modal fade" id="editBankModal{{ $bank->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fa-solid fa-pen-to-square text-primary mr-2"></i> Edit Bank Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('partner.bank.details.update', $bank->id) }}">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Bank Name <span class="text-danger">*</span></label>
                            <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $bank->bank_name) }}" required placeholder="e.g., State Bank of India">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Account Number <span class="text-danger">*</span></label>
                            <input type="text" name="account_no" class="form-control font-monospace" value="{{ old('account_no', $bank->account_no) }}" required placeholder="Enter full bank account number">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">IFSC Code <span class="text-danger">*</span></label>
                                <input type="text" name="ifsc_code" class="form-control font-monospace text-uppercase" value="{{ old('ifsc_code', $bank->ifsc_code) }}" required placeholder="e.g., SBIN0001234">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Branch Name</label>
                                <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name', $bank->branch_name) }}" placeholder="e.g., Park Street">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Account Holder Name</label>
                            <input type="text" name="account_holder_name" class="form-control" value="{{ old('account_holder_name', $bank->account_holder_name) }}" placeholder="Name as in bank passbook">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">UPI ID (Optional)</label>
                            <input type="text" name="upi_id" class="form-control font-monospace" value="{{ old('upi_id', $bank->upi_id) }}" placeholder="e.g., doctor@okhdfcbank">
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="is_primary_{{ $bank->id }}" name="is_primary" value="1" {{ $bank->is_primary ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-medium text-dark" for="is_primary_{{ $bank->id }}">
                                Set as Primary Account for Payouts
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div class="modal fade" id="deleteBankModal{{ $bank->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-body text-center p-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; background: #fee2e2; color: #dc2626;">
                        <i class="fa-solid fa-trash-can fa-lg"></i>
                    </div>
                    <h5 class="font-weight-bold mb-2">Delete Account?</h5>
                    <p class="text-muted mb-3" style="font-size: 0.85rem;">Are you sure you want to remove <strong>{{ $bank->bank_name }}</strong> (ending in {{ substr($bank->account_no, -4) }})?</p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-light btn-sm mr-2 px-3" data-dismiss="modal">Cancel</button>
                        <form method="POST" action="{{ route('partner.bank.details.delete', $bank->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm px-3">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 14px;">
            <div class="card-body">
                <i class="fa-solid fa-building-columns fa-3x mb-3 text-black-50"></i>
                <h4 class="font-weight-bold text-dark mb-1">No Bank Accounts Added Yet</h4>
                <p class="text-muted mb-3" style="max-width: 460px; margin: 0 auto; font-size: 0.9rem;">Add your official bank account details so that consultation payments and fees can be settled to your bank directly.</p>
                <button type="button" class="btn btn-primary px-4 py-2 font-weight-medium" style="border-radius: 8px;" data-toggle="modal" data-target="#addBankModal">
                    <i class="fa-solid fa-plus mr-1"></i> Add Bank Account Now
                </button>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Add Bank Account Modal -->
<div class="modal fade" id="addBankModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold text-dark"><i class="fa-solid fa-building-columns text-primary mr-2"></i> Add Bank Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('partner.bank.details.store') }}">
                @csrf
                <div class="modal-body py-3">
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Bank Name <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}" required placeholder="e.g., State Bank of India, HDFC Bank">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Account Number <span class="text-danger">*</span></label>
                        <input type="text" name="account_no" class="form-control font-monospace" value="{{ old('account_no') }}" required placeholder="Enter full bank account number">
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">IFSC Code <span class="text-danger">*</span></label>
                            <input type="text" name="ifsc_code" class="form-control font-monospace text-uppercase" value="{{ old('ifsc_code') }}" required placeholder="e.g., SBIN0001234">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Branch Name</label>
                            <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name') }}" placeholder="e.g., Salt Lake Sector V">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">Account Holder Name</label>
                        <input type="text" name="account_holder_name" class="form-control" value="{{ old('account_holder_name', $partner->partner_contact_person_name) }}" placeholder="Name as per bank passbook">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" style="font-size: 0.85rem;">UPI ID (Optional)</label>
                        <input type="text" name="upi_id" class="form-control font-monospace" value="{{ old('upi_id') }}" placeholder="e.g., doctor@okhdfcbank">
                    </div>
                    <div class="custom-control custom-checkbox mt-2">
                        <input type="checkbox" class="custom-control-input" id="is_primary_new" name="is_primary" value="1" {{ count($bankAccounts) === 0 ? 'checked' : '' }}>
                        <label class="custom-control-label font-weight-medium text-dark" for="is_primary_new">
                            Set as Primary Account for Payouts
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Save Bank Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
