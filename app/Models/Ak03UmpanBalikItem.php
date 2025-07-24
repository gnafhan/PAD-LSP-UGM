<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ak03UmpanBalikItem extends Model
{
    use HasFactory;

    protected $table = 'ak03_umpan_balik_items';

    protected $fillable = [
        'ak03_id',
        'komponen_id',
        'hasil',
        'catatan',
    ];

    /**
     * Get the Ak03 record that owns the item.
     */
    public function ak03(): BelongsTo
    {
        return $this->belongsTo(Ak03::class, 'ak03_id');
    }
}
