<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use App\Services\UserService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService, $userService;
    public function __construct(
        SettingService $settingService,
        UserService $userService
    ){
        $this->settingService = $settingService;
        $this->userService = $userService;
    }
    public function index(Request $request){
        $data = $setting_partner = array();
        $settings = $this->settingService->list($request);
        foreach($settings as $setting){
            $data[$setting->code_setting][] = array(
                'code_setting' => $setting->code_setting,
                'key_setting' => $setting->key_setting,
                'value_setting' => $setting->value_setting,
            );
            if($setting->code_setting == 'setting_partner' && $setting->key_setting == 'partners'){
                $partners = $this->userService->list($request);
                if(!empty($partners)){
                    foreach($partners as $partner){
                        $setting_partner[] = array(
                            'id' => $partner->id,
                            'name' => $partner->name,
                            'telephone' => $partner->telephone,
                        );
                    }
                }
            }
        }
        return view('pages.admin.settings.index', array(
            'settings' => $data,
            'setting_partner' => $setting_partner
        ));
    }

    public function update(Request $request){
        $data = $this->systemSettingData($request);
        $data_update = array();
        if(!empty($data)){
            dd($data);
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
