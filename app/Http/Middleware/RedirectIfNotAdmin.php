<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        if(Auth::user() == NULL || Auth::user()->role_id != 1) {
            return redirect('/');
        }

        return $next($request);
    }
}