<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MUK extends Model
{
    use HasFactory;

    protected $table = 'muk';
    protected $primaryKey = 'id_muk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_muk',
        'nama_muk',
        'file_muk',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_muk');
            $number = $lastId ? intval(substr($lastId, 3)) + 1 : 1;
            $model->id_muk = 'MUK' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
