<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // if (!$request->expectsJson()) {
        //     return route('login');
        // }

        // return response()->json(['message' => 'Unauthenticated.'], 401);

        if (!$request->expectsJson()) {
            Log::warning('Request tidak mengharapkan JSON. Mengembalikan HTML.');
            return route('login');
        }
    }
}
