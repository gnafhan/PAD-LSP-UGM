<?php
namespace App\Services;

use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use Illuminate\Support\Facades\Log;

class ProgressTrackingService
{
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
}