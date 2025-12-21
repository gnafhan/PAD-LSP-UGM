<?php

namespace App\Models;

use App\Enums\AssessmentType;
use App\Services\SkemaConfigService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ProgresAsesmen extends Model
{
    use HasFactory;

    protected $table = 'progres_asesmen';
    protected $primaryKey = 'id_progres_asesmen';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_asesi',
        'apl01',
        'apl02',
        'ak01',
        'konsultasi_pra_uji',
        'mapa01',
        'mapa02',
        'pernyataan_ketidak_berpihakan',
        'ak07',
        'ia01',
        'ia02',
        'ia05',
        'ia11',
        'tugas_peserta',
        'hasil_asesmen',
        'ak02',
        'umpan_balik',
        'ak04'
    ];

    protected $casts = [
        'apl01' => 'array',
        'apl02' => 'array',
        'ak01' => 'array',
        'konsultasi_pra_uji' => 'array',
        'mapa01' => 'array',
        'mapa02' => 'array',
        'pernyataan_ketidak_berpihakan' => 'array',
        'ak07' => 'array',
        'ia01' => 'array',
        'ia02' => 'array',
        'ia05' => 'array',
        'ia11' => 'array',
        'tugas_peserta' => 'array',
        'hasil_asesmen' => 'array',
        'ak02' => 'array',
        'umpan_balik' => 'array',
        'ak04' => 'array'
    ];

    /**
     * Mapping from progress field names (lowercase) to AssessmentType enum values (uppercase).
     * Used for converting between database field names and assessment type constants.
     */
    public static array $fieldToAssessmentTypeMap = [
        'apl01' => AssessmentType::APL01,
        'apl02' => AssessmentType::APL02,
        'ak01' => AssessmentType::AK01,
        'ak02' => AssessmentType::AK02,
        'ak04' => AssessmentType::AK04,
        'ak07' => AssessmentType::AK07,
        'ia01' => AssessmentType::IA01,
        'ia02' => AssessmentType::IA02,
        'ia05' => AssessmentType::IA05,
        'ia11' => AssessmentType::IA11,
        'mapa01' => AssessmentType::MAPA01,
        'mapa02' => AssessmentType::MAPA02,
        'konsultasi_pra_uji' => AssessmentType::KONSUL_PRA_UJI,
        'pernyataan_ketidak_berpihakan' => AssessmentType::KETIDAKBERPIHAKAN,
        'tugas_peserta' => AssessmentType::TUGAS_PESERTA,
    ];

    /**
     * Get the assessment type constant for a given progress field name.
     *
     * @param string $fieldName The progress field name (e.g., 'apl01')
     * @return string|null The AssessmentType constant or null if not mapped
     */
    public static function getAssessmentTypeForField(string $fieldName): ?string
    {
        return self::$fieldToAssessmentTypeMap[$fieldName] ?? null;
    }

    /**
     * Get the progress field name for a given assessment type constant.
     *
     * @param string $assessmentType The AssessmentType constant (e.g., 'APL01')
     * @return string|null The progress field name or null if not mapped
     */
    public static function getFieldForAssessmentType(string $assessmentType): ?string
    {
        $flipped = array_flip(self::$fieldToAssessmentTypeMap);
        return $flipped[$assessmentType] ?? null;
    }

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    /**
     * Check if an assessment step is enabled for the asesi's scheme.
     * Uses SkemaConfigService to check the scheme's assessment configuration.
     * 
     * Requirements: 5.1, 5.3
     *
     * @param string $step The progress field name (e.g., 'apl01', 'ak01')
     * @return bool Whether the assessment is enabled for the asesi's scheme
     */
    public function isAssessmentEnabledForScheme(string $step): bool
    {
        // Get the assessment type for this field
        $assessmentType = self::getAssessmentTypeForField($step);
        
        // If no mapping exists, check if it's a valid fillable field
        // Fields without mapping (like 'hasil_asesmen', 'umpan_balik') are always enabled
        if ($assessmentType === null) {
            return \in_array($step, $this->fillable, true);
        }

        // Get the asesi's scheme
        $asesi = $this->asesi;
        if (!$asesi || !$asesi->id_skema) {
            // If no asesi or scheme, default to enabled (backward compatibility)
            return true;
        }

        // Use SkemaConfigService to check if assessment is enabled
        $configService = app(SkemaConfigService::class);
        return $configService->isAssessmentEnabled($asesi->id_skema, $assessmentType);
    }

    /**
     * Get progress data only for assessments that are enabled for the asesi's scheme.
     * Returns structured progress data filtered by the scheme's assessment configuration.
     * 
     * Requirements: 5.1
     *
     * @return array Structured progress data for enabled assessments only
     */
    public function getEnabledAssessmentsProgress(): array
    {
        $progressFields = [
            'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
            'mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan',
            'ak07', 'ia01', 'ia02', 'ia05', 'ia11', 'tugas_peserta',
            'ak02', 'umpan_balik', 'ak04'
        ];
        
        $result = [];
        foreach ($progressFields as $field) {
            // Only include fields that are enabled for the scheme
            if ($this->isAssessmentEnabledForScheme($field)) {
                if (\is_array($this->$field)) {
                    $result[$field] = $this->$field;
                } else {
                    // Convert legacy boolean values to structured format
                    $result[$field] = [
                        'completed' => (bool)$this->$field,
                        'completed_at' => (bool)$this->$field ? $this->updated_at?->format('d-m-Y H:i:s') : null
                    ];
                }
            }
        }
        
        return $result;
    }

    protected static function booted()
    {
        static::creating(function ($progresAsesmen) {
            // Set timezone to WIB
            $now = Carbon::now()->setTimezone('Asia/Jakarta');
            
            // Set apl01 completion status and time upon creation
            if (is_null($progresAsesmen->apl01) || (is_array($progresAsesmen->apl01) && empty($progresAsesmen->apl01['completed_at']))) {
                $progresAsesmen->apl01 = [
                    'completed' => true,
                    'completed_at' => $now->format('d-m-Y H:i:s') . ' WIB'
                ];
            }

            // Initialize other steps with default structure if they are null
            $progressFields = [
                'apl02', 'ak01', 'konsultasi_pra_uji', 'mapa01', 'mapa02',
                'pernyataan_ketidak_berpihakan', 'ak07', 'ia01', 'ia02', 'ia05', 'ia11',
                'tugas_peserta', 'hasil_asesmen', 'ak02', 'umpan_balik', 'ak04'
            ];

            foreach ($progressFields as $field) {
                if (is_null($progresAsesmen->{$field})) {
                    $progresAsesmen->{$field} = ['completed' => false, 'completed_at' => null];
                }
            }
        });
    }

    /**
     * Mark a step as completed
     * 
     * @param string $step The step to mark as completed
     * @return bool Success status
     */
    public function completeStep(string $step): bool
    {
        // Fix: Hapus array_keys, langsung periksa di array fillable
        if (!in_array($step, $this->fillable)) {
            \Log::error("Step $step not in fillable array", ['fillable' => $this->fillable]);
            return false;
        }

        try {
            // Set timezone to WIB (Waktu Indonesia Barat)
            $now = now()->setTimezone('Asia/Jakarta');
            
            $this->$step = [
                'completed' => true,
                'completed_at' => $now->format('d-m-Y H:i:s') . ' WIB'
            ];
            
            $result = $this->save();
            
            if (!$result) {
                \Log::error("Failed to save step $step", [
                    'model_id' => $this->id_progres_asesmen,
                    'step' => $step
                ]);
            }
            
            return $result;
        } catch (\Exception $e) {
            \Log::error("Exception when completing step $step: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if a step is completed
     * 
     * @param string $step The step to check
     * @return bool Whether the step is completed
     */
    public function isStepCompleted(string $step): bool
    {
        // Fix: Hapus array_keys, langsung periksa di array fillable
        if (!in_array($step, $this->fillable)) {
            return false;
        }

        if (is_array($this->$step)) {
            return isset($this->$step['completed']) && $this->$step['completed'] === true;
        }
        
        // For backward compatibility with boolean values
        return (bool)$this->$step;
    }

    /**
     * Get completion timestamp for a step
     * 
     * @param string $step The step to get the timestamp for
     * @return string|null The completion timestamp
     */
    public function getStepCompletionTime(string $step): ?string
    {
        // Fix: Hapus array_keys, langsung periksa di array fillable
        if (!in_array($step, $this->fillable)) {
            return null;
        }

        if (is_array($this->$step) && isset($this->$step['completed_at'])) {
            return $this->$step['completed_at'];
        }
        
        return null;
    }

    /**
     * Fields that are excluded from progress calculation.
     * - hasil_asesmen: follows AK02, not a separate step
     */
    public static array $excludedFromProgress = ['hasil_asesmen'];
    
    /**
     * Optional fields that are only counted in progress when completed.
     * These fields don't count towards total steps unless the asesi has submitted them.
     */
    public static array $optionalProgressFields = ['ak04'];

    /**
     * Calculate progress percentage based on enabled assessments only.
     * Maintains backward compatibility for schemes without configuration.
     * 
     * Requirements: 8.3
     * 
     * @param bool $useSchemeConfig Whether to filter by scheme configuration (default: true)
     * @return array Progress details including percentage
     */
    public function calculateProgress(bool $useSchemeConfig = true): array
    {
        $progressFields = [
            'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
            'mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan',
            'ak07', 'ia01', 'ia02', 'ia05', 'ia11', 'tugas_peserta',
            'ak02', 'umpan_balik', 'ak04'
        ];
        
        // Filter fields based on scheme configuration if enabled
        $enabledFields = $progressFields;
        if ($useSchemeConfig) {
            $enabledFields = array_filter($progressFields, function ($field) {
                return $this->isAssessmentEnabledForScheme($field);
            });
        }
        
        // Exclude fields that should not be counted in progress
        $enabledFields = array_filter($enabledFields, function ($field) {
            return !\in_array($field, self::$excludedFromProgress, true);
        });
        
        // Handle optional fields (ak04 - banding)
        // Only count optional fields if they are completed
        $optionalCompleted = 0;
        foreach (self::$optionalProgressFields as $optionalField) {
            if (\in_array($optionalField, $enabledFields, true)) {
                // Remove from enabled fields for now
                $enabledFields = array_filter($enabledFields, fn($f) => $f !== $optionalField);
                // If completed, add to completed count
                if ($this->isStepCompleted($optionalField)) {
                    $optionalCompleted++;
                }
            }
        }
        
        $completedSteps = 0;
        foreach ($enabledFields as $field) {
            if ($this->isStepCompleted($field)) {
                $completedSteps++;
            }
        }
        
        // Add optional completed steps
        $completedSteps += $optionalCompleted;
        
        // Total steps = enabled fields + optional completed fields
        $totalSteps = \count($enabledFields) + $optionalCompleted;
        $percentage = ($totalSteps > 0) ? round(($completedSteps / $totalSteps) * 100) : 0;
        
        return [
            'progress_percentage' => $percentage,
            'completed_steps' => $completedSteps,
            'total_steps' => $totalSteps
        ];
    }
    
    /**
     * Get all progress data in structured format
     * 
     * @return array Structured progress data
     */
    public function getStructuredProgress(): array
    {
        $progressFields = [
            'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
            'mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan',
            'ak07', 'ia01', 'ia02', 'ia05', 'ia11', 'tugas_peserta',
            'ak02', 'umpan_balik', 'ak04'
        ];
        
        $result = [];
        foreach ($progressFields as $field) {
            if (is_array($this->$field)) {
                $result[$field] = $this->$field;
            } else {
                // Convert legacy boolean values to structured format
                $result[$field] = [
                    'completed' => (bool)$this->$field,
                    'completed_at' => (bool)$this->$field ? $this->updated_at->format('d-m-Y H:i:s') : null
                ];
            }
        }
        
        return $result;
    }
}