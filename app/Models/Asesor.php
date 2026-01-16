<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;


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
        'tempat_lahir',
        'tanggal_lahir',
        'provinsi',
        'kabupaten_kota',
        'fakultas',

        // Foreign key
        'id_user',
    ];

    protected $dates = ['masa_berlaku'];


    public function bidangKompetensi()
    {
        return $this->hasMany(BidangKompetensi::class, 'id_bidang_kompetensi', 'id_bidang_kompetensi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
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
        return json_decode($value, true) ?: [];
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
            Log::info('Timestamp null untuk asesor dengan ID: ' . $this->id_asesor);
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
            Log::info($timestamp);

            Log::info('Tidak ada tanda tangan untuk asesor dengan ID: ' . $this->id_asesor);
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
                Log::info('Tanda tangan pertama untuk asesor dengan ID: ' . $this->id_asesor . ' tidak valid pada timestamp: ' . $carbonTime);
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

    /**
     * Relationship to AsesorSkemaAssignment
     * Returns all scheme assignments for this asesor.
     * 
     * Requirements: 3.1
     *
     * @return HasMany
     */
    public function skemaAssignments(): HasMany
    {
        return $this->hasMany(AsesorSkemaAssignment::class, 'id_asesor', 'id_asesor');
    }

    /**
     * Get collection of schemes assigned to this asesor.
     * 
     * Requirements: 2.1
     *
     * @return Collection Collection of Skema models
     */
    public function getAssignedSkemas(): Collection
    {
        return Skema::whereIn('id_skema', 
            $this->skemaAssignments()->pluck('id_skema')
        )->get();
    }

    /**
     * Check if this asesor has access to a specific scheme.
     * 
     * Requirements: 2.2
     *
     * @param string $idSkema The scheme ID to check access for
     * @return bool True if asesor has access, false otherwise
     */
    public function canAccessSkema(string $idSkema): bool
    {
        return $this->skemaAssignments()
            ->where('id_skema', $idSkema)
            ->exists();
    }
}
