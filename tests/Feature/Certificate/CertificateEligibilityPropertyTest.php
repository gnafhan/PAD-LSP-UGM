<?php

namespace Tests\Feature\Certificate;

use App\Enums\AssessmentType;
use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\CertificateService;
use App\Services\ProgressTrackingService;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for Certificate Eligibility
 * 
 * **Feature: certificate-generation, Property 5: Progress validation rejects non-100% progress**
 * **Validates: Requirements 4.1**
 */
class CertificateEligibilityPropertyTest extends TestCase
{
    use RefreshDatabase;

    private CertificateService $certificateService;
    private SkemaConfigService $skemaConfigService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skemaConfigService = new SkemaConfigService();
        $progressTrackingService = new ProgressTrackingService($this->skemaConfigService);
        $this->certificateService = new CertificateService($progressTrackingService);
    }

    /**
     * Property 5: Progress validation rejects non-100% progress
     * 
     * For any asesi with progress less than 100%, attempting to generate a certificate
     * returns an error (isEligibleForCertificate returns false).
     * 
     * **Feature: certificate-generation, Property 5: Progress validation rejects non-100% progress**
     * **Validates: Requirements 4.1**
     * 
     * @test
     */
    public function asesi_with_incomplete_progress_is_not_eligible_for_certificate(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme with default config
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Create progress with random incomplete state
            // Randomly complete some steps but not all
            // Based on ProgresAsesmen::$excludedFromProgress, these are the counted steps:
            $allSteps = [
                'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
                'ak07', 'ia02', 'ia05', 'tugas_peserta',
                'ak02', 'umpan_balik'
            ];

            // Randomly select how many steps to complete (0 to count-1, never all)
            $stepsToComplete = fake()->numberBetween(0, \count($allSteps) - 1);
            $completedSteps = fake()->randomElements($allSteps, $stepsToComplete);

            $progressData = ['id_asesi' => $asesi->id_asesi];
            foreach ($allSteps as $step) {
                $isCompleted = \in_array($step, $completedSteps);
                $progressData[$step] = [
                    'completed' => $isCompleted,
                    'completed_at' => $isCompleted ? now()->format('d-m-Y H:i:s') . ' WIB' : null
                ];
            }

            // Add excluded fields as not completed
            $excludedSteps = ['mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan', 'ia01', 'ia11', 'hasil_asesmen', 'ak04'];
            foreach ($excludedSteps as $step) {
                $progressData[$step] = ['completed' => false, 'completed_at' => null];
            }

            $progresAsesmen = ProgresAsesmen::create($progressData);

            // Verify: Asesi is NOT eligible for certificate
            $isEligible = $this->certificateService->isEligibleForCertificate($asesi);
            
            $this->assertFalse(
                $isEligible,
                "Asesi with incomplete progress ({$stepsToComplete}/" . \count($allSteps) . " steps) should NOT be eligible for certificate"
            );

            // Verify: Progress percentage is less than 100
            $progressPercentage = $this->certificateService->getProgressPercentage($asesi);
            $this->assertLessThan(
                100,
                $progressPercentage,
                "Progress percentage should be less than 100 for incomplete progress"
            );

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Asesi with 100% progress IS eligible for certificate
     * 
     * For any asesi with progress exactly 100%, isEligibleForCertificate returns true.
     * 
     * @test
     */
    public function asesi_with_complete_progress_is_eligible_for_certificate(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme with default config
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Create progress with ALL steps completed
            // Based on ProgresAsesmen::$excludedFromProgress, these are excluded:
            // 'mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan', 'ia01', 'ia11', 'hasil_asesmen', 'ak04'
            $allSteps = [
                'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
                'ak07', 'ia02', 'ia05', 'tugas_peserta',
                'ak02', 'umpan_balik'
            ];

            $progressData = ['id_asesi' => $asesi->id_asesi];
            foreach ($allSteps as $step) {
                $progressData[$step] = [
                    'completed' => true,
                    'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'
                ];
            }

            // Add excluded fields (they don't affect progress calculation)
            $excludedSteps = ['mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan', 'ia01', 'ia11', 'hasil_asesmen', 'ak04'];
            foreach ($excludedSteps as $step) {
                $progressData[$step] = ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'];
            }

            $progresAsesmen = ProgresAsesmen::create($progressData);

            // Verify: Asesi IS eligible for certificate
            $isEligible = $this->certificateService->isEligibleForCertificate($asesi);
            
            $this->assertTrue(
                $isEligible,
                "Asesi with 100% progress should be eligible for certificate"
            );

            // Verify: Progress percentage is exactly 100
            $progressPercentage = $this->certificateService->getProgressPercentage($asesi);
            $this->assertEquals(
                100,
                $progressPercentage,
                "Progress percentage should be exactly 100 for complete progress"
            );

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: generateCertificate throws exception for ineligible asesi
     * 
     * For any asesi with progress < 100%, calling generateCertificate throws an exception.
     * 
     * @test
     */
    public function generate_certificate_throws_exception_for_ineligible_asesi(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create a scheme with default config
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Create progress with incomplete state (only apl01 completed)
            $progresAsesmen = ProgresAsesmen::factory()
                ->forAsesi($asesi)
                ->create();

            // Verify: generateCertificate throws exception
            $this->expectException(\Exception::class);
            $this->expectExceptionMessage('Asesi belum memenuhi syarat untuk mendapatkan sertifikat');
            
            $this->certificateService->generateCertificate($asesi);

            // Clean up (won't reach here due to exception, but good practice)
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }
}
