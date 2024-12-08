<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Nếu người dùng chưa đăng nhập, redirect về trang login
            return redirect()->route('login');
        }

        $profile = User::where('id', Auth::user()->id)->with('accountPayment')->first();

        if (!$profile->email_verified_at) {
            $user_email = $profile->email;
            Auth::logout();
            return redirect()->route('register', ['email_verify' => $user_email])
                ->withErrors(['not_verify_user' => 'Vui lòng xác nhận tài khoản trước khi đăng nhập.']);
        }

        // Share profile to view
        view()->share('profile', [
            'id'         => $profile->id,
            'name'       => $profile->name,
            'username'   => $profile->username,
            'avatar'     => $profile->avatar,
            'email'      => $profile->email,
            'telephone'  => $profile->telephone,
            'language'   => $profile->language,
            'dark_mode'  => $profile->dark_mode,
            'country_code' => $profile->country_code,
            'email_verified_at' => $profile->email_verified_at
        ]);

        return $next($request);
    }
}
