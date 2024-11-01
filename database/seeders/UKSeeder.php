<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UK;

class UKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 10) as $index) {
            UK::create([
                'id_uk' => 'UK' . str_pad($index, 3, '0', STR_PAD_LEFT),
                'nama_uk' => fake()->sentence(2),
                'id_bidang' => 'BID' . str_pad(fake()->numberBetween(1, 5), 3, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
