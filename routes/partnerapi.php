<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerApi\AuthApiController;
use App\Http\Controllers\PartnerApi\ClinicProfileAddApiController;

// Public routes for partner API
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/send-otp', [AuthApiController::class, 'sendOTP']);
Route::post('/verify-otp', [AuthApiController::class, 'verifyOTP']);
Route::post('/forgot-password/send-otp', [AuthApiController::class, 'forgotPasswordSendOtp']);
Route::post('/forgot-password/reset', [AuthApiController::class, 'forgotPasswordReset']);

// Protected routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/get-coupon-details', [AuthApiController::class, 'getCouponDetails']);
    Route::post('/add-partner-coupon', [AuthApiController::class, 'partnerCouponCodeAdd']);

    // Clinic Profile (OPD & Pathology) Routes
    Route::get('/clinic-profile/opd', [ClinicProfileAddApiController::class, 'getOPDContact']);
    Route::post('/clinic-profile/opd', [ClinicProfileAddApiController::class, 'storeOPDContact']);
    Route::get('/clinic-profile/pathology', [ClinicProfileAddApiController::class, 'getPathologyContact']);
    Route::post('/clinic-profile/pathology', [ClinicProfileAddApiController::class, 'storePathologyContact']);
});