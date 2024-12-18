<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
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
        $list_partners = array();
        foreach($settings as $setting){
            $data[$setting->key_setting] = $setting->value_setting;
            if($setting->key_setting == 'setting_partner'){
                $setting_partners = !empty($setting->value_setting) ? explode(';', $setting->value_setting) : [];
                User::whereIn('id', $setting_partners)->get()->each(function($user) use(&$list_partners){
                    $list_partners[$user->id] = $user->name;
                });
            }
        }
        return view('pages.admin.settings.index', array(
            'setting' => $data,
            'list_partners' => $list_partners
        ));
    }

    public function update(Request $request){
        $data = $this->systemSettingData($request);
        $data_update = array();
        foreach($data as $key => $value){
            foreach($value as $k => $v){
                $data_update[] = array(
                    'code_setting' => $key,
                    'key_setting' => $k,
                    'value_setting' => $v
                );
            }
        }
        Setting::where('code_setting', 'system')->delete();
        Setting::where('code_setting', 'service')->delete();
        Setting::where('code_setting', 'partner')->delete();
        Setting::where('code_setting', 'payment')->delete();
        Setting::insert($data_update);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    private function systemSettingData($request): array{
        $data = array(
            'system' => array(
                'approve_project' => $request->approve_project ?? null, // Duyệt dự án
                'rating_image' => $request->rating_image ?? null, // Đánh giá hình ảnh
                'time_guarantee' => $request->time_guarantee ? date('H:i', strtotime($request->time_guarantee)) : null, // Thời gian bảo hành
            ),
            'service' => array(
                'setting_percent_slow' => $request->setting_percent_slow ?? null,
                'setting_price_slow' => $request->setting_price_slow ?? null,
                'setting_percent_no_slow' => $request->setting_percent_no_slow ?? null,
                'setting_min_image' => $request->setting_min_image ?? null,
                'setting_max_image' => $request->setting_max_image ?? null,
            ),
            'partner' => array(
                'setting_price_image' => $request->setting_price_image ?? null,
                'setting_vertify_account' => $request->setting_vertify_account ?? null,
                'setting_partner' => $request->setting_partner ?? null,
            ),
            'payment' => array(
                'vertify_account' => $request->vertify_account ?? null
            )
        );
        return $data;
    }

    public function deletePartnerSetting(Request $request){
        $keyword = 'setting_partner';
        $settings = $this->settingService->findSettingByKey($keyword);
        $value = $settings->value_setting;
        $value = explode(';', $value);
        $value = array_diff($value, [$request->id]);
        $value = implode(';', $value);
        $settings->value_setting = $value;
        $settings->save();
        return response()->json(['success' => true]);
    }
}
