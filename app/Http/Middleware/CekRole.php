<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware cek login & role dari session
class CekRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        // Belum login → redirect ke halaman login
        if (!$request->session()->has('iduser')) {
            return redirect('/login');
        }

        // Cek apakah role user ada di daftar role yang diizinkan
        $userRole = $request->session()->get('role');
        if (count($roles) > 0 && !in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
