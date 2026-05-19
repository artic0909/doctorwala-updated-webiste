<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerApi\AuthApiController;

// Public routes for partner API
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/send-otp', [AuthApiController::class, 'sendOTP']);
Route::post('/verify-otp', [AuthApiController::class, 'verifyOTP']);

// Protected routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/get-coupon-details', [AuthApiController::class, 'getCouponDetails']);
    Route::post('/add-partner-coupon', [AuthApiController::class, 'partnerCouponCodeAdd']);
});