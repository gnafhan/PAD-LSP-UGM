<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenanggungJawab extends Model
{
    use HasFactory;

    protected $table = 'penanggung_jawab';
    protected $primaryKey = 'id_penanggung_jawab';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penanggung_jawab',
        'nama_penanggung_jawab',
        'status_penanggung_jawab',
    ];
}
