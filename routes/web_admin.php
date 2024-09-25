<?php

use App\Http\Controllers\Admin\ApproveApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VoucherController;
use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => '/admin',
        'middleware' => ['locale','auth']
    ], function(){
        Route::group(['middleware' => ['locale','auth']], function(){
        Route::get('/overview-customer',  [DashboardController::class, 'customerOverview'])->name('overview.customer');
        Route::get('/overview-partner',  [DashboardController::class, 'partnerOverview'])->name('overview.partner');
        Route::get('/order',  [DashboardController::class, 'order'])->name('order');
        Route::get('/approve-application',  [ApproveApplicationController::class, 'index'])->name('approve_application');
        Route::resource('/statistics', StatisticController::class);
        Route::resource('/category', CategoryController::class);
        Route::resource('/product', ProductController::class);
        Route::resource('/order', OrderController::class);
        Route::resource('/voucher', VoucherController::class);
        Route::get('/categories-list', [CategoryController::class, 'categoriesList'])->name('categories.list');
        Route::post('/destroy-category-id/{id}', [CategoryController::class, 'destroyCategoryById'])->name('destroy.category.id');
    });
});