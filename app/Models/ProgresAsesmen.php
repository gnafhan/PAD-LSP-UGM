<?php

namespace App\Models;

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
        'ia11',
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
        'ia11' => 'array',
        'hasil_asesmen' => 'array',
        'ak02' => 'array',
        'umpan_balik' => 'array',
        'ak04' => 'array'
    ];

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
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
                'pernyataan_ketidak_berpihakan', 'ak07', 'ia01', 'ia02',
                'hasil_asesmen', 'ak02', 'umpan_balik', 'ak04'
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
     * Calculate progress percentage
     * 
     * @return array Progress details including percentage
     */
    public function calculateProgress(): array
    {
        $progressFields = [
            'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji',
            'mapa01', 'mapa02', 'pernyataan_ketidak_berpihakan',
            'ak07', 'ia01', 'ia02', 'hasil_asesmen',
            'ak02', 'umpan_balik', 'ak04'
        ];
        
        $completedSteps = 0;
        foreach ($progressFields as $field) {
            if ($this->isStepCompleted($field)) {
                $completedSteps++;
            }
        }
        
        $totalSteps = count($progressFields);
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
            'ak07', 'ia01', 'ia02', 'hasil_asesmen',
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