<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\Skema;
use App\Models\Soal;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: IA05 Question Validation
 * 
 * Property 2: For any multiple choice question creation, the system SHALL require
 * question text, at least 2 non-empty answer options, and a valid correct answer marking.
 * 
 * Validates: Requirements 1.2
 */
class IA05QuestionValidationPropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;
    protected Skema $scheme;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
        $this->scheme = Skema::factory()->create();
    }

    /**
     * Property: Valid questions with all required fields are created successfully.
     */
    public function test_valid_questions_are_created_successfully(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $correctAnswer = fake()->randomElement(['a', 'b', 'c', 'd', 'e']);
            
            $data = [
                'pertanyaan' => fake()->sentence() . '?',
                'jawaban_a' => fake()->sentence(),
                'jawaban_b' => fake()->sentence(),
                'jawaban_c' => fake()->boolean(70) ? fake()->sentence() : null,
                'jawaban_d' => fake()->boolean(50) ? fake()->sentence() : null,
                'jawaban_e' => fake()->boolean(30) ? fake()->sentence() : null,
                'jawaban_benar' => $correctAnswer,
            ];

            // Ensure at least 2 options are filled and correct answer is filled
            $data['jawaban_a'] = fake()->sentence();
            $data['jawaban_b'] = fake()->sentence();
            $data['jawaban_' . $correctAnswer] = fake()->sentence();

            $question = $this->service->createIA05Question($this->scheme->id_skema, $data);

            $this->assertInstanceOf(Soal::class, $question);
            $this->assertEquals($this->scheme->id_skema, $question->id_skema);
            $this->assertEquals($data['pertanyaan'], $question->pertanyaan);
            $this->assertEquals($correctAnswer, $question->jawaban_benar);
        }
    }

    /**
     * Property: Questions without question text are rejected.
     */
    public function test_questions_without_text_are_rejected(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'pertanyaan' => '', // Empty question text
                'jawaban_a' => fake()->sentence(),
                'jawaban_b' => fake()->sentence(),
                'jawaban_benar' => 'a',
            ];

            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Pertanyaan tidak boleh kosong');
            
            $this->service->createIA05Question($this->scheme->id_skema, $data);
        }
    }

    /**
     * Property: Questions with null question text are rejected.
     */
    public function test_questions_with_null_text_are_rejected(): void
    {
        $data = [
            'pertanyaan' => null,
            'jawaban_a' => fake()->sentence(),
            'jawaban_b' => fake()->sentence(),
            'jawaban_benar' => 'a',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Pertanyaan tidak boleh kosong');
        
        $this->service->createIA05Question($this->scheme->id_skema, $data);
    }

    /**
     * Property: Questions with less than 2 answer options are rejected.
     */
    public function test_questions_with_insufficient_options_are_rejected(): void
    {
        // Test with only 1 option
        $data = [
            'pertanyaan' => fake()->sentence() . '?',
            'jawaban_a' => fake()->sentence(),
            'jawaban_b' => null,
            'jawaban_c' => null,
            'jawaban_d' => null,
            'jawaban_e' => null,
            'jawaban_benar' => 'a',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimal 2 opsi jawaban harus diisi');
        
        $this->service->createIA05Question($this->scheme->id_skema, $data);
    }

    /**
     * Property: Questions with empty answer options are rejected.
     */
    public function test_questions_with_empty_options_are_rejected(): void
    {
        $data = [
            'pertanyaan' => fake()->sentence() . '?',
            'jawaban_a' => '',
            'jawaban_b' => '',
            'jawaban_c' => '',
            'jawaban_d' => '',
            'jawaban_e' => '',
            'jawaban_benar' => 'a',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Minimal 2 opsi jawaban harus diisi');
        
        $this->service->createIA05Question($this->scheme->id_skema, $data);
    }

    /**
     * Property: Questions without correct answer marking are rejected.
     */
    public function test_questions_without_correct_answer_are_rejected(): void
    {
        $data = [
            'pertanyaan' => fake()->sentence() . '?',
            'jawaban_a' => fake()->sentence(),
            'jawaban_b' => fake()->sentence(),
            'jawaban_benar' => '', // Empty correct answer
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Jawaban benar harus dipilih');
        
        $this->service->createIA05Question($this->scheme->id_skema, $data);
    }

    /**
     * Property: Questions with invalid correct answer marking are rejected.
     */
    public function test_questions_with_invalid_correct_answer_are_rejected(): void
    {
        $invalidAnswers = ['f', 'g', '1', 'x', 'ab'];
        
        foreach ($invalidAnswers as $invalidAnswer) {
            $data = [
                'pertanyaan' => fake()->sentence() . '?',
                'jawaban_a' => fake()->sentence(),
                'jawaban_b' => fake()->sentence(),
                'jawaban_benar' => $invalidAnswer,
            ];

            try {
                $this->service->createIA05Question($this->scheme->id_skema, $data);
                $this->fail("Expected exception for invalid answer: $invalidAnswer");
            } catch (\InvalidArgumentException $e) {
                $this->assertStringContainsString('Jawaban benar harus dipilih dari opsi yang tersedia', $e->getMessage());
            }
        }
    }

    /**
     * Property: Correct answer must reference a filled option.
     */
    public function test_correct_answer_must_reference_filled_option(): void
    {
        $data = [
            'pertanyaan' => fake()->sentence() . '?',
            'jawaban_a' => fake()->sentence(),
            'jawaban_b' => fake()->sentence(),
            'jawaban_c' => null, // Option C is empty
            'jawaban_d' => null,
            'jawaban_e' => null,
            'jawaban_benar' => 'c', // But correct answer is C
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Jawaban benar harus dipilih dari opsi yang tersedia');
        
        $this->service->createIA05Question($this->scheme->id_skema, $data);
    }

    /**
     * Property: Questions with exactly 2 valid options are accepted.
     */
    public function test_questions_with_exactly_two_options_are_accepted(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'pertanyaan' => fake()->sentence() . '?',
                'jawaban_a' => fake()->sentence(),
                'jawaban_b' => fake()->sentence(),
                'jawaban_c' => null,
                'jawaban_d' => null,
                'jawaban_e' => null,
                'jawaban_benar' => fake()->randomElement(['a', 'b']),
            ];

            $question = $this->service->createIA05Question($this->scheme->id_skema, $data);

            $this->assertInstanceOf(Soal::class, $question);
            $this->assertNotNull($question->jawaban_a);
            $this->assertNotNull($question->jawaban_b);
        }
    }

    /**
     * Property: Display order is automatically assigned.
     */
    public function test_display_order_is_automatically_assigned(): void
    {
        $questions = [];
        
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'pertanyaan' => "Question $i?",
                'jawaban_a' => fake()->sentence(),
                'jawaban_b' => fake()->sentence(),
                'jawaban_benar' => 'a',
            ];

            $questions[] = $this->service->createIA05Question($this->scheme->id_skema, $data);
        }

        // Verify display orders are sequential
        for ($i = 0; $i < count($questions); $i++) {
            $this->assertEquals($i, $questions[$i]->display_order, 
                "Question $i should have display_order $i");
        }
    }
}
