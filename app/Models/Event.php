<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $primaryKey = 'id_event';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_event',
        'nama_event',
        'tanggal_mulai_event',
        'tanggal_berakhir_event',
        'tuk',
        'tipe_event',
    ];

    protected $dates = ['tanggal_mulai_event', 'tanggal_berakhir_event'];

    public function skemas()
    {
        return $this->belongsToMany(Skema::class, 'event_skema', 'id_event', 'id_skema');
    }

    public function getTanggalMulaiEventAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getTanggalBerakhirEventAttribute($value)
    {
        return Carbon::parse($value);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_event');
            $number = $lastId ? intval(substr($lastId, 5)) + 1 : 1;
            $model->id_event = 'EVENT' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
