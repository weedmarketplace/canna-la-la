<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AgeCheckMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Session::get('age_verified')) {
            return redirect()->route('age.confirmation');
        }

        return $next($request);
    }
}