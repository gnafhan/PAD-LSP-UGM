<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * @OA\SecurityScheme(
 *      securityScheme="ApiKeyAuth",
 *      in="header",
 *      name="API-KEY",
 *      type="apiKey"
 * )
 */
class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Support ALL possible variations that the team might use
        $apiKey = $request->header('API-KEY')          // Standard format with dash
               ?? $request->header('API_KEY')          // Original format with underscore  
               ?? $request->header('Api-Key')          // Capitalized format
               ?? $request->header('api-key')          // Lowercase format
               ?? $request->header('X-API-KEY')        // X-prefixed format
               ?? $request->header('X-Api-Key')        // X-prefixed capitalized
               ?? $request->header('x-api-key')        // X-prefixed lowercase
               ?? $request->server('HTTP_API_KEY')     // Server variable format
               ?? $request->server('HTTP_X_API_KEY')   // Server X-prefixed format
               ?? $request->header('ApiKey')           // No dash/underscore format
               ?? $request->header('APIKEY');          // All caps no separator

        if ($apiKey !== env('API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

