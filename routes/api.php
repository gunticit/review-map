<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\ProjectController;

Route::group([
    'middleware' => ['locale']
], function(){
    Route::get('/api-generate-comment', [ProjectController::class, 'ajaxHandleComments'])->name('api.generate.comment');
});