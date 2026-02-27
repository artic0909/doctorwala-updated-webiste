<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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

        return view('user-profile', compact('user', 'aboutDetails', 'otherBanners', 'latestSingleBooking', 'bookings'));
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
            'user_password' => 'required|string|min:8',
        ]);




        $userId = Auth::guard('dwuser')->id();

        if (!$userId) {
            return back()->withErrors(['message' => 'User not found or not logged in']);
        }


        $newPassword = Hash::make($request->user_password);



        $updateResult = DB::table('dw_user_models')
            ->where('id', $userId)
            ->update([
                'user_password' => $newPassword,
            ]);

        if ($updateResult) {
            return back()->with('password_update_status', 'success');
        } else {
            return back()->with('password_update_status', 'failure');
        }
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
}
