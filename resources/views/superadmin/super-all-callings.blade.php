<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Super | AI Voice Callings (Riya Assistant)</title>

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

    <style>
        .badge-opd { background-color: #007bff; color: white; }
        .badge-path { background-color: #6f42c1; color: white; }
        .badge-doctor { background-color: #20c997; color: white; }
        .badge-both { background-color: #17a2b8; color: white; }
        .badge-hospital { background-color: #fd7e14; color: white; }
        .badge-medical { background-color: #343a40; color: white; }
        .table td, .table th { vertical-align: middle; }
        .transcript-box {
            background-color: #f8f9fa;
            border-left: 4px solid #4B49AC;
            padding: 15px;
            border-radius: 4px;
            max-height: 350px;
            overflow-y: auto;
            font-family: inherit;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .summary-box {
            background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
            border: 1px solid #b8daff;
            border-radius: 6px;
            padding: 12px 15px;
        }
        .webhook-card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: #f3f4f6;
            border-radius: 10px;
        }
        .code-pill {
            background: rgba(255, 255, 255, 0.12);
            color: #67e8f9;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.9rem;
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

                    <!-- GP Management -->
                    <li class="nav-item">
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

                    <!-- AI Voice Callings (Active) -->
                    <li class="nav-item active">
                        <a class="nav-link" href="/superadmin/super-callings">
                            <i class="fa-solid fa-headset" aria-hidden="true"></i>&nbsp; <span class="menu-title font-weight-bold">AI Callings</span>
                        </a>
                    </li>

                    <!-- Follow-ups -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/super-followups">
                            <i class="fa fa-phone-volume" aria-hidden="true"></i>&nbsp; <span class="menu-title">Follow-ups</span>
                        </a>
                    </li>

                    <!-- Bulk Message -->
                    <li class="nav-item">
                        <a class="nav-link" href="/superadmin/bulkmessage">
                            <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>&nbsp; <span class="menu-title">Bulk Message</span>
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
                                        href="/superadmin/super-add-subscriptions">Add Subscriptions</a>
                                </li>
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
                </ul>
            </nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Alert message -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fa-solid fa-circle-check mr-1"></i> Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Header Section -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h3 class="font-weight-bold text-dark mb-1">
                                <i class="fa-solid fa-headset text-primary mr-2"></i> AI Voice Calling Leads (Riya Assistant)
                            </h3>
                            <p class="text-muted mb-0">Automatic calling log, provider discovery details, transcripts, recordings, and webhook integration.</p>
                        </div>
                        <div class="col-md-4 text-md-right mt-2 mt-md-0">
                            <a href="{{ route('superadmin.export.callings', request()->query()) }}" class="btn btn-success btn-icon-text font-weight-bold">
                                <i class="fa-solid fa-file-excel mr-1"></i> Export to Excel
                            </a>
                        </div>
                    </div>

                    <!-- KPIs Row -->
                    <div class="row mb-4">
                        <div class="col-md mb-3 stretch-card">
                            <div class="card" style="background-color: #392C70; color: white; border-radius: 10px;">
                                <div class="card-body py-3">
                                    <p class="mb-2 text-uppercase font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Total Calls</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $totalCalls }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mb-3 stretch-card">
                            <div class="card" style="background-color: #10b981; color: white; border-radius: 10px;">
                                <div class="card-body py-3">
                                    <p class="mb-2 text-uppercase font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Leads Captured</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $leadsCaptured }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mb-3 stretch-card">
                            <div class="card" style="background-color: #f59e0b; color: white; border-radius: 10px;">
                                <div class="card-body py-3">
                                    <p class="mb-2 text-uppercase font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Callbacks</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $callbacksScheduled }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mb-3 stretch-card">
                            <div class="card" style="background-color: #0284c7; color: white; border-radius: 10px;">
                                <div class="card-body py-3">
                                    <p class="mb-2 text-uppercase font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Links Sent</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $linksSent }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md mb-3 stretch-card">
                            <div class="card" style="background-color: #ef4444; color: white; border-radius: 10px;">
                                <div class="card-body py-3">
                                    <p class="mb-2 text-uppercase font-weight-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">DND Marked</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $dndCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Webhook Connection Info Banner -->
                    <div class="card webhook-card mb-4 shadow">
                        <div class="card-body p-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div>
                                    <span class="badge badge-success px-2 py-1 mr-2"><i class="fa-solid fa-bolt"></i> VAPI WEBHOOK LIVE</span>
                                    <span class="font-weight-bold">Endpoint for Vapi AI Webhook / Server URL:</span>
                                    <code class="code-pill ml-1" id="vapiWebhookUrl">{{ url('/api/vapi/webhook') }}</code>
                                </div>
                                <div class="mt-2 mt-md-0">
                                    <button type="button" class="btn btn-sm btn-info" onclick="copyWebhookUrl()">
                                        <i class="fa-regular fa-copy mr-1"></i> Copy URL
                                    </button>
                                    <button class="btn btn-sm btn-outline-light ml-1" type="button" data-toggle="collapse" data-target="#vapiInstructions">
                                        <i class="fa-solid fa-circle-question mr-1"></i> Instructions
                                    </button>
                                </div>
                            </div>
                            <div class="collapse mt-3" id="vapiInstructions">
                                <hr style="border-color: rgba(255,255,255,0.15);">
                                <div class="row text-white-50" style="font-size: 0.88rem;">
                                    <div class="col-md-6 mb-2">
                                        <strong class="text-white">1. In Vapi AI Assistant Settings:</strong><br>
                                        Go to <em>Assistant &rarr; Advanced &rarr; Server URL</em> and paste the copied URL above.<br>
                                        Vapi will automatically deliver call updates, tool executions, and the final <code>end-of-call-report</code>.
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong class="text-white">2. Automatic Tool Handling:</strong><br>
                                        Supports Riya's tools: <span class="code-pill">save_lead</span>, <span class="code-pill">schedule_callback</span>, <span class="code-pill">send_link</span>, <span class="code-pill">mark_dnd</span>, and <span class="code-pill">end_call</span>.<br>
                                        The phone number called is automatically linked and stored in the <code>callings</code> table.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Card -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body py-3">
                            <form action="{{ route('superadmin.super-callings') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-lg-3 col-md-6 mb-2">
                                        <label class="font-weight-bold text-muted small mb-1">Search</label>
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="Phone, Provider, City, Doctor..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-lg-2 col-md-6 mb-2">
                                        <label class="font-weight-bold text-muted small mb-1">Provider Type</label>
                                        <select name="provider_type" class="form-control form-control-sm">
                                            <option value="">All Types</option>
                                            <option value="OPD" {{ request('provider_type') == 'OPD' ? 'selected' : '' }}>OPD</option>
                                            <option value="Path" {{ request('provider_type') == 'Path' ? 'selected' : '' }}>Pathology</option>
                                            <option value="Doctor" {{ request('provider_type') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                            <option value="Hospital" {{ request('provider_type') == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                                            <option value="Medical Shop" {{ request('provider_type') == 'Medical Shop' ? 'selected' : '' }}>Medical Shop</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-2">
                                        <label class="font-weight-bold text-muted small mb-1">Status</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All Statuses</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="callback" {{ request('status') == 'callback' ? 'selected' : '' }}>Callback Scheduled</option>
                                            <option value="link_sent" {{ request('status') == 'link_sent' ? 'selected' : '' }}>Link Sent</option>
                                            <option value="dnd" {{ request('status') == 'dnd' ? 'selected' : '' }}>DND</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-4 mb-2">
                                        <label class="font-weight-bold text-muted small mb-1">Language</label>
                                        <select name="language" class="form-control form-control-sm">
                                            <option value="">All Languages</option>
                                            <option value="Bengali" {{ request('language') == 'Bengali' ? 'selected' : '' }}>Bengali</option>
                                            <option value="Hindi" {{ request('language') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                            <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-2 d-flex">
                                        <button type="submit" class="btn btn-primary btn-sm flex-fill mr-1">
                                            <i class="fa-solid fa-filter mr-1"></i> Filter
                                        </button>
                                        <a href="{{ route('superadmin.super-callings') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                            <i class="fa-solid fa-rotate-right mr-1"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Main Table Card -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">Callings Records (Table: <code class="text-danger">callings</code>)</h4>
                                <span class="badge badge-info px-3 py-2 font-weight-bold">Total: {{ $callings->total() }}</span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Date & Time</th>
                                            <th>Phone Number</th>
                                            <th>Provider Name & Type</th>
                                            <th>Location</th>
                                            <th>Doctors / Tests</th>
                                            <th>Mode / Fees</th>
                                            <th>Language</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 130px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($callings as $call)
                                        <tr>
                                            <td><strong>{{ $call->id }}</strong></td>
                                            <td>
                                                <div class="small font-weight-bold">{{ $call->created_at ? $call->created_at->format('d M Y') : 'N/A' }}</div>
                                                <div class="text-muted small">{{ $call->created_at ? $call->created_at->format('h:i A') : '' }}</div>
                                                @if($call->duration_seconds)
                                                <span class="badge badge-light border mt-1"><i class="fa-regular fa-clock mr-1"></i>{{ $call->formatted_duration }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="font-weight-bold text-dark">
                                                    {{ $call->phone_number ?? 'Unknown' }}
                                                </div>
                                                <div class="mt-1 d-flex">
                                                    @if($call->phone_number)
                                                    <a href="tel:{{ $call->clean_phone }}" class="badge badge-primary mr-1" title="Call">
                                                        <i class="fa fa-phone"></i> Call
                                                    </a>
                                                    <a href="https://wa.me/{{ $call->clean_phone }}" target="_blank" class="badge badge-success" title="WhatsApp">
                                                        <i class="fa-brands fa-whatsapp"></i> Chat
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold text-dark" style="font-size: 0.95rem;">
                                                    {{ $call->provider_name ?? '— Pending Discovery —' }}
                                                </div>
                                                @if($call->provider_type)
                                                <span class="badge badge-info mt-1">{{ $call->provider_type }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($call->location)
                                                <i class="fa-solid fa-location-dot text-danger mr-1"></i>{{ $call->location }}
                                                @else
                                                <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($call->doctors_and_timings)
                                                <div class="small text-truncate" style="max-width: 180px;" title="{{ $call->doctors_and_timings }}">
                                                    <strong>Doc:</strong> {{ $call->doctors_and_timings }}
                                                </div>
                                                @endif
                                                @if($call->tests_offered)
                                                <div class="small text-truncate" style="max-width: 180px;" title="{{ $call->tests_offered }}">
                                                    <strong>Tests:</strong> {{ $call->tests_offered }}
                                                </div>
                                                @endif
                                                @if(!$call->doctors_and_timings && !$call->tests_offered)
                                                <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($call->consultation_modes)
                                                <span class="badge badge-secondary">{{ ucfirst($call->consultation_modes) }}</span><br>
                                                @endif
                                                @if($call->doctor_fee_known)
                                                <small class="text-muted">Fee: <strong>{{ $call->doctor_fee_known }}</strong></small>
                                                @endif
                                                @if(!$call->consultation_modes && !$call->doctor_fee_known)
                                                <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($call->language)
                                                <span class="badge badge-light border font-weight-bold">{{ $call->language }}</span>
                                                @else
                                                <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($call->app_link_sent)
                                                <span class="badge badge-success d-inline-block mb-1"><i class="fa fa-paper-plane mr-1"></i>Link Sent</span><br>
                                                @endif
                                                @if($call->callback_scheduled)
                                                <span class="badge badge-warning text-dark d-inline-block mb-1" title="{{ $call->callback_time }}"><i class="fa fa-calendar-check mr-1"></i>Callback</span><br>
                                                @endif
                                                @if($call->is_dnd)
                                                <span class="badge badge-danger d-inline-block mb-1"><i class="fa fa-ban mr-1"></i>DND</span><br>
                                                @endif
                                                @if(!$call->app_link_sent && !$call->callback_scheduled && !$call->is_dnd)
                                                <span class="badge badge-secondary">{{ ucfirst($call->call_status ?? 'completed') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-primary btn-sm p-2" data-toggle="modal" data-target="#detailModal{{ $call->id }}" title="View Full Details">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm p-2" data-toggle="modal" data-target="#deleteModal{{ $call->id }}" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-5">
                                                <i class="fa-solid fa-headset fa-3x text-muted mb-3 d-block"></i>
                                                <h5 class="text-muted">No Calling Records Found</h5>
                                                <p class="text-muted small">Configure your Vapi AI Voice Assistant Webhook using the URL above to start receiving calls automatically into this table.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                <div class="text-muted small mb-2 mb-md-0">
                                    Showing {{ $callings->firstItem() ?? 0 }} to {{ $callings->lastItem() ?? 0 }} of {{ $callings->total() }} entries
                                </div>
                                <div>
                                    {{ $callings->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modals Section -->
                @foreach($callings as $call)
                <!-- Detail Modal -->
                <div class="modal fade" id="detailModal{{ $call->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $call->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="detailModalLabel{{ $call->id }}">
                                    <i class="fa-solid fa-headset mr-2"></i> Call Log Details: {{ $call->provider_name ?? ($call->phone_number ?? 'Call #' . $call->id) }}
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-4">

                                <!-- Audio Player if recording URL exists -->
                                @if($call->recording_url)
                                <div class="card mb-3 border-primary">
                                    <div class="card-body py-2 px-3 bg-light d-flex align-items-center flex-wrap">
                                        <strong class="mr-3 text-primary"><i class="fa-solid fa-play-circle mr-1"></i> Call Recording:</strong>
                                        <audio controls style="flex-grow: 1; max-width: 100%;">
                                            <source src="{{ $call->recording_url }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </div>
                                @endif

                                <!-- AI Summary -->
                                @if($call->summary)
                                <div class="summary-box mb-3">
                                    <h6 class="font-weight-bold text-primary mb-1"><i class="fa-solid fa-sparkles mr-1"></i> AI Conversation Summary</h6>
                                    <p class="mb-0 text-dark" style="line-height: 1.5;">{{ $call->summary }}</p>
                                </div>
                                @endif

                                <!-- Key Info Grid -->
                                <div class="card border mb-3">
                                    <div class="card-header bg-light py-2 font-weight-bold text-dark">
                                        <i class="fa-solid fa-info-circle mr-1 text-primary"></i> Provider & Discovery Information
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 35%;" class="font-weight-bold text-muted">Calling Phone Number:</td>
                                                    <td>
                                                        <strong class="text-dark">{{ $call->phone_number ?? 'N/A' }}</strong>
                                                        @if($call->phone_number)
                                                        <a href="tel:{{ $call->clean_phone }}" class="ml-2 badge badge-primary"><i class="fa fa-phone"></i> Call</a>
                                                        <a href="https://wa.me/{{ $call->clean_phone }}" target="_blank" class="ml-1 badge badge-success"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Provider Name:</td>
                                                    <td><strong class="text-primary">{{ $call->provider_name ?? 'Not Provided' }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Provider Type:</td>
                                                    <td>{{ $call->provider_type ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Location:</td>
                                                    <td>{{ $call->location ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Doctors and Timings:</td>
                                                    <td>{{ $call->doctors_and_timings ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Consultation Mode:</td>
                                                    <td>{{ $call->consultation_modes ? ucfirst($call->consultation_modes) : 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Doctor Fee:</td>
                                                    <td>{{ $call->doctor_fee_known ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Tests Offered:</td>
                                                    <td>{{ $call->tests_offered ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Rates List Exists:</td>
                                                    <td>{{ $call->rates_list_exists ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Home Sample Collection:</td>
                                                    <td>{{ $call->home_sample_collection ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Language:</td>
                                                    <td>{{ $call->language ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Partner App Link Sent:</td>
                                                    <td>
                                                        @if($call->app_link_sent)
                                                        <span class="badge badge-success"><i class="fa fa-check mr-1"></i> Sent via WhatsApp/SMS</span>
                                                        @else
                                                        <span class="badge badge-secondary">Not Sent</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Callback Scheduled:</td>
                                                    <td>
                                                        @if($call->callback_scheduled)
                                                        <span class="badge badge-warning text-dark"><i class="fa fa-calendar-check mr-1"></i> Yes: {{ $call->callback_time }}</span>
                                                        @if($call->callback_notes)
                                                        <div class="small text-muted mt-1">Notes: {{ $call->callback_notes }}</div>
                                                        @endif
                                                        @else
                                                        <span class="badge badge-light border">No</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">DND (Do Not Disturb):</td>
                                                    <td>
                                                        @if($call->is_dnd)
                                                        <span class="badge badge-danger"><i class="fa fa-ban mr-1"></i> Marked DND</span>
                                                        @else
                                                        <span class="badge badge-light border">No</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Call Status / Duration:</td>
                                                    <td>
                                                        <span class="badge badge-info">{{ ucfirst($call->call_status ?? 'completed') }}</span>
                                                        <span class="ml-2 text-muted">Duration: {{ $call->formatted_duration }}</span>
                                                        @if($call->ended_reason)
                                                        <span class="ml-2 text-muted">({{ $call->ended_reason }})</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($call->vapi_call_id)
                                                <tr>
                                                    <td class="font-weight-bold text-muted">Vapi Call ID:</td>
                                                    <td><code>{{ $call->vapi_call_id }}</code></td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Call Transcript -->
                                @if($call->transcript)
                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-dark mb-2">
                                        <i class="fa-solid fa-comment-dots mr-1 text-primary"></i> Call Transcript
                                    </h6>
                                    <div class="transcript-box">{{ $call->transcript }}</div>
                                </div>
                                @endif

                                <!-- Raw Webhook Payload Collapsible -->
                                @if($call->raw_payload)
                                <div class="mt-2">
                                    <a class="btn btn-sm btn-outline-secondary" data-toggle="collapse" href="#rawJson{{ $call->id }}" role="button">
                                        <i class="fa-solid fa-code mr-1"></i> View Raw Vapi Payload
                                    </a>
                                    <div class="collapse mt-2" id="rawJson{{ $call->id }}">
                                        <pre class="bg-dark text-white p-3 rounded small" style="max-height: 250px; overflow-y: auto;">{{ json_encode($call->raw_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                                @endif

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal{{ $call->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ route('superadmin.super-callings.delete', $call->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body text-center p-4">
                                    <i class="fa-solid fa-trash-can fa-3x text-danger mb-3"></i>
                                    <h4>Delete Calling Record?</h4>
                                    <p class="text-muted">Are you sure you want to delete call record #{{ $call->id }} ({{ $call->phone_number ?? 'No Number' }})? This action cannot be undone.</p>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger font-weight-bold">Confirm Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. <a
                                href="https://doctorwala.info/" target="_blank">Doctorwala.info</a> -
                            All rights reserved.</span>
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
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{asset('../partner-assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('../partner-assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('../partner-assets/js/template.js')}}"></script>
    <script src="{{asset('../partner-assets/js/settings.js')}}"></script>
    <script src="{{asset('../partner-assets/js/todolist.js')}}"></script>
    <!-- endinject -->

    <script>
        function copyWebhookUrl() {
            var url = document.getElementById('vapiWebhookUrl').innerText;
            navigator.clipboard.writeText(url).then(function() {
                alert('Webhook URL copied to clipboard: ' + url);
            }).catch(function(err) {
                console.error('Could not copy: ', err);
            });
        }
    </script>
</body>

</html>

