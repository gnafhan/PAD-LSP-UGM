<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiTeknis extends Model
{
    use HasFactory;

    protected $table = 'kompetensi_teknis';
    protected $primaryKey = 'id_kompetensi_teknis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kompetensi_teknis',
        'id_asesor',
        'lembaga_sertifikasi',
        'skema_kompetensi',
        'masa_berlaku',
        'file_sertifikat'
    ];

    public $timestamps = true;

    /**
     * Relasi Many to One: 
     * Banyak kompetensi_teknis dimiliki oleh satu asesor.
     */
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
}
