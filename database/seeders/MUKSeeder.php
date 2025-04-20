<?php

namespace Database\Seeders;

use App\Models\MUK;
use Illuminate\Database\Seeder;

class MUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_muk' => 'Materi ujian informatika',
                'file_muk' => 'informatika.pdf',
            ],
            [
                'nama_muk' => 'Materi ujian elektronika',
                'file_muk' => 'elektronika.pdf',
            ],
            [
                'nama_muk' => 'Materi ujian mekanika',
                'file_muk' => 'mekanika.pdf',
            ],
        ];

        foreach ($data as $item) {
            MUK::create($item);
        }
    }
}
