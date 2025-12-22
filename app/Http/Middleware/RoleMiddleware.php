<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::info('Role Middleware Check', [
            'authenticated' => Auth::check(),
            'session_id' => $request->session()->getId(),
            'cookies' => $request->cookies->all()
        ]);
        
        if (!Auth::check()) {
            // Only store intended URL if it's not a file upload request to avoid serialization issues
            if (!$request->hasFile('file_upload')) {
                redirect()->setIntendedUrl($request->url());
            }
            
            // Log the status for debugging
            Log::info('Auth check failed in middleware');
            return redirect('/login');
        }
    
        $user = Auth::user();
        
        // Log the user for debugging
        Log::info('User in middleware', ['user' => $user, 'level' => $user->level]);
        
        if (!in_array($user->level, $roles)) {
            // Special case: if user is trying to access /user/* routes but their level is now 'asesi'
            // redirect them to asesi home instead of showing 403
            if (in_array('user', $roles) && $user->level === 'asesi') {
                return redirect()->route('home-asesi')->with('info', 'Pengajuan Anda telah disetujui. Selamat datang di dashboard asesi!');
            }
            
            return abort(403, 'Unauthorized');
        }
    
        return $next($request);
    }
}