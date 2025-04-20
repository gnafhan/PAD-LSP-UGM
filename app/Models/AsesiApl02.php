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
            $tahun = date('Y');
            $lastIdTahunIni = self::whereYear('created_at', $tahun)->max('id_asesiAPL02');

            // Jika belum ada data tahun ini
            if (!$lastIdTahunIni) {
                $model->id_asesiAPL02 = 'ASESIAPL2_' . $tahun . '_00001';
                return;
            }

            // Extract nomor urut dari tahun yang sama
            if (preg_match('/ASESIAPL2_' . $tahun . '_(\d+)/', $lastIdTahunIni, $matches)) {
                $number = (int)$matches[1];
                $nextNumber = $number + 1;

                // Format dengan 5 digit
                $model->id_asesiAPL02 = 'ASESIAPL2_' . $tahun . '_' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Fallback jika tidak cocok
                $model->id_asesiAPL02 = 'ASESIAPL2_' . $tahun . '_00001';
            }
        });
    }
}
