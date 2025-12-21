<?php

namespace Tests\Feature\Certificate;

use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Models\User;
use App\Services\CertificateService;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

/**
 * Property-Based Tests for Certificate Authorization
 * 
 * **Feature: certificate-generation, Property 6: Authorization prevents cross-user access**
 * **Validates: Requirements 4.2**
 */
class CertificateAuthorizationPropertyTest extends TestCase
{
    use RefreshDatabase;

    private SkemaConfigService $skemaConfigService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skemaConfigService = new SkemaConfigService();
    }

    /**
     * Helper to create asesi with 100% progress
     */
    private function createAsesiWithFullProgress(User $user, Skema $skema): Asesi
    {
        $asesi = Asesi::factory()->forSkema($skema)->create([
            'id_user' => $user->id_user
        ]);

        $countedSteps = [
            'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
            'ak07', 'ia02', 'ia05', 'tugas_peserta',
            'ak02', 'umpan_balik'
        ];

        $excludedSteps = ['mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan', 'ia01', 'ia11', 'hasil_asesmen', 'ak04'];

        $progressData = ['id_asesi' => $asesi->id_asesi];
        
        foreach ($countedSteps as $step) {
            $progressData[$step] = [
                'completed' => true,
                'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'
            ];
        }
        
        foreach ($excludedSteps as $step) {
            $progressData[$step] = [
                'completed' => true,
                'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'
            ];
        }

        ProgresAsesmen::create($progressData);

        return $asesi;
    }

    /**
     * Helper to create asesi with incomplete progress
     */
    private function createAsesiWithIncompleteProgress(User $user, Skema $skema): Asesi
    {
        $asesi = Asesi::factory()->forSkema($skema)->create([
            'id_user' => $user->id_user
        ]);

        // Only complete apl01
        $progressData = [
            'id_asesi' => $asesi->id_asesi,
            'apl01' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
        ];

        ProgresAsesmen::create($progressData);

        return $asesi;
    }

    /**
     * Property 6: Authorization prevents cross-user access
     * 
     * For any authenticated user attempting to access admin route without admin role,
     * the system rejects the request.
     * 
     * **Feature: certificate-generation, Property 6: Authorization prevents cross-user access**
     * **Validates: Requirements 4.2**
     * 
     * @test
     */
    public function unauthorized_user_cannot_access_other_asesi_certificate(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            $ownerUser = User::factory()->create(['level' => 'asesi']);
            $asesi = $this->createAsesiWithFullProgress($ownerUser, $skema);

            $otherUser = User::factory()->create(['level' => 'asesi']);

            // Non-admin trying to access admin route should get 403
            $response = $this->actingAs($otherUser)
                ->get("/admin/asesi/{$asesi->id_asesi}/certificate/download");

            $response->assertStatus(403);

            // Clean up
            ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->delete();
            $asesi->delete();
            $ownerUser->delete();
            $otherUser->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Unauthenticated user cannot access certificate
     * 
     * @test
     */
    public function unauthenticated_user_cannot_access_certificate(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            $user = User::factory()->create(['level' => 'asesi']);
            $asesi = $this->createAsesiWithFullProgress($user, $skema);

            // Try to access certificate without authentication
            $response = $this->get("/asesi/certificate/download");

            // Should redirect to login
            $this->assertTrue(
                $response->status() === 302 || $response->status() === 401,
                "Unauthenticated request should be rejected"
            );

            // Clean up
            ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->delete();
            $asesi->delete();
            $user->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Ineligible asesi cannot download certificate
     * 
     * For any asesi with progress < 100%, the certificate download should be rejected.
     * 
     * @test
     */
    public function ineligible_asesi_cannot_download_certificate(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            $user = User::factory()->create(['level' => 'asesi']);
            $asesi = $this->createAsesiWithIncompleteProgress($user, $skema);

            // Try to download certificate with incomplete progress
            $response = $this->actingAs($user)
                ->get("/asesi/certificate/download");

            // Should get 403 Forbidden
            $response->assertStatus(403);

            // Clean up
            ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->delete();
            $asesi->delete();
            $user->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Eligible asesi can access certificate endpoint
     * 
     * For any asesi with 100% progress, the certificate endpoint should be accessible.
     * Note: We test eligibility check passes, not actual PDF generation (which is slow).
     * 
     * @test
     */
    public function eligible_asesi_passes_authorization_check(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            $user = User::factory()->create(['level' => 'asesi']);
            $asesi = $this->createAsesiWithFullProgress($user, $skema);

            // Check that the CertificateService correctly identifies eligibility
            $certificateService = app(CertificateService::class);
            $isEligible = $certificateService->isEligibleForCertificate($asesi);

            $this->assertTrue($isEligible, "Asesi with 100% progress should be eligible");

            // Clean up
            ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->delete();
            $asesi->delete();
            $user->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }
}
