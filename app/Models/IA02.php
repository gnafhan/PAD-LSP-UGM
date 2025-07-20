<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IA02 extends Model
{
    use HasFactory;

    protected $table = 'ia02';

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'id_skema',
        'judul_sertifikasi',
        'nomor_sertifikasi',
        'nama_peserta',
        'nama_asesor',
        'tuk',
        'instruksi_kerja',
        'waktu_tanda_tangan_asesor',
        'waktu_tanda_tangan_asesi',
        'ttd_asesor',
        'ttd_asesi',
        'status',
        'catatan'
    ];

    protected $casts = [
        'waktu_tanda_tangan_asesor' => 'datetime',
        'waktu_tanda_tangan_asesi' => 'datetime',
    ];

    // Relationships
    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }



    public function kompetensis()
    {
        return $this->hasMany(IA02Kompetensi::class, 'ia02_id');
    }

    public function prosesAssessments()
    {
        return $this->hasMany(IA02ProsesAssessment::class, 'ia02_id')->orderBy('nomor_proses');
    }

    // Helper methods
    public function isAsesorSigned()
    {
        return !is_null($this->waktu_tanda_tangan_asesor) && !is_null($this->ttd_asesor);
    }

    public function isAsesiSigned()
    {
        return !is_null($this->waktu_tanda_tangan_asesi) && !is_null($this->ttd_asesi);
    }

    public function isCompleted()
    {
        return $this->isAsesorSigned() && $this->isAsesiSigned();
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
            'submitted' => 'Disubmit',
            'approved' => 'Disetujui',
            'completed' => 'Selesai'
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }
}
