<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AllowUnverifiedPostEdits
{
    /**
     * Handle an incoming request, allowing unverified users to edit posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // If the user is authenticated, allow them to proceed regardless of verification status
        if ($request->user()) {
            return $next($request);
        }

        // If not authenticated, redirect to login
        return redirect()->route('login');
    }
}
