<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'id_user',
        'email',
        'password',
        'no_hp',
        'level',
    ];

    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'string';
}
