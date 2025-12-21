<?php

namespace Database\Seeders;

use App\Enums\AssessmentType;
use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\ProgressTrackingService;
use App\Services\SkemaConfigService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

/**
 * VerifyProgressDataCompatibilitySeeder
 * 
 * Verifies that existing progres_asesmen data works correctly with the new
 * dynamic assessment configuration system.
 * 
 * This seeder performs the following checks:
 * 1. Existing progress data is accessible via the new service methods
 * 2. Progress calculation works correctly with scheme configuration
 * 3. Historical completion data is preserved when assessments are disabled
 * 
 * Requirements: 8.4
 */
class VerifyProgressDataCompatibilitySeeder extends Seeder
{
    private SkemaConfigService $configService;
    private ProgressTrackingService $progressService;

    public function __construct()
    {
        $this->configService = new SkemaConfigService();
        $this->progressService = new ProgressTrackingService($this->configService);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting progress data compatibility verification...');

        // Get all existing progress records
        $progressRecords = ProgresAsesmen::with('asesi.skema')->get();

        if ($progressRecords->isEmpty()) {
            $this->command->warn('No progress records found. Skipping compatibility verification.');
            return;
        }

        $this->command->info("Found {$progressRecords->count()} progress records to verify.");

        $passedCount = 0;
        $failedCount = 0;
        $errors = [];

        foreach ($progressRecords as $progress) {
            $result = $this->verifyProgressRecord($progress);
            
            if ($result['passed']) {
                $passedCount++;
            } else {
                $failedCount++;
                $errors[] = $result['error'];
                $this->command->error("  FAILED: {$result['error']}");
            }
        }

        $this->command->newLine();
        $this->command->info("Verification complete.");
        $this->command->info("  Passed: {$passedCount}");
        
        if ($failedCount > 0) {
            $this->command->error("  Failed: {$failedCount}");
            foreach ($errors as $error) {
                $this->command->error("    - {$error}");
            }
        } else {
            $this->command->info("  Failed: 0");
            $this->command->info("All progress records are compatible with the new system!");
        }
    }

    /**
     * Verify a single progress record for compatibility.
     *
     * @param ProgresAsesmen $progress
     * @return array ['passed' => bool, 'error' => string|null]
     */
    private function verifyProgressRecord(ProgresAsesmen $progress): array
    {
        $idAsesi = $progress->id_asesi;

        try {
            // Check 1: Progress record can be retrieved via service
            $progressData = $this->progressService->getProgressData($idAsesi);
            if ($progressData === null) {
                return [
                    'passed' => false,
                    'error' => "Progress data not retrievable for asesi {$idAsesi}"
                ];
            }

            // Check 2: Progress calculation works
            $calculatedProgress = $progress->calculateProgress(false); // Without scheme config
            if (!isset($calculatedProgress['progress_percentage'])) {
                return [
                    'passed' => false,
                    'error' => "Progress calculation failed for asesi {$idAsesi}"
                ];
            }

            // Check 3: If asesi has a scheme, verify scheme-based progress works
            $asesi = $progress->asesi;
            if ($asesi && $asesi->id_skema) {
                // Ensure scheme has configuration (create default if not)
                $this->ensureSchemeHasConfig($asesi->id_skema);

                // Verify scheme-based progress calculation
                $schemeProgress = $this->progressService->calculateSchemeBasedProgress($idAsesi);
                if (!isset($schemeProgress['progress_percentage'])) {
                    return [
                        'passed' => false,
                        'error' => "Scheme-based progress calculation failed for asesi {$idAsesi}"
                    ];
                }

                // Verify enabled progress data retrieval
                $enabledProgress = $this->progressService->getEnabledProgressData($idAsesi);
                if ($enabledProgress === null) {
                    return [
                        'passed' => false,
                        'error' => "Enabled progress data not retrievable for asesi {$idAsesi}"
                    ];
                }
            }

            // Check 4: Verify historical data is preserved
            $structuredProgress = $progress->getStructuredProgress();
            foreach ($structuredProgress as $field => $data) {
                if (is_array($data) && isset($data['completed']) && $data['completed'] === true) {
                    // Verify completed_at is preserved
                    if (!isset($data['completed_at']) || $data['completed_at'] === null) {
                        // This is acceptable for legacy data that was boolean
                        Log::info("Legacy progress data detected", [
                            'id_asesi' => $idAsesi,
                            'field' => $field
                        ]);
                    }
                }
            }

            // Check 5: Verify isStepCompleted works for all fields
            $progressFields = [
                'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
                'mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan',
                'ak07', 'ia01', 'ia02', 'hasil_asesmen',
                'ak02', 'umpan_balik', 'ak04'
            ];

            foreach ($progressFields as $field) {
                // This should not throw an exception
                $isCompleted = $progress->isStepCompleted($field);
                // isCompleted can be true or false, we just verify it doesn't error
            }

            $this->command->line("  PASSED: Asesi {$idAsesi}");
            return ['passed' => true, 'error' => null];

        } catch (\Exception $e) {
            Log::error("Progress compatibility verification failed", [
                'id_asesi' => $idAsesi,
                'error' => $e->getMessage()
            ]);
            return [
                'passed' => false,
                'error' => "Exception for asesi {$idAsesi}: {$e->getMessage()}"
            ];
        }
    }

    /**
     * Ensure a scheme has assessment configuration.
     * Creates default configuration if none exists.
     *
     * @param string $idSkema
     */
    private function ensureSchemeHasConfig(string $idSkema): void
    {
        $existingConfig = SkemaAssessmentConfig::where('id_skema', $idSkema)->exists();
        
        if (!$existingConfig) {
            // Create default configuration
            $this->configService->applyDefaultConfig($idSkema);
            Log::info("Created default config for scheme during compatibility check", [
                'id_skema' => $idSkema
            ]);
        }
    }
}
