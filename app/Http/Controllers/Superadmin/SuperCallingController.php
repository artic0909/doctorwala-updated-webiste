<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Calling;
use App\Exports\CallingsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SuperCallingController extends Controller
{
    /**
     * Display listing of AI Voice Callings
     */
    public function index(Request $request)
    {
        $query = Calling::query();

        // Search text
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('phone_number', 'like', "%{$search}%")
                  ->orWhere('provider_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('doctors_and_timings', 'like', "%{$search}%")
                  ->orWhere('tests_offered', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('vapi_call_id', 'like', "%{$search}%");
            });
        }

        // Provider Type
        if ($request->filled('provider_type')) {
            $query->where('provider_type', 'like', "%{$request->provider_type}%");
        }

        // Language
        if ($request->filled('language')) {
            $query->where('language', 'like', "%{$request->language}%");
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'callback') {
                $query->where('callback_scheduled', true);
            } elseif ($status === 'dnd') {
                $query->where('is_dnd', true);
            } elseif ($status === 'link_sent') {
                $query->where('app_link_sent', true);
            } else {
                $query->where('call_status', $status);
            }
        }

        // Date Range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // KPI Counts
        $totalCalls = Calling::count();
        $leadsCaptured = Calling::whereNotNull('provider_name')->where('provider_name', '!=', '')->count();
        $callbacksScheduled = Calling::where('callback_scheduled', true)->count();
        $linksSent = Calling::where('app_link_sent', true)->count();
        $dndCount = Calling::where('is_dnd', true)->count();

        $callings = $query->orderBy('id', 'desc')->paginate(15);

        return view('superadmin.super-all-callings', compact(
            'callings',
            'totalCalls',
            'leadsCaptured',
            'callbacksScheduled',
            'linksSent',
            'dndCount'
        ));
    }

    /**
     * Delete calling record
     */
    public function delete($id)
    {
        $calling = Calling::findOrFail($id);
        $calling->delete();

        return back()->with('success', 'Calling record deleted successfully!');
    }

    /**
     * Export calling records as Excel
     */
    public function exportAsExcel(Request $request)
    {
        return Excel::download(
            new CallingsExport($request->all()),
            'doctorwala_ai_callings_' . date('Y_m_d_His') . '.xlsx'
        );
    }
}

