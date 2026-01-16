<?php

namespace App\Services;

use App\Models\Asesi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AcceptanceLetterService
{
    /**
     * Check if asesi is eligible for acceptance letter (hasil asesmen = kompeten)
     */
    public function isEligibleForAcceptanceLetter(Asesi $asesi): bool
    {
        if (!$asesi->relationLoaded('rincianAsesmen')) {
            $asesi->load('rincianAsesmen.hasilAsesmen');
        }
        
        \Log::info('Checking eligibility for acceptance letter', [
            'id_asesi' => $asesi->id_asesi,
            'has_rincian' => $asesi->rincianAsesmen ? 'yes' : 'no',
            'rincian_id' => $asesi->rincianAsesmen?->id_rincian_asesmen,
        ]);
        
        if ($asesi->rincianAsesmen && $asesi->rincianAsesmen->hasilAsesmen->isNotEmpty()) {
            $hasilAsesmen = $asesi->rincianAsesmen->hasilAsesmen->first();
            
            \Log::info('Hasil asesmen found', [
                'id_asesi' => $asesi->id_asesi,
                'hasil_id' => $hasilAsesmen->id,
                'status' => $hasilAsesmen->status,
            ]);
            
            return $hasilAsesmen->status === 'kompeten';
        }
        
        \Log::warning('No hasil asesmen found', [
            'id_asesi' => $asesi->id_asesi,
        ]);
        
        return false;
    }

    /**
     * Prepare acceptance letter data for template
     */
    public function getAcceptanceLetterData(Asesi $asesi): array
    {
        Carbon::setLocale('id');
        
        $skema = $asesi->skema;
        $hasilAsesmen = $asesi->rincianAsesmen?->hasilAsesmen?->first();
        $tanggalSelesai = $hasilAsesmen?->tanggal_selesai 
            ? Carbon::parse($hasilAsesmen->tanggal_selesai) 
            : Carbon::now();
        
        return [
            'nomor_surat' => $this->generateLetterNumber($asesi),
            'nama_asesi' => $asesi->nama_asesi,
            'nim' => $asesi->nim ?? '-',
            'tempat_tanggal_lahir' => $asesi->tempat_tanggal_lahir ?? '-',
            'nama_skema' => $skema?->nama_skema ?? 'Tidak Diketahui',
            'nomor_skema' => $skema?->nomor_skema ?? '-',
            'tanggal_asesmen' => $tanggalSelesai->translatedFormat('d F Y'),
            'tanggal_surat' => Carbon::now()->translatedFormat('d F Y'),
            'tahun' => Carbon::now()->year,
        ];
    }

    /**
     * Generate unique letter number
     */
    private function generateLetterNumber(Asesi $asesi): string
    {
        $year = date('Y');
        $month = date('m');
        
        // Format: AL/LSP-UGM/YYYY/MM/ASESI_ID
        return "AL/LSP-UGM/{$year}/{$month}/{$asesi->id_asesi}";
    }

    /**
     * Generate acceptance letter PDF
     */
    public function generateAcceptanceLetter(Asesi $asesi): string
    {
        if (!$this->isEligibleForAcceptanceLetter($asesi)) {
            throw new \Exception('Asesi belum memenuhi syarat untuk mendapatkan acceptance letter');
        }

        $data = $this->getAcceptanceLetterData($asesi);

        try {
            $pdf = Pdf::loadView('documents.acceptance-letter-template', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                ]);

            return $pdf->output();
        } catch (\Exception $e) {
            Log::error('Acceptance letter generation failed', [
                'asesi_id' => $asesi->id_asesi,
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Gagal membuat acceptance letter: ' . $e->getMessage());
        }
    }

    /**
     * Get PDF instance for streaming/download
     */
    public function getPdfInstance(Asesi $asesi): \Barryvdh\DomPDF\PDF
    {
        if (!$this->isEligibleForAcceptanceLetter($asesi)) {
            throw new \Exception('Asesi belum memenuhi syarat untuk mendapatkan acceptance letter');
        }

        $data = $this->getAcceptanceLetterData($asesi);

        return Pdf::loadView('documents.acceptance-letter-template', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);
    }
}
