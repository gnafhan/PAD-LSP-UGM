<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * SchemeContextController
 * 
 * Handles scheme context selection for asesor sidebar.
 * Stores selected scheme in session for dynamic sidebar rendering.
 * 
 * Requirements: 6.1, 6.4
 */
class SchemeContextController extends Controller
{
    /**
     * Get the list of schemes assigned to the current asesor.
     * 
     * Requirements: 6.1
     *
     * @return JsonResponse
     */
    public function getAssignedSchemes(): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $asesor = Asesor::where('id_user', $user->id_user)->first();
        
        if (!$asesor) {
            return response()->json(['error' => 'Asesor not found'], 404);
        }

        $assignedSchemes = $asesor->getAssignedSkemas();
        
        return response()->json([
            'schemes' => $assignedSchemes->map(function ($skema) {
                return [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                    'nomor_skema' => $skema->nomor_skema ?? null,
                ];
            }),
            'selected_scheme' => session('selected_skema_id'),
        ]);
    }

    /**
     * Set the selected scheme context in session.
     * 
     * Requirements: 6.1, 6.4
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function setSchemeContext(Request $request): JsonResponse
    {
        $request->validate([
            'id_skema' => 'required|string',
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $asesor = Asesor::where('id_user', $user->id_user)->first();
        
        if (!$asesor) {
            return response()->json(['error' => 'Asesor not found'], 404);
        }

        $idSkema = $request->input('id_skema');

        // Verify asesor has access to this scheme
        if (!$asesor->canAccessSkema($idSkema)) {
            return response()->json(['error' => 'Access denied to this scheme'], 403);
        }

        // Store in session
        session(['selected_skema_id' => $idSkema]);

        // Get scheme details
        $skema = Skema::find($idSkema);

        return response()->json([
            'success' => true,
            'message' => 'Scheme context updated',
            'selected_scheme' => $skema ? [
                'id_skema' => $skema->id_skema,
                'nama_skema' => $skema->nama_skema,
            ] : null,
        ]);
    }

    /**
     * Clear the selected scheme context from session.
     * 
     * @return JsonResponse
     */
    public function clearSchemeContext(): JsonResponse
    {
        session()->forget('selected_skema_id');

        return response()->json([
            'success' => true,
            'message' => 'Scheme context cleared',
        ]);
    }

    /**
     * Get the current scheme context.
     * 
     * @return JsonResponse
     */
    public function getCurrentContext(): JsonResponse
    {
        $selectedSkemaId = session('selected_skema_id');
        
        if (!$selectedSkemaId) {
            return response()->json([
                'selected_scheme' => null,
            ]);
        }

        $skema = Skema::find($selectedSkemaId);

        return response()->json([
            'selected_scheme' => $skema ? [
                'id_skema' => $skema->id_skema,
                'nama_skema' => $skema->nama_skema,
                'nomor_skema' => $skema->nomor_skema ?? null,
            ] : null,
        ]);
    }
}
