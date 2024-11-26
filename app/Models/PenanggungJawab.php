<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenanggungJawab extends Model
{
    use HasFactory;

    protected $table = 'penanggung_jawab';
    protected $primaryKey = 'id_penanggung_jawab';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penanggung_jawab',
        'nama_pananggung_jawab',
        'status_penanggung_jawab',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_penanggung_jawab');
            $number = $lastId ? intval(substr($lastId, 16)) + 1 : 1;
            $model->id_penanggung_jawab = 'PENANGGUNG_JAWAB' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
