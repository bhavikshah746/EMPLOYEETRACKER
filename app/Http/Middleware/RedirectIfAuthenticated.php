<?php

namespace App\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (Sentinel::check() && (Sentinel::getUser()->role == '1' || Sentinel::getUser()->role == '2')) {
            return redirect()->route('admin.users.index');
        }

        return $next($request);
    }
}
