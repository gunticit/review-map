<?php

use App\Http\Controllers\Admin\ApproveProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManagePartnerController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ManageCustomerController;
use App\Http\Controllers\Admin\NotificateController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\Admin\AdminFaqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\SupportController;
use App\Http\Controllers\Partner\MissionController;

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
        Route::resource('/admin-faq', AdminFaqController::class);
        Route::get('/product-check-code/{product_code}', [ProductController::class, 'productCheckCode'])->name('product.check.code');
        Route::resource('/order', OrderController::class);
        Route::resource('/voucher', AdminVoucherController::class);
        Route::get('/categories-list', [CategoryController::class, 'categoriesList'])->name('categories.list');
        Route::post('/destroy-category-id/{id}', [CategoryController::class, 'destroyCategoryById'])->name('destroy.category.id');
        Route::resource('/manage-customer', ManageCustomerController::class);
        Route::get('/manage-partner/list', [ManagePartnerController::class, 'list'])->name('admin.manage.partner.list');
        Route::get('/manage-partner/info/{id}', [ManagePartnerController::class, 'info'])->name('admin.manage.partner.info');
        Route::get('/manage-partner/wallet/{id}', [ManagePartnerController::class, 'wallet'])->name('admin.manage.partner.wallet');
        Route::get('/manage-partner/project/{id}', [ManagePartnerController::class, 'project'])->name('admin.manage.partner.project');
        Route::get('/manage-partner/edit/{id}', [ManagePartnerController::class, 'edit'])->name('admin.manage.partner.edit');
        Route::post('/admin-company-update', [ManageCustomerController::class, 'adminCompanyUpdate'])->name('admin.company.update');
        Route::post('/show-project-json/{id}', [ProjectController::class, 'showJson'])->name('show.project.json');
        Route::post('/project-wrong-image', [ProjectController::class, 'wrongImage'])->name('project.wrong.image');
        Route::post('/update-project-status/{id}', [ProjectController::class, 'updateStatus'])->name('update.project.status');
        Route::post('/mission-show-json/{id}', [MissionController::class, 'showJson'])->name('show.mission.json');
        Route::post('/result-google-map/{place_id}', [MissionController::class, 'resultGoogleMap'])->name('result.google.map');
        Route::post('/update-mission-status/{id}', [MissionController::class, 'updateStatus'])->name('update.mission.status');
        Route::post('/update-no-image/{id}', [MissionController::class, 'updateNoImage'])->name('update.no.image');
        Route::post('/update-no-review/{id}', [MissionController::class, 'updateNoReview'])->name('update.no.review');

        
        Route::get('/support', [SupportController::class, 'index'])->name('admin.support');
        Route::post('/support-store', [SupportController::class, 'store'])->name('admin.support.store');
        Route::get('/support-edit/{id}', [SupportController::class, 'edit'])->name('admin.support.edit');
        Route::put('/support-update/{id}', [SupportController::class, 'update'])->name('admin.support.update');
        Route::delete('/support-delete/{id}', [SupportController::class, 'delete'])->name('admin.support.delete');
        Route::delete('/support-delete-by-ids/{ids}', [SupportController::class, 'deleteByIds'])->name('admin.support.delete.by.ids');
        Route::get('/support-create', [SupportController::class, 'create'])->name('admin.support.create');
        Route::get('/setting', [SettingController::class, 'index'])->name('setting');
        Route::post('/update-setting', [SettingController::class, 'update'])->name('update.setting');

        //QL Thông báo đối tác
        Route::get('/list-notificate-partner', [NotificateController::class, 'partner_list'])->name('list.notificate.partner');
        Route::get('/detail-notificate-partner/{id}', [NotificateController::class, 'partner_detail'])->name('detail.notificate.partner');
        Route::get('/create-notificate-partner', [NotificateController::class, 'partner_create'])->name('create.notificate.partner');
        Route::post('/store-notificate-partner', [NotificateController::class, 'partner_store'])->name('store.notificate.partner');
        Route::post('/edit-notificate-partner/{id}', [NotificateController::class, 'partner_edit'])->name('edit.notificate.partner');
        Route::delete('/delete-notificate-partner/{id}', [NotificateController::class, 'partner_delete'])->name('delete.notificate.partner');

        Route::get('/list-notificate-customer', [NotificateController::class, 'customer_list'])->name('list.notificate.customer');
        Route::get('/detail-notificate-customer/{id}', [NotificateController::class, 'customer_detail'])->name('detail.notificate.customer');
        Route::get('/create-notificate-customer', [NotificateController::class, 'customer_create'])->name('create.notificate.customer');
        Route::post('/store-notificate-customer', [NotificateController::class, 'customer_store'])->name('store.notificate.customer');
        Route::put('/list-notificate-customer/{id}', [NotificateController::class, 'customer_edit'])->name('edit.notificate.customer');
        Route::delete('/delete-notificate-customer/{id}', [NotificateController::class, 'customer_delete'])->name('delete.notificate.customer');
    });
});