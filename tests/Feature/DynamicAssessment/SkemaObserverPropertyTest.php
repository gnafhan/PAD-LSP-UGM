<?php

namespace Tests\Feature\DynamicAssessment;

use App\Enums\AssessmentType;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for SkemaObserver - Default Configuration
 * 
 * **Feature: dynamic-assessment-flow, Property 10: Default Configuration on New Scheme**
 * **Validates: Requirements 7.1**
 * 
 * Property: For any newly created scheme, the system SHALL apply a default
 * assessment tool configuration with APL tools enabled.
 */
class SkemaObserverPropertyTest extends TestCase
{
    use RefreshDatabase;

    private SkemaConfigService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SkemaConfigService();
    }

    /**
     * Property 10: Default Configuration on New Scheme
     * 
     * For any newly created scheme, the system SHALL apply a default
     * assessment tool configuration with all assessments enabled,
     * including mandatory APL tools.
     * 
     * **Feature: dynamic-assessment-flow, Property 10: Default Configuration on New Scheme**
     * **Validates: Requirements 7.1**
     * 
     * @test
     */
    public function new_scheme_gets_default_configuration_with_all_assessments_enabled(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Create a new scheme - observer should automatically create default config
            $skema = Skema::factory()->create();

            // Verify that assessment config records were created
            $configCount = SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->count();
            $expectedCount = count(AssessmentType::getAllTypes());
            
            $this->assertEquals(
                $expectedCount,
                $configCount,
                "New scheme should have {$expectedCount} assessment config records, got {$configCount}"
            );

            // Verify all assessment types are enabled
            foreach (AssessmentType::getAllTypes() as $type) {
                $config = SkemaAssessmentConfig::where('id_skema', $skema->id_skema)
                    ->where('assessment_type', $type)
                    ->first();

                $this->assertNotNull(
                    $config,
                    "Config for {$type} should exist for new scheme"
                );

                $this->assertTrue(
                    $config->is_enabled,
                    "Assessment type {$type} should be enabled by default"
                );
            }

            // Verify mandatory APL types are enabled
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $isEnabled = $this->service->isAssessmentEnabled($skema->id_skema, $mandatoryType);
                $this->assertTrue(
                    $isEnabled,
                    "Mandatory type {$mandatoryType} should be enabled for new scheme"
                );
            }

            // Verify getEnabledAssessments returns all types
            $enabledAssessments = $this->service->getEnabledAssessments($skema->id_skema);
            $allTypes = AssessmentType::getAllTypes();

            foreach ($allTypes as $type) {
                $this->assertTrue(
                    $enabledAssessments->contains($type),
                    "Type {$type} should be in enabled assessments for new scheme"
                );
            }

            // Clean up for next iteration
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Default configuration includes display order
     * 
     * For any newly created scheme, each assessment config should have
     * a valid display_order value.
     * 
     * @test
     */
    public function new_scheme_config_has_valid_display_order(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $skema = Skema::factory()->create();

            // Get all configs ordered by display_order
            $configs = SkemaAssessmentConfig::where('id_skema', $skema->id_skema)
                ->orderBy('display_order', 'asc')
                ->get();

            // Verify display_order values are sequential and non-negative
            $previousOrder = -1;
            foreach ($configs as $config) {
                $this->assertGreaterThanOrEqual(
                    0,
                    $config->display_order,
                    "Display order should be non-negative"
                );
                $this->assertGreaterThan(
                    $previousOrder,
                    $config->display_order,
                    "Display order should be sequential"
                );
                $previousOrder = $config->display_order;
            }

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Scheme deletion cleans up config
     * 
     * For any scheme that is deleted, the associated assessment
     * configuration records should also be deleted.
     * 
     * @test
     */
    public function scheme_deletion_removes_assessment_config(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create scheme (observer creates config)
            $skema = Skema::factory()->create();
            $idSkema = $skema->id_skema;

            // Verify config exists
            $configCountBefore = SkemaAssessmentConfig::where('id_skema', $idSkema)->count();
            $this->assertGreaterThan(
                0,
                $configCountBefore,
                "Config should exist before deletion"
            );

            // Delete scheme (observer should clean up config)
            $skema->delete();

            // Verify config is deleted
            $configCountAfter = SkemaAssessmentConfig::where('id_skema', $idSkema)->count();
            $this->assertEquals(
                0,
                $configCountAfter,
                "Config should be deleted after scheme deletion"
            );
        }
    }

    /**
     * Property: Multiple scheme creation creates independent configs
     * 
     * For any two newly created schemes, each should have its own
     * independent assessment configuration.
     * 
     * @test
     */
    public function multiple_schemes_have_independent_configs(): void
    {
        for ($i = 0; $i < 50; $i++) {
            // Create two schemes
            $skema1 = Skema::factory()->create();
            $skema2 = Skema::factory()->create();

            // Verify each has its own config
            $config1Count = SkemaAssessmentConfig::where('id_skema', $skema1->id_skema)->count();
            $config2Count = SkemaAssessmentConfig::where('id_skema', $skema2->id_skema)->count();

            $this->assertEquals(
                count(AssessmentType::getAllTypes()),
                $config1Count,
                "Scheme 1 should have full config"
            );
            $this->assertEquals(
                count(AssessmentType::getAllTypes()),
                $config2Count,
                "Scheme 2 should have full config"
            );

            // Modify one scheme's config
            $randomType = fake()->randomElement(AssessmentType::getConfigurableTypes());
            SkemaAssessmentConfig::where('id_skema', $skema1->id_skema)
                ->where('assessment_type', $randomType)
                ->update(['is_enabled' => false]);

            // Verify the other scheme's config is unchanged
            $skema2Config = SkemaAssessmentConfig::where('id_skema', $skema2->id_skema)
                ->where('assessment_type', $randomType)
                ->first();

            $this->assertTrue(
                $skema2Config->is_enabled,
                "Scheme 2's config should be independent and unchanged"
            );

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema1->id_skema)->delete();
            SkemaAssessmentConfig::where('id_skema', $skema2->id_skema)->delete();
            $skema1->delete();
            $skema2->delete();
        }
    }
}
