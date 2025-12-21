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
 * Property-Based Tests for Historical Progress Retention
 * 
 * **Feature: dynamic-assessment-flow, Property 15: Historical Progress Retention**
 * **Validates: Requirements 8.4**
 * 
 * Tests that when an assessment tool is disabled after an asesi has completed it,
 * the historical completion data is retained.
 */
class HistoricalProgressRetentionPropertyTest extends TestCase
{
    use RefreshDatabase;

    private ProgressTrackingService $progressService;
    private SkemaConfigService $configService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configService = new SkemaConfigService();
        $this->progressService = new ProgressTrackingService($this->configService);
    }

    /**
     * Property 15: Historical Progress Retention
     * 
     * For any assessment tool disabled after an asesi has completed it,
     * the historical completion data SHALL be retained.
     * 
     * **Feature: dynamic-assessment-flow, Property 15: Historical Progress Retention**
     * **Validates: Requirements 8.4**
     * 
     * @test
     */
    public function historical_progress_is_retained_when_assessment_is_disabled(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme with all assessments enabled
            $skema = Skema::factory()->create();
            $this->configService->applyDefaultConfig($skema->id_skema);

            // Create asesi with this scheme
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Pick a random configurable assessment type to complete and then disable
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $randomType = fake()->randomElement($configurableTypes);
            $fieldName = ProgresAsesmen::getFieldForAssessmentType($randomType);

            // Skip if no field mapping exists for this type
            if ($fieldName === null) {
                // Clean up and continue
                $asesi->delete();
                SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
                $skema->delete();
                continue;
            }

            // Create progress record with the random assessment completed
            $completedAt = now()->format('d-m-Y H:i:s') . ' WIB';
            $progressData = [
                'id_asesi' => $asesi->id_asesi,
                'apl01' => ['completed' => true, 'completed_at' => $completedAt],
                'apl02' => ['completed' => false, 'completed_at' => null],
                'ak01' => ['completed' => false, 'completed_at' => null],
                'konsultasi_pra_uji' => ['completed' => false, 'completed_at' => null],
                'mapa01' => ['completed' => false, 'completed_at' => null],
                'mapa02' => ['completed' => false, 'completed_at' => null],
                'pernyataan_ketidak_berpihakan' => ['completed' => false, 'completed_at' => null],
                'ak07' => ['completed' => false, 'completed_at' => null],
                'ia01' => ['completed' => false, 'completed_at' => null],
                'ia02' => ['completed' => false, 'completed_at' => null],
                'hasil_asesmen' => ['completed' => false, 'completed_at' => null],
                'ak02' => ['completed' => false, 'completed_at' => null],
                'umpan_balik' => ['completed' => false, 'completed_at' => null],
                'ak04' => ['completed' => false, 'completed_at' => null],
            ];

            // Mark the random assessment as completed
            $progressData[$fieldName] = ['completed' => true, 'completed_at' => $completedAt];

            $progresAsesmen = ProgresAsesmen::create($progressData);

            // Verify: Assessment is completed before disabling
            $this->assertTrue(
                $progresAsesmen->isStepCompleted($fieldName),
                "Assessment {$fieldName} should be completed before disabling"
            );

            // Store the original completion data
            $originalCompletionData = $progresAsesmen->$fieldName;
            $originalCompletedAt = $progresAsesmen->getStepCompletionTime($fieldName);

            // Now disable the assessment in the scheme configuration
            $config = [];
            foreach (AssessmentType::getAllTypes() as $type) {
                // Disable only the random type, keep others enabled
                $config[$type] = ($type !== $randomType);
            }
            // Ensure mandatory types stay enabled
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Refresh the progress record
            $progresAsesmen->refresh();

            // PROPERTY VERIFICATION: Historical data is retained
            
            // 1. The completion status is still stored in the database
            $this->assertTrue(
                $progresAsesmen->isStepCompleted($fieldName),
                "Historical completion status should be retained for {$fieldName} after disabling"
            );

            // 2. The completion timestamp is still stored
            $this->assertEquals(
                $originalCompletedAt,
                $progresAsesmen->getStepCompletionTime($fieldName),
                "Historical completion timestamp should be retained for {$fieldName} after disabling"
            );

            // 3. The raw data in the database is unchanged
            $this->assertEquals(
                $originalCompletionData,
                $progresAsesmen->$fieldName,
                "Historical completion data should be unchanged for {$fieldName} after disabling"
            );

            // 4. The structured progress still contains the historical data
            $structuredProgress = $progresAsesmen->getStructuredProgress();
            $this->assertArrayHasKey($fieldName, $structuredProgress);
            $this->assertTrue(
                $structuredProgress[$fieldName]['completed'],
                "Structured progress should retain completed status for {$fieldName}"
            );

            // 5. Verify the assessment is now disabled in the scheme
            $this->assertFalse(
                $this->configService->isAssessmentEnabled($skema->id_skema, $randomType),
                "Assessment {$randomType} should be disabled in scheme config"
            );

            // 6. Verify the assessment is not included in enabled assessments progress
            // (but the data is still in the database)
            $enabledProgress = $progresAsesmen->getEnabledAssessmentsProgress();
            $this->assertArrayNotHasKey(
                $fieldName,
                $enabledProgress,
                "Disabled assessment {$fieldName} should not appear in enabled assessments progress"
            );

            // Clean up for next iteration
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Multiple assessments can be disabled while retaining all historical data
     * 
     * For any set of assessments disabled after completion, all historical data
     * should be retained for each assessment.
     * 
     * @test
     */
    public function multiple_disabled_assessments_retain_all_historical_data(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme with all assessments enabled
            $skema = Skema::factory()->create();
            $this->configService->applyDefaultConfig($skema->id_skema);

            // Create asesi with this scheme
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Create progress with multiple random assessments completed
            $completedAt = now()->format('d-m-Y H:i:s') . ' WIB';
            $progressData = [
                'id_asesi' => $asesi->id_asesi,
                'apl01' => ['completed' => true, 'completed_at' => $completedAt],
                'apl02' => ['completed' => false, 'completed_at' => null],
                'ak01' => ['completed' => false, 'completed_at' => null],
                'konsultasi_pra_uji' => ['completed' => false, 'completed_at' => null],
                'mapa01' => ['completed' => false, 'completed_at' => null],
                'mapa02' => ['completed' => false, 'completed_at' => null],
                'pernyataan_ketidak_berpihakan' => ['completed' => false, 'completed_at' => null],
                'ak07' => ['completed' => false, 'completed_at' => null],
                'ia01' => ['completed' => false, 'completed_at' => null],
                'ia02' => ['completed' => false, 'completed_at' => null],
                'hasil_asesmen' => ['completed' => false, 'completed_at' => null],
                'ak02' => ['completed' => false, 'completed_at' => null],
                'umpan_balik' => ['completed' => false, 'completed_at' => null],
                'ak04' => ['completed' => false, 'completed_at' => null],
            ];

            // Randomly select 2-5 configurable assessments to complete
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $numToComplete = fake()->numberBetween(2, min(5, count($configurableTypes)));
            $typesToComplete = fake()->randomElements($configurableTypes, $numToComplete);
            
            $completedFields = [];
            foreach ($typesToComplete as $type) {
                $fieldName = ProgresAsesmen::getFieldForAssessmentType($type);
                if ($fieldName !== null && isset($progressData[$fieldName])) {
                    $progressData[$fieldName] = ['completed' => true, 'completed_at' => $completedAt];
                    $completedFields[$fieldName] = $type;
                }
            }

            // Skip if no fields were completed
            if (empty($completedFields)) {
                $asesi->delete();
                SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
                $skema->delete();
                continue;
            }

            $progresAsesmen = ProgresAsesmen::create($progressData);

            // Store original completion data
            $originalData = [];
            foreach ($completedFields as $fieldName => $type) {
                $originalData[$fieldName] = [
                    'data' => $progresAsesmen->$fieldName,
                    'completed_at' => $progresAsesmen->getStepCompletionTime($fieldName),
                ];
            }

            // Disable all completed assessments
            $config = [];
            foreach (AssessmentType::getAllTypes() as $type) {
                // Disable completed types, keep others enabled
                $config[$type] = !in_array($type, array_values($completedFields));
            }
            // Ensure mandatory types stay enabled
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Refresh and verify all historical data is retained
            $progresAsesmen->refresh();

            foreach ($completedFields as $fieldName => $type) {
                // Skip mandatory types as they can't be disabled
                if (AssessmentType::isMandatory($type)) {
                    continue;
                }

                // Verify completion status retained
                $this->assertTrue(
                    $progresAsesmen->isStepCompleted($fieldName),
                    "Historical completion status should be retained for {$fieldName}"
                );

                // Verify timestamp retained
                $this->assertEquals(
                    $originalData[$fieldName]['completed_at'],
                    $progresAsesmen->getStepCompletionTime($fieldName),
                    "Historical timestamp should be retained for {$fieldName}"
                );

                // Verify raw data unchanged
                $this->assertEquals(
                    $originalData[$fieldName]['data'],
                    $progresAsesmen->$fieldName,
                    "Historical data should be unchanged for {$fieldName}"
                );
            }

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Re-enabling an assessment preserves historical completion data
     * 
     * For any assessment that was completed, then disabled, then re-enabled,
     * the historical completion data should still be accessible.
     * 
     * @test
     */
    public function reenabling_assessment_preserves_historical_data(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme with all assessments enabled
            $skema = Skema::factory()->create();
            $this->configService->applyDefaultConfig($skema->id_skema);

            // Create asesi with this scheme
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Pick a random configurable assessment type
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $randomType = fake()->randomElement($configurableTypes);
            $fieldName = ProgresAsesmen::getFieldForAssessmentType($randomType);

            if ($fieldName === null) {
                $asesi->delete();
                SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
                $skema->delete();
                continue;
            }

            // Create progress with the assessment completed
            $completedAt = now()->format('d-m-Y H:i:s') . ' WIB';
            $progressData = [
                'id_asesi' => $asesi->id_asesi,
                'apl01' => ['completed' => true, 'completed_at' => $completedAt],
                'apl02' => ['completed' => false, 'completed_at' => null],
                'ak01' => ['completed' => false, 'completed_at' => null],
                'konsultasi_pra_uji' => ['completed' => false, 'completed_at' => null],
                'mapa01' => ['completed' => false, 'completed_at' => null],
                'mapa02' => ['completed' => false, 'completed_at' => null],
                'pernyataan_ketidak_berpihakan' => ['completed' => false, 'completed_at' => null],
                'ak07' => ['completed' => false, 'completed_at' => null],
                'ia01' => ['completed' => false, 'completed_at' => null],
                'ia02' => ['completed' => false, 'completed_at' => null],
                'hasil_asesmen' => ['completed' => false, 'completed_at' => null],
                'ak02' => ['completed' => false, 'completed_at' => null],
                'umpan_balik' => ['completed' => false, 'completed_at' => null],
                'ak04' => ['completed' => false, 'completed_at' => null],
            ];
            $progressData[$fieldName] = ['completed' => true, 'completed_at' => $completedAt];

            $progresAsesmen = ProgresAsesmen::create($progressData);

            // Store original data
            $originalData = $progresAsesmen->$fieldName;
            $originalCompletedAt = $progresAsesmen->getStepCompletionTime($fieldName);

            // Step 1: Disable the assessment
            $config = [];
            foreach (AssessmentType::getAllTypes() as $type) {
                $config[$type] = ($type !== $randomType);
            }
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Verify disabled
            $this->assertFalse(
                $this->configService->isAssessmentEnabled($skema->id_skema, $randomType),
                "Assessment should be disabled"
            );

            // Step 2: Re-enable the assessment
            $config[$randomType] = true;
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Verify re-enabled
            $this->assertTrue(
                $this->configService->isAssessmentEnabled($skema->id_skema, $randomType),
                "Assessment should be re-enabled"
            );

            // Refresh and verify historical data is preserved
            $progresAsesmen->refresh();

            // Verify completion status
            $this->assertTrue(
                $progresAsesmen->isStepCompleted($fieldName),
                "Historical completion status should be preserved after re-enabling {$fieldName}"
            );

            // Verify timestamp
            $this->assertEquals(
                $originalCompletedAt,
                $progresAsesmen->getStepCompletionTime($fieldName),
                "Historical timestamp should be preserved after re-enabling {$fieldName}"
            );

            // Verify raw data
            $this->assertEquals(
                $originalData,
                $progresAsesmen->$fieldName,
                "Historical data should be preserved after re-enabling {$fieldName}"
            );

            // Verify it now appears in enabled assessments progress
            $enabledProgress = $progresAsesmen->getEnabledAssessmentsProgress();
            $this->assertArrayHasKey(
                $fieldName,
                $enabledProgress,
                "Re-enabled assessment {$fieldName} should appear in enabled assessments progress"
            );

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }
}
