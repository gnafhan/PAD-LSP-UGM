<?php
namespace App\Services;

use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use Illuminate\Support\Facades\Log;

class ProgressTrackingService
{
    /**
     * The SkemaConfigService instance.
     * Used for checking scheme-based assessment configuration.
     * 
     * Requirements: 8.3
     */
    private SkemaConfigService $skemaConfigService;

    /**
     * Create a new ProgressTrackingService instance.
     * 
     * @param SkemaConfigService $skemaConfigService
     */
    public function __construct(SkemaConfigService $skemaConfigService)
    {
        $this->skemaConfigService = $skemaConfigService;
    }

    /**
     * Mark a step as completed for an asesi
     *
     * @param string $idAsesi The asesi ID
     * @param string $step The step to mark as completed
     * @param string $context Additional context for logging
     * @return bool Success status
     */
    public function completeStep(string $idAsesi, string $step, string $context = ''): bool
    {
        $asesi = Asesi::with('progresAsesmen')->where('id_asesi', $idAsesi)->first();
        
        if (!$asesi || !$asesi->progresAsesmen) {
            Log::warning("Failed to complete step $step: Asesi or ProgresAsesmen not found", [
                'id_asesi' => $idAsesi,
                'step' => $step
            ]);
            return false;
        }
        
        $result = $asesi->progresAsesmen->completeStep($step);
        
        if ($result) {
            Log::info("Step $step completed for Asesi", [
                'id_asesi' => $idAsesi,
                'step' => $step,
                'context' => $context,
                'completed_at' => $asesi->progresAsesmen->getStepCompletionTime($step)
            ]);
        }

        else {
            Log::warning("Failed to complete step $step for Asesi", [
                'id_asesi' => $idAsesi,
                'step' => $step
            ]);
        }
        
        return $result;
    }
    
    /**
     * Check if a step is completed for an asesi
     *
     * @param string $idAsesi The asesi ID
     * @param string $step The step to check
     * @return bool Whether the step is completed
     */
    public function isStepCompleted(string $idAsesi, string $step): bool
    {
        $asesi = Asesi::with('progresAsesmen')->where('id_asesi', $idAsesi)->first();
        
        if (!$asesi || !$asesi->progresAsesmen) {
            return false;
        }
        
        return $asesi->progresAsesmen->isStepCompleted($step);
    }
    
    /**
     * Get completion time for a step
     *
     * @param string $idAsesi The asesi ID
     * @param string $step The step to get the completion time for
     * @return string|null The completion time or null if not completed
     */
    public function getStepCompletionTime(string $idAsesi, string $step): ?string
    {
        $asesi = Asesi::with('progresAsesmen')->where('id_asesi', $idAsesi)->first();
        
        if (!$asesi || !$asesi->progresAsesmen) {
            return null;
        }
        
        return $asesi->progresAsesmen->getStepCompletionTime($step);
    }
    
    /**
     * Get all progress data for an asesi
     *
     * @param string $idAsesi The asesi ID
     * @return array|null Progress data or null if not found
     */
    public function getProgressData(string $idAsesi): ?array
    {
        $asesi = Asesi::with('progresAsesmen')->where('id_asesi', $idAsesi)->first();
        
        if (!$asesi || !$asesi->progresAsesmen) {
            return null;
        }
        
        return [
            'progress_details' => $asesi->progresAsesmen->getStructuredProgress(),
            'progress_summary' => $asesi->progresAsesmen->calculateProgress()
        ];
    }

    /**
     * Get progress data filtered by enabled assessments for the asesi's scheme.
     * Returns only progress for assessments that are enabled in the scheme configuration.
     * 
     * Requirements: 8.3
     *
     * @param string $idAsesi The asesi ID
     * @return array|null Progress data filtered by enabled assessments, or null if not found
     */
    public function getEnabledProgressData(string $idAsesi): ?array
    {
        $asesi = Asesi::with(['progresAsesmen', 'skema'])->where('id_asesi', $idAsesi)->first();
        
        if (!$asesi || !$asesi->progresAsesmen) {
            return null;
        }
        
        // Get enabled assessments progress from the model
        $enabledProgress = $asesi->progresAsesmen->getEnabledAssessmentsProgress();
        
        // Calculate progress based on enabled assessments only
        $progressSummary = $asesi->progresAsesmen->calculateProgress(true);
        
        return [
            'progress_details' => $enabledProgress,
            'progress_summary' => $progressSummary
        ];
    }

    /**
     * Calculate progress percentage based on enabled assessments only.
     * Uses the scheme configuration to determine which assessments count toward progress.
     * 
     * Requirements: 8.3
     *
     * @param string $idAsesi The asesi ID
     * @return array Progress calculation with percentage, completed steps, and total steps
     */
    public function calculateSchemeBasedProgress(string $idAsesi): array
    {
        $asesi = Asesi::with(['progresAsesmen', 'skema'])->where('id_asesi', $idAsesi)->first();
        
        if (!$asesi || !$asesi->progresAsesmen) {
            return [
                'progress_percentage' => 0,
                'completed_steps' => 0,
                'total_steps' => 0,
                'enabled_assessments' => []
            ];
        }

        // Get the scheme ID
        $idSkema = $asesi->id_skema;
        
        // Get enabled assessments for the scheme
        $enabledAssessments = $idSkema 
            ? $this->skemaConfigService->getEnabledAssessments($idSkema)->toArray()
            : [];

        // Calculate progress using the model's method
        $progressData = $asesi->progresAsesmen->calculateProgress(true);
        
        return [
            'progress_percentage' => $progressData['progress_percentage'],
            'completed_steps' => $progressData['completed_steps'],
            'total_steps' => $progressData['total_steps'],
            'enabled_assessments' => $enabledAssessments
        ];
    }

    /**
     * Check if a step is enabled for an asesi's scheme.
     * Uses the scheme configuration to determine if the assessment step is enabled.
     * 
     * Requirements: 5.3
     *
     * @param string $idAsesi The asesi ID
     * @param string $step The step/assessment type to check
     * @return bool Whether the step is enabled for the asesi's scheme
     */
    public function isStepEnabledForAsesi(string $idAsesi, string $step): bool
    {
        $asesi = Asesi::with('skema')->where('id_asesi', $idAsesi)->first();
        
        if (!$asesi) {
            return false;
        }

        // If asesi has no scheme, default to enabled (backward compatibility)
        if (!$asesi->id_skema) {
            return true;
        }

        // Get the assessment type for this step field
        $assessmentType = ProgresAsesmen::getAssessmentTypeForField($step);
        
        // If no mapping exists, the step is always enabled (e.g., hasil_asesmen, umpan_balik)
        if ($assessmentType === null) {
            return true;
        }

        // Use SkemaConfigService to check if assessment is enabled
        return $this->skemaConfigService->isAssessmentEnabled($asesi->id_skema, $assessmentType);
    }
}