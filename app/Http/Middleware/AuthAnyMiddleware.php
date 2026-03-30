<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAnyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('web')->check() && !Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
