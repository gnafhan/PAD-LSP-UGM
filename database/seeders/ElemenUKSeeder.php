<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ElemenUK;
use App\Models\UK;

class ElemenUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data elemen untuk setiap unit kompetensi
        $elemenData = [
            'J.620100.009.02' => [
                'Mengidentifikasi coding sederhana',
                'Mengidentifikasi basic coding',
            ],
            'J.620100.013.07' => [
                'Mengidentifikasi penulisan kode dengan kaidah yang baik',
                'Mengidentifikasi kaidah',
            ],
            'J.620100.027.02' => [
                'Mengidentifikasi pemmrograman kotlin',
                'Mengidentifikasi cara coding kotlin',
            ],
            'J.450100.027.02' => [
                'Mengidentifikasi cara visualisasi data',
                'Mengidentifikasi cara mengolah data',
            ],
            'J.6289700.027.02' => [
                'Mengidentifikasi contoh model',
                'Mengidentifikasi training model',
            ],
        ];

        // Untuk setiap kode UK, cari UK yang sesuai dan tambahkan elemen-elemennya
        foreach ($elemenData as $kodeUK => $elemens) {
            $uk = UK::where('kode_uk', $kodeUK)->first();
            
            if ($uk) {
                foreach ($elemens as $elemen) {
                    ElemenUK::create([
                        'id_uk' => $uk->id_uk,
                        'nama_elemen' => $elemen
                    ]);
                }
            }
        }
    }
}