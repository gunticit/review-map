<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Resources\UserResource;
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
        $data = new UserResource($user);
        return $data;
    }

    public function registerUser($request){
        $data = $this->filterData($request);
        $user = $this->userRepository->create($data);
        return $user ?? [];
    }

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
                'login' => __('These credentials do not match our records.'),
            ]);
        }
        RateLimiter::clear($this->throttleKey($request));
        return redirect()->route('home');
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
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'role_id' => isset($data['role_id'])?$data['role_id']:1,
            'permission_id' => isset($data['permission_id'])?$data['permission_id']:1,
            'password' => Hash::make($data['password']),
        );
    }
}