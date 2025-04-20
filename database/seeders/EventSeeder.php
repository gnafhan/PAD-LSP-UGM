<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

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
                'tanggal_mulai_event' => '2025-03-10',
                'tanggal_berakhir_event' => '2025-06-15',
                'tuk' => 'TILC',
                'tipe_event' => 'Offline',
            ],
            [
                'nama_event' => 'EVENT/999/234',
                'tanggal_mulai_event' => '2025-03-02',
                'tanggal_berakhir_event' => '2025-11-15',
                'tuk' => 'DTEDI',
                'tipe_event' => 'Online',
            ],
        ];

        foreach ($data as $item) {
            Event::create($item);
        }
    }
}
