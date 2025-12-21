<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * IA02Template Model
 * 
 * Stores scheme-specific work instruction templates for IA02.
 * Each scheme can have one template with rich text content.
 * 
 * Requirements: 2.1
 */
class IA02Template extends Model
{
    use HasFactory;

    protected $table = 'ia02_templates';

    protected $fillable = [
        'id_skema',
        'instruksi_kerja',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the scheme that owns this template.
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Scope to get default templates.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope to get template for a specific scheme.
     */
    public function scopeForSkema($query, string $idSkema)
    {
        return $query->where('id_skema', $idSkema);
    }
}
