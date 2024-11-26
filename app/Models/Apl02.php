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

    public function uk()
    {
        return $this->belongsTo(UK::class, 'id_uk', 'id_uk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_apl02');
            $number = $lastId ? intval(substr($lastId, 6)) + 1 : 1;
            $model->id_apl02 = 'APL02_' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
