<?php

namespace App\Services;

use App\Models\Asesor;
use App\Models\AsesorSkemaAssignment;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * AccessControlService
 * 
 * Service for managing access control for schemes.
 * Handles asesor-scheme assignments and permission checks.
 * 
 * Requirements: 2.1, 2.2, 3.2, 3.3
 */
class AccessControlService
{
    /**
     * Check if a user can manage a specific scheme.
     * Admin users have full access to all schemes.
     * Asesor users can only access schemes assigned to them.
     * 
     * Requirements: 2.1, 2.2
     *
     * @param User $user The user to check
     * @param string $idSkema The scheme ID to check access for
     * @return bool Whether the user can manage the scheme
     */
    public function canManageSkema(User $user, string $idSkema): bool
    {
        // Admin has full access to all schemes
        if ($user->level === 'admin') {
            return true;
        }

        // For asesor, check if they have an assignment
        if ($user->level === 'asesor') {
            // Get the asesor record for this user
            $asesor = Asesor::where('id_user', $user->id_user)->first();
            
            if (!$asesor) {
                Log::warning("User is asesor but has no asesor record", [
                    'id_user' => $user->id_user
                ]);
                return false;
            }

            // Check if asesor is assigned to this scheme
            return AsesorSkemaAssignment::isAssigned($asesor->id_asesor, $idSkema);
        }

        // Other user levels (asesi, etc.) cannot manage schemes
        return false;
    }

    /**
     * Get all schemes assigned to an asesor.
     * 
     * Requirements: 2.1
     *
     * @param string $idAsesor The asesor ID
     * @return Collection Collection of Skema models assigned to the asesor
     */
    public function getAssignedSkemas(string $idAsesor): Collection
    {
        $assignedSkemaIds = AsesorSkemaAssignment::getAssignedSkemaIds($idAsesor);
        
        if (empty($assignedSkemaIds)) {
            return collect();
        }

        return Skema::whereIn('id_skema', $assignedSkemaIds)->get();
    }

    /**
     * Assign a scheme to an asesor.
     * Creates an assignment record granting the asesor access.
     * 
     * Requirements: 3.2
     *
     * @param string $idSkema The scheme ID to assign
     * @param string $idAsesor The asesor ID to assign to
     * @param string $assignedBy The user ID of the admin making the assignment
     * @return AsesorSkemaAssignment The created assignment record
     * @throws \InvalidArgumentException If assignment already exists
     */
    public function assignSkemaToAsesor(string $idSkema, string $idAsesor, string $assignedBy): AsesorSkemaAssignment
    {
        // Check if assignment already exists
        if (AsesorSkemaAssignment::isAssigned($idAsesor, $idSkema)) {
            throw new \InvalidArgumentException(
                "Asesor is already assigned to this scheme."
            );
        }

        // Validate that the scheme exists
        $skema = Skema::find($idSkema);
        if (!$skema) {
            throw new \InvalidArgumentException("Scheme not found: {$idSkema}");
        }

        // Validate that the asesor exists
        $asesor = Asesor::find($idAsesor);
        if (!$asesor) {
            throw new \InvalidArgumentException("Asesor not found: {$idAsesor}");
        }

        try {
            $assignment = AsesorSkemaAssignment::create([
                'id_asesor' => $idAsesor,
                'id_skema' => $idSkema,
                'assigned_by' => $assignedBy,
                'assigned_at' => now(),
            ]);

            Log::info("Scheme assigned to asesor", [
                'id_skema' => $idSkema,
                'id_asesor' => $idAsesor,
                'assigned_by' => $assignedBy
            ]);

            return $assignment;
        } catch (\Exception $e) {
            Log::error("Failed to assign scheme to asesor", [
                'id_skema' => $idSkema,
                'id_asesor' => $idAsesor,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Revoke a scheme assignment from an asesor.
     * Deletes the assignment record, removing the asesor's access.
     * 
     * Requirements: 3.3
     *
     * @param string $idSkema The scheme ID to revoke
     * @param string $idAsesor The asesor ID to revoke from
     * @return bool Whether the revocation was successful
     * @throws \InvalidArgumentException If assignment does not exist
     */
    public function revokeSkemaFromAsesor(string $idSkema, string $idAsesor): bool
    {
        // Check if assignment exists
        $assignment = AsesorSkemaAssignment::where('id_asesor', $idAsesor)
            ->where('id_skema', $idSkema)
            ->first();

        if (!$assignment) {
            throw new \InvalidArgumentException(
                "Assignment not found for asesor {$idAsesor} and scheme {$idSkema}."
            );
        }

        try {
            $deleted = $assignment->delete();

            Log::info("Scheme revoked from asesor", [
                'id_skema' => $idSkema,
                'id_asesor' => $idAsesor
            ]);

            return $deleted;
        } catch (\Exception $e) {
            Log::error("Failed to revoke scheme from asesor", [
                'id_skema' => $idSkema,
                'id_asesor' => $idAsesor,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Check if an asesor has access to a specific scheme.
     * 
     * @param string $idAsesor The asesor ID
     * @param string $idSkema The scheme ID
     * @return bool Whether the asesor has access
     */
    public function asesorHasAccess(string $idAsesor, string $idSkema): bool
    {
        return AsesorSkemaAssignment::isAssigned($idAsesor, $idSkema);
    }

    /**
     * Get all asesors assigned to a specific scheme.
     * 
     * @param string $idSkema The scheme ID
     * @return Collection Collection of Asesor models assigned to the scheme
     */
    public function getAssignedAsesors(string $idSkema): Collection
    {
        $assignedAsesorIds = AsesorSkemaAssignment::getAssignedAsesorIds($idSkema);
        
        if (empty($assignedAsesorIds)) {
            return collect();
        }

        return Asesor::whereIn('id_asesor', $assignedAsesorIds)->get();
    }
}
