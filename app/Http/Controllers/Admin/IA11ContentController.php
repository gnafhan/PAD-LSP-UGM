<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * IA11ContentController
 * 
 * Controller for managing IA11 portfolio verification checklist per scheme.
 * 
 * Requirements: 6.1, 6.2, 6.3, 6.4
 */
class IA11ContentController extends Controller
{
    protected SchemeContentService $contentService;

    public function __construct(SchemeContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Get all IA11 checklist items for a scheme.
     * GET /admin/skema/{id}/content/ia11
     * 
     * Requirements: 6.1
     */
    public function index(string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);
        $checklist = $this->contentService->getIA11Checklist($id);

        return response()->json([
            'success' => true,
            'data' => [
                'skema' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                ],
                'checklist' => $checklist,
                'count' => $checklist->count(),
            ],
        ]);
    }

    /**
     * Create a new IA11 checklist item.
     * POST /admin/skema/{id}/content/ia11
     * 
     * Requirements: 6.2
     */
    public function store(Request $request, string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'verification_criteria' => 'nullable|string',
            'is_required' => 'boolean',
        ]);

        try {
            $item = $this->contentService->createIA11Item($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Item checklist berhasil ditambahkan',
                'data' => $item,
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update an existing IA11 checklist item.
     * PUT /admin/skema/{id}/content/ia11/{itemId}
     * 
     * Requirements: 6.3
     */
    public function update(Request $request, string $id, int $itemId): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'verification_criteria' => 'nullable|string',
            'is_required' => 'boolean',
        ]);

        try {
            $result = $this->contentService->updateIA11Item($itemId, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Item checklist berhasil diperbarui',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Delete an IA11 checklist item.
     * DELETE /admin/skema/{id}/content/ia11/{itemId}
     * 
     * Requirements: 6.4
     */
    public function destroy(string $id, int $itemId): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        try {
            $this->contentService->deleteIA11Item($itemId);

            return response()->json([
                'success' => true,
                'message' => 'Item checklist berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan',
            ], 404);
        }
    }
}
