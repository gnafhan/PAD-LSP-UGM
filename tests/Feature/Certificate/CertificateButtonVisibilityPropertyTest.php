<?php

namespace Tests\Feature\Certificate;

use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Models\User;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for Certificate Button Visibility
 * 
 * **Feature: certificate-generation, Property 1: Certificate button visibility matches progress state**
 * **Validates: Requirements 1.1, 1.2**
 */
class CertificateButtonVisibilityPropertyTest extends TestCase
{
    use RefreshDatabase;

    private SkemaConfigService $skemaConfigService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skemaConfigService = new SkemaConfigService();
    }

    /**
     * Helper to create asesi with specific progress
     */
    private function createAsesiWithProgress(User $user, Skema $skema, bool $fullProgress): Asesi
    {
        $asesi = Asesi::factory()->forSkema($skema)->create([
            'id_user' => $user->id_user
        ]);

        // Steps that ARE counted in progress (not in excludedFromProgress)
        $countedSteps = [
            'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
            'ak07', 'ia02', 'ia05', 'tugas_peserta',
            'ak02', 'umpan_balik'
        ];

        // Steps that are excluded from progress calculation
        $excludedSteps = ['mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan', 'ia01', 'ia11', 'hasil_asesmen', 'ak04'];

        $progressData = ['id_asesi' => $asesi->id_asesi];
        
        if ($fullProgress) {
            // All counted steps completed
            foreach ($countedSteps as $step) {
                $progressData[$step] = [
                    'completed' => true,
                    'completed_at' => now()->format('d-m-Y H:i:s') . ' WIB'
                ];
            }
        } else {
            // Only some steps completed (random incomplete state)
            $stepsToComplete = fake()->numberBetween(1, count($countedSteps) - 2);
            $completedSteps = fake()->randomElements($countedSteps, $stepsToComplete);
            
            foreach ($countedSteps as $step) {
                $isCompleted = in_array($step, $completedSteps);
                $progressData[$step] = [
                    'completed' => $isCompleted,
                    'completed_at' => $isCompleted ? now()->format('d-m-Y H:i:s') . ' WIB' : null
                ];
            }
        }
        
        // Set excluded steps (they don't affect percentage)
        foreach ($excludedSteps as $step) {
            $progressData[$step] = ['completed' => false, 'completed_at' => null];
        }

        ProgresAsesmen::create($progressData);

        return $asesi;
    }

    /**
     * Property 1: Certificate button visibility matches progress state
     * 
     * For any asesi, the certificate download button is visible if and only if
     * the asesi's progress percentage equals 100%.
     * 
     * **Feature: certificate-generation, Property 1: Certificate button visibility matches progress state**
     * **Validates: Requirements 1.1, 1.2**
     * 
     * @test
     */
    public function certificate_button_visible_only_when_progress_is_100_percent(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create scheme
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            // Create user and asesi with FULL progress
            $user = User::factory()->create(['level' => 'asesi']);
            $asesi = $this->createAsesiWithProgress($user, $skema, true);

            // Visit home page as this user
            $response = $this->actingAs($user)->get('/asesi/home');

            // Verify: Page loads successfully
            $response->assertStatus(200);

            // Verify: Download button IS visible (contains the download link)
            $response->assertSee('Download Sertifikat');
            $response->assertSee(route('asesi.certificate.download'));

            // Clean up
            ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->delete();
            $asesi->delete();
            $user->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Certificate button hidden when progress is below 100%
     * 
     * For any asesi with progress < 100%, the certificate download button is NOT visible.
     * 
     * @test
     */
    public function certificate_button_hidden_when_progress_below_100_percent(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create scheme
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            // Create user and asesi with INCOMPLETE progress
            $user = User::factory()->create(['level' => 'asesi']);
            $asesi = $this->createAsesiWithProgress($user, $skema, false);

            // Visit home page as this user
            $response = $this->actingAs($user)->get('/asesi/home');

            // Verify: Page loads successfully
            $response->assertStatus(200);

            // Verify: Download button is NOT visible
            $response->assertDontSee('Download Sertifikat');

            // Clean up
            ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->delete();
            $asesi->delete();
            $user->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Progress percentage is displayed correctly
     * 
     * For any asesi, the displayed progress percentage matches the calculated progress.
     * 
     * @test
     */
    public function progress_percentage_displayed_correctly(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create scheme
            $skema = Skema::factory()->create();
            $this->skemaConfigService->applyDefaultConfig($skema->id_skema);

            // Create user and asesi with full progress
            $user = User::factory()->create(['level' => 'asesi']);
            $asesi = $this->createAsesiWithProgress($user, $skema, true);

            // Visit home page as this user
            $response = $this->actingAs($user)->get('/asesi/home');

            // Verify: Page loads successfully
            $response->assertStatus(200);

            // Verify: 100% is displayed
            $response->assertSee('100%');

            // Clean up
            ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->delete();
            $asesi->delete();
            $user->delete();
            SkemaAssessmentConfig::where('id_skema', $skema->id_skema)->delete();
            $skema->delete();
        }
    }
}
