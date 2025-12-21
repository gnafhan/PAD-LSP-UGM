<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MAPA01Config Model
 * 
 * Stores scheme-specific configuration for MAPA01 assessment planning.
 * Contains default pendekatan asesmen options.
 * 
 * Requirements: 4.1
 */
class MAPA01Config extends Model
{
    use HasFactory;

    protected $table = 'mapa01_configs';

    protected $fillable = [
        'id_skema',
        'config_data',
    ];

    protected $casts = [
        'config_data' => 'array',
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
     * Get a specific config value by key.
     */
    public function getConfigValue(string $key, $default = null)
    {
        return data_get($this->config_data, $key, $default);
    }

    /**
     * Set a specific config value by key.
     */
    public function setConfigValue(string $key, $value): void
    {
        $config = $this->config_data ?? [];
        data_set($config, $key, $value);
        $this->config_data = $config;
    }
}
