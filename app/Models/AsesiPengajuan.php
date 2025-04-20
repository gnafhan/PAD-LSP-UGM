<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesiPengajuan extends Model
{
    use HasFactory;

    protected $table = 'asesi_pengajuan';

    protected $primaryKey = 'id_pengajuan';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_pengajuan',
        'id_user',
        'id_skema',
        'nama_user',
        'nik',
        'nim',
        'kota_domisili',
        'tempat_tanggal_lahir',
        'jenis_kelamin',
        'kebangsaan',
        'alamat_rumah',
        'no_telp',
        'pendidikan_terakhir',
        'skema_sertifikasi',
        'nama_skema',
        'nomor_skema',
        'tujuan_asesmen',
        'sumber_anggaran',
        'email',
        'file_kelengkapan_pemohon',
        'ttd_pemohon',
        'status_rekomendasi',
        'status_pekerjaan',
        'nama_perusahaan',
        'jabatan',
        'alamat_perusahaan',
        'no_telp_perusahaan',
    ];

    protected $casts = [
        'file_kelengkapan_pemohon' => 'array',
        'ttd_pemohon' => 'string',
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Menentukan prefix sesuai dengan nama model
            // Misalnya: 'ASESI', 'ASESOR', 'SKEMA', dll
            $prefix = 'PENGAJUAN'; // Ganti dengan prefix yang sesuai untuk setiap model

            // Mendapatkan nama kolom ID berdasarkan $primaryKey dari model
            $idColumn = 'id_pengajuan';

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
