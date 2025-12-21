<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * IA05ContentController
 * 
 * Controller for managing IA05 multiple choice questions per scheme.
 * 
 * Requirements: 1.1, 1.2, 1.3, 1.4, 1.5
 */
class IA05ContentController extends Controller
{
    protected SchemeContentService $contentService;

    public function __construct(SchemeContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Get all IA05 questions for a scheme.
     * GET /admin/skema/{id}/content/ia05
     * 
     * Requirements: 1.1
     */
    public function index(string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);
        $questions = $this->contentService->getIA05Questions($id);

        return response()->json([
            'success' => true,
            'data' => [
                'skema' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                ],
                'questions' => $questions,
                'count' => $questions->count(),
            ],
        ]);
    }

    /**
     * Create a new IA05 question.
     * POST /admin/skema/{id}/content/ia05
     * 
     * Requirements: 1.2
     */
    public function store(Request $request, string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban_a' => 'nullable|string',
            'jawaban_b' => 'nullable|string',
            'jawaban_c' => 'nullable|string',
            'jawaban_d' => 'nullable|string',
            'jawaban_e' => 'nullable|string',
            'jawaban_benar' => 'required|string|in:a,b,c,d,e',
        ]);

        try {
            $question = $this->contentService->createIA05Question($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil ditambahkan',
                'data' => $question,
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update an existing IA05 question.
     * PUT /admin/skema/{id}/content/ia05/{kode}
     * 
     * Requirements: 1.3
     */
    public function update(Request $request, string $id, string $kode): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'pertanyaan' => 'sometimes|required|string',
            'jawaban_a' => 'nullable|string',
            'jawaban_b' => 'nullable|string',
            'jawaban_c' => 'nullable|string',
            'jawaban_d' => 'nullable|string',
            'jawaban_e' => 'nullable|string',
            'jawaban_benar' => 'sometimes|required|string|in:a,b,c,d,e',
        ]);

        try {
            $result = $this->contentService->updateIA05Question($kode, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil diperbarui',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Delete an IA05 question.
     * DELETE /admin/skema/{id}/content/ia05/{kode}
     * 
     * Requirements: 1.4
     */
    public function destroy(string $id, string $kode): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        try {
            $this->contentService->deleteIA05Question($kode);

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Soal tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Reorder IA05 questions.
     * POST /admin/skema/{id}/content/ia05/reorder
     * 
     * Requirements: 1.5
     */
    public function reorder(Request $request, string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|string',
        ]);

        $result = $this->contentService->reorderIA05Questions($id, $validated['order']);

        return response()->json([
            'success' => true,
            'message' => 'Urutan soal berhasil diperbarui',
        ]);
    }
}
