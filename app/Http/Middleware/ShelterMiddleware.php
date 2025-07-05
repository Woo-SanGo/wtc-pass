<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShelterMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'shelter') {
            return $next($request);
        }

        // Optional: redirect or abort if not shelter
        return redirect()->route('apply.shelter')->with('error', 'Only shelters can access this page.');
    }
}
