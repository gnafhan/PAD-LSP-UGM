<?php

namespace Database\Factories;

use App\Models\ElemenUK;
use App\Models\UK;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ElemenUK>
 */
class ElemenUKFactory extends Factory
{
    protected $model = ElemenUK::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_uk' => UK::factory(),
            'nama_elemen' => $this->faker->sentence(3),
        ];
    }

    /**
     * Create an elemen for a specific UK.
     */
    public function forUK(UK $uk): static
    {
        return $this->state(fn (array $attributes) => [
            'id_uk' => $uk->id_uk,
        ]);
    }
}
