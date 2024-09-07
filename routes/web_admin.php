<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['locale','auth']], function(){
    Route::get('/overview-customer',  [DashboardController::class, 'customerOverview'])->name('overview.customer');
});