<?php

namespace App\Http\Controllers\Auth;
use App\Exceptions\ProcessException;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UpdateCurrentLocationRequest;
use App\Models\Role;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;



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

    public function authenticate(AuthRequest $request)
    {
        $userCheck = $this->authService->checkUserDomain($request->input('username'));
        if (!empty($userCheck)) {
            $url = request()->secure() ? 'https://' : 'http://';
            if ($userCheck->hasRole(Role::ADMIN_ROLE) && $request->getHost() !== env('ADMIN_DOMAIN')) {
                $url = $url . env('ADMIN_DOMAIN');
                return redirect()->back()->with('wrong_path', $url);
            }
            if ($userCheck->hasRole(Role::PARTNER_ROLE) && $request->getHost() !== env('PARTNER_DOMAIN')) {
                $url = $url . env('PARTNER_DOMAIN');
                return redirect()->back()->with('wrong_path', $url);
            }
            if ($userCheck->hasRole(Role::CUSTOMER_ROLE) && $request->getHost() !== env('CUSTOMER_DOMAIN')) {
                $url = $url . env('CUSTOMER_DOMAIN');
                return redirect()->back()->with('wrong_path', $url);
                ;
            }
        }
        try {
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
            if ($data) {
                return redirect()->back()->with([
                    'email' => $data->email,
                    'telephone' => $data->telephone,
                ]);
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

    public function sendOtp(EmailRequest $request)
    {
        try {
            $this->authService->sendOtp($request->email);
            return $this->sendResponse(['email' => $request->email], 'OTP sent successfully');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 422); // Using sendError
        }
    }

    public function verifyOtp(Request $request)
    {
        $otp_attempts = $request->input('otp_attempts', 0);
        $email = $request->input('email');

        // kiểm tra số lần đã nhập
        if ($otp_attempts >= 5) {
            $this->authService->clearOtp($email);
            return $this->sendError(null, 'Số lần nhập mã OTP đã vượt quá giới hạn.', 400);
        }

        $otpArray = $request->input('otp');

        $otp = implode('', $otpArray);

        // Verify the OTP
        if ($this->authService->verifyOtp($email, $otp)) {
            return $this->sendResponse(['email' => $email], 'Xác nhận OTP thành công');
        } else {
            return $this->sendError(null, 'Mã xác thực không trùng khớp. Số lần thử còn lại: ' . (4 - $otp_attempts), 422);
        }
    }

    public function updatePassword(PasswordResetRequest $request)
    {
        try {
            $this->authService->updatePassword($request->email, $request->password);
            return $this->sendResponse(null, 'Đổi mật khẩu thành công');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 422); // Using sendError
        }
    }

    public function updateCurrentLocation(UpdateCurrentLocationRequest $request)
    {
        try {
            $this->authService->updateCurrentLocation($request);
            return $this->sendResponse(null, 'Cập nhật vị trí thành công');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 422); // Using sendError
        }
    }

}
