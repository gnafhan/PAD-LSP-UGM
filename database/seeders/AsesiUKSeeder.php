<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AsesiUK;

class AsesiUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_asesi' => 'ASESI1',
                'id_uk' => 'UK1',
                'elemen_uk' => 'Memahami dasar-dasar keselamatan kerja',
                'jawaban_elemen_uk' => 'true; false; true; true',
                'file_bukti' => json_encode(['sertifikat_keselamatan.pdf', 'surat_pernyataan.pdf']), //nullable, jadi untuk sementara ini buat agar menjadi null dulu
            ],
            [
                'id_asesi' => 'ASESI2',
                'id_uk' => 'UK2',
                'elemen_uk' => 'Menguasai teknik dasar pemrograman',
                'jawaban_elemen_uk' => 'true; false; true; true',
                'file_bukti' => json_encode(['laporan_kursus.pdf', 'contoh_project.pdf']),
            ],
            [
                'id_asesi' => 'ASESI3',
                'id_uk' => 'UK3',
                'elemen_uk' => 'Menguasai pengolahan data menggunakan Excel',
                'jawaban_elemen_uk' => 'true; false; true; true',
                'file_bukti' => json_encode(['excel_tutorial.pdf', 'laporan_data.xlsx']),
            ],
        ];

        foreach ($data as $item) {
            AsesiUK::create($item);
        }
    }
}
