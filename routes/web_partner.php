<?php

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Partner\CartController;
use App\Http\Controllers\Partner\ProductController;
use App\Http\Controllers\Partner\MissionController;
use App\Http\Controllers\Partner\OverviewController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Partner\PartnerSupportController;
use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => '/partner',
        'middleware' => ['partner.auth']
    ], function(){
    Route::get('/',  [OverviewController::class, 'index'])->name('partner.overview');
    Route::resource('/mission',  MissionController::class);
    Route::get('/mission-histories', [MissionController::class, 'histories'])->name('mission.histories');
    Route::get('/wallet-withdraw',  [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    Route::post('/wallet/transaction-histories',  [WalletController::class, 'storeTransactionHistory'])->name('wallet.transaction-histories.store');
    Route::get('/wallet/verify/create',  [WalletController::class, 'createVerify'])->name('wallet.verify.create');
    Route::post('/wallet/verify',  [WalletController::class, 'storeVerify'])->name('wallet.verify.store');
    Route::get('/store-product',  [ProductController::class, 'index'])->name('store.product');
    
    Route::get('/cart',  [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/update-quantity',  [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::delete('/cart/delete-item',  [CartController::class, 'deleteItem'])->name('cart.delete.item');
    Route::post('/cart/apply-voucher',  [CartController::class, 'applyVoucher'])->name('cart.apply.voucher');

    Route::post('/create-mission-ajax', [MissionController::class, 'createMissionAjax'])->name('create.mission.ajax');
    Route::get('/mission/confirm/{id}', [MissionController::class, 'missionConfirm'])->name('mission.confirm');
    Route::get('/mission-success', [MissionController::class, 'success'])->name('mission.success');
    Route::post('/verify-recaptcha', [MissionController::class, 'verifyRecaptcha'])->name('verify.recaptcha');

    Route::get('/support', [PartnerSupportController::class, 'index'])->name('support');
    Route::post('/support-store', [PartnerSupportController::class, 'store'])->name('support.store');
    Route::get('/support-edit/{id}', [PartnerSupportController::class, 'edit'])->name('support.edit');
    Route::put('/support-update/{id}', [PartnerSupportController::class, 'update'])->name('support.update');
    Route::delete('/support-delete/{id}', [PartnerSupportController::class, 'delete'])->name('support.delete');
    Route::delete('/support-delete-by-ids/{ids}', [PartnerSupportController::class, 'deleteByIds'])->name('support.delete.by.ids');
    Route::get('/support-create', [PartnerSupportController::class, 'create'])->name('support.create');
});