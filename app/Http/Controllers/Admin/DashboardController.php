<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function customerOverview(){
        $data =  array(
            'total_project' => 0,
            'total_project_complete' => 0,
            'total_project_working' => 0,
            'total_project_working' => 0,
            'total_project_pause' => 0,
            'total_project_guarantee' => 0
        );
        return view('pages.admin.dashboard.customer-overview', array(
            'overview' => $data
        ));
    }
    public function partnerOverview(){
        $data =  array(
            'total_partner' => 0,
            'total_partner_verified' => 0,
            'total_partner_commission' => 0, // Hoa hồng
            'total_order' => 0,
            'total_mission_success' => 0,
            'total_mission_working' => 0,
        );
        return view('pages.admin.dashboard.partner-overview', $data);
    }
}
