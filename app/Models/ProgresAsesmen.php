<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'pertanyaan_ketidak_berpihakan',
        'ak07',
        'ia01',
        'ia02',
        'hasil_asesmen',
        'ak02',
        'umpan_balik',
        'ak04'
    ];

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }
}
