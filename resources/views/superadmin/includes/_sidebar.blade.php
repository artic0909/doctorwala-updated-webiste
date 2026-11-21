<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Section: Overview -->
        <li class="sidebar-category-header">Main Overview</li>
        
        <li class="nav-item {{ request()->is('superadmin/super-dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-dashboard">
                <i class="fa-solid fa-chart-pie nav-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- Appointments (Top Level) --}}
        @php
            $isAppointmentsActive = request()->is('superadmin/super-opd-inquiry*') || 
                                    request()->is('superadmin/super-path-inquiry*') || 
                                    request()->is('superadmin/super-doc-inquiry*') || 
                                    request()->is('superadmin/super-user-inquiry*');
        @endphp
        <li class="nav-item {{ $isAppointmentsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-appointments" aria-expanded="{{ $isAppointmentsActive ? 'true' : 'false' }}" aria-controls="ui-appointments">
                <i class="fa-solid fa-calendar-check nav-icon"></i>
                <span class="menu-title">Appointments</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isAppointmentsActive ? 'show' : '' }}" id="ui-appointments">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-opd-inquiry*') ? 'active' : '' }}" href="/superadmin/super-opd-inquiry">OPD Appointments</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-path-inquiry*') ? 'active' : '' }}" href="/superadmin/super-path-inquiry">Pathology Bookings</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-doc-inquiry*') ? 'active' : '' }}" href="/superadmin/super-doc-inquiry">Doctor Appointments</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-user-inquiry*') ? 'active' : '' }}" href="/superadmin/super-user-inquiry">User Inquiries</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-callings*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-callings">
                <i class="fa-solid fa-headset nav-icon"></i>
                <span class="menu-title">AI Voice Callings</span>
                <span class="badge badge-pill badge-primary ml-auto" style="font-size: 0.65rem; padding: 3px 6px;">AI</span>
            </a>
        </li>

        <!-- Section: Core Operations -->
        <li class="sidebar-category-header">Operations</li>

        {{-- 1. Healthcare Providers --}}
        @php
            $isHealthcareActive = request()->is('superadmin/super-all-partner*') || 
                                  request()->is('superadmin/super-add-partners*') || 
                                  request()->is('superadmin/importer*') ||
                                  request()->is('superadmin/super-all-doctors*') || 
                                  request()->is('superadmin/super-edit-doctors-details*') || 
                                  request()->is('superadmin/super-adddoc-banner*') ||
                                  request()->is('superadmin/super-all-others*') || 
                                  request()->is('superadmin/super-edit-others-details*') || 
                                  request()->is('superadmin/super-addothers-banner*') ||
                                  request()->is('superadmin/super-all-opd*') || 
                                  request()->is('superadmin/super-edit-opd-details*') || 
                                  request()->is('superadmin/super-addopd-doctor*') ||
                                  request()->is('superadmin/super-all-pathology*') || 
                                  request()->is('superadmin/super-edit-pathology-details*') || 
                                  request()->is('superadmin/super-addpath-test*');
        @endphp
        <li class="nav-item {{ $isHealthcareActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-healthcare" aria-expanded="{{ $isHealthcareActive ? 'true' : 'false' }}" aria-controls="ui-healthcare">
                <i class="fa-solid fa-hospital-user nav-icon"></i>
                <span class="menu-title">Healthcare Providers</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isHealthcareActive ? 'show' : '' }}" id="ui-healthcare">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-partner*') ? 'active' : '' }}" href="/superadmin/super-all-partner">All Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-add-partners*') ? 'active' : '' }}" href="/superadmin/super-add-partners">Add New Partner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-doctors*') || request()->is('superadmin/super-edit-doctors-details*') || request()->is('superadmin/super-adddoc-banner*') ? 'active' : '' }}" href="/superadmin/super-all-doctors">All Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-others*') || request()->is('superadmin/super-edit-others-details*') || request()->is('superadmin/super-addothers-banner*') ? 'active' : '' }}" href="/superadmin/super-all-others">Physiotherapy & Allied</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-opd*') || request()->is('superadmin/super-edit-opd-details*') || request()->is('superadmin/super-addopd-doctor*') ? 'active' : '' }}" href="/superadmin/super-all-opd">OPD Clinics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-pathology*') || request()->is('superadmin/super-edit-pathology-details*') || request()->is('superadmin/super-addpath-test*') ? 'active' : '' }}" href="/superadmin/super-all-pathology">Pathology Labs</a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- 2. Patients & Agent Network --}}
        @php
            $isNetworkActive = request()->is('superadmin/super-all-user*') || 
                               request()->is('superadmin/super-all-reffer*') ||
                               request()->is('superadmin/super-ep*') || 
                               request()->is('superadmin/super-gp*');
        @endphp
        <li class="nav-item {{ $isNetworkActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-network" aria-expanded="{{ $isNetworkActive ? 'true' : 'false' }}" aria-controls="ui-network">
                <i class="fa-solid fa-users-viewfinder nav-icon"></i>
                <span class="menu-title">Patients & Network</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isNetworkActive ? 'show' : '' }}" id="ui-network">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-user*') ? 'active' : '' }}" href="/superadmin/super-all-user">All Patients / Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-reffer*') ? 'active' : '' }}" href="/superadmin/super-all-reffer">Referral Records</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-ep*') ? 'active' : '' }}" href="/superadmin/super-ep">EP Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-gp*') ? 'active' : '' }}" href="/superadmin/super-gp">GP Management</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Section: Growth & Monetization -->
        <li class="sidebar-category-header">Growth & Marketing</li>

        {{-- 3. Banners & Marketing --}}
        @php
            $isMarketingActive = request()->is('superadmin/super-home-banner*') || 
                                 request()->is('superadmin/super-others-banner*') || 
                                 request()->is('superadmin/super-partner-carousel*') || 
                                 request()->is('superadmin/carousel*') ||
                                 request()->is('superadmin/super-followups*') || 
                                 request()->is('superadmin/bulkmessage*');
        @endphp
        <li class="nav-item {{ $isMarketingActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-marketing" aria-expanded="{{ $isMarketingActive ? 'true' : 'false' }}" aria-controls="ui-marketing">
                <i class="fa-solid fa-bullhorn nav-icon"></i>
                <span class="menu-title">Marketing & Outreach</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isMarketingActive ? 'show' : '' }}" id="ui-marketing">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-home-banner') ? 'active' : '' }}" href="/superadmin/super-home-banner">Home Banners</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-others-banner') ? 'active' : '' }}" href="/superadmin/super-others-banner">Others Banners</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-partner-carousel') ? 'active' : '' }}" href="/superadmin/super-partner-carousel">Partner Carousel</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-followups*') ? 'active' : '' }}" href="/superadmin/super-followups">Partner Follow-ups</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/bulkmessage*') ? 'active' : '' }}" href="/superadmin/bulkmessage">Bulk Messaging</a></li>
                </ul>
            </div>
        </li>

        <!-- Section: Support & Platform -->
        <li class="sidebar-category-header">Patient Care & Support</li>

        {{-- 5. Support & Helpdesk --}}
        @php
            $isSupportActive = request()->is('superadmin/super-all-tickets*') || 
                               request()->is('superadmin/super-ticket-replies*') || 
                               request()->is('superadmin/super-all-feedback*');
        @endphp
        <li class="nav-item {{ $isSupportActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-support" aria-expanded="{{ $isSupportActive ? 'true' : 'false' }}" aria-controls="ui-support">
                <i class="fa-solid fa-headset nav-icon"></i>
                <span class="menu-title">Helpdesk & Support</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isSupportActive ? 'show' : '' }}" id="ui-support">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-all-tickets*') ? 'active' : '' }}" href="/superadmin/super-all-tickets">All Tickets</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-ticket-replies*') ? 'active' : '' }}" href="/superadmin/super-ticket-replies">Ticket Replies</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-all-feedback*') ? 'active' : '' }}" href="/superadmin/super-all-feedback">Patient Feedbacks</a></li>
                </ul>
            </div>
        </li>

        {{-- 6. CMS & Settings --}}
        @php
            $isSettingsActive = request()->is('superadmin/super-blogs*') || 
                                request()->is('superadmin/super-aboutus*') ||
                                request()->is('superadmin/profile*');
        @endphp
        <li class="nav-item {{ $isSettingsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-settings" aria-expanded="{{ $isSettingsActive ? 'true' : 'false' }}" aria-controls="ui-settings">
                <i class="fa-solid fa-gear nav-icon"></i>
                <span class="menu-title">Portal & Settings</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isSettingsActive ? 'show' : '' }}" id="ui-settings">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-blogs*') ? 'active' : '' }}" href="/superadmin/super-blogs">Blog Articles</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-aboutus*') ? 'active' : '' }}" href="/superadmin/super-aboutus">About Us Page</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/profile*') ? 'active' : '' }}" href="{{ route('superadmin.profile.edit') }}">Admin Profile & Security</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>