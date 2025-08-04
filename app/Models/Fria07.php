<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fria07 extends Model
{
    protected $table = 'fria07';
    protected $primaryKey = 'id_fria07';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_fria07',
        'id_asesi',
        'id_asesor',
        'id_skema',
        'id_event',
        'id_rincian_asesmen',
        'data_tambahan',
        'waktu_tanda_tangan_asesor',
        'waktu_tanda_tangan_asesi',
    ];

    protected $casts = [
        'data_tambahan' => 'array',
        'waktu_tanda_tangan_asesor' => 'datetime',
        'waktu_tanda_tangan_asesi' => 'datetime',
    ];

    // Relationships
    public function asesi() {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }
    
    public function asesor() {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
    
    public function skema() {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }
    
    public function event() {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
    
    public function rincianAsesmen() {
        return $this->belongsTo(RincianAsesmen::class, 'id_rincian_asesmen', 'id_rincian_asesmen');
    }

    public function isAsesorSigned(){
        return $this->waktu_tanda_tangan_asesor !== null;
    }

    public function isAsesiSigned(){
        return $this->waktu_tanda_tangan_asesi !== null;
    }
}
