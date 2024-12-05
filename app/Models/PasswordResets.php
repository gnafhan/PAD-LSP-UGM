<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    use HasFactory;

    protected $table = 'password_Resets';

    protected $fillable = [
        'id_password_resets',
        'id_user',
        'email',
        'token',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastId = self::max('id_password_resets');
            $number = $lastId ? intval(substr($lastId, 10)) + 1 : 1;
            $model->id_password_resets = 'PWD_RESETS' . str_pad($number, 1, '0', STR_PAD_LEFT);
        });
    }
}
