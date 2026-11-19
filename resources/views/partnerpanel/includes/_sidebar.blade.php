@php
    $regTypes = $registrationTypes ?? (Auth::guard('partner')->user() ? Auth::guard('partner')->user()->registration_type ?? [] : []);
    if (is_string($regTypes)) {
        $regTypes = json_decode($regTypes, true) ?? explode(',', $regTypes);
    }
    $regTypes = is_array($regTypes) ? $regTypes : [];

    $isProfileActive = request()->is('partnerpanel/partner-profile*') || request()->is('partnerpanel/partner-about-clinic*') || request()->is('partnerpanel/partner-service-lists*') || request()->is('partnerpanel/partner-gallery*');
    $isOpdActive = request()->is('partnerpanel/partner-opd*');
    $isPathActive = request()->is('partnerpanel/partner-pathology*');
    $isPatientsActive = request()->is('partnerpanel/partner-patient-profile-request*') || request()->is('partnerpanel/patient-profile-all-request*') || request()->is('partnerpanel/patient-user-profile-view*');
    $isSubActive = request()->is('partnerpanel/partner-get-subscription*') || request()->is('partnerpanel/partner-show-invoice*');
    $isTicketsActive = request()->is('partnerpanel/partner-get-ticket*') || request()->is('partnerpanel/partner-show-ticket*');
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Section: Overview -->
        <li class="sidebar-category-header">Main Overview</li>

        <li class="nav-item {{ request()->is('partnerpanel/partner-dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/partnerpanel/partner-dashboard">
                <i class="fa-solid fa-chart-pie nav-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Section: Clinic & Profile -->
        <li class="sidebar-category-header">Clinic & Profile</li>

        <li class="nav-item {{ $isProfileActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-partner-profile" aria-expanded="{{ $isProfileActive ? 'true' : 'false' }}" aria-controls="ui-partner-profile">
                <i class="fa-solid fa-hospital nav-icon"></i>
                <span class="menu-title">Profile & Details</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isProfileActive ? 'show' : '' }}" id="ui-partner-profile">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-profile') ? 'active' : '' }}" href="/partnerpanel/partner-profile">Profile Settings</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-about-clinic') ? 'active' : '' }}" href="/partnerpanel/partner-about-clinic">About Clinic</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-service-lists') ? 'active' : '' }}" href="/partnerpanel/partner-service-lists">Service List</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-gallery') ? 'active' : '' }}" href="/partnerpanel/partner-gallery">Photo Gallery</a></li>
                </ul>
            </div>
        </li>

        <!-- Section: Services (OPD / Pathology / Doctor) -->
        <li class="sidebar-category-header">Medical Services</li>

        @if(in_array('Doctor', $regTypes))
        <li class="nav-item {{ request()->is('partnerpanel/partner-doctors*') ? 'active' : '' }}">
            <a class="nav-link" href="/partnerpanel/partner-doctors">
                <i class="fa-solid fa-stethoscope nav-icon"></i>
                <span class="menu-title">Doctor Profile</span>
            </a>
        </li>
        @endif

        @if(in_array('OPD', $regTypes))
        <li class="nav-item {{ $isOpdActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-partner-opd" aria-expanded="{{ $isOpdActive ? 'true' : 'false' }}" aria-controls="ui-partner-opd">
                <i class="fa-solid fa-clinic-medical nav-icon"></i>
                <span class="menu-title">OPD Chambers</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isOpdActive ? 'show' : '' }}" id="ui-partner-opd">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-opd-contact') ? 'active' : '' }}" href="/partnerpanel/partner-opd-contact">OPD Contact</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-opd') ? 'active' : '' }}" href="/partnerpanel/partner-opd">Upload OPD Doctors</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-opd-show') ? 'active' : '' }}" href="/partnerpanel/partner-opd-show">View OPD Chambers</a></li>
                </ul>
            </div>
        </li>
        @endif

        @if(in_array('Pathology', $regTypes))
        <li class="nav-item {{ $isPathActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-partner-path" aria-expanded="{{ $isPathActive ? 'true' : 'false' }}" aria-controls="ui-partner-path">
                <i class="fa-solid fa-flask-vial nav-icon"></i>
                <span class="menu-title">Pathology Lab</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isPathActive ? 'show' : '' }}" id="ui-partner-path">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-pathology-contact') ? 'active' : '' }}" href="/partnerpanel/partner-pathology-contact">Pathology Contact</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-pathology') ? 'active' : '' }}" href="/partnerpanel/partner-pathology">Upload Tests</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-pathology-show') ? 'active' : '' }}" href="/partnerpanel/partner-pathology-show">View Tests List</a></li>
                </ul>
            </div>
        </li>
        @endif

        <!-- Section: Patients & Clinical Care -->
        <li class="sidebar-category-header">Patient Care</li>

        <li class="nav-item {{ $isPatientsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-partner-patients" aria-expanded="{{ $isPatientsActive ? 'true' : 'false' }}" aria-controls="ui-partner-patients">
                <i class="fa-solid fa-hospital-user nav-icon"></i>
                <span class="menu-title">Patient Records</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isPatientsActive ? 'show' : '' }}" id="ui-partner-patients">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-patient-profile-request') ? 'active' : '' }}" href="/partnerpanel/partner-patient-profile-request">Send Request</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/patient-profile-all-request') ? 'active' : '' }}" href="/partnerpanel/patient-profile-all-request">All Profiles</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ request()->is('partnerpanel/partner-inquiry-from-patients*') ? 'active' : '' }}">
            <a class="nav-link" href="/partnerpanel/partner-inquiry-from-patients">
                <i class="fa-solid fa-hand-holding-medical nav-icon"></i>
                <span class="menu-title">Patient Inquiries</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('partnerpanel/partner-feedbacks*') ? 'active' : '' }}">
            <a class="nav-link" href="/partnerpanel/partner-feedbacks">
                <i class="fa-solid fa-star nav-icon"></i>
                <span class="menu-title">Patient Reviews</span>
            </a>
        </li>

        <!-- Section: Billing & Help -->
        <li class="sidebar-category-header">Billing & Support</li>

        <li class="nav-item {{ $isSubActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-partner-sub" aria-expanded="{{ $isSubActive ? 'true' : 'false' }}" aria-controls="ui-partner-sub">
                <i class="fa-solid fa-credit-card nav-icon"></i>
                <span class="menu-title">Subscription</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isSubActive ? 'show' : '' }}" id="ui-partner-sub">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-get-subscription') ? 'active' : '' }}" href="/partnerpanel/partner-get-subscription">My Plan & Renewal</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-show-invoice') ? 'active' : '' }}" href="/partnerpanel/partner-show-invoice">Billing Invoices</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ $isTicketsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-partner-tickets" aria-expanded="{{ $isTicketsActive ? 'true' : 'false' }}" aria-controls="ui-partner-tickets">
                <i class="fa-solid fa-headset nav-icon"></i>
                <span class="menu-title">Support Tickets</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isTicketsActive ? 'show' : '' }}" id="ui-partner-tickets">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-get-ticket') ? 'active' : '' }}" href="/partnerpanel/partner-get-ticket">Open Ticket</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('partnerpanel/partner-show-ticket') ? 'active' : '' }}" href="/partnerpanel/partner-show-ticket">Ticket History</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
