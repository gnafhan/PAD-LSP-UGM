<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    private CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Download certificate PDF for authenticated asesi
     *
     * @return Response|StreamedResponse
     */
    public function download()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(401, 'Anda harus login untuk mengakses sertifikat');
        }

        // Get asesi for current user
        $asesi = Asesi::with('skema')->where('id_user', $user->id_user)->first();

        if (!$asesi) {
            abort(404, 'Data asesi tidak ditemukan');
        }

        // Check if asesi has skema
        if (!$asesi->skema) {
            abort(500, 'Data skema tidak lengkap');
        }

        // Check eligibility
        if (!$this->certificateService->isEligibleForCertificate($asesi)) {
            abort(403, 'Anda belum menyelesaikan seluruh proses asesmen');
        }

        try {
            $pdf = $this->certificateService->getPdfInstance($asesi);
            $filename = 'Sertifikat_' . str_replace(' ', '_', $asesi->nama_asesi) . '_' . date('Ymd') . '.pdf';
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            abort(500, 'Gagal membuat sertifikat, silakan coba lagi');
        }
    }

    /**
     * Preview certificate in browser
     *
     * @return Response|StreamedResponse
     */
    public function preview()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(401, 'Anda harus login untuk mengakses sertifikat');
        }

        // Get asesi for current user
        $asesi = Asesi::with('skema')->where('id_user', $user->id_user)->first();

        if (!$asesi) {
            abort(404, 'Data asesi tidak ditemukan');
        }

        // Check if asesi has skema
        if (!$asesi->skema) {
            abort(500, 'Data skema tidak lengkap');
        }

        // Check eligibility
        if (!$this->certificateService->isEligibleForCertificate($asesi)) {
            abort(403, 'Anda belum menyelesaikan seluruh proses asesmen');
        }

        try {
            $pdf = $this->certificateService->getPdfInstance($asesi);
            
            return $pdf->stream('Sertifikat_Preview.pdf');
        } catch (\Exception $e) {
            abort(500, 'Gagal membuat sertifikat, silakan coba lagi');
        }
    }

    /**
     * Download certificate for specific asesi (admin only)
     *
     * @param string $idAsesi
     * @return Response|StreamedResponse
     */
    public function downloadForAsesi(string $idAsesi)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(401, 'Anda harus login untuk mengakses sertifikat');
        }

        // Get asesi
        $asesi = Asesi::with('skema')->where('id_asesi', $idAsesi)->first();

        if (!$asesi) {
            abort(404, 'Data asesi tidak ditemukan');
        }

        // Check authorization - only the asesi owner or admin can download
        if ($asesi->id_user !== $user->id_user && $user->level !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk sertifikat ini');
        }

        // Check if asesi has skema
        if (!$asesi->skema) {
            abort(500, 'Data skema tidak lengkap');
        }

        // Check eligibility
        if (!$this->certificateService->isEligibleForCertificate($asesi)) {
            abort(403, 'Asesi belum menyelesaikan seluruh proses asesmen');
        }

        try {
            $pdf = $this->certificateService->getPdfInstance($asesi);
            $filename = 'Sertifikat_' . str_replace(' ', '_', $asesi->nama_asesi) . '_' . date('Ymd') . '.pdf';
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            abort(500, 'Gagal membuat sertifikat, silakan coba lagi');
        }
    }
}
