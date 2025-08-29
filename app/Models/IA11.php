<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IA11 extends Model
{
    use HasFactory;

    protected $table = 'ia11';

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'id_skema',
        'judul_sertifikasi',
        'nama_peserta',
        'nama_asesor',
        'kegiatan_data',
        'komentar_all',
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
        'kegiatan_data' => 'json',
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

    /**
     * Get TUK through asesi->rincianAsesmen->event->tuk relationship
     */
    public function getTukAttribute()
    {
        // Try to get TUK through asesi relationship
        if ($this->asesi && $this->asesi->rincianAsesmen && 
            $this->asesi->rincianAsesmen->event && $this->asesi->rincianAsesmen->event->tuk) {
            return $this->asesi->rincianAsesmen->event->tuk->nama_tuk;
        }
        
        // Fallback to default
        return 'LSP Politeknik Negeri Malang';
    }

    /**
     * Get nomor_skema through skema relationship
     */
    public function getNomorSkemaAttribute()
    {
        return $this->skema ? $this->skema->nomor_skema : null;
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
