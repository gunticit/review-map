<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportController;
// Customer
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::get('/support-create', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support-store', [SupportController::class, 'store'])->name('support.store');
    Route::get('/support-edit/{id}', [SupportController::class, 'edit'])->name('support.edit');
    Route::put('/support-update/{id}', [SupportController::class, 'update'])->name('support.update');
    Route::delete('/support-delete/{id}', [SupportController::class, 'delete'])->name('support.delete');
    Route::delete('/support-delete-by-ids/{ids}', [SupportController::class, 'deleteByIds'])->name('support.delete.by.ids');
    Route::get('/generate-comment', [ProjectController::class, 'generateComment'])->name('generate.comment');