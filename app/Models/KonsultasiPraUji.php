<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiPraUji extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_pra_uji';
    
    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'tanggal_konsultasi',
        'waktu_pelaksanaan',
        'tempat_uji',
        'jawaban_checklist',
        'waktu_tanda_tangan_asesor',
    ];
    
    protected $casts = [
        'jawaban_checklist' => 'array',
        'tanggal_konsultasi' => 'timestamp',
        'waktu_tanda_tangan_asesor' => 'timestamp',
    ];
    
    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }
    
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
}