<?php

namespace App\Observers;

use App\Models\Skema;
use App\Services\SkemaConfigService;
use Illuminate\Support\Facades\Log;

/**
 * SkemaObserver
 * 
 * Observes Skema model events to automatically create default assessment
 * configuration when a new scheme is created.
 * 
 * Requirements: 7.1
 */
class SkemaObserver
{
    private SkemaConfigService $skemaConfigService;

    public function __construct(SkemaConfigService $skemaConfigService)
    {
        $this->skemaConfigService = $skemaConfigService;
    }

    /**
     * Handle the Skema "created" event.
     * 
     * Creates default SkemaAssessmentConfig records with all assessments enabled.
     * 
     * Requirements: 7.1
     *
     * @param Skema $skema
     * @return void
     */
    public function created(Skema $skema): void
    {
        try {
            // Apply default configuration with all assessments enabled
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            Log::info("Default assessment configuration created for new scheme", [
                'id_skema' => $skema->id_skema,
                'nama_skema' => $skema->nama_skema,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to create default assessment configuration for scheme", [
                'id_skema' => $skema->id_skema,
                'error' => $e->getMessage(),
            ]);
            // Don't throw - allow scheme creation to succeed even if config fails
            // The system has backward compatibility for schemes without config
        }
    }

    /**
     * Handle the Skema "deleted" event.
     * 
     * Cleans up associated SkemaAssessmentConfig records when a scheme is deleted.
     *
     * @param Skema $skema
     * @return void
     */
    public function deleted(Skema $skema): void
    {
        try {
            // Delete associated assessment configurations
            $skema->assessmentConfig()->delete();

            Log::info("Assessment configuration deleted for scheme", [
                'id_skema' => $skema->id_skema,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to delete assessment configuration for scheme", [
                'id_skema' => $skema->id_skema,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
