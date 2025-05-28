<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        return route('login');
    }
    
    return response()->json(['message' => 'Unauthenticated.'], 401);
}
}
