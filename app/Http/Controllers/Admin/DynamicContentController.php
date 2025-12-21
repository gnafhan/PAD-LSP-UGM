<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentContent;
use App\Models\Skema;
use App\Services\AccessControlService;
use App\Services\AssessmentContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * DynamicContentController
 * 
 * @deprecated This controller is deprecated in favor of the new scheme-specific content controllers.
 * 
 * The following controllers should be used instead:
 * - SchemeContentController: Dashboard for scheme content management
 * - IA05ContentController: Multiple choice questions (Soal)
 * - IA02ContentController: Work instructions (IA02Template)
 * - IA07ContentController: Oral questions (IA07Question)
 * - MAPAConfigController: MAPA01 and MAPA02 configurations
 * - IA11ContentController: Portfolio checklist items
 * - ContentCopyController: Copy content between schemes
 * 
 * New routes are available under:
 * - GET /admin/skema/{id}/content - Dashboard
 * - GET/POST /admin/skema/{id}/content/ia05 - IA05 questions
 * - GET/POST /admin/skema/{id}/content/ia02 - IA02 templates
 * - GET/POST /admin/skema/{id}/content/ia07 - IA07 questions
 * - GET/POST /admin/skema/{id}/content/mapa01 - MAPA01 config
 * - GET/POST /admin/skema/{id}/content/mapa02 - MAPA02 config
 * - GET/POST /admin/skema/{id}/content/ia11 - IA11 checklist
 * 
 * This controller is kept for backward compatibility but will redirect to new routes.
 * 
 * @see \App\Http\Controllers\Admin\SchemeContentController
 * @see \App\Http\Controllers\Admin\IA05ContentController
 * @see \App\Http\Controllers\Admin\IA02ContentController
 * @see \App\Http\Controllers\Admin\IA07ContentController
 * @see \App\Http\Controllers\Admin\MAPAConfigController
 * @see \App\Http\Controllers\Admin\IA11ContentController
 */
class DynamicContentController extends Controller
{
    /**
     * @var AssessmentContentService
     */
    protected AssessmentContentService $contentService;

    /**
     * @var AccessControlService
     */
    protected AccessControlService $accessControlService;

    /**
     * Create a new controller instance.
     *
     * @param AssessmentContentService $contentService
     * @param AccessControlService $accessControlService
     */
    public function __construct(
        AssessmentContentService $contentService,
        AccessControlService $accessControlService
    ) {
        $this->contentService = $contentService;
        $this->accessControlService = $accessControlService;
    }

    /**
     * Show the assessment content management page.
     * 
     * @deprecated Use SchemeContentController::index() instead.
     * GET /admin/skema/{id}/content
     * 
     * This method now redirects to the new scheme content dashboard.
     *
     * @param string $skemaId The scheme ID
     * @return View|\Illuminate\Http\RedirectResponse
     */
    public function showContentPage(string $skemaId)
    {
        // Log deprecation warning
        Log::warning('Deprecated: DynamicContentController::showContentPage() called. Use SchemeContentController::index() instead.', [
            'id_skema' => $skemaId,
            'user_id' => Auth::id(),
        ]);

        // Find the scheme
        $skema = Skema::find($skemaId);
        
        if (!$skema) {
            return redirect()->route('admin.skema.index')
                ->with('error', 'Skema tidak ditemukan');
        }

        // Redirect to new scheme content dashboard
        return redirect()->route('admin.skema.content.index', $skemaId)
            ->with('info', 'Halaman manajemen konten telah diperbarui. Anda dialihkan ke halaman baru.');
    }

    /**
     * Get content for a scheme and assessment type.
     * 
     * @deprecated Use the specific content controllers instead:
     * - IA05ContentController::index() for IA05/IA07 questions
     * - IA02ContentController::show() for IA02 templates
     * - IA07ContentController::index() for oral questions
     * - MAPAConfigController::showMAPA01/showMAPA02() for MAPA configs
     * - IA11ContentController::index() for IA11 checklist
     * 
     * GET /assessment-content/{skemaId}/{type}
     *
     * @param string $skemaId The scheme ID
     * @param string $type The assessment type
     * @return JsonResponse
     */
    public function index(string $skemaId, string $type): JsonResponse
    {
        // Log deprecation warning
        Log::warning('Deprecated: DynamicContentController::index() called. Use specific content controllers instead.', [
            'id_skema' => $skemaId,
            'assessment_type' => $type,
            'user_id' => Auth::id(),
        ]);

        try {
            // Find the scheme
            $skema = Skema::find($skemaId);
            
            if (!$skema) {
                return response()->json([
                    'success' => false,
                    'message' => 'Scheme not found',
                    'deprecated' => true,
                    'redirect_to' => route('admin.skema.content.index', $skemaId),
                ], 404);
            }

            // Check authorization
            $user = Auth::user();
            if (!$this->accessControlService->canManageSkema($user, $skemaId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this scheme',
                ], 403);
            }

            // Validate assessment type
            if (!AssessmentContent::isValidAssessmentType($type)) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid assessment type: {$type}. Valid types are: " . 
                        implode(', ', AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                    'deprecated' => true,
                    'note' => 'This endpoint is deprecated. Please use the new scheme content API.',
                ], 400);
            }

            // Get content for scheme and type
            $content = $this->contentService->getContentBySkema($skemaId, $type);

            return response()->json([
                'success' => true,
                'deprecated' => true,
                'deprecation_notice' => 'This endpoint is deprecated. Please migrate to the new scheme content API at /admin/skema/{id}/content/*',
                'data' => [
                    'id_skema' => $skema->id_skema,
                    'nama_skema' => $skema->nama_skema,
                    'assessment_type' => $type,
                    'content' => $content->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'content_type' => $item->content_type,
                            'content_data' => $item->content_data,
                            'display_order' => $item->display_order,
                            'created_by' => $item->created_by,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                        ];
                    }),
                    'total_count' => $content->count(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get assessment content (deprecated endpoint)', [
                'id_skema' => $skemaId,
                'assessment_type' => $type,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve assessment content',
                'deprecated' => true,
            ], 500);
        }
    }


    /**
     * Create new assessment content.
     * 
     * @deprecated Use the specific content controllers instead:
     * - IA05ContentController::store() for IA05 questions
     * - IA02ContentController::store() for IA02 templates
     * - IA07ContentController::store() for oral questions
     * - MAPAConfigController::storeMAPA01/storeMAPA02() for MAPA configs
     * - IA11ContentController::store() for IA11 checklist
     * 
     * POST /assessment-content
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Log deprecation warning
        Log::warning('Deprecated: DynamicContentController::store() called. Use specific content controllers instead.', [
            'id_skema' => $request->input('id_skema'),
            'assessment_type' => $request->input('assessment_type'),
            'user_id' => Auth::id(),
        ]);

        try {
            // Validate request
            $validated = $request->validate([
                'id_skema' => 'required|string',
                'assessment_type' => 'required|string',
                'content_type' => 'required|string',
                'content_data' => 'required|array',
                'display_order' => 'nullable|integer|min:0',
            ]);

            // Find the scheme
            $skema = Skema::find($validated['id_skema']);
            
            if (!$skema) {
                return response()->json([
                    'success' => false,
                    'message' => 'Scheme not found',
                    'deprecated' => true,
                ], 404);
            }

            // Check authorization
            $user = Auth::user();
            if (!$this->accessControlService->canManageSkema($user, $validated['id_skema'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this scheme',
                ], 403);
            }

            // Validate assessment type
            if (!AssessmentContent::isValidAssessmentType($validated['assessment_type'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid assessment type: {$validated['assessment_type']}. Valid types are: " . 
                        implode(', ', AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                    'deprecated' => true,
                ], 400);
            }

            // Validate content type
            if (!AssessmentContent::isValidContentType($validated['content_type'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid content type: {$validated['content_type']}. Valid types are: " . 
                        implode(', ', AssessmentContent::CONTENT_TYPES),
                    'deprecated' => true,
                ], 400);
            }

            // Create content
            $contentData = [
                'id_skema' => $validated['id_skema'],
                'assessment_type' => $validated['assessment_type'],
                'content_type' => $validated['content_type'],
                'content_data' => $validated['content_data'],
                'created_by' => $user->id_user,
            ];

            if (isset($validated['display_order'])) {
                $contentData['display_order'] = $validated['display_order'];
            }

            $content = $this->contentService->createContent($contentData);

            Log::info('Assessment content created (via deprecated endpoint)', [
                'id' => $content->id,
                'id_skema' => $validated['id_skema'],
                'assessment_type' => $validated['assessment_type'],
                'created_by' => $user->id_user,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Assessment content created successfully',
                'deprecated' => true,
                'deprecation_notice' => 'This endpoint is deprecated. Please migrate to the new scheme content API.',
                'data' => [
                    'id' => $content->id,
                    'id_skema' => $content->id_skema,
                    'assessment_type' => $content->assessment_type,
                    'content_type' => $content->content_type,
                    'content_data' => $content->content_data,
                    'display_order' => $content->display_order,
                    'created_by' => $content->created_by,
                    'created_at' => $content->created_at,
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'deprecated' => true,
            ], 422);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'deprecated' => true,
            ], 400);
        } catch (\Exception $e) {
            Log::error('Failed to create assessment content (deprecated endpoint)', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create assessment content',
                'deprecated' => true,
            ], 500);
        }
    }


    /**
     * Update existing assessment content.
     * 
     * @deprecated Use the specific content controllers instead:
     * - IA05ContentController::update() for IA05 questions
     * - IA02ContentController::store() for IA02 templates (uses upsert)
     * - IA07ContentController::update() for oral questions
     * - MAPAConfigController::storeMAPA01/storeMAPA02() for MAPA configs (uses upsert)
     * - IA11ContentController::update() for IA11 checklist
     * 
     * PUT /assessment-content/{id}
     *
     * @param Request $request
     * @param int $id The content ID
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Log deprecation warning
        Log::warning('Deprecated: DynamicContentController::update() called. Use specific content controllers instead.', [
            'content_id' => $id,
            'user_id' => Auth::id(),
        ]);

        try {
            // Find the content
            $content = AssessmentContent::find($id);
            
            if (!$content) {
                return response()->json([
                    'success' => false,
                    'message' => 'Assessment content not found',
                    'deprecated' => true,
                ], 404);
            }

            // Check authorization based on the content's scheme
            $user = Auth::user();
            if (!$this->accessControlService->canManageSkema($user, $content->id_skema)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this scheme',
                ], 403);
            }

            // Validate request
            $validated = $request->validate([
                'assessment_type' => 'nullable|string',
                'content_type' => 'nullable|string',
                'content_data' => 'nullable|array',
                'display_order' => 'nullable|integer|min:0',
            ]);

            // Validate assessment type if provided
            if (isset($validated['assessment_type']) && 
                !AssessmentContent::isValidAssessmentType($validated['assessment_type'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid assessment type: {$validated['assessment_type']}. Valid types are: " . 
                        implode(', ', AssessmentContent::CONTENT_ASSESSMENT_TYPES),
                    'deprecated' => true,
                ], 400);
            }

            // Validate content type if provided
            if (isset($validated['content_type']) && 
                !AssessmentContent::isValidContentType($validated['content_type'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid content type: {$validated['content_type']}. Valid types are: " . 
                        implode(', ', AssessmentContent::CONTENT_TYPES),
                    'deprecated' => true,
                ], 400);
            }

            // Update content (id_skema is preserved by the service)
            $this->contentService->updateContent($id, $validated);

            // Refresh the content to get updated values
            $content->refresh();

            Log::info('Assessment content updated (via deprecated endpoint)', [
                'id' => $id,
                'id_skema' => $content->id_skema,
                'updated_by' => $user->id_user,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Assessment content updated successfully',
                'deprecated' => true,
                'deprecation_notice' => 'This endpoint is deprecated. Please migrate to the new scheme content API.',
                'data' => [
                    'id' => $content->id,
                    'id_skema' => $content->id_skema,
                    'assessment_type' => $content->assessment_type,
                    'content_type' => $content->content_type,
                    'content_data' => $content->content_data,
                    'display_order' => $content->display_order,
                    'created_by' => $content->created_by,
                    'created_at' => $content->created_at,
                    'updated_at' => $content->updated_at,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'deprecated' => true,
            ], 422);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'deprecated' => true,
            ], 400);
        } catch (\Exception $e) {
            Log::error('Failed to update assessment content (deprecated endpoint)', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update assessment content',
                'deprecated' => true,
            ], 500);
        }
    }


    /**
     * Delete assessment content.
     * 
     * @deprecated Use the specific content controllers instead:
     * - IA05ContentController::destroy() for IA05 questions
     * - IA07ContentController::destroy() for oral questions
     * - IA11ContentController::destroy() for IA11 checklist
     * 
     * DELETE /assessment-content/{id}
     *
     * @param int $id The content ID
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        // Log deprecation warning
        Log::warning('Deprecated: DynamicContentController::destroy() called. Use specific content controllers instead.', [
            'content_id' => $id,
            'user_id' => Auth::id(),
        ]);

        try {
            // Find the content
            $content = AssessmentContent::find($id);
            
            if (!$content) {
                return response()->json([
                    'success' => false,
                    'message' => 'Assessment content not found',
                    'deprecated' => true,
                ], 404);
            }

            // Check authorization based on the content's scheme
            $user = Auth::user();
            if (!$this->accessControlService->canManageSkema($user, $content->id_skema)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have access to this scheme',
                ], 403);
            }

            // Store info for logging before deletion
            $idSkema = $content->id_skema;
            $assessmentType = $content->assessment_type;

            // Delete content
            $this->contentService->deleteContent($id);

            Log::info('Assessment content deleted (via deprecated endpoint)', [
                'id' => $id,
                'id_skema' => $idSkema,
                'assessment_type' => $assessmentType,
                'deleted_by' => $user->id_user,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Assessment content deleted successfully',
                'deprecated' => true,
                'deprecation_notice' => 'This endpoint is deprecated. Please migrate to the new scheme content API.',
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'deprecated' => true,
            ], 400);
        } catch (\Exception $e) {
            Log::error('Failed to delete assessment content (deprecated endpoint)', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete assessment content',
                'deprecated' => true,
            ], 500);
        }
    }
}
