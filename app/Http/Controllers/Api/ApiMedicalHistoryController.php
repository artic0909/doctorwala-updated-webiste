<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use App\Models\SystemPrescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiMedicalHistoryController extends Controller
{
    /**
     * Get all medical records (both reports & prescriptions)
     */
    public function getAll(Request $request)
    {
        try {
            $records = MedicalHistory::where('dw_user_id', $request->user()->id)
                ->orderBy('date_of_report', 'desc')
                ->get()
                ->map(fn($r) => $this->formatRecord($r));

            return response()->json([
                'status'  => true,
                'message' => 'Medical records fetched successfully.',
                'data'    => $records
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Get only Reports
     */
    public function getReports(Request $request)
    {
        try {
            $records = MedicalHistory::where('dw_user_id', $request->user()->id)
                ->where('type', 'report')
                ->orderBy('date_of_report', 'desc')
                ->get()
                ->map(fn($r) => $this->formatRecord($r));

            return response()->json([
                'status'  => true,
                'message' => 'Reports fetched successfully.',
                'data'    => $records
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Get only Prescriptions
     */
    public function getPrescriptions(Request $request)
    {
        try {
            $records = MedicalHistory::where('dw_user_id', $request->user()->id)
                ->where('type', 'prescription')
                ->orderBy('date_of_report', 'desc')
                ->get()
                ->map(fn($r) => $this->formatRecord($r));

            return response()->json([
                'status'  => true,
                'message' => 'Prescriptions fetched successfully.',
                'data'    => $records
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Get System Prescriptions
     */
    public function getSystemPrescriptions(Request $request)
    {
        try {
            $records = SystemPrescription::where('dw_user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'System prescriptions fetched successfully.',
                'data'    => $records
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Get single record with images
     */
    public function getRecord(Request $request, $id)
    {
        try {
            $record = MedicalHistory::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            return response()->json([
                'status'  => true,
                'message' => 'Record fetched successfully.',
                'data'    => $this->formatRecord($record)
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Record not found or unauthorized.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Add new medical record (mirrors website addMedicalHistory)
     */
    public function addMedicalHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'           => 'required|in:report,prescription',
            'date_of_report' => 'required|date|before_or_equal:today',
            'heading'        => 'required|string|max:255',
            'images'         => 'nullable|array|max:20',
            'images.*'       => 'file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store(
                        'medical_histories/' . $request->user()->id,
                        'public'
                    );
                    $imagePaths[] = $path;
                }
            }

            $record = MedicalHistory::create([
                'dw_user_id'     => $request->user()->id,
                'type'           => $request->type,
                'date_of_report' => $request->date_of_report,
                'heading'        => $request->heading,
                'images'         => $imagePaths,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Medical record added successfully.',
                'data'    => $this->formatRecord($record)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Edit existing medical record (mirrors website editMedicalHistory)
     */
    public function editMedicalHistory(Request $request, $id)
    {
        try {
            $record = MedicalHistory::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $validator = Validator::make($request->all(), [
                'type'            => 'required|in:report,prescription',
                'date_of_report'  => 'required|date|before_or_equal:today',
                'heading'         => 'required|string|max:255',
                'new_images'      => 'nullable|array|max:20',
                'new_images.*'    => 'file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'deleted_images'  => 'nullable|array',
                'deleted_images.*' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation error',
                    'errors'  => $validator->errors()
                ], 422);
            }

            $imagePaths = $record->images ?? [];

            // ── 1. Delete removed files from disk & array ──────────
            if ($request->filled('deleted_images')) {
                foreach ($request->deleted_images as $deletedPath) {
                    if (str_starts_with($deletedPath, 'medical_histories/' . $request->user()->id . '/')) {
                        Storage::disk('public')->delete($deletedPath);
                        $imagePaths = array_filter($imagePaths, fn($p) => $p !== $deletedPath);
                    }
                }
                $imagePaths = array_values($imagePaths);
            }

            // ── 2. Store newly uploaded files ──────────────────────
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $file) {
                    $path = $file->store('medical_histories/' . $request->user()->id, 'public');
                    $imagePaths[] = $path;
                }
            }

            // ── 3. Save ────────────────────────────────────────────
            $record->update([
                'type'           => $request->type,
                'date_of_report' => $request->date_of_report,
                'heading'        => $request->heading,
                'images'         => $imagePaths,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Medical record updated successfully.',
                'data'    => $this->formatRecord($record->fresh())
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Record not found or unauthorized.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete medical record (mirrors website destroy)
     */
    public function destroy(Request $request, $id)
    {
        try {
            $record = MedicalHistory::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            if (!empty($record->images)) {
                foreach ($record->images as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            $record->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Record deleted successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Record not found or unauthorized.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Helper — format record with full image URLs
     */
    private function formatRecord(MedicalHistory $record): array
    {
        return [
            'id'              => $record->id,
            'type'            => $record->type,
            'date_of_report'  => $record->date_of_report,
            'heading'         => $record->heading,
            'images'          => collect($record->images ?? [])->map(
                fn($path) => asset('storage/' . $path)
            )->values()->toArray(),
            'created_at'      => $record->created_at,
            'updated_at'      => $record->updated_at,
            'partner_id'      => $record->partner_id,
            'doctor_name'     => $record->doctor_name,
            'clinic_name'     => $record->clinic_name,
        ];
    }
}
