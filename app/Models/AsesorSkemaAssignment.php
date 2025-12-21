<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * AsesorSkemaAssignment Model
 * 
 * Stores which schemes are assigned to each asesor for access control.
 * Only admin can create/delete assignments.
 * 
 * Requirements: 3.2, 3.3
 */
class AsesorSkemaAssignment extends Model
{
    use HasFactory;

    protected $table = 'asesor_skema_assignment';

    protected $fillable = [
        'id_asesor',
        'id_skema',
        'assigned_by',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    /**
     * Relationship to Asesor
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    /**
     * Relationship to Skema
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Relationship to User who assigned (admin)
     */
    public function assignedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id_user');
    }

    /**
     * Scope to get assignments for a specific asesor
     */
    public function scopeForAsesor(Builder $query, string $idAsesor): Builder
    {
        return $query->where('id_asesor', $idAsesor);
    }

    /**
     * Scope to get assignments for a specific skema
     */
    public function scopeForSkema(Builder $query, string $idSkema): Builder
    {
        return $query->where('id_skema', $idSkema);
    }

    /**
     * Scope to get assignments by a specific admin
     */
    public function scopeAssignedBy(Builder $query, string $assignedBy): Builder
    {
        return $query->where('assigned_by', $assignedBy);
    }

    /**
     * Check if an asesor is assigned to a specific skema
     */
    public static function isAssigned(string $idAsesor, string $idSkema): bool
    {
        return self::where('id_asesor', $idAsesor)
            ->where('id_skema', $idSkema)
            ->exists();
    }

    /**
     * Get all skema IDs assigned to an asesor
     */
    public static function getAssignedSkemaIds(string $idAsesor): array
    {
        return self::where('id_asesor', $idAsesor)
            ->pluck('id_skema')
            ->toArray();
    }

    /**
     * Get all asesor IDs assigned to a skema
     */
    public static function getAssignedAsesorIds(string $idSkema): array
    {
        return self::where('id_skema', $idSkema)
            ->pluck('id_asesor')
            ->toArray();
    }

    /**
     * Boot method to set default assigned_at timestamp
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (AsesorSkemaAssignment $assignment) {
            if (empty($assignment->assigned_at)) {
                $assignment->assigned_at = now();
            }
        });
    }
}
