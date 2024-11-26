<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AsesiMUK;

class AsesiMUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_asesi' => 'ASESI1',
                'id_muk' => 'MUK1',
                'file_jawabanMUK' => 'uploads/jawaban1.pdf',
                'id_asesor' => 'ASESOR1',
                'id_ujian' => 'UJIAN1',
            ],
            [
                'id_asesi' => 'ASESI2',
                'id_muk' => 'MUK2',
                'file_jawabanMUK' => 'uploads/jawaban2.pdf',
                'id_asesor' => 'ASESOR2',
                'id_ujian' => 'UJIAN2',
            ],
        ];

        foreach ($data as $item) {
            AsesiMUK::create($item);
        }
    }
}
