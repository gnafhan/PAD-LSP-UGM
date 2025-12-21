<?php

namespace Database\Factories;

use App\Models\AssessmentContent;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssessmentContent>
 */
class AssessmentContentFactory extends Factory
{
    protected $model = AssessmentContent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_skema' => Skema::factory(),
            'assessment_type' => $this->faker->randomElement(AssessmentContent::CONTENT_ASSESSMENT_TYPES),
            'content_type' => $this->faker->randomElement(AssessmentContent::CONTENT_TYPES),
            'content_data' => $this->generateContentData(),
            'created_by' => User::factory(),
            'display_order' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Generate random content data based on content type
     */
    private function generateContentData(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'instructions' => $this->faker->sentences(3),
        ];
    }

    /**
     * State for multiple choice content
     */
    public function multipleChoice(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'content_type' => 'multiple_choice',
                'content_data' => [
                    'question' => $this->faker->sentence() . '?',
                    'options' => [
                        ['id' => 'a', 'text' => $this->faker->sentence()],
                        ['id' => 'b', 'text' => $this->faker->sentence()],
                        ['id' => 'c', 'text' => $this->faker->sentence()],
                        ['id' => 'd', 'text' => $this->faker->sentence()],
                    ],
                    'correct_answer' => $this->faker->randomElement(['a', 'b', 'c', 'd']),
                ],
            ];
        });
    }

    /**
     * State for essay content
     */
    public function essay(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'content_type' => 'essay',
                'content_data' => [
                    'question' => $this->faker->paragraph(),
                    'min_words' => $this->faker->numberBetween(50, 100),
                    'max_words' => $this->faker->numberBetween(200, 500),
                    'rubric' => $this->faker->sentences(5),
                ],
            ];
        });
    }

    /**
     * State for practical task content
     */
    public function practicalTask(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'content_type' => 'practical_task',
                'content_data' => [
                    'title' => $this->faker->sentence(),
                    'instructions' => $this->faker->paragraphs(3),
                    'duration_minutes' => $this->faker->numberBetween(30, 180),
                    'materials_needed' => $this->faker->words(5),
                ],
            ];
        });
    }
}
