<?php

use App\Http\Controllers\Admin\ApproveProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManagePartnerController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ManageCustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\VoucherController;
use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => '/admin',
        'middleware' => ['admin.auth']
    ], function(){
        Route::group(['middleware' => ['locale','auth']], function(){
        Route::get('/overview-customer',  [DashboardController::class, 'customerOverview'])->name('overview.customer');
        Route::get('/overview-partner',  [DashboardController::class, 'partnerOverview'])->name('overview.partner');
        Route::get('/order',  [DashboardController::class, 'order'])->name('order');
        Route::get('/approve-project',  [ApproveProjectController::class, 'index'])->name('approve.project');
        Route::resource('/statistics', StatisticController::class);
        Route::resource('/category', CategoryController::class);
        Route::resource('/product', ProductController::class);
        Route::resource('/order', OrderController::class);
        Route::resource('/voucher', VoucherController::class);
        Route::get('/categories-list', [CategoryController::class, 'categoriesList'])->name('categories.list');
        Route::post('/destroy-category-id/{id}', [CategoryController::class, 'destroyCategoryById'])->name('destroy.category.id');
        Route::resource('/manage-customer', ManageCustomerController::class);
        Route::get('/manage-partner/info', [ManagePartnerController::class, 'info'])->name('admin.manage.partner.info');
        Route::get('/manage-partner/wallet', [ManagePartnerController::class, 'wallet'])->name('admin.manage.partner.wallet');
        Route::get('/manage-partner/project', [ManagePartnerController::class, 'project'])->name('admin.manage.partner.project');
        Route::post('/admin-company-update', [ManageCustomerController::class, 'adminCompanyUpdate'])->name('admin.company.update');


        Route::post('/show-project-json/{id}', [ProjectController::class, 'showJson'])->name('show.project.json');
        Route::post('/project-wrong-image', [ProjectController::class, 'wrongImage'])->name('project.wrong.image');
        Route::post('/update-project-status/{id}', [ProjectController::class, 'updateStatus'])->name('update.project.status');

        
    });
});