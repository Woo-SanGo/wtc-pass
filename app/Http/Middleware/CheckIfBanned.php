<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfBanned
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->is_banned) {
            // Log out the user if banned
            Auth::logout();

            // Redirect or abort with a message
            return redirect('/login')->withErrors(['Your account has been banned. Please contact support.']);
        }

        return $next($request);
    }
}
