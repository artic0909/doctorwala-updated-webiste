<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PartnerPatientInquiry;
use Illuminate\Http\Request;

class SuperAllPatientInquiryController extends Controller
{
    public function indexOPD(Request $request)
    {
        $query = PartnerPatientInquiry::where('clinic_type', 'OPD');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_phone', 'like', "%{$search}%")
                  ->orWhere('patient_email', 'like', "%{$search}%")
                  ->orWhere('patient_message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $inquiries = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.inquiries.opd', compact('inquiries'));
    }

    public function opdDelete($id)
    {
        $inquiry = PartnerPatientInquiry::find($id);
        $inquiry->delete();
        return back()->with('success', 'Deleted successfully!');
    }

    public function indexPath(Request $request)
    {
        $query = PartnerPatientInquiry::where('clinic_type', 'Pathology');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_phone', 'like', "%{$search}%")
                  ->orWhere('patient_email', 'like', "%{$search}%")
                  ->orWhere('patient_message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $inquiries = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.inquiries.pathology', compact('inquiries'));
    }

    public function pathDelete($id)
    {
        $inquiry = PartnerPatientInquiry::find($id);
        $inquiry->delete();
        return back()->with('success', 'Deleted successfully!');
    }

    public function indexDoc(Request $request)
    {
        $query = PartnerPatientInquiry::where('clinic_type', 'Doctor');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_phone', 'like', "%{$search}%")
                  ->orWhere('patient_email', 'like', "%{$search}%")
                  ->orWhere('patient_message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $inquiries = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.inquiries.doctor', compact('inquiries'));
    }




    public function docDelete($id)
    {
        $inquiry = PartnerPatientInquiry::find($id);
        $inquiry->delete();
        return back()->with('success', 'Deleted successfully!');
    }
}
