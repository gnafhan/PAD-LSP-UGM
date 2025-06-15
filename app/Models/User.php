<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'name',
        'email',
        'password',
        'no_hp',
        'level',
        'gauth_id', // tambahkan ini
        'gauth_type', // tambahkan ini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Relasi One to Many: 
     * Satu user (admin) memiliki banyak tanda tangan (dengan history).
    */
    public function tandaTangan()
    {
        return $this->hasMany(TandaTanganAdmin::class, 'id_user', 'id_user');
    }
    
    /**
     * Mendapatkan tanda tangan user (admin) yang aktif saat ini
     */
    public function tandaTanganAktif()
    {
        return $this->hasMany(TandaTanganAdmin::class, 'id_user', 'id_user')
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
        $allSignatures = $this->hasMany(TandaTanganAdmin::class, 'id_user', 'id_user')
            ->orderBy('valid_from', 'asc')
            ->get();
        
        // Jika tidak ada tanda tangan sama sekali
        if ($allSignatures->isEmpty()) {
            //Log
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
                return null; // Belum ada tanda tangan saat formulir ditandatangani
            }
        }
        
        // Default: Jika semua kondisi di atas gagal, cari tanda tangan yang valid pada timestamp
        return $this->hasMany(TandaTanganAdmin::class, 'id_user', 'id_user')
            ->where('valid_from', '<=', $carbonTime)
            ->where(function ($query) use ($carbonTime) {
                $query->where('valid_until', '>=', $carbonTime)
                    ->orWhereNull('valid_until');
            })
            ->orderBy('valid_from', 'desc')
            ->first();
    }

    //asesi
    public function asesi()
    {
        return $this->hasOne(Asesi::class, 'id_user', 'id_user');
    }

    // asesor
    public function asesor()
    {
        return $this->hasOne(Asesor::class, 'id_user', 'id_user');
    }

    //asesi pengajuan
    public function asesiPengajuan()
    {
        return $this->hasOne(AsesiPengajuan::class, 'id_user', 'id_user');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $tahun = date('Y');
            $lastIdTahunIni = self::whereYear('created_at', $tahun)->max('id_user');

            // Jika belum ada data tahun ini
            if (!$lastIdTahunIni) {
                $model->id_user = 'USER' . $tahun . '00001';
                return;
            }

            // Extract nomor urut dari tahun yang sama
            if (preg_match('/USER' . $tahun . '(\d+)/', $lastIdTahunIni, $matches)) {
                $number = (int)$matches[1];
                $nextNumber = $number + 1;

                // Format dengan 5 digit
                $model->id_user = 'USER' . $tahun . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Fallback jika tidak cocok
                $model->id_user = 'USER' . $tahun . '00001';
            }
        });
    }
}
