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
        'file_persyaratan_dasar_pemohon',
        'file_administratif',
        'ttd_pemohon',
        'status_rekomendasi'
    ];

    protected $casts = [
        'file_persyaratan_dasar_pemohon' => 'array',
        'file_administratif' => 'array',
        'ttd_pemohon' => 'string',
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_pengajuan');
            $number = $lastId ? intval(substr($lastId, 9)) + 1 : 1;
            $model->id_pengajuan = 'PENGAJUAN' . str_pad($number, 6, '0', STR_PAD_LEFT);
        });
    }
}
