<?php

namespace Database\Factories;

use App\Models\Skema;
use App\Models\Soal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Soal>
 */
class SoalFactory extends Factory
{
    protected $model = Soal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_skema' => Skema::factory(),
            'pertanyaan' => $this->faker->sentence() . '?',
            'jawaban_a' => $this->faker->sentence(),
            'jawaban_b' => $this->faker->sentence(),
            'jawaban_c' => $this->faker->sentence(),
            'jawaban_d' => $this->faker->sentence(),
            'jawaban_e' => $this->faker->sentence(),
            'jawaban_benar' => $this->faker->randomElement(['a', 'b', 'c', 'd', 'e']),
            'display_order' => 0,
        ];
    }

    /**
     * Create a question for a specific scheme.
     */
    public function forSkema(Skema $skema): static
    {
        return $this->state(fn (array $attributes) => [
            'id_skema' => $skema->id_skema,
        ]);
    }
}
