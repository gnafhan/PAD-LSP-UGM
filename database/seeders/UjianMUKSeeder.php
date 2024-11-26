<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UjianMUK;

class UjianMUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_asesi' => 'ASESI1',
                'id_asesor' => 'ASESOR1',
                'tgl_ujian' => '2024-11-25',
                'status_ujian' => 'On process',
                'nilai_kompetensi' => 0,
                'id_tuk' => 'TUK1',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '11:00:00',
                'id_muk' => 'MUK1',
                'tipe_ujian' => 'Offline'
            ],
            [
                'id_asesi' => 'ASESI2',
                'id_asesor' => 'ASESOR2',
                'tgl_ujian' => '2024-11-26',
                'status_ujian' => 'Pending',
                'nilai_kompetensi' => 0,
                'id_tuk' => 'TUK2',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'id_muk' => 'MUK2',
                'tipe_ujian' => 'Online'
            ],
            [
                'id_asesi' => 'ASESI3',
                'id_asesor' => 'ASESOR3',
                'tgl_ujian' => '2024-11-27',
                'status_ujian' => 'Completed',
                'nilai_kompetensi' => 85,
                'id_tuk' => 'TUK1',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'id_muk' => 'MUK3',
                'tipe_ujian' => 'Offline'
            ],
        ];

        foreach ($data as $item) {
            UjianMUK::create($item);
        }
    }
}
