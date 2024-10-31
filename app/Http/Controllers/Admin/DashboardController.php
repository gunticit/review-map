<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function customerOverview(){
        $total_customer = User::role('customer')->count();
        $total_project = Project::whereNull('deleted_by')->count();
        $total_project_status = Project::whereNull('deleted_by')->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();
        $total_project_complete = 0;
        $total_project_working = 0;
        $total_project_pause = 0;
        $total_project_working = 0;
        $total_project_guarantee = 0;
        foreach($total_project_status as $project_status){
            if($project_status->status == Project::COMPLETED_PROJECT){
                $total_project_complete = $project_status->count;
            }
            if($project_status->status == Project::WORKING_PROJECT){
                $total_project_working = $project_status->count;
            }
            if($project_status->status == Project::STOPPED_PROJECT){
                $total_project_pause = $project_status->count;
            }
            $total_project_guarantee = 0;
        }
        $years = array(
            date('Y') - 1,
            date('Y'),
            date('Y') + 1
        );
        $data =  array(
            'total_customer' => $total_customer,
            'total_project' => $total_project,
            'total_project_complete' => $total_project_complete,
            'total_project_working' => $total_project_working,
            'total_project_pause' => $total_project_pause,
            'total_project_guarantee' => $total_project_guarantee
        );
        return view('pages.admin.dashboard.customer-overview', array(
            'overview' => $data,
            'years' => $years,
            'filters' => array(
                'year' => $request->year ?? ''
            )
        ));
    }
    public function partnerOverview(){
        $total_partners = User::role('partner')->count();
        $data =  array(
            'total_partner' => $total_partners,
            'total_partner_verified' => 0,
            'total_partner_commission' => 0, // Hoa hồng
            'total_order' => 0,
            'total_mission_success' => 0,
            'total_mission_working' => 0,
        );
        return view('pages.admin.dashboard.partner-overview', $data);
    }
}
