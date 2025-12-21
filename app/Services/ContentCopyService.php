<?php

namespace App\Services;

use App\Models\IA02Template;
use App\Models\IA07Question;
use App\Models\IA11Checklist;
use App\Models\MAPA01Config;
use App\Models\MAPA02Config;
use App\Models\Skema;
use App\Models\Soal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * ContentCopyService
 * 
 * Service for copying assessment content between schemes.
 * 
 * Requirements: 9.1, 9.2
 */
class ContentCopyService
{
    protected SchemeContentService $schemeContentService;

    public function __construct(SchemeContentService $schemeContentService)
    {
        $this->schemeContentService = $schemeContentService;
    }

    /**
     * Get schemes that have at least one type of content.
     * Requirements: 9.1
     */
    public function getSchemesWithContent(): Collection
    {
        return Skema::all()->filter(function ($scheme) {
            return $this->schemeContentService->hasContent($scheme->id_skema);
        })->values();
    }

    /**
     * Copy all content from source to target scheme.
     * Requirements: 9.2
     * 
     * @return array Summary of copied content
     */
    public function copyAllContent(string $sourceSkema, string $targetSkema, bool $overwrite = false): array
    {
        // Validate source has content
        if (!$this->schemeContentService->hasContent($sourceSkema)) {
            throw new \InvalidArgumentException('Skema sumber tidak memiliki konten');
        }

        // Check if target has content and overwrite is not allowed
        if (!$overwrite && $this->schemeContentService->hasContent($targetSkema)) {
            throw new \InvalidArgumentException('Skema target sudah memiliki konten. Konfirmasi untuk menimpa.');
        }

        return DB::transaction(function () use ($sourceSkema, $targetSkema, $overwrite) {
            $summary = [
                'ia05_copied' => 0,
                'ia02_copied' => false,
                'ia07_copied' => 0,
                'mapa01_copied' => false,
                'mapa02_copied' => false,
                'ia11_copied' => 0,
            ];

            // Clear existing content if overwriting
            if ($overwrite) {
                $this->clearContent($targetSkema);
            }

            // Copy each content type
            $summary['ia05_copied'] = $this->copyIA05Content($sourceSkema, $targetSkema);
            $summary['ia02_copied'] = $this->copyIA02Content($sourceSkema, $targetSkema);
            $summary['ia07_copied'] = $this->copyIA07Content($sourceSkema, $targetSkema);
            $summary['mapa01_copied'] = $this->copyMAPAConfig($sourceSkema, $targetSkema, 'mapa01');
            $summary['mapa02_copied'] = $this->copyMAPAConfig($sourceSkema, $targetSkema, 'mapa02');
            $summary['ia11_copied'] = $this->copyIA11Content($sourceSkema, $targetSkema);

            return $summary;
        });
    }

    /**
     * Copy IA05 questions from source to target scheme.
     * Requirements: 9.2
     * 
     * @return int Number of questions copied
     */
    public function copyIA05Content(string $sourceSkema, string $targetSkema): int
    {
        $sourceQuestions = Soal::forSkema($sourceSkema)->ordered()->get();
        $copiedCount = 0;

        foreach ($sourceQuestions as $question) {
            Soal::create([
                'id_skema' => $targetSkema,
                'pertanyaan' => $question->pertanyaan,
                'jawaban_a' => $question->jawaban_a,
                'jawaban_b' => $question->jawaban_b,
                'jawaban_c' => $question->jawaban_c,
                'jawaban_d' => $question->jawaban_d,
                'jawaban_e' => $question->jawaban_e,
                'jawaban_benar' => $question->jawaban_benar,
                'display_order' => $question->display_order,
            ]);
            $copiedCount++;
        }

        return $copiedCount;
    }

    /**
     * Copy IA02 template from source to target scheme.
     * Requirements: 9.2
     * 
     * @return bool Whether template was copied
     */
    public function copyIA02Content(string $sourceSkema, string $targetSkema): bool
    {
        $sourceTemplate = IA02Template::forSkema($sourceSkema)->first();

        if (!$sourceTemplate) {
            return false;
        }

        IA02Template::create([
            'id_skema' => $targetSkema,
            'instruksi_kerja' => $sourceTemplate->instruksi_kerja,
            'is_default' => false,
        ]);

        return true;
    }

    /**
     * Copy IA07 questions from source to target scheme.
     * Note: UK and ElemenUK associations may not be valid for target scheme.
     * Requirements: 9.2
     * 
     * @return int Number of questions copied
     */
    public function copyIA07Content(string $sourceSkema, string $targetSkema): int
    {
        $sourceQuestions = IA07Question::forSkema($sourceSkema)->ordered()->get();
        $copiedCount = 0;

        // Get target scheme's UK list
        $targetScheme = Skema::findOrFail($targetSkema);
        $targetUkIds = is_array($targetScheme->daftar_id_uk) 
            ? $targetScheme->daftar_id_uk 
            : json_decode($targetScheme->daftar_id_uk, true) ?? [];

        foreach ($sourceQuestions as $question) {
            // Only copy if UK exists in target scheme
            if (in_array($question->id_uk, $targetUkIds)) {
                IA07Question::create([
                    'id_skema' => $targetSkema,
                    'id_uk' => $question->id_uk,
                    'id_elemen_uk' => $question->id_elemen_uk,
                    'pertanyaan' => $question->pertanyaan,
                    'display_order' => $question->display_order,
                    'is_active' => $question->is_active,
                ]);
                $copiedCount++;
            }
        }

        return $copiedCount;
    }

    /**
     * Copy MAPA config from source to target scheme.
     * Requirements: 9.2
     * 
     * @return bool Whether config was copied
     */
    public function copyMAPAConfig(string $sourceSkema, string $targetSkema, string $type = 'mapa01'): bool
    {
        if ($type === 'mapa01') {
            $sourceConfig = MAPA01Config::forSkema($sourceSkema)->first();
            
            if (!$sourceConfig) {
                return false;
            }

            MAPA01Config::create([
                'id_skema' => $targetSkema,
                'config_data' => $sourceConfig->config_data,
            ]);

            return true;
        }

        if ($type === 'mapa02') {
            $sourceConfig = MAPA02Config::forSkema($sourceSkema)->first();
            
            if (!$sourceConfig) {
                return false;
            }

            MAPA02Config::create([
                'id_skema' => $targetSkema,
                'muk_items' => $sourceConfig->muk_items,
                'default_potensi' => $sourceConfig->default_potensi,
            ]);

            return true;
        }

        return false;
    }

    /**
     * Copy IA11 checklist items from source to target scheme.
     * Requirements: 9.2
     * 
     * @return int Number of items copied
     */
    public function copyIA11Content(string $sourceSkema, string $targetSkema): int
    {
        $sourceItems = IA11Checklist::forSkema($sourceSkema)->ordered()->get();
        $copiedCount = 0;

        foreach ($sourceItems as $item) {
            IA11Checklist::create([
                'id_skema' => $targetSkema,
                'item_name' => $item->item_name,
                'description' => $item->description,
                'verification_criteria' => $item->verification_criteria,
                'display_order' => $item->display_order,
                'is_required' => $item->is_required,
            ]);
            $copiedCount++;
        }

        return $copiedCount;
    }

    /**
     * Clear all content for a scheme.
     */
    protected function clearContent(string $idSkema): void
    {
        Soal::forSkema($idSkema)->delete();
        IA02Template::forSkema($idSkema)->delete();
        IA07Question::forSkema($idSkema)->delete();
        MAPA01Config::forSkema($idSkema)->delete();
        MAPA02Config::forSkema($idSkema)->delete();
        IA11Checklist::forSkema($idSkema)->delete();
    }
}
