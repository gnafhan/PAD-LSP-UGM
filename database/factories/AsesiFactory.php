<?php

namespace Database\Factories;

use App\Models\Asesi;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asesi>
 */
class AsesiFactory extends Factory
{
    protected $model = Asesi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_asesi' => $this->faker->name(),
            'tempat_tanggal_lahir' => $this->faker->city() . ', ' . $this->faker->date('d F Y'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'kebangsaan' => 'Indonesia',
            'alamat_rumah' => $this->faker->address(),
            'kota_domisili' => $this->faker->city(),
            'no_telp' => $this->faker->numerify('08##########'),
            'no_telp_rumah' => $this->faker->numerify('0##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'nim' => $this->faker->numerify('##########'),
            'id_user' => User::factory(),
            'id_skema' => Skema::factory(),
            'file_kelengkapan_pemohon' => [], // JSON field - empty array as default
            'ttd_pemohon' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==', // Placeholder signature
            'status_pekerjaan' => $this->faker->randomElement(['Mahasiswa', 'Karyawan', 'Wiraswasta']),
            'nama_perusahaan' => $this->faker->company(),
            'jabatan' => $this->faker->jobTitle(),
            'alamat_perusahaan' => $this->faker->address(),
            'no_telp_perusahaan' => $this->faker->numerify('0##########'),
        ];
    }

    /**
     * Configure the model factory to use a specific skema.
     */
    public function forSkema(Skema $skema): static
    {
        return $this->state(fn (array $attributes) => [
            'id_skema' => $skema->id_skema,
        ]);
    }
}
