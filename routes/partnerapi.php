<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerApi\AuthApiController;
use App\Http\Controllers\PartnerApi\ClinicProfileAddApiController;
use App\Http\Controllers\PartnerApi\DoctoraddApiController;
use App\Http\Controllers\PartnerApi\TestaddApiController;
use App\Http\Controllers\PartnerApi\AppointmentsManagementApiController;
use App\Http\Controllers\PartnerApi\MedicalCardAccessController;

// Public routes for partner API
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/send-otp', [AuthApiController::class, 'sendOTP']);
Route::post('/verify-otp', [AuthApiController::class, 'verifyOTP']);
Route::post('/forgot-password/send-otp', [AuthApiController::class, 'forgotPasswordSendOtp']);
Route::post('/forgot-password/reset', [AuthApiController::class, 'forgotPasswordReset']);
Route::get('/about-us', [AuthApiController::class, 'getAboutUsDetails']);


// Protected routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/profile/update', [AuthApiController::class, 'updateProfile']);
    Route::post('/get-coupon-details', [AuthApiController::class, 'getCouponDetails']);
    Route::post('/add-partner-coupon', [AuthApiController::class, 'partnerCouponCodeAdd']);

    // Clinic Profile (OPD, Pathology & Doctor Contact) Routes
    Route::get('/clinic-profile/opd', [ClinicProfileAddApiController::class, 'getOPDContact']);
    Route::post('/clinic-profile/opd', [ClinicProfileAddApiController::class, 'storeOPDContact']);
    Route::get('/clinic-profile/pathology', [ClinicProfileAddApiController::class, 'getPathologyContact']);
    Route::post('/clinic-profile/pathology', [ClinicProfileAddApiController::class, 'storePathologyContact']);
    Route::get('/clinic-profile/doctor', [ClinicProfileAddApiController::class, 'getDoctorContact']);
    Route::post('/clinic-profile/doctor', [ClinicProfileAddApiController::class, 'storeDoctorContact']);

    // Doctor Add/Manage Routes
    Route::get('/doctors', [DoctoraddApiController::class, 'index']);
    Route::post('/doctors', [DoctoraddApiController::class, 'store']);
    Route::post('/doctors/{id}', [DoctoraddApiController::class, 'update']);
    Route::delete('/doctors/{id}', [DoctoraddApiController::class, 'destroy']);

    // Test Add/Manage Routes
    Route::get('/tests', [TestaddApiController::class, 'index']);
    Route::post('/tests', [TestaddApiController::class, 'store']);
    Route::post('/tests/{id}', [TestaddApiController::class, 'update']);
    Route::delete('/tests/{id}', [TestaddApiController::class, 'destroy']);

    // Appointments Management Routes
    Route::get('/appointments', [AppointmentsManagementApiController::class, 'index']);
    Route::get('/appointments/stats', [AppointmentsManagementApiController::class, 'stats']);
    Route::post('/appointments/{id}/status', [AppointmentsManagementApiController::class, 'updateStatus']);

    // Medical Card Access Routes
    Route::get('/medical-card-access/meta', [MedicalCardAccessController::class, 'index']);
    Route::post('/medical-card-access/lookup', [MedicalCardAccessController::class, 'patientLookup']);
    Route::post('/medical-card-access/request', [MedicalCardAccessController::class, 'sendRequest']);
    Route::get('/medical-card-access/requests', [MedicalCardAccessController::class, 'allRequests']);
    Route::get('/medical-card-access/patient/{encryptedId}', [MedicalCardAccessController::class, 'viewPatientProfile']);
    Route::get('/medical-card-access/patient/{encryptedId}/history', [MedicalCardAccessController::class, 'viewMedicalHistory']);
    Route::get('/medical-card-access/report/{encryptedId}', [MedicalCardAccessController::class, 'viewPatientReportDetails']);
});