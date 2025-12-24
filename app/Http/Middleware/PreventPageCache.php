<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventPageCache
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only modify HTML GET responses to avoid interfering with APIs/files
        if ($request->isMethod('GET') && str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
}
