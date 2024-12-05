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
        'no_telp_perusahaan'
    ];

    protected $casts = [
        'file_kelengkapan_pemohon' => 'array', //json
        'file_sertifikat' => 'string',
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_asesi');
            $number = $lastId ? intval(substr($lastId, 5)) + 1 : 1;
            $model->id_asesi = 'ASESI' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
