<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGatekeeper
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_id') || !in_array(session('admin_role'), ['gatekeeper', 'admin'])) {
            return redirect('/gatekeeper/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
