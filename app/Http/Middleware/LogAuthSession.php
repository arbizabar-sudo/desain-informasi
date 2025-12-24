<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LogAuthSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $sid = session()->getId();
            $auth = Auth::check() ? 'AUTH' : 'GUEST';
            $uid = Auth::id();
            Log::debug("AuthSession: path={$request->path()} status={$auth} uid={$uid} session_id={$sid}");
        } catch (\Throwable $e) {
            // ignore logging errors
            Log::debug('AuthSession: logging failed - ' . $e->getMessage());
        }

        return $next($request);
    }
}
