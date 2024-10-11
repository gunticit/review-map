<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Repositories\AuthSocial\AuthSocialRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthSocialService {
    protected $authSocialRepositoryInterface;

    public function __construct(AuthSocialRepositoryInterface $authSocialRepositoryInterface)
    {
        $this->authSocialRepositoryInterface = $authSocialRepositoryInterface;
    }

    public function handleGoogleCallback($request){
        $code = $request->input('code');
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email', $googleUser->getEmail())->first();
        if($user){
            $user->update([
                'google_id' => $googleUser->getId(),
                'token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken
            ]);
        }else{
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(8)),
                'token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken
            ]);
        }
        Auth::login($user, true);
        return $user;
    }

}