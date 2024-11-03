<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apl02 extends Model
{
    use HasFactory;

    protected $table = 'apl02';

    protected $primaryKey = 'id_apl02';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_apl02',
        'id_uk',
    ];

    // Relasi ke model UK
    public function uk()
    {
        return $this->belongsTo(UK::class, 'id_uk');
    }
}
