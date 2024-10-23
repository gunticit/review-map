<?php

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Partner\CartController;
use App\Http\Controllers\Partner\ProductController;
use App\Http\Controllers\Partner\MissionController;
use App\Http\Controllers\Partner\OrderController;
use App\Http\Controllers\Partner\OverviewController;
use App\Http\Controllers\WalletController;

Route::group([
        'prefix' => '/partner',
        'middleware' => ['partner.auth']
    ], function(){
    Route::get('/',  [OverviewController::class, 'index'])->name('partner.overview');
    Route::resource('/mission',  MissionController::class);
    Route::get('/mission-histories', [MissionController::class, 'histories'])->name('mission.histories');
    Route::get('/wallet-withdraw',  [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    Route::post('/wallet/transaction-histories',  [WalletController::class, 'storeTransactionHistory'])->name('withdraw.wallet.store');
    Route::get('/wallet/verify/create',  [WalletController::class, 'createVerify'])->name('wallet.verify.create');
    Route::post('/wallet/verify',  [WalletController::class, 'storeVerify'])->name('wallet.verify.store');
    Route::get('/store-product',  [ProductController::class, 'index'])->name('store.product');
    
    Route::get('/cart',  [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/update-quantity',  [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::delete('/cart/delete-item',  [CartController::class, 'deleteItem'])->name('cart.delete.item');
    Route::post('/cart/apply-voucher',  [CartController::class, 'applyVoucher'])->name('cart.apply.voucher');
    Route::post('/order', [OrderController::class, 'store']);

    Route::post('/create-mission-ajax', [MissionController::class, 'createMissionAjax'])->name('create.mission.ajax');
    Route::get('/mission/confirm/{id}', [MissionController::class, 'missionConfirm'])->name('mission.confirm');
    Route::get('/mission-success', [MissionController::class, 'success'])->name('mission.success');
    Route::post('/verify-recaptcha', [MissionController::class, 'verifyRecaptcha'])->name('verify.recaptcha');
});