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

    public function register(Request $request)
    {
        $email_verify = $request->has('email_verify') ? $request->input('email_verify') : '';
        $email_session = session('email', '');
        $telephone_session = session('telephone', '');
        return view('auth.register', [
            'email_verify' => $email_verify,
            'email_session' => $email_session,
            'telephone_session' => $telephone_session
        ]);
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
            return $this->sendResponse(['email' => $request->email], 'Đã gửi Otp thành công!');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 200); // Using sendError
        }
    }

    public function verifyOtp(Request $request)
    {
        $otpAttempts = $request->input('otp_attempts', 0);
        $email = $request->input('email');
        $otpArray = $request->input('otp');
        
        if (empty($email) || empty($otpArray)) {
            return $this->sendError(null, 'Email và mã OTP là bắt buộc.', 422);
        }

        $otp = is_array($otpArray) ? implode('', $otpArray) : $otpArray;

        if ($otpAttempts >= 5) {
            $this->authService->clearOtp($email);
            return $this->sendError(null, 'Số lần nhập mã OTP đã vượt quá giới hạn.', 429);
        }

        if ($this->authService->verifyOtp($email, $otp)) {
            $user = $this->authService->getUserByEmail($email);

            if (!$user) {
                return $this->sendError(null, 'Người dùng không tồn tại.', 404);
            }

            $this->setRole($user);
            $token = Auth::login($user);

            return $this->sendResponse([
                'status' => true,
                'email' => $email,
                'token' => $token,
            ], 'Xác nhận OTP thành công và đã đăng nhập.', 200);
        } else {
            $remainingAttempts = max(0, 4 - $otpAttempts); 
            $this->authService->incrementOtpAttempts($email);
            return response()->json([
                'status' => false,
                'message' => 'Mã otp không đúng',
            ]);
        }
    }

    private function setRole($user)
    {
        if (request()->getHost() === env('ADMIN_DOMAIN')) {
            $user->assignRole(Role::ADMIN_ROLE);
        }
        if (request()->getHost() === env('PARTNER_DOMAIN')) {
            $user->assignRole(Role::PARTNER_ROLE);
        }
        if (request()->getHost() === env('CUSTOMER_DOMAIN')) {
            $user->assignRole(Role::CUSTOMER_ROLE);
        }
    }

    public function updatePassword(PasswordResetRequest $request)
    {
        try {
            $this->authService->updatePassword($request->email, $request->password);
            return $this->sendResponse(null, 'Đổi mật khẩu thành công');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 200); // Using sendError
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
