<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ak07BagianA extends Model
{
    use HasFactory;

    protected $table = 'ak07_bagian_a';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ak07_id',
        'item',
        'penyesuaian'
    ];

    /**
     * Get the AK01 record that owns this item.
     */
    public function ak07(): BelongsTo
    {
        return $this->belongsTo(Ak07::class, 'ak07_id');
    }
}
