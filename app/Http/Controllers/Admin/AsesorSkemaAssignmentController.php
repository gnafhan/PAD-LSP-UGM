<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\AsesorSkemaAssignment;
use App\Models\Skema;
use App\Services\AccessControlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * AsesorSkemaAssignmentController
 * 
 * Controller for managing asesor-scheme assignments.
 * Only admin users can manage assignments.
 * 
 * Requirements: 3.1, 3.2, 3.3
 */
class AsesorSkemaAssignmentController extends Controller
{
    /**
     * @var AccessControlService
     */
    protected AccessControlService $accessControlService;

    /**
     * Create a new controller instance.
     *
     * @param AccessControlService $accessControlService
     */
    public function __construct(AccessControlService $accessControlService)
    {
        $this->accessControlService = $accessControlService;
    }

    /**
     * Display the asesor-scheme assignments management page.
     * 
     * GET /admin/asesor-assignments
     * 
     * Shows a list of all asesors with their assigned schemes.
     * 
     * Requirements: 3.1
     *
     * @return View
     */
    public function showAssignmentsPage(): View
    {
        // Check admin authorization
        $user = Auth::user();
        if (!$user || $user->level !== 'admin') {
            abort(403, 'This operation requires admin privileges');
        }

        // Get all asesors with their assignments
        $asesors = Asesor::with(['skemaAssignments.skema'])
            ->orderBy('nama_asesor', 'asc')
            ->get();

        // Get all available schemes for the assignment modal
        $allSkemas = Skema::orderBy('nama_skema', 'asc')->get();

        return view('home.home-admin.asesor-skema-assignments', [
            'asesors' => $asesors,
            'allSkemas' => $allSkemas,
        ]);
    }

    /**
     * Get asesor's assigned schemes.
     * 
     * GET /admin/asesor/{id}/assignments
     * 
     * Returns the list of all schemes assigned to the specified asesor.
     * 
     * Requirements: 3.1
     *
     * @param string $id The asesor ID
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        try {
            // Check admin authorization
            $user = Auth::user();
            if (!$user || $user->level !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'This operation requires admin privileges',
                ], 403);
            }

            // Find the asesor
            $asesor = Asesor::find($id);
            
            if (!$asesor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asesor not found',
                ], 404);
            }

            // Get assigned schemes
            $assignedSkemas = $this->accessControlService->getAssignedSkemas($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id_asesor' => $asesor->id_asesor,
                    'nama_asesor' => $asesor->nama_asesor,
                    'assigned_skemas' => $assignedSkemas->map(function ($skema) {
                        return [
                            'id_skema' => $skema->id_skema,
                            'nama_skema' => $skema->nama_skema,
                            'nomor_skema' => $skema->nomor_skema ?? null,
                        ];
                    })->toArray(),
                    'total_assignments' => $assignedSkemas->count(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get asesor assignments', [
                'id_asesor' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve asesor assignments',
            ], 500);
        }
    }


    /**
     * Assign a scheme to an asesor.
     * 
     * POST /admin/asesor/{id}/assign-skema
     * 
     * Creates an assignment relationship granting the asesor access to the scheme.
     * 
     * Requirements: 3.2
     *
     * @param Request $request
     * @param string $id The asesor ID
     * @return JsonResponse
     */
    public function store(Request $request, string $id): JsonResponse
    {
        try {
            // Check admin authorization
            $user = Auth::user();
            if (!$user || $user->level !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'This operation requires admin privileges',
                ], 403);
            }

            // Validate request
            $validated = $request->validate([
                'id_skema' => 'required|string',
            ]);

            // Find the asesor
            $asesor = Asesor::find($id);
            
            if (!$asesor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asesor not found',
                ], 404);
            }

            // Find the scheme
            $skema = Skema::find($validated['id_skema']);
            
            if (!$skema) {
                return response()->json([
                    'success' => false,
                    'message' => 'Scheme not found',
                ], 404);
            }

            // Create the assignment
            $assignment = $this->accessControlService->assignSkemaToAsesor(
                $validated['id_skema'],
                $id,
                $user->id_user
            );

            Log::info('Scheme assigned to asesor via controller', [
                'id_skema' => $validated['id_skema'],
                'id_asesor' => $id,
                'assigned_by' => $user->id_user,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Scheme assigned to asesor successfully',
                'data' => [
                    'assignment_id' => $assignment->id,
                    'id_asesor' => $asesor->id_asesor,
                    'nama_asesor' => $asesor->nama_asesor,
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                    'assigned_at' => $assignment->assigned_at,
                ],
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_code' => 'DUPLICATE_ASSIGNMENT',
            ], 409);
        } catch (\Exception $e) {
            Log::error('Failed to assign scheme to asesor', [
                'id_asesor' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to assign scheme to asesor',
            ], 500);
        }
    }

    /**
     * Revoke a scheme assignment from an asesor.
     * 
     * DELETE /admin/asesor/{id}/revoke-skema/{skemaId}
     * 
     * Removes the assignment relationship, revoking the asesor's access to the scheme.
     * 
     * Requirements: 3.3
     *
     * @param string $id The asesor ID
     * @param string $skemaId The scheme ID to revoke
     * @return JsonResponse
     */
    public function destroy(string $id, string $skemaId): JsonResponse
    {
        try {
            // Check admin authorization
            $user = Auth::user();
            if (!$user || $user->level !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'This operation requires admin privileges',
                ], 403);
            }

            // Find the asesor
            $asesor = Asesor::find($id);
            
            if (!$asesor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asesor not found',
                ], 404);
            }

            // Find the scheme
            $skema = Skema::find($skemaId);
            
            if (!$skema) {
                return response()->json([
                    'success' => false,
                    'message' => 'Scheme not found',
                ], 404);
            }

            // Revoke the assignment
            $this->accessControlService->revokeSkemaFromAsesor($skemaId, $id);

            Log::info('Scheme revoked from asesor via controller', [
                'id_skema' => $skemaId,
                'id_asesor' => $id,
                'revoked_by' => $user->id_user,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Scheme assignment revoked successfully',
                'data' => [
                    'id_asesor' => $asesor->id_asesor,
                    'nama_asesor' => $asesor->nama_asesor,
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                ],
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_code' => 'ASSIGNMENT_NOT_FOUND',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to revoke scheme from asesor', [
                'id_asesor' => $id,
                'id_skema' => $skemaId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke scheme assignment',
            ], 500);
        }
    }
}
