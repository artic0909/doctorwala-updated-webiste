<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PartnerInquiryModel;
use Illuminate\Http\Request;

class SuperTicketController extends Controller
{


    public function index(Request $request)
    {
        $query = PartnerInquiryModel::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('ticket_id', 'LIKE', "%{$search}%")
                  ->orWhere('partner_clinic_name', 'LIKE', "%{$search}%")
                  ->orWhere('partner_contact_person_name', 'LIKE', "%{$search}%")
                  ->orWhere('partner_mobile_number', 'LIKE', "%{$search}%")
                  ->orWhere('partner_email', 'LIKE', "%{$search}%")
                  ->orWhere('partner_city', 'LIKE', "%{$search}%")
                  ->orWhere('partner_state', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            if ($request->status === 'Pending') {
                $query->where(function($q) {
                    $q->whereNull('partner_problem_reply')->orWhere('partner_problem_reply', '');
                });
            } elseif ($request->status === 'Replied') {
                $query->whereNotNull('partner_problem_reply')->where('partner_problem_reply', '!=', '');
            }
        }

        $tickets = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.tickets.index', compact('tickets'));
    }



    public function addReply(Request $request, $id)
    {
        $validated = $request->validate([
            'partner_problem_reply' => 'required|string',
        ]);


        $partnerInquiry = PartnerInquiryModel::find($id);

        if (!$partnerInquiry) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        $partnerInquiry->partner_problem_reply = $request->input('partner_problem_reply');
        $partnerInquiry->save();

        return redirect('/superadmin/super-ticket-replies')->with('success', 'Updated Successfully!');
    }






    public function delete($id)
    {
        $partnerINQInfo = PartnerInquiryModel::find($id);

        if ($partnerINQInfo) {

            $partnerINQInfo->delete();

            return back()->with('success', 'deleted successfully!');
        }
    }











    // For all replies ----------------------------------------------------------->
    public function showAllReplayed(Request $request)
    {
        $query = PartnerInquiryModel::whereNotNull('partner_problem_reply')
            ->where('partner_problem_reply', '!=', '');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('ticket_id', 'LIKE', "%{$search}%")
                  ->orWhere('partner_clinic_name', 'LIKE', "%{$search}%")
                  ->orWhere('partner_contact_person_name', 'LIKE', "%{$search}%")
                  ->orWhere('partner_mobile_number', 'LIKE', "%{$search}%")
                  ->orWhere('partner_email', 'LIKE', "%{$search}%")
                  ->orWhere('partner_city', 'LIKE', "%{$search}%")
                  ->orWhere('partner_problem_reply', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('updated_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('updated_at', '<=', $request->to_date);
        }

        $repliedTickets = $query->orderBy('updated_at', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.tickets.replies', compact('repliedTickets'));
    }
}
