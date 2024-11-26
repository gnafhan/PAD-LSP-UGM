<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesiMUK extends Model
{
    use HasFactory;

    protected $table = 'asesi_muk';
    protected $primaryKey = 'id_asesiMUK';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_asesiMUK',
        'id_asesi',
        'id_muk',
        'file_jawabanMUK',
        'id_asesor',
        'id_ujian',
    ];

    public $timestamps = true;

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function ujianMUK()
    {
        return $this->belongsTo(UjianMUK::class, 'id_ujian', 'id_ujian');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_asesiMUK');
            $number = $lastId ? intval(substr($lastId, 9)) + 1 : 1;
            $model->id_asesiMUK = 'ASESI_MUK' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
