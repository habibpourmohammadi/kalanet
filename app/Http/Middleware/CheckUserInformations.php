<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserInformations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return to_route("home.auth.login.page")->with("swal-error", "لطفا وارد حساب کاربری خود شوید");
        } elseif (Auth::user()->name == null) {
            return to_route("home.profile.myProfile.index")->with("swal-error", "لطفا اطلاعات خود را تکمیل کنید");
        } else {
            return $next($request);
        }
    }
}
