<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaAsesmen extends Model
{
    use HasFactory;

    protected $table = 'rencana_asesmen';
    protected $primaryKey = 'id_rencana_asesmen';
    public $timestamps = true;
    protected $fillable = [
        'id_skema',
        'id_uk',
        'elemen',
        'bukti_bukti',
        'jenis_bukti',
        'metode_dan_perangkat_asesmen'
    ];

    // Relasi dengan tabel lain
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    public function unitKompetensi()
    {
        return $this->belongsTo(UK::class, 'id_uk', 'id_uk');
    }
}