<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login → biarkan auth middleware yang handle
        if (!Auth::check()) {
            abort(403);
        }

        // Jika login tapi bukan admin → tampilkan 403 page
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}
