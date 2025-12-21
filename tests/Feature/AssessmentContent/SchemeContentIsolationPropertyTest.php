<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\ElemenUK;
use App\Models\IA02Template;
use App\Models\IA07Question;
use App\Models\IA11Checklist;
use App\Models\Skema;
use App\Models\Soal;
use App\Models\UK;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: Scheme Content Isolation
 * 
 * Property 1: For any scheme and any content type (IA05, IA02, IA07, IA11),
 * content created for that scheme SHALL only be retrievable when querying that specific scheme.
 * 
 * Validates: Requirements 1.1, 2.1, 3.1, 6.1
 */
class SchemeContentIsolationPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: IA05 questions are isolated per scheme.
     * For any two schemes, questions created for scheme1 should not appear in scheme2's results.
     */
    public function test_ia05_questions_are_isolated_per_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create two random schemes
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();

            // Create questions for scheme1
            $questionCount = fake()->numberBetween(1, 5);
            for ($j = 0; $j < $questionCount; $j++) {
                Soal::factory()->create([
                    'id_skema' => $scheme1->id_skema,
                    'pertanyaan' => fake()->sentence(),
                    'jawaban_a' => fake()->sentence(),
                    'jawaban_b' => fake()->sentence(),
                    'jawaban_c' => fake()->sentence(),
                    'jawaban_d' => fake()->sentence(),
                    'jawaban_e' => fake()->sentence(),
                    'jawaban_benar' => fake()->randomElement(['a', 'b', 'c', 'd', 'e']),
                ]);
            }

            // Query questions for scheme2
            $scheme2Questions = $this->service->getIA05Questions($scheme2->id_skema);

            // Verify scheme1's questions are not in scheme2's results
            $scheme1QuestionIds = Soal::forSkema($scheme1->id_skema)->pluck('kode_soal')->toArray();
            $scheme2QuestionIds = $scheme2Questions->pluck('kode_soal')->toArray();

            foreach ($scheme1QuestionIds as $id) {
                $this->assertNotContains($id, $scheme2QuestionIds, 
                    "Scheme1's question should not appear in scheme2's results");
            }

            // Verify scheme2 has no questions (we didn't create any for it)
            $this->assertCount(0, $scheme2Questions, 
                "Scheme2 should have no questions");
        }
    }

    /**
     * Property: IA02 templates are isolated per scheme.
     * For any two schemes, template created for scheme1 should not be retrievable for scheme2.
     */
    public function test_ia02_templates_are_isolated_per_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create two random schemes
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();

            // Create template for scheme1
            $templateContent = fake()->paragraphs(3, true);
            IA02Template::create([
                'id_skema' => $scheme1->id_skema,
                'instruksi_kerja' => $templateContent,
            ]);

            // Query template for scheme2
            $scheme2Template = $this->service->getIA02Template($scheme2->id_skema);

            // Verify scheme2 has no template
            $this->assertNull($scheme2Template, 
                "Scheme2 should not have scheme1's template");

            // Verify scheme1's template is retrievable
            $scheme1Template = $this->service->getIA02Template($scheme1->id_skema);
            $this->assertNotNull($scheme1Template);
            $this->assertEquals($templateContent, $scheme1Template->instruksi_kerja);
        }
    }

    /**
     * Property: IA07 questions are isolated per scheme.
     * For any two schemes, questions created for scheme1 should not appear in scheme2's results.
     */
    public function test_ia07_questions_are_isolated_per_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create UK and ElemenUK
            $uk = UK::factory()->create();
            $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);

            // Create two random schemes with the UK
            $scheme1 = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);
            $scheme2 = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

            // Create questions for scheme1
            $questionCount = fake()->numberBetween(1, 3);
            for ($j = 0; $j < $questionCount; $j++) {
                IA07Question::create([
                    'id_skema' => $scheme1->id_skema,
                    'id_uk' => $uk->id_uk,
                    'id_elemen_uk' => $elemenUk->id_elemen_uk,
                    'pertanyaan' => fake()->sentence(),
                    'display_order' => $j,
                    'is_active' => true,
                ]);
            }

            // Query questions for scheme2
            $scheme2Questions = $this->service->getIA07Questions($scheme2->id_skema);

            // Verify scheme1's questions are not in scheme2's results
            $scheme1QuestionIds = IA07Question::forSkema($scheme1->id_skema)->pluck('id')->toArray();
            $scheme2QuestionIds = $scheme2Questions->pluck('id')->toArray();

            foreach ($scheme1QuestionIds as $id) {
                $this->assertNotContains($id, $scheme2QuestionIds, 
                    "Scheme1's IA07 question should not appear in scheme2's results");
            }

            // Verify scheme2 has no questions
            $this->assertCount(0, $scheme2Questions, 
                "Scheme2 should have no IA07 questions");
        }
    }

    /**
     * Property: IA11 checklist items are isolated per scheme.
     * For any two schemes, items created for scheme1 should not appear in scheme2's results.
     */
    public function test_ia11_checklist_items_are_isolated_per_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create two random schemes
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();

            // Create checklist items for scheme1
            $itemCount = fake()->numberBetween(1, 5);
            for ($j = 0; $j < $itemCount; $j++) {
                IA11Checklist::create([
                    'id_skema' => $scheme1->id_skema,
                    'item_name' => fake()->words(3, true),
                    'description' => fake()->sentence(),
                    'verification_criteria' => fake()->sentence(),
                    'display_order' => $j,
                    'is_required' => fake()->boolean(),
                ]);
            }

            // Query checklist for scheme2
            $scheme2Checklist = $this->service->getIA11Checklist($scheme2->id_skema);

            // Verify scheme1's items are not in scheme2's results
            $scheme1ItemIds = IA11Checklist::forSkema($scheme1->id_skema)->pluck('id')->toArray();
            $scheme2ItemIds = $scheme2Checklist->pluck('id')->toArray();

            foreach ($scheme1ItemIds as $id) {
                $this->assertNotContains($id, $scheme2ItemIds, 
                    "Scheme1's IA11 item should not appear in scheme2's results");
            }

            // Verify scheme2 has no items
            $this->assertCount(0, $scheme2Checklist, 
                "Scheme2 should have no IA11 checklist items");
        }
    }

    /**
     * Property: Content summary correctly reflects scheme-specific content.
     */
    public function test_content_summary_reflects_scheme_specific_content(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create two schemes
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();

            // Create random content for scheme1
            $ia05Count = fake()->numberBetween(0, 3);
            for ($j = 0; $j < $ia05Count; $j++) {
                Soal::factory()->create(['id_skema' => $scheme1->id_skema]);
            }

            $hasIa02 = fake()->boolean();
            if ($hasIa02) {
                IA02Template::create([
                    'id_skema' => $scheme1->id_skema,
                    'instruksi_kerja' => fake()->paragraph(),
                ]);
            }

            $ia11Count = fake()->numberBetween(0, 3);
            for ($j = 0; $j < $ia11Count; $j++) {
                IA11Checklist::create([
                    'id_skema' => $scheme1->id_skema,
                    'item_name' => fake()->words(3, true),
                    'display_order' => $j,
                ]);
            }

            // Get summaries
            $summary1 = $this->service->getContentSummary($scheme1->id_skema);
            $summary2 = $this->service->getContentSummary($scheme2->id_skema);

            // Verify scheme1's summary
            $this->assertEquals($ia05Count, $summary1['ia05_count']);
            $this->assertEquals($hasIa02, $summary1['ia02_exists']);
            $this->assertEquals($ia11Count, $summary1['ia11_count']);

            // Verify scheme2's summary (should be empty)
            $this->assertEquals(0, $summary2['ia05_count']);
            $this->assertFalse($summary2['ia02_exists']);
            $this->assertEquals(0, $summary2['ia11_count']);
        }
    }
}
