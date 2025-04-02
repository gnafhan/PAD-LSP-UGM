<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UK extends Model
{
    use HasFactory;

    protected $table = 'uk';
    protected $primaryKey = 'id_uk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_uk',
        'kode_uk',
        'nama_uk',
        'id_bidang',
        'jenis_standar',
    ];

    public function bidang()
    {
        return $this->belongsTo(UKBidang::class, 'id_bidang', 'id_bidang');
    }

    public function elemen_uk()
    {
        return $this->hasMany(ElemenUK::class, 'id_uk', 'id_uk');
    }

    public function count_elemen_uk()
    {
        return $this->elemen_uk()->count();
    }

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            // Menentukan prefix sesuai dengan nama model
            // Misalnya: 'ASESI', 'ASESOR', 'SKEMA', dll
            $prefix = 'UK'; // Ganti dengan prefix yang sesuai untuk setiap model
            
            // Mendapatkan nama kolom ID berdasarkan $primaryKey dari model
            $idColumn = 'id_uk';
            
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
