<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesiApl02 extends Model
{
    use HasFactory;

    protected $table = 'asesi_apl02';
    protected $primaryKey = 'id_asesiAPL02';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_asesiAPL02',
        'id_asesi',
        'daftar_id_asesiUK',
        'file_portofolio',
    ];

    public $timestamps = true;

    protected $casts = [
        'file_portofolio' => 'array',
        'daftar_id_asesiUK' => 'array',
    ];

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_asesiAPL02');
            $number = $lastId ? intval(substr($lastId, 12)) + 1 : 1;
            $model->id_asesiAPL02 = 'ASESI_APL02_' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
