<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * IA07ContentController
 * 
 * Controller for managing IA07 oral questions per scheme.
 * Questions are organized by unit kompetensi and elemen UK.
 * 
 * Requirements: 3.1, 3.2, 3.3, 3.4
 */
class IA07ContentController extends Controller
{
    protected SchemeContentService $contentService;

    public function __construct(SchemeContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Get all IA07 questions for a scheme, grouped by UK and elemen.
     * GET /admin/skema/{id}/content/ia07
     * 
     * Requirements: 3.1
     */
    public function index(string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);
        $questions = $this->contentService->getIA07Questions($id);
        $groupedQuestions = $this->contentService->getIA07QuestionsGrouped($id);
        $unitKompetensi = $skema->getUnitKompetensi();

        return response()->json([
            'success' => true,
            'data' => [
                'skema' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                ],
                'questions' => $questions,
                'grouped' => $groupedQuestions,
                'unit_kompetensi' => $unitKompetensi,
                'count' => $questions->count(),
            ],
        ]);
    }

    /**
     * Create a new IA07 oral question.
     * POST /admin/skema/{id}/content/ia07
     * 
     * Requirements: 3.2
     */
    public function store(Request $request, string $id): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'id_uk' => 'required|string|exists:uk,id_uk',
            'id_elemen_uk' => 'required|integer|exists:elemen_uk,id_elemen_uk',
            'pertanyaan' => 'required|string',
            'is_active' => 'boolean',
        ]);

        try {
            $question = $this->contentService->createIA07Question($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Pertanyaan lisan berhasil ditambahkan',
                'data' => $question->load(['unitKompetensi', 'elemenUK']),
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update an existing IA07 oral question.
     * PUT /admin/skema/{id}/content/ia07/{questionId}
     * 
     * Requirements: 3.3
     */
    public function update(Request $request, string $id, int $questionId): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        $validated = $request->validate([
            'pertanyaan' => 'sometimes|required|string',
            'is_active' => 'boolean',
        ]);

        try {
            $result = $this->contentService->updateIA07Question($questionId, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Pertanyaan lisan berhasil diperbarui',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Delete an IA07 oral question.
     * DELETE /admin/skema/{id}/content/ia07/{questionId}
     * 
     * Requirements: 3.4
     */
    public function destroy(string $id, int $questionId): JsonResponse
    {
        $skema = Skema::findOrFail($id);

        try {
            $this->contentService->deleteIA07Question($questionId);

            return response()->json([
                'success' => true,
                'message' => 'Pertanyaan lisan berhasil dihapus',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan tidak ditemukan',
            ], 404);
        }
    }
}
