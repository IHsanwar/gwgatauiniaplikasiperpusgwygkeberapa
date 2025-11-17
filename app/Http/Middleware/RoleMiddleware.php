<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(403, 'Anda belum login.');
        }

        $userRole = auth()->user()->role;

        // Jika user role ada dalam list role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak untuk role: ' . $userRole);
    }

}
