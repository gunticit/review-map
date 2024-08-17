<?php
use Illuminate\Support\Facades\Route;

// use App\Modules\Admin\Controllers\Dashboard\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::group([
        'module' => 'Admin',
        'prefix' => 'admin',
    ], function () {
        // Route::get('/', [DashboardController::class, 'index']);
        Route::get('/test', function(){
            return 'test';
        });
    });
});