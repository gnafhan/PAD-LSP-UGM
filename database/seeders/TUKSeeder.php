<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TUK;

class TUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_tuk' => 'T.239000.12',
                'nama_tuk' => 'TILC',
                'alamat' => 'Sekip Utara, Blimbingsari, Sleman',
                'id_penanggung_jawab' => 'PENANGGUNG_JAWAB1',
                'no_lisensi_skkn' => 'S/456/234',
            ],
            [
                'kode_tuk' => 'T.539300.12',
                'nama_tuk' => 'DTEDI',
                'alamat' => 'Sekip Barat, Sendowo, Sleman',
                'id_penanggung_jawab' => 'PENANGGUNG_JAWAB2',
                'no_lisensi_skkn' => 'S/123/234',
            ],
        ];

        foreach ($data as $item) {
            TUK::create($item);
        }
    }
}
