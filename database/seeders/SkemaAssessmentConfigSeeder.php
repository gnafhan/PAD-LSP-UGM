<?php

namespace Database\Seeders;

use App\Enums\AssessmentType;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * SkemaAssessmentConfigSeeder
 * 
 * Seeds default assessment configuration for all existing schemes.
 * All assessments are enabled by default to maintain backward compatibility.
 * 
 * Requirements: 7.1
 */
class SkemaAssessmentConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates default assessment configuration for all existing schemes
     * that don't already have configuration records.
     */
    public function run(): void
    {
        $this->command->info('Starting SkemaAssessmentConfig seeding...');

        // Get all existing schemes
        $skemas = Skema::all();
        
        if ($skemas->isEmpty()) {
            $this->command->warn('No schemes found. Skipping assessment config seeding.');
            return;
        }

        $this->command->info("Found {$skemas->count()} schemes to process.");

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($skemas as $skema) {
            // Check if scheme already has configuration
            $existingConfigCount = SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->count();
            
            if ($existingConfigCount > 0) {
                $this->command->line("  Skipping {$skema->nama_skema} - already has {$existingConfigCount} config records.");
                $skippedCount++;
                continue;
            }

            // Create default configuration for this scheme
            $this->createDefaultConfigForSkema($skema);
            $createdCount++;
            $this->command->line("  Created config for: {$skema->nama_skema}");
        }

        $this->command->info("Seeding complete. Created: {$createdCount}, Skipped: {$skippedCount}");
    }

    /**
     * Create default assessment configuration for a scheme.
     * All assessment types are enabled by default.
     *
     * @param Skema $skema The scheme to create configuration for
     */
    private function createDefaultConfigForSkema(Skema $skema): void
    {
        $allTypes = AssessmentType::getAllTypes();
        $displayOrder = 0;

        try {
            DB::beginTransaction();

            foreach ($allTypes as $assessmentType) {
                SkemaAssessmentConfig::create([
                    'id_skema' => $skema->id_skema,
                    'assessment_type' => $assessmentType,
                    'is_enabled' => true, // All enabled by default
                    'display_order' => $displayOrder++,
                    'config_data' => null,
                ]);
            }

            DB::commit();

            Log::info("Created default assessment config for scheme", [
                'id_skema' => $skema->id_skema,
                'nama_skema' => $skema->nama_skema,
                'config_count' => count($allTypes)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to create assessment config for scheme", [
                'id_skema' => $skema->id_skema,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
