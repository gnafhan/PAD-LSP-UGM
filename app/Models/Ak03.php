<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ak03 extends Model
{
    use HasFactory;

    protected $table = 'ak03';

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'waktu_tanda_tangan_asesi',
        'general_feedback',
    ];

    protected $casts = [
        'waktu_tanda_tangan_asesi' => 'datetime',
    ];

    /**
     * Get the asesi that owns the feedback.
     */
    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    /**
     * Get the asesor associated with the feedback.
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    /**
     * Get all of the feedback items for the Ak03 record.
     */
    public function umpanBalikItems(): HasMany
    {
        return $this->hasMany(Ak03UmpanBalikItem::class, 'ak03_id');
    }
}