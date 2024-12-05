<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_event' => 'EVENT/678/234',
                'tanggal_mulai_event' => '2024-12-05',
                'tanggal_berakhir_event' => '2024-12-15',
                'tuk' => 'TILC',
                'tipe_event' => 'Offline',
                // 'daftar_id_skema' => json_encode(['SKEMA3', 'SKEMA2']),
            ],
            [
                'nama_event' => 'EVENT/999/234',
                'tanggal_mulai_event' => '2024-11-05',
                'tanggal_berakhir_event' => '2024-11-15',
                'tuk' => 'DTEDI',
                'tipe_event' => 'Online',
                // 'daftar_id_skema' => json_encode(['SKEMA1', 'SKEMA2']),
            ],
        ];

        foreach ($data as $item) {
            Event::create($item);
        }
    }
}


