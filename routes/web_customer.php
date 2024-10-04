<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\ProjectController;
use App\Http\Controllers\Customer\SupportController;

// Customer
Route::group([
    'prefix' => '/customer',
    'middleware' => ['customer.auth']
], function(){
    Route::get('/overview', [App\Http\Controllers\DashboardController::class, 'index'])->name('customer.overview');
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support-store', [SupportController::class, 'store'])->name('support.store');
    Route::get('/support-edit/{id}', [SupportController::class, 'edit'])->name('support.edit');
    Route::put('/support-update/{id}', [SupportController::class, 'update'])->name('support.update');
    Route::delete('/support-delete/{id}', [SupportController::class, 'delete'])->name('support.delete');
    Route::delete('/support-delete-by-ids/{ids}', [SupportController::class, 'deleteByIds'])->name('support.delete.by.ids');
    Route::get('/support-create', [SupportController::class, 'create'])->name('support.create');
    
    Route::get('/generate-comment', [ProjectController::class, 'generateComment'])->name('generate.comment');
    Route::get('/list-projects', [ProjectController::class, 'index'])->name('project.list');
    Route::get('/create-project', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/create-project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/edit-project/{id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/update-project/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::put('/update-status-project/{id}', [ProjectController::class, 'updateStatus'])->name('project.update.status');
});