<?php

namespace App\Services;

use App\Models\Asesi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CertificateService
{
    private ProgressTrackingService $progressTrackingService;

    public function __construct(ProgressTrackingService $progressTrackingService)
    {
        $this->progressTrackingService = $progressTrackingService;
    }

    /**
     * Check if asesi is eligible for certificate (hasil asesmen = kompeten)
     *
     * @param Asesi $asesi
     * @return bool
     */
    public function isEligibleForCertificate(Asesi $asesi): bool
    {
        // Load rincianAsesmen with hasilAsesmen if not already loaded
        if (!$asesi->relationLoaded('rincianAsesmen')) {
            $asesi->load('rincianAsesmen.hasilAsesmen');
        }
        
        // Check if asesi has hasil asesmen with status 'kompeten'
        if ($asesi->rincianAsesmen && $asesi->rincianAsesmen->hasilAsesmen->isNotEmpty()) {
            $hasilAsesmen = $asesi->rincianAsesmen->hasilAsesmen->first();
            return $hasilAsesmen->status === 'kompeten';
        }
        
        return false;
    }

    /**
     * Get progress percentage for asesi
     *
     * @param Asesi $asesi
     * @return int
     */
    public function getProgressPercentage(Asesi $asesi): int
    {
        $progressData = $this->progressTrackingService->calculateSchemeBasedProgress($asesi->id_asesi);
        
        return (int) $progressData['progress_percentage'];
    }

    /**
     * Prepare certificate data for template
     *
     * @param Asesi $asesi
     * @return array
     */
    public function getCertificateData(Asesi $asesi): array
    {
        Carbon::setLocale('id');
        
        $skema = $asesi->skema;
        $tanggal = Carbon::now()->setTimezone('Asia/Jakarta');
        
        return [
            'nama_asesi' => $asesi->nama_asesi,
            'tanggal' => $tanggal->translatedFormat('d F Y'),
            'tanggal_raw' => $tanggal,
            'nama_skema' => $skema?->nama_skema ?? 'Tidak Diketahui',
            'nomor_skema' => $skema?->nomor_skema ?? '-',
            'nomor_sertifikat' => $this->generateCertificateNumber($asesi),
            'status' => 'KOMPETEN',
            'id_asesi' => $asesi->id_asesi,
        ];
    }

    /**
     * Generate unique certificate number
     *
     * @param Asesi $asesi
     * @return string
     */
    private function generateCertificateNumber(Asesi $asesi): string
    {
        $year = date('Y');
        $month = date('m');
        
        // Format: CERT/LSP-UGM/YYYY/MM/ASESI_ID
        return "CERT/LSP-UGM/{$year}/{$month}/{$asesi->id_asesi}";
    }

    /**
     * Generate certificate PDF
     *
     * @param Asesi $asesi
     * @return string PDF content
     * @throws \Exception
     */
    public function generateCertificate(Asesi $asesi): string
    {
        if (!$this->isEligibleForCertificate($asesi)) {
            throw new \Exception('Asesi belum memenuhi syarat untuk mendapatkan sertifikat');
        }

        $data = $this->getCertificateData($asesi);

        try {
            $pdf = Pdf::loadView('certificates.certificate-template', $data)
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                ]);

            return $pdf->output();
        } catch (\Exception $e) {
            Log::error('Certificate generation failed', [
                'asesi_id' => $asesi->id_asesi,
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Gagal membuat sertifikat: ' . $e->getMessage());
        }
    }

    /**
     * Get PDF instance for streaming/download
     *
     * @param Asesi $asesi
     * @return \Barryvdh\DomPDF\PDF
     * @throws \Exception
     */
    public function getPdfInstance(Asesi $asesi): \Barryvdh\DomPDF\PDF
    {
        if (!$this->isEligibleForCertificate($asesi)) {
            throw new \Exception('Asesi belum memenuhi syarat untuk mendapatkan sertifikat');
        }

        $data = $this->getCertificateData($asesi);

        return Pdf::loadView('certificates.certificate-template', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);
    }
}
