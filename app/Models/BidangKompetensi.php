<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKompetensi extends Model
{
    use HasFactory;

    protected $table = 'bidang_kompetensi';
    protected $primaryKey = 'id_bidang_kompetensi';
    public $timestamps = true;
    
    protected $fillable = ['nama_bidang'];
}

