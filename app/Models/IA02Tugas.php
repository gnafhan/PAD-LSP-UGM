<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IA02Tugas extends Model
{
    use HasFactory;

    protected $table = 'ia02_tugas';

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'id_skema',
        'judul_tugas',
        'jenis_evidence',
        'teks_jawaban',
        'link_eksternal',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'waktu_submit',
        'status',
        'catatan_asesor',
        'nilai',
        'metadata',
    ];

    protected $casts = [
        'waktu_submit' => 'datetime',
        'metadata' => 'array',
        'file_size' => 'integer',
        'nilai' => 'decimal:2',
    ];

    // Constants for evidence types
    const JENIS_EVIDENCE = [
        '1' => 'Teks Jawaban',
        '2' => 'Link Eksternal',
        '3' => 'Upload File',
    ];

    // Constants for status
    const STATUS = [
        'draft' => 'Draft',
        'submitted' => 'Submitted',
        'reviewed' => 'Reviewed',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    /**
     * Get the asesi that owns the task
     */
    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    /**
     * Get the asesor that owns the task
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    /**
     * Get the skema that owns the task
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Get human readable evidence type
     */
    public function getJenisEvidenceTextAttribute(): string
    {
        return self::JENIS_EVIDENCE[$this->jenis_evidence] ?? 'Unknown';
    }

    /**
     * Get human readable status
     */
    public function getStatusTextAttribute(): string
    {
        return self::STATUS[$this->status] ?? 'Unknown';
    }

    /**
     * Check if task has file attachment
     */
    public function hasFile(): bool
    {
        return $this->jenis_evidence === '3' && !empty($this->file_path);
    }

    /**
     * Get file URL if exists
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->hasFile()) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute(): ?string
    {
        if (!$this->file_size) {
            return null;
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope for filtering by evidence type
     */
    public function scopeByEvidenceType($query, $type)
    {
        return $query->where('jenis_evidence', $type);
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by asesi
     */
    public function scopeByAsesi($query, $id_asesi)
    {
        return $query->where('id_asesi', $id_asesi);
    }
}
