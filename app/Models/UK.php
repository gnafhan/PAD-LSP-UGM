<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UK extends Model
{
    use HasFactory;

    protected $table = 'uk';
    protected $primaryKey = 'id_uk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_uk',
        'kode_uk',
        'nama_uk',
        'id_bidang',
        'jenis_standar',
    ];

    // Relasi ke model UkBidang
    public function bidang()
    {
        return $this->belongsTo(UkBidang::class, 'id_bidang');
    }

    // Event untuk mengatur id_uk saat creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_uk');
            $number = $lastId ? intval(substr($lastId, 2)) + 1 : 1;
            $model->id_uk = 'UK' . $number;
        });
    }
}
