<?php

use App\Http\Controllers\Api\ApiAllDoctorController;
use App\Http\Controllers\Api\ApiAllOPDController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiBlogController;
use App\Http\Controllers\Api\ApiAllPathologyController;
use App\Http\Controllers\Api\ApiCouponsController;
use App\Http\Controllers\Api\ApiUserLoginController;
use App\Http\Controllers\Api\ApiUserOTPController;
use App\Http\Controllers\Api\ApiUserProfileEditController;
use App\Http\Controllers\Api\ApiUserRegisterController;
use App\Http\Controllers\Api\ApiPatientFeedbackController;
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
