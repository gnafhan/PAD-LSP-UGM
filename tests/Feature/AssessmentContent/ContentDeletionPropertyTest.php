<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\ElemenUK;
use App\Models\IA07Question;
use App\Models\IA11Checklist;
use App\Models\Skema;
use App\Models\Soal;
use App\Models\UK;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: Content Deletion Removes Item
 * 
 * Property 4: For any content item that is deleted, the item SHALL no longer
 * be retrievable from the database.
 * 
 * Validates: Requirements 1.4, 3.4, 6.4
 */
class ContentDeletionPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: Deleted IA05 question is not retrievable.
     */
    public function test_deleted_ia05_question_is_not_retrievable(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();

            // Create question
            $question = Soal::factory()->create([
                'id_skema' => $scheme->id_skema,
            ]);

            $kodeSoal = $question->kode_soal;

            // Verify question exists
            $this->assertNotNull(Soal::find($kodeSoal));

            // Delete question
            $result = $this->service->deleteIA05Question($kodeSoal);
            $this->assertTrue($result);

            // Verify question is no longer retrievable
            $this->assertNull(Soal::find($kodeSoal),
                "Deleted IA05 question should not be retrievable");

            // Verify question is not in scheme's questions
            $schemeQuestions = $this->service->getIA05Questions($scheme->id_skema);
            $this->assertFalse($schemeQuestions->contains('kode_soal', $kodeSoal),
                "Deleted question should not appear in scheme's questions");
        }
    }

    /**
     * Property: Deleted IA07 question is not retrievable.
     */
    public function test_deleted_ia07_question_is_not_retrievable(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $uk = UK::factory()->create();
            $elemenUk = ElemenUK::factory()->create(['id_uk' => $uk->id_uk]);
            $scheme = Skema::factory()->create(['daftar_id_uk' => [$uk->id_uk]]);

            // Create question
            $question = IA07Question::create([
                'id_skema' => $scheme->id_skema,
                'id_uk' => $uk->id_uk,
                'id_elemen_uk' => $elemenUk->id_elemen_uk,
                'pertanyaan' => fake()->sentence(),
                'display_order' => 0,
                'is_active' => true,
            ]);

            $questionId = $question->id;

            // Verify question exists
            $this->assertNotNull(IA07Question::find($questionId));

            // Delete question
            $result = $this->service->deleteIA07Question($questionId);
            $this->assertTrue($result);

            // Verify question is no longer retrievable
            $this->assertNull(IA07Question::find($questionId),
                "Deleted IA07 question should not be retrievable");

            // Verify question is not in scheme's questions
            $schemeQuestions = $this->service->getIA07Questions($scheme->id_skema);
            $this->assertFalse($schemeQuestions->contains('id', $questionId),
                "Deleted question should not appear in scheme's IA07 questions");
        }
    }

    /**
     * Property: Deleted IA11 checklist item is not retrievable.
     */
    public function test_deleted_ia11_checklist_item_is_not_retrievable(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();

            // Create checklist item
            $item = IA11Checklist::create([
                'id_skema' => $scheme->id_skema,
                'item_name' => fake()->words(3, true),
                'display_order' => 0,
            ]);

            $itemId = $item->id;

            // Verify item exists
            $this->assertNotNull(IA11Checklist::find($itemId));

            // Delete item
            $result = $this->service->deleteIA11Item($itemId);
            $this->assertTrue($result);

            // Verify item is no longer retrievable
            $this->assertNull(IA11Checklist::find($itemId),
                "Deleted IA11 item should not be retrievable");

            // Verify item is not in scheme's checklist
            $schemeChecklist = $this->service->getIA11Checklist($scheme->id_skema);
            $this->assertFalse($schemeChecklist->contains('id', $itemId),
                "Deleted item should not appear in scheme's IA11 checklist");
        }
    }

    /**
     * Property: Deleting one item doesn't affect other items.
     */
    public function test_deleting_one_item_doesnt_affect_others(): void
    {
        $scheme = Skema::factory()->create();

        // Create multiple questions
        $questions = [];
        for ($i = 0; $i < 5; $i++) {
            $questions[] = Soal::factory()->create([
                'id_skema' => $scheme->id_skema,
                'pertanyaan' => "Question $i",
            ]);
        }

        // Delete middle question
        $deletedQuestion = $questions[2];
        $this->service->deleteIA05Question($deletedQuestion->kode_soal);

        // Verify other questions still exist
        foreach ($questions as $index => $question) {
            if ($index === 2) {
                $this->assertNull(Soal::find($question->kode_soal));
            } else {
                $this->assertNotNull(Soal::find($question->kode_soal),
                    "Question $index should still exist");
            }
        }

        // Verify count is correct
        $remainingQuestions = $this->service->getIA05Questions($scheme->id_skema);
        $this->assertCount(4, $remainingQuestions);
    }

    /**
     * Property: Deleting non-existent item throws exception.
     */
    public function test_deleting_non_existent_item_throws_exception(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->service->deleteIA05Question('NON_EXISTENT_ID');
    }

    /**
     * Property: Deleting non-existent IA07 question throws exception.
     */
    public function test_deleting_non_existent_ia07_question_throws_exception(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->service->deleteIA07Question(999999);
    }

    /**
     * Property: Deleting non-existent IA11 item throws exception.
     */
    public function test_deleting_non_existent_ia11_item_throws_exception(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->service->deleteIA11Item(999999);
    }

    /**
     * Property: Content summary updates after deletion.
     */
    public function test_content_summary_updates_after_deletion(): void
    {
        $scheme = Skema::factory()->create();

        // Create questions
        $question1 = Soal::factory()->create(['id_skema' => $scheme->id_skema]);
        $question2 = Soal::factory()->create(['id_skema' => $scheme->id_skema]);

        // Verify initial count
        $summary = $this->service->getContentSummary($scheme->id_skema);
        $this->assertEquals(2, $summary['ia05_count']);

        // Delete one question
        $this->service->deleteIA05Question($question1->kode_soal);

        // Verify updated count
        $summary = $this->service->getContentSummary($scheme->id_skema);
        $this->assertEquals(1, $summary['ia05_count']);

        // Delete remaining question
        $this->service->deleteIA05Question($question2->kode_soal);

        // Verify count is zero
        $summary = $this->service->getContentSummary($scheme->id_skema);
        $this->assertEquals(0, $summary['ia05_count']);
    }
}
