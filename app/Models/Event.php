<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'daftar_id_skema',
    ];

    protected $casts = [
        'daftar_id_skema' => 'array',
    ];

    public function skema()
    {
        return $this->hasMany(Skema::class, 'id_skema', 'daftar_id_skema');
    }

    public function getSkemaAttribute()
    {
        $idArray = is_array($this->daftar_id_skema) ? $this->daftar_id_skema : json_decode($this->daftar_id_skema, true);
        return Skema::whereIn('id_skema', $idArray ?? [])->get();
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
