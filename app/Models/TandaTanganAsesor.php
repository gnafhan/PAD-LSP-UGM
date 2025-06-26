<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TandaTanganAsesor extends Model
{
    use HasFactory;
    
    protected $table = 'tanda_tangan_asesor';
    
    protected $fillable = [
        'id_asesor',
        'file_tanda_tangan',
        'valid_from',
        'valid_until',
    ];
    
    protected $dates = [
        'valid_from',
        'valid_until',
    ];
    
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
}