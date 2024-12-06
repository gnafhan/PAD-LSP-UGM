<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TUK extends Model
{
    use HasFactory;

    protected $table = 'tuk';
    protected $primaryKey = 'id_tuk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tuk',
        'kode_tuk',
        'nama_tuk',
        'alamat',
        'id_penanggung_jawab',
        'no_lisensi_skkn',
    ];

    public $timestamps = true;

    public function penanggungJawab()
    {
        return $this->belongsTo(PenanggungJawab::class, 'id_penanggung_jawab', 'id_penanggung_jawab');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_tuk');
            $number = $lastId ? intval(substr($lastId, 3)) + 1 : 1;
            $model->id_tuk = 'TUK' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
