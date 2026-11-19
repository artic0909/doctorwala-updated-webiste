<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\FrontContactModel;
use Illuminate\Http\Request;

class SuperUserInquiryController extends Controller
{
    public function index(Request $request){
        $query = FrontContactModel::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $inquiries = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.inquiries.user', compact('inquiries'));
    }

    public function delete($id){
        $inquiry = FrontContactModel::find($id);
        $inquiry->delete();
        return redirect()->back()->with('success', 'Inquiry deleted successfully');
    }
}
