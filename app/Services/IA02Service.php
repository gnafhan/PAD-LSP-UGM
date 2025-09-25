<?php

namespace App\Services;

use App\Models\IA02;
use App\Models\IA02Kompetensi;
use App\Models\IA02ProsesAssessment;
use App\Models\IA02InstruksiKerja;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\Skema;
use App\Models\UK;
use Carbon\Carbon;

class IA02Service
{
    public function createIA02ForAsesi($asesiId, $asesorId, $skemaId = null)
    {
        $asesi = Asesi::with(['skema', 'rincianAsesmen.asesor', 'rincianAsesmen.event.tuk'])->find($asesiId);
        $asesor = Asesor::find($asesorId);
        
        if (!$asesi || !$asesor) {
            throw new \Exception('Asesi atau Asesor tidak ditemukan');
        }

        // Use asesi's skema if skemaId not provided
        $targetSkemaId = $skemaId ?? $asesi->id_skema;
        $skema = Skema::find($targetSkemaId);
        
        if (!$skema) {
            throw new \Exception('Skema tidak ditemukan');
        }

        // Get TUK information from rincian asesmen - same logic as IA11
        $tukName = 'LSP Politeknik Negeri Malang'; // Default
        if ($asesi->rincianAsesmen && $asesi->rincianAsesmen->event && $asesi->rincianAsesmen->event->tuk) {
            $tukName = $asesi->rincianAsesmen->event->tuk->nama_tuk;
        }

        // Check if IA02 already exists
        $existingIA02 = IA02::where('id_asesi', $asesiId)
                           ->where('id_asesor', $asesorId)
                           ->where('id_skema', $targetSkemaId)
                           ->first();

        if ($existingIA02) {
            return $existingIA02;
        }

        // Create new IA02
        $ia02 = IA02::create([
            'id_asesi' => $asesiId,
            'id_asesor' => $asesorId,
            'id_skema' => $targetSkemaId,
            'judul_sertifikasi' => $skema->nama_skema,
            'nama_peserta' => $asesi->nama_asesi,
            'nama_asesor' => $asesor->nama_asesor,
            'instruksi_kerja' => $this->getDefaultInstruksiKerja(),
            'status' => 'draft'
        ]);

        // Create kompetensis based on skema's UK
        $this->createDefaultKompetensis($ia02);

        // Create default process assessments
        $this->createDefaultProsesAssessments($ia02);

        return $ia02;
    }

    private function createDefaultKompetensis($ia02)
    {
        // Get UK related to this skema (you might need to adjust this based on your skema-uk relationship)
        $uks = UK::take(5)->get(); // For now, get first 5 UKs as example
        
        foreach ($uks as $index => $uk) {
            IA02Kompetensi::create([
                'ia02_id' => $ia02->id,
                'id_uk' => $uk->id_uk,
                'kode_uk' => $uk->kode_uk,
                'nama_uk' => $uk->nama_uk,
                'deskripsi_kompetensi' => 'Mengidentifikasi situasi konflik?',
                'urutan' => $index + 1
            ]);
        }
    }

    private function createDefaultProsesAssessments($ia02)
    {
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

        foreach ($defaultProcesses as $processData) {
            $process = IA02ProsesAssessment::create([
                'ia02_id' => $ia02->id,
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
        }
    }

    private function getDefaultInstruksiKerja()
    {
        return '<p><em>Tulis disini:</em></p>
        <p><strong>Skenario</strong></p>
        <p>Narasikan tugas yang harus dikerjakan oleh Asesi.</p>
        <p><strong>A. Studi Kasus</strong></p>
        <p>Anda sebagai seorang Pemandu Museum/Edukator mendapat tugas untuk melakukan pemanduan di museum dengan peserta 10 orang pengunjung, dengan latar belakang yang berbeda. Bagaimana strategi anda sebagai Pemandu Museum dalam mengelola kunjungan, terkait dengan pemanduan museum!</p>
        <p><strong>B. Instruksi Kerja dan demonstrasikan unjuk kerja di bawah ini :</strong></p>
        <ol>
        <li>Informasikan waktu kunjungan di museum dan peraturan selama kunjungan.</li>
        <li>Informasikan kepada pengunjung aksesibilitas dari setiap museum di atas, baik dalam hal sarana prasarananya, etika di museum tersebut. (baik etika secara umum maupun etika secara lokal di museum tersebut).</li>
        </ol>';
    }

    public function updateIA02($ia02Id, $data)
    {
        $ia02 = IA02::findOrFail($ia02Id);
        
        $allowedFields = [
            'instruksi_kerja',
            'catatan',
            'status'
        ];

        $updateData = array_intersect_key($data, array_flip($allowedFields));
        
        return $ia02->update($updateData);
    }

    public function signByAsesor($ia02Id, $signatureData = null)
    {
        $ia02 = IA02::findOrFail($ia02Id);
        
        $ia02->update([
            'waktu_tanda_tangan_asesor' => Carbon::now(),
            'ttd_asesor' => $signatureData,
            'status' => $ia02->isAsesiSigned() ? 'completed' : 'approved'
        ]);

        return $ia02;
    }

    public function signByAsesi($ia02Id, $signatureData = null)
    {
        $ia02 = IA02::findOrFail($ia02Id);
        
        $ia02->update([
            'waktu_tanda_tangan_asesi' => Carbon::now(),
            'ttd_asesi' => $signatureData,
            'status' => $ia02->isAsesorSigned() ? 'completed' : 'submitted'
        ]);

        return $ia02;
    }

    public function getIA02ForAsesi($asesiId, $asesorId = null)
    {
        $query = IA02::with([
            'asesi.rincianAsesmen.event.tuk', 
            'asesor', 
            'skema', 
            'kompetensis.uk', 
            'prosesAssessments.instruksiKerjas'
        ])->where('id_asesi', $asesiId);

        if ($asesorId) {
            $query->where('id_asesor', $asesorId);
        }

        return $query->first();
    }
}
