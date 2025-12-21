<?php

namespace Tests\Feature\DynamicAssessment;

use App\Models\Asesor;
use App\Models\AsesorSkemaAssignment;
use App\Models\Skema;
use App\Models\User;
use App\Services\AccessControlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for AccessControlService
 * 
 * Tests Property 3 and Property 4 from the design document.
 */
class AccessControlServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    private AccessControlService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AccessControlService();
    }

    /**
     * Property 3: Asesor Scheme Access Control
     * 
     * For any asesor and any scheme, the asesor SHALL only have access 
     * to schemes that are explicitly assigned to them.
     * 
     * **Feature: dynamic-assessment-flow, Property 3: Asesor Scheme Access Control**
     * **Validates: Requirements 2.1, 2.2**
     * 
     * @test
     */
    public function asesor_can_only_access_assigned_schemes(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create an asesor user
            $user = User::factory()->create(['level' => 'asesor']);
            $asesor = Asesor::factory()->create(['id_user' => $user->id_user]);
            
            // Create multiple random schemes
            $numSchemes = fake()->numberBetween(2, 5);
            $schemes = [];
            for ($j = 0; $j < $numSchemes; $j++) {
                $schemes[] = Skema::factory()->create();
            }
            
            // Randomly assign some schemes to the asesor
            $assignedSchemes = fake()->randomElements($schemes, fake()->numberBetween(0, $numSchemes));
            foreach ($assignedSchemes as $scheme) {
                AsesorSkemaAssignment::create([
                    'id_asesor' => $asesor->id_asesor,
                    'id_skema' => $scheme->id_skema,
                    'assigned_by' => $user->id_user,
                    'assigned_at' => now(),
                ]);
            }
            
            // Verify access control for each scheme
            foreach ($schemes as $scheme) {
                $hasAccess = $this->service->canManageSkema($user, $scheme->id_skema);
                $isAssigned = in_array($scheme, $assignedSchemes, true);
                
                $this->assertEquals(
                    $isAssigned,
                    $hasAccess,
                    "Asesor should " . ($isAssigned ? "" : "NOT ") . "have access to scheme {$scheme->id_skema}"
                );
            }
            
            // Clean up for next iteration
            AsesorSkemaAssignment::where('id_asesor', $asesor->id_asesor)->delete();
            foreach ($schemes as $scheme) {
                $scheme->delete();
            }
            $asesor->delete();
            $user->delete();
        }
    }

    /**
     * Property 3 (continued): Admin has full access to all schemes
     * 
     * For any admin user and any scheme, the admin SHALL have access.
     * 
     * **Feature: dynamic-assessment-flow, Property 3: Asesor Scheme Access Control**
     * **Validates: Requirements 2.1, 2.2**
     * 
     * @test
     */
    public function admin_has_full_access_to_all_schemes(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create an admin user
            $adminUser = User::factory()->create(['level' => 'admin']);
            
            // Create random schemes
            $numSchemes = fake()->numberBetween(1, 5);
            $schemes = [];
            for ($j = 0; $j < $numSchemes; $j++) {
                $schemes[] = Skema::factory()->create();
            }
            
            // Admin should have access to ALL schemes without any assignment
            foreach ($schemes as $scheme) {
                $hasAccess = $this->service->canManageSkema($adminUser, $scheme->id_skema);
                
                $this->assertTrue(
                    $hasAccess,
                    "Admin should have access to scheme {$scheme->id_skema}"
                );
            }
            
            // Clean up
            foreach ($schemes as $scheme) {
                $scheme->delete();
            }
            $adminUser->delete();
        }
    }

    /**
     * Property 3 (continued): Non-asesor/non-admin users cannot manage schemes
     * 
     * For any user that is not admin or asesor, they SHALL NOT have access.
     * 
     * **Feature: dynamic-assessment-flow, Property 3: Asesor Scheme Access Control**
     * **Validates: Requirements 2.1, 2.2**
     * 
     * @test
     */
    public function non_admin_non_asesor_cannot_manage_schemes(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a non-admin, non-asesor user (e.g., asesi)
            $user = User::factory()->create(['level' => 'asesi']);
            
            // Create a random scheme
            $scheme = Skema::factory()->create();
            
            // User should NOT have access
            $hasAccess = $this->service->canManageSkema($user, $scheme->id_skema);
            
            $this->assertFalse(
                $hasAccess,
                "Non-admin/non-asesor user should NOT have access to scheme {$scheme->id_skema}"
            );
            
            // Clean up
            $scheme->delete();
            $user->delete();
        }
    }

    /**
     * Property 4: Assignment Creates Access
     * 
     * For any admin, asesor, and scheme, creating an assignment SHALL grant 
     * the asesor access to that scheme, and revoking SHALL deny access.
     * 
     * **Feature: dynamic-assessment-flow, Property 4: Assignment Creates Access**
     * **Validates: Requirements 3.2, 3.3**
     * 
     * @test
     */
    public function assignment_creates_and_revokes_access(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create admin user for assignment
            $adminUser = User::factory()->create(['level' => 'admin']);
            
            // Create asesor user
            $asesorUser = User::factory()->create(['level' => 'asesor']);
            $asesor = Asesor::factory()->create(['id_user' => $asesorUser->id_user]);
            
            // Create a scheme
            $scheme = Skema::factory()->create();
            
            // Initially, asesor should NOT have access
            $this->assertFalse(
                $this->service->canManageSkema($asesorUser, $scheme->id_skema),
                "Asesor should NOT have access before assignment"
            );
            
            // Assign scheme to asesor
            $assignment = $this->service->assignSkemaToAsesor(
                $scheme->id_skema,
                $asesor->id_asesor,
                $adminUser->id_user
            );
            
            $this->assertNotNull($assignment, "Assignment should be created");
            
            // Now asesor SHOULD have access
            $this->assertTrue(
                $this->service->canManageSkema($asesorUser, $scheme->id_skema),
                "Asesor should have access after assignment"
            );
            
            // Revoke the assignment
            $revoked = $this->service->revokeSkemaFromAsesor(
                $scheme->id_skema,
                $asesor->id_asesor
            );
            
            $this->assertTrue($revoked, "Revocation should succeed");
            
            // After revocation, asesor should NOT have access
            $this->assertFalse(
                $this->service->canManageSkema($asesorUser, $scheme->id_skema),
                "Asesor should NOT have access after revocation"
            );
            
            // Clean up
            $scheme->delete();
            $asesor->delete();
            $asesorUser->delete();
            $adminUser->delete();
        }
    }

    /**
     * Property 4 (continued): Duplicate assignment throws exception
     * 
     * For any asesor already assigned to a scheme, attempting to assign again
     * SHALL throw an exception.
     * 
     * **Feature: dynamic-assessment-flow, Property 4: Assignment Creates Access**
     * **Validates: Requirements 3.2, 3.3**
     * 
     * @test
     */
    public function duplicate_assignment_throws_exception(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create admin user
            $adminUser = User::factory()->create(['level' => 'admin']);
            
            // Create asesor
            $asesorUser = User::factory()->create(['level' => 'asesor']);
            $asesor = Asesor::factory()->create(['id_user' => $asesorUser->id_user]);
            
            // Create scheme
            $scheme = Skema::factory()->create();
            
            // First assignment should succeed
            $this->service->assignSkemaToAsesor(
                $scheme->id_skema,
                $asesor->id_asesor,
                $adminUser->id_user
            );
            
            // Second assignment should throw exception
            $exceptionThrown = false;
            try {
                $this->service->assignSkemaToAsesor(
                    $scheme->id_skema,
                    $asesor->id_asesor,
                    $adminUser->id_user
                );
            } catch (\InvalidArgumentException $e) {
                $exceptionThrown = true;
                $this->assertStringContainsString(
                    'already assigned',
                    $e->getMessage()
                );
            }
            
            $this->assertTrue(
                $exceptionThrown,
                "Duplicate assignment should throw InvalidArgumentException"
            );
            
            // Clean up
            AsesorSkemaAssignment::where('id_asesor', $asesor->id_asesor)->delete();
            $scheme->delete();
            $asesor->delete();
            $asesorUser->delete();
            $adminUser->delete();
        }
    }

    /**
     * Property 4 (continued): Revoking non-existent assignment throws exception
     * 
     * For any asesor not assigned to a scheme, attempting to revoke
     * SHALL throw an exception.
     * 
     * **Feature: dynamic-assessment-flow, Property 4: Assignment Creates Access**
     * **Validates: Requirements 3.2, 3.3**
     * 
     * @test
     */
    public function revoking_nonexistent_assignment_throws_exception(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create asesor
            $asesorUser = User::factory()->create(['level' => 'asesor']);
            $asesor = Asesor::factory()->create(['id_user' => $asesorUser->id_user]);
            
            // Create scheme (but don't assign)
            $scheme = Skema::factory()->create();
            
            // Revoking should throw exception
            $exceptionThrown = false;
            try {
                $this->service->revokeSkemaFromAsesor(
                    $scheme->id_skema,
                    $asesor->id_asesor
                );
            } catch (\InvalidArgumentException $e) {
                $exceptionThrown = true;
                $this->assertStringContainsString(
                    'Assignment not found',
                    $e->getMessage()
                );
            }
            
            $this->assertTrue(
                $exceptionThrown,
                "Revoking non-existent assignment should throw InvalidArgumentException"
            );
            
            // Clean up
            $scheme->delete();
            $asesor->delete();
            $asesorUser->delete();
        }
    }

    /**
     * Property: getAssignedSkemas returns correct schemes
     * 
     * For any asesor with assignments, getAssignedSkemas SHALL return
     * exactly the schemes that are assigned.
     * 
     * @test
     */
    public function get_assigned_skemas_returns_correct_schemes(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create admin user
            $adminUser = User::factory()->create(['level' => 'admin']);
            
            // Create asesor
            $asesorUser = User::factory()->create(['level' => 'asesor']);
            $asesor = Asesor::factory()->create(['id_user' => $asesorUser->id_user]);
            
            // Create multiple schemes
            $numSchemes = fake()->numberBetween(1, 5);
            $allSchemes = [];
            for ($j = 0; $j < $numSchemes; $j++) {
                $allSchemes[] = Skema::factory()->create();
            }
            
            // Randomly assign some schemes
            $numToAssign = fake()->numberBetween(0, $numSchemes);
            $assignedSchemes = fake()->randomElements($allSchemes, $numToAssign);
            
            foreach ($assignedSchemes as $scheme) {
                $this->service->assignSkemaToAsesor(
                    $scheme->id_skema,
                    $asesor->id_asesor,
                    $adminUser->id_user
                );
            }
            
            // Get assigned schemes
            $returnedSchemes = $this->service->getAssignedSkemas($asesor->id_asesor);
            
            // Verify count matches
            $this->assertCount(
                count($assignedSchemes),
                $returnedSchemes,
                "Should return exactly {$numToAssign} schemes"
            );
            
            // Verify each assigned scheme is in the result
            $returnedIds = $returnedSchemes->pluck('id_skema')->toArray();
            foreach ($assignedSchemes as $scheme) {
                $this->assertContains(
                    $scheme->id_skema,
                    $returnedIds,
                    "Assigned scheme {$scheme->id_skema} should be in result"
                );
            }
            
            // Clean up
            AsesorSkemaAssignment::where('id_asesor', $asesor->id_asesor)->delete();
            foreach ($allSchemes as $scheme) {
                $scheme->delete();
            }
            $asesor->delete();
            $asesorUser->delete();
            $adminUser->delete();
        }
    }
}
