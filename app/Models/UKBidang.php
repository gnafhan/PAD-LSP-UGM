<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UKBidang extends Model
{
    use HasFactory;

    protected $table = 'uk_bidang';
    protected $primaryKey = 'id_bidang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_bidang', 'nama_bidang'];
}
