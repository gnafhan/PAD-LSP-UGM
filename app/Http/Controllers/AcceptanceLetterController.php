<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Services\AcceptanceLetterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AcceptanceLetterController extends Controller
{
    private AcceptanceLetterService $acceptanceLetterService;

    public function __construct(AcceptanceLetterService $acceptanceLetterService)
    {
        $this->acceptanceLetterService = $acceptanceLetterService;
    }

    /**
     * Generate and download acceptance letter for asesi
     */
    public function download(string $id_asesi)
    {
        $asesi = Asesi::with(['skema', 'rincianAsesmen.hasilAsesmen'])->find($id_asesi);

        if (!$asesi) {
            abort(404, 'Asesi tidak ditemukan');
        }

        // Authorization check
        $user = Auth::user();
        
        \Log::info('Acceptance Letter Download Attempt', [
            'id_asesi' => $id_asesi,
            'user_id' => $user->id_user,
            'user_role' => $user->role,
            'asesi_id_user' => $asesi->id_user ?? 'null',
        ]);
        
        // Check if user is admin OR the asesi owner (by id_user)
        $isAdmin = $user->role === 'admin';
        $isOwner = $asesi->id_user === $user->id_user;
        
        if (!$isAdmin && !$isOwner) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh acceptance letter ini');
        }

        // Check eligibility
        if (!$this->acceptanceLetterService->isEligibleForAcceptanceLetter($asesi)) {
            \Log::warning('Asesi not eligible for acceptance letter', [
                'id_asesi' => $id_asesi,
                'has_rincian' => $asesi->rincianAsesmen ? 'yes' : 'no',
                'has_hasil' => $asesi->rincianAsesmen?->hasilAsesmen?->isNotEmpty() ? 'yes' : 'no',
                'hasil_status' => $asesi->rincianAsesmen?->hasilAsesmen?->first()?->status ?? 'null',
            ]);
            abort(403, 'Asesi belum memenuhi syarat untuk mendapatkan acceptance letter (status belum kompeten)');
        }

        try {
            $pdf = $this->acceptanceLetterService->getPdfInstance($asesi);
            $filename = 'Acceptance_Letter_' . str_replace(' ', '_', $asesi->nama_asesi) . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('Failed to generate acceptance letter', [
                'id_asesi' => $id_asesi,
                'error' => $e->getMessage(),
            ]);
            abort(500, 'Gagal membuat acceptance letter: ' . $e->getMessage());
        }
    }

    /**
     * Preview acceptance letter in browser
     */
    public function preview(string $id_asesi)
    {
        $asesi = Asesi::with(['skema', 'rincianAsesmen.hasilAsesmen'])->find($id_asesi);

        if (!$asesi) {
            abort(404, 'Asesi tidak ditemukan');
        }

        // Authorization check
        $user = Auth::user();
        
        // Check if user is admin OR the asesi owner (by id_user)
        $isAdmin = $user->role === 'admin';
        $isOwner = $asesi->id_user === $user->id_user;
        
        if (!$isAdmin && !$isOwner) {
            abort(403, 'Anda tidak memiliki akses untuk melihat acceptance letter ini');
        }

        // Check eligibility
        if (!$this->acceptanceLetterService->isEligibleForAcceptanceLetter($asesi)) {
            abort(403, 'Asesi belum memenuhi syarat untuk mendapatkan acceptance letter');
        }

        try {
            $pdf = $this->acceptanceLetterService->getPdfInstance($asesi);
            
            return $pdf->stream('Acceptance_Letter_' . str_replace(' ', '_', $asesi->nama_asesi) . '.pdf');
        } catch (\Exception $e) {
            abort(500, 'Gagal membuat acceptance letter: ' . $e->getMessage());
        }
    }
}
