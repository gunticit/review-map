<?php

namespace App\Services;

use Exception;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService {
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Authenticates the user with the given credentials.
     *
     * @param array $credentials The user's login credentials.
     * @return mixed|null The authenticated user if successful, null otherwise.
     * @throws ValidationException
     */

    public function login($request)
    {      
        $this->authenticate($request);
        $user        = Auth::user();
        $data = !empty($user) ? new UserResource($user) : null;
        return $data;
    }

    public function registerUser($request){
        $data = $this->filterData($request);
        $user = $this->userRepository->create($data);
        $this->setRole($user, $request);
        $user = UserResource::make($user);
        return $user;
    }
    // private function checkRoleByDomain($request){
    //     $user = 
    // }
    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function authenticate($request)
    {
        $this->ensureIsNotRateLimited($request);
        $loginType = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $credentials = [
            $loginType => $request->input('username'),
            'password' => $request->input('password'),
        ];
        $credentials['active'] = 1;
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request));
            return redirect()->back()->withErrors([
                'login' => __('Thông tin đăng nhập không chính xác.'),
            ]);
        }
        RateLimiter::clear($this->throttleKey($request));
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function ensureIsNotRateLimited($request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));
        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    private function throttleKey($request): string
    {
        return Str::transliterate(Str::lower($request->input('username')).'|'.$request->ip());
    }

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'name' => $data['name'],
            'username' => convertUserName($data['name']),
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'password' => Hash::make($data['password']),
        );
    }

    private function setRole($user, $request){
        if($request->getHost() === env('ADMIN_DOMAIN')){
            $user->assignRole(Role::ADMIN_ROLE);
        }
        if($request->getHost() === env('PARTNER_DOMAIN')){
            $user->assignRole(Role::PARTNER_ROLE);
        }
        if($request->getHost() === env('CUSTOMER_DOMAIN')){
            $user->assignRole(Role::CUSTOMER_ROLE);
        }
    }

    public function changePassword($request){
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
        return true;
    }

    public function sendOtp($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new Exception("Email không tồn tại trong hệ thống");
        }
        if (!empty($user->otp_expires_at) && now()->lessThanOrEqualTo($user->otp_expires_at)) {
            throw new Exception("Hãy thử lại sau vài phút");
        }
        return $this->userRepository->generateOtp($user);
    }

    public function verifyOtp($email, $otp)
    {
        $user = User::where('email', $email)->first();

        if ($user && $user->otp === $otp && now()->lessThan($user->otp_expires_at)) {
            $this->userRepository->verifyOtp($user);
            return true;
        }
        return false;
    }

    public function updatePassword($email, $password)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $this->userRepository->resetPassword($user, $password);
        }
    }
    public function clearOtp($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $this->userRepository->clearOtp($user);
        }
    }
    public function checkUserDomain($username)
    {
        $loginType = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $userCheck = User::where($loginType, $username)->first();
        return $userCheck;

    }

    public function updateCurrentLocation($request)
    {
        $data = $request->validated();
        $email = Auth::user()->email;
        return User::where('email', $email)->update([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);
    }
}