<?php

namespace App\Models;

use App\Enums\AssessmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * SkemaAssessmentConfig Model
 * 
 * Stores which assessment tools are enabled for each certification scheme.
 * APL tools (APL01, APL02) are mandatory and cannot be disabled.
 * 
 * Requirements: 1.2, 1.3
 */
class SkemaAssessmentConfig extends Model
{
    use HasFactory;

    protected $table = 'skema_assessment_config';

    protected $fillable = [
        'id_skema',
        'assessment_type',
        'is_enabled',
        'display_order',
        'config_data',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'config_data' => 'array',
        'display_order' => 'integer',
    ];

    /**
     * APL types that are mandatory and cannot be disabled
     * @deprecated Use AssessmentType::getMandatoryTypes() instead
     */
    public const MANDATORY_TYPES = ['APL01', 'APL02'];

    /**
     * All available assessment types
     * @deprecated Use AssessmentType::getAllTypes() instead
     */
    public const ASSESSMENT_TYPES = [
        'APL01', 'APL02',
        'AK01', 'AK02', 'AK04', 'AK07',
        'IA01', 'IA02', 'IA05', 'IA07', 'IA11',
        'MAPA01', 'MAPA02',
        'KONSUL_PRA_UJI', 'KETIDAKBERPIHAKAN', 'TUGAS_PESERTA',
    ];

    /**
     * Relationship to Skema
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Scope to get only enabled assessments
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }

    /**
     * Scope to get assessments for a specific scheme
     */
    public function scopeForSkema(Builder $query, string $idSkema): Builder
    {
        return $query->where('id_skema', $idSkema);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order', 'asc');
    }

    /**
     * Check if the assessment type is mandatory (APL)
     */
    public static function isMandatoryType(string $assessmentType): bool
    {
        return AssessmentType::isMandatory($assessmentType);
    }

    /**
     * Check if the assessment type is valid
     */
    public static function isValidAssessmentType(string $assessmentType): bool
    {
        return AssessmentType::isValid($assessmentType);
    }

    /**
     * Get configurable (non-mandatory) assessment types
     */
    public static function getConfigurableTypes(): array
    {
        return AssessmentType::getConfigurableTypes();
    }

    /**
     * Boot method to enforce APL mandatory constraint
     */
    protected static function boot()
    {
        parent::boot();

        // Prevent disabling mandatory APL types
        static::saving(function (SkemaAssessmentConfig $config) {
            if (self::isMandatoryType($config->assessment_type) && !$config->is_enabled) {
                // Force APL types to always be enabled
                $config->is_enabled = true;
            }
        });

        // Also prevent updates that try to disable APL types
        static::updating(function (SkemaAssessmentConfig $config) {
            if (self::isMandatoryType($config->assessment_type) && !$config->is_enabled) {
                // Force APL types to always be enabled
                $config->is_enabled = true;
            }
        });
    }

    /**
     * Validate that APL types cannot be disabled
     * Returns true if valid, false if attempting to disable APL
     */
    public function validateMandatoryConstraint(): bool
    {
        if (self::isMandatoryType($this->assessment_type) && !$this->is_enabled) {
            return false;
        }
        return true;
    }
}
