<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fria05Jawaban extends Model
{
    use HasFactory;

    protected $table = 'fria05_jawaban';

    protected $fillable = [
        'fria05_id',
        'kode_soal',
        'jawaban'
    ];

    public function fria05(): BelongsTo
    {
        return $this->belongsTo(Fria05::class, 'fria05_id');
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class, 'kode_soal', 'kode_soal');
    }
}
