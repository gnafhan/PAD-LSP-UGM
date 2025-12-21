<?php

namespace App\Services;

use App\Models\AssessmentContent;
use App\Models\Skema;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * AssessmentContentService
 * 
 * Service for managing dynamic assessment content (questions, tasks) per scheme.
 * Handles CRUD operations while maintaining scheme associations.
 * 
 * Requirements: 4.1, 4.2, 4.3, 4.4, 4.5
 */
class AssessmentContentService
{
    /**
     * Get content filtered by scheme and optionally by assessment type.
     * Returns content ordered by display_order.
     * 
     * Requirements: 4.3
     *
     * @param string $idSkema The scheme ID
     * @param string|null $assessmentType Optional assessment type filter
     * @return Collection Collection of AssessmentContent models
     */
    public function getContentBySkema(string $idSkema, ?string $assessmentType = null): Collection
    {
        $query = AssessmentContent::forSkema($idSkema);

        if ($assessmentType !== null) {
            $query->forAssessmentType($assessmentType);
        }

        return $query->ordered()->get();
    }


    /**
     * Create new assessment content with scheme association.
     * Validates that the scheme exists and content types are valid.
     * 
     * Requirements: 4.1, 4.2
     *
     * @param array $data Content data including:
     *   - id_skema: string (required)
     *   - assessment_type: string (required)
     *   - content_type: string (required)
     *   - content_data: array (required)
     *   - created_by: string (required)
     *   - display_order: int (optional)
     * @return AssessmentContent The created content model
     * @throws \InvalidArgumentException If validation fails
     */
    public function createContent(array $data): AssessmentContent
    {
        // Validate required fields
        $requiredFields = ['id_skema', 'assessment_type', 'content_type', 'content_data', 'created_by'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        // Validate scheme exists
        $skema = Skema::find($data['id_skema']);
        if (!$skema) {
            throw new \InvalidArgumentException("Scheme not found: {$data['id_skema']}");
        }

        // Validate assessment type
        if (!AssessmentContent::isValidAssessmentType($data['assessment_type'])) {
            throw new \InvalidArgumentException(
                "Invalid assessment type: {$data['assessment_type']}. " .
                "Valid types are: " . implode(', ', AssessmentContent::CONTENT_ASSESSMENT_TYPES)
            );
        }

        // Validate content type
        if (!AssessmentContent::isValidContentType($data['content_type'])) {
            throw new \InvalidArgumentException(
                "Invalid content type: {$data['content_type']}. " .
                "Valid types are: " . implode(', ', AssessmentContent::CONTENT_TYPES)
            );
        }

        // Validate content_data is an array
        if (!is_array($data['content_data'])) {
            throw new \InvalidArgumentException("content_data must be an array");
        }

        try {
            // Set default display_order if not provided
            if (!isset($data['display_order'])) {
                $maxOrder = AssessmentContent::forSkema($data['id_skema'])
                    ->forAssessmentType($data['assessment_type'])
                    ->max('display_order');
                $data['display_order'] = ($maxOrder ?? -1) + 1;
            }

            $content = AssessmentContent::create([
                'id_skema' => $data['id_skema'],
                'assessment_type' => $data['assessment_type'],
                'content_type' => $data['content_type'],
                'content_data' => $data['content_data'],
                'created_by' => $data['created_by'],
                'display_order' => $data['display_order'],
            ]);

            Log::info("Assessment content created", [
                'id' => $content->id,
                'id_skema' => $data['id_skema'],
                'assessment_type' => $data['assessment_type'],
                'content_type' => $data['content_type'],
            ]);

            return $content;
        } catch (\Exception $e) {
            Log::error("Failed to create assessment content", [
                'id_skema' => $data['id_skema'],
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }


    /**
     * Update existing assessment content while preserving scheme association.
     * The scheme association (id_skema) cannot be changed.
     * 
     * Requirements: 4.4
     *
     * @param int $contentId The content ID to update
     * @param array $data Update data (id_skema is ignored if provided)
     * @return bool Success status
     * @throws \InvalidArgumentException If content not found or validation fails
     */
    public function updateContent(int $contentId, array $data): bool
    {
        $content = AssessmentContent::find($contentId);
        
        if (!$content) {
            throw new \InvalidArgumentException("Assessment content not found: {$contentId}");
        }

        // Preserve scheme association - remove id_skema from update data
        // This ensures Property 6: Content Edit Preserves Association
        $originalSkema = $content->id_skema;
        unset($data['id_skema']);

        // Validate assessment type if provided
        if (isset($data['assessment_type']) && !AssessmentContent::isValidAssessmentType($data['assessment_type'])) {
            throw new \InvalidArgumentException(
                "Invalid assessment type: {$data['assessment_type']}. " .
                "Valid types are: " . implode(', ', AssessmentContent::CONTENT_ASSESSMENT_TYPES)
            );
        }

        // Validate content type if provided
        if (isset($data['content_type']) && !AssessmentContent::isValidContentType($data['content_type'])) {
            throw new \InvalidArgumentException(
                "Invalid content type: {$data['content_type']}. " .
                "Valid types are: " . implode(', ', AssessmentContent::CONTENT_TYPES)
            );
        }

        // Validate content_data is an array if provided
        if (isset($data['content_data']) && !is_array($data['content_data'])) {
            throw new \InvalidArgumentException("content_data must be an array");
        }

        try {
            // Only update allowed fields
            $allowedFields = ['assessment_type', 'content_type', 'content_data', 'display_order'];
            $updateData = array_intersect_key($data, array_flip($allowedFields));

            $updated = $content->update($updateData);

            // Verify scheme association is preserved
            $content->refresh();
            if ($content->id_skema !== $originalSkema) {
                Log::error("Scheme association changed unexpectedly", [
                    'content_id' => $contentId,
                    'original_skema' => $originalSkema,
                    'new_skema' => $content->id_skema
                ]);
                throw new \RuntimeException("Scheme association was unexpectedly modified");
            }

            Log::info("Assessment content updated", [
                'id' => $contentId,
                'id_skema' => $originalSkema,
                'updated_fields' => array_keys($updateData),
            ]);

            return $updated;
        } catch (\Exception $e) {
            Log::error("Failed to update assessment content", [
                'content_id' => $contentId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }


    /**
     * Delete assessment content from a scheme.
     * 
     * Requirements: 4.5
     *
     * @param int $contentId The content ID to delete
     * @return bool Success status
     * @throws \InvalidArgumentException If content not found
     */
    public function deleteContent(int $contentId): bool
    {
        $content = AssessmentContent::find($contentId);
        
        if (!$content) {
            throw new \InvalidArgumentException("Assessment content not found: {$contentId}");
        }

        try {
            $idSkema = $content->id_skema;
            $assessmentType = $content->assessment_type;
            
            $deleted = $content->delete();

            Log::info("Assessment content deleted", [
                'id' => $contentId,
                'id_skema' => $idSkema,
                'assessment_type' => $assessmentType,
            ]);

            return $deleted;
        } catch (\Exception $e) {
            Log::error("Failed to delete assessment content", [
                'content_id' => $contentId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Duplicate content from one scheme to another.
     * Creates copies of all content from source scheme to target scheme.
     * 
     * @param string $sourceSkema The source scheme ID
     * @param string $targetSkema The target scheme ID
     * @param string $createdBy The user ID creating the duplicates
     * @return bool Success status
     */
    public function duplicateContentToSkema(string $sourceSkema, string $targetSkema, string $createdBy): bool
    {
        // Validate schemes exist
        if (!Skema::find($sourceSkema)) {
            throw new \InvalidArgumentException("Source scheme not found: {$sourceSkema}");
        }
        if (!Skema::find($targetSkema)) {
            throw new \InvalidArgumentException("Target scheme not found: {$targetSkema}");
        }

        try {
            DB::beginTransaction();

            $sourceContent = $this->getContentBySkema($sourceSkema);
            
            foreach ($sourceContent as $content) {
                AssessmentContent::create([
                    'id_skema' => $targetSkema,
                    'assessment_type' => $content->assessment_type,
                    'content_type' => $content->content_type,
                    'content_data' => $content->content_data,
                    'created_by' => $createdBy,
                    'display_order' => $content->display_order,
                ]);
            }

            DB::commit();

            Log::info("Assessment content duplicated", [
                'source_skema' => $sourceSkema,
                'target_skema' => $targetSkema,
                'content_count' => $sourceContent->count(),
            ]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to duplicate assessment content", [
                'source_skema' => $sourceSkema,
                'target_skema' => $targetSkema,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get content count for a scheme, optionally filtered by assessment type.
     * 
     * @param string $idSkema The scheme ID
     * @param string|null $assessmentType Optional assessment type filter
     * @return int Content count
     */
    public function getContentCount(string $idSkema, ?string $assessmentType = null): int
    {
        $query = AssessmentContent::forSkema($idSkema);

        if ($assessmentType !== null) {
            $query->forAssessmentType($assessmentType);
        }

        return $query->count();
    }

    /**
     * Reorder content items within a scheme and assessment type.
     * 
     * @param string $idSkema The scheme ID
     * @param string $assessmentType The assessment type
     * @param array $orderedIds Array of content IDs in desired order
     * @return bool Success status
     */
    public function reorderContent(string $idSkema, string $assessmentType, array $orderedIds): bool
    {
        try {
            DB::beginTransaction();

            foreach ($orderedIds as $order => $contentId) {
                AssessmentContent::where('id', $contentId)
                    ->where('id_skema', $idSkema)
                    ->where('assessment_type', $assessmentType)
                    ->update(['display_order' => $order]);
            }

            DB::commit();

            Log::info("Assessment content reordered", [
                'id_skema' => $idSkema,
                'assessment_type' => $assessmentType,
                'content_count' => \count($orderedIds),
            ]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to reorder assessment content", [
                'id_skema' => $idSkema,
                'assessment_type' => $assessmentType,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
