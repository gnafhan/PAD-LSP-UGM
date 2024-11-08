<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor';
    protected $primaryKey = 'id_asesor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_asesor', 'kode_registrasi', 'nama_asesor', 'no_sertifikat', 'no_hp',
        'email', 'alamat', 'bidang', 'status_asesor', 'foto_asesor', 'gelar_depan',
        'gelar_belakang', 'no_ktp', 'jenis_kelamin', 'pendidikan_terakhir', 'keahlian',
        'tempat_lahir', 'tanggal_lahir', 'kebangsaan', 'no_lisensi', 'masa_berlaku',
        'institusi_asal', 'no_telp_institusi_asal', 'fax_institusi_asal', 'email_institusi_asal'
    ];

    protected $dates = ['tanggal_lahir', 'masa_berlaku'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_asesor');
            $number = $lastId ? intval(substr($lastId, 6)) + 1 : 1;
            $model->id_asesor = 'ASESOR' . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }
}
