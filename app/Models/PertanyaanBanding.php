<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PertanyaanBanding extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_banding';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'pertanyaan',
        'order',
        'jenis_pertanyaan',
    ];

    public function jawaban_banding(): HasMany
    {
        return $this->hasMany(JawabanBanding::class, 'id_pertanyaan_banding', 'id');
    }
}
