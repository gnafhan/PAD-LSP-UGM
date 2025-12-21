<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * MAPAConfigController
 * 
 * Controller for managing MAPA01 and MAPA02 configurations per scheme.
 * 
 * Requirements: 4.1, 4.2, 5.1, 5.2, 5.3
 */
class MAPAConfigController extends Controller
{
    protected SchemeContentService $contentService;

    public function __construct(SchemeContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Get MAPA01 configuration for a scheme.
     * GET /admin/skema/{id}/content/mapa01
     * 
     * Requirements: 4.1
     */
    public function showMAPA01(string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);
        $config = $this->contentService->getMAPA01Config($id);

        return response()->json([
            'success' => true,
            'data' => [
                'skema' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                ],
                'config' => $config,
                'has_config' => $config !== null,
            ],
        ]);
    }

    /**
     * Save MAPA01 configuration for a scheme.
     * POST /admin/skema/{id}/content/mapa01
     * 
     * Requirements: 4.2
     */
    public function storeMAPA01(Request $request, string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'config_data' => 'required|array',
        ]);

        $config = $this->contentService->saveMAPA01Config($id, $validated['config_data']);

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi MAPA01 berhasil disimpan',
            'data' => $config,
        ]);
    }

    /**
     * Get MAPA02 configuration for a scheme.
     * GET /admin/skema/{id}/content/mapa02
     * 
     * Requirements: 5.1
     */
    public function showMAPA02(string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);
        $config = $this->contentService->getMAPA02Config($id);

        return response()->json([
            'success' => true,
            'data' => [
                'skema' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                ],
                'config' => $config,
                'has_config' => $config !== null,
            ],
        ]);
    }

    /**
     * Save MAPA02 configuration for a scheme.
     * POST /admin/skema/{id}/content/mapa02
     * 
     * Requirements: 5.2, 5.3
     */
    public function storeMAPA02(Request $request, string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'muk_items' => 'nullable|array',
            'muk_items.*' => 'string',
            'default_potensi' => 'nullable|array',
        ]);

        $config = $this->contentService->saveMAPA02Config($id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi MAPA02 berhasil disimpan',
            'data' => $config,
        ]);
    }
}
