<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;
use App\Models\ProgramStudi;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fakultas di UGM
        $fakultasList = [
            [
                'id' => 'FAK202600001',
                'nama' => 'Fakultas Teknik',
                'prodi' => [
                    'Teknik Sipil',
                    'Teknik Mesin',
                    'Teknik Elektro',
                    'Teknik Kimia',
                    'Teknik Arsitektur',
                    'Teknik Industri',
                    'Teknik Informatika',
                    'Teknik Geologi',
                    'Teknik Nuklir',
                ]
            ],
            [
                'id' => 'FAK202600002',
                'nama' => 'Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan',
                'prodi' => [
                    'Pendidikan Dokter',
                    'Ilmu Keperawatan',
                    'Gizi Kesehatan',
                    'Kesehatan Masyarakat',
                ]
            ],
            [
                'id' => 'FAK202600003',
                'nama' => 'Fakultas Pertanian',
                'prodi' => [
                    'Agroteknologi',
                    'Agronomi',
                    'Ilmu Tanah',
                    'Proteksi Tanaman',
                    'Mikrobiologi Pertanian',
                    'Sosial Ekonomi Pertanian',
                ]
            ],
            [
                'id' => 'FAK202600004',
                'nama' => 'Fakultas Peternakan',
                'prodi' => [
                    'Ilmu dan Industri Peternakan',
                ]
            ],
            [
                'id' => 'FAK202600005',
                'nama' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam',
                'prodi' => [
                    'Matematika',
                    'Fisika',
                    'Kimia',
                    'Biologi',
                    'Ilmu Komputer',
                    'Statistika',
                    'Geofisika',
                    'Elektronika dan Instrumentasi',
                ]
            ],
            [
                'id' => 'FAK202600006',
                'nama' => 'Fakultas Kehutanan',
                'prodi' => [
                    'Kehutanan',
                ]
            ],
            [
                'id' => 'FAK202600007',
                'nama' => 'Fakultas Geografi',
                'prodi' => [
                    'Geografi dan Ilmu Lingkungan',
                    'Kartografi dan Penginderaan Jauh',
                    'Pembangunan Wilayah',
                ]
            ],
            [
                'id' => 'FAK202600008',
                'nama' => 'Fakultas Biologi',
                'prodi' => [
                    'Biologi',
                ]
            ],
            [
                'id' => 'FAK202600009',
                'nama' => 'Fakultas Farmasi',
                'prodi' => [
                    'Farmasi',
                ]
            ],
            [
                'id' => 'FAK202600010',
                'nama' => 'Fakultas Ekonomika dan Bisnis',
                'prodi' => [
                    'Ilmu Ekonomi',
                    'Manajemen',
                    'Akuntansi',
                ]
            ],
            [
                'id' => 'FAK202600011',
                'nama' => 'Fakultas Ilmu Sosial dan Ilmu Politik',
                'prodi' => [
                    'Ilmu Komunikasi',
                    'Ilmu Hubungan Internasional',
                    'Manajemen dan Kebijakan Publik',
                    'Pembangunan Sosial dan Kesejahteraan',
                    'Politik dan Pemerintahan',
                    'Sosiologi',
                ]
            ],
            [
                'id' => 'FAK202600012',
                'nama' => 'Fakultas Ilmu Budaya',
                'prodi' => [
                    'Sastra Indonesia',
                    'Sastra Inggris',
                    'Sastra Arab',
                    'Sastra Jepang',
                    'Sastra Prancis',
                    'Arkeologi',
                    'Sejarah',
                    'Antropologi Budaya',
                    'Pariwisata',
                ]
            ],
            [
                'id' => 'FAK202600013',
                'nama' => 'Fakultas Filsafat',
                'prodi' => [
                    'Filsafat',
                ]
            ],
            [
                'id' => 'FAK202600014',
                'nama' => 'Fakultas Psikologi',
                'prodi' => [
                    'Psikologi',
                ]
            ],
            [
                'id' => 'FAK202600015',
                'nama' => 'Fakultas Hukum',
                'prodi' => [
                    'Ilmu Hukum',
                ]
            ],
            [
                'id' => 'FAK202600016',
                'nama' => 'Sekolah Vokasi',
                'prodi' => [
                    'Teknologi Rekayasa Perangkat Lunak',
                    'Teknologi Informasi',
                    'Akuntansi Sektor Publik',
                    'Perbankan',
                    'Manajemen Bisnis Pariwisata',
                    'Bahasa Inggris',
                    'Bahasa Korea',
                    'Bahasa Jepang',
                ]
            ],
        ];

        foreach ($fakultasList as $index => $fakultasData) {
            $fakultas = Fakultas::create([
                'id_fakultas' => $fakultasData['id'],
                'nama_fakultas' => $fakultasData['nama'],
            ]);

            foreach ($fakultasData['prodi'] as $prodiIndex => $prodiNama) {
                ProgramStudi::create([
                    'id_program_studi' => 'PRODI' . str_pad(($index * 100 + $prodiIndex + 1), 9, '0', STR_PAD_LEFT),
                    'id_fakultas' => $fakultas->id_fakultas,
                    'nama_program_studi' => $prodiNama,
                ]);
            }
        }
    }
}
