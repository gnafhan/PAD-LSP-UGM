<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ak01HasilItem extends Model
{
    use HasFactory;

    protected $table = 'ak01_hasil_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ak01_id',
        'hasil_item'
    ];

    /**
     * Get the AK01 record that owns this item.
     */
    public function ak01(): BelongsTo
    {
        return $this->belongsTo(Ak01::class, 'ak01_id');
    }
}