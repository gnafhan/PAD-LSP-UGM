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
    public function run(): void
    {
        $data = [
            [
                'kode_uk' => 'J.620100.009.02',
                'nama_uk' => 'Melakukan coding sederhana',
                'elemen_uk' => 'Mengidentifikasi coding sederhana; Mengidentifikasi basic coding',
                'id_bidang' => null,
                'jenis_standar' => 'Internasional',
            ],
            [
                'kode_uk' => 'J.620100.013.07',
                'nama_uk' => 'Menulis kode dengan kaidah yang baik',
                'elemen_uk' => 'Mengidentifikasi penulisan kode dengan kaidah yang baik; Mengidentifikasi kaidah',
                'id_bidang' => null,
                'jenis_standar' => 'SKKNI',
            ],
            [
                'kode_uk' => 'J.620100.027.02',
                'nama_uk' => 'Mengimplementasikan pemrograman kotlin',
                'elemen_uk' => 'Mengidentifikasi pemmrograman kotlin; Mengidentifikasi cara coding kotlin',
                'id_bidang' => null,
                'jenis_standar' => 'SKKNI',
            ],
            [
                'kode_uk' => 'J.450100.027.02',
                'nama_uk' => 'Melakukan visualisasi data',
                'elemen_uk' => 'Mengidentifikasi cara visualisasi data; Mengidentifikasi cara mengolah data',
                'id_bidang' => null,
                'jenis_standar' => 'Nasional',
            ],
            [
                'kode_uk' => 'J.6289700.027.02',
                'nama_uk' => 'Membuat contoh model machine learning',
                'elemen_uk' => 'Mengidentifikasi contoh model; Mengidentifikasi training model',
                'id_bidang' => null,
                'jenis_standar' => 'Internasional',
            ],

        ];

        foreach ($data as $item) {
            UK::create($item);
        }
    }
}
