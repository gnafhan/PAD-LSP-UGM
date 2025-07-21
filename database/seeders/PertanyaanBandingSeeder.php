<?php

namespace Database\Seeders;

use App\Models\PertanyaanBanding;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PertanyaanBandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PertanyaanBanding::create([
            'pertanyaan' => 'Apakah Proses Banding telah dijelaskan kepada Anda?',
            'order' => 1,
            'jenis_pertanyaan' => 'true_false',
        ]);
        PertanyaanBanding::create([
            'pertanyaan' => 'Apakah Anda telah mendiskusikan Banding dengan Asesor?',
            'order' => 2,
            'jenis_pertanyaan' => 'true_false',
        ]);
        PertanyaanBanding::create([
            'pertanyaan' => 'Apakah Anda mau melibatkan "orang lain" membantu Anda dalam Proses Banding?',
            'order' => 3,
            'jenis_pertanyaan' => 'true_false',
        ]);
        PertanyaanBanding::create([
            'pertanyaan' => 'Banding ini diajukan atas alasan sebagai berikut :',
            'order' => 4,
            'jenis_pertanyaan' => 'text',
        ]);

    }
}
