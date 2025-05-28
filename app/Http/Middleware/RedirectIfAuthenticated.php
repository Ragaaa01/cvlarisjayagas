<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
   public function handle($request, Closure $next, ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            
            // Jika request API, return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Already authenticated'
                ], 400);
            }
            
            // Redirect berdasarkan role
            return $user->role === 'administrator'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.home');
        }
    }

    return $next($request);
}
}
