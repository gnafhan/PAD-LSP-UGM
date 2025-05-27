<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apl02Kompetensi extends Model
{
    use HasFactory;

    protected $table = 'apl02_kompetensi';
    
    protected $fillable = [
        'id_apl02',
        'id_uk',
        'kode_uk',
        'nama_uk',
        'nama_elemen',
        'kompeten',
    ];

    protected $casts = [
        'kompeten' => 'boolean',
    ];

    /**
     * Get the APL02 record that owns this competency element
     */
    public function apl02(): BelongsTo
    {
        return $this->belongsTo(Apl02::class, 'id_apl02', 'id');
    }
}