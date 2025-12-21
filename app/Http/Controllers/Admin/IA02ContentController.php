<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * IA02ContentController
 * 
 * Controller for managing IA02 work instruction templates per scheme.
 * 
 * Requirements: 2.1, 2.2, 2.4
 */
class IA02ContentController extends Controller
{
    protected SchemeContentService $contentService;

    public function __construct(SchemeContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Get IA02 template for a scheme.
     * GET /admin/skema/{id}/content/ia02
     * 
     * Requirements: 2.1
     */
    public function show(string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);
        $template = $this->contentService->getIA02Template($id);

        return response()->json([
            'success' => true,
            'data' => [
                'skema' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                ],
                'template' => $template,
                'has_template' => $template !== null,
            ],
        ]);
    }

    /**
     * Save IA02 template for a scheme.
     * POST /admin/skema/{id}/content/ia02
     * 
     * Requirements: 2.2, 2.4
     */
    public function store(Request $request, string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'instruksi_kerja' => 'required|string',
        ]);

        $template = $this->contentService->saveIA02Template($id, $validated['instruksi_kerja']);

        return response()->json([
            'success' => true,
            'message' => 'Template instruksi kerja berhasil disimpan',
            'data' => $template,
        ]);
    }
}
