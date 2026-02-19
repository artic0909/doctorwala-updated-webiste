<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Daily visitors – last 30 days ──────────────────────────
        $dailyVisitors = DB::table('visitor_logs')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(29))
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        // ── Device breakdown ───────────────────────────────────────
        $deviceBreakdown = DB::table('visitor_logs')
            ->selectRaw('device_type, COUNT(*) as total')
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->get();

        // ── Browser breakdown ──────────────────────────────────────
        $browserBreakdown = DB::table('visitor_logs')
            ->selectRaw('browser, COUNT(*) as total')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // ── OS breakdown ───────────────────────────────────────────
        $osBreakdown = DB::table('visitor_logs')
            ->selectRaw('os, COUNT(*) as total')
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('total')
            ->get();

        // ── Top pages ──────────────────────────────────────────────
        $topPages = DB::table('visitor_logs')
            ->selectRaw('page_url, COUNT(*) as total')
            ->whereNotNull('page_url')
            ->groupBy('page_url')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // ── Hourly traffic today ───────────────────────────────────
        $hourlyToday = DB::table('visitor_logs')
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as total')
            ->whereDate('created_at', today())
            ->groupByRaw('HOUR(created_at)')
            ->orderBy('hour')
            ->get();

        // ── Summary stats ──────────────────────────────────────────
        $totalVisitors   = DB::table('visitor_logs')->count();
        $todayVisitors   = DB::table('visitor_logs')->whereDate('created_at', today())->count();
        $uniqueIPs       = DB::table('visitor_logs')->distinct('ip_address')->count('ip_address');
        $yesterdayCount  = DB::table('visitor_logs')->whereDate('created_at', now()->subDay())->count();

        return view('superadmin.super-dashboard', compact(
            'dailyVisitors',
            'deviceBreakdown',
            'browserBreakdown',
            'osBreakdown',
            'topPages',
            'hourlyToday',
            'totalVisitors',
            'todayVisitors',
            'uniqueIPs',
            'yesterdayCount'
        ));
    }
}
