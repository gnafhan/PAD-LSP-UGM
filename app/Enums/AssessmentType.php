<?php

namespace App\Enums;

/**
 * AssessmentType Enum Class
 * 
 * Defines all assessment type constants used in the dynamic assessment flow.
 * APL types (APL01, APL02) are mandatory for all schemes and cannot be disabled.
 * 
 * Requirements: 1.3
 */
class AssessmentType
{
    // APL - Always Required (Mandatory)
    public const APL01 = 'APL01';
    public const APL02 = 'APL02';

    // AK - Configurable
    public const AK01 = 'AK01';
    public const AK02 = 'AK02';
    public const AK04 = 'AK04';
    public const AK07 = 'AK07';

    // IA - Configurable
    public const IA01 = 'IA01';
    public const IA02 = 'IA02';
    public const IA05 = 'IA05';
    public const IA07 = 'IA07';
    public const IA11 = 'IA11';

    // MAPA - Configurable
    public const MAPA01 = 'MAPA01';
    public const MAPA02 = 'MAPA02';

    // Others - Configurable
    public const KONSUL_PRA_UJI = 'KONSUL_PRA_UJI';
    public const KETIDAKBERPIHAKAN = 'KETIDAKBERPIHAKAN';
    public const TUGAS_PESERTA = 'TUGAS_PESERTA';

    /**
     * Get all mandatory assessment types that cannot be disabled.
     * APL tools are required for all certification schemes.
     *
     * @return array<string>
     */
    public static function getMandatoryTypes(): array
    {
        return [
            self::APL01,
            self::APL02,
        ];
    }

    /**
     * Get all configurable (non-mandatory) assessment types.
     * These can be enabled or disabled per scheme.
     *
     * @return array<string>
     */
    public static function getConfigurableTypes(): array
    {
        return [
            // AK types
            self::AK01,
            self::AK02,
            self::AK04,
            self::AK07,
            // IA types
            self::IA01,
            self::IA02,
            self::IA05,
            self::IA07,
            self::IA11,
            // MAPA types
            self::MAPA01,
            self::MAPA02,
            // Others
            self::KONSUL_PRA_UJI,
            self::KETIDAKBERPIHAKAN,
            self::TUGAS_PESERTA,
        ];
    }

    /**
     * Get all assessment types (mandatory + configurable).
     *
     * @return array<string>
     */
    public static function getAllTypes(): array
    {
        return array_merge(
            self::getMandatoryTypes(),
            self::getConfigurableTypes()
        );
    }

    /**
     * Check if a given type is mandatory.
     *
     * @param string $type
     * @return bool
     */
    public static function isMandatory(string $type): bool
    {
        return in_array($type, self::getMandatoryTypes(), true);
    }

    /**
     * Check if a given type is configurable.
     *
     * @param string $type
     * @return bool
     */
    public static function isConfigurable(string $type): bool
    {
        return in_array($type, self::getConfigurableTypes(), true);
    }

    /**
     * Check if a given type is valid (exists in the system).
     *
     * @param string $type
     * @return bool
     */
    public static function isValid(string $type): bool
    {
        return in_array($type, self::getAllTypes(), true);
    }
}
