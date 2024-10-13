<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthSocialService;
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
        $this->authSocialService->handleGoogleCallback();
        return redirect()->route('login');
    }
}
