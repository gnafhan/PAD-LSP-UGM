<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\ElemenUK;
use App\Models\IA02Template;
use App\Models\IA07Question;
use App\Models\IA11Checklist;
use App\Models\MAPA01Config;
use App\Models\MAPA02Config;
use App\Models\Skema;
use App\Models\Soal;
use App\Models\UK;
use App\Services\ContentCopyService;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: Content Copy Duplicates All Items
 * 
 * Property 10: For any content copy operation from source to target scheme,
 * all content items from source SHALL exist in target after copy.
 * 
 * Validates: Requirements 9.2
 */
class ContentCopyPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected ContentCopyService $copyService;
    protected SchemeContentService $contentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contentService = new SchemeContentService();
        $this->copyService = new ContentCopyService($this->contentService);
    }

    /**
     * Property: IA05 questions are duplicated to target scheme.
     */
    public function test_ia05_questions_are_duplicated(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $sourceScheme = Skema::factory()->create();
            $targetScheme = Skema::factory()->create();

            // Create random number of questions in source
            $questionCount = fake()->numberBetween(1, 5);
            $sourceQuestions = [];
            for ($j = 0; $j < $questionCount; $j++) {
                $sourceQuestions[] = Soal::factory()->create([
                    'id_skema' => $sourceScheme->id_skema,
                    'pertanyaan' => "Question $j",
                    'display_order' => $j,
                ]);
            }

            // Copy content
            $summary = $this->copyService->copyAllContent(
                $sourceScheme->id_skema,
                $targetScheme->id_skema
            );

            // Verify all questions were copied
            $this->assertEquals($questionCount, $summary['ia05_copied']);

            $targetQuestions = Soal::forSkema($targetScheme->id_skema)->ordered()->get();
            $this->assertCount($questionCount, $targetQuestions);

            // Verify content matches
            for ($j = 0; $j < $questionCount; $j++) {
                $this->assertEquals(
                    $sourceQuestions[$j]->pertanyaan,
                    $targetQuestions[$j]->pertanyaan
                );
                $this->assertEquals(
                    $sourceQuestions[$j]->jawaban_benar,
                    $targetQuestions[$j]->jawaban_benar
                );
            }
        }
    }

    /**
     * Property: IA02 template is duplicated to target scheme.
     */
    public function test_ia02_template_is_duplicated(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $sourceScheme = Skema::factory()->create();
            $targetScheme = Skema::factory()->create();

            // Create template in source
            $templateContent = fake()->paragraphs(3, true);
            IA02Template::create([
                'id_skema' => $sourceScheme->id_skema,
                'instruksi_kerja' => $templateContent,
            ]);

            // Copy content
            $summary = $this->copyService->copyAllContent(
                $sourceScheme->id_skema,
                $targetScheme->id_skema
            );

            // Verify template was copied
            $this->assertTrue($summary['ia02_copied']);

            $targetTemplate = IA02Template::forSkema($targetScheme->id_skema)->first();
            $this->assertNotNull($targetTemplate);
            $this->assertEquals($templateContent, $targetTemplate->instruksi_kerja);
        }
    }

    /**
     * Property: IA07 questions are duplicated when UK matches.
     */
    public function test_ia07_questions_are_duplicated_when_uk_matches(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create shared UK and elemen
            $uk = UK::factory()->create();
            $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);

            // Create schemes with same UK
            $sourceScheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);
            $targetScheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

            // Create questions in source
            $questionCount = fake()->numberBetween(1, 3);
            for ($j = 0; $j < $questionCount; $j++) {
                IA07Question::create([
                    'id_skema' => $sourceScheme->id_skema,
                    'id_uk' => $uk->id_uk,
                    'id_elemen_uk' => $elemenUk->id_elemen_uk,
                    'pertanyaan' => "IA07 Question $j",
                    'display_order' => $j,
                    'is_active' => true,
                ]);
            }

            // Copy content
            $summary = $this->copyService->copyAllContent(
                $sourceScheme->id_skema,
                $targetScheme->id_skema
            );

            // Verify questions were copied
            $this->assertEquals($questionCount, $summary['ia07_copied']);

            $targetQuestions = IA07Question::forSkema($targetScheme->id_skema)->get();
            $this->assertCount($questionCount, $targetQuestions);
        }
    }

    /**
     * Property: IA07 questions are NOT copied when UK doesn't match.
     */
    public function test_ia07_questions_not_copied_when_uk_doesnt_match(): void
    {
        // Create different UKs
        $uk1 = UK::factory()->create();
        $uk2 = UK::factory()->create();
        $elemenUk1 = ElemenUK::factory()->create(['id_uk' => $uk1->id_uk]);

        // Source has uk1, target has uk2
        $sourceScheme = Skema::factory()->create(['daftar_id_uk' => [$uk1->id_uk]]);
        $targetScheme = Skema::factory()->create(['daftar_id_uk' => [$uk2->id_uk]]);

        // Create questions in source
        IA07Question::create([
            'id_skema' => $sourceScheme->id_skema,
            'id_uk' => $uk1->id_uk,
            'id_elemen_uk' => $elemenUk1->id_elemen_uk,
            'pertanyaan' => 'Question for UK1',
            'display_order' => 0,
            'is_active' => true,
        ]);

        // Copy content
        $summary = $this->copyService->copyAllContent(
            $sourceScheme->id_skema,
            $targetScheme->id_skema
        );

        // Verify no IA07 questions were copied (UK doesn't match)
        $this->assertEquals(0, $summary['ia07_copied']);
    }

    /**
     * Property: MAPA01 config is duplicated to target scheme.
     */
    public function test_mapa01_config_is_duplicated(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $sourceScheme = Skema::factory()->create();
            $targetScheme = Skema::factory()->create();

            // Create config in source
            $configData = [
                'pendekatan' => fake()->randomElement(['observasi', 'demonstrasi']),
                'tempat' => fake()->word(),
            ];
            MAPA01Config::create([
                'id_skema' => $sourceScheme->id_skema,
                'config_data' => $configData,
            ]);

            // Copy content
            $summary = $this->copyService->copyAllContent(
                $sourceScheme->id_skema,
                $targetScheme->id_skema
            );

            // Verify config was copied
            $this->assertTrue($summary['mapa01_copied']);

            $targetConfig = MAPA01Config::forSkema($targetScheme->id_skema)->first();
            $this->assertNotNull($targetConfig);
            $this->assertEquals($configData, $targetConfig->config_data);
        }
    }

    /**
     * Property: MAPA02 config is duplicated to target scheme.
     */
    public function test_mapa02_config_is_duplicated(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $sourceScheme = Skema::factory()->create();
            $targetScheme = Skema::factory()->create();

            // Create config in source
            $mukItems = [['code' => 'MUK-01', 'enabled' => true]];
            $defaultPotensi = ['UK1' => 'K'];
            MAPA02Config::create([
                'id_skema' => $sourceScheme->id_skema,
                'muk_items' => $mukItems,
                'default_potensi' => $defaultPotensi,
            ]);

            // Copy content
            $summary = $this->copyService->copyAllContent(
                $sourceScheme->id_skema,
                $targetScheme->id_skema
            );

            // Verify config was copied
            $this->assertTrue($summary['mapa02_copied']);

            $targetConfig = MAPA02Config::forSkema($targetScheme->id_skema)->first();
            $this->assertNotNull($targetConfig);
            $this->assertEquals($mukItems, $targetConfig->muk_items);
            $this->assertEquals($defaultPotensi, $targetConfig->default_potensi);
        }
    }

    /**
     * Property: IA11 checklist items are duplicated to target scheme.
     */
    public function test_ia11_checklist_items_are_duplicated(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $sourceScheme = Skema::factory()->create();
            $targetScheme = Skema::factory()->create();

            // Create checklist items in source
            $itemCount = fake()->numberBetween(1, 5);
            $sourceItems = [];
            for ($j = 0; $j < $itemCount; $j++) {
                $sourceItems[] = IA11Checklist::create([
                    'id_skema' => $sourceScheme->id_skema,
                    'item_name' => "Item $j",
                    'description' => fake()->sentence(),
                    'display_order' => $j,
                    'is_required' => fake()->boolean(),
                ]);
            }

            // Copy content
            $summary = $this->copyService->copyAllContent(
                $sourceScheme->id_skema,
                $targetScheme->id_skema
            );

            // Verify items were copied
            $this->assertEquals($itemCount, $summary['ia11_copied']);

            $targetItems = IA11Checklist::forSkema($targetScheme->id_skema)->ordered()->get();
            $this->assertCount($itemCount, $targetItems);

            // Verify content matches
            for ($j = 0; $j < $itemCount; $j++) {
                $this->assertEquals($sourceItems[$j]->item_name, $targetItems[$j]->item_name);
                $this->assertEquals($sourceItems[$j]->is_required, $targetItems[$j]->is_required);
            }
        }
    }

    /**
     * Property: Copy fails when source has no content.
     */
    public function test_copy_fails_when_source_has_no_content(): void
    {
        $sourceScheme = Skema::factory()->create();
        $targetScheme = Skema::factory()->create();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Skema sumber tidak memiliki konten');

        $this->copyService->copyAllContent(
            $sourceScheme->id_skema,
            $targetScheme->id_skema
        );
    }

    /**
     * Property: Copy fails when target has content and overwrite is false.
     */
    public function test_copy_fails_when_target_has_content_without_overwrite(): void
    {
        $sourceScheme = Skema::factory()->create();
        $targetScheme = Skema::factory()->create();

        // Create content in both schemes
        Soal::factory()->create(['id_skema' => $sourceScheme->id_skema]);
        Soal::factory()->create(['id_skema' => $targetScheme->id_skema]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Skema target sudah memiliki konten');

        $this->copyService->copyAllContent(
            $sourceScheme->id_skema,
            $targetScheme->id_skema,
            false // overwrite = false
        );
    }

    /**
     * Property: Copy succeeds when target has content and overwrite is true.
     */
    public function test_copy_succeeds_with_overwrite(): void
    {
        $sourceScheme = Skema::factory()->create();
        $targetScheme = Skema::factory()->create();

        // Create content in source
        Soal::factory()->create([
            'id_skema' => $sourceScheme->id_skema,
            'pertanyaan' => 'Source question',
        ]);

        // Create different content in target
        Soal::factory()->create([
            'id_skema' => $targetScheme->id_skema,
            'pertanyaan' => 'Target question',
        ]);

        // Copy with overwrite
        $summary = $this->copyService->copyAllContent(
            $sourceScheme->id_skema,
            $targetScheme->id_skema,
            true // overwrite = true
        );

        // Verify target now has source content
        $this->assertEquals(1, $summary['ia05_copied']);

        $targetQuestions = Soal::forSkema($targetScheme->id_skema)->get();
        $this->assertCount(1, $targetQuestions);
        $this->assertEquals('Source question', $targetQuestions->first()->pertanyaan);
    }

    /**
     * Property: getSchemesWithContent returns only schemes with content.
     */
    public function test_get_schemes_with_content_returns_correct_schemes(): void
    {
        // Create schemes with and without content
        $schemeWithContent1 = Skema::factory()->create();
        $schemeWithContent2 = Skema::factory()->create();
        $schemeWithoutContent = Skema::factory()->create();

        Soal::factory()->create(['id_skema' => $schemeWithContent1->id_skema]);
        IA02Template::create([
            'id_skema' => $schemeWithContent2->id_skema,
            'instruksi_kerja' => 'Test',
        ]);

        // Get schemes with content
        $schemesWithContent = $this->copyService->getSchemesWithContent();

        $schemeIds = $schemesWithContent->pluck('id_skema')->toArray();

        $this->assertContains($schemeWithContent1->id_skema, $schemeIds);
        $this->assertContains($schemeWithContent2->id_skema, $schemeIds);
        $this->assertNotContains($schemeWithoutContent->id_skema, $schemeIds);
    }
}
