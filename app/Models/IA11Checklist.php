<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * IA11Checklist Model
 * 
 * Stores scheme-specific portfolio verification checklist items for IA11.
 * 
 * Requirements: 6.1
 */
class IA11Checklist extends Model
{
    use HasFactory;

    protected $table = 'ia11_checklists';

    protected $fillable = [
        'id_skema',
        'item_name',
        'description',
        'verification_criteria',
        'display_order',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the scheme that owns this checklist item.
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Scope to get required items only.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    /**
     * Scope to order by display_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    /**
     * Scope to get items for a specific scheme.
     */
    public function scopeForSkema($query, string $idSkema)
    {
        return $query->where('id_skema', $idSkema);
    }
}
