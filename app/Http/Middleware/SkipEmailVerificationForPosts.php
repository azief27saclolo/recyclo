<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SkipEmailVerificationForPosts
{
    /**
     * Handle an incoming request, bypassing email verification for post editing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow the request to proceed without email verification
        return $next($request);
    }
}
