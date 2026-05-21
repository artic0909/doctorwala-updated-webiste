<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use App\Models\PartnerAllOPDDoctorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctoraddApiController extends Controller
{
    /**
     * Get all doctors for the currently logged in partner
     */
    public function index(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $doctors = PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partner->id)->get();
        
        foreach ($doctors as $doctor) {
            $doctor->visit_day_time = json_decode($doctor->visit_day_time, true);
        }

        return response()->json([
            'status' => true,
            'doctors' => $doctors
        ], 200);
    }

    /**
     * Store new doctor details
     */
    public function store(Request $request)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'doctor_name' => 'required|string|max:255',
            'doctor_designation' => 'required|string|max:255',
            'doctor_specialist' => 'required|string|max:255',
            'doctor_fees' => 'required|numeric',
            'doctor_more' => 'nullable|string',
            'doctor_visit_day' => 'nullable|array',
            'doctor_visit_day.*' => 'nullable|string|max:255',
            'doctor_visit_start_time' => 'nullable|array',
            'doctor_visit_start_time.*' => 'nullable|string',
            'doctor_visit_end_time' => 'nullable|array',
            'doctor_visit_end_time.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Prepare visit day and time data
        $visitDayTime = [];
        if ($request->has('doctor_visit_day') && is_array($request->doctor_visit_day)) {
            foreach ($request->doctor_visit_day as $index => $day) {
                $visitDayTime[] = [
                    'day' => $day,
                    'start_time' => $request->doctor_visit_start_time[$index] ?? null,
                    'end_time' => $request->doctor_visit_end_time[$index] ?? null,
                ];
            }
        }

        $data = [
            'currently_loggedin_partner_id' => $partner->id,
            'doctor_name' => $request->doctor_name,
            'doctor_designation' => $request->doctor_designation,
            'doctor_specialist' => $request->doctor_specialist,
            'doctor_fees' => $request->doctor_fees,
            'doctor_more' => $request->doctor_more,
            'visit_day_time' => json_encode($visitDayTime),
        ];

        $doctor = PartnerAllOPDDoctorModel::create($data);
        $doctor->visit_day_time = $visitDayTime;

        return response()->json([
            'status' => true,
            'message' => 'OPD Doctor details added successfully!',
            'doctor' => $doctor
        ], 200);
    }

    /**
     * Update doctor details
     */
    public function update(Request $request, $id)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'doctor_name' => 'required|string|max:255',
            'doctor_designation' => 'required|string|max:255',
            'doctor_specialist' => 'required|string|max:255',
            'doctor_fees' => 'required|numeric',
            'doctor_more' => 'nullable|string',
            'doctor_visit_day' => 'nullable|array',
            'doctor_visit_day.*' => 'nullable|string|max:255',
            'doctor_visit_start_time' => 'nullable|array',
            'doctor_visit_start_time.*' => 'nullable|string',
            'doctor_visit_end_time' => 'nullable|array',
            'doctor_visit_end_time.*' => 'nullable|string',
            'status' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        $doctor = PartnerAllOPDDoctorModel::where('id', $id)
            ->where('currently_loggedin_partner_id', $partner->id)
            ->first();

        if (!$doctor) {
            return response()->json([
                'status' => false,
                'message' => 'OPD Doctor details not found.'
            ], 404);
        }

        // Prepare visit day and time data
        $visitDayTime = [];
        if ($request->has('doctor_visit_day') && is_array($request->doctor_visit_day)) {
            foreach ($request->doctor_visit_day as $index => $day) {
                $visitDayTime[] = [
                    'day' => $day,
                    'start_time' => $request->doctor_visit_start_time[$index] ?? null,
                    'end_time' => $request->doctor_visit_end_time[$index] ?? null,
                ];
            }
        }

        $data = [
            'doctor_name' => $request->doctor_name,
            'doctor_designation' => $request->doctor_designation,
            'doctor_specialist' => $request->doctor_specialist,
            'doctor_fees' => $request->doctor_fees,
            'doctor_more' => $request->doctor_more,
            'status' => $request->status ?? $doctor->status,
            'visit_day_time' => json_encode($visitDayTime),
        ];

        $doctor->update($data);
        $doctor->visit_day_time = $visitDayTime;

        return response()->json([
            'status' => true,
            'message' => 'OPD Doctor details updated successfully!',
            'doctor' => $doctor
        ], 200);
    }

    /**
     * Delete doctor
     */
    public function destroy(Request $request, $id)
    {
        $partner = $request->user();
        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $doctor = PartnerAllOPDDoctorModel::where('id', $id)
            ->where('currently_loggedin_partner_id', $partner->id)
            ->first();

        if (!$doctor) {
            return response()->json([
                'status' => false,
                'message' => 'OPD Doctor details not found.'
            ], 404);
        }

        $doctor->delete();

        return response()->json([
            'status' => true,
            'message' => 'OPD Doctor details deleted successfully!'
        ], 200);
    }
}
