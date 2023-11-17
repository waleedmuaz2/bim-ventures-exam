<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return $next($request);
        }
        if ($request->is('api/*')) {
                return jsonFormat('','route not accessible','403');
        }
        abort(403, 'Unauthorized.');
    }
}
