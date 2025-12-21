<?php

namespace Database\Factories;

use App\Models\Skema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skema>
 */
class SkemaFactory extends Factory
{
    protected $model = Skema::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_skema' => $this->faker->unique()->numerify('SKM-###'),
            'nama_skema' => $this->faker->sentence(3),
            'dokumen_skkni' => $this->faker->url(),
            'daftar_id_uk' => [],
            'persyaratan_skema' => $this->faker->paragraph(),
            'has_complete_info' => $this->faker->boolean(),
        ];
    }
}
