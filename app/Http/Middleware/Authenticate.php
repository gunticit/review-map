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

        $profile = User::where('id',(Auth::user()->id))->with('accountPayment')->first();
        view()->share('profile', array(
            'id'         => $profile->id ?? null,
            'name'   => $profile->name ?? null,
            'username' => $profile->username ?? null,
            'avatar' => $profile->avatar ?? null,
            'email'     => $profile->email ?? null,
            'telephone'   => $profile->telephone ?? null,
            'language'   => $profile->language ?? null,
            'dark_mode'  => $profile->dark_mode ?? null,
            'country_code' => $profile->country_code ?? null
        ));
        return $next($request);
    }
}
