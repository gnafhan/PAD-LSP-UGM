<?php

namespace Tests\Feature\DynamicAssessment;

use App\Enums\AssessmentType;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\AsesiDashboardService;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for AsesiDashboardService
 * 
 * **Feature: dynamic-assessment-flow, Property 8: Asesi Content Matches Scheme**
 * **Validates: Requirements 5.2**
 * 
 * Property: For any asesi accessing an assessment tool, the loaded content SHALL be
 * specific to their scheme.
 */
class AsesiDashboardServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    private AsesiDashboardService $asesiDashboardService;
    private SkemaConfigService $skemaConfigService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skemaConfigService = new SkemaConfigService();
        $this->asesiDashboardService = new AsesiDashboardService($this->skemaConfigService);
    }

    /**
     * Property 8: Asesi Content Matches Scheme
     * 
     * For any asesi with a scheme, the dashboard SHALL display only assessment tools
     * that are enabled for their scheme, and APL tools are always included.
     * 
     * **Feature: dynamic-assessment-flow, Property 8: Asesi Content Matches Scheme**
     * **Validates: Requirements 5.2**
     * 
     * @test
     */
    public function asesi_content_matches_scheme_configuration(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Generate random scheme
            $skema = Skema::factory()->create();
            
            // Generate random configuration for configurable types
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $config = [];
            
            // Randomly enable/disable configurable types
            $enabledTypes = [];
            $disabledTypes = [];
            foreach ($configurableTypes as $type) {
                $isEnabled = fake()->boolean();
                $config[$type] = $isEnabled;
                if ($isEnabled) {
                    $enabledTypes[] = $type;
                } else {
                    $disabledTypes[] = $type;
                }
            }
            
            // Always include mandatory types as enabled (required by service)
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }

            // Update configuration
            $this->skemaConfigService->updateAssessmentConfig($skema->id_skema, $config);

            // Create an asesi with this scheme
            $asesi = Asesi::factory()->create([
                'id_skema' => $skema->id_skema,
            ]);

            // Get filtered assessment sections for the asesi
            $sections = $this->asesiDashboardService->getFilteredAssessmentSections($asesi);

            // Collect all assessment types shown in sections
            $shownAssessmentTypes = [];
            foreach ($sections as $section) {
                foreach ($section['items'] as $itemKey => $item) {
                    if (isset($item['assessment_type']) && $item['assessment_type'] !== null) {
                        $shownAssessmentTypes[] = $item['assessment_type'];
                    }
                }
            }

            // Property 1: All mandatory types (APL01, APL02) should always be shown
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $this->assertContains(
                    $mandatoryType,
                    $shownAssessmentTypes,
                    "Mandatory type {$mandatoryType} should always be shown for asesi"
                );
            }

            // Property 2: Enabled configurable types that exist in dashboard should be shown
            foreach ($enabledTypes as $enabledType) {
                // Only check types that are defined in the dashboard structure
                $fieldMap = $this->asesiDashboardService->getFieldToAssessmentTypeMap();
                if (in_array($enabledType, $fieldMap, true)) {
                    $this->assertContains(
                        $enabledType,
                        $shownAssessmentTypes,
                        "Enabled type {$enabledType} should be shown for asesi"
                    );
                }
            }

            // Property 3: Disabled configurable types should NOT be shown (unless mandatory)
            foreach ($disabledTypes as $disabledType) {
                // Skip mandatory types
                if (AssessmentType::isMandatory($disabledType)) {
                    continue;
                }
                // Only check types that are defined in the dashboard structure
                $fieldMap = $this->asesiDashboardService->getFieldToAssessmentTypeMap();
                if (in_array($disabledType, $fieldMap, true)) {
                    $this->assertNotContains(
                        $disabledType,
                        $shownAssessmentTypes,
                        "Disabled type {$disabledType} should NOT be shown for asesi"
                    );
                }
            }

            // Clean up for next iteration
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $asesi->delete();
            $skema->delete();
        }
    }

    /**
     * Property: isAssessmentEnabledForAsesi returns correct value for any assessment type
     * 
     * @test
     */
    public function is_assessment_enabled_for_asesi_returns_correct_value(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Generate random scheme
            $skema = Skema::factory()->create();
            
            // Generate random configuration
            $config = [];
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $config[$type] = fake()->boolean();
            }
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }

            $this->skemaConfigService->updateAssessmentConfig($skema->id_skema, $config);

            // Create an asesi with this scheme
            $asesi = Asesi::factory()->create([
                'id_skema' => $skema->id_skema,
            ]);

            // Test each assessment type
            foreach (AssessmentType::getAllTypes() as $type) {
                $isEnabled = $this->asesiDashboardService->isAssessmentEnabledForAsesi($asesi, $type);
                
                if (AssessmentType::isMandatory($type)) {
                    // Mandatory types should always be enabled
                    $this->assertTrue(
                        $isEnabled,
                        "Mandatory type {$type} should always be enabled for asesi"
                    );
                } else {
                    // Configurable types should match their config
                    $expectedEnabled = $config[$type];
                    $this->assertEquals(
                        $expectedEnabled,
                        $isEnabled,
                        "Type {$type} enabled status should match config (expected: " . ($expectedEnabled ? 'true' : 'false') . ")"
                    );
                }
            }

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $asesi->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Asesi without scheme gets all assessments (backward compatibility)
     * 
     * @test
     */
    public function asesi_without_scheme_gets_all_assessments(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create an asesi without a scheme
            $asesi = Asesi::factory()->create([
                'id_skema' => null,
            ]);

            // Get filtered assessment sections
            $sections = $this->asesiDashboardService->getFilteredAssessmentSections($asesi);

            // Should get all sections (backward compatibility)
            $allSections = $this->asesiDashboardService->getAllAssessmentSections();
            
            // The number of sections should be the same
            $this->assertCount(
                count($allSections),
                $sections,
                "Asesi without scheme should get all assessment sections"
            );

            // All assessment types should be enabled
            foreach (AssessmentType::getAllTypes() as $type) {
                $isEnabled = $this->asesiDashboardService->isAssessmentEnabledForAsesi($asesi, $type);
                $this->assertTrue(
                    $isEnabled,
                    "Type {$type} should be enabled for asesi without scheme (backward compatibility)"
                );
            }

            // Clean up
            $asesi->delete();
        }
    }

    /**
     * Property: Different asesis with different schemes see different assessments
     * 
     * @test
     */
    public function different_asesis_see_different_assessments_based_on_scheme(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create two schemes with different configurations
            $skema1 = Skema::factory()->create();
            $skema2 = Skema::factory()->create();

            // Pick a random configurable type to test
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $testType = fake()->randomElement($configurableTypes);

            // Configure scheme1 with testType enabled
            $config1 = [];
            foreach ($configurableTypes as $type) {
                $config1[$type] = ($type === $testType);
            }
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config1[$mandatoryType] = true;
            }
            $this->skemaConfigService->updateAssessmentConfig($skema1->id_skema, $config1);

            // Configure scheme2 with testType disabled
            $config2 = [];
            foreach ($configurableTypes as $type) {
                $config2[$type] = ($type !== $testType);
            }
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config2[$mandatoryType] = true;
            }
            $this->skemaConfigService->updateAssessmentConfig($skema2->id_skema, $config2);

            // Create asesis for each scheme
            $asesi1 = Asesi::factory()->create(['id_skema' => $skema1->id_skema]);
            $asesi2 = Asesi::factory()->create(['id_skema' => $skema2->id_skema]);

            // Check that testType is enabled for asesi1 but not for asesi2
            $this->assertTrue(
                $this->asesiDashboardService->isAssessmentEnabledForAsesi($asesi1, $testType),
                "Type {$testType} should be enabled for asesi1"
            );
            $this->assertFalse(
                $this->asesiDashboardService->isAssessmentEnabledForAsesi($asesi2, $testType),
                "Type {$testType} should NOT be enabled for asesi2"
            );

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema1->id_skema)->delete();
            SkemaAssessmentConfig::where('id_skema', $skema2->id_skema)->delete();
            $asesi1->delete();
            $asesi2->delete();
            $skema1->delete();
            $skema2->delete();
        }
    }
}
