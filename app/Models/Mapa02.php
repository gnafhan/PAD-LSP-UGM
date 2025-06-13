<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mapa02 extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mapa02';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'muk_ceklis_observasi',
        'muk_tugas_praktik_demonstrasi',
        'muk_pertanyaan_tertulis_esai',
        'muk_pertanyaan_lisan',
        'muk_ceklis_verifikasi_portfolio',
        'muk_ceklis_meninjau_materi_uji',
        'waktu_tanda_tangan_asesor',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'waktu_tanda_tangan_asesor' => 'timestamp',
        'muk_ceklis_observasi' => 'integer',
        'muk_tugas_praktik_demonstrasi' => 'integer',
        'muk_pertanyaan_tertulis_esai' => 'integer',
        'muk_pertanyaan_lisan' => 'integer',
        'muk_ceklis_verifikasi_portfolio' => 'integer',
        'muk_ceklis_meninjau_materi_uji' => 'integer',
    ];

    /**
     * Get the asesi that owns the Mapa02 record.
     */
    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    /**
     * Get the asesor that owns the Mapa02 record.
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
}