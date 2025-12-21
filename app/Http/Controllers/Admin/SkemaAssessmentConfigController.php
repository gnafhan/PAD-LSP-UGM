<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AssessmentType;
use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\AccessControlService;
use App\Services\SkemaConfigService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * SkemaAssessmentConfigController
 * 
 * Controller for managing assessment configuration per certification scheme.
 * Handles viewing and updating which assessment tools are enabled for each scheme.
 * 
 * Requirements: 1.1, 1.2, 1.3, 1.4, 2.1, 2.2
 */
class SkemaAssessmentConfigController extends Controller
{
    /**
     * @var SkemaConfigService
     */
    protected SkemaConfigService $skemaConfigService;

    /**
     * @var AccessControlService
     */
    protected AccessControlService $accessControlService;

    /**
     * Create a new controller instance.
     *
     * @param SkemaConfigService $skemaConfigService
     * @param AccessControlService $accessControlService
     */
    public function __construct(
        SkemaConfigService $skemaConfigService,
        AccessControlService $accessControlService
    ) {
        $this->skemaConfigService = $skemaConfigService;
        $this->accessControlService = $accessControlService;
    }

    /**
     * Display the assessment configuration page for a scheme.
     * 
     * GET /admin/skema/{id}/assessment-config/view
     * 
     * Renders the admin page with toggle switches for each assessment type.
     * APL toggles are disabled (always on).
     * 
     * Requirements: 1.1
     *
     * @param string $id The scheme ID
     * @return View|\Illuminate\Http\RedirectResponse
     */
    public function show(string $id): View|\Illuminate\Http\RedirectResponse
    {
        try {
            // Find the scheme
            $skema = Skema::find($id);
            
            if (!$skema) {
                return redirect()->route('admin.skema.index')
                    ->with('error', 'Skema tidak ditemukan.');
            }

            // Check authorization
            $user = Auth::user();
            if (!$this->accessControlService->canManageSkema($user, $id)) {
                return redirect()->route('admin.skema.index')
                    ->with('error', 'Anda tidak memiliki akses ke skema ini.');
            }

            // Get enabled assessments
            $enabledAssessments = $this->skemaConfigService->getEnabledAssessments($id);
            
            // Build assessment config array for the view
            $assessmentConfig = [];
            $allTypes = AssessmentType::getAllTypes();
            
            foreach ($allTypes as $type) {
                $assessmentConfig[] = [
                    'assessment_type' => $type,
                    'is_enabled' => $enabledAssessments->contains($type),
                    'is_mandatory' => AssessmentType::isMandatory($type),
                ];
            }

            // Assessment labels for display
            $assessmentLabels = [
                'APL01' => 'Formulir Permohonan Sertifikasi Kompetensi',
                'APL02' => 'Asesmen Mandiri',
                'AK01' => 'Persetujuan Asesmen dan Kerahasiaan',
                'AK02' => 'Checklist Verifikasi Portofolio',
                'AK04' => 'Banding Asesmen',
                'AK07' => 'Feedback dan Catatan Asesmen',
                'IA01' => 'Ceklis Observasi Aktivitas di Tempat Kerja',
                'IA02' => 'Tugas Praktik Demonstrasi',
                'IA05' => 'Pertanyaan Tertulis Pilihan Ganda',
                'IA07' => 'Pertanyaan Lisan',
                'IA11' => 'Ceklis Verifikasi Portofolio',
                'MAPA01' => 'Merencanakan Aktivitas dan Proses Asesmen',
                'MAPA02' => 'Peta Instrumen Asesmen',
                'KONSUL_PRA_UJI' => 'Konsultasi Pra Uji Kompetensi',
                'KETIDAKBERPIHAKAN' => 'Pernyataan Ketidakberpihakan',
                'TUGAS_PESERTA' => 'Tugas Praktik Peserta',
            ];

            return view('home.home-admin.skema-assessment-config', [
                'skema' => $skema,
                'assessmentConfig' => $assessmentConfig,
                'assessmentLabels' => $assessmentLabels,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load assessment configuration page', [
                'id_skema' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('admin.skema.index')
                ->with('error', 'Gagal memuat halaman konfigurasi asesmen.');
        }
    }

    /**
     * Get current assessment configuration for a scheme.
     * 
     * GET /admin/skema/{id}/assessment-config
     * 
     * Returns the list of all available assessment tools with their enabled status
     * for the specified scheme. APL tools are always marked as mandatory.
     * 
     * Requirements: 1.1
     *
     * @param string $id The scheme ID
     * @return JsonResponse
     */
    public function index(string $id): JsonResponse
    {
        try {
            // Find the scheme
            $skema = Skema::find($id);
            
            if (!$skema) {
                return response()->json([
                    'success' => false,
                    'message' => 'Scheme not found',
                ], 404);
            }

            // Check authorization
            $user = Auth::user();
            if (!$this->accessControlService->canManageSkema($user, $id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this scheme',
                ], 403);
            }

            // Get enabled assessments
            $enabledAssessments = $this->skemaConfigService->getEnabledAssessments($id);
            
            // Get full configuration with all assessment types
            $fullConfig = $this->skemaConfigService->getFullConfig($id);
            
            // Build response with all assessment types and their status
            $assessmentConfig = [];
            $allTypes = AssessmentType::getAllTypes();
            
            foreach ($allTypes as $type) {
                $configRecord = $fullConfig->firstWhere('assessment_type', $type);
                $assessmentConfig[] = [
                    'assessment_type' => $type,
                    'is_enabled' => $enabledAssessments->contains($type),
                    'is_mandatory' => AssessmentType::isMandatory($type),
                    'display_order' => $configRecord ? $configRecord->display_order : null,
                    'config_data' => $configRecord ? $configRecord->config_data : null,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                    'assessment_config' => $assessmentConfig,
                    'mandatory_types' => AssessmentType::getMandatoryTypes(),
                    'configurable_types' => AssessmentType::getConfigurableTypes(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get assessment configuration', [
                'id_skema' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve assessment configuration',
            ], 500);
        }
    }


    /**
     * Update assessment configuration for a scheme.
     * 
     * PUT /admin/skema/{id}/assessment-config
     * 
     * Updates which assessment tools are enabled for the specified scheme.
     * APL tools cannot be disabled - they are mandatory for all schemes.
     * 
     * Requirements: 1.2, 1.3, 1.4
     *
     * @param Request $request
     * @param string $id The scheme ID
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            // Find the scheme
            $skema = Skema::find($id);
            
            if (!$skema) {
                return response()->json([
                    'success' => false,
                    'message' => 'Scheme not found',
                ], 404);
            }

            // Check authorization
            $user = Auth::user();
            if (!$this->accessControlService->canManageSkema($user, $id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this scheme',
                ], 403);
            }

            // Validate request
            $validated = $request->validate([
                'config' => 'required|array',
                'config.*' => 'boolean',
            ]);

            $config = $validated['config'];

            // Validate that APL types are not being disabled
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                if (isset($config[$mandatoryType]) && $config[$mandatoryType] === false) {
                    return response()->json([
                        'success' => false,
                        'message' => "APL tools ({$mandatoryType}) cannot be disabled. They are mandatory for all schemes.",
                        'error_code' => 'APL_DISABLE_ATTEMPT',
                    ], 422);
                }
            }

            // Validate that at least APL tools are enabled
            $hasAplEnabled = false;
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                if (!isset($config[$mandatoryType]) || $config[$mandatoryType] === true) {
                    $hasAplEnabled = true;
                    break;
                }
            }

            if (!$hasAplEnabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'At least APL tools must be enabled for the scheme.',
                    'error_code' => 'MINIMUM_APL_REQUIRED',
                ], 422);
            }

            // Update the configuration
            $this->skemaConfigService->updateAssessmentConfig($id, $config);

            // Get updated configuration
            $enabledAssessments = $this->skemaConfigService->getEnabledAssessments($id);

            Log::info('Assessment configuration updated', [
                'id_skema' => $id,
                'updated_by' => $user->id_user,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Assessment configuration updated successfully',
                'data' => [
                    'id_skema' => $skema->id_skema,
                    'enabled_assessments' => $enabledAssessments->toArray(),
                ],
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to update assessment configuration', [
                'id_skema' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update assessment configuration',
            ], 500);
        }
    }
}
