<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema';
    protected $primaryKey = 'id_skema';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_skema',
        'nomor_skema',
        'nama_skema',
        'dokumen_skkni',
        'daftar_id_uk',
        'persyaratan_skema',
    ];

    protected $casts = [
        'daftar_id_uk' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_skema');
            $number = $lastId ? intval(substr($lastId, 3)) + 1 : 1;
            $model->id_skema = 'SKM' . $number;
        });
    }
}
