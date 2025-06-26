<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $primaryKey = 'id_event';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_event',
        'id_tuk',
        'nama_event',
        'tanggal_mulai_event',
        'tanggal_berakhir_event',
        'tipe_event',
        'periode_pelaksanaan',
        'tahun_pelaksanaan',
    ];

    protected $dates = ['tanggal_mulai_event', 'tanggal_berakhir_event'];


    public function getRentangWaktuAttribute(): string
    {
        return $this->tanggal_mulai_event->format('d-m-Y') . ' s/d ' . $this->tanggal_berakhir_event->format('d-m-Y');
    }

    public function getTanggalMulaiEventAttribute($value): Carbon
    {
        return Carbon::parse($value);
    }

    public function getTanggalBerakhirEventAttribute($value): Carbon
    {
        return Carbon::parse($value);
    }




    //tuk
    public function tuk(): BelongsTo
    {
        return $this->belongsTo(TUK::class, 'id_tuk', 'id_tuk');
    }

    //has many rincian asesmen
    public function rincianAsesmen(): HasMany
    {
        return $this->hasMany(RincianAsesmen::class, 'id_event', 'id_event');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model): void {
            // Menentukan prefix sesuai dengan nama model
            // Misalnya: 'ASESI', 'ASESOR', 'SKEMA', dll
            $prefix = 'EVENT'; // Ganti dengan prefix yang sesuai untuk setiap model

            // Mendapatkan nama kolom ID berdasarkan $primaryKey dari model
            $idColumn = 'id_event';

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
