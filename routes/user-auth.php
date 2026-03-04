<?php


// use App\Http\Controllers\DwPartnerController;
use App\Http\Controllers\Front\FrontAboutPageController;
use App\Http\Controllers\Front\FrontBlogsPageController;
use App\Http\Controllers\Front\FrontContactusPageController;
use App\Http\Controllers\Front\FrontHomePageController;
use App\Http\Controllers\Front\FrontPrivacyPolicyPageController;
use App\Http\Controllers\DwUserController;
use App\Http\Controllers\DwUserOTPController;
use App\Http\Controllers\User\ProfileEditController;
use App\Http\Controllers\User\UserAllDoctorHandleController;
use App\Http\Controllers\User\UserAllOPDHandleController;
use App\Http\Controllers\User\UserAllPathologyHandleController;
use App\Http\Controllers\User\UserSearchHandleController as UserUserSearchHandleController;
use Illuminate\Support\Facades\Route;


Route::get('/dw/user-auth', [DwUserController::class, 'viewUserLogForm'])->name('dw.user-auth');
Route::post('/dw/user-register', [DwUserController::class, 'userRegForm'])->name('dw.user-register');
Route::post('/dw/user-auth', [DwUserController::class, 'userLogin'])->name('dw.user-login');



// OTP Routes
Route::get('/user-otp',          [DwUserOTPController::class, 'userOtpView'])->name('dw.user-otp');
Route::post('/user-otp/send',    [DwUserOTPController::class, 'sendOTP'])->name('user.send.otp');
Route::post('/user-otp/verify',  [DwUserOTPController::class, 'verifyOTP'])->name('user.verify.otp');
Route::post('/user-otp/reset',   [DwUserOTPController::class, 'resetOtp'])->name('user.otp.reset');



Route::middleware(['auth:dwuser', 'verified'])->group(function () {




    // ===========================================================================================================
    // ========================================== User Restricted Routes Start ===================================
    // ===========================================================================================================


    Route::get('/dw/coupons', function () {
        return view('coupon');
    })->name('dw.coupon');



    Route::get('/dw', [FrontHomePageController::class, 'index'])->name('dw.index');
    Route::get('/dw/about', [FrontAboutPageController::class, 'index'])->name('dw.about');
    Route::get('/dw/blog', [FrontBlogsPageController::class, 'index'])->name('dw.blog');
    Route::get('/dw/blog/{slug}', [FrontBlogsPageController::class, 'blogdetails'])->name('dw.blog.details');
    Route::get('/dw/contact', [FrontContactusPageController::class, 'index'])->name('dw.contact');
    Route::post('/dw/contact', [FrontContactusPageController::class, 'store'])->name('restricted-contact.store');
    Route::get('/dw/privacy-policy', [FrontPrivacyPolicyPageController::class, 'index'])->name('dw.privacy-policy');
    Route::get('/dw/opd', [UserAllOPDHandleController::class, 'index'])->name('dw.opd');
    Route::get('/dw/doctor', [UserAllDoctorHandleController::class, 'index'])->name('dw.doctor');
    Route::get('/dw/pathology', [UserAllPathologyHandleController::class, 'index'])->name('dw.pathology');

    Route::get('/dw/opd/search-specialist', [FrontHomePageController::class, 'opdContactFetchBySearchDoctorSpaciality'])
        ->name('opd.search.doctor.specialist1');


    // OPD Filter Search---------------------------------------------------------------------------------------------------------------->
    Route::get('dw/opd/search', [UserAllOPDHandleController::class, 'opdFilterSearch'])->name('opd.filter.search');

    // single opd ------------------------------------------------->
    Route::get('/dw/opd/{slug}', [UserAllOPDHandleController::class, 'singleOPDView'])
        ->name('dw.opd.single')
        ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*');

    Route::post('/dw/opd/inquiry', [UserAllOPDHandleController::class, 'patientInquiry'])->name('dw.opd.inquiry.store');
    Route::post('/dw/opd/rating', [UserAllOPDHandleController::class, 'saveRating'])->name('dw.opd.rating.save');



    // Path Filter Search---------------------------------------------------------------------------------------------------------------->
    Route::get('dw/pathology/search', [UserAllPathologyHandleController::class, 'pathFilterSearch'])->name('path.filter.search');

    // single pathology ------------------------------------------------->
    Route::get('/dw/pathology/{slug}', [UserAllPathologyHandleController::class, 'singlePathView'])
        ->name('dw.pathology.single')
        ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*');

    Route::post('/dw/pathology/inquiry', [UserAllPathologyHandleController::class, 'patientInquiry'])->name('dw.pathology.inquiry.store');
    Route::post('/dw/pathology/rating', [UserAllPathologyHandleController::class, 'saveRating'])->name('dw.pathology.rating.save');



    // Doc Filter Search---------------------------------------------------------------------------------------------------------------->
    Route::get('dw/doctor/search', [UserAllDoctorHandleController::class, 'docFilterSearch'])->name('doc.filter.search');

    // single doctor ------------------------------------------------->
    Route::get('/dw/doctor/{slug}', [UserAllDoctorHandleController::class, 'singleDocView'])
        ->name('dw.doctor.single')
        ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*');

    Route::post('/dw/doctor/inquiry', [UserAllDoctorHandleController::class, 'patientInquiry'])->name('dw.doctor.inquiry.store');
    Route::post('/dw/doctor/rating', [UserAllDoctorHandleController::class, 'saveRating'])->name('dw.doctor.rating.save');


    // Search result route
    Route::get('/dw/search-result', [UserUserSearchHandleController::class, 'index'])->name('dw.search.result');






    // ===========================================================================================================
    // ========================================== User Restricted Routes End =====================================
    // ===========================================================================================================








    // Route to show the profile edit page---------------------------------------------------------------------------------------------------------------->
    Route::get('/dw', [ProfileEditController::class, 'userProfileEditWithCurrentUserDetails']);

    // Route to update the profile details---------------------------------------------------------------------------------------------------------------->
    Route::post('/dw/user-profile-update', [ProfileEditController::class, 'updateProfile'])->name('user.profile.update');

    // Route to generate medical card---------------------------------------------------------------------------------------------------------------->
    Route::post('/dw/generate-medical-card', [DwUserController::class, 'generateMedicalCard'])->name('dw.generate.medical-card');




    Route::post('/user-logout', [DwUserController::class, 'userlogout'])->name('user.logout');






    // Profile & Medical Card
    Route::get('/dw/profile', [ProfileEditController::class, 'userProfile'])->name('dw.profile');
    Route::put('/dw/password/update', [ProfileEditController::class, 'updatePassword'])->name('dw.password.update');
    Route::get('/dw/medical-history', [ProfileEditController::class, 'medicalHistory'])->name('dw.medical-history');
    Route::post('/dw/medical-history/add', [ProfileEditController::class, 'addMedicalHistory'])->name('dw.medical-history.add');
    Route::delete('/dw/medical-history/{id}', [ProfileEditController::class, 'destroy'])->name('dw.medical-history.destroy');
    Route::put('/dw/medical-history/{id}/update', [ProfileEditController::class, 'editMecicalHistory'])->name('dw.medical-history.update');
    Route::get('/dw/medical-history/{id}/files', [ProfileEditController::class, 'viewReportImagesOrPdf'])->name('dw.medical-history.view');
    Route::post('/dw/vitals/add',[ProfileEditController::class, 'addVitals'])->name('dw.vitals.add');
    Route::put('/dw/vitals/{id}/update',[ProfileEditController::class, 'editVitals'])->name('dw.vitals.update');

    Route::get('/dw/notifications', [ProfileEditController::class, 'notification'])->name('dw.notification');
    Route::patch('/dw/notification/{id}/accept',        [ProfileEditController::class, 'acceptRequest'])->name('dw.notification.accept');
    Route::patch('/dw/notification/{id}/reject',        [ProfileEditController::class, 'rejectRequest'])->name('dw.notification.reject');
    Route::patch('/dw/notification/{id}/permission-off',[ProfileEditController::class, 'permissionOffRequest'])->name('dw.notification.permission.off');
    Route::patch('/dw/notification/{id}/permission-on',[ProfileEditController::class, 'permissionOnRequest'])->name('dw.notification.permission.on');

    // Status Change of appointment
    Route::post('/dw/profile/appointment-complete/{id}', [ProfileEditController::class, 'updatePatientEnquiryStatusIntoComplete'])->name('dw.appointment.complete');
    Route::post('/dw/profile/appointment-cancel/{id}', [ProfileEditController::class, 'cancelPatientEnquiry'])->name('dw.appointment.cancel');
});
