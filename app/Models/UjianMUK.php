<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianMUK extends Model
{
    use HasFactory;

    protected $table = 'ujian_muk';

    protected $primaryKey = 'id_ujian';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_tuk',
        'id_asesi',
        'id_asesor',
        'tgl_ujian',
        'status_ujian',
        'nilai_kompetensi',
        'id_tuk',
        'jam_mulai',
        'jam_selesai',
        'id_muk',
        'tipe_ujian',
    ];

    public $timestamps = true;

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function tuk()
    {
        return $this->belongsTo(TUK::class, 'id_tuk', 'id_tuk');
    }

    public function muk()
    {
        return $this->belongsTo(MUK::class, 'id_mmuk', 'id_mmuk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Menentukan prefix sesuai dengan nama model
            // Misalnya: 'ASESI', 'ASESOR', 'SKEMA', dll
            $prefix = 'UJIAN'; // Ganti dengan prefix yang sesuai untuk setiap model

            // Mendapatkan nama kolom ID berdasarkan $primaryKey dari model
            $idColumn = 'id_ujian';

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
