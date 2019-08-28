<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

class Authenticate
{

    public function handle($request, Closure $next)
    {
        if (! Sentinel::check() || (Sentinel::getUser()->role!='1' && Sentinel::getUser()->role!='2')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
