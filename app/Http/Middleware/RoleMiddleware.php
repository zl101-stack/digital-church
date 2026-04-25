<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // ✅ CEK LOGIN (tetap)
        if (!auth()->check()) {
            abort(403);
        }

        // ✅ TAMBAHAN (FIX MASALAH user,admin)
        $roles = collect($roles)
            ->flatMap(function ($role) {
                return explode(',', $role);
            })
            ->toArray();

        // ✅ LOGIKA LAMA (tidak diubah)
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}