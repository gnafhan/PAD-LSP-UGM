<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IA02InstruksiKerja extends Model
{
    use HasFactory;

    protected $table = 'ia02_instruksi_kerjas';

    protected $fillable = [
        'proses_assessment_id',
        'nomor_urut',
        'instruksi_kerja',
        'standar_alat_media',
        'output_yang_diharapkan'
    ];

    // Relationships
    public function prosesAssessment()
    {
        return $this->belongsTo(IA02ProsesAssessment::class, 'proses_assessment_id');
    }
}
