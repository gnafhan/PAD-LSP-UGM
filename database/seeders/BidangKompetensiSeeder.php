<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BidangKompetensi;

class BidangKompetensiSeeder extends Seeder
{
    public function run(): void
    {
        $bidang_kompetensi = [
            // Bidang yang sudah ada
            ['nama_bidang' => 'Teknologi Informasi'],
            ['nama_bidang' => 'Manajemen Proyek'],
            ['nama_bidang' => 'Akuntansi dan Keuangan'],
            ['nama_bidang' => 'Kesehatan dan Keselamatan Kerja'],
            ['nama_bidang' => 'Pemasaran dan Penjualan'],
            ['nama_bidang' => 'Desain Grafis dan Multimedia'],
            ['nama_bidang' => 'Pariwisata dan Perhotelan'],
            ['nama_bidang' => 'Konstruksi dan Teknik Sipil'],
            ['nama_bidang' => 'Otomotif'],
            ['nama_bidang' => 'Pendidikan dan Pelatihan'],
            
            // Bidang tambahan sesuai dengan BNSP dan LSP Indonesia
            ['nama_bidang' => 'Pemrograman Komputer'],
            ['nama_bidang' => 'Jaringan Komputer dan Telekomunikasi'],
            ['nama_bidang' => 'Keamanan Siber (Cyber Security)'],
            ['nama_bidang' => 'Analisis dan Ilmu Data'],
            ['nama_bidang' => 'Administrasi Sistem dan Database'],
            ['nama_bidang' => 'Pengembangan Web dan Aplikasi Mobile'],
            ['nama_bidang' => 'Sistem Informasi Manajemen'],
            ['nama_bidang' => 'Kecerdasan Buatan dan Machine Learning'],
            ['nama_bidang' => 'Tata Kelola TI'],
            ['nama_bidang' => 'Cloud Computing'],
            
            ['nama_bidang' => 'Manajemen Keuangan dan Investasi'],
            ['nama_bidang' => 'Perpajakan'],
            ['nama_bidang' => 'Perbankan dan Jasa Keuangan'],
            ['nama_bidang' => 'Audit dan Assurance'],
            ['nama_bidang' => 'Manajemen Risiko Keuangan'],
            
            ['nama_bidang' => 'Perhotelan dan Manajemen Penginapan'],
            ['nama_bidang' => 'MICE (Meeting, Incentive, Convention, Exhibition)'],
            ['nama_bidang' => 'Tour Guide dan Manajemen Wisata'],
            ['nama_bidang' => 'Kuliner dan Katering'],
            ['nama_bidang' => 'Manajemen Destinasi Pariwisata'],
            
            ['nama_bidang' => 'Arsitek dan Perancangan Bangunan'],
            ['nama_bidang' => 'Teknik Properti dan Real Estate'],
            ['nama_bidang' => 'Pengawasan Konstruksi'],
            ['nama_bidang' => 'Quantity Surveyor'],
            ['nama_bidang' => 'Interior Design'],
            
            ['nama_bidang' => 'Mekanik Kendaraan Ringan'],
            ['nama_bidang' => 'Mekanik Kendaraan Berat'],
            ['nama_bidang' => 'Teknologi Alat Berat'],
            ['nama_bidang' => 'Kelistrikan Otomotif'],
            ['nama_bidang' => 'Body Repair dan Pengecatan'],
            
            ['nama_bidang' => 'Teknik Elektro dan Instrumentasi'],
            ['nama_bidang' => 'Teknik Mesin dan Manufaktur'],
            ['nama_bidang' => 'Teknik Kimia dan Proses'],
            ['nama_bidang' => 'Teknik Lingkungan'],
            ['nama_bidang' => 'Teknik Industri'],
            
            ['nama_bidang' => 'Sumber Daya Manusia'],
            ['nama_bidang' => 'Manajemen Bisnis'],
            ['nama_bidang' => 'Digital Marketing'],
            ['nama_bidang' => 'Customer Service dan Relasi Publik'],
            ['nama_bidang' => 'Logistik dan Manajemen Rantai Pasok'],
            ['nama_bidang' => 'UMKM dan Kewirausahaan'],
            
            ['nama_bidang' => 'Bahasa dan Penerjemahan'],
            ['nama_bidang' => 'Fotografi dan Videografi'],
            ['nama_bidang' => 'Animasi dan Desain 3D'],
            ['nama_bidang' => 'Film dan Produksi Media'],
            ['nama_bidang' => 'Musik dan Seni Pertunjukan'],
            
            ['nama_bidang' => 'Keperawatan dan Tenaga Medis'],
            ['nama_bidang' => 'Farmasi dan Kefarmasian'],
            ['nama_bidang' => 'Manajemen Fasilitas Kesehatan'],
            ['nama_bidang' => 'Kesehatan Masyarakat dan Gizi'],
            ['nama_bidang' => 'Laboratorium Medis'],
            
            ['nama_bidang' => 'Pertanian dan Agribisnis'],
            ['nama_bidang' => 'Perikanan dan Marikultur'],
            ['nama_bidang' => 'Kehutanan dan Lingkungan'],
            ['nama_bidang' => 'Peternakan'],
            ['nama_bidang' => 'Teknologi Pangan dan Pengolahan Hasil Pertanian']
        ];

        foreach ($bidang_kompetensi as $bidang) {
            BidangKompetensi::create($bidang);
        }
    }
}