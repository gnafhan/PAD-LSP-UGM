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
        // Log session information
        \Log::info('Role Middleware Check', [
            'authenticated' => Auth::check(),
            'session_id' => $request->session()->getId(),
            'cookies' => $request->cookies->all()
        ]);
        
        if (!Auth::check()) {
            // Store intended URL before redirecting 
            redirect()->setIntendedUrl($request->url());
            
            // Log the status for debugging
            \Log::info('Auth check failed in middleware');
            return redirect('/login');
        }
    
        $user = Auth::user();
        
        // Log the user for debugging
        \Log::info('User in middleware', ['user' => $user, 'level' => $user->level]);
        
        if (!in_array($user->level, $roles)) {
            return abort(403, 'Unauthorized');
        }
    
        return $next($request);
    }
}