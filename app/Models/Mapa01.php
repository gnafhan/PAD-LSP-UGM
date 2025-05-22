<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mapa01 extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mapa01';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'pendekatan_asesmen_asesi',
        'tujuan_asesmen',
        'lingkungan',
        'peluang_untuk_mengumpulkan_bukti',
        'hubungan_antara_standar_kompetensi',
        'pelaksana_asesmen',
        'pihak_yang_relevan_untuk_dikonfirmasi',
        'tolak_ukur_asesmen',
        'waktu_tanda_tangan_asesor',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'waktu_tanda_tangan_asesor' => 'datetime',
    ];

    /**
     * Get the asesi that owns the MAPA01 record.
     */
    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    /**
     * Get the asesor that owns the MAPA01 record.
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
}