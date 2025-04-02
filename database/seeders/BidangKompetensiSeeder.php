<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BidangKompetensi;

class BidangKompetensiSeeder extends Seeder
{
    public function run(): void
    {
        $bidang_kompetensi = [
            ['nama_bidang' => 'Teknologi Informasi'],
            ['nama_bidang' => 'Manajemen Proyek'],
            ['nama_bidang' => 'Akuntansi dan Keuangan'],
            ['nama_bidang' => 'Kesehatan dan Keselamatan Kerja'],
            ['nama_bidang' => 'Pemasaran dan Penjualan'],
            ['nama_bidang' => 'Desain Grafis dan Multimedia'],
            ['nama_bidang' => 'Pariwisata dan Perhotelan'],
            ['nama_bidang' => 'Konstruksi dan Teknik Sipil'],
            ['nama_bidang' => 'Otomotif'],
            ['nama_bidang' => 'Pendidikan dan Pelatihan']
        ];

        foreach ($bidang_kompetensi as $bidang) {
            BidangKompetensi::create($bidang);
        }
    }
}

