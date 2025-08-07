<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ak02KetentuanKompetensi extends Model
{
    use HasFactory;

    protected $table = 'ak02_ketentuan_kompetensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ak02_id',
        'item',
        'bukti'
    ];

    /**
     * Get the AK01 record that owns this item.
     */
    public function ak02(): BelongsTo
    {
        return $this->belongsTo(Ak02::class, 'ak02_id');
    }
}
