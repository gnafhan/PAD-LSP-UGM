<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IA02ProsesAssessment extends Model
{
    use HasFactory;

    protected $table = 'ia02_proses_assessments';

    protected $fillable = [
        'ia02_id',
        'nomor_proses',
        'judul_proses',
        'deskripsi_proses',
        'urutan'
    ];

    // Relationships
    public function ia02()
    {
        return $this->belongsTo(IA02::class, 'ia02_id');
    }

    public function instruksiKerjas()
    {
        return $this->hasMany(IA02InstruksiKerja::class, 'proses_assessment_id')->orderBy('nomor_urut');
    }
}
