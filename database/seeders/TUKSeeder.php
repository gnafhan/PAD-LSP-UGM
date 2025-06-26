<?php

namespace Database\Seeders;

use App\Models\TUK;
use Illuminate\Database\Seeder;
use App\Models\PenanggungJawab;

class TUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penanggung_jawab1 = PenanggungJawab::where('nama_penanggung_jawab', 'Hirukawa')->first();
        $penanggung_jawab2 = PenanggungJawab::where('nama_penanggung_jawab', 'Hodai')->first();
        $data = [
            [
                'kode_tuk' => 'T.239000.12',
                'nama_tuk' => 'TILC',
                'alamat' => 'Sekip Utara, Blimbingsari, Sleman',
                'id_penanggung_jawab' => $penanggung_jawab1->id_penanggung_jawab,
                'no_lisensi_skkn' => 'S/456/234',
            ],
            [
                'kode_tuk' => 'T.539300.12',
                'nama_tuk' => 'DTEDI',
                'alamat' => 'Sekip Barat, Sendowo, Sleman',
                'id_penanggung_jawab' => $penanggung_jawab2->id_penanggung_jawab,
                'no_lisensi_skkn' => 'S/123/234',
            ],
        ];

        foreach ($data as $item) {
            TUK::create($item);
        }
    }
}
