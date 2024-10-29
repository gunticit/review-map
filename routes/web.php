<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocicalController;
use App\Http\Controllers\Partner\PartnerSupportController;

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);

// Auth::routes(['login' => false,'register' => false,'logout' => false]);
Route::group([
    'namespace' => '\App\Http\Controllers\Auth'
],  // Chỉ định namespace cho group
    function(){
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
        Route::post('/registerUser', [AuthController::class, 'registerUser'])->name('auth.registerUser');
        Route::post('/password/email', [AuthController::class, 'sendOtp'])->name('password.email');
        Route::post('/password/otp', [AuthController::class, 'verifyOtp'])->name('password.otp');
        Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');
        Route::get('auth/google', [SocicalController::class, 'redirectToGoogle'])->name('auth.google');
        Route::get('auth/google/callback', [SocicalController::class, 'handleGoogleCallback']);    
        Route::get('/support', [PartnerSupportController::class, 'index'])->name('support');
        Route::post('/support-store', [PartnerSupportController::class, 'store'])->name('support.store');
        Route::get('/support-edit/{id}', [PartnerSupportController::class, 'edit'])->name('support.edit');
        Route::put('/support-update/{id}', [PartnerSupportController::class, 'update'])->name('support.update');
        Route::delete('/support-delete/{id}', [PartnerSupportController::class, 'delete'])->name('support.delete');
        Route::delete('/support-delete-by-ids/{ids}', [PartnerSupportController::class, 'deleteByIds'])->name('support.delete.by.ids');
        Route::get('/support-create', [PartnerSupportController::class, 'create'])->name('support.create');
        Route::get('/support-detail', [PartnerSupportController::class, 'detail'])->name('support.detail');
    }
);


Route::group(['middleware' => 'locale'], function() {
    Route::get('change-language/{language}', 'App\Http\Controllers\DashboardController@changeLanguage')
        ->name('user.language');
});

Route::group(['middleware' => ['locale','auth']], function(){
    Route::get('/terms', [App\Http\Controllers\TermsController::class, 'index'])->name('terms');
    Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history');
    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/setup', [App\Http\Controllers\WalletController::class, 'setupWalletAndDeposit'])->name('wallet.setup');
    Route::get('/edit-profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/edit-profile-partner', [App\Http\Controllers\ProfileController::class, 'editPartner'])->name('profile.partner.edit');
    Route::post('/update-profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update-profile-company', [App\Http\Controllers\ProfileController::class, 'updateProfileCompany'])->name('profile.update.company');
    Route::post('/update-profile-payment/{idPayment}', [App\Http\Controllers\ProfileController::class, 'updateAccountPayment'])->name('profile.partner.update.payment');
    Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
    Route::get('/notification/{id}', [App\Http\Controllers\NotificationController::class, 'show'])->name('notification.show');
    Route::delete('/notification-delete/{id}', [App\Http\Controllers\NotificationController::class, 'ajaxDeleteNotification'])->name('notification.delete');
    Route::post('/change-password', [App\Http\Controllers\Auth\AuthController::class, 'changePassword'])->name('profile.change.password');
    Route::post('/update-location', [App\Http\Controllers\Auth\AuthController::class, 'updateCurrentLocation'])->name('profile.update.location');
    Route::get('/notification-user', [App\Http\Controllers\NotificationController::class, 'ajaxNotification'])->name('notification.user');
    Route::put('/notification-user-read', [App\Http\Controllers\NotificationController::class, 'ajaxMakeRead'])->name('notification.user.read');
    
    include 'web_customer.php';
    include 'web_admin.php';
    include 'web_partner.php';
});

// payment 
Route::get('return/onepay', [App\Http\Controllers\Payment\OnepayController::class, 'onepay_return'])->name('onepay.onepay_return');
Route::get('return/onepay_ipn', [App\Http\Controllers\Payment\OnepayController::class, 'onepay_ipn'])->name('onepay.onepay_ipn');


Route::get('/get-long-url', [App\Http\Controllers\DashboardController::class, 'getLongUrl'])->name('get.long.url');
Route::get('/list-tags', [App\Http\Controllers\TagController::class, 'index'])->name('list.tags');