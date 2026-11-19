<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PartnerFeedback;
use Illuminate\Http\Request;

class SuperAllFeedbacksController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerFeedback::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('clinic_name', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('feedback', 'like', "%{$search}%");
            });
        }

        if ($request->filled('clinic_type')) {
            $query->where('clinic_type', $request->clinic_type);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.feedbacks.index', compact('feedbacks'));
    }

    public function delete($id)
    {
        $feedback = PartnerFeedback::find($id);
        $feedback->delete();
        return back()->with('success', 'Feedback deleted successfully');
    }
}
