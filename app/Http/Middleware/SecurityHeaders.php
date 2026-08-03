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

        // Anti-clickjacking
        if (method_exists($response, 'header')) {
            $response->header('X-Frame-Options', 'SAMEORIGIN');
            $response->header('X-Content-Type-Options', 'nosniff');
            
            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
                   "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; " .
                   "img-src 'self' data: blob: https://ghchart.rshah.org https://ui-avatars.com; " .
                   "font-src 'self' data: https://cdnjs.cloudflare.com; " .
                   "media-src 'self' https://assets.mixkit.co; " .
                   "connect-src 'self' https://api.github.com; " .
                   "frame-src 'self'; " .
                   "frame-ancestors 'self'; " .
                   "form-action 'self'; " .
                   "object-src 'none'; " .
                   "base-uri 'self';";
            $response->header('Content-Security-Policy', $csp);
        }

        if (property_exists($response, 'headers') && $response->headers) {
            $response->headers->remove('X-Powered-By');
        }

        return $response;
    }
}
