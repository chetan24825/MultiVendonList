<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('login') || $request->routeIs('logout')) {
            return $next($request);
        }
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->status == '0') {
                Auth::logout();
                Session::invalidate();
                Session::regenerateToken();
                return redirect()->route('login')->with('error', 'Your Account is inactive By Admin.');
            }
        }
        return $next($request);
    }
}
