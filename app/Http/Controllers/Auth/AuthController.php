<?php

namespace App\Http\Controllers\Auth;
use App\Exceptions\ProcessException;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RegisterRequest;
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
        if(Auth::check()){
            if(Auth::user()->getRoleNames()->first() == 'customer'){
                return redirect()->route('customer.overview');
            }
            if(Auth::user()->getRoleNames()->first() == 'partner'){
                return redirect()->route('partner.overview');
            }
            return redirect()->route('overview.customer');
        }
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
                if(Auth::user()->getRoleNames()->first() == 'customer'){
                    return redirect()->route('customer.overview');
                }
                if(Auth::user()->getRoleNames()->first() == 'partner'){
                    return redirect()->route('partner.overview');
                }
                return redirect()->route('overview.customer');
            }
            Session::flash('error', __('auth.failed'));
            return redirect()->back()->withInput();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', __('auth.failed'));
            return redirect()->back()->withInput();
        }
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

    public function changePassword(ChangePasswordRequest $request){
        try{
            $this->authService->changePassword($request);
            return response()->json([
                'status' => true,
                'message' => __('Đổi mật khẩu thành công')
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => __('Đổi mật khẩu không thành công')
            ]);
            throw new ProcessException($e);
        }
    }
}
