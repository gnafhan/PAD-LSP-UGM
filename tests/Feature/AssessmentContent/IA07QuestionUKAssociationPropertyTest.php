<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\ElemenUK;
use App\Models\IA07Question;
use App\Models\Skema;
use App\Models\UK;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: IA07 Question UK Association
 * 
 * Property 7: For any IA07 oral question, the question SHALL be associated with
 * a valid unit kompetensi and elemen UK from the scheme.
 * 
 * Validates: Requirements 3.2
 */
class IA07QuestionUKAssociationPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: Questions with valid UK and elemen are created successfully.
     */
    public function test_questions_with_valid_uk_and_elemen_are_created(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create UK and ElemenUK
            $uk = UK::factory()->create();
            $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);

            // Create scheme with the UK
            $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

            $data = [
                'id_uk' => $uk->id_uk,
                'id_elemen_uk' => $elemenUk->id_elemen_uk,
                'pertanyaan' => fake()->sentence() . '?',
            ];

            $question = $this->service->createIA07Question($scheme->id_skema, $data);

            $this->assertInstanceOf(IA07Question::class, $question);
            $this->assertEquals($scheme->id_skema, $question->id_skema);
            $this->assertEquals($uk->id_uk, $question->id_uk);
            $this->assertEquals($elemenUk->id_elemen_uk, $question->id_elemen_uk);
        }
    }

    /**
     * Property: Questions with UK not in scheme are rejected.
     */
    public function test_questions_with_invalid_uk_are_rejected(): void
    {
        // Create UK and ElemenUK
        $uk1 = UK::factory()->create();
        $uk2 = UK::factory()->create();
        $elemenUk2 = ElemenUK::factory()->create(['id_uk' => $uk2->id_uk]);

        // Create scheme with only uk1
        $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk1->id_uk]]);

        $data = [
            'id_uk' => $uk2->id_uk, // UK not in scheme
            'id_elemen_uk' => $elemenUk2->id_elemen_uk,
            'pertanyaan' => fake()->sentence() . '?',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unit kompetensi tidak valid untuk skema ini');

        $this->service->createIA07Question($scheme->id_skema, $data);
    }

    /**
     * Property: Questions without UK are rejected.
     */
    public function test_questions_without_uk_are_rejected(): void
    {
        $uk = UK::factory()->create();
        $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
        $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

        $data = [
            'id_uk' => null,
            'id_elemen_uk' => $elemenUk->id_elemen_uk,
            'pertanyaan' => fake()->sentence() . '?',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unit kompetensi harus dipilih');

        $this->service->createIA07Question($scheme->id_skema, $data);
    }

    /**
     * Property: Questions without elemen UK are rejected.
     */
    public function test_questions_without_elemen_uk_are_rejected(): void
    {
        $uk = UK::factory()->create();
        $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

        $data = [
            'id_uk' => $uk->id_uk,
            'id_elemen_uk' => null,
            'pertanyaan' => fake()->sentence() . '?',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Elemen UK harus dipilih');

        $this->service->createIA07Question($scheme->id_skema, $data);
    }

    /**
     * Property: Questions without pertanyaan are rejected.
     */
    public function test_questions_without_pertanyaan_are_rejected(): void
    {
        $uk = UK::factory()->create();
        $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
        $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

        $data = [
            'id_uk' => $uk->id_uk,
            'id_elemen_uk' => $elemenUk->id_elemen_uk,
            'pertanyaan' => '',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Pertanyaan tidak boleh kosong');

        $this->service->createIA07Question($scheme->id_skema, $data);
    }

    /**
     * Property: Created questions have correct relationships loaded.
     */
    public function test_questions_have_correct_relationships(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $uk = UK::factory()->create();
            $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
            $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

            $data = [
                'id_uk' => $uk->id_uk,
                'id_elemen_uk' => $elemenUk->id_elemen_uk,
                'pertanyaan' => fake()->sentence() . '?',
            ];

            $this->service->createIA07Question($scheme->id_skema, $data);

            // Retrieve with relationships
            $questions = $this->service->getIA07Questions($scheme->id_skema);
            $question = $questions->first();

            $this->assertNotNull($question->unitKompetensi);
            $this->assertEquals($uk->id_uk, $question->unitKompetensi->id_uk);
            $this->assertNotNull($question->elemenUK);
            $this->assertEquals($elemenUk->id_elemen_uk, $question->elemenUK->id_elemen_uk);
        }
    }

    /**
     * Property: Questions can be grouped by UK and elemen.
     */
    public function test_questions_can_be_grouped_by_uk_and_elemen(): void
    {
        // Create multiple UKs with multiple elements
        $uk1 = UK::factory()->create();
        $uk2 = UK::factory()->create();
        $elemen1a = ElemenUK::factory()->create(['id_uk' => $uk1->id_uk]);
        $elemen1b = ElemenUK::factory()->create(['id_uk' => $uk1->id_uk]);
        $elemen2a = ElemenUK::factory()->create(['id_uk' => $uk2->id_uk]);

        $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk1->id_uk, $uk2->id_uk]]);

        // Create questions for different UK/elemen combinations
        $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk1->id_uk,
            'id_elemen_uk' => $elemen1a->id_elemen_uk,
            'pertanyaan' => 'Question 1a-1',
        ]);
        $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk1->id_uk,
            'id_elemen_uk' => $elemen1a->id_elemen_uk,
            'pertanyaan' => 'Question 1a-2',
        ]);
        $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk1->id_uk,
            'id_elemen_uk' => $elemen1b->id_elemen_uk,
            'pertanyaan' => 'Question 1b-1',
        ]);
        $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk2->id_uk,
            'id_elemen_uk' => $elemen2a->id_elemen_uk,
            'pertanyaan' => 'Question 2a-1',
        ]);

        // Get grouped questions
        $grouped = $this->service->getIA07QuestionsGrouped($scheme->id_skema);

        // Verify grouping
        $this->assertCount(2, $grouped); // 2 UKs
        $this->assertTrue($grouped->has($uk1->id_uk));
        $this->assertTrue($grouped->has($uk2->id_uk));

        // UK1 has 2 elements
        $this->assertCount(2, $grouped[$uk1->id_uk]);
        // UK2 has 1 element
        $this->assertCount(1, $grouped[$uk2->id_uk]);

        // Elemen 1a has 2 questions
        $this->assertCount(2, $grouped[$uk1->id_uk][$elemen1a->id_elemen_uk]);
        // Elemen 1b has 1 question
        $this->assertCount(1, $grouped[$uk1->id_uk][$elemen1b->id_elemen_uk]);
    }

    /**
     * Property: Display order is automatically assigned per elemen.
     */
    public function test_display_order_is_assigned_per_elemen(): void
    {
        $uk = UK::factory()->create();
        $elemen1 = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
        $elemen2 = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
        $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

        // Create questions for elemen1
        $q1 = $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk->id_uk,
            'id_elemen_uk' => $elemen1->id_elemen_uk,
            'pertanyaan' => 'E1 Question 1',
        ]);
        $q2 = $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk->id_uk,
            'id_elemen_uk' => $elemen1->id_elemen_uk,
            'pertanyaan' => 'E1 Question 2',
        ]);

        // Create questions for elemen2
        $q3 = $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk->id_uk,
            'id_elemen_uk' => $elemen2->id_elemen_uk,
            'pertanyaan' => 'E2 Question 1',
        ]);

        // Verify display orders
        $this->assertEquals(0, $q1->display_order);
        $this->assertEquals(1, $q2->display_order);
        $this->assertEquals(0, $q3->display_order); // Resets for new elemen
    }

    /**
     * Property: Only active questions are returned by default.
     */
    public function test_only_active_questions_are_returned(): void
    {
        $uk = UK::factory()->create();
        $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
        $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

        // Create active and inactive questions
        $activeQuestion = $this->service->createIA07Question($scheme->id_skema, [
            'id_uk' => $uk->id_uk,
            'id_elemen_uk' => $elemenUk->id_elemen_uk,
            'pertanyaan' => 'Active question',
            'is_active' => true,
        ]);

        IA07Question::create([
            'id_skema' => $scheme->id_skema,
            'id_uk' => $uk->id_uk,
            'id_elemen_uk' => $elemenUk->id_elemen_uk,
            'pertanyaan' => 'Inactive question',
            'is_active' => false,
            'display_order' => 1,
        ]);

        // Get questions (should only return active)
        $questions = $this->service->getIA07Questions($scheme->id_skema);

        $this->assertCount(1, $questions);
        $this->assertEquals($activeQuestion->id, $questions->first()->id);
    }
}
