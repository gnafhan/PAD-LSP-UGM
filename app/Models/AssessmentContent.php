<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * AssessmentContent Model
 * 
 * Stores dynamic assessment content (questions, tasks) that are specific
 * to each certification scheme.
 * 
 * Requirements: 4.1, 4.2
 */
class AssessmentContent extends Model
{
    use HasFactory;

    protected $table = 'assessment_content';

    protected $fillable = [
        'id_skema',
        'assessment_type',
        'content_type',
        'content_data',
        'created_by',
        'display_order',
    ];

    protected $casts = [
        'content_data' => 'array',
        'display_order' => 'integer',
    ];

    /**
     * Available content types
     */
    public const CONTENT_TYPES = [
        'multiple_choice',
        'essay',
        'practical_task',
        'checklist',
        'document_upload',
        'observation',
    ];

    /**
     * Assessment types that can have dynamic content
     */
    public const CONTENT_ASSESSMENT_TYPES = [
        'IA02', 'IA05', 'IA07', 'IA11',
        'AK01', 'AK02', 'AK07',
        'MAPA01', 'MAPA02',
    ];

    /**
     * Relationship to Skema
     */
    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Relationship to User who created the content
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    /**
     * Scope to get content for a specific scheme
     */
    public function scopeForSkema(Builder $query, string $idSkema): Builder
    {
        return $query->where('id_skema', $idSkema);
    }

    /**
     * Scope to get content for a specific assessment type
     */
    public function scopeForAssessmentType(Builder $query, string $assessmentType): Builder
    {
        return $query->where('assessment_type', $assessmentType);
    }

    /**
     * Scope to get content for a specific content type
     */
    public function scopeForContentType(Builder $query, string $contentType): Builder
    {
        return $query->where('content_type', $contentType);
    }

    /**
     * Scope to get content by scheme and assessment type
     */
    public function scopeBySchemeAndType(Builder $query, string $idSkema, string $assessmentType): Builder
    {
        return $query->where('id_skema', $idSkema)
            ->where('assessment_type', $assessmentType);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order', 'asc');
    }

    /**
     * Check if the content type is valid
     */
    public static function isValidContentType(string $contentType): bool
    {
        return \in_array($contentType, self::CONTENT_TYPES, true);
    }

    /**
     * Check if the assessment type can have dynamic content
     */
    public static function isValidAssessmentType(string $assessmentType): bool
    {
        return \in_array($assessmentType, self::CONTENT_ASSESSMENT_TYPES, true);
    }

    /**
     * Get content for a specific scheme and assessment type
     */
    public static function getContentForScheme(string $idSkema, string $assessmentType): \Illuminate\Database\Eloquent\Collection
    {
        return self::bySchemeAndType($idSkema, $assessmentType)
            ->ordered()
            ->get();
    }

    /**
     * Get all content for a scheme
     */
    public static function getAllContentForScheme(string $idSkema): \Illuminate\Database\Eloquent\Collection
    {
        return self::forSkema($idSkema)
            ->ordered()
            ->get();
    }
}
