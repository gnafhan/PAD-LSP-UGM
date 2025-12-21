<?php

namespace Tests\Feature\DynamicAssessment;

use App\Enums\AssessmentType;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for SkemaConfigService
 * 
 * **Feature: dynamic-assessment-flow, Property 2: Assessment Configuration Persistence**
 * **Validates: Requirements 1.2, 2.3**
 * 
 * Property: For any scheme and any assessment type, toggling the enabled state
 * SHALL persist correctly to the database and be retrievable.
 */
class SkemaConfigServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    private SkemaConfigService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SkemaConfigService();
    }

    /**
     * Property 2: Assessment Configuration Persistence
     * 
     * For any scheme and any assessment type, toggling the enabled state
     * SHALL persist correctly to the database and be retrievable.
     * 
     * **Feature: dynamic-assessment-flow, Property 2: Assessment Configuration Persistence**
     * **Validates: Requirements 1.2, 2.3**
     * 
     * @test
     */
    public function configuration_persists_correctly_for_any_scheme_and_assessment_type(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Generate random scheme
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

            // Update configuration
            $result = $this->service->updateAssessmentConfig($skema->id_skema, $config);
            $this->assertTrue($result, "Configuration update should succeed");

            // Verify each assessment type persisted correctly
            foreach ($config as $assessmentType => $expectedEnabled) {
                $actualEnabled = $this->service->isAssessmentEnabled($skema->id_skema, $assessmentType);
                
                // For mandatory types, should always be true
                if (AssessmentType::isMandatory($assessmentType)) {
                    $this->assertTrue(
                        $actualEnabled,
                        "Mandatory type {$assessmentType} should always be enabled"
                    );
                } else {
                    $this->assertEquals(
                        $expectedEnabled,
                        $actualEnabled,
                        "Assessment type {$assessmentType} should have is_enabled={$expectedEnabled}"
                    );
                }
            }

            // Verify getEnabledAssessments returns correct set
            $enabledAssessments = $this->service->getEnabledAssessments($skema->id_skema);
            
            // All mandatory types should be in enabled list
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $this->assertTrue(
                    $enabledAssessments->contains($mandatoryType),
                    "Mandatory type {$mandatoryType} should be in enabled assessments"
                );
            }

            // Configurable types should match their config
            foreach ($configurableTypes as $type) {
                if ($config[$type]) {
                    $this->assertTrue(
                        $enabledAssessments->contains($type),
                        "Enabled type {$type} should be in enabled assessments"
                    );
                } else {
                    $this->assertFalse(
                        $enabledAssessments->contains($type),
                        "Disabled type {$type} should not be in enabled assessments"
                    );
                }
            }

            // Clean up for next iteration
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }


    /**
     * Property: Configuration toggle round-trip
     * 
     * For any scheme and any configurable assessment type, toggling from
     * enabled to disabled and back should result in the original state.
     * 
     * @test
     */
    public function configuration_toggle_round_trip_preserves_state(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $skema = Skema::factory()->create();
            
            // Pick a random configurable type
            $configurableTypes = AssessmentType::getConfigurableTypes();
            $randomType = fake()->randomElement($configurableTypes);
            $initialState = fake()->boolean();

            // Set initial state
            $config = [$randomType => $initialState];
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            $this->service->updateAssessmentConfig($skema->id_skema, $config);

            // Verify initial state
            $this->assertEquals(
                $initialState,
                $this->service->isAssessmentEnabled($skema->id_skema, $randomType),
                "Initial state should be {$initialState}"
            );

            // Toggle to opposite state
            $config[$randomType] = !$initialState;
            $this->service->updateAssessmentConfig($skema->id_skema, $config);

            // Verify toggled state
            $this->assertEquals(
                !$initialState,
                $this->service->isAssessmentEnabled($skema->id_skema, $randomType),
                "Toggled state should be " . (!$initialState ? 'true' : 'false')
            );

            // Toggle back to original state
            $config[$randomType] = $initialState;
            $this->service->updateAssessmentConfig($skema->id_skema, $config);

            // Verify round-trip
            $this->assertEquals(
                $initialState,
                $this->service->isAssessmentEnabled($skema->id_skema, $randomType),
                "Round-trip should restore original state {$initialState}"
            );

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: APL types cannot be disabled via updateAssessmentConfig
     * 
     * For any scheme, attempting to disable APL types should throw an exception.
     * 
     * @test
     */
    public function apl_types_cannot_be_disabled_via_service(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $skema = Skema::factory()->create();
            
            // Pick a random mandatory type
            $mandatoryTypes = AssessmentType::getMandatoryTypes();
            $randomMandatoryType = fake()->randomElement($mandatoryTypes);

            // Attempt to disable mandatory type
            $config = [$randomMandatoryType => false];

            $exceptionThrown = false;
            try {
                $this->service->updateAssessmentConfig($skema->id_skema, $config);
            } catch (\InvalidArgumentException $e) {
                $exceptionThrown = true;
                $this->assertStringContainsString(
                    'cannot be disabled',
                    $e->getMessage(),
                    "Exception message should mention cannot be disabled"
                );
            }

            $this->assertTrue(
                $exceptionThrown,
                "Attempting to disable {$randomMandatoryType} should throw InvalidArgumentException"
            );

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: getDefaultConfig returns all types enabled
     * 
     * The default configuration should have all assessment types enabled.
     * 
     * @test
     */
    public function default_config_has_all_types_enabled(): void
    {
        $defaultConfig = $this->service->getDefaultConfig();

        // All types should be present and enabled
        foreach (AssessmentType::getAllTypes() as $type) {
            $this->assertArrayHasKey(
                $type,
                $defaultConfig,
                "Default config should contain {$type}"
            );
            $this->assertTrue(
                $defaultConfig[$type],
                "Default config should have {$type} enabled"
            );
        }
    }

    /**
     * Property: getEnabledAssessments always includes mandatory types
     * 
     * For any scheme configuration, getEnabledAssessments should always
     * include mandatory APL types.
     * 
     * @test
     */
    public function get_enabled_assessments_always_includes_mandatory_types(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $skema = Skema::factory()->create();
            
            // Create random config with all configurable types disabled
            $config = [];
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $config[$type] = false;
            }
            // Must include mandatory types as enabled to pass validation
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }

            $this->service->updateAssessmentConfig($skema->id_skema, $config);

            // Get enabled assessments
            $enabledAssessments = $this->service->getEnabledAssessments($skema->id_skema);

            // Mandatory types should always be present
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $this->assertTrue(
                    $enabledAssessments->contains($mandatoryType),
                    "Mandatory type {$mandatoryType} should always be in enabled assessments"
                );
            }

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }
}
