<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiVitalsController extends Controller
{
    /**
     * Get all vitals of authenticated user
     */
    public function getVitals(Request $request)
    {
        try {
            $vitals = Vital::where('dw_user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Vitals fetched successfully.',
                'data'    => $vitals
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Add new vitals (mirrors website addVitals)
     */
    public function addVitals(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'heart_rate'     => 'nullable|numeric|min:30|max:250',
            'blood_pressure' => 'nullable|string|max:20',
            'temparature'    => 'nullable|numeric|min:30',
            'spo'            => 'nullable|numeric|min:50|max:100',
            'blood_sugar'    => 'nullable|numeric|min:20|max:600',
            'weight'         => 'nullable|numeric|min:1|max:300',
            'height'         => 'nullable|numeric|min:50|max:300',
            'bmi'            => 'nullable|numeric',
            'blood_group'    => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $vital = Vital::create([
                'dw_user_id'     => $request->user()->id,
                'heart_rate'     => $request->heart_rate,
                'blood_pressure' => $request->blood_pressure,
                'temparature'    => $request->temparature,
                'spo'            => $request->spo,
                'blood_sugar'    => $request->blood_sugar,
                'weight'         => $request->weight,
                'height'         => $request->height,
                'bmi'            => $request->bmi,
                'blood_group'    => $request->blood_group,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Vitals saved successfully.',
                'data'    => $vital
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Edit existing vitals (mirrors website editVitals)
     */
    public function editVitals(Request $request, $id)
    {
        try {
            $vital = Vital::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $validator = Validator::make($request->all(), [
                'heart_rate'     => 'nullable|numeric|min:30|max:250',
                'blood_pressure' => 'nullable|string|max:20',
                'temparature'    => 'nullable|numeric|min:30',
                'spo'            => 'nullable|numeric|min:50|max:100',
                'blood_sugar'    => 'nullable|numeric|min:20|max:600',
                'weight'         => 'nullable|numeric|min:1|max:300',
                'height'         => 'nullable|numeric|min:50|max:300',
                'bmi'            => 'nullable|numeric',
                'blood_group'    => 'nullable|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation error',
                    'errors'  => $validator->errors()
                ], 422);
            }

            $vital->update([
                'heart_rate'     => $request->heart_rate,
                'blood_pressure' => $request->blood_pressure,
                'temparature'    => $request->temparature,
                'spo'            => $request->spo,
                'blood_sugar'    => $request->blood_sugar,
                'weight'         => $request->weight,
                'height'         => $request->height,
                'bmi'            => $request->bmi,
                'blood_group'    => $request->blood_group,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Vitals updated successfully.',
                'data'    => $vital->fresh()
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Vital record not found or unauthorized.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete a vital record
     */
    public function deleteVitals($id, Request $request)
    {
        try {
            $vital = Vital::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $vital->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Vital record deleted successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Vital record not found or unauthorized.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }
}
