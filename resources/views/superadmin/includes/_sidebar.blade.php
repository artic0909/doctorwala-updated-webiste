<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Section: Main Overview -->
        <li class="sidebar-category-header">Main Overview</li>
        
        <li class="nav-item {{ request()->is('superadmin/super-dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-dashboard">
                <i class="fa-solid fa-chart-pie nav-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-callings*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-callings">
                <i class="fa-solid fa-headset nav-icon"></i>
                <span class="menu-title">AI Voice Callings</span>
                <span class="badge badge-pill badge-primary ml-auto" style="font-size: 0.65rem; padding: 3px 6px;">AI</span>
            </a>
        </li>

        <!-- Section: Medical Providers -->
        <li class="sidebar-category-header">Healthcare Providers</li>

        @php
            $isPartnersActive = request()->is('superadmin/super-all-partner*') || request()->is('superadmin/super-add-partners*') || request()->is('superadmin/importer*');
        @endphp
        <li class="nav-item {{ $isPartnersActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-partners" aria-expanded="{{ $isPartnersActive ? 'true' : 'false' }}" aria-controls="ui-partners">
                <i class="fa-solid fa-hospital-user nav-icon"></i>
                <span class="menu-title">Partners</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isPartnersActive ? 'show' : '' }}" id="ui-partners">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-add-partners') ? 'active' : '' }}" href="/superadmin/super-add-partners">Add Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-partner') ? 'active' : '' }}" href="/superadmin/super-all-partner">All Partners</a>
                    </li>
                </ul>
            </div>
        </li>

        @php
            $isClinicsActive = request()->is('superadmin/super-all-opd*') || request()->is('superadmin/super-edit-opd-details*') || request()->is('superadmin/super-addopd-doctor*') ||
                               request()->is('superadmin/super-all-pathology*') || request()->is('superadmin/super-edit-pathology-details*') || request()->is('superadmin/super-addpath-test*') ||
                               request()->is('superadmin/super-all-doctors*') || request()->is('superadmin/super-edit-doctors-details*') || request()->is('superadmin/super-adddoc-banner*');
        @endphp
        <li class="nav-item {{ $isClinicsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-clinics" aria-expanded="{{ $isClinicsActive ? 'true' : 'false' }}" aria-controls="ui-clinics">
                <i class="fa-solid fa-stethoscope nav-icon"></i>
                <span class="menu-title">Clinics & Doctors</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isClinicsActive ? 'show' : '' }}" id="ui-clinics">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-opd*') || request()->is('superadmin/super-edit-opd-details*') || request()->is('superadmin/super-addopd-doctor*') ? 'active' : '' }}" href="/superadmin/super-all-opd">OPD Clinics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-pathology*') || request()->is('superadmin/super-edit-pathology-details*') || request()->is('superadmin/super-addpath-test*') ? 'active' : '' }}" href="/superadmin/super-all-pathology">Pathology Labs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-doctors*') || request()->is('superadmin/super-edit-doctors-details*') || request()->is('superadmin/super-adddoc-banner*') ? 'active' : '' }}" href="/superadmin/super-all-doctors">All Doctors</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Section: Users & Agent Network -->
        <li class="sidebar-category-header">Users & Network</li>

        @php
            $isUsersActive = request()->is('superadmin/super-all-user*') || request()->is('superadmin/super-all-reffer*');
        @endphp
        <li class="nav-item {{ $isUsersActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-users" aria-expanded="{{ $isUsersActive ? 'true' : 'false' }}" aria-controls="ui-users">
                <i class="fa-solid fa-users nav-icon"></i>
                <span class="menu-title">Patients & Referrals</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isUsersActive ? 'show' : '' }}" id="ui-users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-user*') ? 'active' : '' }}" href="/superadmin/super-all-user">All Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-all-reffer*') ? 'active' : '' }}" href="/superadmin/super-all-reffer">Referral Records</a>
                    </li>
                </ul>
            </div>
        </li>

        @php
            $isFieldActive = request()->is('superadmin/super-ep*') || request()->is('superadmin/super-gp*');
        @endphp
        <li class="nav-item {{ $isFieldActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-field-network" aria-expanded="{{ $isFieldActive ? 'true' : 'false' }}" aria-controls="ui-field-network">
                <i class="fa-solid fa-user-tie nav-icon"></i>
                <span class="menu-title">Field Network</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isFieldActive ? 'show' : '' }}" id="ui-field-network">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-ep*') ? 'active' : '' }}" href="/superadmin/super-ep">EP Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/super-gp*') ? 'active' : '' }}" href="/superadmin/super-gp">GP Management</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Section: Marketing & Growth -->
        <li class="sidebar-category-header">Marketing & Promo</li>

        @php
            $isBannersActive = request()->is('superadmin/super-home-banner*') || request()->is('superadmin/super-others-banner*') || request()->is('superadmin/super-partner-carousel*') || request()->is('superadmin/carousel*');
        @endphp
        <li class="nav-item {{ $isBannersActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="{{ $isBannersActive ? 'true' : 'false' }}" aria-controls="ui-banners">
                <i class="fa-solid fa-images nav-icon"></i>
                <span class="menu-title">Banners</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isBannersActive ? 'show' : '' }}" id="ui-banners">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-home-banner') ? 'active' : '' }}" href="/superadmin/super-home-banner">Home Banner</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-others-banner') ? 'active' : '' }}" href="/superadmin/super-others-banner">Others Banner</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-partner-carousel') ? 'active' : '' }}" href="/superadmin/super-partner-carousel">Partner Carousel</a></li>
                </ul>
            </div>
        </li>

        @php
            $isCouponsActive = request()->is('superadmin/super-add-coupons*') || request()->is('superadmin/super-show-coupons*');
        @endphp
        <li class="nav-item {{ $isCouponsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-coupons" aria-expanded="{{ $isCouponsActive ? 'true' : 'false' }}" aria-controls="ui-coupons">
                <i class="fa-solid fa-ticket-simple nav-icon"></i>
                <span class="menu-title">Coupons</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isCouponsActive ? 'show' : '' }}" id="ui-coupons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-add-coupons') ? 'active' : '' }}" href="/superadmin/super-add-coupons">Add Coupons</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-show-coupons') ? 'active' : '' }}" href="/superadmin/super-show-coupons">Show Coupons</a></li>
                </ul>
            </div>
        </li>

        @php
            $isSubsActive = request()->is('superadmin/super-add-subscriptions*') || request()->is('superadmin/super-show-subscription*');
        @endphp
        <li class="nav-item {{ $isSubsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-subs" aria-expanded="{{ $isSubsActive ? 'true' : 'false' }}" aria-controls="ui-subs">
                <i class="fa-solid fa-shield-halved nav-icon"></i>
                <span class="menu-title">Subscriptions</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isSubsActive ? 'show' : '' }}" id="ui-subs">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-add-subscriptions') ? 'active' : '' }}" href="/superadmin/super-add-subscriptions">Add Subscriptions</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-show-subscription') ? 'active' : '' }}" href="/superadmin/super-show-subscription">Show Subscriptions</a></li>
                </ul>
            </div>
        </li>

        @php
            $isCommActive = request()->is('superadmin/super-followups*') || request()->is('superadmin/bulkmessage*');
        @endphp
        <li class="nav-item {{ $isCommActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-comm" aria-expanded="{{ $isCommActive ? 'true' : 'false' }}" aria-controls="ui-comm">
                <i class="fa-solid fa-bullhorn nav-icon"></i>
                <span class="menu-title">Broadcast & Follow-up</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isCommActive ? 'show' : '' }}" id="ui-comm">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-followups*') ? 'active' : '' }}" href="/superadmin/super-followups">Follow-ups</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/bulkmessage*') ? 'active' : '' }}" href="/superadmin/bulkmessage">Bulk Message</a></li>
                </ul>
            </div>
        </li>

        <!-- Section: Support & Inquiries -->
        <li class="sidebar-category-header">Patient Care & Support</li>

        @php
            $isInquiriesActive = request()->is('superadmin/super-opd-inquiry*') || request()->is('superadmin/super-path-inquiry*') || request()->is('superadmin/super-doc-inquiry*') || request()->is('superadmin/super-user-inquiry*');
        @endphp
        <li class="nav-item {{ $isInquiriesActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-inquiries" aria-expanded="{{ $isInquiriesActive ? 'true' : 'false' }}" aria-controls="ui-inquiries">
                <i class="fa-solid fa-hand-holding-medical nav-icon"></i>
                <span class="menu-title">Inquiries</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isInquiriesActive ? 'show' : '' }}" id="ui-inquiries">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-user-inquiry') ? 'active' : '' }}" href="/superadmin/super-user-inquiry">User Inquiry</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-opd-inquiry') ? 'active' : '' }}" href="/superadmin/super-opd-inquiry">OPD Inquiries</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-path-inquiry') ? 'active' : '' }}" href="/superadmin/super-path-inquiry">Pathology Inquiries</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-doc-inquiry') ? 'active' : '' }}" href="/superadmin/super-doc-inquiry">Doctor Inquiries</a></li>
                </ul>
            </div>
        </li>

        @php
            $isSupportActive = request()->is('superadmin/super-all-tickets*') || request()->is('superadmin/super-ticket-replies*') || request()->is('superadmin/super-all-feedback*');
        @endphp
        <li class="nav-item {{ $isSupportActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-support" aria-expanded="{{ $isSupportActive ? 'true' : 'false' }}" aria-controls="ui-support">
                <i class="fa-solid fa-headset nav-icon"></i>
                <span class="menu-title">Helpdesk & Feedback</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isSupportActive ? 'show' : '' }}" id="ui-support">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-all-tickets') ? 'active' : '' }}" href="/superadmin/super-all-tickets">All Tickets</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-ticket-replies') ? 'active' : '' }}" href="/superadmin/super-ticket-replies">Ticket Replies</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-all-feedback*') ? 'active' : '' }}" href="/superadmin/super-all-feedback">Patient Feedbacks</a></li>
                </ul>
            </div>
        </li>

        <!-- Section: Content & Settings -->
        <li class="sidebar-category-header">Content & Settings</li>

        @php
            $isCmsActive = request()->is('superadmin/super-blogs*') || request()->is('superadmin/super-aboutus*');
        @endphp
        <li class="nav-item {{ $isCmsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-cms" aria-expanded="{{ $isCmsActive ? 'true' : 'false' }}" aria-controls="ui-cms">
                <i class="fa-solid fa-newspaper nav-icon"></i>
                <span class="menu-title">Portal CMS</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isCmsActive ? 'show' : '' }}" id="ui-cms">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-blogs*') ? 'active' : '' }}" href="/superadmin/super-blogs">Blogs</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-aboutus*') ? 'active' : '' }}" href="/superadmin/super-aboutus">About Us</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ request()->is('superadmin/profile*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('superadmin.profile.edit') }}">
                <i class="fa-solid fa-user-gear nav-icon"></i>
                <span class="menu-title">Admin Account</span>
            </a>
        </li>
    </ul>
</nav>