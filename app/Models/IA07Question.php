<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * IA07Question Model
 * 
 * Stores scheme-specific oral questions for IA07.
 * Questions are organized by unit kompetensi and elemen UK.
 * 
 * Requirements: 3.1, 3.2
 */
class IA07Question extends Model
{
    use HasFactory;

    protected $table = 'ia07_questions';

    protected $fillable = [
        'id_skema',
        'id_uk',
        'id_elemen_uk',
        'pertanyaan',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the scheme that owns this question.
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Get the unit kompetensi for this question.
     */
    public function unitKompetensi(): BelongsTo
    {
        return $this->belongsTo(UK::class, 'id_uk', 'id_uk');
    }

    /**
     * Get the elemen UK for this question.
     */
    public function elemenUK(): BelongsTo
    {
        return $this->belongsTo(ElemenUK::class, 'id_elemen_uk', 'id_elemen_uk');
    }

    /**
     * Scope to get active questions only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by display_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    /**
     * Scope to get questions for a specific scheme.
     */
    public function scopeForSkema($query, string $idSkema)
    {
        return $query->where('id_skema', $idSkema);
    }

    /**
     * Scope to get questions for a specific UK.
     */
    public function scopeForUK($query, string $idUk)
    {
        return $query->where('id_uk', $idUk);
    }

    /**
     * Scope to get questions for a specific elemen UK.
     */
    public function scopeForElemenUK($query, int $idElemenUk)
    {
        return $query->where('id_elemen_uk', $idElemenUk);
    }
}
