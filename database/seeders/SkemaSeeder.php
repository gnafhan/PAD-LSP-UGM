<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skema;

class SkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nomor_skema' => 'SKM/0317/00010/2/2019/22',
                'nama_skema' => 'Programmer',
                'dokumen_skkni' => 'skkni/skkni_Programmer.pdf',
                'daftar_id_uk' => json_encode(['UK1', 'UK2']),
                'persyaratan_skema' => 'Ijazah Terakhir, Pas Photo Berwarna, KTP/KK/Paspor, Transkrip Nilai, Bukti Magang/ Kerja Praktek',
            ],
            [
                'nomor_skema' => 'SKM/2988/00010/2/2021/34',
                'nama_skema' => 'Backend Developer',
                'dokumen_skkni' => 'skkni/skkni_Backend_Developer.pdf',
                'daftar_id_uk' => json_encode(['UK3', 'UK4']),
                'persyaratan_skema' => 'Ijazah Terakhir, Pas Photo Berwarna, KTP/KK/Paspor, Transkrip Nilai, Bukti Magang/ Kerja Praktek',
            ],
            [
                'nomor_skema' => 'SKM/3111/00010/2/2022/65',
                'nama_skema' => 'Data Science',
                'dokumen_skkni' => 'skkni/skkni_Data_Science.pdf',
                'daftar_id_uk' => json_encode(['UK3', 'UK4', 'UK5']),
                'persyaratan_skema' => 'Ijazah Terakhir, Pas Photo Berwarna, KTP/KK/Paspor, Transkrip Nilai, Bukti Magang/ Kerja Praktek',
            ],
        ];

        foreach ($data as $item) {
            Skema::create($item);
        }
    }
}
