<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function customerOverview(){
        $data =  array(
            'totalCustomer' => 0
        );
        return view('admin.dashboard.customer-overview', $data);
    }
    public function partnerOverview(){
        return view('admin.dashboard.partner-overview');
    }
}
