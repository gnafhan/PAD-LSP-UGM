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

    public function content()
    {
        return $this->hasMany(IA02Content::class, 'ia02_id', 'id');
    }

    public function instruksiKerjaContent()
    {
        return $this->hasOne(IA02Content::class, 'ia02_id', 'id')
                    ->where('content_type', 'instruksi_kerja');
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
    
    // Accessor to get instruksi_kerja from content if available
    public function getInstruksiKerjaAttribute($value)
    {
        // If there's content for instruksi_kerja, return that instead
        $content = $this->instruksiKerjaContent;
        if ($content && !empty($content->html_content)) {
            return $content->html_content;
        }
        
        // Otherwise return the original field value
        return $value;
    }
    
    // Method to get plain text version of instruksi kerja
    public function getInstruksiKerjaPlainText()
    {
        $content = $this->instruksiKerjaContent;
        if ($content && !empty($content->text_content)) {
            return $content->text_content;
        }
        
        // Fallback to stripping HTML from the original field
        return strip_tags($this->attributes['instruksi_kerja'] ?? '');
    }
}
