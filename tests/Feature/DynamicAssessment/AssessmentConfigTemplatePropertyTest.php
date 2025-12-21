<?php

namespace Tests\Feature\DynamicAssessment;

use App\Enums\AssessmentType;
use App\Models\AssessmentConfigTemplate;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for AssessmentConfigTemplate
 * 
 * **Feature: dynamic-assessment-flow, Property 11: Template Application Copies Configuration**
 * **Feature: dynamic-assessment-flow, Property 12: Template Isolation**
 * **Validates: Requirements 7.3, 7.4**
 */
class AssessmentConfigTemplatePropertyTest extends TestCase
{
    use RefreshDatabase;

    private SkemaConfigService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SkemaConfigService();
    }

    /**
     * Property 11: Template Application Copies Configuration
     * 
     * For any template applied to a scheme, the scheme's configuration SHALL
     * match the template's configuration after application.
     * 
     * **Feature: dynamic-assessment-flow, Property 11: Template Application Copies Configuration**
     * **Validates: Requirements 7.3**
     * 
     * @test
     */
    public function template_application_copies_configuration_to_scheme(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Generate random template with random configuration
            $template = AssessmentConfigTemplate::factory()->create();
            
            // Generate random scheme
            $skema = Skema::factory()->create();

            // Apply template to scheme
            $result = $this->service->applyTemplate($skema->id_skema, $template->id);
            $this->assertTrue($result, "Template application should succeed");

            // Get the template's configuration (with mandatory types enforced)
            $templateConfig = $template->getConfigWithMandatoryTypes();

            // Verify each assessment type in scheme matches template
            foreach ($templateConfig as $assessmentType => $expectedEnabled) {
                $actualEnabled = $this->service->isAssessmentEnabled($skema->id_skema, $assessmentType);
                
                // For mandatory types, should always be true
                if (AssessmentType::isMandatory($assessmentType)) {
                    $this->assertTrue(
                        $actualEnabled,
                        "Mandatory type {$assessmentType} should always be enabled after template application"
                    );
                } else {
                    $this->assertEquals(
                        $expectedEnabled,
                        $actualEnabled,
                        "Assessment type {$assessmentType} should match template config (expected: " . 
                        ($expectedEnabled ? 'true' : 'false') . ")"
                    );
                }
            }

            // Verify getEnabledAssessments returns correct set
            $enabledAssessments = $this->service->getEnabledAssessments($skema->id_skema);
            $templateEnabledTypes = $template->getEnabledTypes();

            // All mandatory types should be in enabled list
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $this->assertTrue(
                    $enabledAssessments->contains($mandatoryType),
                    "Mandatory type {$mandatoryType} should be in enabled assessments after template application"
                );
            }

            // Configurable types should match template
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $expectedInEnabled = in_array($type, $templateEnabledTypes, true);
                $actualInEnabled = $enabledAssessments->contains($type);
                
                $this->assertEquals(
                    $expectedInEnabled,
                    $actualInEnabled,
                    "Type {$type} enabled status should match template"
                );
            }

            // Clean up for next iteration
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
            $template->delete();
        }
    }

    /**
     * Property 12: Template Isolation
     * 
     * For any template modification, schemes that previously used the template
     * SHALL retain their original configuration unchanged.
     * 
     * **Feature: dynamic-assessment-flow, Property 12: Template Isolation**
     * **Validates: Requirements 7.4**
     * 
     * @test
     */
    public function template_modification_does_not_affect_schemes_that_used_it(): void
    {
        // Run property test 100 times with random data
        for ($i = 0; $i < 100; $i++) {
            // Generate random template
            $template = AssessmentConfigTemplate::factory()->create();
            
            // Generate random scheme
            $skema = Skema::factory()->create();

            // Apply template to scheme
            $this->service->applyTemplate($skema->id_skema, $template->id);

            // Capture the scheme's configuration after template application
            $schemeConfigBefore = [];
            foreach (AssessmentType::getAllTypes() as $type) {
                $schemeConfigBefore[$type] = $this->service->isAssessmentEnabled($skema->id_skema, $type);
            }

            // Modify the template with new random configuration
            $newConfig = [];
            foreach (AssessmentType::getMandatoryTypes() as $type) {
                $newConfig[$type] = true; // Mandatory always true
            }
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                // Flip the configuration to ensure it's different
                $currentValue = $template->config_data[$type] ?? false;
                $newConfig[$type] = !$currentValue;
            }
            
            $template->config_data = $newConfig;
            $template->save();

            // Verify scheme's configuration is unchanged after template modification
            foreach (AssessmentType::getAllTypes() as $type) {
                $schemeConfigAfter = $this->service->isAssessmentEnabled($skema->id_skema, $type);
                
                $this->assertEquals(
                    $schemeConfigBefore[$type],
                    $schemeConfigAfter,
                    "Scheme config for {$type} should be unchanged after template modification " .
                    "(before: " . ($schemeConfigBefore[$type] ? 'true' : 'false') . 
                    ", after: " . ($schemeConfigAfter ? 'true' : 'false') . ")"
                );
            }

            // Clean up for next iteration
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
            $template->delete();
        }
    }

    /**
     * Property: Template always enforces APL mandatory types
     * 
     * For any template, APL types should always be enabled in the configuration.
     * 
     * @test
     */
    public function template_always_enforces_apl_mandatory_types(): void
    {
        for ($i = 0; $i < 100; $i++) {
            // Create template with random config that tries to disable APL
            $config = [];
            foreach (AssessmentType::getMandatoryTypes() as $type) {
                $config[$type] = fake()->boolean(); // Randomly try to disable
            }
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $config[$type] = fake()->boolean();
            }

            $template = AssessmentConfigTemplate::create([
                'name' => fake()->unique()->words(3, true),
                'description' => fake()->sentence(),
                'config_data' => $config,
                'is_default' => false,
            ]);

            // Verify APL types are always enabled after save
            $savedConfig = $template->fresh()->config_data;
            
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $this->assertTrue(
                    $savedConfig[$mandatoryType] ?? false,
                    "Mandatory type {$mandatoryType} should always be enabled in template"
                );
            }

            // Also verify getConfigWithMandatoryTypes returns APL as enabled
            $configWithMandatory = $template->getConfigWithMandatoryTypes();
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $this->assertTrue(
                    $configWithMandatory[$mandatoryType],
                    "getConfigWithMandatoryTypes should return {$mandatoryType} as enabled"
                );
            }

            // Clean up
            $template->delete();
        }
    }

    /**
     * Property: Applying same template multiple times is idempotent
     * 
     * For any scheme and template, applying the same template multiple times
     * should result in the same configuration.
     * 
     * @test
     */
    public function applying_same_template_multiple_times_is_idempotent(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $template = AssessmentConfigTemplate::factory()->create();
            $skema = Skema::factory()->create();

            // Apply template first time
            $this->service->applyTemplate($skema->id_skema, $template->id);
            
            // Capture configuration after first application
            $configAfterFirst = [];
            foreach (AssessmentType::getAllTypes() as $type) {
                $configAfterFirst[$type] = $this->service->isAssessmentEnabled($skema->id_skema, $type);
            }

            // Apply template second time
            $this->service->applyTemplate($skema->id_skema, $template->id);

            // Verify configuration is the same
            foreach (AssessmentType::getAllTypes() as $type) {
                $configAfterSecond = $this->service->isAssessmentEnabled($skema->id_skema, $type);
                
                $this->assertEquals(
                    $configAfterFirst[$type],
                    $configAfterSecond,
                    "Config for {$type} should be same after applying template twice"
                );
            }

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
            $template->delete();
        }
    }
}
