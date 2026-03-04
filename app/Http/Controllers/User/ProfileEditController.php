<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\MedicalHistory;
use App\Models\PartnerAllOPDDoctorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PartnerDoctorContactModel;
use App\Models\PartnerAllPathologyTestModel;
use App\Models\PartnerFeedback;
use App\Models\PartnerOPDContactModel;
use App\Models\PartnerPathologyContactModel;
use App\Models\PartnerPatientInquiry;
use App\Models\SuperAboutusModel;
use App\Models\SuperHomeBannerModel;
use App\Models\SuperOtherBannerModel;
use App\Models\Vital;
use Illuminate\Support\Facades\Storage;

class ProfileEditController extends Controller
{
    protected $guard = 'dwuser';

    public function userProfileEditWithCurrentUserDetails()
    {

        $specialists = PartnerAllOPDDoctorModel::distinct()->pluck('doctor_specialist');
        $types = PartnerAllPathologyTestModel::distinct()->pluck('test_type');

        $aboutDetails = SuperAboutusModel::get();
        $homeBanners = SuperHomeBannerModel::get();

        $opds = PartnerOPDContactModel::with('banner')->get();
        $paths = PartnerPathologyContactModel::with('banner')->get();
        $docs = PartnerDoctorContactModel::with('banner')->get();

        $testi = PartnerFeedback::get();

        $user = Auth::guard('dwuser')->user();
        return view('index', compact('user', 'aboutDetails', 'homeBanners', 'opds', 'paths', 'docs', 'specialists', 'types', 'testi'));
    }


    // Profile
    public function userProfile()
    {
        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();
        $user = Auth::guard('dwuser')->user();
        $latestSingleBooking = PartnerPatientInquiry::where('dw_user_id', $user->id)
            ->where('status', '=', 'Upcoming')
            ->with(['opdContact.banner', 'pathologyContact.banner', 'doctorContact.banner', 'user', 'doctor', 'test'])
            ->latest()
            ->first();

        $bookings = PartnerPatientInquiry::where('dw_user_id', $user->id)
            ->with(['opdContact.banner', 'pathologyContact.banner', 'doctorContact.banner', 'user', 'doctor', 'test'])
            ->latest()
            ->get();

        $histories = MedicalHistory::where('dw_user_id', Auth::id())
            ->latest('date_of_report')
            ->paginate(10);

        $noOfPrescription = MedicalHistory::where('dw_user_id', Auth::id())
            ->where('type', 'prescription')
            ->count();
        $noOfReport = MedicalHistory::where('dw_user_id', Auth::id())
            ->where('type', 'report')
            ->count();

        $vital = Vital::where('dw_user_id', Auth::id())->latest()->first();

        $noOfRequest = AccessRequest::where('dw_user_id', Auth::id())->count();

        return view('user-profile', compact('user', 'aboutDetails', 'otherBanners', 'latestSingleBooking', 'bookings', 'histories', 'noOfPrescription', 'noOfReport', 'vital', 'noOfRequest'));
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'user_name'         => 'required|string|max:255',
            'user_email'        => 'required|email|max:255',
            'user_mobile'       => 'required|string|max:15',
            'dob'               => 'nullable|date',
            'gender'            => 'nullable|string|max:10',
            'address'           => 'nullable|string|max:500',
            'blood_group'       => 'nullable|string|max:5',
            'height'            => 'nullable|numeric',
            'weight'            => 'nullable|numeric',
            'emergency_contact' => 'nullable|string|max:15',
            'allergies'         => 'nullable|string',
            'chronic_conditions' => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {

            $userId = Auth::guard('dwuser')->id();

            $data = [
                'user_name'          => $request->user_name,
                'user_email'         => $request->user_email,
                'user_mobile'        => $request->user_mobile,
                'dob'                => $request->dob,
                'gender'             => $request->gender,
                'address'            => $request->address,
                'blood_group'        => $request->blood_group,
                'height'             => $request->height,
                'weight'             => $request->weight,
                'emergency_contact'  => $request->emergency_contact,
                'allergies'          => $request->allergies,
                'chronic_conditions' => $request->chronic_conditions,
            ];

            // ── Profile image upload ───────────────────────────────────────────
            if ($request->hasFile('image')) {

                // Delete old image if exists
                $oldImage = DB::table('dw_user_models')->where('id', $userId)->value('image');
                if ($oldImage && file_exists(public_path('storage/' . $oldImage))) {
                    unlink(public_path('storage/' . $oldImage));
                }

                $file      = $request->file('image');
                $fileName  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/images'), $fileName);

                $data['image'] = 'images/' . $fileName;
            }

            DB::table('dw_user_models')
                ->where('id', $userId)
                ->update($data);

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Illuminate\Database\QueryException $e) {

            return back()->withInput()->with('error', 'This email or mobile is already in use.');
        } catch (\Exception $e) {

            return back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::guard('dwuser')->user();

        if (!$user) {
            return back()->with('password_error', 'User not found or not logged in.');
        }

        // Check current password against existing hash
        if (!Hash::check($request->current_password, $user->user_password)) {
            return back()->with('password_error', 'Current password is incorrect.');
        }

        DB::table('dw_user_models')
            ->where('id', $user->id)
            ->update([
                'user_password' => Hash::make($request->password),
            ]);

        return back()->with('password_success', 'Password updated successfully.');
    }

    public function updatePatientEnquiryStatusIntoComplete($id)
    {
        $inquiry = PartnerPatientInquiry::find($id);

        if (!$inquiry) {
            return back()->with('error', 'Inquiry not found.');
        }

        $inquiry->status = 'Completed';
        $inquiry->save();

        return back()->with('success', 'Inquiry status updated to Completed.');
    }

    public function cancelPatientEnquiry($id)
    {
        $inquiry = PartnerPatientInquiry::find($id);

        if (!$inquiry) {
            return back()->with('error', 'Inquiry not found.');
        }

        $inquiry->status = 'Cancelled';
        $inquiry->save();

        return back()->with('success', 'Inquiry has been cancelled.');
    }

    public function medicalHistory()
    {
        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();
        $user = Auth::guard('dwuser')->user();
        $latestSingleBooking = PartnerPatientInquiry::where('dw_user_id', $user->id)
            ->where('status', '=', 'Upcoming')
            ->with(['opdContact.banner', 'pathologyContact.banner', 'doctorContact.banner', 'user', 'doctor', 'test'])
            ->latest()
            ->first();

        $bookings = PartnerPatientInquiry::where('dw_user_id', $user->id)
            ->with(['opdContact.banner', 'pathologyContact.banner', 'doctorContact.banner', 'user', 'doctor', 'test'])
            ->latest()
            ->get();

        $histories = MedicalHistory::where('dw_user_id', Auth::id())
            ->latest('date_of_report')
            ->paginate(10);

        $noOfPrescription = MedicalHistory::where('dw_user_id', Auth::id())
            ->where('type', 'prescription')
            ->count();
        $noOfReport = MedicalHistory::where('dw_user_id', Auth::id())
            ->where('type', 'report')
            ->count();

        $vital = Vital::where('dw_user_id', Auth::id())->latest()->first();

        return view('user-medical-history', compact('user', 'aboutDetails', 'otherBanners', 'latestSingleBooking', 'bookings', 'histories', 'noOfPrescription', 'noOfReport', 'vital'));
    }

    public function addMedicalHistory(Request $request)
    {
        $request->validate([
            'dw_user_id'     => 'required|integer|exists:dw_user_models,id',
            'type'           => 'required|in:report,prescription',
            'date_of_report' => 'required|date|before_or_equal:today',
            'heading'        => 'required|string|max:255',
            'images'         => 'nullable|array|max:20',
            'images.*'       => 'file|mimes:jpg,jpeg,png,webp,pdf|max:5120', // 5 MB each
        ]);

        // ── Store images ──────────────────────────────────────────
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Store under storage/app/public/medical_histories/{user_id}/
                $path = $file->store(
                    'medical_histories/' . Auth::id(),
                    'public'
                );
                $imagePaths[] = $path;
            }
        }

        // ── Create record ─────────────────────────────────────────
        MedicalHistory::create([
            'dw_user_id'     => Auth::id(), // always use authenticated ID, ignore user-supplied value
            'type'           => $request->type,
            'date_of_report' => $request->date_of_report,
            'heading'        => $request->heading,
            'images'         => $imagePaths, // cast to JSON via model
        ]);

        return redirect()->back()->with('success', 'Medical record added successfully.');
    }

    public function editMecicalHistory(Request $request, $id)
    {
        $record = MedicalHistory::where('id', $id)
            ->where('dw_user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'type'            => 'required|in:report,prescription',
            'date_of_report'  => 'required|date|before_or_equal:today',
            'heading'         => 'required|string|max:255',
            'new_images'      => 'nullable|array|max:20',
            'new_images.*'    => 'file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'deleted_images'  => 'nullable|array',
            'deleted_images.*' => 'string',
        ]);

        $imagePaths = $record->images ?? [];

        // ── 1. Delete removed files from disk & array ─────────────
        if ($request->filled('deleted_images')) {
            foreach ($request->deleted_images as $deletedPath) {
                // Security: make sure the path belongs to this user
                if (str_starts_with($deletedPath, 'medical_histories/' . Auth::id() . '/')) {
                    Storage::disk('public')->delete($deletedPath);
                    $imagePaths = array_filter($imagePaths, fn($p) => $p !== $deletedPath);
                }
            }
            $imagePaths = array_values($imagePaths); // re-index
        }

        // ── 2. Store newly uploaded files ─────────────────────────
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $file) {
                $path = $file->store('medical_histories/' . Auth::id(), 'public');
                $imagePaths[] = $path;
            }
        }

        // ── 3. Save ───────────────────────────────────────────────
        $record->update([
            'type'           => $request->type,
            'date_of_report' => $request->date_of_report,
            'heading'        => $request->heading,
            'images'         => $imagePaths,
        ]);

        return redirect()->back()->with('success', 'Medical record updated successfully.');
    }

    public function viewReportImagesOrPdf($id)
    {
        $record = MedicalHistory::where('id', $id)
            ->where('dw_user_id', Auth::id())
            ->firstOrFail();

        return view('user-view-report-images', compact('record'));
    }

    public function destroy($id)
    {
        $record = MedicalHistory::where('id', $id)
            ->where('dw_user_id', Auth::id()) // ensure ownership
            ->firstOrFail();

        // Remove stored images from disk
        if (!empty($record->images)) {
            foreach ($record->images as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $record->delete();

        return redirect()->back()->with('success', 'Record deleted.');
    }

    public function addVitals(Request $request)
    {
        $request->validate([
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

        Vital::create([
            'dw_user_id'     => Auth::id(),
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

        return redirect()->back()->with('success', 'Vitals saved successfully.');
    }

    public function editVitals(Request $request, $id)
    {
        $vital = Vital::where('id', $id)
            ->where('dw_user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
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

        return redirect()->back()->with('success', 'Vitals updated successfully.');
    }

    public function notification()
    {
        $aboutDetails = SuperAboutusModel::get();
        $otherBanners = SuperOtherBannerModel::get();
        $user = Auth::guard('dwuser')->user();

        $requests = AccessRequest::where('dw_user_id', $user->id)
            ->with(['doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user-notification', compact('user', 'aboutDetails', 'otherBanners', 'requests'));
    }

    public function acceptRequest($id)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', Auth::guard('dwuser')->id())
                ->firstOrFail();

            $req->update([
                'req_status'    => 'accepted',
                'access_status' => 'on',
                'read_status'   => 'read',
            ]);

            return redirect()->back()->with('success', 'Request accepted. The clinic can now view your medical profile.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Request not found or unauthorized.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function rejectRequest($id)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', Auth::guard('dwuser')->id())
                ->firstOrFail();

            $req->update([
                'req_status'    => 'rejected',
                'access_status' => 'off',
                'read_status'   => 'read',
            ]);

            return redirect()->back()->with('success', 'Request rejected successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Request not found or unauthorized.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function permissionOffRequest($id)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', Auth::guard('dwuser')->id())
                ->firstOrFail();

            $req->update([
                'req_status'    => 'rejected',
                'access_status' => 'off',
                'read_status'   => 'read',
            ]);

            return redirect()->back()->with('success', 'Access has been revoked for this clinic.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Request not found or unauthorized.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function permissionOnRequest($id)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', Auth::guard('dwuser')->id())
                ->firstOrFail();

            $req->update([
                'req_status'    => 'accepted',
                'access_status' => 'on',
                'read_status'   => 'read',
            ]);

            return redirect()->back()->with('success', 'Access has been granted to this clinic.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Request not found or unauthorized.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
