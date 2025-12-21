<?php

namespace Tests\Feature\DynamicAssessment;

use App\Enums\AssessmentType;
use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\ProgressTrackingService;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for ProgressTrackingService
 * 
 * **Feature: dynamic-assessment-flow, Property 13: Progress Record Creation**
 * **Feature: dynamic-assessment-flow, Property 14: Progress Completion Update**
 * **Validates: Requirements 8.1, 8.2**
 */
class ProgressTrackingServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    private ProgressTrackingService $service;
    private SkemaConfigService $configService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configService = new SkemaConfigService();
        $this->service = new ProgressTrackingService($this->configService);
    }

    /**
     * Property 13: Progress Record Creation
     * 
     * For any asesi starting an assessment, the system SHALL create a progress record
     * for that asesi-scheme-assessment combination.
     * 
     * **Feature: dynamic-assessment-flow, Property 13: Progress Record Creation**
     * **Validates: Requirements 8.1**
     * 
     * @test
     */
    public function progress_record_is_created_for_asesi_scheme_assessment_combination(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme with random configuration
            $skema = Skema::factory()->create();
            
            // Generate random configuration
            $config = [];
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $config[$type] = fake()->boolean();
            }
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Create asesi with this scheme
            $asesi = Asesi::factory()->forSkema($skema)->create();
            
            // Create progress record for asesi
            $progresAsesmen = ProgresAsesmen::factory()->forAsesi($asesi)->create();

            // Verify: Progress record exists for this asesi
            $this->assertDatabaseHas('progres_asesmen', [
                'id_asesi' => $asesi->id_asesi
            ]);

            // Verify: Progress record is associated with the correct asesi
            $this->assertEquals(
                $asesi->id_asesi,
                $progresAsesmen->id_asesi,
                "Progress record should be associated with the correct asesi"
            );

            // Verify: APL01 is automatically marked as completed on creation
            $this->assertTrue(
                $progresAsesmen->isStepCompleted('apl01'),
                "APL01 should be automatically completed on progress record creation"
            );

            // Verify: getProgressData returns data for this asesi
            $progressData = $this->service->getProgressData($asesi->id_asesi);
            $this->assertNotNull(
                $progressData,
                "getProgressData should return data for asesi with progress record"
            );
            $this->assertArrayHasKey('progress_details', $progressData);
            $this->assertArrayHasKey('progress_summary', $progressData);

            // Clean up for next iteration
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property 14: Progress Completion Update
     * 
     * For any asesi completing an assessment, the system SHALL update the progress record
     * with completion status and timestamp.
     * 
     * **Feature: dynamic-assessment-flow, Property 14: Progress Completion Update**
     * **Validates: Requirements 8.2**
     * 
     * @test
     */
    public function progress_completion_updates_status_and_timestamp(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();
            
            // Apply default config (all enabled)
            $this->configService->applyDefaultConfig($skema->id_skema);

            // Create asesi with this scheme
            $asesi = Asesi::factory()->forSkema($skema)->create();
            
            // Create progress record
            $progresAsesmen = ProgresAsesmen::factory()->forAsesi($asesi)->create();

            // Pick a random step to complete (excluding apl01 which is auto-completed)
            $completableSteps = [
                'apl02', 'ak01', 'konsultasi_pra_uji', 'mapa01', 'mapa02',
                'pernyataan_ketidak_berpihakan', 'ak07', 'ia01', 'ia02',
                'hasil_asesmen', 'ak02', 'umpan_balik', 'ak04'
            ];
            $randomStep = fake()->randomElement($completableSteps);

            // Verify: Step is not completed initially
            $this->assertFalse(
                $progresAsesmen->isStepCompleted($randomStep),
                "Step {$randomStep} should not be completed initially"
            );

            // Complete the step using the service
            $result = $this->service->completeStep($asesi->id_asesi, $randomStep, 'Property test');

            // Verify: completeStep returns true
            $this->assertTrue(
                $result,
                "completeStep should return true for valid step {$randomStep}"
            );

            // Refresh the model to get updated data
            $progresAsesmen->refresh();

            // Verify: Step is now completed
            $this->assertTrue(
                $progresAsesmen->isStepCompleted($randomStep),
                "Step {$randomStep} should be completed after completeStep"
            );

            // Verify: Completion timestamp is set
            $completionTime = $progresAsesmen->getStepCompletionTime($randomStep);
            $this->assertNotNull(
                $completionTime,
                "Completion timestamp should be set for step {$randomStep}"
            );

            // Verify: Timestamp contains WIB timezone indicator
            $this->assertStringContainsString(
                'WIB',
                $completionTime,
                "Completion timestamp should contain WIB timezone"
            );

            // Verify: isStepCompleted via service also returns true
            $this->assertTrue(
                $this->service->isStepCompleted($asesi->id_asesi, $randomStep),
                "Service isStepCompleted should return true for completed step"
            );

            // Verify: getStepCompletionTime via service returns the timestamp
            $serviceCompletionTime = $this->service->getStepCompletionTime($asesi->id_asesi, $randomStep);
            $this->assertEquals(
                $completionTime,
                $serviceCompletionTime,
                "Service getStepCompletionTime should match model completion time"
            );

            // Clean up for next iteration
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: getEnabledProgressData returns only enabled assessments
     * 
     * For any asesi with a scheme configuration, getEnabledProgressData should return
     * progress data only for assessments that are enabled in the scheme.
     * 
     * @test
     */
    public function get_enabled_progress_data_returns_only_enabled_assessments(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();
            
            // Generate random configuration
            $config = [];
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $config[$type] = fake()->boolean();
            }
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Create asesi and progress
            $asesi = Asesi::factory()->forSkema($skema)->create();
            $progresAsesmen = ProgresAsesmen::factory()
                ->forAsesi($asesi)
                ->withRandomProgress()
                ->create();

            // Get enabled progress data via service
            $enabledProgressData = $this->service->getEnabledProgressData($asesi->id_asesi);

            // Verify: Data is returned
            $this->assertNotNull($enabledProgressData);
            $this->assertArrayHasKey('progress_details', $enabledProgressData);
            $this->assertArrayHasKey('progress_summary', $enabledProgressData);

            // Verify: Disabled assessments are not in progress_details
            foreach ($config as $assessmentType => $isEnabled) {
                if (!$isEnabled) {
                    $field = ProgresAsesmen::getFieldForAssessmentType($assessmentType);
                    if ($field !== null) {
                        $this->assertArrayNotHasKey(
                            $field,
                            $enabledProgressData['progress_details'],
                            "Disabled assessment {$assessmentType} (field: {$field}) should not be in enabled progress data"
                        );
                    }
                }
            }

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: calculateSchemeBasedProgress returns correct percentage
     * 
     * For any asesi with a scheme, calculateSchemeBasedProgress should return
     * progress percentage based only on enabled assessments.
     * 
     * @test
     */
    public function calculate_scheme_based_progress_returns_correct_percentage(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();
            
            // Apply default config (all enabled)
            $this->configService->applyDefaultConfig($skema->id_skema);

            // Create asesi and progress with all steps completed
            $asesi = Asesi::factory()->forSkema($skema)->create();
            
            $progressData = [
                'id_asesi' => $asesi->id_asesi,
                'apl01' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'apl02' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'ak01' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'konsultasi_pra_uji' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'mapa01' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'mapa02' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'pernyataan_ketidak_berpihakan' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'ak07' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'ia01' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'ia02' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'hasil_asesmen' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'ak02' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'umpan_balik' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
                'ak04' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
            ];
            
            $progresAsesmen = ProgresAsesmen::create($progressData);

            // Calculate scheme-based progress
            $progress = $this->service->calculateSchemeBasedProgress($asesi->id_asesi);

            // Verify: Progress percentage is 100% when all steps are completed
            $this->assertEquals(
                100,
                $progress['progress_percentage'],
                "Progress should be 100% when all enabled steps are completed"
            );

            // Verify: completed_steps equals total_steps
            $this->assertEquals(
                $progress['total_steps'],
                $progress['completed_steps'],
                "Completed steps should equal total steps when all are completed"
            );

            // Verify: enabled_assessments is returned
            $this->assertArrayHasKey('enabled_assessments', $progress);
            $this->assertNotEmpty($progress['enabled_assessments']);

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: isStepEnabledForAsesi matches scheme configuration
     * 
     * For any asesi and any step, isStepEnabledForAsesi should return true
     * only if the step is enabled in the asesi's scheme configuration.
     * 
     * @test
     */
    public function is_step_enabled_for_asesi_matches_scheme_config(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();
            
            // Generate random configuration
            $config = [];
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $config[$type] = fake()->boolean();
            }
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Test each mapped field
            foreach (ProgresAsesmen::$fieldToAssessmentTypeMap as $field => $assessmentType) {
                $isEnabled = $this->service->isStepEnabledForAsesi($asesi->id_asesi, $field);
                $expectedEnabled = $config[$assessmentType] ?? true;

                // Mandatory types should always be enabled
                if (AssessmentType::isMandatory($assessmentType)) {
                    $this->assertTrue(
                        $isEnabled,
                        "Mandatory type {$assessmentType} (field: {$field}) should always be enabled"
                    );
                } else {
                    $this->assertEquals(
                        $expectedEnabled,
                        $isEnabled,
                        "Field {$field} (type: {$assessmentType}) enabled state should match config"
                    );
                }
            }

            // Clean up
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Non-existent asesi returns appropriate defaults
     * 
     * For any non-existent asesi ID, the service methods should return
     * appropriate default values without errors.
     * 
     * @test
     */
    public function non_existent_asesi_returns_appropriate_defaults(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Generate a random non-existent asesi ID
            $nonExistentId = 'ASESI_NONEXISTENT_' . fake()->uuid();

            // Verify: getProgressData returns null
            $this->assertNull(
                $this->service->getProgressData($nonExistentId),
                "getProgressData should return null for non-existent asesi"
            );

            // Verify: getEnabledProgressData returns null
            $this->assertNull(
                $this->service->getEnabledProgressData($nonExistentId),
                "getEnabledProgressData should return null for non-existent asesi"
            );

            // Verify: calculateSchemeBasedProgress returns zeros
            $progress = $this->service->calculateSchemeBasedProgress($nonExistentId);
            $this->assertEquals(0, $progress['progress_percentage']);
            $this->assertEquals(0, $progress['completed_steps']);
            $this->assertEquals(0, $progress['total_steps']);

            // Verify: isStepCompleted returns false
            $this->assertFalse(
                $this->service->isStepCompleted($nonExistentId, 'apl01'),
                "isStepCompleted should return false for non-existent asesi"
            );

            // Verify: isStepEnabledForAsesi returns false
            $this->assertFalse(
                $this->service->isStepEnabledForAsesi($nonExistentId, 'apl01'),
                "isStepEnabledForAsesi should return false for non-existent asesi"
            );

            // Verify: completeStep returns false
            $this->assertFalse(
                $this->service->completeStep($nonExistentId, 'apl02'),
                "completeStep should return false for non-existent asesi"
            );
        }
    }
}
