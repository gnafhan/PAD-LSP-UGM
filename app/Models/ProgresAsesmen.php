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
        'apl02',
        'ak01',
        'konsultasi_pra_uji',
        'ia01',
        'ia02',
        'ia07',
    ];

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }
}
