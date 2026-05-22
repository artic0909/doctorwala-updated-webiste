<?php

namespace App\Http\Controllers\PartnerApi;

use App\Http\Controllers\Controller;
use App\Models\DwPartnerModel;
use App\Mail\SendOTPPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    /**
     * Partner Registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_clinic_name' => 'required|string|max:255',
            'partner_contact_person_name' => 'required|string|max:255',
            'partner_mobile_number' => 'required|string|max:15|unique:dw_partner_models,partner_mobile_number',
            'partner_email' => 'required|string|email|max:255|unique:dw_partner_models,partner_email',
            'partner_state' => 'required|string',
            'partner_city' => 'required|string',
            'partner_pincode' => 'required|string',
            'partner_landmark' => 'required|string',
            'partner_address' => 'required|string',
            'partner_password' => 'required|string|min:6',
            'registration_type' => 'required|array',
            'registration_type.*' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Generate standard DwPartner ID
            $partnerId = 'DWPTR' . (DwPartnerModel::max('id') + 1);

            $partner = new DwPartnerModel();
            $partner->partner_id = $partnerId;
            $partner->partner_clinic_name = $request->partner_clinic_name;
            $partner->partner_contact_person_name = $request->partner_contact_person_name;
            $partner->partner_mobile_number = $request->partner_mobile_number;
            $partner->partner_email = $request->partner_email;
            $partner->partner_state = $request->partner_state;
            $partner->partner_city = $request->partner_city;
            $partner->partner_pincode = $request->partner_pincode;
            $partner->partner_landmark = $request->partner_landmark;
            $partner->partner_address = $request->partner_address;
            $partner->partner_password = bcrypt($request->partner_password);
            $partner->registration_type = json_encode($request->registration_type);
            $partner->status = 'Pending';
            $partner->save();

            // Generate token for direct login upon registration
            $token = $partner->createToken('partner-flutter-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Registration successful! Welcome.',
                'token' => $token,
                'partner' => [
                    'id' => $partner->id,
                    'partner_id' => $partner->partner_id,
                    'partner_clinic_name' => $partner->partner_clinic_name,
                    'partner_contact_person_name' => $partner->partner_contact_person_name,
                    'partner_mobile_number' => $partner->partner_mobile_number,
                    'partner_email' => $partner->partner_email,
                    'partner_state' => $partner->partner_state,
                    'partner_city' => $partner->partner_city,
                    'partner_pincode' => $partner->partner_pincode,
                    'partner_landmark' => $partner->partner_landmark,
                    'partner_address' => $partner->partner_address,
                    'registration_type' => json_decode($partner->registration_type, true) ?? $partner->registration_type,
                    'status' => $partner->status,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during registration. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Partner Login (Password-based)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_email' => 'required|string',
            'partner_password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        $identifier = trim($request->partner_email);

        // Find partner by email or mobile number
        $partner = DwPartnerModel::where('partner_email', $identifier)
            ->orWhere('partner_mobile_number', $identifier)
            ->first();

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'No partner account found with the provided email or mobile number.'
            ], 404);
        }

        if (!Hash::check($request->partner_password, $partner->partner_password)) {
            return response()->json([
                'status' => false,
                'message' => 'Incorrect password. Please try again.'
            ], 401);
        }

        // Generate Sanctum token
        $token = $partner->createToken('partner-flutter-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful.',
            'token' => $token,
            'partner' => [
                'id' => $partner->id,
                'partner_id' => $partner->partner_id,
                'partner_clinic_name' => $partner->partner_clinic_name,
                'partner_contact_person_name' => $partner->partner_contact_person_name,
                'partner_mobile_number' => $partner->partner_mobile_number,
                'partner_email' => $partner->partner_email,
                'partner_state' => $partner->partner_state,
                'partner_city' => $partner->partner_city,
                'partner_pincode' => $partner->partner_pincode,
                'partner_landmark' => $partner->partner_landmark,
                'partner_address' => $partner->partner_address,
                'registration_type' => is_string($partner->registration_type) ? json_decode($partner->registration_type, true) : $partner->registration_type,
                'status' => $partner->status,
            ]
        ], 200);
    }

    /**
     * Send OTP for Passwordless Authentication
     */
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide a valid email address.',
                'errors' => $validator->errors()
            ], 422);
        }

        $partner = DwPartnerModel::where('partner_email', $request->partner_email)->first();

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Email is not registered.'
            ], 404);
        }

        try {
            $otp = rand(1000, 9999);
            
            // Store OTP in Cache for 3 minutes
            Cache::put('partner_otp_' . $request->partner_email, $otp, now()->addMinutes(3));

            // Send OTP email
            Mail::to($request->partner_email)->send(new SendOTPPartner($otp));

            return response()->json([
                'status' => true,
                'message' => 'OTP has been sent to your email.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to send OTP email. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP and Login
     */
    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_email' => 'required|email',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid inputs.',
                'errors' => $validator->errors()
            ], 422);
        }

        $storedOtp = Cache::get('partner_otp_' . $request->partner_email);

        if (!$storedOtp || $storedOtp != $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP.'
            ], 401);
        }

        $partner = DwPartnerModel::where('partner_email', $request->partner_email)->first();

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Partner not found.'
            ], 404);
        }

        // Clean up OTP from cache
        Cache::forget('partner_otp_' . $request->partner_email);

        // Generate Sanctum token
        $token = $partner->createToken('partner-flutter-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully.',
            'token' => $token,
            'partner' => [
                'id' => $partner->id,
                'partner_id' => $partner->partner_id,
                'partner_clinic_name' => $partner->partner_clinic_name,
                'partner_contact_person_name' => $partner->partner_contact_person_name,
                'partner_mobile_number' => $partner->partner_mobile_number,
                'partner_email' => $partner->partner_email,
                'partner_state' => $partner->partner_state,
                'partner_city' => $partner->partner_city,
                'partner_pincode' => $partner->partner_pincode,
                'partner_landmark' => $partner->partner_landmark,
                'partner_address' => $partner->partner_address,
                'registration_type' => is_string($partner->registration_type) ? json_decode($partner->registration_type, true) : $partner->registration_type,
                'status' => $partner->status,
            ]
        ], 200);
    }

    /**
     * Send OTP for Forgot Password
     */
    public function forgotPasswordSendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide a valid email address.',
                'errors' => $validator->errors()
            ], 422);
        }

        $partner = DwPartnerModel::where('partner_email', $request->partner_email)->first();

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Email is not registered.'
            ], 404);
        }

        try {
            $otp = rand(1000, 9999);
            
            // Store OTP in Cache for 5 minutes
            Cache::put('partner_forgot_password_otp_' . $request->partner_email, $otp, now()->addMinutes(5));

            // Send OTP email
            Mail::to($request->partner_email)->send(new SendOTPPartner($otp));

            return response()->json([
                'status' => true,
                'message' => 'OTP has been sent to your email for password reset.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to send OTP email. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP and Reset Password
     */
    public function forgotPasswordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partner_email' => 'required|email',
            'otp' => 'required|digits:4',
            'partner_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        $storedOtp = Cache::get('partner_forgot_password_otp_' . $request->partner_email);

        if (!$storedOtp || $storedOtp != $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP.'
            ], 401);
        }

        $partner = DwPartnerModel::where('partner_email', $request->partner_email)->first();

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Partner not found.'
            ], 404);
        }

        // Update password
        $partner->partner_password = bcrypt($request->partner_password);
        $partner->save();

        // Clean up OTP from cache
        Cache::forget('partner_forgot_password_otp_' . $request->partner_email);

        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully. You can now login with your new password.',
        ], 200);
    }

    /**
     * Get Authenticated Partner Profile
     */
    public function profile(Request $request)
    {
        $partner = $request->user();

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'partner' => [
                'id' => $partner->id,
                'partner_id' => $partner->partner_id,
                'partner_clinic_name' => $partner->partner_clinic_name,
                'partner_contact_person_name' => $partner->partner_contact_person_name,
                'partner_mobile_number' => $partner->partner_mobile_number,
                'partner_email' => $partner->partner_email,
                'partner_state' => $partner->partner_state,
                'partner_city' => $partner->partner_city,
                'partner_pincode' => $partner->partner_pincode,
                'partner_landmark' => $partner->partner_landmark,
                'partner_address' => $partner->partner_address,
                'registration_type' => is_string($partner->registration_type) ? json_decode($partner->registration_type, true) : $partner->registration_type,
                'status' => $partner->status,
            ]
        ], 200);
    }

    /**
     * Logout and Revoke Access Token
     */
    public function logout(Request $request)
    {
        $partner = $request->user();

        if ($partner) {
            $partner->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully.'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized or no active session.'
        ], 401);
    }

    /**
     * Get Coupon Details by code
     */
    public function getCouponDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon code is required.',
                'errors' => $validator->errors()
            ], 422);
        }

        $couponCode = $request->input('coupon_code');
        $coupon = \App\Models\SuperCouponModel::where('coupon_code', $couponCode)->first();

        if ($coupon) {
            return response()->json([
                'success' => true,
                'data' => $coupon,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Coupon not found.',
        ], 404);
    }

    /**
     * Associate Coupon to Partner & Mark Status as Active
     */
    public function partnerCouponCodeAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currently_loggedin_partner_id' => 'required',
            'coupon_code' => 'required|string',
            'coupon_amount' => 'required|string',
            'coupon_start_date' => 'required|string',
            'coupon_end_date' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            \App\Models\CouponHolderModel::create([
                'currently_loggedin_partner_id' => $request->input('currently_loggedin_partner_id'),
                'coupon_code' => $request->input('coupon_code'),
                'coupon_amount' => $request->input('coupon_amount'),
                'coupon_start_date' => $request->input('coupon_start_date'),
                'coupon_end_date' => $request->input('coupon_end_date'),
            ]);

            // Update partner status to Active
            DwPartnerModel::where('id', $request->input('currently_loggedin_partner_id'))
                ->update(['status' => 'Active']);

            // Get updated partner details to return
            $partner = DwPartnerModel::find($request->input('currently_loggedin_partner_id'));

            return response()->json([
                'success' => true,
                'message' => 'Coupon associated and subscription activated successfully!',
                'partner' => [
                    'id' => $partner->id,
                    'partner_id' => $partner->partner_id,
                    'partner_clinic_name' => $partner->partner_clinic_name,
                    'partner_contact_person_name' => $partner->partner_contact_person_name,
                    'partner_mobile_number' => $partner->partner_mobile_number,
                    'partner_email' => $partner->partner_email,
                    'partner_state' => $partner->partner_state,
                    'partner_city' => $partner->partner_city,
                    'partner_pincode' => $partner->partner_pincode,
                    'partner_landmark' => $partner->partner_landmark,
                    'partner_address' => $partner->partner_address,
                    'registration_type' => is_string($partner->registration_type) ? json_decode($partner->registration_type, true) : $partner->registration_type,
                    'status' => $partner->status,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to associate coupon. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Partner Profile
     */
    public function updateProfile(Request $request)
    {
        $partner = $request->user();

        if (!$partner) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'partner_clinic_name' => 'required|string|max:255',
            'partner_contact_person_name' => 'required|string|max:255',
            'partner_mobile_number' => 'required|string|max:15|unique:dw_partner_models,partner_mobile_number,' . $partner->id,
            'partner_email' => 'required|string|email|max:255|unique:dw_partner_models,partner_email,' . $partner->id,
            'partner_state' => 'required|string',
            'partner_city' => 'required|string',
            'partner_pincode' => 'required|string',
            'partner_landmark' => 'required|string',
            'partner_address' => 'required|string',
            'partner_password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $partner->partner_clinic_name = $request->partner_clinic_name;
            $partner->partner_contact_person_name = $request->partner_contact_person_name;
            $partner->partner_mobile_number = $request->partner_mobile_number;
            $partner->partner_email = $request->partner_email;
            $partner->partner_state = $request->partner_state;
            $partner->partner_city = $request->partner_city;
            $partner->partner_pincode = $request->partner_pincode;
            $partner->partner_landmark = $request->partner_landmark;
            $partner->partner_address = $request->partner_address;

            if ($request->filled('partner_password')) {
                $partner->partner_password = bcrypt($request->partner_password);
            }

            $partner->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully!',
                'partner' => [
                    'id' => $partner->id,
                    'partner_id' => $partner->partner_id,
                    'partner_clinic_name' => $partner->partner_clinic_name,
                    'partner_contact_person_name' => $partner->partner_contact_person_name,
                    'partner_mobile_number' => $partner->partner_mobile_number,
                    'partner_email' => $partner->partner_email,
                    'partner_state' => $partner->partner_state,
                    'partner_city' => $partner->partner_city,
                    'partner_pincode' => $partner->partner_pincode,
                    'partner_landmark' => $partner->partner_landmark,
                    'partner_address' => $partner->partner_address,
                    'registration_type' => is_string($partner->registration_type) ? json_decode($partner->registration_type, true) : $partner->registration_type,
                    'status' => $partner->status,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating profile. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get About Us / Help details
     */
    public function getAboutUsDetails()
    {
        $about = \App\Models\SuperAboutusModel::first();
        if ($about) {
            return response()->json([
                'success' => true,
                'data' => $about
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'About Us details not found.'
        ], 404);
    }
}
