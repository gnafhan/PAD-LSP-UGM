<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ak01 extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ak01';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'waktu_tanda_tangan_asesor',
        'waktu_tanda_tangan_asesi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'waktu_tanda_tangan_asesor' => 'timestamp',
        'waktu_tanda_tangan_asesi' => 'timestamp',
    ];

    /**
     * Get the asesi that owns the AK01 record.
     */
    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    /**
     * Get the asesor that owns the AK01 record.
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    /**
     * Get the hasil items for this AK01 record.
     */
    public function hasilItems(): HasMany
    {
        return $this->hasMany(Ak01HasilItem::class, 'ak01_id');
    }
}