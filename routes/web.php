<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);

// Auth::routes(['login' => false,'register' => false,'logout' => false]);
Route::group([
    'namespace' => '\App\Http\Controllers\Auth'],  // Chỉ định namespace cho group
    function(){
        Route::get('/login', 'AuthController@login')->name('login');
        Route::get('/register', 'AuthController@register')->name('register');
        Route::get('/logout', 'AuthController@logout')->name('logout');
        Route::post('/authenticate', 'AuthController@authenticate')->name('auth.authenticate');
        Route::post('/registerUser', 'AuthController@registerUser')->name('auth.registerUser');
    }
);
Route::group(['middleware' => 'locale'], function() {
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');
});
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group([
    'prefix' => '/v1/admin',
    'as' => 'admin.',
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['auth']], function () {
        Route::get('/test', function(){
            return 'test';
        });
});

Route::group([
    'prefix' => '/v1/customer',
    'as' => 'customer.',
    'namespace' => 'App\Http\Controllers\Customer',
    'middleware' => ['auth', 'customer']], function () {
});

Route::group([
    'prefix' => '/v1/guest',
    'as' => 'guest.',
    'namespace' => 'App\Http\Controllers\Guest',
    'middleware' => ['auth', 'customer']], function () {
});

Route::group(['middleware' => 'locale'], function() {
    Route::get('change-language/{language}', 'App\Http\Controllers\DashboardController@changeLanguage')
        ->name('user.language');
});

Route::group(['middleware' => ['locale','auth']], function(){
    Route::get('/terms', [App\Http\Controllers\TermsController::class, 'index'])->name('terms');
    Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');
    Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history');
    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
    Route::get('/list-projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('project.list');
    Route::get('/create-project', [App\Http\Controllers\ProjectController::class, 'create'])->name('project.create');
    Route::post('/create-project', [App\Http\Controllers\ProjectController::class, 'store'])->name('project.store');
    Route::get('/edit-project/{id}', [App\Http\Controllers\ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/update-project/{id}', [App\Http\Controllers\ProjectController::class, 'update'])->name('project.update');
    Route::put('/update-status-project/{id}', [App\Http\Controllers\ProjectController::class, 'updateStatus'])->name('project.update.status');
    Route::get('/edit-profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
    Route::get('/notification/{id}', [App\Http\Controllers\NotificationController::class, 'show'])->name('notification.show');

    
    include 'web_customer.php';
    include 'web_admin.php';
    include 'web_partner.php';
});



Route::get('/get-long-url', [App\Http\Controllers\DashboardController::class, 'getLongUrl'])->name('get.long.url');
Route::get('/list-tags', [App\Http\Controllers\TagController::class, 'index'])->name('list.tags');