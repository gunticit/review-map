<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        return view('pages.admin.settings.index');
    }

    public function update(Request $request){
        $data = $this->systemSettingData($request);
        $data_update = array();
        if(!empty($data)){
            foreach($data as $key => $dt){
                if(!empty($dt)){
                    $data_update[] = array(
                        'code_setting' => 'SETTING_SYSTEM',
                        'key_setting' => $key,
                        'value_setting' => $dt
                    );
                }
            }
        }
        Setting::insert($data_update);
    }

    private function systemSettingData($request): array{
        $data = array(
            'approve_project' => $request->approve_project ?? null, // Duyệt dự án
            'rating_image' => $request->rating_image ?? null, // Đánh giá hình ảnh
            'time_guarantee' => $request->time_guarantee ? strtotime($request->time_guarantee) : null, // Thời gian bảo hành
        );
        return $data;
    }
}
