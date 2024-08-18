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

        public function authenticate(AuthRequest $request){
            try{
                $check_login = $this->authService->login($request);
                if($check_login){
                    return redirect()->route('home');
                }
                return redirect()->route('login');
            }catch(\Exception $e){
                throw new ProcessException($e);
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
    }