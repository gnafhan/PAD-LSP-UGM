<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\TUK;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get TUK IDs from kode tuk
        $tuk1 = 'T.239000.12';
        $tuk2 = 'T.539300.12';
        $tuk1 = TUK::where('kode_tuk', $tuk1)->first();
        $tuk2 = TUK::where('kode_tuk', $tuk2)->first();


        $data = [
            [
                'nama_event' => 'EVENT/678/234',
                'tanggal_mulai_event' => '2025-03-10',
                'tanggal_berakhir_event' => '2025-06-15',
                'tipe_event' => 'Offline',
                'id_tuk' => $tuk1->id_tuk,
                'tahun_pelaksanaan' => '2025',
                'periode_pelaksanaan' => '1',
            ],
            [
                'nama_event' => 'EVENT/999/234',
                'tanggal_mulai_event' => '2025-03-02',
                'tanggal_berakhir_event' => '2025-11-15',
                'tipe_event' => 'Online',
                'id_tuk' => $tuk2->id_tuk,
                'tahun_pelaksanaan' => '2025',
                'periode_pelaksanaan' => '2',
            ],
        ];

        foreach ($data as $item) {
            Event::create($item);
        }
    }
}


