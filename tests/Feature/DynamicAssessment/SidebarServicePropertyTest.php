<?php

namespace Tests\Feature\DynamicAssessment;

use App\Enums\AssessmentType;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\SidebarService;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for SidebarService
 * 
 * **Feature: dynamic-assessment-flow, Property 9: Sidebar Reflects Enabled Tools**
 * **Validates: Requirements 6.1, 6.2, 6.3, 6.4**
 * 
 * Property: For any scheme context selection, the sidebar navigation SHALL display
 * exactly the assessment tools that are enabled for that scheme, plus mandatory APL tools.
 */
class SidebarServicePropertyTest extends TestCase
{
    use RefreshDatabase;

    private SidebarService $sidebarService;
    private SkemaConfigService $skemaConfigService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skemaConfigService = new SkemaConfigService();
        $this->sidebarService = new SidebarService($this->skemaConfigService);
    }

    /**
     * Property 9: Sidebar Reflects Enabled Tools
     * 
     * For any scheme context selection, the sidebar navigation SHALL display
     * exactly the assessment tools that are enabled for that scheme, plus mandatory sidebar items.
     * Note: APL01 is an asesi form, not shown in asesor sidebar. APL02 is mandatory in sidebar.
     * 
     * **Feature: dynamic-assessment-flow, Property 9: Sidebar Reflects Enabled Tools**
     * **Validates: Requirements 6.1, 6.2, 6.3, 6.4**
     * 
     * @test
     */
    public function sidebar_reflects_enabled_tools_for_any_scheme(): void
    {
        // Get mandatory sidebar items (APL02 only - APL01 is asesi form)
        $mandatorySidebarItems = $this->sidebarService->getMandatorySidebarItems();

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

            // Get menu items for the scheme
            $menuSections = $this->sidebarService->getMenuItemsForScheme($skema->id_skema);

            // Collect all assessment types shown in menu
            $shownAssessmentTypes = [];
            foreach ($menuSections as $section) {
                foreach ($section['items'] as $assessmentType => $item) {
                    $shownAssessmentTypes[] = $assessmentType;
                }
            }

            // Property 1: All mandatory sidebar items (APL02) should always be shown
            foreach ($mandatorySidebarItems as $mandatoryItem) {
                $this->assertContains(
                    $mandatoryItem,
                    $shownAssessmentTypes,
                    "Mandatory sidebar item {$mandatoryItem} should always be shown in sidebar"
                );
            }

            // Property 2: All enabled configurable types that exist in menu should be shown
            foreach ($enabledTypes as $enabledType) {
                // Only check types that are defined in the menu structure
                if ($this->sidebarService->getMenuItemConfig($enabledType) !== null) {
                    $this->assertContains(
                        $enabledType,
                        $shownAssessmentTypes,
                        "Enabled type {$enabledType} should be shown in sidebar"
                    );
                }
            }

            // Property 3: Disabled configurable types should NOT be shown (unless mandatory sidebar)
            foreach ($disabledTypes as $disabledType) {
                // Skip mandatory sidebar items and types not in menu
                if (in_array($disabledType, $mandatorySidebarItems, true)) {
                    continue;
                }
                if ($this->sidebarService->getMenuItemConfig($disabledType) !== null) {
                    $this->assertNotContains(
                        $disabledType,
                        $shownAssessmentTypes,
                        "Disabled type {$disabledType} should NOT be shown in sidebar"
                    );
                }
            }

            // Clean up for next iteration
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Sidebar updates when scheme context changes
     * 
     * When the scheme context changes, the sidebar should reflect the new scheme's configuration.
     * 
     * **Validates: Requirements 6.4**
     * 
     * @test
     */
    public function sidebar_updates_when_scheme_context_changes(): void
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

            // Get menu items for scheme1
            $menuSections1 = $this->sidebarService->getMenuItemsForScheme($skema1->id_skema);
            $shownTypes1 = $this->extractAssessmentTypes($menuSections1);

            // Get menu items for scheme2
            $menuSections2 = $this->sidebarService->getMenuItemsForScheme($skema2->id_skema);
            $shownTypes2 = $this->extractAssessmentTypes($menuSections2);

            // testType should be in scheme1's menu but not in scheme2's menu
            $this->assertContains(
                $testType,
                $shownTypes1,
                "Type {$testType} should be shown for scheme1 where it's enabled"
            );
            $this->assertNotContains(
                $testType,
                $shownTypes2,
                "Type {$testType} should NOT be shown for scheme2 where it's disabled"
            );

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema1->id_skema)->delete();
            SkemaAssessmentConfig::where('id_skema', $skema2->id_skema)->delete();
            $skema1->delete();
            $skema2->delete();
        }
    }

    /**
     * Property: Mandatory sidebar items always visible regardless of configuration attempts
     * 
     * Even if someone tries to disable APL02, it should still appear in sidebar.
     * Note: APL01 is an asesi form, not shown in asesor sidebar.
     * 
     * **Validates: Requirements 6.3**
     * 
     * @test
     */
    public function mandatory_sidebar_items_always_visible_regardless_of_configuration(): void
    {
        $mandatorySidebarItems = $this->sidebarService->getMandatorySidebarItems();

        for ($i = 0; $i < 100; $i++) {
            $skema = Skema::factory()->create();

            // Create config with all configurable types disabled
            $config = [];
            foreach (AssessmentType::getConfigurableTypes() as $type) {
                $config[$type] = false;
            }
            // Mandatory types must be true (service enforces this)
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }

            $this->skemaConfigService->updateAssessmentConfig($skema->id_skema, $config);

            // Get menu items
            $menuSections = $this->sidebarService->getMenuItemsForScheme($skema->id_skema);
            $shownTypes = $this->extractAssessmentTypes($menuSections);

            // All mandatory sidebar items (APL02) should still be visible
            foreach ($mandatorySidebarItems as $mandatoryItem) {
                $this->assertContains(
                    $mandatoryItem,
                    $shownTypes,
                    "Mandatory sidebar item {$mandatoryItem} should always be visible"
                );
            }

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: isMenuItemVisible returns correct visibility for any assessment type
     * 
     * @test
     */
    public function is_menu_item_visible_returns_correct_visibility(): void
    {
        for ($i = 0; $i < 100; $i++) {
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

            // Test visibility for each type
            foreach (AssessmentType::getAllTypes() as $type) {
                $isVisible = $this->sidebarService->isMenuItemVisible($skema->id_skema, $type);
                
                if (AssessmentType::isMandatory($type)) {
                    // Mandatory types should always be visible
                    $this->assertTrue(
                        $isVisible,
                        "Mandatory type {$type} should always be visible"
                    );
                } else {
                    // Configurable types should match their config
                    $expectedVisible = $config[$type];
                    $this->assertEquals(
                        $expectedVisible,
                        $isVisible,
                        "Type {$type} visibility should match config (expected: " . ($expectedVisible ? 'true' : 'false') . ")"
                    );
                }
            }

            // Clean up
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Helper method to extract assessment types from menu sections.
     */
    private function extractAssessmentTypes(array $menuSections): array
    {
        $types = [];
        foreach ($menuSections as $section) {
            foreach ($section['items'] as $assessmentType => $item) {
                $types[] = $assessmentType;
            }
        }
        return $types;
    }
}
