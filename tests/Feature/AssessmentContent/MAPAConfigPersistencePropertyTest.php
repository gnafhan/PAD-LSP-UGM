<?php

namespace Tests\Feature\AssessmentContent;

use App\Models\MAPA01Config;
use App\Models\MAPA02Config;
use App\Models\Skema;
use App\Services\SchemeContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Property Test: MAPA Config Persistence
 * 
 * Property 8: For any MAPA01 or MAPA02 configuration saved, the configuration
 * SHALL be retrievable and match the saved values.
 * 
 * Validates: Requirements 4.2, 5.2, 5.3
 */
class MAPAConfigPersistencePropertyTest extends TestCase
{
    use RefreshDatabase;

    protected SchemeContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SchemeContentService();
    }

    /**
     * Property: MAPA01 config is persisted and retrievable.
     */
    public function test_mapa01_config_is_persisted_and_retrievable(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();
            
            $config = [
                'pendekatan_asesmen' => [
                    'observasi' => fake()->boolean(),
                    'demonstrasi' => fake()->boolean(),
                    'pertanyaan_lisan' => fake()->boolean(),
                    'pertanyaan_tertulis' => fake()->boolean(),
                    'verifikasi_portofolio' => fake()->boolean(),
                ],
                'tempat_asesmen' => fake()->randomElement(['TUK', 'Tempat Kerja', 'Kombinasi']),
                'waktu_asesmen' => fake()->date(),
            ];

            // Save config
            $this->service->saveMAPA01Config($scheme->id_skema, $config);

            // Retrieve config
            $retrieved = $this->service->getMAPA01Config($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($config, $retrieved->config_data,
                "MAPA01 config should be preserved exactly");
        }
    }

    /**
     * Property: MAPA01 config update replaces previous config.
     */
    public function test_mapa01_config_update_replaces_previous(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $scheme = Skema::factory()->create();

            // Save initial config
            $initialConfig = ['key1' => 'value1', 'key2' => fake()->word()];
            $this->service->saveMAPA01Config($scheme->id_skema, $initialConfig);

            // Update with new config
            $newConfig = ['key3' => 'value3', 'key4' => fake()->word()];
            $this->service->saveMAPA01Config($scheme->id_skema, $newConfig);

            // Retrieve config
            $retrieved = $this->service->getMAPA01Config($scheme->id_skema);

            $this->assertEquals($newConfig, $retrieved->config_data);
            $this->assertArrayNotHasKey('key1', $retrieved->config_data);
        }
    }

    /**
     * Property: Only one MAPA01 config exists per scheme.
     */
    public function test_only_one_mapa01_config_per_scheme(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $scheme = Skema::factory()->create();

            // Save multiple times
            $saveCount = fake()->numberBetween(2, 5);
            for ($j = 0; $j < $saveCount; $j++) {
                $this->service->saveMAPA01Config($scheme->id_skema, ['iteration' => $j]);
            }

            // Count configs
            $configCount = MAPA01Config::forSkema($scheme->id_skema)->count();

            $this->assertEquals(1, $configCount,
                "Only one MAPA01 config should exist per scheme");
        }
    }

    /**
     * Property: MAPA02 config with MUK items is persisted.
     */
    public function test_mapa02_config_with_muk_items_is_persisted(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();

            $mukItems = [];
            $itemCount = fake()->numberBetween(3, 8);
            for ($j = 0; $j < $itemCount; $j++) {
                $mukItems[] = [
                    'code' => 'MUK-' . str_pad($j + 1, 2, '0', STR_PAD_LEFT),
                    'name' => fake()->words(3, true),
                    'enabled' => fake()->boolean(),
                ];
            }

            $config = ['muk_items' => $mukItems];

            // Save config
            $this->service->saveMAPA02Config($scheme->id_skema, $config);

            // Retrieve config
            $retrieved = $this->service->getMAPA02Config($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($mukItems, $retrieved->muk_items,
                "MAPA02 MUK items should be preserved exactly");
        }
    }

    /**
     * Property: MAPA02 config with default potensi is persisted.
     */
    public function test_mapa02_config_with_default_potensi_is_persisted(): void
    {
        for ($i = 0; $i < 20; $i++) {
            $scheme = Skema::factory()->create();

            $defaultPotensi = [];
            $ukCount = fake()->numberBetween(2, 5);
            for ($j = 0; $j < $ukCount; $j++) {
                $ukId = 'UK' . date('Y') . str_pad($j + 1, 5, '0', STR_PAD_LEFT);
                $defaultPotensi[$ukId] = fake()->randomElement(['K', 'BK', 'T']);
            }

            $config = ['default_potensi' => $defaultPotensi];

            // Save config
            $this->service->saveMAPA02Config($scheme->id_skema, $config);

            // Retrieve config
            $retrieved = $this->service->getMAPA02Config($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($defaultPotensi, $retrieved->default_potensi,
                "MAPA02 default potensi should be preserved exactly");
        }
    }

    /**
     * Property: MAPA02 config with both MUK items and default potensi is persisted.
     */
    public function test_mapa02_config_with_both_fields_is_persisted(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $scheme = Skema::factory()->create();

            $mukItems = [
                ['code' => 'MUK-01', 'name' => 'Item 1', 'enabled' => true],
                ['code' => 'MUK-02', 'name' => 'Item 2', 'enabled' => false],
            ];

            $defaultPotensi = [
                'UK202500001' => 'K',
                'UK202500002' => 'BK',
            ];

            $config = [
                'muk_items' => $mukItems,
                'default_potensi' => $defaultPotensi,
            ];

            // Save config
            $this->service->saveMAPA02Config($scheme->id_skema, $config);

            // Retrieve config
            $retrieved = $this->service->getMAPA02Config($scheme->id_skema);

            $this->assertNotNull($retrieved);
            $this->assertEquals($mukItems, $retrieved->muk_items);
            $this->assertEquals($defaultPotensi, $retrieved->default_potensi);
        }
    }

    /**
     * Property: MAPA02 config update replaces previous config.
     */
    public function test_mapa02_config_update_replaces_previous(): void
    {
        $scheme = Skema::factory()->create();

        // Save initial config
        $initialConfig = [
            'muk_items' => [['code' => 'OLD', 'enabled' => true]],
            'default_potensi' => ['UK1' => 'K'],
        ];
        $this->service->saveMAPA02Config($scheme->id_skema, $initialConfig);

        // Update with new config
        $newConfig = [
            'muk_items' => [['code' => 'NEW', 'enabled' => false]],
            'default_potensi' => ['UK2' => 'BK'],
        ];
        $this->service->saveMAPA02Config($scheme->id_skema, $newConfig);

        // Retrieve config
        $retrieved = $this->service->getMAPA02Config($scheme->id_skema);

        $this->assertEquals($newConfig['muk_items'], $retrieved->muk_items);
        $this->assertEquals($newConfig['default_potensi'], $retrieved->default_potensi);
    }

    /**
     * Property: Only one MAPA02 config exists per scheme.
     */
    public function test_only_one_mapa02_config_per_scheme(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $scheme = Skema::factory()->create();

            // Save multiple times
            $saveCount = fake()->numberBetween(2, 5);
            for ($j = 0; $j < $saveCount; $j++) {
                $this->service->saveMAPA02Config($scheme->id_skema, [
                    'muk_items' => [['iteration' => $j]],
                ]);
            }

            // Count configs
            $configCount = MAPA02Config::forSkema($scheme->id_skema)->count();

            $this->assertEquals(1, $configCount,
                "Only one MAPA02 config should exist per scheme");
        }
    }

    /**
     * Property: Empty config is handled correctly.
     */
    public function test_empty_config_is_handled(): void
    {
        $scheme = Skema::factory()->create();

        // Save empty config
        $this->service->saveMAPA01Config($scheme->id_skema, []);
        $this->service->saveMAPA02Config($scheme->id_skema, []);

        // Retrieve configs
        $mapa01 = $this->service->getMAPA01Config($scheme->id_skema);
        $mapa02 = $this->service->getMAPA02Config($scheme->id_skema);

        $this->assertNotNull($mapa01);
        $this->assertEquals([], $mapa01->config_data);

        $this->assertNotNull($mapa02);
        $this->assertNull($mapa02->muk_items);
        $this->assertNull($mapa02->default_potensi);
    }

    /**
     * Property: MAPA02 helper methods work correctly.
     */
    public function test_mapa02_helper_methods_work_correctly(): void
    {
        $scheme = Skema::factory()->create();

        $config = [
            'muk_items' => [
                ['code' => 'MUK-01', 'name' => 'Item 1', 'enabled' => true],
                ['code' => 'MUK-02', 'name' => 'Item 2', 'enabled' => false],
                ['code' => 'MUK-03', 'name' => 'Item 3', 'enabled' => true],
            ],
            'default_potensi' => [
                'UK1' => 'K',
                'UK2' => 'BK',
            ],
        ];

        $this->service->saveMAPA02Config($scheme->id_skema, $config);
        $retrieved = $this->service->getMAPA02Config($scheme->id_skema);

        // Test getEnabledMukItems
        $enabledItems = $retrieved->getEnabledMukItems();
        $this->assertCount(2, $enabledItems);

        // Test isMukItemEnabled
        $this->assertTrue($retrieved->isMukItemEnabled('MUK-01'));
        $this->assertFalse($retrieved->isMukItemEnabled('MUK-02'));
        $this->assertTrue($retrieved->isMukItemEnabled('MUK-03'));
        $this->assertTrue($retrieved->isMukItemEnabled('MUK-99')); // Not found defaults to true

        // Test getDefaultPotensi
        $this->assertEquals('K', $retrieved->getDefaultPotensi('UK1'));
        $this->assertEquals('BK', $retrieved->getDefaultPotensi('UK2'));
        $this->assertNull($retrieved->getDefaultPotensi('UK99')); // Not found
    }
}
