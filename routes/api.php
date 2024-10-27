<?php

use App\Http\Controllers\ApiGoogleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/google-place', [ApiGoogleController::class, 'getPlaceDetails']);

