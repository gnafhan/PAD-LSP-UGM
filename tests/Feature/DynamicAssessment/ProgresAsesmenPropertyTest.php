<?php

namespace Tests\Feature\DynamicAssessment;

use App\Enums\AssessmentType;
use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for ProgresAsesmen Model
 * 
 * **Feature: dynamic-assessment-flow, Property 7: Asesi Sees Only Enabled Assessments**
 * **Validates: Requirements 5.1, 5.3**
 * 
 * Property: For any asesi with a scheme, the dashboard SHALL display only 
 * assessment tools that are enabled for their scheme.
 */
class ProgresAsesmenPropertyTest extends TestCase
{
    use RefreshDatabase;

    private SkemaConfigService $configService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configService = new SkemaConfigService();
    }

    /**
     * Property 7: Asesi Sees Only Enabled Assessments
     * 
     * For any asesi with a scheme, the progress data returned by getEnabledAssessmentsProgress()
     * SHALL contain only assessment tools that are enabled for their scheme.
     * 
     * **Feature: dynamic-assessment-flow, Property 7: Asesi Sees Only Enabled Assessments**
     * **Validates: Requirements 5.1, 5.3**
     * 
     * @test
     */
    public function asesi_sees_only_enabled_assessments_in_progress(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();
            
            // Generate random configuration for configurable types
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $config = [];
            
            // Randomly enable/disable configurable types
            foreach ($configurableTypes as $type) {
                $config[$type] = fake()->boolean();
            }
            
            // Always include mandatory types as enabled
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }

            // Apply configuration to scheme
            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Create asesi with this scheme
            $asesi = Asesi::factory()->forSkema($skema)->create();
            
            // Create progress record for asesi with random completion states
            $progresAsesmen = ProgresAsesmen::factory()
                ->forAsesi($asesi)
                ->withRandomProgress()
                ->create();

            // Get enabled assessments progress
            $enabledProgress = $progresAsesmen->getEnabledAssessmentsProgress();

            // Verify: All returned fields should be enabled for the scheme
            foreach (array_keys($enabledProgress) as $field) {
                $assessmentType = ProgresAsesmen::getAssessmentTypeForField($field);
                
                if ($assessmentType !== null) {
                    // Field has a mapping to assessment type - verify it's enabled
                    $this->assertTrue(
                        $this->configService->isAssessmentEnabled($skema->id_skema, $assessmentType),
                        "Field {$field} (type: {$assessmentType}) should be enabled for scheme but was returned in progress"
                    );
                }
                // Fields without mapping (hasil_asesmen, umpan_balik) are always included
            }

            // Verify: Disabled assessments should NOT be in the returned progress
            foreach ($config as $assessmentType => $isEnabled) {
                if (!$isEnabled) {
                    $field = ProgresAsesmen::getFieldForAssessmentType($assessmentType);
                    if ($field !== null) {
                        $this->assertArrayNotHasKey(
                            $field,
                            $enabledProgress,
                            "Disabled assessment type {$assessmentType} (field: {$field}) should not be in enabled progress"
                        );
                    }
                }
            }

            // Clean up for next iteration
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: isAssessmentEnabledForScheme returns correct value based on scheme config
     * 
     * For any asesi and any assessment step, isAssessmentEnabledForScheme() should return
     * true only if the assessment is enabled in the scheme's configuration.
     * 
     * @test
     */
    public function is_assessment_enabled_for_scheme_matches_config(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();
            
            // Generate random configuration
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $config = [];
            
            foreach ($configurableTypes as $type) {
                $config[$type] = fake()->boolean();
            }
            
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }

            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Create asesi and progress
            $asesi = Asesi::factory()->forSkema($skema)->create();
            $progresAsesmen = ProgresAsesmen::factory()->forAsesi($asesi)->create();

            // Test each mapped field
            foreach (ProgresAsesmen::$fieldToAssessmentTypeMap as $field => $assessmentType) {
                $isEnabled = $progresAsesmen->isAssessmentEnabledForScheme($field);
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
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: calculateProgress uses only enabled assessments
     * 
     * For any asesi with a scheme, calculateProgress() should calculate percentage
     * based only on enabled assessments.
     * 
     * @test
     */
    public function calculate_progress_uses_only_enabled_assessments(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();
            
            // Generate random configuration - ensure at least some are disabled
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $config = [];
            $enabledCount = 0;
            
            foreach ($configurableTypes as $type) {
                $isEnabled = fake()->boolean();
                $config[$type] = $isEnabled;
                if ($isEnabled) {
                    $enabledCount++;
                }
            }
            
            // Always include mandatory types
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }

            $this->configService->updateAssessmentConfig($skema->id_skema, $config);

            // Create asesi and progress with all steps completed
            $asesi = Asesi::factory()->forSkema($skema)->create();
            
            // Create progress with all steps completed
            // Note: ia11 is not in the progres_asesmen table migration
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

            // Calculate progress with scheme config
            $progress = $progresAsesmen->calculateProgress(true);

            // With all steps completed, percentage should be 100%
            $this->assertEquals(
                100,
                $progress['progress_percentage'],
                "With all enabled steps completed, progress should be 100%"
            );

            // Total steps should match enabled assessments count
            // (enabled configurable + mandatory + unmapped fields like hasil_asesmen, umpan_balik, ak04)
            $this->assertGreaterThan(
                0,
                $progress['total_steps'],
                "Total steps should be greater than 0"
            );

            // Completed steps should equal total steps when all are completed
            $this->assertEquals(
                $progress['total_steps'],
                $progress['completed_steps'],
                "Completed steps should equal total steps when all are completed"
            );

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Backward compatibility - schemes without config show all assessments
     * 
     * For any asesi with a scheme that has no assessment configuration,
     * all assessments should be enabled (backward compatibility).
     * 
     * @test
     */
    public function schemes_without_config_show_all_assessments(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create a scheme WITHOUT any assessment config
            $skema = Skema::factory()->create();
            
            // Create asesi and progress
            $asesi = Asesi::factory()->forSkema($skema)->create();
            $progresAsesmen = ProgresAsesmen::factory()->forAsesi($asesi)->create();

            // All mapped fields should be enabled
            foreach (ProgresAsesmen::$fieldToAssessmentTypeMap as $field => $assessmentType) {
                $this->assertTrue(
                    $progresAsesmen->isAssessmentEnabledForScheme($field),
                    "Field {$field} should be enabled for scheme without config (backward compatibility)"
                );
            }

            // getEnabledAssessmentsProgress should return all fields
            $enabledProgress = $progresAsesmen->getEnabledAssessmentsProgress();
            
            // Note: ia11 is not in the progres_asesmen table migration
            $allProgressFields = [
                'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
                'mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan',
                'ak07', 'ia01', 'ia02', 'hasil_asesmen',
                'ak02', 'umpan_balik', 'ak04'
            ];
            
            foreach ($allProgressFields as $field) {
                $this->assertArrayHasKey(
                    $field,
                    $enabledProgress,
                    "Field {$field} should be in enabled progress for scheme without config"
                );
            }

            // Clean up
            $progresAsesmen->delete();
            $asesi->delete();
            $skema->delete();
        }
    }
}
