<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super | Follow-up Tracking</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('../partner-assets/js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->

    <link href="{{asset('fav5.png')}}" rel="icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="/superadmin/super-dashboard" style="font-weight: 900;"><img
                        src="{{asset('../img/logo3.png')}}" alt="logo"></a>
                <a class="navbar-brand brand-logo-mini" href="/superadmin/super-dashboard"><img src="{{asset('fav5.png')}}"
                        alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <input type="search" id="search" placeholder="Search by Partner, Type or Remarks here ........" name="search"
                    class="form-control mx-4 w-100">

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{asset('fav5.png')}}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    <i class="ti-power-off text-primary"></i>
                                    Logout
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <!-- dasboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-dashboard">
                            <i class="fa-solid fa-chart-pie"></i>&nbsp; <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <!-- banners -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="fa fa-image" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Banners</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-home-banner">Home Banner</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-others-banner">Others Banner</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- all user lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-user">
                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span class="menu-title">All User</span>
                        </a>
                    </li>

                    <!-- all partners lists -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic12t" aria-expanded="false"
                            aria-controls="ui-basic12t">
                            <i class="fa fa-users" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Partners</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic12t">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-add-partners">Add Partners</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-all-partner">All Partners</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- all OPD lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-opd">
                            <i class="fa fa-user-doctor" aria-hidden="true"></i>&nbsp; <span class="menu-title">All OPD</span>
                        </a>
                    </li>

                    <!-- all pathology lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-pathology">
                            <i class="fa fa-syringe" aria-hidden="true"></i>&nbsp; <span class="menu-title">All Pathology</span>
                        </a>
                    </li>

                    <!-- all doctor lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-doctors">
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp; <span class="menu-title">All Doctors</span>
                        </a>
                    </li>

                    <!-- about us -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-aboutus">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; <span class="menu-title">About Us</span>
                        </a>
                    </li>

                    <!-- blogs -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-blogs">
                            <i class="fa fa-blog" aria-hidden="true"></i>&nbsp; <span class="menu-title">Add Blogs</span>
                        </a>
                    </li>

                    <!-- user inquiry -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-user-inquiry">
                            <i class="fa-solid fa-comment"></i>&nbsp; <span class="menu-title">User Inquiry</span>
                        </a>
                    </li>

                    <!-- coupon -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic12" aria-expanded="false"
                            aria-controls="ui-basic12">
                            <i class="fa fa-gifts" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Coupons</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic12">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-add-coupons">Add Coupons</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-show-coupons">Show Coupons</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- subscription -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic123" aria-expanded="false"
                            aria-controls="ui-basic123">
                            <i class="fa fa-coins" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Subscription</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic123">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-add-subscriptions">Add Subscriptions</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-show-subscription">Show Subscriptions</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Inquiry from patients/user -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic132" aria-expanded="false"
                            aria-controls="ui-basic132">
                            <i class="fa fa-hand-holding-medical" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Inquiries</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic132">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-opd-inquiry">All OPD Inq</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-path-inquiry">All Path Inq</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-doc-inquiry">All Doc Inq</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Ticket management -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic111" aria-expanded="false"
                            aria-controls="ui-basic111">
                            <i class="fa-solid fa-ticket"></i>&nbsp; <span class="menu-title">Tickets</span><i
                                class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic111">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-all-tickets">All Tickets</a></li>
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-ticket-replies">Replies</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Follow-ups standalone menu active -->
                    <li class="nav-item active">
                        <a class="nav-link" href="/superadmin/super-followups">
                            <i class="fa fa-phone-volume" aria-hidden="true"></i>&nbsp; <span class="menu-title">Follow-ups</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Title Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h3 class="font-weight-bold"><i class="fa fa-phone-volume text-danger"></i> Follow-up Tracking System</h3>
                            <p class="text-muted">Manage, schedule, and track communications with clinical and diagnostics partners.</p>
                        </div>
                    </div>

                    <!-- Split Grid Content -->
                    <div class="row">
                        <!-- Left Side: Mini Form (col-md-4) -->
                        <div class="col-lg-4 col-md-12 grid-margin stretch-card">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold mb-3"><i class="fa-solid fa-plus text-danger"></i> Add Follow-up</h4>
                                    
                                    <form action="{{ route('superadmin.followup.store') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label for="dw_partner_id" class="font-weight-bold"><i class="fa fa-hospital text-danger mr-1"></i> Select Partner <span class="text-danger">*</span></label>
                                            <select name="dw_partner_id" id="dw_partner_id" class="form-control" style="height: 50px;" required>
                                                <option value="">-- Choose Partner --</option>
                                                @foreach($partners as $partner)
                                                    <option value="{{ $partner->id }}" {{ (old('dw_partner_id') ?? request('dw_partner_id')) == $partner->id ? 'selected' : '' }}>
                                                        {{ $partner->partner_clinic_name }} ({{ $partner->partner_contact_person_name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('dw_partner_id')
                                                <small class="text-danger font-weight-bold mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="type" class="font-weight-bold"><i class="fa-solid fa-circle-info text-danger mr-1"></i> Communication Type <span class="text-danger">*</span></label>
                                            <select name="type" id="type" class="form-control" style="height: 50px;" required>
                                                <option value="cll" {{ old('type') == 'cll' ? 'selected' : '' }}>Call</option>
                                                <option value="message" {{ old('type') == 'message' ? 'selected' : '' }}>Message</option>
                                                <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both (Call & Message)</option>
                                            </select>
                                            @error('type')
                                                <small class="text-danger font-weight-bold mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="date" class="font-weight-bold"><i class="fa-regular fa-calendar-days text-danger mr-1"></i> Date <span class="text-danger">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control" style="height: 50px;" value="{{ old('date', now()->toDateString()) }}" required>
                                            @error('date')
                                                <small class="text-danger font-weight-bold mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="remarks" class="font-weight-bold"><i class="fa-regular fa-comments text-danger mr-1"></i> Discussion / Remarks <span class="text-danger">*</span></label>
                                            <textarea name="remarks" id="remarks" rows="5" class="form-control" placeholder="Summarize the follow-up conversation notes here..." required>{{ old('remarks') }}</textarea>
                                            @error('remarks')
                                                <small class="text-danger font-weight-bold mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-danger btn-block rounded p-3 font-weight-bold shadow-sm">
                                            <i class="fa-solid fa-square-plus mr-1"></i> Add Record
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Show All Follow-ups (col-md-8) -->
                        <div class="col-lg-8 col-md-12 grid-margin stretch-card">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title font-weight-bold mb-0"><i class="fa-solid fa-list-check text-danger mr-1"></i> Communication Log Tracking</h4>
                                        <span class="badge badge-danger p-2 font-weight-bold">{{ count($followups) }} Entries</span>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered mt-2" id="followupsTable">
                                            <thead class="bg-light text-dark">
                                                <tr>
                                                    <th class="font-weight-bold text-center" style="width: 5%">SL.</th>
                                                    <th class="font-weight-bold" style="width: 15%">Date</th>
                                                    <th class="font-weight-bold" style="width: 30%">Partner / Clinic Details</th>
                                                    <th class="font-weight-bold text-center" style="width: 15%">Type</th>
                                                    <th class="font-weight-bold" style="width: 25%">Remarks</th>
                                                    <th class="font-weight-bold text-center" style="width: 10%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($followups as $followup)
                                                    <tr>
                                                        <td class="text-center font-weight-bold"><b>{{ $loop->iteration }}</b></td>
                                                        <td>
                                                            <b class="text-danger"><i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($followup->date)->format('d-M-Y') }}</b>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">{{ $followup->partner->partner_clinic_name ?? 'N/A' }}</span>
                                                                <small class="text-muted mt-1"><i class="fa-regular fa-user mr-1"></i>{{ $followup->partner->partner_contact_person_name ?? 'N/A' }}</small>
                                                                <small class="text-muted"><i class="fa-solid fa-phone mr-1"></i>{{ $followup->partner->partner_mobile_number ?? 'N/A' }}</small>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($followup->type == 'cll')
                                                                <span class="badge badge-info p-2 rounded w-75"><i class="fa fa-phone mr-1"></i> Call</span>
                                                            @elseif($followup->type == 'message')
                                                                <span class="badge badge-success p-2 rounded w-75"><i class="fa-solid fa-message mr-1"></i> Message</span>
                                                            @else
                                                                <span class="badge badge-primary p-2 rounded w-75"><i class="fa-solid fa-volume-high mr-1"></i> Both</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="text-wrap text-muted" style="display: block; line-height: 1.4; font-size: 0.85rem;">{{ $followup->remarks }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" data-target="#myDeleteModal{{$followup->id}}" data-toggle="modal" class="btn btn-outline-danger btn-sm p-2 rounded">
                                                                <i class="fa-solid fa-trash-can"></i> Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted p-5">
                                                            <i class="fa-regular fa-folder-open fa-3x mb-3 text-muted"></i>
                                                            <p class="font-weight-bold">No follow-ups recorded yet.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modals -->
                @foreach ($followups as $followup)
                <div class="modal fade" id="myDeleteModal{{$followup->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="myDeleteModalLabel{{$followup->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form class="modal-body" action="{{ route('superadmin.followup.delete', $followup->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <div class="form-group d-flex flex-column align-items-center text-center p-4">
                                    <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                    <h3 class="font-weight-bold">Are You Sure?</h3>
                                    <p class="mt-2 text-muted">Do you really want to delete this follow-up record? This process is irreversible.</p>
                                    
                                    <div class="btnss d-flex justify-content-around align-items-center w-100 mt-4">
                                        <button type="button" class="btn btn-secondary rounded w-50 mr-3 p-2 font-weight-bold" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger rounded w-50 p-2 font-weight-bold">Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Success and Error alerts via Custom Dialogs -->
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                                <i class="fa-solid fa-circle-check fa-4x text-success mb-3"></i>
                                <h3 class="font-weight-bold text-success">Success</h3>
                                <h5 class="text-muted mt-2">{{ session('success') }}</h5>
                            </div>
                            <div class="modal-footer border-0 w-100 d-flex justify-content-center">
                                <button type="button" class="btn btn-primary w-100 p-2 font-weight-bold" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                                <i class="fa-solid fa-circle-xmark fa-4x text-danger mb-3"></i>
                                <h3 class="font-weight-bold text-danger">Error</h3>
                                <h5 class="text-muted mt-2">{{ session('error') }}</h5>
                            </div>
                            <div class="modal-footer border-0 w-100 d-flex justify-content-center">
                                <button type="button" class="btn btn-primary w-100 p-2 font-weight-bold" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trigger Alerts if Session Messages Exist -->
                @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        successModal.show();
                    });
                </script>
                @endif

                @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                        errorModal.show();
                    });
                </script>
                @endif

                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. <a
                                href="https://doctorwala.info/" target="_blank">Doctorwala.info</a> - All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Easy-To-Use & made with
                            <i class="ti-heart text-danger ml-1"></i></span>
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Developed by <a
                                href="https://github.com/artic0909" target="_blank">SaklinMustak</a></span>
                    </div>
                </footer>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- plugins:js -->
    <script src="{{asset('../partner-assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('../partner-assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('../partner-assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('../partner-assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('../partner-assets/js/dataTables.select.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('../partner-assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('../partner-assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('../partner-assets/js/template.js')}}"></script>
    <script src="{{asset('../partner-assets/js/settings.js')}}"></script>
    <script src="{{asset('../partner-assets/js/todolist.js')}}"></script>
    <!-- endinject -->

    <!-- Live Dynamic Search Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const query = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('#followupsTable tbody tr');

                    rows.forEach(row => {
                        // Skip if it is the empty placeholder row
                        if (row.cells.length === 1 && row.cells[0].colSpan === 6) return;

                        const dateText = row.cells[1].textContent.toLowerCase();
                        const partnerText = row.cells[2].textContent.toLowerCase();
                        const typeText = row.cells[3].textContent.toLowerCase();
                        const remarksText = row.cells[4].textContent.toLowerCase();

                        if (dateText.includes(query) || partnerText.includes(query) || typeText.includes(query) || remarksText.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>
