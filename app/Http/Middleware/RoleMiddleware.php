<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil user yang sedang login
        $user = Auth::user();


        // Cek apakah user memiliki salah satu dari role yang diizinkan
        if (!in_array($user->level, $roles)) {
            return abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
