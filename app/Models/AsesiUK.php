<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesiUK extends Model
{
    use HasFactory;

    protected $table = 'asesi_uk';

    protected $primaryKey = 'id_asesiUK';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_asesiUK',
        'id_asesi',
        'id_uk',
        'elemen_uk',
        'jawaban_elemen_uk',
        'file_bukti',
    ];

    protected $casts = [
        'file_bukti' => 'array',
    ];

    public $timestamps = true;

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function uk()
    {
        return $this->belongsTo(UK::class, 'id_uk', 'id_uk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Menentukan prefix sesuai dengan nama model
            // Misalnya: 'ASESI', 'ASESOR', 'SKEMA', dll
            $prefix = 'ASESI_UK'; // Ganti dengan prefix yang sesuai untuk setiap model

            // Mendapatkan nama kolom ID berdasarkan $primaryKey dari model
            $idColumn = 'id_asesiUK';

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
