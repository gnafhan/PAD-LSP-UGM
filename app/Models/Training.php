<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'start_date', 'end_date', 
        'capacity', 'instructor_id'
    ];
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
        //Relasi many to one ke tabel instructors
    }
}


