<?php

namespace App\Models;

use App\Enums\AssessmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema';

    protected $primaryKey = 'id_skema';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_skema',
        'nomor_skema',
        'nama_skema',
        'id_bidang_kompetensi',
        'dokumen_skkni',
        'daftar_id_uk', //json
        'persyaratan_skema',
        'has_complete_info',
    ];

    protected $casts = [
        'daftar_id_uk' => 'array',
    ];

    // count daftar_id_uk
    public function getCountDaftarIdUkAttribute()
    {
        $idArray = is_array($this->daftar_id_uk) ? $this->daftar_id_uk : json_decode($this->daftar_id_uk, true);
        return count($idArray ?? []);
    }


    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_skema', 'id_skema', 'id_event');
    }

    public function bidangKompetensi()
    {
        return $this->belongsTo(BidangKompetensi::class, 'id_bidang_kompetensi', 'id_bidang_kompetensi');
    }


    public function unitKompetensi()
    {
        // Return a query builder for the UK models based on the JSON field
        $idArray = is_array($this->daftar_id_uk) ? $this->daftar_id_uk : json_decode($this->daftar_id_uk, true);
        return UK::with('elemen_uk')->whereIn('id_uk', $idArray ?? []);
    }

    // Method to get unit kompetensi without eager loading
    public function getUnitKompetensi()
    {
        $idArray = is_array($this->daftar_id_uk) ? $this->daftar_id_uk : json_decode($this->daftar_id_uk, true);
        return UK::with('elemen_uk')->whereIn('id_uk', $idArray ?? [])->get();
    }

    public function eventSkemas()
    {
        return $this->hasMany(EventSkema::class, 'id_skema');
    }

    public function rencanaAsesmen()
    {
        return $this->hasMany(RencanaAsesmen::class, 'id_skema', 'id_skema');
    }

    // asesi
    public function asesi()
    {
        return $this->hasMany(Asesi::class, 'id_skema', 'id_skema');
    }

    /**
     * Relationship to SkemaAssessmentConfig
     * Returns all assessment configurations for this scheme.
     * 
     * Requirements: 1.1
     *
     * @return HasMany
     */
    public function assessmentConfig(): HasMany
    {
        return $this->hasMany(SkemaAssessmentConfig::class, 'id_skema', 'id_skema');
    }

    /**
     * Relationship to AsesorSkemaAssignment
     * Returns all asesor assignments for this scheme.
     * 
     * Requirements: 3.1
     *
     * @return HasMany
     */
    public function asesorAssignments(): HasMany
    {
        return $this->hasMany(AsesorSkemaAssignment::class, 'id_skema', 'id_skema');
    }

    /**
     * Get array of enabled assessment types for this scheme.
     * Always includes mandatory APL types regardless of configuration.
     * If no configuration exists, returns all assessment types (backward compatibility).
     * 
     * Requirements: 5.1
     *
     * @return array Array of enabled assessment type strings
     */
    public function getEnabledAssessments(): array
    {
        // Get enabled assessments from the relationship
        $enabledFromDb = $this->assessmentConfig()
            ->where('is_enabled', true)
            ->orderBy('display_order', 'asc')
            ->pluck('assessment_type')
            ->toArray();

        // If no configuration exists, return all types (backward compatibility)
        if (empty($enabledFromDb) && !$this->assessmentConfig()->exists()) {
            return AssessmentType::getAllTypes();
        }

        // Always include mandatory APL types
        $mandatoryTypes = AssessmentType::getMandatoryTypes();
        
        // Merge mandatory types with enabled types, ensuring no duplicates
        return array_values(array_unique(array_merge($mandatoryTypes, $enabledFromDb)));
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'SKEMA';
            $tahun = date('Y');
            $lastIdTahunIni = self::whereYear('created_at', $tahun)->max('id_skema');

            // Jika belum ada data tahun ini
            if (!$lastIdTahunIni) {
                $model->id_skema = $prefix . $tahun . '00001';
                return;
            }

            // Extract nomor urut dari tahun yang sama
            if (preg_match('/' . $prefix . $tahun . '(\d+)/', $lastIdTahunIni, $matches)) {
                $number = (int)$matches[1];
                $nextNumber = $number + 1;

                // Format dengan 5 digit
                $model->id_skema = $prefix . $tahun . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Fallback jika tidak cocok
                $model->id_skema = $prefix . $tahun . '00001';
            }
        });
    }
}
