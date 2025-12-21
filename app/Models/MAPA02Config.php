<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MAPA02Config Model
 * 
 * Stores scheme-specific MUK checklist and default potensi configuration for MAPA02.
 * 
 * Requirements: 5.1
 */
class MAPA02Config extends Model
{
    use HasFactory;

    protected $table = 'mapa02_configs';

    protected $fillable = [
        'id_skema',
        'muk_items',
        'default_potensi',
    ];

    protected $casts = [
        'muk_items' => 'array',
        'default_potensi' => 'array',
    ];

    /**
     * Get the scheme that owns this config.
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Scope to get config for a specific scheme.
     */
    public function scopeForSkema($query, string $idSkema)
    {
        return $query->where('id_skema', $idSkema);
    }

    /**
     * Get enabled MUK items.
     */
    public function getEnabledMukItems(): array
    {
        if (!$this->muk_items) {
            return [];
        }

        return array_filter($this->muk_items, fn($item) => $item['enabled'] ?? false);
    }

    /**
     * Check if a specific MUK item is enabled.
     */
    public function isMukItemEnabled(string $mukCode): bool
    {
        if (!$this->muk_items) {
            return true; // Default to enabled if no config
        }

        foreach ($this->muk_items as $item) {
            if (($item['code'] ?? '') === $mukCode) {
                return $item['enabled'] ?? true;
            }
        }

        return true; // Default to enabled if not found
    }

    /**
     * Get default potensi value for a specific UK.
     */
    public function getDefaultPotensi(string $idUk): ?string
    {
        if (!$this->default_potensi) {
            return null;
        }

        return $this->default_potensi[$idUk] ?? null;
    }
}
