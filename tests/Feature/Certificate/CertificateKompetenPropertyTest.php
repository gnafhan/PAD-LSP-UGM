<?php

namespace Tests\Feature\Certificate;

use App\Models\Asesi;
use App\Models\Skema;
use App\Services\CertificateService;
use App\Services\ProgressTrackingService;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for Certificate KOMPETEN Text
 * 
 * **Feature: certificate-generation, Property 4: Certificate contains KOMPETEN text**
 * **Validates: Requirements 2.6**
 */
class CertificateKompetenPropertyTest extends TestCase
{
    use RefreshDatabase;

    private CertificateService $certificateService;

    protected function setUp(): void
    {
        parent::setUp();
        $skemaConfigService = new SkemaConfigService();
        $progressTrackingService = new ProgressTrackingService($skemaConfigService);
        $this->certificateService = new CertificateService($progressTrackingService);
    }

    /**
     * Property 4: Certificate contains KOMPETEN text
     * 
     * For any generated certificate, the certificate data contains the text "KOMPETEN".
     * 
     * **Feature: certificate-generation, Property 4: Certificate contains KOMPETEN text**
     * **Validates: Requirements 2.6**
     * 
     * @test
     */
    public function certificate_data_always_contains_kompeten_status(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme with random data
            $skema = Skema::factory()->create([
                'nama_skema' => fake()->sentence(3),
                'nomor_skema' => 'SKM-' . fake()->unique()->numerify('####')
            ]);

            // Create asesi with random data
            $asesi = Asesi::factory()->forSkema($skema)->create([
                'nama_asesi' => fake()->name()
            ]);

            // Get certificate data
            $certificateData = $this->certificateService->getCertificateData($asesi);

            // Verify: Status field exists and equals "KOMPETEN"
            $this->assertArrayHasKey(
                'status',
                $certificateData,
                "Certificate data should have 'status' field"
            );

            $this->assertEquals(
                'KOMPETEN',
                $certificateData['status'],
                "Certificate status should always be 'KOMPETEN'"
            );

            // Verify: Status is exactly "KOMPETEN" (case-sensitive)
            $this->assertSame(
                'KOMPETEN',
                $certificateData['status'],
                "Certificate status should be exactly 'KOMPETEN' (case-sensitive)"
            );

            // Clean up
            $asesi->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Certificate template renders KOMPETEN text
     * 
     * For any certificate, the rendered view contains the KOMPETEN text.
     * 
     * @test
     */
    public function certificate_template_renders_kompeten_text(): void
    {
        for ($i = 0; $i < 10; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Get certificate data
            $certificateData = $this->certificateService->getCertificateData($asesi);

            // Render the view
            $renderedView = view('certificates.certificate-template', $certificateData)->render();

            // Verify: Rendered view contains "KOMPETEN"
            $this->assertStringContainsString(
                'KOMPETEN',
                $renderedView,
                "Rendered certificate should contain 'KOMPETEN' text"
            );

            // Verify: Rendered view contains the status badge with KOMPETEN
            $this->assertStringContainsString(
                'status-badge',
                $renderedView,
                "Rendered certificate should have status badge element"
            );

            // Clean up
            $asesi->delete();
            $skema->delete();
        }
    }
}
