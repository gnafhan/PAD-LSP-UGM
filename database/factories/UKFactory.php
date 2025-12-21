<?php

namespace Database\Factories;

use App\Models\UK;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UK>
 */
class UKFactory extends Factory
{
    protected $model = UK::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_uk' => $this->faker->unique()->numerify('UK-###.##'),
            'nama_uk' => $this->faker->sentence(4),
            'id_bidang' => null,
            'jenis_standar' => $this->faker->randomElement(['SKKNI', 'KKNI', 'Standar Khusus']),
        ];
    }
}
