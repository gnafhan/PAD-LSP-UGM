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
        'id_asesor',
        'kode_registrasi',
        'nama_asesor',
        'no_sertifikat',
        'no_hp',
        'email',
        'alamat',
        'status_asesor',
        'foto_asesor',
        'no_ktp',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'tempat_lahir',
        'tanggal_lahir',
        'kebangsaan',
        'no_lisensi',
        'masa_berlaku',
        'institusi_asal',
        'no_telp_institusi_asal',
        'fax_institusi_asal',
        'email_institusi_asal',
        'daftar_bidang_kompetensi', //json
        'file_sertifikat_asesor',
    ];

    protected $dates = ['tanggal_lahir', 'masa_berlaku'];

    public function bidangKompetensi()
    {
        return $this->hasMany(BidangKompetensi::class, 'id_bidang_kompetensi', 'id_bidang_kompetensi');
    }

    public function konsultasiPraUji()
    {
        return $this->hasMany(KonsultasiPraUji::class, 'id_asesor', 'id_asesor');
    }

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            $prefix = 'ASESOR';
            $tahun = date('Y');
            $lastIdTahunIni = self::whereYear('created_at', $tahun)->max('id_asesor');
            
            // Jika belum ada data tahun ini
            if (!$lastIdTahunIni) {
                $model->id_asesor = $prefix . $tahun . '00001';
                return;
            }
            
            // Extract nomor urut dari tahun yang sama
            if (preg_match('/' . $prefix . $tahun . '(\d+)/', $lastIdTahunIni, $matches)) {
                $number = (int)$matches[1];
                $nextNumber = $number + 1;
                
                // Format dengan 5 digit
                $model->id_asesor = $prefix . $tahun . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Fallback jika tidak cocok
                $model->id_asesor = $prefix . $tahun . '00001';
            }
        });
    }

    /**
     * Relasi One to Many: 
     * Satu asesor memiliki banyak kompetensi teknis.
    */
    public function kompetensiTeknis()
    {
        return $this->hasMany(KompetensiTeknis::class, 'id_asesor', 'id_asesor');
    }

        /**
     * Relasi One to Many: 
     * Satu asesor memiliki banyak tanda tangan (dengan history).
    */
    public function tandaTangan()
    {
        return $this->hasMany(TandaTanganAsesor::class, 'id_asesor', 'id_asesor');
    }
    
    /**
     * Mendapatkan tanda tangan asesor yang aktif saat ini
     */
    public function tandaTanganAktif()
    {
        return $this->hasMany(TandaTanganAsesor::class, 'id_asesor', 'id_asesor')
            ->where('valid_until', null);
    }
    
    /**
     * Mendapatkan tanda tangan asesor yang valid pada waktu tertentu
     */
    public function getTandaTanganPadaWaktu($timestamp)
    {
        return $this->hasMany(TandaTanganAsesor::class, 'id_asesor', 'id_asesor')
            ->where('valid_from', '<=', $timestamp)
            ->where(function($query) use ($timestamp) {
                $query->where('valid_until', '>=', $timestamp)
                      ->orWhereNull('valid_until');
            })
            ->first();
    }

    public function asesi()
    {
        return $this->belongsToMany(Asesi::class, 'rincian_asesmen', 'id_asesor', 'id_asesi');
    }
    
    public function rincianAsesmen()
    {
        return $this->hasMany(RincianAsesmen::class, 'id_asesor', 'id_asesor');
    }
}
