<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('admin')->check() || auth()->guard('admin')->user()->role !== 'admin') {
            return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
