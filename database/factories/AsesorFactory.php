<?php

namespace Database\Factories;

use App\Models\Asesor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asesor>
 */
class AsesorFactory extends Factory
{
    protected $model = Asesor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_registrasi' => $this->faker->unique()->numerify('REG-####'),
            'nama_asesor' => $this->faker->name(),
            'no_sertifikat' => $this->faker->unique()->numerify('SERT-####'),
            'no_hp' => $this->faker->numerify('08##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'alamat' => $this->faker->address(),
            'status_asesor' => $this->faker->randomElement(['aktif', 'nonaktif']),
            'no_ktp' => $this->faker->numerify('################'),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'kebangsaan' => 'Indonesia',
            'kode_pos' => $this->faker->numerify('#####'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'provinsi' => $this->faker->state(),
            'kabupaten_kota' => $this->faker->city(),
            'masa_berlaku' => $this->faker->dateTimeBetween('now', '+2 years'),
        ];
    }

    /**
     * Configure the model factory to create an asesor with a user.
     */
    public function withUser(): static
    {
        return $this->state(function (array $attributes) {
            $user = User::factory()->create(['level' => 'asesor']);
            return [
                'id_user' => $user->id_user,
            ];
        });
    }
}
