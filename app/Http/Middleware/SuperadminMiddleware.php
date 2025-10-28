<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperadminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login → redirect ke halaman login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika sudah login tapi bukan superadmin → logout dan arahkan ke login
        if (auth()->user()->role !== 'superadmin') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika superadmin → lanjutkan request
        return $next($request);
    }
}
