<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AsesiApl02;

class AsesiApl02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_asesi' => 'ASESI1',
                'daftar_id_asesiUK' => json_encode(['ASESI_UK1', 'ASESI_UK2']),
                'file_portofolio' => json_encode(['portofolio/file1.pdf', 'portofolio/file2.pdf']),
            ],
            [
                'id_asesi' => 'ASESI2',
                'daftar_id_asesiUK' => json_encode(['ASESI_UK2']),
                'file_portofolio' => json_encode(['portofolio/file3.pdf', 'portofolio/file4.pdf']),
            ],
            [
                'id_asesi' => 'ASESI3',
                'daftar_id_asesiUK' => json_encode(['ASESI_UK2', 'ASESI_UK3']),
                'file_portofolio' => json_encode(['portofolio/file5.pdf', 'portofolio/file6.pdf']),
            ],
        ];

        foreach ($data as $item) {
            AsesiApl02::create($item);
        }
    }
}
