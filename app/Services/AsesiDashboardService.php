<?php

namespace App\Services;

use App\Enums\AssessmentType;
use App\Models\Asesi;
use Illuminate\Support\Collection;

/**
 * AsesiDashboardService
 * 
 * Service for managing Asesi dashboard display based on scheme configuration.
 * Filters assessment tools to show only those enabled for the asesi's scheme.
 * APL items are always included as they are mandatory.
 * 
 * Requirements: 5.1, 5.2, 5.3
 */
class AsesiDashboardService
{
    private SkemaConfigService $skemaConfigService;

    /**
     * Assessment items organized by section for Asesi dashboard.
     * Maps assessment types to their display information.
     */
    private const ASSESSMENT_SECTIONS = [
        'formulir_pendaftaran' => [
            'title' => 'Formulir Pendaftaran',
            'items' => [
                'ak01' => [
                    'assessment_type' => 'AK01',
                    'label' => 'Formulir AK.01',
                    'description' => 'Formulir Permohonan Sertifikasi',
                    'route_name' => 'asesi.fr.ak1',
                ],
                'apl01' => [
                    'assessment_type' => 'APL01',
                    'label' => 'Formulir APL.01',
                    'description' => 'Permohonan Sertifikasi Kompetensi',
                    'route_name' => 'asesi.apl1-detail',
                    'is_mandatory' => true,
                ],
                'apl02' => [
                    'assessment_type' => 'APL02',
                    'label' => 'Formulir APL.02',
                    'description' => 'Asesmen Mandiri',
                    'route_name' => 'asesi.asesmen.mandiri',
                    'is_mandatory' => true,
                ],
            ],
        ],
        'formulir_prauji' => [
            'title' => 'Formulir Prauji',
            'items' => [
                'konsultasi_pra_uji' => [
                    'assessment_type' => 'KONSUL_PRA_UJI',
                    'label' => 'Konsultasi Prauji',
                    'description' => 'Diskusi dengan asesor sebelum asesmen',
                    'route_name' => 'asesi.konsul-prauji',
                ],
                'ia02' => [
                    'assessment_type' => 'IA02',
                    'label' => 'Formulir IA.02',
                    'description' => 'Tugas Praktik & Observasi',
                    'route_name' => 'asesi.fr.ia2.detail',
                    'requires_rincian_id' => true,
                ],
                'tugas_peserta' => [
                    'assessment_type' => 'TUGAS_PESERTA',
                    'label' => 'Tugas Peserta',
                    'description' => 'Tugas Peserta',
                    'route_name' => 'asesi.fr.ia2.soal',
                    'requires_rincian_id' => true,
                ],
                'ia05' => [
                    'assessment_type' => 'IA05',
                    'label' => 'Formulir IA.05',
                    'description' => 'Pertanyaan Tertulis Pilihan Ganda',
                    'route_name' => 'asesi.fr.ia05',
                ],
            ],
        ],
        'pasca_uji' => [
            'title' => 'Pasca Uji',
            'items' => [
                'umpan_balik' => [
                    'assessment_type' => null, // Not a configurable assessment type
                    'label' => 'Umpan Balik',
                    'description' => 'Umpan balik dari peserta',
                    'route_name' => 'asesi.fr.ak3',
                    'always_visible' => true,
                ],
                'ak04' => [
                    'assessment_type' => 'AK04',
                    'label' => 'Formulir AK.04',
                    'description' => 'Keputusan dan Umpan Balik Asesmen',
                    'route_name' => 'asesi.frak04',
                ],
            ],
        ],
    ];

    public function __construct(SkemaConfigService $skemaConfigService)
    {
        $this->skemaConfigService = $skemaConfigService;
    }

    /**
     * Get filtered assessment sections for an asesi based on their scheme configuration.
     * Only returns assessments that are enabled for the asesi's scheme.
     * APL items are always included as they are mandatory.
     * 
     * Requirements: 5.1
     *
     * @param Asesi $asesi The asesi model
     * @return array Array of assessment sections with filtered items
     */
    public function getFilteredAssessmentSections(Asesi $asesi): array
    {
        $idSkema = $asesi->id_skema;
        
        // If no scheme, return all items (backward compatibility)
        if (!$idSkema) {
            return $this->getAllAssessmentSections();
        }

        // Get enabled assessments for the scheme
        $enabledAssessments = $this->skemaConfigService->getEnabledAssessments($idSkema);

        $filteredSections = [];

        foreach (self::ASSESSMENT_SECTIONS as $sectionKey => $section) {
            $filteredItems = [];

            foreach ($section['items'] as $itemKey => $itemConfig) {
                $assessmentType = $itemConfig['assessment_type'] ?? null;
                $isMandatory = $itemConfig['is_mandatory'] ?? false;
                $alwaysVisible = $itemConfig['always_visible'] ?? false;

                // Determine if item should be shown
                $shouldShow = false;

                if ($alwaysVisible) {
                    // Items marked as always_visible are always shown
                    $shouldShow = true;
                } elseif ($isMandatory) {
                    // Mandatory items (APL) are always shown
                    $shouldShow = true;
                } elseif ($assessmentType === null) {
                    // Items without assessment type are always shown
                    $shouldShow = true;
                } elseif ($enabledAssessments->contains($assessmentType)) {
                    // Item is enabled in scheme config
                    $shouldShow = true;
                }

                if ($shouldShow) {
                    $filteredItems[$itemKey] = array_merge($itemConfig, [
                        'is_enabled' => true,
                        'field_name' => $itemKey,
                    ]);
                }
            }

            // Only include section if it has items
            if (!empty($filteredItems)) {
                $filteredSections[$sectionKey] = [
                    'title' => $section['title'],
                    'items' => $filteredItems,
                ];
            }
        }

        return $filteredSections;
    }

    /**
     * Get all assessment sections without filtering.
     * Used for backward compatibility when no scheme is configured.
     *
     * @return array Array of all assessment sections
     */
    public function getAllAssessmentSections(): array
    {
        $sections = [];

        foreach (self::ASSESSMENT_SECTIONS as $sectionKey => $section) {
            $items = [];
            foreach ($section['items'] as $itemKey => $itemConfig) {
                $items[$itemKey] = array_merge($itemConfig, [
                    'is_enabled' => true,
                    'field_name' => $itemKey,
                ]);
            }

            $sections[$sectionKey] = [
                'title' => $section['title'],
                'items' => $items,
            ];
        }

        return $sections;
    }

    /**
     * Check if a specific assessment is enabled for an asesi's scheme.
     * APL types always return true as they are mandatory.
     * 
     * Requirements: 5.3
     *
     * @param Asesi $asesi The asesi model
     * @param string $assessmentType The assessment type to check
     * @return bool Whether the assessment is enabled
     */
    public function isAssessmentEnabledForAsesi(Asesi $asesi, string $assessmentType): bool
    {
        // APL types are always enabled (mandatory)
        if (AssessmentType::isMandatory($assessmentType)) {
            return true;
        }

        $idSkema = $asesi->id_skema;
        
        // If no scheme, default to enabled (backward compatibility)
        if (!$idSkema) {
            return true;
        }

        return $this->skemaConfigService->isAssessmentEnabled($idSkema, $assessmentType);
    }

    /**
     * Get the list of enabled assessment types for an asesi's scheme.
     * 
     * @param Asesi $asesi The asesi model
     * @return Collection Collection of enabled assessment type strings
     */
    public function getEnabledAssessmentTypes(Asesi $asesi): Collection
    {
        $idSkema = $asesi->id_skema;
        
        // If no scheme, return all types (backward compatibility)
        if (!$idSkema) {
            return collect(AssessmentType::getAllTypes());
        }

        return $this->skemaConfigService->getEnabledAssessments($idSkema);
    }

    /**
     * Get the field name to assessment type mapping.
     * Useful for checking if a progress field is enabled.
     *
     * @return array Mapping of field names to assessment types
     */
    public function getFieldToAssessmentTypeMap(): array
    {
        $map = [];
        foreach (self::ASSESSMENT_SECTIONS as $section) {
            foreach ($section['items'] as $fieldName => $config) {
                if (isset($config['assessment_type']) && $config['assessment_type'] !== null) {
                    $map[$fieldName] = $config['assessment_type'];
                }
            }
        }
        return $map;
    }

    /**
     * Check if a progress field is enabled for an asesi's scheme.
     * 
     * @param Asesi $asesi The asesi model
     * @param string $fieldName The progress field name (e.g., 'apl01', 'ak01')
     * @return bool Whether the field's assessment is enabled
     */
    public function isFieldEnabledForAsesi(Asesi $asesi, string $fieldName): bool
    {
        $fieldMap = $this->getFieldToAssessmentTypeMap();
        
        // If field is not in map, it's always enabled (e.g., hasil_asesmen)
        if (!isset($fieldMap[$fieldName])) {
            return true;
        }

        return $this->isAssessmentEnabledForAsesi($asesi, $fieldMap[$fieldName]);
    }
}
