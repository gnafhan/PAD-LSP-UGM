<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesiPengajuan extends Model
{
    use HasFactory;

    protected $table = 'asesi_pengajuan';

    protected $fillable = [
        'id_asesi',
        'id_skema',
        'nama_skema',
        'id_ujian',
        'tgl_ujian',
        'nik',
        'nama_asesi',
        'jenis_kelamin',
        'tempat_tanggal_lahir',
        'alamat_sesuai_ktp',
        'kode_pos',
        'email',
        'nim',
        'no_telp',
        'kewarganegaraan',
        'dokumen',
        'sumber_anggaran',
    ];

    protected $casts = [
        'dokumen' => 'array',
    ];
}
