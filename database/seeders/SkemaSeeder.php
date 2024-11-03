<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skema;

class SkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $index) {
            Skema::create([
                'id_skema' => 'SKM' . str_pad($index, 3, '0', STR_PAD_LEFT),
                'nomor_skema' => 'SKM-' . fake()->unique()->numerify('####'),
                'nama_skema' => fake()->sentence(3),
                'dokumen_skkni' => fake()->randomHtml(),
                'persyaratan_skema' => fake()->paragraph(2),
            ]);
        }
    }
}
