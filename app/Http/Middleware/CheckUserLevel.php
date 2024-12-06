<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $level
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $level)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');  // Redirect ke halaman login jika belum login
        }

        // Cek level pengguna
        if (Auth::user()->level !== $level) {
            // Jika level pengguna tidak sesuai, redirect ke halaman yang sesuai
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        // Lanjutkan request jika level sesuai
        return $next($request);
    }
}
