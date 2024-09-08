<?php

namespace App\Http\Controllers\Auth;
use App\Exceptions\ProcessException;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AuthController extends BaseController
{
    protected $authService;

    function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function authenticate(AuthRequest $request){
        try{
            $user = $this->authService->login($request);
            if(!empty($user)){
                $domain = $this->switchDomain($user);
                return redirect()->intended($domain);
            }
            Session::flash('error', __('auth.failed'));
            return redirect()->back()->withInput();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', __('auth.failed'));
            return redirect()->back()->withInput();
        }
    }

    private function switchDomain($user)
    {
        $domain = null;
        switch (true) {
            case $user->hasRole(Role::ADMIN_ROLE):
                $domain = "http://". Role::ADMIN_ROLE . '.' . config('constants.main_domain') ."/home";
                break;
            case $user->hasRole(Role::CUSTOMER_ROLE):
                    $domain = "http://". Role::CUSTOMER_ROLE . '.' . config('constants.main_domain') ."/home";
                break;
            case $user->hasRole(Role::PARTNER_ROLE):
                    $domain = "http://". Role::PARTNER_ROLE . '.' . config('constants.main_domain') ."/home";
                    break;
            default:
                break;
        }
        return $domain;
    }

    public function registerUser(RegisterRequest $request){
        try{
            $data = $this->authService->registerUser($request);
            if($data){
                Session::flash('success', 'Bạn đã tạo user thành công');
                return redirect()->route('login');
            }
            Session::flash('error', 'Tạo user không thành công');
            return redirect()->back()->withInput();
        }catch(\Exception $e){
            throw new ProcessException($e);
        }
    }
}
