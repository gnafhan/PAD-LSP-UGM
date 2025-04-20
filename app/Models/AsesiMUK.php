<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesiMUK extends Model
{
    use HasFactory;

    protected $table = 'asesi_muk';

    protected $primaryKey = 'id_asesiMUK';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_asesiMUK',
        'id_asesi',
        'id_muk',
        'file_jawabanMUK',
        'id_asesor',
        'id_ujian',
    ];

    public $timestamps = true;

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function ujianMUK()
    {
        return $this->belongsTo(UjianMUK::class, 'id_ujian', 'id_ujian');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Menentukan prefix sesuai dengan nama model
            // Misalnya: 'ASESI', 'ASESOR', 'SKEMA', dll
            $prefix = 'ASESI_MUK'; // Ganti dengan prefix yang sesuai untuk setiap model

            // Mendapatkan nama kolom ID berdasarkan $primaryKey dari model
            $idColumn = 'id_asesiMUK';

            $tahun = date('Y');
            $lastIdTahunIni = self::whereYear('created_at', $tahun)->max($idColumn);

            // Jika belum ada data tahun ini
            if (!$lastIdTahunIni) {
                $model->{$idColumn} = $prefix . $tahun . '00001';
                return;
            }

            // Extract nomor urut dari tahun yang sama
            if (preg_match('/' . $prefix . $tahun . '(\d+)/', $lastIdTahunIni, $matches)) {
                $number = (int)$matches[1];
                $nextNumber = $number + 1;

                // Format dengan 5 digit
                $model->{$idColumn} = $prefix . $tahun . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Fallback jika tidak cocok
                $model->{$idColumn} = $prefix . $tahun . '00001';
            }
        });
    }
}
