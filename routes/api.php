<?php

use App\Http\Controllers\Api\ApiAllDoctorController;
use App\Http\Controllers\Api\ApiAllOPDController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiBlogController;
use App\Http\Controllers\Api\ApiAllPathologyController;
use App\Http\Controllers\Api\ApiAppointmentsController;
use App\Http\Controllers\Api\ApiCouponsController;
use App\Http\Controllers\Api\ApiDocAppointmentBookingController;
use App\Http\Controllers\Api\ApiMedicalHistoryController;
use App\Http\Controllers\Api\ApiNotificationController;
use App\Http\Controllers\Api\ApiOpdAppointmentBookingController;
use App\Http\Controllers\Api\ApiPathAppointmentBookingController;
use App\Http\Controllers\Api\ApiUserLoginController;
use App\Http\Controllers\Api\ApiUserOTPController;
use App\Http\Controllers\Api\ApiUserProfileEditController;
use App\Http\Controllers\Api\ApiUserRegisterController;
use App\Http\Controllers\Api\ApiPatientFeedbackController;
use App\Http\Controllers\Api\ApiSearchHandleController;
use App\Http\Controllers\Api\ApiVitalsController;
use Illuminate\Http\Request;


// create api routes here for flutter app ------------------------------->
Route::post('/login', [ApiUserLoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [ApiUserLoginController::class, 'logout']);
Route::post('/register', [ApiUserRegisterController::class, 'register']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'name' => $request->user()->user_name,
        'email' => $request->user()->user_email,
    ]);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-profile', [ApiUserProfileEditController::class, 'getProfile']);
    Route::post('/update-profile', [ApiUserProfileEditController::class, 'updateProfile']);
    Route::post('/update-password', [ApiUserProfileEditController::class, 'updatePassword']);

    // Notifications
    Route::get('/notifications',                        [ApiNotificationController::class, 'notifications']);
    Route::post('/notifications/{id}/accept',           [ApiNotificationController::class, 'acceptRequest']);
    Route::post('/notifications/{id}/reject',           [ApiNotificationController::class, 'rejectRequest']);
    Route::post('/notifications/{id}/permission-off',   [ApiNotificationController::class, 'permissionOffRequest']);
    Route::post('/notifications/{id}/permission-on',    [ApiNotificationController::class, 'permissionOnRequest']);

    // Vitals
    Route::get('/vitals',           [ApiVitalsController::class, 'getVitals']);
    Route::post('/vitals',          [ApiVitalsController::class, 'addVitals']);
    Route::put('/vitals/{id}',      [ApiVitalsController::class, 'editVitals']);
    Route::delete('/vitals/{id}',   [ApiVitalsController::class, 'deleteVitals']);

    // Medical History
    Route::get('/medical-history',                  [ApiMedicalHistoryController::class, 'getAll']);
    Route::get('/medical-history/reports',          [ApiMedicalHistoryController::class, 'getReports']);
    Route::get('/medical-history/prescriptions',    [ApiMedicalHistoryController::class, 'getPrescriptions']);
    Route::get('/medical-history/{id}',             [ApiMedicalHistoryController::class, 'getRecord']);
    Route::post('/medical-history',                 [ApiMedicalHistoryController::class, 'addMedicalHistory']);
    Route::post('/medical-history/{id}',            [ApiMedicalHistoryController::class, 'editMedicalHistory']);
    Route::delete('/medical-history/{id}',          [ApiMedicalHistoryController::class, 'destroy']);

    // Global Search
    Route::get('/search', [ApiSearchHandleController::class, 'search']);

    // Opd & Pathology & Doctor Appointments
    Route::post('/opd-appointment', [ApiOpdAppointmentBookingController::class, 'patientInquiry']);
    Route::post('/path-appointment', [ApiPathAppointmentBookingController::class, 'patientInquiry']);
    Route::post('/doc-appointment', [ApiDocAppointmentBookingController::class, 'patientInquiry']);


    // Appointments
    Route::get('/appointments',                         [ApiAppointmentsController::class, 'getAppointments']);
    Route::get('/appointments/{id}',                    [ApiAppointmentsController::class, 'getAppointmentDetail']);
    Route::get('/appointments/status/{status}',         [ApiAppointmentsController::class, 'getAppointmentsByStatus']);
    Route::post('/appointments/{id}/complete',          [ApiAppointmentsController::class, 'markAsCompleted']);
    Route::post('/appointments/{id}/cancel',            [ApiAppointmentsController::class, 'cancelAppointment']);
});


Route::post('/send-otp', [ApiUserOTPController::class, 'sendOTP']);
Route::post('/verify-otp', [ApiUserOTPController::class, 'verifyOTP']);
Route::post('/update-password-during-otp', [ApiUserOTPController::class, 'updatePasswordDuringOTP']);

Route::post('/patient-feedback', [ApiPatientFeedbackController::class, 'store']);




// Sidebar Routes=================================================>
Route::get('/api/blogs', [ApiBlogController::class, 'index']);



// Home Screen Routes==================================================>
Route::get('/api/all-pathology-contacts', [ApiAllPathologyController::class, 'allPathologyData']);
Route::get('/api/all-opd-contacts', [ApiAllOPDController::class, 'allOpdData']);
Route::get('/api/all-doctors-contacts', [ApiAllDoctorController::class, 'allDoctorData']);
Route::get('/api/all-coupons', [ApiCouponsController::class, 'index']);
