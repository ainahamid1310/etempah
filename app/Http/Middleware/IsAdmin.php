<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check() && Auth::user()->is_admin == '1') {
            foreach ($roles as $role) {
                if ($request->user()->hasRole($role)) {
                    return $next($request);
                }
            }
        }

        return redirect('/forbidden');
    }
}
