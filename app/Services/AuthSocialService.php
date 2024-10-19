<?php

namespace App\Services;

use App\Models\Role;
use Config;
use Exception;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Session;
use App\Helpers\Helper;

class AuthSocialService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function handleDomainRedirect()
    {
        $domain = request()->getHost();
        switch ($domain) {
            case env('CUSTOMER_DOMAIN'):
                $googleRedirectUri = env('CUSTOMER_REDIRECT_URI');
                break;
            case env('PARTNER_DOMAIN'):
                $googleRedirectUri = env('PARTNER_REDIRECT_URI');
                break;
            case env('ADMIN_DOMAIN'):
                $googleRedirectUri = env('ADMIN_REDIRECT_URI');
                break;
            default:
                return redirect()->route('login');
        }
        Config::set('services.google.redirect', $googleRedirectUri);
        Session::put('google_redirect_uri', $googleRedirectUri);
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if (empty($finduser)) { // Nếu lần đầu tiên đăng nhập, tạo người dùng mới
                $data = [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                    'password' => Hash::make(Str::random(8)),
                    'email_verified_at' => now(),
                ];
                $finduser = $this->userRepository->create($data); // Đổi tên $user thành $finduser
                $this->setRole($finduser);
            }
            if(!$finduser->avatar){
                $avatarUrl = Helper::saveAvatarGoogle($user->getAvatar(), $finduser);
            }
          return $finduser;

        } catch (Exception $e) {
            dd($e->getMessage());
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
}