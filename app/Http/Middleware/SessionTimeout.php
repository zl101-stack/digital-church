<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        $timeout = 300; // 5 menit

        if (session('last_activity')) {
            if (time() - session('last_activity') > $timeout) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect('/login')
                    ->with('status', 'Session habis karena tidak aktif.');
            }
        }

        session(['last_activity' => time()]);

        return $next($request);
    }
}