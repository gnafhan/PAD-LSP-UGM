<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IA02ProsesAssessment;
use App\Models\IA02InstruksiKerja;

class IA02DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Default process assessment templates
        $defaultProcesses = [
            [
                'nomor_proses' => 1,
                'judul_proses' => 'Mengimplementasikan Dasar-dasar Kepemanduan Museum',
                'deskripsi_proses' => 'Proses implementasi dasar-dasar kepemanduan museum untuk asesi',
                'instruksi_kerjas' => [
                    ['nomor_urut' => 1, 'instruksi_kerja' => 'Meneraptkan Prinsip "Edutainment"', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 2, 'instruksi_kerja' => 'Meneraptkan Pengetahuan tentang Museum', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 3, 'instruksi_kerja' => 'Mengembangkan Pengetahuan', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                ]
            ],
            [
                'nomor_proses' => 2,
                'judul_proses' => 'Mengimplementasikan Dasar-dasar Kepemanduan Museum',
                'deskripsi_proses' => 'Proses implementasi lanjutan dasar-dasar kepemanduan museum',
                'instruksi_kerjas' => [
                    ['nomor_urut' => 1, 'instruksi_kerja' => 'Meneraptkan Prinsip "Edutainment"', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 2, 'instruksi_kerja' => 'Meneraptkan Pengetahuan tentang Museum', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 3, 'instruksi_kerja' => 'Mengembangkan Pengetahuan', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                ]
            ],
            [
                'nomor_proses' => 3,
                'judul_proses' => 'Mengimplementasikan Dasar-dasar Kepemanduan Museum',
                'deskripsi_proses' => 'Proses implementasi tingkat menengah kepemanduan museum',
                'instruksi_kerjas' => [
                    ['nomor_urut' => 1, 'instruksi_kerja' => 'Meneraptkan Prinsip "Edutainment"', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 2, 'instruksi_kerja' => 'Meneraptkan Pengetahuan tentang Museum', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 3, 'instruksi_kerja' => 'Mengembangkan Pengetahuan', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                ]
            ],
            [
                'nomor_proses' => 4,
                'judul_proses' => 'Mengimplementasikan Dasar-dasar Kepemanduan Museum',
                'deskripsi_proses' => 'Proses implementasi tingkat lanjut kepemanduan museum',
                'instruksi_kerjas' => [
                    ['nomor_urut' => 1, 'instruksi_kerja' => 'Meneraptkan Prinsip "Edutainment"', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 2, 'instruksi_kerja' => 'Meneraptkan Pengetahuan tentang Museum', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 3, 'instruksi_kerja' => 'Mengembangkan Pengetahuan', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                ]
            ],
            [
                'nomor_proses' => 5,
                'judul_proses' => 'Mengimplementasikan Dasar-dasar Kepemanduan Museum',
                'deskripsi_proses' => 'Proses implementasi tingkat ahli kepemanduan museum',
                'instruksi_kerjas' => [
                    ['nomor_urut' => 1, 'instruksi_kerja' => 'Meneraptkan Prinsip "Edutainment"', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 2, 'instruksi_kerja' => 'Meneraptkan Pengetahuan tentang Museum', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 3, 'instruksi_kerja' => 'Mengembangkan Pengetahuan', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                ]
            ],
            [
                'nomor_proses' => 6,
                'judul_proses' => 'Mengimplementasikan Dasar-dasar Kepemanduan Museum',
                'deskripsi_proses' => 'Proses evaluasi dan validasi kepemanduan museum',
                'instruksi_kerjas' => [
                    ['nomor_urut' => 1, 'instruksi_kerja' => 'Meneraptkan Prinsip "Edutainment"', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 2, 'instruksi_kerja' => 'Meneraptkan Pengetahuan tentang Museum', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                    ['nomor_urut' => 3, 'instruksi_kerja' => 'Mengembangkan Pengetahuan', 'standar_alat_media' => '-', 'output_yang_diharapkan' => '-'],
                ]
            ],
        ];

        // Note: Since these are templates, we'll create them without ia02_id
        // They will be used as templates when creating actual IA02 records
        foreach ($defaultProcesses as $processData) {
            // This seeder creates template data that can be used when creating IA02 records
            $this->command->info("Template data for Process {$processData['nomor_proses']}: {$processData['judul_proses']}");
            
            // You can uncomment below if you want to create actual template records in database
            /*
            $process = IA02ProsesAssessment::create([
                'ia02_id' => null, // Template record
                'nomor_proses' => $processData['nomor_proses'],
                'judul_proses' => $processData['judul_proses'],
                'deskripsi_proses' => $processData['deskripsi_proses'],
                'urutan' => $processData['nomor_proses']
            ]);

            foreach ($processData['instruksi_kerjas'] as $instruksiData) {
                IA02InstruksiKerja::create([
                    'proses_assessment_id' => $process->id,
                    'nomor_urut' => $instruksiData['nomor_urut'],
                    'instruksi_kerja' => $instruksiData['instruksi_kerja'],
                    'standar_alat_media' => $instruksiData['standar_alat_media'],
                    'output_yang_diharapkan' => $instruksiData['output_yang_diharapkan']
                ]);
            }
            */
        }

        $this->command->info('IA02 default data seeder completed. Template data structure is ready for use.');
    }
}
