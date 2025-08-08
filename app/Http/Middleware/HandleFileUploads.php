<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleFileUploads
{
    /**
     * Handle an incoming request to prevent file upload serialization issues.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If this is a file upload request, disable any session flashing of input
        if ($request->hasFile('file_upload') || ($request->isMethod('POST') && count($request->allFiles()) > 0)) {
            // Prevent Laravel from automatically flashing input to session on validation errors
            $request->session()->forget('_flash');
            $request->session()->forget('_old_input');
        }

        return $next($request);
    }
}
