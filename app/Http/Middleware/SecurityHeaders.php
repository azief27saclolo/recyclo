<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Add Content Security Policy headers to block unwanted connections
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval'; " .
               "connect-src 'self'; " . // This blocks connections to external services like Sentry
               "img-src 'self' data:; " .
               "style-src 'self' 'unsafe-inline'; " .
               "font-src 'self'; " .
               "frame-src 'self'";
        
        $response->header('Content-Security-Policy', $csp);
        
        // Add other security headers
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        $response->header('X-XSS-Protection', '1; mode=block');
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        return $response;
    }
}
