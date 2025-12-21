<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * SchemeContentController
 * 
 * Controller for managing scheme-specific assessment content dashboard.
 * Provides unified interface for all IA content types per scheme.
 * 
 * Requirements: 7.1
 */
class SchemeContentController extends Controller
{
    protected SchemeContentService $contentService;

    public function __construct(SchemeContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Display the scheme content dashboard with tabs for each content type.
     * GET /admin/skema/{id}/content
     * 
     * Requirements: 7.1
     */
    public function index(string $id): View
    {
        $skema = Skema::findOrFail($id);
        $summary = $this->contentService->getContentSummary($id);
        $unitKompetensi = $skema->getUnitKompetensi();

        return view('home.home-admin.scheme-content-dashboard', [
            'skema' => $skema,
            'summary' => $summary,
            'unitKompetensi' => $unitKompetensi,
        ]);
    }

    /**
     * Get content summary for a scheme as JSON.
     * GET /admin/skema/{id}/content/summary
     * 
     * Requirements: 7.1
     */
    public function summary(string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);
        $summary = $this->contentService->getContentSummary($id);

        return response()->json([
            'success' => true,
            'data' => [
                'skema' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                    'nomor_skema' => $skema->nomor_skema,
                ],
                'summary' => $summary,
                'has_content' => $this->contentService->hasContent($id),
            ],
        ]);
    }
}
