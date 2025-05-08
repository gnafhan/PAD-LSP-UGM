<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TandaTanganAdmin extends Model
{
    use HasFactory;
    
    protected $table = 'tanda_tangan_admin';
    
    protected $fillable = [
        'id_user',
        'file_tanda_tangan',
        'valid_from',
        'valid_until',
    ];
    
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
