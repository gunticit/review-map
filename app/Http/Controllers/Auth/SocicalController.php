<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\AuthSocialService;
use Auth;
use Config;
use Laravel\Socialite\Facades\Socialite;
use Session;

class SocicalController extends Controller
{
    protected $authSocialService;

    public function __construct(AuthSocialService $authSocialService)
    {
        $this->authSocialService = $authSocialService;
    }

    public function redirectToGoogle()
    {
        $this->authSocialService->handleDomainRedirect();
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        Config::set('services.google.redirect', Session::get('google_redirect_uri'));
        $user = $this->authSocialService->handleGoogleCallback();
        if (!empty($user)) {
            $url = request()->secure() ? 'https://' : 'http://';
            if ($user->hasRole(Role::ADMIN_ROLE) && request()->getHost() !== env('ADMIN_DOMAIN')) {
                $url = $url . env('ADMIN_DOMAIN');
                return redirect()->route('login')->with('wrong_path', $url);
            }
            if ($user->hasRole(Role::PARTNER_ROLE) && request()->getHost() !== env('PARTNER_DOMAIN')) {
                $url = $url . env('PARTNER_DOMAIN');
                return redirect()->route('login')->with('wrong_path', $url);
            }
            if ($user->hasRole(Role::CUSTOMER_ROLE) && request()->getHost() !== env('CUSTOMER_DOMAIN')) {
                $url = $url . env('CUSTOMER_DOMAIN');
                return redirect()->route('login')->with('wrong_path', $url);
                ;
            }
        }
        Auth::login($user, true);
        return redirect()->route('login');
    }
}
