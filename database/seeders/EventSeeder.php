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
            ],
            [
                'nama_event' => 'EVENT/999/234',
                'tanggal_mulai_event' => '2024-11-05',
                'tanggal_berakhir_event' => '2024-11-15',
                'tuk' => 'DTEDI',
                'tipe_event' => 'Online',
            ],
        ];

        foreach ($data as $item) {
            Event::create($item);
        }
    }
}


