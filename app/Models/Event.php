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
