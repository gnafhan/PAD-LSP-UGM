<?php

namespace Database\Seeders;

use App\Models\UKBidang;
use Illuminate\Database\Seeder;

class UKBidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Bidang yang sudah ada
            ['nama_bidang' => 'Sosial'],
            ['nama_bidang' => 'Data Science'],
            ['nama_bidang' => 'Keamanan'],
            ['nama_bidang' => 'Budaya'],
            ['nama_bidang' => 'Ekonomi'],
            ['nama_bidang' => 'Hukum'],
            ['nama_bidang' => 'Politik'],
            ['nama_bidang' => 'Agama'],
            // Bidang tambahan yang relevan dengan LSP Indonesia
            ['nama_bidang' => 'Teknologi Informasi dan Komunikasi'],
            ['nama_bidang' => 'Pariwisata dan Hospitality'],
            ['nama_bidang' => 'Manufaktur'],
            ['nama_bidang' => 'Konstruksi'],
            ['nama_bidang' => 'Keuangan dan Perbankan'],
            ['nama_bidang' => 'Administrasi Perkantoran'],
            ['nama_bidang' => 'Pertanian dan Perkebunan'],
            ['nama_bidang' => 'Logistik dan Supply Chain'],
            ['nama_bidang' => 'Pendidikan dan Pelatihan'],
            ['nama_bidang' => 'Kesehatan'],
            ['nama_bidang' => 'Kelistrikan dan Elektronika'],
            ['nama_bidang' => 'Media dan Komunikasi'],
            ['nama_bidang' => 'Kuliner dan Tata Boga'],
            ['nama_bidang' => 'Otomotif'],
            ['nama_bidang' => 'Maritim dan Perikanan'],
            ['nama_bidang' => 'Lingkungan dan Kehutanan'],
            ['nama_bidang' => 'Pertambangan dan Energi'],
            ['nama_bidang' => 'Tekstil dan Garmen'],
            ['nama_bidang' => 'Keamanan dan Keselamatan Kerja (K3)'],
            ['nama_bidang' => 'Manajemen Proyek'],
            ['nama_bidang' => 'Bisnis dan Perdagangan'],
            ['nama_bidang' => 'Seni dan Industri Kreatif'],
            ['nama_bidang' => 'Bahasa dan Komunikasi'],
            ['nama_bidang' => 'Riset dan Pengembangan']
        ];

        foreach ($data as $item) {
            UKBidang::create($item);
        }
    }
}