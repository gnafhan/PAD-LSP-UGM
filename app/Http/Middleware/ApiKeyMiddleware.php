<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa API_KEY di header. Anda bisa menggunakan 'API_KEY' atau header lain seperti 'Authorization'
        $apiKey = $request->header('API_KEY');

        if ($apiKey !== env('API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

