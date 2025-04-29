<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next)
    {
        // If user is not verified, redirect to verification notice
        if (Auth::check() && !Auth::user()->email_verified) {
            return Redirect::route('verification.notice');
        }

        return $next($request);
    }
}
