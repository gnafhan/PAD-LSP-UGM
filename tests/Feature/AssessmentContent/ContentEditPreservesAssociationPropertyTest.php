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
 * Property Test: Content Edit Preserves Association
 * 
 * Property 3: For any content item (question, checklist item, template) that is edited,
 * the scheme association SHALL remain unchanged after the edit.
 * 
 * Validates: Requirements 1.3, 3.3, 6.3
 */
class ContentEditPreservesAssociationPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: Editing IA05 question preserves scheme association.
     */
    public function test_editing_ia05_question_preserves_scheme_association(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();
            
            // Create question
            $question = Soal::factory()->create([
                'id_skema' => $scheme->id_skema,
                'pertanyaan' => 'Original question',
            ]);

            $originalSchemaId = $question->id_skema;

            // Edit question with various changes
            $updateData = [
                'pertanyaan' => fake()->sentence() . '?',
                'jawaban_a' => fake()->sentence(),
                'jawaban_b' => fake()->sentence(),
                'jawaban_benar' => fake()->randomElement(['a', 'b', 'c', 'd', 'e']),
            ];

            $this->service->updateIA05Question($question->kode_soal, $updateData);

            // Reload and verify scheme association is unchanged
            $question->refresh();
            $this->assertEquals($originalSchemaId, $question->id_skema,
                "Scheme association should be preserved after edit");
        }
    }

    /**
     * Property: Attempting to change scheme via update is ignored.
     */
    public function test_attempting_to_change_scheme_via_update_is_ignored(): void
    {
        $scheme1 = Skema::factory()->create();
        $scheme2 = Skema::factory()->create();

        $question = Soal::factory()->create([
            'id_skema' => $scheme1->id_skema,
        ]);

        // Try to change scheme via update
        $this->service->updateIA05Question($question->kode_soal, [
            'id_skema' => $scheme2->id_skema, // This should be ignored
            'pertanyaan' => 'Updated question',
        ]);

        // Verify scheme is still scheme1
        $question->refresh();
        $this->assertEquals($scheme1->id_skema, $question->id_skema,
            "Scheme change attempt should be ignored");
    }

    /**
     * Property: Editing IA07 question preserves scheme association.
     */
    public function test_editing_ia07_question_preserves_scheme_association(): void
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
                'pertanyaan' => 'Original question',
                'display_order' => 0,
                'is_active' => true,
            ]);

            $originalSchemaId = $question->id_skema;

            // Edit question
            $this->service->updateIA07Question($question->id, [
                'pertanyaan' => fake()->sentence() . '?',
                'is_active' => fake()->boolean(),
            ]);

            // Verify scheme association is unchanged
            $question->refresh();
            $this->assertEquals($originalSchemaId, $question->id_skema,
                "Scheme association should be preserved after IA07 edit");
        }
    }

    /**
     * Property: Editing IA11 checklist item preserves scheme association.
     */
    public function test_editing_ia11_checklist_item_preserves_scheme_association(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();

            // Create checklist item
            $item = IA11Checklist::create([
                'id_skema' => $scheme->id_skema,
                'item_name' => 'Original item',
                'description' => 'Original description',
                'display_order' => 0,
                'is_required' => true,
            ]);

            $originalSchemaId = $item->id_skema;

            // Edit item
            $this->service->updateIA11Item($item->id, [
                'item_name' => fake()->words(3, true),
                'description' => fake()->sentence(),
                'is_required' => fake()->boolean(),
            ]);

            // Verify scheme association is unchanged
            $item->refresh();
            $this->assertEquals($originalSchemaId, $item->id_skema,
                "Scheme association should be preserved after IA11 edit");
        }
    }

    /**
     * Property: Multiple edits preserve scheme association.
     */
    public function test_multiple_edits_preserve_scheme_association(): void
    {
        $scheme = Skema::factory()->create();

        $question = Soal::factory()->create([
            'id_skema' => $scheme->id_skema,
        ]);

        $originalSchemaId = $question->id_skema;

        // Perform multiple edits
        for ($i = 0; $i < 5; $i++) {
            $this->service->updateIA05Question($question->kode_soal, [
                'pertanyaan' => "Edit $i: " . fake()->sentence(),
            ]);

            $question->refresh();
            $this->assertEquals($originalSchemaId, $question->id_skema,
                "Scheme association should be preserved after edit $i");
        }
    }

    /**
     * Property: Edit updates only specified fields.
     */
    public function test_edit_updates_only_specified_fields(): void
    {
        $scheme = Skema::factory()->create();

        $originalData = [
            'id_skema' => $scheme->id_skema,
            'pertanyaan' => 'Original question',
            'jawaban_a' => 'Answer A',
            'jawaban_b' => 'Answer B',
            'jawaban_c' => 'Answer C',
            'jawaban_d' => 'Answer D',
            'jawaban_e' => 'Answer E',
            'jawaban_benar' => 'a',
        ];

        $question = Soal::factory()->create($originalData);

        // Update only pertanyaan
        $this->service->updateIA05Question($question->kode_soal, [
            'pertanyaan' => 'Updated question',
        ]);

        $question->refresh();

        // Verify only pertanyaan changed
        $this->assertEquals('Updated question', $question->pertanyaan);
        $this->assertEquals('Answer A', $question->jawaban_a);
        $this->assertEquals('Answer B', $question->jawaban_b);
        $this->assertEquals('a', $question->jawaban_benar);
        $this->assertEquals($scheme->id_skema, $question->id_skema);
    }
}
