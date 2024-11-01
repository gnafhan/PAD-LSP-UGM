<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema';

    protected $primaryKey = 'id_skema';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_skema',
        'nomor_skema',
        'nama_skema',
        'dokumen_skkni',
        'persyaratan_skema',
    ];
}
