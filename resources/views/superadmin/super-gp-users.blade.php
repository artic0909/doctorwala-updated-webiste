<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super | Users under {{ $gp->name }} ({{ $gp->code }})</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('../partner-assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('../partner-assets/css/vertical-layout-light/style.css')}}">

    <link href="{{asset('fav5.png')}}" rel="icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .role-badge-gp {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: #fff !important;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        .ep-badge {
            background: #eef2ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
        }
        .status-badge-active {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
            padding: 4px 10px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .status-badge-inactive {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
            padding: 4px 10px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .code-pill {
            background-color: #f3f4f6;
            color: #1f2937;
            font-family: monospace;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px dashed #cbd5e1;
            font-size: 0.85rem;
        }
        .card-pill {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-family: monospace;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            border: 1px solid #bfdbfe;
        }
        .kpi-card {
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
    </style>
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

                <form method="GET" action="{{ route('superadmin.super-gp.users', $gp->id) }}" class="d-flex w-100 align-items-center ml-3">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search users by name, mobile, email, medical card..." class="form-control mr-2 w-100">
                    <button type="submit" class="btn btn-primary" style="height: 38px; white-space: nowrap;">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

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
                    <!-- dashboard -->
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
                                <li class="nav-item"> <a class="nav-link"
                                        href="/superadmin/super-partner-carousel">Partner Carousel</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- all user lists -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-user">
                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <span class="menu-title">All User</span>
                        </a>
                    </li>

                    <!-- referrals -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-all-reffer">
                            <i class="fa fa-gift" aria-hidden="true"></i>&nbsp; <span class="menu-title">Referrals</span>
                        </a>
                    </li>

                    <!-- EP Management -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-ep">
                            <i class="fa-solid fa-user-tie" aria-hidden="true"></i>&nbsp; <span class="menu-title">EP Management</span>
                        </a>
                    </li>

                    <!-- GP Management (Active) -->
                    <li class="nav-item active">
                        <a class="nav-link" href="/superadmin/super-gp">
                            <i class="fa-solid fa-users-gear" aria-hidden="true"></i>&nbsp; <span class="menu-title">GP Management</span>
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

                    <!-- blogs -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-blogs">
                            <i class="fa fa-blog" aria-hidden="true"></i>&nbsp; <span class="menu-title">Blogs</span>
                        </a>
                    </li>

                    <!-- coupons -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false"
                            aria-controls="ui-basic1">
                            <i class="fa fa-tag" aria-hidden="true"></i>&nbsp; <span
                                class="menu-title">Coupons</span><i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic1">
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

                    <!-- Inquiries -->
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

                    <!-- Tickets -->
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
                </ul>
            </nav>

            <!-- main-panel -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Top Bar: Back & GP Header Info -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                        <div class="d-flex align-items-center flex-wrap">
                            <a href="{{ route('superadmin.super-gp') }}" class="btn btn-outline-secondary btn-sm rounded mr-3 mb-2 mb-md-0 font-weight-bold shadow-sm">
                                <i class="fa fa-arrow-left mr-1"></i> Back to GPs
                            </a>
                            <div>
                                <h3 class="font-weight-bold text-dark mb-1 d-flex align-items-center flex-wrap">
                                    <span>Registered Users under:</span>
                                    <span class="text-success ml-2 font-weight-bold">{{ $gp->name }}</span>
                                    <span class="code-pill ml-2">{{ $gp->code }}</span>
                                </h3>
                                <p class="text-muted mb-0 small">
                                    Displaying all patients/users who registered using Gram Panchayat code <strong>{{ $gp->code }}</strong>.
                                </p>
                            </div>
                        </div>

                        <!-- Assigned EP Details Badge -->
                        <div class="mt-2 mt-md-0">
                            @if ($gp->ep)
                            <div class="card p-2 px-3 shadow-sm bg-white" style="border-radius: 10px; border-left: 4px solid #4f46e5;">
                                <div class="small text-muted font-weight-bold text-uppercase" style="font-size: 0.7rem;">Assigned Executive Partner (EP)</div>
                                <div class="font-weight-bold text-dark d-flex align-items-center">
                                    <i class="fa-solid fa-user-tie text-primary mr-1"></i>
                                    <span>{{ $gp->ep->name }}</span>
                                    <span class="code-pill ml-1 small">{{ $gp->ep->code }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- KPIs Row -->
                    <div class="row mb-4">
                        <div class="col-md-4 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Total Users Registered</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $totalUsers ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-users fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Registered This Month</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $thisMonthUsers ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-calendar-check fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3 stretch-card transparent">
                            <div class="card kpi-card" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: white;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-2 font-weight-bold text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.8px;">Registered Today</p>
                                            <h2 class="font-weight-bold mb-0 text-white">{{ $todayUsers ?? 0 }}</h2>
                                        </div>
                                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.15);">
                                            <i class="fa-solid fa-clock fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Card -->
                    <div class="card mb-4 shadow-sm" style="border-radius: 12px; border: none;">
                        <div class="card-body py-3">
                            <form method="GET" action="{{ route('superadmin.super-gp.users', $gp->id) }}">
                                <div class="row align-items-end">
                                    <!-- Search -->
                                    <div class="col-lg-4 col-md-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-search text-muted mr-1"></i> Search Keywords
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Name, Mobile, Email, Card No..." value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <!-- From Date -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-calendar text-muted mr-1"></i> From Registration Date
                                        </label>
                                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm">
                                    </div>

                                    <!-- To Date -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">
                                            <i class="fa fa-calendar text-muted mr-1"></i> To Registration Date
                                        </label>
                                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm">
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="col-lg-2 col-md-6 col-12 mb-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-sm px-3 mr-2 font-weight-bold rounded shadow-sm" style="min-width: 85px;">
                                            <i class="fa fa-filter mr-1"></i> Filter
                                        </button>
                                        <a href="{{ route('superadmin.super-gp.users', $gp->id) }}" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold rounded" title="Clear Filters">
                                            <i class="fa fa-rotate-left mr-1"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Main Table Card -->
                    <div class="card shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap">
                            <h5 class="mb-0 font-weight-bold text-dark">
                                <i class="fa-solid fa-users text-success mr-2"></i>Referred Patients / Users List
                                <span class="badge badge-secondary ml-2">{{ $users->total() }}</span>
                            </h5>
                            <span class="small text-muted font-weight-bold">
                                GP: <span class="text-success">{{ $gp->name }}</span> ({{ $gp->code }})
                            </span>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 60px;">#</th>
                                            <th>Member ID / Card No</th>
                                            <th>User Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>Registration Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $index => $user)
                                        <tr>
                                            <td class="text-center text-muted font-weight-bold">
                                                {{ $users->firstItem() + $index }}
                                            </td>

                                            <td>
                                                <div>
                                                    <span class="card-pill">{{ $user->memberid ?? 'N/A' }}</span>
                                                </div>
                                                @if ($user->medical_card_no)
                                                    <small class="text-muted font-monospace d-block mt-1 font-weight-500">
                                                        {{ $user->medical_card_no }}
                                                    </small>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="font-weight-bold text-dark">{{ $user->user_name }}</div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-phone text-muted mr-1 small"></i>
                                                    <a href="tel:{{ $user->user_mobile }}" class="text-dark font-weight-500 mr-2">
                                                        {{ $user->user_mobile }}
                                                    </a>
                                                    <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $user->user_mobile) }}" target="_blank"
                                                        class="badge badge-success p-1" title="Chat on WhatsApp">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </td>

                                            <td>
                                                @if ($user->user_email)
                                                    <a href="mailto:{{ $user->user_email }}" class="text-muted small">
                                                        <i class="fa fa-envelope mr-1 text-primary"></i> {{ $user->user_email }}
                                                    </a>
                                                @else
                                                    <span class="text-muted font-italic small">N/A</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge badge-light border text-dark font-weight-500">
                                                    <i class="fa fa-location-dot text-danger mr-1"></i> {{ $user->user_city ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td class="text-muted small">
                                                <i class="fa-regular fa-clock text-muted mr-1"></i>
                                                {{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="py-4">
                                                    <i class="fa-solid fa-users-slash fa-3x text-muted mb-3 d-block"></i>
                                                    <h5 class="text-muted font-weight-bold">No Users Found for this GP</h5>
                                                    <p class="text-muted small">No patients have registered using GP Code <strong>{{ $gp->code }}</strong> yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination Footer -->
                        @if ($users->hasPages())
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap py-3">
                            <div class="small text-muted mb-2 mb-md-0">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                            </div>
                            <div>
                                {{ $users->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        @endif
                    </div>

                </div>

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
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{asset('../partner-assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('../partner-assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('../partner-assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('../partner-assets/js/template.js')}}"></script>
    <script src="{{asset('../partner-assets/js/settings.js')}}"></script>
    <script src="{{asset('../partner-assets/js/todolist.js')}}"></script>
</body>

</html>
