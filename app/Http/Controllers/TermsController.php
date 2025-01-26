<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SettingService;

class TermsController extends Controller
{
    private $settingService;
    public function __construct(SettingService $settingService){
        $this->settingService = $settingService;
    }

    public function index($slug){
        switch($slug){
            case 'intro':
                $key_setting = 'setting_intro_content';
                $heading_title = 'Giới thiệu';
                break;
            case 'terms':
                $key_setting = 'setting_term_content';
                $heading_title = 'Điều khoản & Chính sách';
                break;
            case 'contact':
                $key_setting = 'setting_contact_content';
                $heading_title = 'Liên hệ';
                break;
            default:
                $key_setting = 'setting_term_content';
                $heading_title = 'Giới thiệu';
                break;
        }
        $content = $this->settingService->findSettingByKey($key_setting);
        $content_setting = isset($content->value_setting) ? html_entity_decode($content->value_setting) : '';
        return view('pages.terms',[
            'content' => $content_setting,
            'heading_title' => $heading_title
        ]);
    }
}
