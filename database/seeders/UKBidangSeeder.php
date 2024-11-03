<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UkBidang;

class UKBidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $index) {
            UkBidang::create([
                'id_bidang' => 'BID' . str_pad($index, 3, '0', STR_PAD_LEFT),
                'nama_bidang' => fake()->sentence(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
