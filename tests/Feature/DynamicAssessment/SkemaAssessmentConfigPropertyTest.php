<?php

namespace Tests\Feature\DynamicAssessment;

use App\Models\SkemaAssessmentConfig;
use App\Models\Skema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for SkemaAssessmentConfig
 * 
 * **Feature: dynamic-assessment-flow, Property 1: APL Tools Mandatory Invariant**
 * **Validates: Requirements 1.3, 2.4**
 * 
 * Property: For any scheme and any configuration update operation, 
 * APL tools (APL01, APL02) SHALL remain enabled and cannot be disabled.
 */
class SkemaAssessmentConfigPropertyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 1: APL Tools Mandatory Invariant
     * 
     * For any scheme and any configuration update operation,
     * APL tools (APL01, APL02) SHALL remain enabled and cannot be disabled.
     * 
     * **Feature: dynamic-assessment-flow, Property 1: APL Tools Mandatory Invariant**
     * **Validates: Requirements 1.3, 2.4**
     * 
     * @test
     */
    public function apl_tools_remain_enabled_for_any_scheme_and_configuration(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Generate random scheme (SkemaObserver creates default configs automatically)
            $skema = Skema::factory()->create();

            // For each mandatory APL type
            foreach (SkemaAssessmentConfig::MANDATORY_TYPES as $aplType) {
                // Get the existing config created by SkemaObserver
                $config = SkemaAssessmentConfig::where('id_skema', $skema->id_skema)
                    ->where('assessment_type', $aplType)
                    ->first();

                // Assert: APL type must be enabled by default
                $this->assertNotNull($config, "APL type {$aplType} config should exist for scheme");
                $this->assertTrue(
                    $config->is_enabled,
                    "APL type {$aplType} should be enabled by default"
                );

                // Test 1: Updating to is_enabled = false should result in is_enabled = true
                $config->is_enabled = false;
                $config->save();

                // Refresh and verify
                $config->refresh();
                $this->assertTrue(
                    $config->is_enabled,
                    "APL type {$aplType} should remain enabled after update attempt to disable"
                );

                // Test 2: Using update() method should also enforce the constraint
                $config->update(['is_enabled' => false]);
                $config->refresh();
                $this->assertTrue(
                    $config->is_enabled,
                    "APL type {$aplType} should remain enabled after update() with is_enabled=false"
                );
            }

            // Clean up for next iteration
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Non-APL assessment types can be freely enabled/disabled
     * 
     * For any scheme and any non-APL assessment type, the is_enabled state
     * should persist exactly as set.
     * 
     * @test
     */
    public function non_apl_types_can_be_enabled_or_disabled(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Generate random scheme (SkemaObserver creates default configs automatically)
            $skema = Skema::factory()->create();
            
            // Get a random configurable (non-APL) type
            $configurableTypes = SkemaAssessmentConfig::getConfigurableTypes();
            $randomType = fake()->randomElement($configurableTypes);
            $randomEnabled = fake()->boolean();

            // Get the existing config created by SkemaObserver
            $config = SkemaAssessmentConfig::where('id_skema', $skema->id_skema)
                ->where('assessment_type', $randomType)
                ->first();

            // Assert: Config should exist from observer
            $this->assertNotNull($config, "Config for {$randomType} should exist for scheme");

            // Update to random enabled state
            $config->update(['is_enabled' => $randomEnabled]);
            $config->refresh();

            // Assert: Non-APL type should have the exact is_enabled value we set
            $this->assertEquals(
                $randomEnabled,
                $config->is_enabled,
                "Non-APL type {$randomType} should have is_enabled={$randomEnabled}"
            );

            // Test toggling
            $newEnabled = !$randomEnabled;
            $config->update(['is_enabled' => $newEnabled]);
            $config->refresh();
            $this->assertEquals(
                $newEnabled,
                $config->is_enabled,
                "Non-APL type {$randomType} should be toggleable to is_enabled={$newEnabled}"
            );

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: isMandatoryType correctly identifies APL types
     * 
     * @test
     */
    public function is_mandatory_type_correctly_identifies_apl_types(): void
    {
        // All APL types should be identified as mandatory
        foreach (SkemaAssessmentConfig::MANDATORY_TYPES as $aplType) {
            $this->assertTrue(
                SkemaAssessmentConfig::isMandatoryType($aplType),
                "{$aplType} should be identified as mandatory"
            );
        }

        // All non-APL types should not be identified as mandatory
        foreach (SkemaAssessmentConfig::getConfigurableTypes() as $type) {
            $this->assertFalse(
                SkemaAssessmentConfig::isMandatoryType($type),
                "{$type} should not be identified as mandatory"
            );
        }
    }

    /**
     * Property: validateMandatoryConstraint returns correct validation result
     * 
     * @test
     */
    public function validate_mandatory_constraint_returns_correct_result(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Test APL types with is_enabled = false should fail validation
            foreach (SkemaAssessmentConfig::MANDATORY_TYPES as $aplType) {
                $config = new SkemaAssessmentConfig([
                    'assessment_type' => $aplType,
                    'is_enabled' => false,
                ]);
                
                $this->assertFalse(
                    $config->validateMandatoryConstraint(),
                    "APL type {$aplType} with is_enabled=false should fail validation"
                );
            }

            // Test APL types with is_enabled = true should pass validation
            foreach (SkemaAssessmentConfig::MANDATORY_TYPES as $aplType) {
                $config = new SkemaAssessmentConfig([
                    'assessment_type' => $aplType,
                    'is_enabled' => true,
                ]);
                
                $this->assertTrue(
                    $config->validateMandatoryConstraint(),
                    "APL type {$aplType} with is_enabled=true should pass validation"
                );
            }

            // Test non-APL types should always pass validation regardless of is_enabled
            $configurableTypes = SkemaAssessmentConfig::getConfigurableTypes();
            $randomType = fake()->randomElement($configurableTypes);
            
            $configEnabled = new SkemaAssessmentConfig([
                'assessment_type' => $randomType,
                'is_enabled' => true,
            ]);
            $this->assertTrue(
                $configEnabled->validateMandatoryConstraint(),
                "Non-APL type {$randomType} with is_enabled=true should pass validation"
            );

            $configDisabled = new SkemaAssessmentConfig([
                'assessment_type' => $randomType,
                'is_enabled' => false,
            ]);
            $this->assertTrue(
                $configDisabled->validateMandatoryConstraint(),
                "Non-APL type {$randomType} with is_enabled=false should pass validation"
            );
        }
    }
}
