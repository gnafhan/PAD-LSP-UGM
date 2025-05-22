<?php
// filepath: app/Models/AsesiPengajuan.php

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
        'waktu_tanda_tangan',
        'id_admin',
        'alasan_penolakan',
        // Kolom baru untuk draft management
        'status',
        'revision_notes',
        'steps_completed',
        'sections_to_revise',
        'submitted_at'
    ];

    protected $casts = [
        'file_kelengkapan_pemohon' => 'array',
        'ttd_pemohon' => 'string',
        'sections_to_revise' => 'array',
        'submitted_at' => 'datetime',
        'waktu_tanda_tangan' => 'datetime',
    ];

    public $timestamps = true;

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_NEEDS_REVISION = 'needs_revision';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    const STATUS_REVISED_BY_ASESI = 'revised_by_asesi';


    // Step constants
    const STEP_DATA_PRIBADI = 1;
    const STEP_DATA_SERTIFIKASI = 2;
    const STEP_BUKTI_KELENGKAPAN = 3;
    const STEP_KONFIRMASI = 4;

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($model) {
            // Menentukan prefix sesuai dengan nama model
            $prefix = 'PENGAJUAN';
            
            // Mendapatkan nama kolom ID
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
    
    // Helper methods
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }
    
    public function needsRevision()
    {
        return $this->status === self::STATUS_NEEDS_REVISION;
    }
    
    public function isSubmitted()
    {
        return $this->status === self::STATUS_SUBMITTED;
    }
    
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }
    
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }
    
    public function updateStepCompleted($step)
    {
        if ($step > $this->steps_completed) {
            $this->steps_completed = $step;
            $this->save();
        }
    }
    
    public function needsRevisionForStep($step)
    {
        if (!$this->sections_to_revise) {
            return false;
        }
        
        return in_array($step, $this->sections_to_revise);
    }

    //admin has one
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }
}