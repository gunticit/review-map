<?php

use App\Http\Controllers\ApiGoogleController;
use Illuminate\Support\Facades\Route;


Route::get('/google-place', [ApiGoogleController::class, 'getPlaceDetails']);

