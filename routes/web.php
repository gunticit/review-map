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
    Route::get('/edit-profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/update-profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update-profile-company', [App\Http\Controllers\ProfileController::class, 'updateProfileCompany'])->name('profile.update.company');
    Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
    Route::get('/notification/{id}', [App\Http\Controllers\NotificationController::class, 'show'])->name('notification.show');
    Route::post('/change-password', [App\Http\Controllers\Auth\AuthController::class, 'changePassword'])->name('profile.change.password');
    Route::post('/update-location', [App\Http\Controllers\Auth\AuthController::class, 'updateCurrentLocation'])->name('profile.update.location');
    Route::get('/notification-user', [App\Http\Controllers\NotificationController::class, 'ajaxNotification'])->name('notification.user');
    Route::put('/notification-user', [App\Http\Controllers\NotificationController::class, 'ajaxNotification'])->name('notification.user.read');
    
    include 'web_customer.php';
    include 'web_admin.php';
    include 'web_partner.php';
});



Route::get('/get-long-url', [App\Http\Controllers\DashboardController::class, 'getLongUrl'])->name('get.long.url');
Route::get('/list-tags', [App\Http\Controllers\TagController::class, 'index'])->name('list.tags');