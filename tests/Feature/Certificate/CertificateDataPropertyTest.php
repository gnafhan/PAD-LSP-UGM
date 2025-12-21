<?php

namespace Tests\Feature\Certificate;

use App\Models\Asesi;
use App\Models\ProgresAsesmen;
use App\Models\Skema;
use App\Models\SkemaAssessmentConfig;
use App\Services\CertificateService;
use App\Services\ProgressTrackingService;
use App\Services\SkemaConfigService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property-Based Tests for Certificate Data
 * 
 * **Feature: certificate-generation, Property 2: Certificate contains asesi name**
 * **Feature: certificate-generation, Property 3: Certificate contains skema name**
 * **Validates: Requirements 2.2, 2.4**
 */
class CertificateDataPropertyTest extends TestCase
{
    use RefreshDatabase;

    private CertificateService $certificateService;
    private SkemaConfigService $skemaConfigService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->skemaConfigService = new SkemaConfigService();
        $progressTrackingService = new ProgressTrackingService($this->skemaConfigService);
        $this->certificateService = new CertificateService($progressTrackingService);
    }

    /**
     * Property 2: Certificate contains asesi name
     * 
     * For any asesi with 100% progress, the generated certificate data contains
     * the asesi's full name.
     * 
     * **Feature: certificate-generation, Property 2: Certificate contains asesi name**
     * **Validates: Requirements 2.2**
     * 
     * @test
     */
    public function certificate_data_contains_asesi_name(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();

            // Create asesi with random name
            $randomName = fake()->name();
            $asesi = Asesi::factory()->forSkema($skema)->create([
                'nama_asesi' => $randomName
            ]);

            // Get certificate data
            $certificateData = $this->certificateService->getCertificateData($asesi);

            // Verify: Certificate data contains the asesi's name
            $this->assertArrayHasKey('nama_asesi', $certificateData);
            $this->assertEquals(
                $randomName,
                $certificateData['nama_asesi'],
                "Certificate data should contain the asesi's full name"
            );

            // Clean up
            $asesi->delete();
            $skema->delete();
        }
    }

    /**
     * Property 3: Certificate contains skema name
     * 
     * For any asesi with 100% progress, the generated certificate data contains
     * the skema name that the asesi completed.
     * 
     * **Feature: certificate-generation, Property 3: Certificate contains skema name**
     * **Validates: Requirements 2.4**
     * 
     * @test
     */
    public function certificate_data_contains_skema_name(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme with random name
            $randomSkemaName = fake()->sentence(3);
            $skema = Skema::factory()->create([
                'nama_skema' => $randomSkemaName
            ]);

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Get certificate data
            $certificateData = $this->certificateService->getCertificateData($asesi);

            // Verify: Certificate data contains the skema name
            $this->assertArrayHasKey('nama_skema', $certificateData);
            $this->assertEquals(
                $randomSkemaName,
                $certificateData['nama_skema'],
                "Certificate data should contain the skema name"
            );

            // Verify: Certificate data also contains nomor_skema
            $this->assertArrayHasKey('nomor_skema', $certificateData);
            $this->assertEquals(
                $skema->nomor_skema,
                $certificateData['nomor_skema'],
                "Certificate data should contain the skema number"
            );

            // Clean up
            $asesi->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Certificate data contains all required fields
     * 
     * For any asesi, getCertificateData returns all required fields.
     * 
     * @test
     */
    public function certificate_data_contains_all_required_fields(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Get certificate data
            $certificateData = $this->certificateService->getCertificateData($asesi);

            // Verify: All required fields are present
            $requiredFields = [
                'nama_asesi',
                'tanggal',
                'tanggal_raw',
                'nama_skema',
                'nomor_skema',
                'nomor_sertifikat',
                'status',
                'id_asesi'
            ];

            foreach ($requiredFields as $field) {
                $this->assertArrayHasKey(
                    $field,
                    $certificateData,
                    "Certificate data should contain field: {$field}"
                );
            }

            // Verify: Status is always "KOMPETEN"
            $this->assertEquals(
                'KOMPETEN',
                $certificateData['status'],
                "Certificate status should always be 'KOMPETEN'"
            );

            // Verify: Certificate number follows expected format
            $this->assertStringContainsString(
                'CERT/LSP-UGM/',
                $certificateData['nomor_sertifikat'],
                "Certificate number should follow the expected format"
            );

            // Verify: Certificate number contains asesi ID
            $this->assertStringContainsString(
                $asesi->id_asesi,
                $certificateData['nomor_sertifikat'],
                "Certificate number should contain asesi ID"
            );

            // Clean up
            $asesi->delete();
            $skema->delete();
        }
    }

    /**
     * Property: Certificate date is in Indonesian format
     * 
     * For any certificate, the date should be in Indonesian format (e.g., "21 Desember 2025").
     * 
     * @test
     */
    public function certificate_date_is_in_indonesian_format(): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create a scheme
            $skema = Skema::factory()->create();

            // Create asesi
            $asesi = Asesi::factory()->forSkema($skema)->create();

            // Get certificate data
            $certificateData = $this->certificateService->getCertificateData($asesi);

            // Verify: Date is present
            $this->assertArrayHasKey('tanggal', $certificateData);
            $this->assertNotEmpty($certificateData['tanggal']);

            // Verify: Date contains Indonesian month name
            $indonesianMonths = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            $containsIndonesianMonth = false;
            foreach ($indonesianMonths as $month) {
                if (str_contains($certificateData['tanggal'], $month)) {
                    $containsIndonesianMonth = true;
                    break;
                }
            }

            $this->assertTrue(
                $containsIndonesianMonth,
                "Certificate date '{$certificateData['tanggal']}' should contain Indonesian month name"
            );

            // Verify: Date contains year
            $currentYear = date('Y');
            $this->assertStringContainsString(
                $currentYear,
                $certificateData['tanggal'],
                "Certificate date should contain the current year"
            );

            // Clean up
            $asesi->delete();
            $skema->delete();
        }
    }
}
