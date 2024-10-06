<?php

use App\Http\Controllers\Partner\ProductController;
use App\Http\Controllers\Partner\MissionController;
use App\Http\Controllers\Partner\OverviewController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => '/partner',
        'middleware' => ['partner.auth']
    ], function(){
    Route::get('/',  [OverviewController::class, 'index'])->name('partner.overview');
    Route::resource('/mission',  MissionController::class);
    Route::get('/wallet-withdraw',  [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    Route::get('/store-product',  [ProductController::class, 'index'])->name('store.product');
    Route::post('/create-mission-ajax', [MissionController::class, 'createMissionAjax'])->name('create.mission.ajax');
    Route::get('/mission/confirm/{id}', [MissionController::class, 'missionConfirm'])->name('mission.confirm');
    Route::get('/mission-success', [MissionController::class, 'success'])->name('mission.success');
});