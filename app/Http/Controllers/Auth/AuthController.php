<?php

    namespace App\Http\Controllers\Auth;
    use Illuminate\Http\Request;
    use App\Exceptions\ProcessException;
    use App\Services\AuthService;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\BaseController;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Rules\Email;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';

        $credentials = [
            $loginType => $request->username,
            'password' => $request->password,
            'active' => 1, // Giả định rằng bạn có cột `active` để kiểm tra tài khoản đã kích hoạt
        ];

        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            return redirect()->route('login')->withErrors([
                'login' => __('Sai thông tin đăng nhập hoặc mật khẩu.'),
            ])->withInput();
        }

        return redirect()->route('home');
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