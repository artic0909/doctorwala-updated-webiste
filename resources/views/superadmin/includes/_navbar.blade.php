<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="/superadmin/super-dashboard">
            <img src="{{ asset('img/logo3.png') }}" alt="Doctorwala" style="height: 36px; max-width: 175px; object-fit: contain;">
        </a>
        <a class="navbar-brand brand-logo-mini" href="/superadmin/super-dashboard">
            <img src="{{ asset('fav5.png') }}" alt="logo" style="width: 32px; height: 32px;" />
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
        <!-- Sidebar Toggle & Badge -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize" style="color: #64748b; padding: 6px;">
                <i class="fa-solid fa-bars-staggered fa-lg"></i>
            </button>
            <span class="navbar-badge-pill d-none d-sm-inline-flex">
                <i class="fa-solid fa-shield-halved mr-1"></i> Super Admin
            </span>
        </div>

        <!-- Quick Links / Action Hub -->
        <div class="d-none d-lg-flex align-items-center" style="gap: 8px;">
            <a href="/superadmin/super-add-partners" class="btn btn-sm btn-outline-primary" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 6px;">
                <i class="fa-solid fa-plus-circle mr-1"></i> Add Partner
            </a>
            <a href="/superadmin/super-callings" class="btn btn-sm btn-outline-primary" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 6px;">
                <i class="fa-solid fa-headset mr-1"></i> AI Callings
            </a>
            <a href="/" target="_blank" class="btn btn-sm btn-outline-secondary" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 6px; border-color: #e2e8f0;">
                <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> View Website
            </a>
        </div>

        <!-- Right Side Nav -->
        <ul class="navbar-nav navbar-nav-right">
            <!-- Profile Dropdown -->
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown" id="profileDropdown" style="padding: 0;">
                    <div class="d-none d-md-block text-right mr-2">
                        <div style="font-weight: 700; font-size: 0.85rem; color: #0f172a; line-height: 1.2;">
                            {{ Auth::user()->name ?? 'Administrator' }}
                        </div>
                        <small style="color: #64748b; font-size: 0.75rem;">Super Admin</small>
                    </div>
                    <img src="{{ asset('fav5.png') }}" alt="profile" style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #e0f2fe;" />
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown border-0 shadow-lg" aria-labelledby="profileDropdown" style="border-radius: 12px; min-width: 200px; padding: 8px;">
                    <div class="px-3 py-2 border-bottom mb-2">
                        <strong class="d-block text-truncate" style="color: #0f172a; font-size: 0.88rem;">{{ Auth::user()->name ?? 'Super Admin' }}</strong>
                        <small class="text-muted text-truncate d-block">{{ Auth::user()->email ?? 'admin@doctorwala.info' }}</small>
                    </div>
                    
                    <a class="dropdown-item py-2" href="/superadmin/super-dashboard" style="font-size: 0.85rem; border-radius: 6px;">
                        <i class="fa-solid fa-chart-pie text-primary mr-2"></i> Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
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
