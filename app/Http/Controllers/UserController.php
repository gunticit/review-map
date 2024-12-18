<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getPartnerSearch(Request $request) {
        $users = User::where('role', Role::PARTNER_ROLE)->get();
    }
}
