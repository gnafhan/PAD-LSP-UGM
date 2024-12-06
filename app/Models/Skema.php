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
        'daftar_id_uk', //json
        'persyaratan_skema',
    ];

    protected $casts = [
        'daftar_id_uk' => 'array',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_skema', 'id_skema', 'id_event');
    }

    public function unitKompetensi()
    {
        return $this->hasMany(UK::class, 'id_uk', 'daftar_id_uk');
    }

    public function getUnitKompetensiAttribute()
    {
        $idArray = is_array($this->daftar_id_uk) ? $this->daftar_id_uk : json_decode($this->daftar_id_uk, true);
        return UK::whereIn('id_uk', $idArray ?? [])->get();
    }

    public function eventSkemas()
    {
        return $this->hasMany(EventSkema::class, 'id_skema');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_skema');
            $number = $lastId ? intval(substr($lastId, 5)) + 1 : 1;
            $model->id_skema = 'SKEMA' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
