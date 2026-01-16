<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fria05 extends Model
{
    use HasFactory;

    protected $table = 'fria05';

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'waktu_tanda_tangan_asesor',
        'waktu_tanda_tangan_asesi',
        'final_decision',
        'catatan_asesor'
    ];

    protected $casts = [
        'waktu_tanda_tangan_asesor' => 'timestamp',
        'waktu_tanda_tangan_asesi' => 'timestamp',
    ];

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function jawabans(): HasMany
    {
        return $this->hasMany(Fria05Jawaban::class, 'fria05_id');
    }
}
