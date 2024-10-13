<?php

use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Customer\CustomerCheckoutController;
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
    Route::post('/list-order-project', [ProjectController::class, 'listOrderProject'])->name('list.order.project');
    Route::get('/list-projects', [ProjectController::class, 'index'])->name('project.list');
    Route::get('/create-project', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/order-project', [ProjectController::class, 'orderProject'])->name('order.project');
    Route::post('/create-project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/edit-project/{id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/update-project/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::put('/update-status-project/{id}', [ProjectController::class, 'updateStatus'])->name('project.update.status');
    Route::delete('/delete-project/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
    Route::delete('/delete-project-by-ids', [ProjectController::class, 'destroyByIds'])->name('project.destroy.ids');
    Route::post('/generate-comment-sample', [ProjectController::class, 'generateCommentBySample'])->name('generate.comment.sample');
    Route::post('/update-new-comment/{id}', [ProjectController::class, 'updateNewComment'])->name('update.new.comment'); // id là comment id

    Route::put('/update-order-project/{id}', [ProjectController::class, 'updateOrderProject'])->name('update.order.project');
    Route::get('/page-order-project/{id}', [ProjectController::class, 'pageOrderProject'])->name('page.order.project');

    Route::post('/confirm-checkout', [CustomerCheckoutController::class, 'confirmCheckout'])->name('confirm.checkout');
    Route::get('/project-search', [ProjectController::class, 'search'])->name('project.search'); 
});