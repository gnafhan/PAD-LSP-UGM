<?php

namespace Database\Seeders;

use App\Models\JawabanBanding;
use App\Models\PertanyaanBanding;
use App\Models\RincianAsesmen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JawabanBandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rincian_asesmen = RincianAsesmen::all();
        $pertanyaan_banding = PertanyaanBanding::all();

        foreach($rincian_asesmen as $rincian){
            foreach($pertanyaan_banding as $pertanyaan){
               if($pertanyaan->jenis_pertanyaan == 'true_false'){
                JawabanBanding::create([
                    'id_pertanyaan_banding' => $pertanyaan->id,
                    'id_rincian_asesmen' => $rincian->id_rincian_asesmen,
                    'jawaban' => "true",
                ]);
               } else if($pertanyaan->jenis_pertanyaan == 'text'){
                JawabanBanding::create([
                    'id_pertanyaan_banding' => $pertanyaan->id,
                    'id_rincian_asesmen' => $rincian->id_rincian_asesmen,
                    'jawaban' => 'text',
                ]);
               }
            }
        }
    }
}
