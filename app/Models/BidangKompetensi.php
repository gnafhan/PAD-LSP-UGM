<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class BidangKompetensi extends Model
{
    use HasFactory;

    protected $table = 'bidang_kompetensi';
    protected $primaryKey = 'id_bidang_kompetensi';
    public $timestamps = true;
    
    protected $fillable = ['nama_bidang'];

    /**
     * Create a new bidang kompetensi with validation
     */
    public static function createBidangKompetensi($namaBidang)
    {
        $validator = Validator::make(['nama_bidang' => $namaBidang], [
            'nama_bidang' => 'required|string|max:255|unique:bidang_kompetensi,nama_bidang'
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return self::create(['nama_bidang' => $namaBidang]);
    }

    /**
     * Get all bidang kompetensi ordered by name
     */
    public static function getAllOrdered()
    {
        return self::orderBy('nama_bidang')->get();
    }
}

