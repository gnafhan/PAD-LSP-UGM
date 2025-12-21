<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Services\ContentCopyService;
use App\Services\SchemeContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ContentCopyController
 * 
 * Controller for copying assessment content between schemes.
 * 
 * Requirements: 9.1, 9.2, 9.3
 */
class ContentCopyController extends Controller
{
    protected ContentCopyService $copyService;
    protected SchemeContentService $contentService;

    public function __construct(ContentCopyService $copyService, SchemeContentService $contentService)
    {
        $this->copyService = $copyService;
        $this->contentService = $contentService;
    }

    /**
     * Get schemes that have content available for copying.
     * GET /admin/content/copy/sources
     * 
     * Requirements: 9.1
     */
    public function sources(): JsonResponse
    {
        $schemes = $this->copyService->getSchemesWithContent();

        $schemesWithSummary = $schemes->map(function ($scheme) {
            return [
                'id_skema' => $scheme->id_skema,
                'nomor_skema' => $scheme->nomor_skema,
                'nama_skema' => $scheme->nama_skema,
                'summary' => $this->contentService->getContentSummary($scheme->id_skema),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'schemes' => $schemesWithSummary,
                'count' => $schemes->count(),
            ],
        ]);
    }

    /**
     * Copy content from source to target scheme.
     * POST /admin/content/copy
     * 
     * Requirements: 9.2, 9.3
     */
    public function copy(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'source_skema' => 'required|string|exists:skema,id_skema',
            'target_skema' => 'required|string|exists:skema,id_skema|different:source_skema',
            'overwrite' => 'boolean',
        ]);

        $sourceSkema = $validated['source_skema'];
        $targetSkema = $validated['target_skema'];
        $overwrite = $validated['overwrite'] ?? false;

        try {
            // Check if target has content and overwrite is not requested
            if (!$overwrite && $this->contentService->hasContent($targetSkema)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Skema target sudah memiliki konten. Konfirmasi untuk menimpa.',
                    'requires_confirmation' => true,
                    'target_summary' => $this->contentService->getContentSummary($targetSkema),
                ], 409);
            }

            $summary = $this->copyService->copyAllContent($sourceSkema, $targetSkema, $overwrite);

            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil disalin',
                'data' => [
                    'source_skema' => $sourceSkema,
                    'target_skema' => $targetSkema,
                    'summary' => $summary,
                ],
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
