<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMUK extends Model
{
    use HasFactory;

    protected $table = 'jadwal_muk';
    protected $primaryKey = 'id_jadwal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_jadwal',
        'id_asesi',
        'id_ujian',
        'waktu_jadwal',
        'id_asesor',
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

    public function ujianMUK()
    {
        return $this->belongsTo(UjianMUK::class, 'id_ujian', 'id_ujian');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_jadwal');
            $number = $lastId ? intval(substr($lastId, 6)) + 1 : 1;
            $model->id_jadwal = 'JADWAL' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
