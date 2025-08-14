<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ak03Penilaian extends Model
{
    use HasFactory;

    protected $table = 'ak03_penilaian';

    protected $fillable = [
        'ak03_id',
        'id_kuk',
        'keputusan',
    ];

    public function ak03(): BelongsTo
    {
        return $this->belongsTo(Ak03::class, 'ak03_id');
    }
}
