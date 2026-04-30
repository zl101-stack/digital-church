<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            abort(403);
        }

        $roles = collect($roles)
            ->flatMap(fn($role) => explode(',', $role))
            ->toArray();

        if (!in_array(auth()->user()->role, $roles)) {

            Log::warning('Akses ilegal role', [
                'user' => auth()->user()->email,
                'role' => auth()->user()->role,
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);

            abort(403);
        }

        return $next($request);
    }
}