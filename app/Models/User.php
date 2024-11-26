<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    // use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'email',
        'password',
        'no_hp',
        'level',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_user');
            $number = $lastId ? intval(substr($lastId, 4)) + 1 : 1;
            $model->id_user = 'USER' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }

}
