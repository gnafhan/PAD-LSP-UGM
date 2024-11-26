<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianMUK extends Model
{
    use HasFactory;

    protected $table = 'ujian_muk';
    protected $primaryKey = 'id_ujian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tuk',
        'id_asesi',
        'id_asesor',
        'tgl_ujian',
        'status_ujian',
        'nilai_kompetensi',
        'id_tuk',
        'jam_mulai',
        'jam_selesai',
        'id_muk',
        'tipe_ujian',
    ];

    public $timestamps = true;

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function tuk()
    {
        return $this->belongsTo(TUK::class, 'id_tuk', 'id_tuk');
    }

    public function muk()
    {
        return $this->belongsTo(MUK::class, 'id_mmuk', 'id_mmuk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_ujian');
            $number = $lastId ? intval(substr($lastId, 5)) + 1 : 1;
            $model->id_ujian = 'UJIAN' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
