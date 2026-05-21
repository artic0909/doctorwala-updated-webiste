<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use App\Models\PartnerAllPathologyTestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestaddApiController extends Controller
{
    /**
     * Get all pathology tests for the currently logged in partner
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

        $tests = PartnerAllPathologyTestModel::where('currently_loggedin_partner_id', $partner->id)->get();

        foreach ($tests as $test) {
            $test->test_day_time = json_decode($test->test_day_time, true);
        }

        return response()->json([
            'status' => true,
            'tests' => $tests
        ], 200);
    }

    /**
     * Store new pathology test details
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
            'test_name' => 'required|string|max:255',
            'test_type' => 'required|string|max:255',
            'test_price' => 'required|numeric',
            'test_day' => 'nullable|array',
            'test_day.*' => 'nullable|string|max:255',
            'test_start_time' => 'nullable|array',
            'test_start_time.*' => 'nullable|string',
            'test_end_time' => 'nullable|array',
            'test_end_time.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Prepare test day and time data
        $testDayTime = [];
        if ($request->has('test_day') && is_array($request->test_day)) {
            foreach ($request->test_day as $index => $day) {
                $testDayTime[] = [
                    'day' => $day,
                    'start_time' => $request->test_start_time[$index] ?? null,
                    'end_time' => $request->test_end_time[$index] ?? null,
                ];
            }
        }

        $data = [
            'currently_loggedin_partner_id' => $partner->id,
            'test_name' => $request->test_name,
            'test_type' => $request->test_type,
            'test_price' => $request->test_price,
            'test_day_time' => json_encode($testDayTime),
        ];

        $test = PartnerAllPathologyTestModel::create($data);
        $test->test_day_time = $testDayTime;

        return response()->json([
            'status' => true,
            'message' => 'Pathology test details added successfully!',
            'test' => $test
        ], 200);
    }

    /**
     * Update pathology test details
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
            'test_name' => 'required|string|max:255',
            'test_type' => 'required|string|max:255',
            'test_price' => 'required|numeric',
            'test_day' => 'nullable|array',
            'test_day.*' => 'nullable|string|max:255',
            'test_start_time' => 'nullable|array',
            'test_start_time.*' => 'nullable|string',
            'test_end_time' => 'nullable|array',
            'test_end_time.*' => 'nullable|string',
            'status' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        $test = PartnerAllPathologyTestModel::where('id', $id)
            ->where('currently_loggedin_partner_id', $partner->id)
            ->first();

        if (!$test) {
            return response()->json([
                'status' => false,
                'message' => 'Pathology test details not found.'
            ], 404);
        }

        // Prepare test day and time data
        $testDayTime = [];
        if ($request->has('test_day') && is_array($request->test_day)) {
            foreach ($request->test_day as $index => $day) {
                $testDayTime[] = [
                    'day' => $day,
                    'start_time' => $request->test_start_time[$index] ?? null,
                    'end_time' => $request->test_end_time[$index] ?? null,
                ];
            }
        }

        $data = [
            'test_name' => $request->test_name,
            'test_type' => $request->test_type,
            'test_price' => $request->test_price,
            'status' => $request->status ?? $test->status,
            'test_day_time' => json_encode($testDayTime),
        ];

        $test->update($data);
        $test->test_day_time = $testDayTime;

        return response()->json([
            'status' => true,
            'message' => 'Pathology test details updated successfully!',
            'test' => $test
        ], 200);
    }

    /**
     * Delete pathology test
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

        $test = PartnerAllPathologyTestModel::where('id', $id)
            ->where('currently_loggedin_partner_id', $partner->id)
            ->first();

        if (!$test) {
            return response()->json([
                'status' => false,
                'message' => 'Pathology test details not found.'
            ], 404);
        }

        $test->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pathology test details deleted successfully!'
        ], 200);
    }
}
