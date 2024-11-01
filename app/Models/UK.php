<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UK extends Model
{
    use HasFactory;

    protected $table = 'uk';

    protected $primaryKey = 'id_uk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_uk',
        'nama_uk',
        'id_bidang',
    ];

    // Relasi ke model UkBidang
    public function bidang()
    {
        return $this->belongsTo(UkBidang::class, 'id_bidang');
    }
}
