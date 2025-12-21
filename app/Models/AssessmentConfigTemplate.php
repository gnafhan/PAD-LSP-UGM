<?php

namespace App\Models;

use App\Enums\AssessmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * AssessmentConfigTemplate Model
 * 
 * Stores template configurations that can be applied to certification schemes.
 * Templates allow admins to quickly set up new schemes with predefined
 * assessment tool configurations.
 * 
 * Requirements: 7.2
 */
class AssessmentConfigTemplate extends Model
{
    use HasFactory;

    protected $table = 'assessment_config_template';

    protected $fillable = [
        'name',
        'description',
        'config_data',
        'created_by',
        'is_default',
    ];

    protected $casts = [
        'config_data' => 'array',
        'is_default' => 'boolean',
    ];

    /**
     * Relationship to User (creator)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    /**
     * Scope to get default template
     */
    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    /**
     * Get the configuration as an array of assessment_type => is_enabled pairs.
     * Ensures mandatory APL types are always enabled.
     *
     * @return array
     */
    public function getConfigWithMandatoryTypes(): array
    {
        $config = $this->config_data ?? [];

        // Ensure mandatory APL types are always enabled
        foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
            $config[$mandatoryType] = true;
        }

        return $config;
    }

    /**
     * Validate that the template configuration is valid.
     * APL types must be enabled.
     *
     * @return bool
     */
    public function isValidConfig(): bool
    {
        $config = $this->config_data ?? [];

        // Check that mandatory types are not explicitly disabled
        foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
            if (isset($config[$mandatoryType]) && $config[$mandatoryType] === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get enabled assessment types from this template.
     *
     * @return array
     */
    public function getEnabledTypes(): array
    {
        $config = $this->getConfigWithMandatoryTypes();
        
        return array_keys(array_filter($config, fn($enabled) => $enabled === true));
    }

    /**
     * Boot method to enforce APL mandatory constraint on save
     */
    protected static function boot()
    {
        parent::boot();

        // Ensure APL types are always enabled in config_data
        static::saving(function (AssessmentConfigTemplate $template) {
            $config = $template->config_data ?? [];
            
            // Force APL types to always be enabled
            foreach (AssessmentType::getMandatoryTypes() as $mandatoryType) {
                $config[$mandatoryType] = true;
            }
            
            $template->config_data = $config;
        });
    }
}
