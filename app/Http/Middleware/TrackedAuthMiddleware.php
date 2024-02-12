<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TrackedAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('tracked-api')->check()) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
