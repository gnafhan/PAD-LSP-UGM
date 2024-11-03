<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apl02;

class Apl02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (range(1, 10) as $index) {
            Apl02::create([
                'id_apl02' => 'APL' . str_pad($index, 3, '0', STR_PAD_LEFT),
                'id_uk' => 'UK' . str_pad(fake()->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
