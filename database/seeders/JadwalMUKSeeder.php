<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JadwalMUK;

class JadwalMUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_asesi' => 'ASESI1',
                'id_ujian' => 'UJIAN1',
                'waktu_jadwal' => '2024-12-01 09:00:00',
                'id_asesor' => 'ASESOR1',
            ],
            [
                'id_asesi' => 'ASESI2',
                'id_ujian' => 'UJIAN2',
                'waktu_jadwal' => '2024-12-02 10:30:00',
                'id_asesor' => 'ASESOR2',
            ],
            [
                'id_asesi' => 'ASESI3',
                'id_ujian' => 'UJIAN3',
                'waktu_jadwal' => '2024-12-03 13:45:00',
                'id_asesor' => 'ASESOR3',
            ],
        ];

        foreach ($data as $item) {
            JadwalMUK::create($item);
        }
    }
}
