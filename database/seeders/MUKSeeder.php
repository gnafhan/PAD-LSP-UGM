<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MUK;

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
