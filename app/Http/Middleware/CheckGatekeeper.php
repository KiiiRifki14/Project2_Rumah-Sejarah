<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGatekeeper
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('admin')->check() || !in_array(auth()->guard('admin')->user()->role, ['gatekeeper', 'admin'])) {
            return redirect('/gatekeeper/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
