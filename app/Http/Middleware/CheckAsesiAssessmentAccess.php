<?php

namespace App\Http\Middleware;

use App\Enums\AssessmentType;
use App\Models\Asesi;
use App\Services\AsesiDashboardService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckAsesiAssessmentAccess Middleware
 * 
 * Middleware to check if an asesi has access to a specific assessment type.
 * Redirects with an appropriate message if the assessment is disabled for their scheme.
 * APL assessments are always accessible as they are mandatory.
 * 
 * Requirements: 5.3
 */
class CheckAsesiAssessmentAccess
{
    private AsesiDashboardService $asesiDashboardService;

    public function __construct(AsesiDashboardService $asesiDashboardService)
    {
        $this->asesiDashboardService = $asesiDashboardService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $assessmentType The assessment type to check (e.g., 'AK01', 'IA02')
     */
    public function handle(Request $request, Closure $next, string $assessmentType): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get the asesi for the current user
        $asesi = Asesi::where('id_user', $user->id_user)->first();
        
        if (!$asesi) {
            return redirect()->route('asesi.index')->with('error', 'Data Asesi tidak ditemukan.');
        }

        // Check if the assessment type is enabled for the asesi's scheme
        if (!$this->asesiDashboardService->isAssessmentEnabledForAsesi($asesi, $assessmentType)) {
            // Get a user-friendly name for the assessment type
            $assessmentName = $this->getAssessmentDisplayName($assessmentType);
            
            return redirect()
                ->route('asesi.index')
                ->with('warning', "Formulir {$assessmentName} tidak tersedia untuk skema sertifikasi Anda. Silakan hubungi administrator jika Anda memerlukan akses.");
        }

        return $next($request);
    }

    /**
     * Get a user-friendly display name for an assessment type.
     *
     * @param string $assessmentType The assessment type constant
     * @return string The display name
     */
    private function getAssessmentDisplayName(string $assessmentType): string
    {
        $displayNames = [
            AssessmentType::APL01 => 'APL.01',
            AssessmentType::APL02 => 'APL.02',
            AssessmentType::AK01 => 'AK.01',
            AssessmentType::AK02 => 'AK.02',
            AssessmentType::AK04 => 'AK.04',
            AssessmentType::AK07 => 'AK.07',
            AssessmentType::IA01 => 'IA.01',
            AssessmentType::IA02 => 'IA.02',
            AssessmentType::IA05 => 'IA.05',
            AssessmentType::IA07 => 'IA.07',
            AssessmentType::IA11 => 'IA.11',
            AssessmentType::MAPA01 => 'MAPA.01',
            AssessmentType::MAPA02 => 'MAPA.02',
            AssessmentType::KONSUL_PRA_UJI => 'Konsultasi Pra Uji',
            AssessmentType::KETIDAKBERPIHAKAN => 'Pernyataan Ketidakberpihakan',
            AssessmentType::TUGAS_PESERTA => 'Tugas Peserta',
        ];

        return $displayNames[$assessmentType] ?? $assessmentType;
    }
}
