<?php

use App\Http\Controllers\Admin\ApproveApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/admin',
    'middleware' => ['locale','auth']], function(){
    Route::get('/overview-customer',  [DashboardController::class, 'customerOverview'])->name('overview.customer');
    Route::get('/overview-partner',  [DashboardController::class, 'partnerOverview'])->name('overview.partner');
    Route::get('/order',  [DashboardController::class, 'order'])->name('order');
    Route::get('/approve-application',  [ApproveApplicationController::class, 'index'])->name('approve_application');
});