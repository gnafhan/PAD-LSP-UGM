<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesi extends Model
{
    use HasFactory;

    protected $table = 'asesi';
    protected $primaryKey = 'id_asesi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_asesi',
        'nama_asesi',
        'tempat_tanggal_lahir',
        'jenis_kelamin',
        'kebangsaan',
        'alamat_rumah',
        'kota_domisili',
        'no_telp',
        'no_telp_rumah',
        'email',
        'nim',
        'id_user',
        'file_sertifikat',
        'id_skema',
        'file_kelengkapan_pemohon',
        'ttd_pemohon',
        'status_pekerjaan',
        'nama_perusahaan',
        'jabatan',
        'alamat_perusahaan',
        'no_telp_perusahaan',
    ];

    protected $casts = [
        'file_kelengkapan_pemohon' => 'array', //json
        'file_sertifikat' => 'string',
    ];

    public $timestamps = true;

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema');
    }

    public function asesor()
    {
        return $this->belongsToMany(Asesor::class, 'rincian_asesmen', 'id_asesi', 'id_asesor');
    }

    public function rincianAsesmen()
    {
        return $this->hasOne(RincianAsesmen::class, 'id_asesi', 'id_asesi');
    }

    //progress asesmen
    public function progresAsesmen()
    {
        return $this->hasOne(ProgresAsesmen::class, 'id_asesi', 'id_asesi');
    }

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $tahun = date('Y');
            $lastIdTahunIni = self::whereYear('created_at', $tahun)->max('id_asesi');
            
            // Jika belum ada data tahun ini
            if (!$lastIdTahunIni) {
                $model->id_asesi = 'ASESI' . $tahun . '00001';
                return;
            }
            
            // Extract nomor urut dari tahun yang sama
            if (preg_match('/ASESI' . $tahun . '(\d+)/', $lastIdTahunIni, $matches)) {
                $number = (int)$matches[1];
                $nextNumber = $number + 1;
                
                // Format dengan 5 digit
                $model->id_asesi = 'ASESI' . $tahun . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Fallback jika tidak cocok
                $model->id_asesi = 'ASESI' . $tahun . '00001';
            }
        });
    }
}
