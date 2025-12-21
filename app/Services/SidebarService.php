<?php

namespace App\Services;

use App\Enums\AssessmentType;
use Illuminate\Support\Collection;

/**
 * SidebarService
 * 
 * Service for generating dynamic sidebar menu items based on scheme configuration.
 * Returns menu items filtered by enabled assessments for a given scheme.
 * APL items are always included regardless of configuration.
 * 
 * Requirements: 6.1, 6.2, 6.3, 6.4
 */
class SidebarService
{
    private SkemaConfigService $skemaConfigService;

    /**
     * Mandatory menu items that should always be shown in sidebar.
     * Note: APL01 is an asesi form, not shown in asesor sidebar.
     * APL02 is the only mandatory item in asesor sidebar.
     */
    private const MANDATORY_SIDEBAR_ITEMS = ['APL02'];

    /**
     * Menu item definitions organized by section.
     * Maps assessment types to their display information.
     */
    private const MENU_SECTIONS = [
        'pelaksanaan_asesmen' => [
            'title' => 'Pelaksanaan Asesmen',
            'items' => [
                'APL02' => [
                    'route' => 'frapl02-asesor',
                    'label' => 'FR.APL.02',
                    'icon' => 'document-edit',
                    'is_mandatory_sidebar' => true, // APL02 is mandatory in sidebar
                ],
                'AK01' => [
                    'route' => 'frak01-asesor',
                    'label' => 'FR.AK.01',
                    'icon' => 'document-edit',
                ],
                'KONSUL_PRA_UJI' => [
                    'route' => 'konsul-prauji-asesor',
                    'label' => 'Konsul Pra Uji',
                    'icon' => 'consultation',
                ],
                'MAPA01' => [
                    'route' => 'frmapa01-asesor',
                    'label' => 'FR.MAPA.01',
                    'icon' => 'document-edit',
                ],
                'MAPA02' => [
                    'route' => 'frmapa02-asesor',
                    'label' => 'FR.MAPA.02',
                    'icon' => 'document-edit',
                ],
                'KETIDAKBERPIHAKAN' => [
                    'route' => 'ketidakberpihakan-asesor',
                    'label' => 'Pernyataan Ketidakberpihakan',
                    'icon' => 'impartiality',
                ],
            ],
        ],
        'perangkat_asesmen' => [
            'title' => 'Perangkat Asesmen',
            'items' => [
                'AK07' => [
                    'route' => 'frak07-asesor',
                    'label' => 'FR.AK.07',
                    'icon' => 'document-edit',
                ],
                'IA01' => [
                    'route' => 'fria01-asesor',
                    'label' => 'FR.IA.01',
                    'icon' => 'document-edit',
                ],
                'IA02' => [
                    'route' => 'fria02-asesor',
                    'label' => 'FR.IA.02',
                    'icon' => 'document-edit',
                ],
                'IA05' => [
                    'route' => 'fria05-asesor',
                    'label' => 'FR.IA.05',
                    'icon' => 'document-edit',
                ],
                'IA07' => [
                    'route' => 'fria07-asesor',
                    'label' => 'FR.IA.07',
                    'icon' => 'document-edit',
                ],
                'TUGAS_PESERTA' => [
                    'route' => 'tugas-peserta',
                    'label' => 'Tugas Peserta',
                    'icon' => 'task',
                ],
                'IA11' => [
                    'route' => 'fria11-asesor',
                    'label' => 'FR.IA.11',
                    'icon' => 'document-edit',
                ],
            ],
        ],
        'keputusan_asesmen' => [
            'title' => 'Keputusan Asesmen',
            'items' => [
                'HASIL_ASESMEN' => [
                    'route' => 'hasil-asesmen-asesor',
                    'label' => 'Hasil Asesmen',
                    'icon' => 'result',
                ],
                'AK02' => [
                    'route' => 'frak02-asesor',
                    'label' => 'FR.AK.02',
                    'icon' => 'document-edit',
                ],
                'AK04' => [
                    'route' => 'frak04-asesor',
                    'label' => 'FR.AK.04',
                    'icon' => 'document-edit',
                ],
            ],
        ],
    ];

    public function __construct(SkemaConfigService $skemaConfigService)
    {
        $this->skemaConfigService = $skemaConfigService;
    }

    /**
     * Get menu items for a specific scheme based on enabled assessments.
     * Always includes mandatory sidebar items (APL02) regardless of configuration.
     * 
     * Requirements: 6.1, 6.2, 6.3
     *
     * @param string $idSkema The scheme ID
     * @return array Array of menu sections with filtered items
     */
    public function getMenuItemsForScheme(string $idSkema): array
    {
        // Get enabled assessments for the scheme
        $enabledAssessments = $this->skemaConfigService->getEnabledAssessments($idSkema);

        $menuSections = [];

        foreach (self::MENU_SECTIONS as $sectionKey => $section) {
            $filteredItems = [];

            foreach ($section['items'] as $assessmentType => $itemConfig) {
                // Check if this is a mandatory sidebar item (APL02)
                $isMandatorySidebar = in_array($assessmentType, self::MANDATORY_SIDEBAR_ITEMS, true);
                
                // Check if assessment is enabled in scheme config
                $isEnabled = $enabledAssessments->contains($assessmentType);
                
                // Special handling for non-assessment menu items (like HASIL_ASESMEN)
                // These are always shown as they are not configurable assessment types
                $isNonAssessmentItem = !AssessmentType::isValid($assessmentType);
                
                // Show item if: mandatory sidebar item, enabled in config, or non-assessment item
                if ($isMandatorySidebar || $isEnabled || $isNonAssessmentItem) {
                    $filteredItems[$assessmentType] = array_merge($itemConfig, [
                        'assessment_type' => $assessmentType,
                        'is_mandatory' => $isMandatorySidebar,
                        'is_enabled' => $isEnabled || $isMandatorySidebar || $isNonAssessmentItem,
                    ]);
                }
            }

            // Only include section if it has items
            if (!empty($filteredItems)) {
                $menuSections[$sectionKey] = [
                    'title' => $section['title'],
                    'items' => $filteredItems,
                ];
            }
        }

        return $menuSections;
    }

    /**
     * Get all menu items without filtering (for admin or when no scheme is selected).
     * 
     * @return array Array of all menu sections with all items
     */
    public function getAllMenuItems(): array
    {
        $menuSections = [];

        foreach (self::MENU_SECTIONS as $sectionKey => $section) {
            $items = [];
            foreach ($section['items'] as $assessmentType => $itemConfig) {
                $isMandatory = AssessmentType::isMandatory($assessmentType);
                $items[$assessmentType] = array_merge($itemConfig, [
                    'assessment_type' => $assessmentType,
                    'is_mandatory' => $isMandatory,
                    'is_enabled' => true,
                ]);
            }

            $menuSections[$sectionKey] = [
                'title' => $section['title'],
                'items' => $items,
            ];
        }

        return $menuSections;
    }

    /**
     * Check if a specific menu item should be visible for a scheme.
     * 
     * @param string $idSkema The scheme ID
     * @param string $assessmentType The assessment type to check
     * @return bool Whether the menu item should be visible
     */
    public function isMenuItemVisible(string $idSkema, string $assessmentType): bool
    {
        // Mandatory sidebar items (APL02) are always visible
        if (in_array($assessmentType, self::MANDATORY_SIDEBAR_ITEMS, true)) {
            return true;
        }

        // Non-assessment items (like HASIL_ASESMEN) are always visible
        if (!AssessmentType::isValid($assessmentType)) {
            return true;
        }

        // Check if enabled for the scheme
        return $this->skemaConfigService->isAssessmentEnabled($idSkema, $assessmentType);
    }

    /**
     * Get the mandatory sidebar items.
     * 
     * @return array Array of mandatory sidebar item assessment types
     */
    public function getMandatorySidebarItems(): array
    {
        return self::MANDATORY_SIDEBAR_ITEMS;
    }

    /**
     * Get the flat list of enabled assessment types for a scheme.
     * Useful for quick checks in views.
     * 
     * @param string $idSkema The scheme ID
     * @return Collection Collection of enabled assessment type strings
     */
    public function getEnabledAssessmentTypes(string $idSkema): Collection
    {
        return $this->skemaConfigService->getEnabledAssessments($idSkema);
    }

    /**
     * Get menu item configuration by assessment type.
     * 
     * @param string $assessmentType The assessment type
     * @return array|null The menu item configuration or null if not found
     */
    public function getMenuItemConfig(string $assessmentType): ?array
    {
        foreach (self::MENU_SECTIONS as $section) {
            if (isset($section['items'][$assessmentType])) {
                return $section['items'][$assessmentType];
            }
        }
        return null;
    }
}
