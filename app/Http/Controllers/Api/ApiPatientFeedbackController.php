<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerFeedback;
use Illuminate\Http\Request;

class ApiPatientFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'currently_loggedin_partner_id' => 'required|integer',
            'clinic_type' => 'required|string',
            'clinic_name' => 'required|string',
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $feedback = new PartnerFeedback();
        $feedback->currently_loggedin_partner_id = $request->currently_loggedin_partner_id;
        $feedback->clinic_type = $request->clinic_type;
        $feedback->clinic_name = $request->clinic_name;
        $feedback->user_name = $request->user_name;
        $feedback->user_email = $request->user_email;
        $feedback->feedback = $request->feedback;
        $feedback->rating = $request->rating;
        $feedback->save();

        return response()->json([
            'status' => true,
            'message' => 'Feedback submitted successfully',
        ]);
    }
}