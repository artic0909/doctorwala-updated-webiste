<?php

namespace App\Http\Controllers\Partnerpanel;

use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use Illuminate\Http\Request;
use App\Models\DwUserModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SystemPrescription;
use Carbon\Carbon;

class PrescriptionController extends Controller
{
    // ─── shared: decrypt ID & verify access ───────────────────────
    private function resolvePatient(string $encryptedId): array
    {
        try {
            $dwUserId = \Illuminate\Support\Facades\Crypt::decryptString($encryptedId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'Invalid link.');
        }

        $partner   = Auth::guard('partner')->user();
        $partnerId = $partner->partner_id;

        $access = \App\Models\AccessRequest::where('dw_user_id', $dwUserId)
            ->where('currently_loggedin_partner_id', $partnerId)
            ->first();

        $blocked = !$access
            || $access->req_status    !== 'accepted'
            || $access->access_status !== 'on';

        $patient = \App\Models\DwUserModel::findOrFail($dwUserId);

        return [$dwUserId, $patient, $blocked, $partner, $partner->id];
    }

    public function index($encryptedId)
    {
        [$dwUserId, $patient, $blocked, $partner, $partnerId] = $this->resolvePatient($encryptedId);

        if ($blocked) {
            return view('partnerpanel.block', compact('patient'));
        }

        $vital = \App\Models\Vital::where('dw_user_id', $dwUserId)->latest()->first();

        $clinicName = $partner->partner_clinic_name ?? 'N/A';
        $doctors = \App\Models\PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partner->id)
            ->orWhere('currently_loggedin_partner_id', $partner->partner_id)
            ->get();

        $encryptedPatientId = $encryptedId;

        return view('partnerpanel.make-prescription', compact('encryptedId', 'patient', 'vital', 'dwUserId', 'clinicName', 'doctors', 'partnerId', 'encryptedPatientId'));
    }

    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $record = MedicalHistory::findOrFail($id);
        $partner = Auth::guard('partner')->user();

        // Security check: only this partner can edit
        if ($record->partner_id !== $partner->partner_id) {
            abort(403, 'Unauthorized to edit this record.');
        }

        $dwUserId = $record->dw_user_id;
        $patient = DwUserModel::findOrFail($dwUserId);
        $vital = \App\Models\Vital::where('dw_user_id', $dwUserId)->latest()->first();
        
        $partnerIdNum = $partner->id;
        $clinicName = $partner->partner_clinic_name ?? 'N/A';
        $doctors = \App\Models\PartnerAllOPDDoctorModel::where('currently_loggedin_partner_id', $partnerIdNum)
            ->orWhere('currently_loggedin_partner_id', $partner->partner_id)
            ->get();

        $encryptedPatientId = Crypt::encryptString($record->dw_user_id);

        return view('partnerpanel.make-prescription', compact('encryptedId', 'patient', 'vital', 'dwUserId', 'clinicName', 'doctors', 'partnerIdNum', 'record', 'encryptedPatientId'));
    }

    public function storeImageReportOrPrescription(Request $request)
    {
        $request->validate([
            'dw_user_id' => 'required|integer|exists:dw_user_models,id',
            'type' => 'required|in:report,prescription',
            'date_of_report' => 'required|date|before_or_equal:today',
            'heading' => 'required|string|max:255',
            'opd_doctor_id' => 'nullable|integer',
            'images' => 'nullable|array|max:20',
            'images.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:5120', // 5 MB each
        ]);

        // ── Store images ──────────────────────────────────────────
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Store under storage/app/public/medical_histories/{dw_user_id}/
                $path = $file->store(
                    'medical_histories/' . $request->dw_user_id,
                    'public'
                );
                $imagePaths[] = $path;
            }
        }

        $partner = Auth::guard('partner')->user();
        $doctorName = null;
        if ($request->opd_doctor_id) {
            $doc = \App\Models\PartnerAllOPDDoctorModel::find($request->opd_doctor_id);
            if ($doc) {
                $doctorName = $doc->doctor_name;
            }
        }

        // ── Create record ─────────────────────────────────────────
        MedicalHistory::create([
            'dw_user_id' => $request->dw_user_id, // Use patient ID from request
            'partner_id' => $partner->id,
            'clinic_name' => $partner->partner_clinic_name,
            'opd_doctor_id' => $request->opd_doctor_id,
            'doctor_name' => $doctorName,
            'type' => $request->type,
            'date_of_report' => $request->date_of_report,
            'heading' => $request->heading,
            'images' => $imagePaths, // cast to JSON via model
        ]);

        return redirect()->back()->with('success', 'Medical record added successfully.');
    }

    public function editImageReportOrPrescription(Request $request, $id)
    {
        $partner = Auth::guard('partner')->user();
        $record = MedicalHistory::where('id', $id)->firstOrFail();
        
        // Security check: only this partner can edit
        if ($record->partner_id != $partner->id) {
            abort(403, 'Unauthorized to edit this record.');
        }

        $request->validate([
            'type' => 'required|in:report,prescription',
            'date_of_report' => 'required|date|before_or_equal:today',
            'heading' => 'required|string|max:255',
            'opd_doctor_id' => 'nullable|integer',
            'new_images' => 'nullable|array|max:20',
            'new_images.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'string',
        ]);

        $imagePaths = $record->images ?? [];

        // ── 1. Delete removed files from disk & array ─────────────
        if ($request->filled('deleted_images')) {
            foreach ($request->deleted_images as $deletedPath) {
                // Security: make sure the path belongs to this user
                if (str_starts_with($deletedPath, 'medical_histories/' . $record->dw_user_id . '/')) {
                    Storage::disk('public')->delete($deletedPath);
                    $imagePaths = array_filter($imagePaths, fn($p) => $p !== $deletedPath);
                }
            }
            $imagePaths = array_values($imagePaths); // re-index
        }

        // ── 2. Store newly uploaded files ─────────────────────────
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $file) {
                $path = $file->store('medical_histories/' . $record->dw_user_id, 'public');
                $imagePaths[] = $path;
            }
        }

        $doctorName = $record->doctor_name;
        if ($request->has('opd_doctor_id') && $request->opd_doctor_id != $record->opd_doctor_id) {
            $doc = \App\Models\PartnerAllOPDDoctorModel::find($request->opd_doctor_id);
            if ($doc) {
                $doctorName = $doc->doctor_name;
            } else {
                $doctorName = null;
            }
        }

        // ── 3. Save ───────────────────────────────────────────────
        $record->update([
            'type' => $request->type,
            'date_of_report' => $request->date_of_report,
            'heading' => $request->heading,
            'opd_doctor_id' => $request->opd_doctor_id,
            'doctor_name' => $doctorName,
            'images' => $imagePaths,
        ]);

        return redirect()->back()->with('success', 'Medical record updated successfully.');
    }

    public function systemFormPrescription(Request $request)
    {
        $request->validate([
            'dw_user_id' => 'required|exists:dw_user_models,id',
            'opd_doctor_id' => 'nullable|integer',
            'prescription_date' => 'required|date',
            'user_age' => 'nullable|string',
            'user_gender' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'bp' => 'nullable|string',
            'pulse' => 'nullable|string',
            'spo2' => 'nullable|string',
            'temperature' => 'nullable|string',
            'weight' => 'nullable|string',
            'heading' => 'nullable|string|max:255',
            'symptoms' => 'nullable|array',
            'other_symptoms' => 'nullable|string',
            'tests' => 'nullable|array',
            'tests.*.name' => 'required|string',
            'tests.*.priority' => 'nullable|string',
            'tests.*.notes' => 'nullable|string',
            'medicines' => 'nullable|array',
            'medicines.*.name' => 'required|string',
            'medicines.*.chemical' => 'nullable|string',
            'medicines.*.brand' => 'nullable|string',
            'medicines.*.dose' => 'nullable|string',
            'medicines.*.timing' => 'nullable|array',
            'medicines.*.eating' => 'nullable|array',
            'medicines.*.days' => 'nullable|string',
            'medical_instructions' => 'nullable|string',
            'diet_instructions' => 'nullable|string',
            'next_visit_date' => 'nullable|date',
            'repeat_tests_required' => 'nullable|string',
            'emergency_note' => 'nullable|string',
        ]);

        $partner = Auth::guard('partner')->user();
        $doctorName = null;
        if ($request->opd_doctor_id) {
            $doc = \App\Models\PartnerAllOPDDoctorModel::find($request->opd_doctor_id);
            if ($doc) {
                $doctorName = $doc->doctor_name;
            }
        }

        $symptomsData = $request->symptoms ?? [];
        if ($request->other_symptoms) {
            $symptomsData[] = $request->other_symptoms;
        }

        SystemPrescription::create([
            'dw_user_id' => $request->dw_user_id,
            'partner_id' => $partner->id,
            'opd_doctor_id' => $request->opd_doctor_id,
            'doctor_name' => $doctorName,
            'prescription_date' => Carbon::parse($request->prescription_date),
            'user_age' => $request->user_age,
            'user_gender' => $request->user_gender,
            'blood_group' => $request->blood_group,
            'bp' => $request->bp,
            'pulse' => $request->pulse,
            'spo2' => $request->spo2,
            'temperature' => $request->temperature,
            'weight' => $request->weight,
            'heading' => $request->heading,
            'symptoms' => $symptomsData,
            'recommended_tests' => $request->tests,
            'medicines' => $request->medicines,
            'medical_instructions' => $request->medical_instructions,
            'diet_instructions' => $request->diet_instructions,
            'next_visit_date' => $request->next_visit_date ? Carbon::parse($request->next_visit_date) : null,
            'repeat_tests_required' => $request->repeat_tests_required === 'yes',
            'emergency_note' => $request->emergency_note,
        ]);

        $encryptedId = Crypt::encryptString($request->dw_user_id);

        return redirect()->route('partner.patient.medical-history', $encryptedId)
            ->with('success', 'Digital prescription saved successfully.');
    }

    public function viewPrescription($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            abort(403, 'Invalid link.');
        }

        $prescription = SystemPrescription::findOrFail($id);
        $patient = DwUserModel::findOrFail($prescription->dw_user_id);
        $partner = Auth::guard('partner')->user();

        // Check if partner has access to this patient
        $access = \App\Models\AccessRequest::where('dw_user_id', $patient->id)
            ->where('currently_loggedin_partner_id', $partner->partner_id)
            ->first();

        if (!$access || $access->req_status !== 'accepted' || $access->access_status !== 'on') {
            abort(403, 'Unauthorized access to this prescription.');
        }

        return view('partnerpanel.view-digital-prescription', compact('prescription', 'patient', 'partner'));
    }

    public function viewPrescriptionUser($id)
    {
        $prescription = SystemPrescription::where('id', $id)
            ->where('dw_user_id', Auth::guard('dwuser')->id())
            ->firstOrFail();

        $patient = DwUserModel::findOrFail($prescription->dw_user_id);
        
        // Find the partner info for the header
        $partner = \App\Models\DwPartnerModel::find($prescription->partner_id);

        return view('partnerpanel.view-digital-prescription', compact('prescription', 'patient', 'partner'));
    }

    public function viewPrescriptionShared($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            try {
                // Support double base64/encryption check or plain numeric ID
                if (is_numeric($encryptedId)) {
                    $id = $encryptedId;
                } else {
                    $id = Crypt::decryptString(urldecode($encryptedId));
                }
            } catch (\Exception $ex) {
                abort(403, 'Invalid link.');
            }
        }

        $prescription = SystemPrescription::findOrFail($id);
        $patient = DwUserModel::findOrFail($prescription->dw_user_id);
        $partner = \App\Models\DwPartnerModel::find($prescription->partner_id);

        if (!$partner) {
            $partner = \App\Models\PartnerOPDContactModel::where('id', $prescription->partner_id)->first();
        }

        return view('partnerpanel.view-digital-prescription', compact('prescription', 'patient', 'partner'));
    }
}
