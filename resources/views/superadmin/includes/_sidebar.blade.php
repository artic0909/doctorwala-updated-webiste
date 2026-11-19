<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Section: Main -->
        <li class="sidebar-category-header">Main Overview</li>
        
        <li class="nav-item {{ request()->is('superadmin/super-dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-dashboard">
                <i class="fa-solid fa-chart-pie nav-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- <li class="nav-item {{ request()->is('superadmin/super-callings*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-callings">
                <i class="fa-solid fa-headset nav-icon"></i>
                <span class="menu-title">AI Voice Callings</span>
                <span class="badge badge-pill badge-primary ml-auto" style="font-size: 0.65rem; padding: 3px 6px;">AI</span>
            </a>
        </li> -->

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
                    <!-- <li class="nav-item">
                        <a class="nav-link {{ request()->is('superadmin/importer*') ? 'active' : '' }}" href="{{ route('superadmin.importer.index') }}">CSV Importer</a>
                    </li> -->
                </ul>
            </div>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-all-opd*') || request()->is('superadmin/super-edit-opd-details*') || request()->is('superadmin/super-addopd-doctor*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-all-opd">
                <i class="fa-solid fa-clinic-medical nav-icon"></i>
                <span class="menu-title">All OPD Clinics</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-all-pathology*') || request()->is('superadmin/super-edit-pathology-details*') || request()->is('superadmin/super-addpath-test*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-all-pathology">
                <i class="fa-solid fa-flask-vial nav-icon"></i>
                <span class="menu-title">All Pathology Labs</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-all-doctors*') || request()->is('superadmin/super-edit-doctors-details*') || request()->is('superadmin/super-adddoc-banner*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-all-doctors">
                <i class="fa-solid fa-user-doctor nav-icon"></i>
                <span class="menu-title">All Doctors</span>
            </a>
        </li>

        <!-- Section: Users & Agent Network -->
        <li class="sidebar-category-header">Users & Network</li>

        <li class="nav-item {{ request()->is('superadmin/super-all-user*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-all-user">
                <i class="fa-solid fa-users nav-icon"></i>
                <span class="menu-title">All Patients / Users</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-all-reffer*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-all-reffer">
                <i class="fa-solid fa-gift nav-icon"></i>
                <span class="menu-title">Referrals</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-ep*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-ep">
                <i class="fa-solid fa-user-tie nav-icon"></i>
                <span class="menu-title">EP Management</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-gp*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-gp">
                <i class="fa-solid fa-handshake nav-icon"></i>
                <span class="menu-title">GP Management</span>
            </a>
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

        <li class="nav-item {{ request()->is('superadmin/super-followups*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-followups">
                <i class="fa-solid fa-phone-volume nav-icon"></i>
                <span class="menu-title">Follow-ups</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/bulkmessage*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/bulkmessage">
                <i class="fa-solid fa-bullhorn nav-icon"></i>
                <span class="menu-title">Bulk Message</span>
            </a>
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
            $isTicketsActive = request()->is('superadmin/super-all-tickets*') || request()->is('superadmin/super-ticket-replies*');
        @endphp
        <li class="nav-item {{ $isTicketsActive ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-tickets" aria-expanded="{{ $isTicketsActive ? 'true' : 'false' }}" aria-controls="ui-tickets">
                <i class="fa-solid fa-ticket nav-icon"></i>
                <span class="menu-title">Tickets</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $isTicketsActive ? 'show' : '' }}" id="ui-tickets">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-all-tickets') ? 'active' : '' }}" href="/superadmin/super-all-tickets">All Tickets</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/super-ticket-replies') ? 'active' : '' }}" href="/superadmin/super-ticket-replies">Replies</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-all-feedback*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-all-feedback">
                <i class="fa-solid fa-star-half-stroke nav-icon"></i>
                <span class="menu-title">Feedbacks</span>
            </a>
        </li>

        <!-- Section: Content & CMS -->
        <li class="sidebar-category-header">Content & CMS</li>

        <li class="nav-item {{ request()->is('superadmin/super-blogs*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-blogs">
                <i class="fa-solid fa-blog nav-icon"></i>
                <span class="menu-title">Blogs</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('superadmin/super-aboutus*') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin/super-aboutus">
                <i class="fa-solid fa-circle-info nav-icon"></i>
                <span class="menu-title">About Us</span>
            </a>
        </li>
    </ul>
</nav>
