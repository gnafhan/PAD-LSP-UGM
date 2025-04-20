<?php

namespace Database\Seeders;

use App\Models\PenanggungJawab;
use Illuminate\Database\Seeder;

class PenanggungJawabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_penanggung_jawab' => 'Hirukawa',
                'status_penanggung_jawab' => 'Aktif',
            ],
            [
                'nama_penanggung_jawab' => 'Hodai',
                'status_penanggung_jawab' => 'Aktif',
            ],
        ];

        foreach ($data as $item) {
            PenanggungJawab::create($item);
        }
    }
}
