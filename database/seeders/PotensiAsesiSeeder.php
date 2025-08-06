<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PotensiAsesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $potensiAsesis = [
            [
                'deskripsi' => 'Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'deskripsi' => 'Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'deskripsi' => 'Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'deskripsi' => 'Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'deskripsi' => 'Pelatihan / belajar mandiri atau otodidak.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('potensi_asesis')->insert($potensiAsesis);
    }
}
