<?php

namespace Database\Seeders;

use App\Models\HasilAsesmen;
use App\Models\RincianAsesmen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HasilAsesmenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rincianAsesmen = RincianAsesmen::all();
        foreach ($rincianAsesmen as $rincian) {
            HasilAsesmen::create([
                'id_rincian_asesmen' => $rincian->id_rincian_asesmen,
                'status' => 'kompeten',
                'tanggal_selesai' => now(),
            ]);
        }
    }
}
