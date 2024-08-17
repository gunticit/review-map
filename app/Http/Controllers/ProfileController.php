<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create(){
        return view('auth.profile.create');
    }
    public function edit(){
        return view('auth.profile.edit');
    }
}
