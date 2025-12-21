<?php

namespace App\Services;

use App\Enums\AssessmentType;
use App\Models\AssessmentConfigTemplate;
use App\Models\SkemaAssessmentConfig;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * SkemaConfigService
 * 
 * Service for managing assessment configuration per certification scheme.
 * Handles enabling/disabling assessment tools while enforcing APL mandatory constraint.
 * 
 * Requirements: 1.1, 1.2, 1.3, 1.4, 5.1, 5.3, 7.1
 */
class SkemaConfigService
{
    /**
     * Get all enabled assessments for a scheme.
     * Always includes mandatory APL types regardless of configuration.
     * 
     * Requirements: 1.1, 5.1
     *
     * @param string $idSkema The scheme ID
     * @return Collection Collection of enabled assessment type strings
     */
    public function getEnabledAssessments(string $idSkema): Collection
    {
        // Query enabled assessments from database
        $enabledFromDb = SkemaAssessmentConfig::forSkema($idSkema)
            ->enabled()
            ->ordered()
            ->pluck('assessment_type')
            ->toArray();

        // Always include mandatory APL types
        $mandatoryTypes = AssessmentType::getMandatoryTypes();
        
        // Merge mandatory types with enabled types, ensuring no duplicates
        $allEnabled = array_unique(array_merge($mandatoryTypes, $enabledFromDb));

        return collect($allEnabled);
    }


    /**
     * Update assessment configuration for a scheme.
     * Validates that APL types cannot be disabled.
     * Creates or updates config records as needed.
     * 
     * Requirements: 1.2, 1.3, 1.4
     *
     * @param string $idSkema The scheme ID
     * @param array $config Array of assessment_type => is_enabled pairs
     * @return bool Success status
     * @throws \InvalidArgumentException If attempting to disable APL types
     */
    public function updateAssessmentConfig(string $idSkema, array $config): bool
    {
        // Validate: APL types cannot be disabled
        foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
            if (isset($config[$mandatoryType]) && $config[$mandatoryType] === false) {
                Log::warning("Attempt to disable mandatory APL type", [
                    'id_skema' => $idSkema,
                    'assessment_type' => $mandatoryType
                ]);
                throw new \InvalidArgumentException(
                    "APL tools ({$mandatoryType}) cannot be disabled. They are mandatory for all schemes."
                );
            }
        }

        // Validate: At least APL tools must be enabled
        $hasAplEnabled = false;
        foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
            if (!isset($config[$mandatoryType]) || $config[$mandatoryType] === true) {
                $hasAplEnabled = true;
                break;
            }
        }

        if (!$hasAplEnabled) {
            throw new \InvalidArgumentException(
                "At least APL tools must be enabled for the scheme."
            );
        }

        try {
            DB::beginTransaction();

            $displayOrder = 0;
            foreach ($config as $assessmentType => $isEnabled) {
                // Validate assessment type
                if (!AssessmentType::isValid($assessmentType)) {
                    Log::warning("Invalid assessment type in config", [
                        'id_skema' => $idSkema,
                        'assessment_type' => $assessmentType
                    ]);
                    continue;
                }

                // Force APL types to always be enabled
                if (AssessmentType::isMandatory($assessmentType)) {
                    $isEnabled = true;
                }

                // Update or create the config record
                SkemaAssessmentConfig::updateOrCreate(
                    [
                        'id_skema' => $idSkema,
                        'assessment_type' => $assessmentType,
                    ],
                    [
                        'is_enabled' => (bool) $isEnabled,
                        'display_order' => $displayOrder++,
                    ]
                );
            }

            // Ensure mandatory APL types exist and are enabled
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                SkemaAssessmentConfig::updateOrCreate(
                    [
                        'id_skema' => $idSkema,
                        'assessment_type' => $mandatoryType,
                    ],
                    [
                        'is_enabled' => true,
                        'display_order' => $displayOrder++,
                    ]
                );
            }

            DB::commit();

            Log::info("Assessment configuration updated", [
                'id_skema' => $idSkema,
                'config_count' => count($config)
            ]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to update assessment configuration", [
                'id_skema' => $idSkema,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }


    /**
     * Get default configuration with all assessments enabled.
     * Used when creating new schemes.
     * 
     * Requirements: 7.1
     *
     * @return array Array of assessment_type => is_enabled pairs (all true)
     */
    public function getDefaultConfig(): array
    {
        $config = [];
        
        // All assessment types enabled by default
        foreach (AssessmentType::getAllTypes() as $type) {
            $config[$type] = true;
        }

        return $config;
    }

    /**
     * Check if a specific assessment is enabled for a scheme.
     * APL types always return true as they are mandatory.
     * 
     * Requirements: 5.3
     *
     * @param string $idSkema The scheme ID
     * @param string $assessmentType The assessment type to check
     * @return bool Whether the assessment is enabled
     */
    public function isAssessmentEnabled(string $idSkema, string $assessmentType): bool
    {
        // APL types are always enabled (mandatory)
        if (AssessmentType::isMandatory($assessmentType)) {
            return true;
        }

        // Check if the assessment type is valid
        if (!AssessmentType::isValid($assessmentType)) {
            return false;
        }

        // Query the database for the specific config
        $config = SkemaAssessmentConfig::forSkema($idSkema)
            ->where('assessment_type', $assessmentType)
            ->first();

        // If no config exists, check if scheme has any config at all
        if (!$config) {
            // If scheme has no config, default to enabled (backward compatibility)
            $hasAnyConfig = SkemaAssessmentConfig::forSkema($idSkema)->exists();
            return !$hasAnyConfig; // If no config exists, default to enabled
        }

        return $config->is_enabled;
    }

    /**
     * Apply default configuration to a scheme.
     * Creates config records for all assessment types with all enabled.
     * 
     * Requirements: 7.1
     *
     * @param string $idSkema The scheme ID
     * @return bool Success status
     */
    public function applyDefaultConfig(string $idSkema): bool
    {
        $defaultConfig = $this->getDefaultConfig();
        return $this->updateAssessmentConfig($idSkema, $defaultConfig);
    }

    /**
     * Get the full configuration for a scheme including disabled assessments.
     * 
     * @param string $idSkema The scheme ID
     * @return Collection Collection of SkemaAssessmentConfig models
     */
    public function getFullConfig(string $idSkema): Collection
    {
        return SkemaAssessmentConfig::forSkema($idSkema)
            ->ordered()
            ->get();
    }

    /**
     * Apply a template configuration to a scheme.
     * Copies the template's configuration to the scheme.
     * 
     * Requirements: 7.3
     *
     * @param string $idSkema The scheme ID
     * @param int $templateId The template ID
     * @return bool Success status
     * @throws \InvalidArgumentException If template not found
     */
    public function applyTemplate(string $idSkema, int $templateId): bool
    {
        $template = AssessmentConfigTemplate::find($templateId);

        if (!$template) {
            Log::warning("Template not found for application", [
                'id_skema' => $idSkema,
                'template_id' => $templateId
            ]);
            throw new \InvalidArgumentException("Template with ID {$templateId} not found.");
        }

        // Get the template configuration with mandatory types enforced
        $config = $template->getConfigWithMandatoryTypes();

        Log::info("Applying template to scheme", [
            'id_skema' => $idSkema,
            'template_id' => $templateId,
            'template_name' => $template->name
        ]);

        // Use the existing updateAssessmentConfig method to apply the configuration
        return $this->updateAssessmentConfig($idSkema, $config);
    }

    /**
     * Get a template by ID.
     *
     * @param int $templateId The template ID
     * @return AssessmentConfigTemplate|null
     */
    public function getTemplate(int $templateId): ?AssessmentConfigTemplate
    {
        return AssessmentConfigTemplate::find($templateId);
    }

    /**
     * Get all available templates.
     *
     * @return Collection Collection of AssessmentConfigTemplate models
     */
    public function getAllTemplates(): Collection
    {
        return AssessmentConfigTemplate::orderBy('name')->get();
    }

    /**
     * Get the default template if one exists.
     *
     * @return AssessmentConfigTemplate|null
     */
    public function getDefaultTemplate(): ?AssessmentConfigTemplate
    {
        return AssessmentConfigTemplate::default()->first();
    }

    /**
     * Create a new template from a scheme's current configuration.
     *
     * @param string $idSkema The scheme ID to copy configuration from
     * @param string $name The template name
     * @param string|null $description Optional description
     * @param string|null $createdBy User ID of creator
     * @return AssessmentConfigTemplate
     */
    public function createTemplateFromScheme(
        string $idSkema,
        string $name,
        ?string $description = null,
        ?string $createdBy = null
    ): AssessmentConfigTemplate {
        // Get current scheme configuration
        $schemeConfig = $this->getFullConfig($idSkema);
        
        $config = [];
        foreach ($schemeConfig as $configItem) {
            $config[$configItem->assessment_type] = $configItem->is_enabled;
        }

        // If no config exists, use default (all enabled)
        if (empty($config)) {
            $config = $this->getDefaultConfig();
        }

        return AssessmentConfigTemplate::create([
            'name' => $name,
            'description' => $description,
            'config_data' => $config,
            'created_by' => $createdBy,
            'is_default' => false,
        ]);
    }
}
