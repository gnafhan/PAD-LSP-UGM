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
                'kode_uk' => 'J.620100.009.01',
                'nama_uk' => 'Menggunakan spesifikasi program',
                'id_bidang' => null,
                'jenis_standar' => 'SKKNI',
            ],
            [
                'kode_uk' => 'J.620100.016.01',
                'nama_uk' => 'Menulis Kode dengan Prinsip sesuai Guidelines dan Best Practices',
                'id_bidang' => null,
                'jenis_standar' => 'SKKNI',
            ],
            [
                'kode_uk' => 'J.620100.017.02',
                'nama_uk' => 'Mengimplementasikan pemrograman terstruktur',
                'id_bidang' => null,
                'jenis_standar' => 'SKKNI',
            ],

        ];

        foreach ($data as $item) {
            UK::create($item);
        }
    }
}
