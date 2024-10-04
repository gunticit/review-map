<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(){
        return view('pages.wallet.list');
    }
    public function withdraw() {
        return view('pages.wallet.withdraw');
    }
}
