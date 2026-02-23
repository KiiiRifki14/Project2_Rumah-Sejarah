<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_id') || session('admin_role') !== 'admin') {
            return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
