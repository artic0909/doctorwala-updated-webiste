@extends('layouts.superadmin')

@section('title', 'Super Admin Dashboard | Doctorwala')

@section('content')
<!-- Header & Welcome Banner -->
<div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
        <div class="d-flex align-items-center">
            <div class="mr-3 d-none d-sm-flex align-items-center justify-content-center rounded-circle" style="width: 52px; height: 52px; background: #e0f2fe; color: #0284c7;">
                <i class="fa-solid fa-user-doctor fa-2x"></i>
            </div>
            <div>
                <h3 class="font-weight-bold mb-1" style="color: var(--doc-text-main); letter-spacing: -0.3px;">
                    Welcome back, {{ Auth::user()->name ?? 'Administrator' }}!
                </h3>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Doctorwala Medical Ecosystem &bull; Super Admin Console
                </p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
        <span class="badge badge-light border px-3 py-2 font-weight-bold shadow-sm" style="font-size: 0.85rem; border-radius: 8px; color: #0f172a;">
            <i class="fa-solid fa-calendar-check text-primary mr-1"></i> <span id="currentDate"></span>
        </span>
    </div>
</div>

<!-- Healthcare Entity KPI Cards -->
<div class="row g-3 mb-4">
    <!-- Total Partners -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">Total Partners</div>
                    <div class="doc-stat-val text-primary">{{ number_format($totalPartners ?? 0) }}</div>
                    <small class="text-muted"><i class="fa-solid fa-hospital mr-1"></i> Verified Facilities</small>
                </div>
                <div class="doc-stat-icon icon-blue">
                    <i class="fa-solid fa-handshake"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users / Patients -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">Total Patients</div>
                    <div class="doc-stat-val text-success">{{ number_format($totalUsers ?? 0) }}</div>
                    <small class="text-muted"><i class="fa-solid fa-id-card mr-1"></i> Health Card Users</small>
                </div>
                <div class="doc-stat-icon icon-green">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- OPD Contacts -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">OPD Clinics</div>
                    <div class="doc-stat-val text-purple">{{ number_format($opdContactCount ?? 0) }}</div>
                    <small class="text-muted"><i class="fa-solid fa-clock mr-1"></i> Chambers Listed</small>
                </div>
                <div class="doc-stat-icon icon-purple">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pathology Contacts -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">Pathology Labs</div>
                    <div class="doc-stat-val text-warning">{{ number_format($pathologyContactCount ?? 0) }}</div>
                    <small class="text-muted"><i class="fa-solid fa-microscope mr-1"></i> Diagnostic Centers</small>
                </div>
                <div class="doc-stat-icon icon-amber">
                    <i class="fa-solid fa-flask-vial"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary KPI Row (Doctors, Tests, Callings) -->
<div class="row g-3 mb-4">
    <!-- Doctor Contacts -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">Doctors Listed</div>
                    <div class="doc-stat-val" style="color: #0d9488;">{{ number_format($doctorContactCount ?? 0) }}</div>
                    <small class="text-muted"><i class="fa-solid fa-stethoscope mr-1"></i> Individual Doctors</small>
                </div>
                <div class="doc-stat-icon icon-teal">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- OPD Doctors -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">OPD Doctors</div>
                    <div class="doc-stat-val text-success">{{ number_format($allOpdDoctorsCount ?? 0) }}</div>
                    <small class="text-muted"><i class="fa-solid fa-calendar-days mr-1"></i> Chamber Timings</small>
                </div>
                <div class="doc-stat-icon icon-green">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pathology Tests -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">Path Tests</div>
                    <div class="doc-stat-val text-purple">{{ number_format($allPathologyTestsCount ?? 0) }}</div>
                    <small class="text-muted"><i class="fa-solid fa-vial mr-1"></i> Test Tariffs</small>
                </div>
                <div class="doc-stat-icon icon-purple">
                    <i class="fa-solid fa-vial-virus"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Callings Lead Hub -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="doc-stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="doc-stat-label">AI Callings</div>
                    <div class="doc-stat-val" style="color: #0284c7;">
                        <a href="/superadmin/super-callings" style="text-decoration: none; color: inherit;">Riya AI</a>
                    </div>
                    <small class="text-primary font-weight-bold">
                        <a href="/superadmin/super-callings" style="text-decoration: underline;">View Call Logs &rarr;</a>
                    </small>
                </div>
                <div class="doc-stat-icon icon-blue">
                    <i class="fa-solid fa-headset"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Clinical Navigation Hub -->
<div class="card mb-4 border shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-bolt text-primary mr-2 fa-lg"></i>
            <h5 class="mb-0 font-weight-bold" style="color: var(--doc-text-main);">Quick Management Hub</h5>
        </div>
        <span class="text-muted small">One-click actions</span>
    </div>
    <div class="card-body p-3">
        <div class="row">
            <!-- Add Partner -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-add-partners" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-blue mr-3"><i class="fa-solid fa-plus"></i></div>
                    <div>
                        <p>Add Partner</p>
                        <small class="text-muted">Register clinic/lab</small>
                    </div>
                </a>
            </div>

            <!-- AI Voice Callings -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-callings" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-teal mr-3"><i class="fa-solid fa-headset"></i></div>
                    <div>
                        <p>AI Callings</p>
                        <small class="text-muted">Live Leads & Audio</small>
                    </div>
                </a>
            </div>

            <!-- All Partners -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-all-partner" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-blue mr-3"><i class="fa-solid fa-hospital"></i></div>
                    <div>
                        <p>All Partners</p>
                        <small class="text-muted">Facility Directory</small>
                    </div>
                </a>
            </div>

            <!-- All OPD -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-all-opd" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-purple mr-3"><i class="fa-solid fa-clinic-medical"></i></div>
                    <div>
                        <p>OPD Clinics</p>
                        <small class="text-muted">Chambers & Days</small>
                    </div>
                </a>
            </div>

            <!-- All Pathology -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-all-pathology" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-amber mr-3"><i class="fa-solid fa-flask-vial"></i></div>
                    <div>
                        <p>Pathology Labs</p>
                        <small class="text-muted">Test Rates & Labs</small>
                    </div>
                </a>
            </div>

            <!-- All Doctors -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-all-doctors" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-teal mr-3"><i class="fa-solid fa-user-doctor"></i></div>
                    <div>
                        <p>All Doctors</p>
                        <small class="text-muted">Doctor Directory</small>
                    </div>
                </a>
            </div>

            <!-- Physiotherapy & Allied Care -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-all-others" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box mr-3" style="background: #e6fffa; color: #0d9488;"><i class="fa-solid fa-hand-holding-medical"></i></div>
                    <div>
                        <p>Physiotherapy & Allied</p>
                        <small class="text-muted">Therapy Directory</small>
                    </div>
                </a>
            </div>

            <!-- All Users / Patients -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/super-all-user" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-green mr-3"><i class="fa-solid fa-users"></i></div>
                    <div>
                        <p>All Patients</p>
                        <small class="text-muted">Registered Users</small>
                    </div>
                </a>
            </div>

            <!-- Bulk Broadcast -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="/superadmin/bulkmessage" class="card card_action_btn p-3 h-100 d-flex flex-row align-items-center">
                    <div class="action-icon-box icon-green mr-3"><i class="fa-solid fa-bullhorn"></i></div>
                    <div>
                        <p>WhatsApp Bulk</p>
                        <small class="text-muted">Patient Broadcasts</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Visitor Analytics & Web Traffic -->
<div class="d-flex align-items-center justify-content-between mb-3 mt-4">
    <div class="d-flex align-items-center">
        <i class="fa-solid fa-chart-line text-primary mr-2 fa-lg"></i>
        <h4 class="mb-0 font-weight-bold" style="color: var(--doc-text-main);">Platform Traffic & Visitor Intelligence</h4>
    </div>
    <span class="badge badge-light border font-weight-bold px-3 py-2">
        <i class="fa-solid fa-signal text-success mr-1"></i> Live Analytics
    </span>
</div>

<!-- Traffic Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="va-stat-card va-stat-blue">
            <div class="va-stat-icon"><i class="fa-solid fa-users"></i></div>
            <div class="va-stat-body">
                <h3>{{ number_format($totalVisitors ?? 0) }}</h3>
                <p>Total Visitors</p>
            </div>
            <div class="va-stat-wave"></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="va-stat-card va-stat-green">
            <div class="va-stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="va-stat-body">
                <h3>{{ number_format($todayVisitors ?? 0) }}</h3>
                <p>Today's Visitors</p>
                @if(isset($yesterdayCount) && $yesterdayCount > 0)
                @php $change = round((($todayVisitors - $yesterdayCount) / $yesterdayCount) * 100, 1); @endphp
                <span class="va-trend">
                    <i class="fa-solid fa-arrow-{{ $change >= 0 ? 'up' : 'down' }} mr-1"></i>
                    {{ abs($change) }}% vs yesterday
                </span>
                @endif
            </div>
            <div class="va-stat-wave"></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="va-stat-card va-stat-purple">
            <div class="va-stat-icon"><i class="fa-solid fa-fingerprint"></i></div>
            <div class="va-stat-body">
                <h3>{{ number_format($uniqueIPs ?? 0) }}</h3>
                <p>Unique IP Addresses</p>
            </div>
            <div class="va-stat-wave"></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="va-stat-card va-stat-orange">
            <div class="va-stat-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <div class="va-stat-body">
                <h3>{{ number_format($yesterdayCount ?? 0) }}</h3>
                <p>Yesterday's Visitors</p>
            </div>
            <div class="va-stat-wave"></div>
        </div>
    </div>
</div>

<!-- Charts Row: Daily Line Chart + Device Types -->
<div class="row g-3 mb-4">
    <!-- Daily Visitors 30 Days -->
    <div class="col-xl-8 col-md-12 mb-3">
        <div class="va-card">
            <div class="va-card-header">
                <div class="va-card-title">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <div>
                        <h5>Daily Patient & Partner Visits</h5>
                        <p>Last 30 days traffic overview</p>
                    </div>
                </div>
                <span class="va-badge va-badge-blue">30 Days</span>
            </div>
            <div class="va-chart-wrap" style="height: 260px;">
                <canvas id="dailyVisitorsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Device Breakdown -->
    <div class="col-xl-4 col-md-12 mb-3">
        <div class="va-card">
            <div class="va-card-header">
                <div class="va-card-title">
                    <i class="fa-solid fa-mobile-screen"></i>
                    <div>
                        <h5>Device Types</h5>
                        <p>Desktop &bull; Mobile &bull; Tablet</p>
                    </div>
                </div>
            </div>
            <div class="va-chart-wrap" style="height: 220px;">
                <canvas id="deviceChart"></canvas>
            </div>
            <div class="va-legend" id="deviceLegend"></div>
        </div>
    </div>
</div>

<!-- Hourly & Browser & OS -->
<div class="row g-3 mb-4">
    <!-- Hourly Traffic Today -->
    <div class="col-xl-5 col-md-12 mb-3">
        <div class="va-card">
            <div class="va-card-header">
                <div class="va-card-title">
                    <i class="fa-solid fa-clock"></i>
                    <div>
                        <h5>Hourly Visits (Today)</h5>
                        <p>Activity timeline</p>
                    </div>
                </div>
                <span class="va-badge va-badge-green">Today</span>
            </div>
            <div class="va-chart-wrap" style="height: 220px;">
                <canvas id="hourlyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Browsers -->
    <div class="col-xl-4 col-md-7 mb-3">
        <div class="va-card">
            <div class="va-card-header">
                <div class="va-card-title">
                    <i class="fa-brands fa-chrome"></i>
                    <div>
                        <h5>Top Browsers</h5>
                        <p>Visitor user agents</p>
                    </div>
                </div>
            </div>
            <div class="va-chart-wrap" style="height: 220px;">
                <canvas id="browserChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Operating Systems -->
    <div class="col-xl-3 col-md-5 mb-3">
        <div class="va-card">
            <div class="va-card-header">
                <div class="va-card-title">
                    <i class="fa-solid fa-desktop"></i>
                    <div>
                        <h5>Operating Systems</h5>
                        <p>Platform breakdown</p>
                    </div>
                </div>
            </div>
            <div class="va-chart-wrap" style="height: 220px;">
                <canvas id="osChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Pages Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="va-card">
            <div class="va-card-header">
                <div class="va-card-title">
                    <i class="fa-solid fa-link"></i>
                    <div>
                        <h5>Top Visited URLs & Services</h5>
                        <p>Most popular patient destinations</p>
                    </div>
                </div>
                <span class="va-badge va-badge-purple">Top 8</span>
            </div>
            <div class="table-responsive">
                <table class="va-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Page URL</th>
                            <th style="width: 140px;">Visits</th>
                            <th style="width: 220px;">Traffic Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPages ?? [] as $i => $page)
                        @php
                            $share = ($totalVisitors ?? 0) > 0 ? round(($page->total / $totalVisitors) * 100, 1) : 0;
                            $shortUrl = strlen($page->page_url) > 60 ? substr($page->page_url, 0, 60) . '…' : $page->page_url;
                        @endphp
                        <tr>
                            <td><span class="va-rank">{{ $i + 1 }}</span></td>
                            <td>
                                <a href="{{ $page->page_url }}" target="_blank" class="va-page-url">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> {{ $shortUrl }}
                                </a>
                            </td>
                            <td><strong>{{ number_format($page->total) }}</strong></td>
                            <td>
                                <div class="va-progress-wrap">
                                    <div class="va-progress-bar" style="width: {{ $share }}%;"></div>
                                    <span>{{ $share }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                No visitor log data recorded yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    (function() {
        const PALETTE = [
            '#0284c7', '#10b981', '#8b5cf6', '#f59e0b',
            '#ef4444', '#0d9488', '#ec4899', '#f97316',
            '#06b6d4', '#6366f1'
        ];

        function buildDailyLabels() {
            const labels = [], vals = [];
            for (let i = 29; i >= 0; i--) {
                const d = new Date();
                d.setDate(d.getDate() - i);
                labels.push(d.toISOString().slice(0, 10));
                vals.push(0);
            }
            return { labels, vals };
        }

        // 1. Daily Line Chart
        (function() {
            const { labels, vals } = buildDailyLabels();
            const raw = @json($dailyVisitors ?? []);

            raw.forEach(r => {
                const idx = labels.indexOf(r.date);
                if (idx !== -1) vals[idx] = r.total;
            });

            const shortLabels = labels.map(d => {
                const dt = new Date(d);
                return dt.toLocaleDateString('en-IN', { month: 'short', day: 'numeric' });
            });

            const ctx = document.getElementById('dailyVisitorsChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: shortLabels,
                        datasets: [{
                            label: 'Visitors',
                            data: vals,
                            borderColor: '#0284c7',
                            backgroundColor: 'rgba(2, 132, 199, 0.08)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0284c7',
                            pointRadius: 3,
                            pointHoverRadius: 6,
                            borderWidth: 2.5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { weight: '800' },
                                callbacks: {
                                    title: c => labels[c[0].dataIndex],
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { maxTicksLimit: 10, font: { size: 10 }, color: '#94a3b8' }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9' },
                                ticks: { font: { size: 10 }, color: '#94a3b8', precision: 0 }
                            }
                        }
                    }
                });
            }
        })();

        // 2. Device Doughnut
        (function() {
            const raw = @json($deviceBreakdown ?? []);
            const labels = raw.map(r => r.device_type ?? 'Unknown');
            const data = raw.map(r => r.total);
            const colors = PALETTE.slice(0, labels.length);

            const ctx = document.getElementById('deviceChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: colors,
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: '#0f172a' }
                        }
                    }
                });

                const legend = document.getElementById('deviceLegend');
                if (legend) {
                    labels.forEach((l, i) => {
                        legend.innerHTML += `<div class="va-legend-item">
                            <div class="va-legend-dot" style="background:${colors[i]}"></div>${l} (${data[i]})
                        </div>`;
                    });
                }
            }
        })();

        // 3. Hourly Bar
        (function() {
            const raw = @json($hourlyToday ?? []);
            const hours = Array.from({ length: 24 }, (_, i) => i);
            const counts = hours.map(h => {
                const found = raw.find(r => r.hour == h);
                return found ? found.total : 0;
            });
            const labels = hours.map(h => h.toString().padStart(2, '0') + ':00');

            const ctx = document.getElementById('hourlyChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Visits',
                            data: counts,
                            backgroundColor: counts.map((_, i) => {
                                const now = new Date().getHours();
                                return i === now ? '#0284c7' : 'rgba(2, 132, 199, 0.2)';
                            }),
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: '#0f172a' }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { maxTicksLimit: 8, font: { size: 9 }, color: '#94a3b8' }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9' },
                                ticks: { font: { size: 9 }, color: '#94a3b8', precision: 0 }
                            }
                        }
                    }
                });
            }
        })();

        // 4. Browser Bar
        (function() {
            const raw = @json($browserBreakdown ?? []);
            const labels = raw.map(r => r.browser ?? 'Unknown');
            const data = raw.map(r => r.total);

            const ctx = document.getElementById('browserChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Users',
                            data,
                            backgroundColor: PALETTE.slice(0, labels.length),
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: '#0f172a' }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9' },
                                ticks: { font: { size: 9 }, color: '#94a3b8', precision: 0 }
                            },
                            y: {
                                grid: { display: false },
                                ticks: { font: { size: 10 }, color: '#0f172a' }
                            }
                        }
                    }
                });
            }
        })();

        // 5. OS Polar Area
        (function() {
            const raw = @json($osBreakdown ?? []);
            const labels = raw.map(r => r.os ?? 'Unknown');
            const data = raw.map(r => r.total);
            const colors = PALETTE.slice(0, labels.length);

            const ctx = document.getElementById('osChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'polarArea',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: colors.map(c => c + 'cc'),
                            borderColor: colors,
                            borderWidth: 1.5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { font: { size: 9 }, padding: 8, boxWidth: 10 }
                            },
                            tooltip: { backgroundColor: '#0f172a' }
                        },
                        scales: {
                            r: {
                                ticks: { font: { size: 8 }, color: '#94a3b8', backdropColor: 'transparent' },
                                grid: { color: '#f1f5f9' }
                            }
                        }
                    }
                });
            }
        })();
    })();

    // Date Updater
    function updateCurrentDate() {
        const today = new Date();
        const options = { weekday: 'short', year: 'numeric', month: 'short', day: '2-digit' };
        const el = document.getElementById('currentDate');
        if (el) el.textContent = today.toLocaleDateString('en-US', options);
    }
    updateCurrentDate();
</script>
@endpush
