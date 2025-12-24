<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateLastActivity
{
    /**
     * Handle an incoming request and update user's last_activity timestamp (throttled).
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $now = time();
                // Only update if older than 30 seconds to reduce DB writes
                if (empty($user->last_activity) || ($now - (int)$user->last_activity) > 30) {
                    $user->last_activity = $now;
                    // silent save, ignore failures
                    try { $user->save(); } catch (\Throwable $e) { /* ignore */ }
                }
            }
        } catch (\Throwable $e) {
            // ignore middleware errors
        }

        return $next($request);
    }
}
