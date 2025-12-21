<?php

namespace Database\Factories;

use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgresAsesmen>
 */
class ProgresAsesmenFactory extends Factory
{
    protected $model = ProgresAsesmen::class;

    /**
     * Define the model's default state.
     * Note: ia11 is not in the progres_asesmen table migration, so it's excluded.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_asesi' => Asesi::factory(),
            'apl01' => ['completed' => true, 'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'],
            'apl02' => ['completed' => false, 'completed_at' => null],
            'ak01' => ['completed' => false, 'completed_at' => null],
            'konsultasi_pra_uji' => ['completed' => false, 'completed_at' => null],
            'mapa01' => ['completed' => false, 'completed_at' => null],
            'mapa02' => ['completed' => false, 'completed_at' => null],
            'pernyataan_ketidak_berpihakan' => ['completed' => false, 'completed_at' => null],
            'ak07' => ['completed' => false, 'completed_at' => null],
            'ia01' => ['completed' => false, 'completed_at' => null],
            'ia02' => ['completed' => false, 'completed_at' => null],
            'hasil_asesmen' => ['completed' => false, 'completed_at' => null],
            'ak02' => ['completed' => false, 'completed_at' => null],
            'umpan_balik' => ['completed' => false, 'completed_at' => null],
            'ak04' => ['completed' => false, 'completed_at' => null],
        ];
    }

    /**
     * Configure the model factory to use a specific asesi.
     */
    public function forAsesi(Asesi $asesi): static
    {
        return $this->state(fn (array $attributes) => [
            'id_asesi' => $asesi->id_asesi,
        ]);
    }

    /**
     * Configure the model factory with random completion states.
     */
    public function withRandomProgress(): static
    {
        return $this->state(function (array $attributes) {
            $fields = [
                'apl02', 'ak01', 'konsultasi_pra_uji', 'mapa01', 'mapa02',
                'pernyataan_ketidak_berpihakan', 'ak07', 'ia01', 'ia02',
                'hasil_asesmen', 'ak02', 'umpan_balik', 'ak04'
            ];

            $result = [];
            foreach ($fields as $field) {
                $completed = $this->faker->boolean();
                $result[$field] = [
                    'completed' => $completed,
                    'completed_at' => $completed ? now()->format('d-m-Y H:i:s') . ' WIB' : null
                ];
            }

            return $result;
        });
    }
}
