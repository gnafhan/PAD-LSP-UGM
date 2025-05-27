<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Skema;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\Apl02Kompetensi;

class Apl02 extends Model
{
    use HasFactory;

    protected $table = 'apl02';
    
    protected $fillable = [
        'id_skema',
        'id_asesi',
        'id_asesor',
        'waktu_tanda_tangan_asesi',
        'waktu_tanda_tangan_asesor',
        'rekomendasi',
        'metode_uji',
    ];

    protected $casts = [
        'waktu_tanda_tangan_asesi' => 'datetime',
        'waktu_tanda_tangan_asesor' => 'datetime',
    ];

    /**
     * Get the skema associated with the APL02
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Get the asesi associated with the APL02
     */
    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    /**
     * Get the asesor associated with the APL02
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    /**
     * Get the kompetensi details for this APL02
     */
    public function kompetensi(): HasMany
    {
        return $this->hasMany(Apl02Kompetensi::class, 'id_apl02', 'id');
    }

    /**
     * Get formatted kompetensi data grouped by unit
     */
    public function getDetailSkema()
    {
        $result = [];
        $kompetensiData = $this->kompetensi()->get();
        
        // Group by unit_kompetensi
        $groupedData = $kompetensiData->groupBy('id_uk');
        
        foreach ($groupedData as $unitId => $kompetensiGroup) {
            // Get first item for unit info
            $firstItem = $kompetensiGroup->first();
            
            $unitData = [
                'id_uk' => $unitId,
                'kode_uk' => $firstItem->kode_uk,
                'nama_uk' => $firstItem->nama_uk,
                'elemen_uk' => []
            ];
            
            // Add each elemen
            foreach ($kompetensiGroup as $item) {
                $unitData['elemen_uk'][] = [
                    'nama_elemen' => $item->nama_elemen,
                    'kompeten' => $item->kompeten
                ];
            }
            
            $result[] = $unitData;
        }
        
        return $result;
    }
}