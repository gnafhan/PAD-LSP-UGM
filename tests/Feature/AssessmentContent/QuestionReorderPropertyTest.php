<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\Skema;
use App\Models\Soal;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: Question Reorder Persistence
 * 
 * Property 5: For any reorder operation on IA05 questions, the new display order
 * SHALL be persisted and reflected in subsequent queries.
 * 
 * Validates: Requirements 1.5
 */
class QuestionReorderPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: Reorder operation persists new order.
     */
    public function test_reorder_operation_persists_new_order(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $scheme = Skema::factory()->create();

            // Create questions with initial order
            $questionCount = fake()->numberBetween(3, 7);
            $questions = [];
            for ($j = 0; $j < $questionCount; $j++) {
                $questions[] = Soal::factory()->create([
                    'id_skema' => $scheme->id_skema,
                    'pertanyaan' => "Question $j",
                    'display_order' => $j,
                ]);
            }

            // Create new random order
            $kodeSoals = collect($questions)->pluck('kode_soal')->toArray();
            shuffle($kodeSoals);

            // Reorder
            $result = $this->service->reorderIA05Questions($scheme->id_skema, $kodeSoals);
            $this->assertTrue($result);

            // Verify new order is persisted
            $reorderedQuestions = $this->service->getIA05Questions($scheme->id_skema);
            
            foreach ($kodeSoals as $expectedOrder => $kodeSoal) {
                $question = $reorderedQuestions->firstWhere('kode_soal', $kodeSoal);
                $this->assertEquals($expectedOrder, $question->display_order,
                    "Question $kodeSoal should have display_order $expectedOrder");
            }
        }
    }

    /**
     * Property: Reordered questions are returned in correct order.
     */
    public function test_reordered_questions_returned_in_correct_order(): void
    {
        $scheme = Skema::factory()->create();

        // Create questions
        $q1 = Soal::factory()->create(['id_skema' => $scheme->id_skema, 'pertanyaan' => 'Q1', 'display_order' => 0]);
        $q2 = Soal::factory()->create(['id_skema' => $scheme->id_skema, 'pertanyaan' => 'Q2', 'display_order' => 1]);
        $q3 = Soal::factory()->create(['id_skema' => $scheme->id_skema, 'pertanyaan' => 'Q3', 'display_order' => 2]);

        // Reorder: Q3, Q1, Q2
        $newOrder = [$q3->kode_soal, $q1->kode_soal, $q2->kode_soal];
        $this->service->reorderIA05Questions($scheme->id_skema, $newOrder);

        // Get questions (should be ordered by display_order)
        $questions = $this->service->getIA05Questions($scheme->id_skema);

        $this->assertEquals('Q3', $questions[0]->pertanyaan);
        $this->assertEquals('Q1', $questions[1]->pertanyaan);
        $this->assertEquals('Q2', $questions[2]->pertanyaan);
    }

    /**
     * Property: Reorder is atomic (all or nothing).
     */
    public function test_reorder_is_atomic(): void
    {
        $scheme = Skema::factory()->create();

        // Create questions with initial order 0,1,2,3
        $questions = [];
        for ($i = 0; $i < 4; $i++) {
            $questions[] = Soal::factory()->create([
                'id_skema' => $scheme->id_skema,
                'display_order' => $i,
            ]);
        }

        // Reorder to: 3,2,1,0 (complete reverse)
        $newOrder = [
            $questions[3]->kode_soal,
            $questions[2]->kode_soal,
            $questions[1]->kode_soal,
            $questions[0]->kode_soal,
        ];
        $this->service->reorderIA05Questions($scheme->id_skema, $newOrder);

        // Verify all questions have new order
        foreach ($questions as $question) {
            $question->refresh();
        }

        // Verify the new order is correct
        $this->assertEquals(3, $questions[0]->display_order); // Was 0, now 3
        $this->assertEquals(2, $questions[1]->display_order); // Was 1, now 2
        $this->assertEquals(1, $questions[2]->display_order); // Was 2, now 1
        $this->assertEquals(0, $questions[3]->display_order); // Was 3, now 0
    }

    /**
     * Property: Reorder only affects specified scheme.
     */
    public function test_reorder_only_affects_specified_scheme(): void
    {
        $scheme1 = Skema::factory()->create();
        $scheme2 = Skema::factory()->create();

        // Create questions for both schemes
        $scheme1Questions = [];
        $scheme2Questions = [];
        for ($i = 0; $i < 3; $i++) {
            $scheme1Questions[] = Soal::factory()->create([
                'id_skema' => $scheme1->id_skema,
                'display_order' => $i,
            ]);
            $scheme2Questions[] = Soal::factory()->create([
                'id_skema' => $scheme2->id_skema,
                'display_order' => $i,
            ]);
        }

        // Record scheme2's original order
        $scheme2OriginalOrder = collect($scheme2Questions)
            ->mapWithKeys(fn($q) => [$q->kode_soal => $q->display_order])
            ->toArray();

        // Reorder scheme1
        $newOrder = collect($scheme1Questions)->pluck('kode_soal')->reverse()->toArray();
        $this->service->reorderIA05Questions($scheme1->id_skema, $newOrder);

        // Verify scheme2's order is unchanged
        foreach ($scheme2Questions as $question) {
            $question->refresh();
            $this->assertEquals(
                $scheme2OriginalOrder[$question->kode_soal],
                $question->display_order,
                "Scheme2's question order should be unchanged"
            );
        }
    }

    /**
     * Property: Partial reorder updates only specified questions.
     */
    public function test_partial_reorder_updates_specified_questions(): void
    {
        $scheme = Skema::factory()->create();

        // Create 5 questions
        $questions = [];
        for ($i = 0; $i < 5; $i++) {
            $questions[] = Soal::factory()->create([
                'id_skema' => $scheme->id_skema,
                'display_order' => $i,
            ]);
        }

        // Reorder only first 3 questions
        $partialOrder = [
            $questions[2]->kode_soal,
            $questions[0]->kode_soal,
            $questions[1]->kode_soal,
        ];
        $this->service->reorderIA05Questions($scheme->id_skema, $partialOrder);

        // Verify first 3 have new order
        $questions[0]->refresh();
        $questions[1]->refresh();
        $questions[2]->refresh();

        $this->assertEquals(1, $questions[0]->display_order);
        $this->assertEquals(2, $questions[1]->display_order);
        $this->assertEquals(0, $questions[2]->display_order);

        // Questions 4 and 5 should be unchanged
        $questions[3]->refresh();
        $questions[4]->refresh();
        $this->assertEquals(3, $questions[3]->display_order);
        $this->assertEquals(4, $questions[4]->display_order);
    }

    /**
     * Property: Empty reorder array doesn't cause errors.
     */
    public function test_empty_reorder_array_doesnt_cause_errors(): void
    {
        $scheme = Skema::factory()->create();

        // Create questions
        $question = Soal::factory()->create([
            'id_skema' => $scheme->id_skema,
            'display_order' => 0,
        ]);

        $originalOrder = $question->display_order;

        // Reorder with empty array
        $result = $this->service->reorderIA05Questions($scheme->id_skema, []);
        $this->assertTrue($result);

        // Verify question order is unchanged
        $question->refresh();
        $this->assertEquals($originalOrder, $question->display_order);
    }

    /**
     * Property: Reorder with non-existent kode_soal is handled gracefully.
     */
    public function test_reorder_with_non_existent_kode_soal_is_handled(): void
    {
        $scheme = Skema::factory()->create();

        $question = Soal::factory()->create([
            'id_skema' => $scheme->id_skema,
            'display_order' => 0,
        ]);

        // Reorder with mix of valid and invalid kode_soal
        $result = $this->service->reorderIA05Questions($scheme->id_skema, [
            'NON_EXISTENT_1',
            $question->kode_soal,
            'NON_EXISTENT_2',
        ]);

        $this->assertTrue($result);

        // Valid question should have new order
        $question->refresh();
        $this->assertEquals(1, $question->display_order);
    }
}
