<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\Order;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function customerOverview(Request $request){
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
        $data_customer_data = User::role('customer')->where('latitude', '!=', null)->where('longitude', '!=', null)->select('name','id','latitude','longitude')->get()->toArray();
        $data_customer_data = array_map(function($item){
            return array(
                'name' => $item['name'],
                'id' => $item['id'],
                'latitude' => (float)$item['latitude'] ?? 0,
                'longitude' => (float)$item['longitude'] ?? 0
            );
        },$data_customer_data);
        return view('pages.admin.dashboard.customer-overview', array(
            'overview' => $data,
            'years' => $years,
            'filters' => array(
                'year' => $request->year ?? ''
            ),
            'data_customer_data' => $data_customer_data,
            'current_lat' => $data_customer_data[0]['latitude'] ?? 0,
            'current_long' => $data_customer_data[0]['longitude'] ?? 0,
        ));
    }
    public function partnerOverview(Request $request){
        // Tổng số đối tác
        $total_partners = User::role('partner');
        if(!empty($request->year)){
            $total_partners = $total_partners->whereYear('created_at', $request->year);
        }
        $total_partners = $total_partners->count();
        // Xác thực tài khoản
        $total_verify = User::role('partner')->join('certification_accounts', 'users.id', '=', 'certification_accounts.user_id');
        if(!empty($request->year)){
            $total_verify = $total_verify->whereYear('users.created_at', $request->year);
        }
        $total_verify = $total_verify->count();
        // Tổng số đối tác đã nhận hoa hồng (là đã hoàn thành nhiệm vụ)
        $has_commission = Mission::whereNotIn('status', [5, 6]);
        if(!empty($request->year)){
            $has_commission = $has_commission->whereYear('created_at', $request->year);
        }
        $has_commission = $has_commission->distinct()
        ->count('user_id');
        // Tổng số đơn hàng
        $order_total = Order::where('status', '!=', 'cancelled');
        if(!empty($request->year)){
            $order_total = $order_total->whereYear('created_at', $request->year);
        }
        $order_total = $order_total->count();
        // Tổng số nhiệm vụ đã hoàn thành
        $mission_complete = Mission::where('status', 1);
        if(!empty($request->year)){
            $mission_complete = $mission_complete->whereYear('created_at', $request->year);
        }
        $mission_complete = $mission_complete->count();
        // Số nhiệm vụ đang thực hiện
        $mission_working = Mission::whereIn('status', array(2,3,4));
        if(!empty($request->year)){
            $mission_working = $mission_working->whereYear('created_at', $request->year);
        }
        $mission_working = $mission_working->count();
        $user_count = User::get()->countBy('level');
        $data_chart_level = array();
        $user_count_sum = $user_count->toArray() ? array_sum($user_count->toArray()) : 0;
        $data_user_count = array();
        for($i = 1; $i <= 5; $i++){
            $data_user_count[$i] = $user_count[$i] ?? 0;
        }
        $arr_colors = array(
            '#d3d3d3',
            '#b3b3ff',
            '#6497e5',
            '#b3d1ff',
            '#ffc107',
            '#ffecb3'
        );
        if(!empty($data_user_count)){
            foreach($data_user_count as $key => $value){
                $dt_val = $user_count_sum > 0 ? $value / $user_count_sum * 100 : 0;
                $data_chart_level[] = array(
                    'name' => 'Cấp '.$key,
                    'y' => number_format($dt_val, 2),
                    'color' => $arr_colors[$key]
                );
            }
        }
        $data_partner_data = User::role('partner')->where('latitude', '!=', null)->where('longitude', '!=', null)->select('name','id','latitude','longitude')->get()->toArray();
        $data_partner_data = array_map(function($item){
            return array(
                'name' => $item['name'],
                'id' => $item['id'],
                'latitude' => (float)$item['latitude'],
                'longitude' => (float)$item['longitude']
            );
        },$data_partner_data);
        $data =  array(
            'total_partner' => $total_partners,
            'total_verify' => $total_verify,
            'order_total' => $order_total,
            'mission_complete' => $mission_complete,
            'mission_working' => $mission_working,
            'has_commission' => $has_commission,
            'data_chart_level' => $data_chart_level,
            'data_partner_data' => $data_partner_data,
            'current_lat' => $data_partner_data[0]['latitude'] ?? 0,
            'current_long' => $data_partner_data[0]['longitude'] ?? 0,
            'total_partner_verified' => 0,
            'total_partner_commission' => 0, // Hoa hồng
            'total_order' => 0,
            'total_mission_success' => 0,
            'total_mission_working' => 0,
            'years' => array(
                date('Y') - 1,
                date('Y'),
                date('Y') + 1
            ),
            'filter_data' => array(
                'year' => $request->year ?? null
            )
        );
        return view('pages.admin.dashboard.partner-overview', $data);
    }
}