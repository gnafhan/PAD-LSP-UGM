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
        'no_met',
        'email',
        'alamat',
        'status_asesor',
        'foto_asesor',
        'no_ktp',
        'jenis_kelamin',
        'kebangsaan',
        'kode_pos',
        'masa_berlaku',
        'daftar_bidang_kompetensi',
        'file_sertifikat_asesor',
    ];

    protected $dates = ['masa_berlaku'];

    public function bidangKompetensi()
    {
        return $this->hasMany(BidangKompetensi::class, 'id_bidang_kompetensi', 'id_bidang_kompetensi');
    }

    public function konsultasiPraUji()
    {
        return $this->hasMany(KonsultasiPraUji::class, 'id_asesor', 'id_asesor');
    }

    // Ak01
    public function ak01()
    {
        return $this->hasMany(Ak01::class, 'id_asesor', 'id_asesor');
    }

        // Accessor for daftar_bidang_kompetensi
    public function getDaftarBidangKompetensiAttribute($value)
    {
        if (is_null($value) || $value === 'null' || $value === '') {
            return [];
        }

        $ids = json_decode($value);

        if (is_array($ids) && !empty($ids)) {
            // Fetch models and preserve order of IDs if possible, or just get names
            $bidangKompetensiModels = BidangKompetensi::whereIn('id_bidang_kompetensi', $ids)->get();
            // Create a map of id => nama_bidang
            $namaBidangMap = $bidangKompetensiModels->pluck('nama_bidang', 'id_bidang_kompetensi');
            // Map IDs to names, preserving order from $ids array
            return collect($ids)->map(function ($id) use ($namaBidangMap) {
                return $namaBidangMap[$id] ?? null;
            })->filter()->values()->all(); // Filter out nulls if an ID wasn't found
        }
        return [];
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
     * 
     * @param mixed $timestamp Timestamp ketika tanda tangan dibutuhkan
     * @return TandaTanganAsesor|null Instance tanda tangan yang valid atau null jika tidak ditemukan
     */
    public function getTandaTanganPadaWaktu($timestamp)
    {
        // Jika timestamp null, return null
        if ($timestamp === null) {
            \Log::info('Timestamp null untuk asesor dengan ID: ' . $this->id_asesor);
            return null;
        }
        
        // Konversi timestamp ke Carbon untuk konsistensi penanganan
        $carbonTime = is_string($timestamp) 
            ? \Carbon\Carbon::parse($timestamp) 
            : ($timestamp instanceof \Carbon\Carbon 
                ? $timestamp 
                : \Carbon\Carbon::parse($timestamp));
        
        // 1. Cari tanda tangan yang valid saat dokumen ditandatangani
        // Ambil semua tanda tangan asesor
        $allSignatures = $this->hasMany(TandaTanganAsesor::class, 'id_asesor', 'id_asesor')
            ->orderBy('valid_from', 'asc')
            ->get();
        
        // Jika tidak ada tanda tangan sama sekali
        if ($allSignatures->isEmpty()) {
            //Log
            \Log::info($timestamp);

            \Log::info('Tidak ada tanda tangan untuk asesor dengan ID: ' . $this->id_asesor);
            return null;
        }
        
        // Kasus khusus: jika hanya ada satu tanda tangan dan belum pernah diupdate
        if ($allSignatures->count() === 1) {
            return $allSignatures->first();
        }
        
        // Cari tanda tangan yang valid saat dokumen ditandatangani
        foreach ($allSignatures as $i => $signature) {
            $nextSignature = $i < $allSignatures->count() - 1 ? $allSignatures[$i + 1] : null;
            
            // Cek apakah timestamp berada di antara tanda tangan ini dan tanda tangan berikutnya
            // atau ini adalah tanda tangan terakhir dan timestamp lebih besar dari valid_from nya
            if (
                // Kasus: waktu formulir berada di antara tanda tangan ini dan berikutnya
                ($nextSignature && 
                $carbonTime->greaterThanOrEqualTo($signature->valid_from) && 
                $carbonTime->lessThan($nextSignature->valid_from))
                ||
                // Kasus: ini tanda tangan terakhir dan waktu formulir setelahnya
                ($i === $allSignatures->count() - 1 && 
                $carbonTime->greaterThanOrEqualTo($signature->valid_from))
            ) {
                return $signature;
            }
            
            // Kasus: ini tanda tangan pertama dan waktu formulir sebelumnya
            if ($i === 0 && $carbonTime->lessThan($signature->valid_from)) {
                //Log
                \Log::info('Tanda tangan pertama untuk asesor dengan ID: ' . $this->id_asesor . ' tidak valid pada timestamp: ' . $carbonTime);
                return null; // Belum ada tanda tangan saat formulir ditandatangani
            }
        }
        
        // Default: Jika semua kondisi di atas gagal, cari tanda tangan yang valid pada timestamp
        return $this->hasMany(TandaTanganAsesor::class, 'id_asesor', 'id_asesor')
            ->where('valid_from', '<=', $carbonTime)
            ->where(function ($query) use ($carbonTime) {
                $query->where('valid_until', '>=', $carbonTime)
                    ->orWhereNull('valid_until');
            })
            ->orderBy('valid_from', 'desc')
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
