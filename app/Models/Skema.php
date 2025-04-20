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
        'has_complete_info',
    ];

    protected $casts = [
        'daftar_id_uk' => 'array',
    ];

    // count daftar_id_uk
    public function getCountDaftarIdUkAttribute()
    {
        $idArray = is_array($this->daftar_id_uk) ? $this->daftar_id_uk : json_decode($this->daftar_id_uk, true);
        return count($idArray ?? []);
    }


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

    public function rencanaAsesmen()
    {
        return $this->hasMany(RencanaAsesmen::class, 'id_skema', 'id_skema');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'SKEMA';
            $tahun = date('Y');
            $lastIdTahunIni = self::whereYear('created_at', $tahun)->max('id_skema');

            // Jika belum ada data tahun ini
            if (!$lastIdTahunIni) {
                $model->id_skema = $prefix . $tahun . '00001';
                return;
            }

            // Extract nomor urut dari tahun yang sama
            if (preg_match('/' . $prefix . $tahun . '(\d+)/', $lastIdTahunIni, $matches)) {
                $number = (int)$matches[1];
                $nextNumber = $number + 1;

                // Format dengan 5 digit
                $model->id_skema = $prefix . $tahun . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Fallback jika tidak cocok
                $model->id_skema = $prefix . $tahun . '00001';
            }
        });
    }
}
