<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="/partnerpanel/partner-dashboard">
            <img src="{{ asset('img/logo3.png') }}" alt="Doctorwala" style="height: 36px; max-width: 175px; object-fit: contain;">
        </a>
        <a class="navbar-brand brand-logo-mini" href="/partnerpanel/partner-dashboard">
            <img src="{{ asset('fav5.png') }}" alt="logo" style="width: 32px; height: 32px;" />
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
        <!-- Sidebar Toggle & Facility Badge -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize" style="color: #64748b; padding: 6px;">
                <i class="fa-solid fa-bars-staggered fa-lg"></i>
            </button>
            <span class="navbar-badge-pill d-none d-sm-inline-flex" style="background: #ccfbf1; color: #0d9488;">
                <i class="fa-solid fa-hospital-user mr-1"></i> Partner Portal
            </span>
        </div>

        <!-- Clinic / Partner Name Info -->
        <div class="d-none d-lg-flex align-items-center">
            @if(!empty($clinicName))
            <span class="badge badge-light border mr-2 px-3 py-2" style="font-size: 0.82rem; font-weight: 700; color: #0f172a; border-radius: 8px;">
                <i class="fa-solid fa-hospital mr-1 text-primary"></i> {{ $clinicName }}
            </span>
            @endif

            @if(!empty($registrationTypes) && is_array($registrationTypes))
                @foreach($registrationTypes as $type)
                    @if($type == 'Doctor')
                    <span class="doc-badge doc-badge-doc mr-1"><i class="fa-solid fa-stethoscope mr-1"></i> Doctor</span>
                    @elseif($type == 'OPD')
                    <span class="doc-badge doc-badge-opd mr-1"><i class="fa-solid fa-clinic-medical mr-1"></i> OPD</span>
                    @elseif($type == 'Pathology')
                    <span class="doc-badge doc-badge-path mr-1"><i class="fa-solid fa-flask-vial mr-1"></i> Pathology</span>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- Right Side Nav -->
        <ul class="navbar-nav navbar-nav-right">
            <!-- Profile Dropdown -->
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown" id="profileDropdown" style="padding: 0;">
                    <div class="d-none d-md-block text-right mr-2">
                        <div style="font-weight: 700; font-size: 0.85rem; color: #0f172a; line-height: 1.2;">
                            {{ $partnerName ?? (Auth::guard('partner')->user()->partner_contact_person_name ?? 'Partner') }}
                        </div>
                        <small style="color: #64748b; font-size: 0.75rem;">Verified Partner</small>
                    </div>
                    <img src="{{ asset('fav5.png') }}" alt="profile" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #ccfbf1;" />
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown border-0 shadow-lg" aria-labelledby="profileDropdown" style="border-radius: 12px; min-width: 200px; padding: 8px;">
                    <a class="dropdown-item py-2" href="/partnerpanel/partner-profile" style="font-size: 0.85rem; border-radius: 6px;">
                        <i class="fa-solid fa-user-gear text-primary mr-2"></i> Profile Settings
                    </a>
                    <a class="dropdown-item py-2" href="/partnerpanel/partner-get-subscription" style="font-size: 0.85rem; border-radius: 6px;">
                        <i class="fa-solid fa-crown text-warning mr-2"></i> Subscription Plan
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('partner.logout') }}">
                        @csrf
                        <a class="dropdown-item py-2 text-danger" href="{{ route('partner.logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();" style="font-size: 0.85rem; border-radius: 6px;">
                            <i class="fa-solid fa-right-from-bracket text-danger mr-2"></i> Logout
                        </a>
                    </form>
                </div>
            </li>

            <!-- Mobile toggler -->
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ml-2" type="button" data-toggle="offcanvas" style="color: #64748b;">
                <i class="fa-solid fa-bars fa-lg"></i>
            </button>
        </ul>
    </div>
</nav>
