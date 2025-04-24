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
     * Mendapatkan tanda tangan user (admin) yang valid pada waktu tertentu
     */
    public function getTandaTanganPadaWaktu($timestamp)
    {
        return $this->hasMany(TandaTanganAdmin::class, 'id_user', 'id_user')
            ->where('valid_from', '<=', $timestamp)
            ->where(function($query) use ($timestamp) {
                $query->where('valid_until', '>=', $timestamp)
                      ->orWhereNull('valid_until');
            })
            ->first();
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
