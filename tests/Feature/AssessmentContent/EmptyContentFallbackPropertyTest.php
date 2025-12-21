<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\Asesi;
use App\Models\ElemenUK;
use App\Models\IA02Template;
use App\Models\IA07Question;
use App\Models\IA11Checklist;
use App\Models\MAPA01Config;
use App\Models\MAPA02Config;
use App\Models\Skema;
use App\Models\Soal;
use App\Models\UK;
use App\Services\IA02Service;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: Empty Content Fallback
 * 
 * Property 11: For any scheme without configured content, the system SHALL indicate
 * that content needs to be configured rather than showing empty or error.
 * 
 * **Feature: assessment-content-per-template, Property 11: Empty Content Fallback**
 * **Validates: Requirements 8.4**
 */
class EmptyContentFallbackPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $schemeContentService;
    protected IA02Service $ia02Service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->schemeContentService = new SchemeContentService();
        $this->ia02Service = new IA02Service();
    }

    /**
     * Property: Scheme without IA05 content returns empty collection (not error).
     * 
     * For any scheme without IA05 questions configured, the system SHALL return
     * an empty collection rather than throwing an error.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_scheme_without_ia05_content_returns_empty_collection(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any IA05 questions
            $scheme = Skema::factory()->create();

            // Attempt to get IA05 questions for this scheme
            $questions = $this->schemeContentService->getIA05Questions($scheme->id_skema);

            // Should return empty collection, not null or error
            $this->assertInstanceOf(
                \Illuminate\Support\Collection::class,
                $questions,
                "Should return a Collection instance"
            );
            $this->assertCount(
                0,
                $questions,
                "Should return empty collection for scheme without IA05 content"
            );
        }
    }

    /**
     * Property: Scheme without IA02 template returns null (indicating no content).
     * 
     * For any scheme without IA02 template configured, the system SHALL return
     * null to indicate content needs to be configured.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_scheme_without_ia02_template_returns_null(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any IA02 template
            $scheme = Skema::factory()->create();

            // Attempt to get IA02 template for this scheme
            $template = $this->schemeContentService->getIA02Template($scheme->id_skema);

            // Should return null, not error
            $this->assertNull(
                $template,
                "Should return null for scheme without IA02 template"
            );
        }
    }

    /**
     * Property: Scheme without IA07 questions returns empty collection.
     * 
     * For any scheme without IA07 oral questions configured, the system SHALL return
     * an empty collection rather than throwing an error.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_scheme_without_ia07_content_returns_empty_collection(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any IA07 questions
            $scheme = Skema::factory()->create();

            // Attempt to get IA07 questions for this scheme
            $questions = $this->schemeContentService->getIA07Questions($scheme->id_skema);

            // Should return empty collection, not null or error
            $this->assertInstanceOf(
                \Illuminate\Support\Collection::class,
                $questions,
                "Should return a Collection instance"
            );
            $this->assertCount(
                0,
                $questions,
                "Should return empty collection for scheme without IA07 content"
            );
        }
    }

    /**
     * Property: Scheme without MAPA01 config returns null.
     * 
     * For any scheme without MAPA01 configuration, the system SHALL return
     * null to indicate content needs to be configured.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_scheme_without_mapa01_config_returns_null(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any MAPA01 config
            $scheme = Skema::factory()->create();

            // Attempt to get MAPA01 config for this scheme
            $config = $this->schemeContentService->getMAPA01Config($scheme->id_skema);

            // Should return null, not error
            $this->assertNull(
                $config,
                "Should return null for scheme without MAPA01 config"
            );
        }
    }

    /**
     * Property: Scheme without MAPA02 config returns null.
     * 
     * For any scheme without MAPA02 configuration, the system SHALL return
     * null to indicate content needs to be configured.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_scheme_without_mapa02_config_returns_null(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any MAPA02 config
            $scheme = Skema::factory()->create();

            // Attempt to get MAPA02 config for this scheme
            $config = $this->schemeContentService->getMAPA02Config($scheme->id_skema);

            // Should return null, not error
            $this->assertNull(
                $config,
                "Should return null for scheme without MAPA02 config"
            );
        }
    }

    /**
     * Property: Scheme without IA11 checklist returns empty collection.
     * 
     * For any scheme without IA11 checklist items configured, the system SHALL return
     * an empty collection rather than throwing an error.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_scheme_without_ia11_content_returns_empty_collection(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any IA11 checklist items
            $scheme = Skema::factory()->create();

            // Attempt to get IA11 checklist for this scheme
            $checklist = $this->schemeContentService->getIA11Checklist($scheme->id_skema);

            // Should return empty collection, not null or error
            $this->assertInstanceOf(
                \Illuminate\Support\Collection::class,
                $checklist,
                "Should return a Collection instance"
            );
            $this->assertCount(
                0,
                $checklist,
                "Should return empty collection for scheme without IA11 content"
            );
        }
    }

    /**
     * Property: hasContent returns false for scheme without any content.
     * 
     * For any scheme without any configured content, hasContent() SHALL return false.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_has_content_returns_false_for_empty_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any content
            $scheme = Skema::factory()->create();

            // Check hasContent
            $hasContent = $this->schemeContentService->hasContent($scheme->id_skema);

            // Should return false
            $this->assertFalse(
                $hasContent,
                "hasContent should return false for scheme without any content"
            );
        }
    }

    /**
     * Property: getContentSummary returns zero counts for empty scheme.
     * 
     * For any scheme without configured content, getContentSummary() SHALL return
     * a summary with zero counts and false exists flags.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_content_summary_shows_zero_for_empty_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any content
            $scheme = Skema::factory()->create();

            // Get content summary
            $summary = $this->schemeContentService->getContentSummary($scheme->id_skema);

            // Verify all counts are zero and exists flags are false
            $this->assertEquals(0, $summary['ia05_count'], "IA05 count should be 0");
            $this->assertFalse($summary['ia02_exists'], "IA02 exists should be false");
            $this->assertEquals(0, $summary['ia07_count'], "IA07 count should be 0");
            $this->assertFalse($summary['mapa01_exists'], "MAPA01 exists should be false");
            $this->assertFalse($summary['mapa02_exists'], "MAPA02 exists should be false");
            $this->assertEquals(0, $summary['ia11_count'], "IA11 count should be 0");
        }
    }

    /**
     * Property: IA02Service hasTemplateForSkema returns false for empty scheme.
     * 
     * For any scheme without IA02 template, hasTemplateForSkema() SHALL return false.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_ia02_service_has_template_returns_false_for_empty_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme without any IA02 template
            $scheme = Skema::factory()->create();

            // Check hasTemplateForSkema
            $hasTemplate = $this->ia02Service->hasTemplateForSkema($scheme->id_skema);

            // Should return false
            $this->assertFalse(
                $hasTemplate,
                "hasTemplateForSkema should return false for scheme without IA02 template"
            );
        }
    }

    /**
     * Property: hasContent returns true when at least one content type exists.
     * 
     * For any scheme with at least one type of content configured, hasContent() SHALL return true.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_has_content_returns_true_when_any_content_exists(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme
            $scheme = Skema::factory()->create();

            // Randomly add one type of content
            $contentType = fake()->randomElement(['ia05', 'ia02', 'ia07', 'mapa01', 'mapa02', 'ia11']);

            switch ($contentType) {
                case 'ia05':
                    Soal::factory()->create(['id_skema' => $scheme->id_skema]);
                    break;
                case 'ia02':
                    IA02Template::create([
                        'id_skema' => $scheme->id_skema,
                        'instruksi_kerja' => fake()->paragraph(),
                    ]);
                    break;
                case 'ia07':
                    $uk = UK::factory()->create();
                    $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
                    IA07Question::create([
                        'id_skema' => $scheme->id_skema,
                        'id_uk' => $uk->id_uk,
                        'id_elemen_uk' => $elemenUk->id_elemen_uk,
                        'pertanyaan' => fake()->sentence(),
                        'display_order' => 0,
                        'is_active' => true,
                    ]);
                    break;
                case 'mapa01':
                    MAPA01Config::create([
                        'id_skema' => $scheme->id_skema,
                        'config_data' => ['test' => 'data'],
                    ]);
                    break;
                case 'mapa02':
                    MAPA02Config::create([
                        'id_skema' => $scheme->id_skema,
                        'muk_items' => ['item1'],
                        'default_potensi' => ['potensi1'],
                    ]);
                    break;
                case 'ia11':
                    IA11Checklist::create([
                        'id_skema' => $scheme->id_skema,
                        'item_name' => fake()->word(),
                        'display_order' => 0,
                        'is_required' => true,
                    ]);
                    break;
            }

            // Check hasContent
            $hasContent = $this->schemeContentService->hasContent($scheme->id_skema);

            // Should return true
            $this->assertTrue(
                $hasContent,
                "hasContent should return true when {$contentType} content exists"
            );
        }
    }

    /**
     * Property: Empty content retrieval is consistent across multiple calls.
     * 
     * For any scheme without content, multiple calls to retrieve content SHALL
     * consistently return empty/null results.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_empty_content_retrieval_is_consistent(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create a scheme without any content
            $scheme = Skema::factory()->create();

            // Call each method multiple times
            for ($j = 0; $j < 3; $j++) {
                $ia05 = $this->schemeContentService->getIA05Questions($scheme->id_skema);
                $ia02 = $this->schemeContentService->getIA02Template($scheme->id_skema);
                $ia07 = $this->schemeContentService->getIA07Questions($scheme->id_skema);
                $mapa01 = $this->schemeContentService->getMAPA01Config($scheme->id_skema);
                $mapa02 = $this->schemeContentService->getMAPA02Config($scheme->id_skema);
                $ia11 = $this->schemeContentService->getIA11Checklist($scheme->id_skema);
                $hasContent = $this->schemeContentService->hasContent($scheme->id_skema);

                // All should consistently return empty/null/false
                $this->assertCount(0, $ia05, "IA05 should consistently return empty");
                $this->assertNull($ia02, "IA02 should consistently return null");
                $this->assertCount(0, $ia07, "IA07 should consistently return empty");
                $this->assertNull($mapa01, "MAPA01 should consistently return null");
                $this->assertNull($mapa02, "MAPA02 should consistently return null");
                $this->assertCount(0, $ia11, "IA11 should consistently return empty");
                $this->assertFalse($hasContent, "hasContent should consistently return false");
            }
        }
    }

    /**
     * Property: Non-existent scheme ID returns empty/null (not error).
     * 
     * For any non-existent scheme ID, content retrieval methods SHALL return
     * empty/null rather than throwing an error.
     * 
     * **Validates: Requirements 8.4**
     */
    public function test_non_existent_scheme_returns_empty_not_error(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Generate a random non-existent scheme ID
            $nonExistentId = 'NON_EXISTENT_' . fake()->uuid();

            // All methods should return empty/null without throwing errors
            $ia05 = $this->schemeContentService->getIA05Questions($nonExistentId);
            $ia02 = $this->schemeContentService->getIA02Template($nonExistentId);
            $ia07 = $this->schemeContentService->getIA07Questions($nonExistentId);
            $mapa01 = $this->schemeContentService->getMAPA01Config($nonExistentId);
            $mapa02 = $this->schemeContentService->getMAPA02Config($nonExistentId);
            $ia11 = $this->schemeContentService->getIA11Checklist($nonExistentId);
            $hasContent = $this->schemeContentService->hasContent($nonExistentId);

            // All should return empty/null/false without errors
            $this->assertCount(0, $ia05, "IA05 should return empty for non-existent scheme");
            $this->assertNull($ia02, "IA02 should return null for non-existent scheme");
            $this->assertCount(0, $ia07, "IA07 should return empty for non-existent scheme");
            $this->assertNull($mapa01, "MAPA01 should return null for non-existent scheme");
            $this->assertNull($mapa02, "MAPA02 should return null for non-existent scheme");
            $this->assertCount(0, $ia11, "IA11 should return empty for non-existent scheme");
            $this->assertFalse($hasContent, "hasContent should return false for non-existent scheme");
        }
    }
}
