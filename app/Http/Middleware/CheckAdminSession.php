<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
