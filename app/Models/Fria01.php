<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fria01 extends Model
{
    protected $table = 'fria01';
    protected $primaryKey = 'id_fria01';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_fria01',
        'id_asesi',
        'id_asesor',
        'id_skema',
        'id_event',
        'id_rincian_asesmen',
        'data_tambahan',
    ];

    protected $casts = [
        'data_tambahan' => 'array',
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
}
