<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRMiddleware
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
        // Check if user is authenticated and has ID 4 (HR)
        if (!Auth::check() || Auth::id() != 4) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return $next($request);
    }
} 