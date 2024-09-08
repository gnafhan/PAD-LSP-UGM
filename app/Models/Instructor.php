<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email'];
    public function trainings()
    {
        return $this->hasMany(Training::class);
        //Relasi one to many ke tabel trainings
    }
}


