<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['locale','auth']], function(){
});


include 'web_admin.php';