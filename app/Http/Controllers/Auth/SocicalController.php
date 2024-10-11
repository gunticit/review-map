<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthSocialService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocicalController extends Controller
{
    protected $authSocialService;

    public function __construct(AuthSocialService $authSocialService){
        $this->authSocialService = $authSocialService;
    }

    public function redirectToGoogle(){
        $url = Socialite::driver('google')->redirect()->getTargetUrl();
        return response()->json(['url' => $url], 200);
    }

    public function handleGoogleCallback(Request $request){
        try{
            $this->authSocialService->handleGoogleCallback($request);
        }catch(\Exception $e){
            return response()->json(['message' => 'Unthorized'], 500);
        }
    }
}
