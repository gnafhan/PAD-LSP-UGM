<?php

namespace Database\Seeders;

use App\Models\Skema;
use Illuminate\Database\Seeder;
use App\Models\UK;

class SkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the uk by kode_uk to fetch their auto-generated IDs
        $UK1 = UK::where('kode_uk', 'J.620100.009.02')->first();
        $UK2 = UK::where('kode_uk', 'J.620100.013.07')->first();
        $UK3 = UK::where('kode_uk', 'J.620100.027.02')->first();
        $UK4 = UK::where('kode_uk', 'J.450100.027.02')->first();
        $UK5 = UK::where('kode_uk', 'J.6289700.027.02')->first();
        $data = [

            [
                'nomor_skema' => 'SKM/0317/00010/2/2019/22',
                'nama_skema' => 'Programmer',
                'dokumen_skkni' => 'skkni/skkni_Programmer.pdf',
                'daftar_id_uk' => json_encode([$UK1->id_uk, $UK2->id_uk]),
                'persyaratan_skema' => 'Ijazah Terakhir, Pas Photo Berwarna, KTP/KK/Paspor, Transkrip Nilai, Bukti Magang/ Kerja Praktek',
            ],
            [
                'nomor_skema' => 'SKM/2988/00010/2/2021/34',
                'nama_skema' => 'Backend Developer',
                'dokumen_skkni' => 'skkni/skkni_Backend_Developer.pdf',
                'daftar_id_uk' => json_encode([$UK3->id_uk, $UK4->id_uk]),
                'persyaratan_skema' => 'Ijazah Terakhir, Pas Photo Berwarna, KTP/KK/Paspor, Transkrip Nilai, Bukti Magang/ Kerja Praktek',
            ],
            [
                'nomor_skema' => 'SKM/3111/00010/2/2022/65',
                'nama_skema' => 'Data Science',
                'dokumen_skkni' => 'skkni/skkni_Data_Science.pdf',
                'daftar_id_uk' => json_encode([$UK1->id_uk, $UK3->id_uk, $UK5->id_uk]),
                'persyaratan_skema' => 'Ijazah Terakhir, Pas Photo Berwarna, KTP/KK/Paspor, Transkrip Nilai, Bukti Magang/ Kerja Praktek',
            ],
        ];

        foreach ($data as $item) {
            Skema::create($item);
        }
    }
}
