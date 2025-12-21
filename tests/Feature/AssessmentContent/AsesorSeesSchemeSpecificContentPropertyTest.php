<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\Asesi;
use App\Models\ElemenUK;
use App\Models\IA02Template;
use App\Models\IA07Question;
use App\Models\Skema;
use App\Models\Soal;
use App\Models\UK;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: Asesor Sees Scheme-Specific Content
 * 
 * Property 9: For any asesi with a scheme, when an asesor opens an assessment form,
 * the content loaded SHALL match the asesi's scheme.
 * 
 * **Feature: assessment-content-per-template, Property 9: Asesor Sees Scheme-Specific Content**
 * **Validates: Requirements 8.1, 8.2, 8.3**
 */
class AsesorSeesSchemeSpecificContentPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: IA05 questions loaded for asesi match their scheme.
     * 
     * For any asesi with a scheme, when loading IA05 questions,
     * the questions returned should only be from the asesi's scheme.
     * 
     * **Validates: Requirements 8.1**
     */
    public function test_ia05_questions_loaded_for_asesi_match_their_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create two schemes with different questions
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();

            // Create questions for scheme1
            $scheme1QuestionCount = fake()->numberBetween(1, 5);
            $scheme1Questions = [];
            for ($j = 0; $j < $scheme1QuestionCount; $j++) {
                $scheme1Questions[] = Soal::factory()->create([
                    'id_skema' => $scheme1->id_skema,
                    'pertanyaan' => "Scheme1 Question {$j}",
                ]);
            }

            // Create questions for scheme2
            $scheme2QuestionCount = fake()->numberBetween(1, 5);
            for ($j = 0; $j < $scheme2QuestionCount; $j++) {
                Soal::factory()->create([
                    'id_skema' => $scheme2->id_skema,
                    'pertanyaan' => "Scheme2 Question {$j}",
                ]);
            }

            // Create asesi for scheme1
            $asesi = Asesi::factory()->create([
                'id_skema' => $scheme1->id_skema,
            ]);

            // Simulate asesor loading IA05 questions for this asesi
            // The asesor should see questions from the asesi's scheme
            $loadedQuestions = $this->service->getIA05Questions($asesi->id_skema);

            // Verify all loaded questions belong to asesi's scheme
            foreach ($loadedQuestions as $question) {
                $this->assertEquals(
                    $scheme1->id_skema,
                    $question->id_skema,
                    "Question should belong to asesi's scheme"
                );
            }

            // Verify the count matches scheme1's questions
            $this->assertCount(
                $scheme1QuestionCount,
                $loadedQuestions,
                "Should load exactly the questions from asesi's scheme"
            );

            // Verify scheme2's questions are not included
            $loadedQuestionIds = $loadedQuestions->pluck('kode_soal')->toArray();
            $scheme2QuestionIds = Soal::forSkema($scheme2->id_skema)->pluck('kode_soal')->toArray();
            
            foreach ($scheme2QuestionIds as $id) {
                $this->assertNotContains(
                    $id,
                    $loadedQuestionIds,
                    "Questions from other schemes should not be loaded"
                );
            }
        }
    }

    /**
     * Property: IA02 template loaded for asesi matches their scheme.
     * 
     * For any asesi with a scheme, when loading IA02 template,
     * the template returned should be from the asesi's scheme.
     * 
     * **Validates: Requirements 8.2**
     */
    public function test_ia02_template_loaded_for_asesi_matches_their_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create two schemes with different templates
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();

            // Create template for scheme1
            $scheme1Content = fake()->paragraphs(3, true);
            IA02Template::create([
                'id_skema' => $scheme1->id_skema,
                'instruksi_kerja' => $scheme1Content,
            ]);

            // Create template for scheme2
            $scheme2Content = fake()->paragraphs(3, true);
            IA02Template::create([
                'id_skema' => $scheme2->id_skema,
                'instruksi_kerja' => $scheme2Content,
            ]);

            // Create asesi for scheme1
            $asesi = Asesi::factory()->create([
                'id_skema' => $scheme1->id_skema,
            ]);

            // Simulate asesor loading IA02 template for this asesi
            $loadedTemplate = $this->service->getIA02Template($asesi->id_skema);

            // Verify template belongs to asesi's scheme
            $this->assertNotNull($loadedTemplate, "Template should be loaded");
            $this->assertEquals(
                $scheme1->id_skema,
                $loadedTemplate->id_skema,
                "Template should belong to asesi's scheme"
            );
            $this->assertEquals(
                $scheme1Content,
                $loadedTemplate->instruksi_kerja,
                "Template content should match scheme1's content"
            );

            // Verify scheme2's template is not loaded
            $this->assertNotEquals(
                $scheme2Content,
                $loadedTemplate->instruksi_kerja,
                "Template from other scheme should not be loaded"
            );
        }
    }

    /**
     * Property: IA07 questions loaded for asesi match their scheme.
     * 
     * For any asesi with a scheme, when loading IA07 oral questions,
     * the questions returned should only be from the asesi's scheme.
     * 
     * **Validates: Requirements 8.3**
     */
    public function test_ia07_questions_loaded_for_asesi_match_their_scheme(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create UK and ElemenUK
            $uk = UK::factory()->create();
            $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);

            // Create two schemes with the same UK
            $scheme1 = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);
            $scheme2 = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

            // Create questions for scheme1
            $scheme1QuestionCount = fake()->numberBetween(1, 3);
            for ($j = 0; $j < $scheme1QuestionCount; $j++) {
                IA07Question::create([
                    'id_skema' => $scheme1->id_skema,
                    'id_uk' => $uk->id_uk,
                    'id_elemen_uk' => $elemenUk->id_elemen_uk,
                    'pertanyaan' => "Scheme1 Oral Question {$j}",
                    'display_order' => $j,
                    'is_active' => true,
                ]);
            }

            // Create questions for scheme2
            $scheme2QuestionCount = fake()->numberBetween(1, 3);
            for ($j = 0; $j < $scheme2QuestionCount; $j++) {
                IA07Question::create([
                    'id_skema' => $scheme2->id_skema,
                    'id_uk' => $uk->id_uk,
                    'id_elemen_uk' => $elemenUk->id_elemen_uk,
                    'pertanyaan' => "Scheme2 Oral Question {$j}",
                    'display_order' => $j,
                    'is_active' => true,
                ]);
            }

            // Create asesi for scheme1
            $asesi = Asesi::factory()->create([
                'id_skema' => $scheme1->id_skema,
            ]);

            // Simulate asesor loading IA07 questions for this asesi
            $loadedQuestions = $this->service->getIA07Questions($asesi->id_skema);

            // Verify all loaded questions belong to asesi's scheme
            foreach ($loadedQuestions as $question) {
                $this->assertEquals(
                    $scheme1->id_skema,
                    $question->id_skema,
                    "IA07 question should belong to asesi's scheme"
                );
            }

            // Verify the count matches scheme1's questions
            $this->assertCount(
                $scheme1QuestionCount,
                $loadedQuestions,
                "Should load exactly the IA07 questions from asesi's scheme"
            );

            // Verify scheme2's questions are not included
            $loadedQuestionIds = $loadedQuestions->pluck('id')->toArray();
            $scheme2QuestionIds = IA07Question::forSkema($scheme2->id_skema)->pluck('id')->toArray();
            
            foreach ($scheme2QuestionIds as $id) {
                $this->assertNotContains(
                    $id,
                    $loadedQuestionIds,
                    "IA07 questions from other schemes should not be loaded"
                );
            }
        }
    }

    /**
     * Property: Content loaded for asesi is consistent across multiple loads.
     * 
     * For any asesi, loading content multiple times should return the same results.
     */
    public function test_content_loaded_for_asesi_is_consistent_across_multiple_loads(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create scheme with content
            $scheme = Skema::factory()->create();
            
            // Create IA05 questions
            $questionCount = fake()->numberBetween(1, 3);
            for ($j = 0; $j < $questionCount; $j++) {
                Soal::factory()->create(['id_skema' => $scheme->id_skema]);
            }

            // Create IA02 template
            IA02Template::create([
                'id_skema' => $scheme->id_skema,
                'instruksi_kerja' => fake()->paragraphs(2, true),
            ]);

            // Create asesi for scheme
            $asesi = Asesi::factory()->create([
                'id_skema' => $scheme->id_skema,
            ]);

            // Load content multiple times
            $firstLoadIA05 = $this->service->getIA05Questions($asesi->id_skema);
            $secondLoadIA05 = $this->service->getIA05Questions($asesi->id_skema);
            
            $firstLoadIA02 = $this->service->getIA02Template($asesi->id_skema);
            $secondLoadIA02 = $this->service->getIA02Template($asesi->id_skema);

            // Verify IA05 consistency
            $this->assertEquals(
                $firstLoadIA05->pluck('kode_soal')->toArray(),
                $secondLoadIA05->pluck('kode_soal')->toArray(),
                "IA05 questions should be consistent across loads"
            );

            // Verify IA02 consistency
            $this->assertEquals(
                $firstLoadIA02->instruksi_kerja,
                $secondLoadIA02->instruksi_kerja,
                "IA02 template should be consistent across loads"
            );
        }
    }

    /**
     * Property: Different asesi with same scheme see same content.
     * 
     * For any two asesi with the same scheme, they should see the same content.
     */
    public function test_different_asesi_with_same_scheme_see_same_content(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create scheme with content
            $scheme = Skema::factory()->create();
            
            // Create IA05 questions
            $questionCount = fake()->numberBetween(1, 3);
            for ($j = 0; $j < $questionCount; $j++) {
                Soal::factory()->create(['id_skema' => $scheme->id_skema]);
            }

            // Create IA02 template
            $templateContent = fake()->paragraphs(2, true);
            IA02Template::create([
                'id_skema' => $scheme->id_skema,
                'instruksi_kerja' => $templateContent,
            ]);

            // Create two asesi for the same scheme
            $asesi1 = Asesi::factory()->create(['id_skema' => $scheme->id_skema]);
            $asesi2 = Asesi::factory()->create(['id_skema' => $scheme->id_skema]);

            // Load content for both asesi
            $asesi1IA05 = $this->service->getIA05Questions($asesi1->id_skema);
            $asesi2IA05 = $this->service->getIA05Questions($asesi2->id_skema);
            
            $asesi1IA02 = $this->service->getIA02Template($asesi1->id_skema);
            $asesi2IA02 = $this->service->getIA02Template($asesi2->id_skema);

            // Verify both asesi see the same IA05 questions
            $this->assertEquals(
                $asesi1IA05->pluck('kode_soal')->toArray(),
                $asesi2IA05->pluck('kode_soal')->toArray(),
                "Both asesi should see the same IA05 questions"
            );

            // Verify both asesi see the same IA02 template
            $this->assertEquals(
                $asesi1IA02->instruksi_kerja,
                $asesi2IA02->instruksi_kerja,
                "Both asesi should see the same IA02 template"
            );
        }
    }

    /**
     * Property: Asesi with different schemes see different content.
     * 
     * For any two asesi with different schemes, they should see different content
     * (assuming each scheme has unique content).
     */
    public function test_asesi_with_different_schemes_see_different_content(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create two schemes with different content
            $scheme1 = Skema::factory()->create();
            $scheme2 = Skema::factory()->create();
            
            // Create unique IA05 questions for each scheme
            Soal::factory()->create([
                'id_skema' => $scheme1->id_skema,
                'pertanyaan' => 'Unique question for scheme 1',
            ]);
            Soal::factory()->create([
                'id_skema' => $scheme2->id_skema,
                'pertanyaan' => 'Unique question for scheme 2',
            ]);

            // Create unique IA02 templates for each scheme
            IA02Template::create([
                'id_skema' => $scheme1->id_skema,
                'instruksi_kerja' => 'Unique template for scheme 1',
            ]);
            IA02Template::create([
                'id_skema' => $scheme2->id_skema,
                'instruksi_kerja' => 'Unique template for scheme 2',
            ]);

            // Create asesi for each scheme
            $asesi1 = Asesi::factory()->create(['id_skema' => $scheme1->id_skema]);
            $asesi2 = Asesi::factory()->create(['id_skema' => $scheme2->id_skema]);

            // Load content for both asesi
            $asesi1IA05 = $this->service->getIA05Questions($asesi1->id_skema);
            $asesi2IA05 = $this->service->getIA05Questions($asesi2->id_skema);
            
            $asesi1IA02 = $this->service->getIA02Template($asesi1->id_skema);
            $asesi2IA02 = $this->service->getIA02Template($asesi2->id_skema);

            // Verify asesi see different IA05 questions
            $this->assertNotEquals(
                $asesi1IA05->pluck('kode_soal')->toArray(),
                $asesi2IA05->pluck('kode_soal')->toArray(),
                "Asesi with different schemes should see different IA05 questions"
            );

            // Verify asesi see different IA02 templates
            $this->assertNotEquals(
                $asesi1IA02->instruksi_kerja,
                $asesi2IA02->instruksi_kerja,
                "Asesi with different schemes should see different IA02 templates"
            );
        }
    }
}
