<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketidakberpihakan extends Model
{
    use HasFactory;

    protected $table = 'ketidakberpihakan';
    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'waktu_tanda_tangan_asesor',
    ];

    protected $casts = [
        'waktu_tanda_tangan_asesor' => 'datetime',
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