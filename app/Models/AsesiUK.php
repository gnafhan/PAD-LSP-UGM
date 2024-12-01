<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesiUK extends Model
{
    use HasFactory;

    protected $table = 'asesi_uk';
    protected $primaryKey = 'id_asesiUK';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_asesiUK',
        'id_asesi',
        'id_uk',
        'elemen_uk',
        'jawaban_elemen_uk',
        'file_bukti',
    ];

    protected $casts = [
        'file_bukti' => 'array',
    ];

    public $timestamps = true;


    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function uk()
    {
        return $this->belongsTo(UK::class, 'id_uk', 'id_uk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_asesiUK');
            $number = $lastId ? intval(substr($lastId, 8)) + 1 : 1;
            $model->id_asesiUK = 'ASESI_UK' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
