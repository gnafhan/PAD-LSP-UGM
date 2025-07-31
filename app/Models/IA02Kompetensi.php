<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IA02Kompetensi extends Model
{
    use HasFactory;

    protected $table = 'ia02_kompetensis';

    protected $fillable = [
        'ia02_id',
        'id_uk',
        'kode_uk',
        'nama_uk',
        'deskripsi_kompetensi',
        'urutan'
    ];

    // Relationships
    public function ia02()
    {
        return $this->belongsTo(IA02::class, 'ia02_id');
    }

    public function uk()
    {
        return $this->belongsTo(UK::class, 'id_uk', 'id_uk');
    }
}
