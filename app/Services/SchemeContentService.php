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
 * SchemeContentService
 * 
 * Service for managing scheme-specific assessment content.
 * Handles CRUD operations for IA05, IA02, IA07, MAPA01, MAPA02, and IA11 content.
 * 
 * Requirements: 1.1-1.5, 2.1-2.4, 3.1-3.4, 4.1-4.3, 5.1-5.3, 6.1-6.4, 7.1
 */
class SchemeContentService
{
    // ========================================
    // IA05 - Multiple Choice Questions
    // ========================================

    /**
     * Get all IA05 questions for a scheme.
     * Requirements: 1.1
     */
    public function getIA05Questions(string $idSkema): Collection
    {
        return Soal::forSkema($idSkema)
            ->ordered()
            ->get();
    }

    /**
     * Create a new IA05 question.
     * Requirements: 1.2
     */
    public function createIA05Question(string $idSkema, array $data): Soal
    {
        $this->validateIA05QuestionData($data);

        // Get next display order
        $maxOrder = Soal::forSkema($idSkema)->max('display_order') ?? -1;

        return Soal::create([
            'id_skema' => $idSkema,
            'pertanyaan' => $data['pertanyaan'],
            'jawaban_a' => $data['jawaban_a'] ?? null,
            'jawaban_b' => $data['jawaban_b'] ?? null,
            'jawaban_c' => $data['jawaban_c'] ?? null,
            'jawaban_d' => $data['jawaban_d'] ?? null,
            'jawaban_e' => $data['jawaban_e'] ?? null,
            'jawaban_benar' => $data['jawaban_benar'],
            'display_order' => $maxOrder + 1,
        ]);
    }

    /**
     * Update an existing IA05 question.
     * Requirements: 1.3
     */
    public function updateIA05Question(string $kodeSoal, array $data): bool
    {
        $soal = Soal::findOrFail($kodeSoal);
        
        // Preserve scheme association
        unset($data['id_skema']);
        
        return $soal->update($data);
    }

    /**
     * Delete an IA05 question.
     * Requirements: 1.4
     */
    public function deleteIA05Question(string $kodeSoal): bool
    {
        $soal = Soal::findOrFail($kodeSoal);
        return $soal->delete();
    }

    /**
     * Reorder IA05 questions.
     * Requirements: 1.5
     */
    public function reorderIA05Questions(string $idSkema, array $order): bool
    {
        return DB::transaction(function () use ($idSkema, $order) {
            foreach ($order as $index => $kodeSoal) {
                Soal::where('kode_soal', $kodeSoal)
                    ->where('id_skema', $idSkema)
                    ->update(['display_order' => $index]);
            }
            return true;
        });
    }

    /**
     * Validate IA05 question data.
     * Requirements: 1.2
     */
    protected function validateIA05QuestionData(array $data): void
    {
        if (empty($data['pertanyaan'])) {
            throw new \InvalidArgumentException('Pertanyaan tidak boleh kosong');
        }

        // Count non-empty answer options
        $answerOptions = ['jawaban_a', 'jawaban_b', 'jawaban_c', 'jawaban_d', 'jawaban_e'];
        $filledOptions = 0;
        foreach ($answerOptions as $option) {
            if (!empty($data[$option])) {
                $filledOptions++;
            }
        }

        if ($filledOptions < 2) {
            throw new \InvalidArgumentException('Minimal 2 opsi jawaban harus diisi');
        }

        if (empty($data['jawaban_benar'])) {
            throw new \InvalidArgumentException('Jawaban benar harus dipilih');
        }

        // Validate correct answer is one of the filled options
        $correctAnswer = strtolower($data['jawaban_benar']);
        $validAnswers = ['a', 'b', 'c', 'd', 'e'];
        if (!in_array($correctAnswer, $validAnswers)) {
            throw new \InvalidArgumentException('Jawaban benar harus dipilih dari opsi yang tersedia');
        }

        $answerKey = 'jawaban_' . $correctAnswer;
        if (empty($data[$answerKey])) {
            throw new \InvalidArgumentException('Jawaban benar harus dipilih dari opsi yang tersedia');
        }
    }

    // ========================================
    // IA02 - Work Instructions
    // ========================================

    /**
     * Get IA02 template for a scheme.
     * Requirements: 2.1
     */
    public function getIA02Template(string $idSkema): ?IA02Template
    {
        return IA02Template::forSkema($idSkema)->first();
    }

    /**
     * Save IA02 template for a scheme.
     * Requirements: 2.2, 2.4
     */
    public function saveIA02Template(string $idSkema, string $content): IA02Template
    {
        return IA02Template::updateOrCreate(
            ['id_skema' => $idSkema],
            ['instruksi_kerja' => $content]
        );
    }

    // ========================================
    // IA07 - Oral Questions
    // ========================================

    /**
     * Get all IA07 questions for a scheme.
     * Requirements: 3.1
     */
    public function getIA07Questions(string $idSkema): Collection
    {
        return IA07Question::forSkema($idSkema)
            ->active()
            ->ordered()
            ->with(['unitKompetensi', 'elemenUK'])
            ->get();
    }

    /**
     * Get IA07 questions grouped by UK and elemen.
     * Requirements: 3.1
     */
    public function getIA07QuestionsGrouped(string $idSkema): Collection
    {
        return $this->getIA07Questions($idSkema)
            ->groupBy('id_uk')
            ->map(function ($ukQuestions) {
                return $ukQuestions->groupBy('id_elemen_uk');
            });
    }

    /**
     * Create a new IA07 question.
     * Requirements: 3.2
     */
    public function createIA07Question(string $idSkema, array $data): IA07Question
    {
        $this->validateIA07QuestionData($idSkema, $data);

        // Get next display order for this elemen
        $maxOrder = IA07Question::forSkema($idSkema)
            ->forElemenUK($data['id_elemen_uk'])
            ->max('display_order') ?? -1;

        return IA07Question::create([
            'id_skema' => $idSkema,
            'id_uk' => $data['id_uk'],
            'id_elemen_uk' => $data['id_elemen_uk'],
            'pertanyaan' => $data['pertanyaan'],
            'display_order' => $maxOrder + 1,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Update an existing IA07 question.
     * Requirements: 3.3
     */
    public function updateIA07Question(int $id, array $data): bool
    {
        $question = IA07Question::findOrFail($id);
        
        // Preserve scheme association
        unset($data['id_skema']);
        
        return $question->update($data);
    }

    /**
     * Delete an IA07 question.
     * Requirements: 3.4
     */
    public function deleteIA07Question(int $id): bool
    {
        $question = IA07Question::findOrFail($id);
        return $question->delete();
    }

    /**
     * Validate IA07 question data.
     */
    protected function validateIA07QuestionData(string $idSkema, array $data): void
    {
        if (empty($data['pertanyaan'])) {
            throw new \InvalidArgumentException('Pertanyaan tidak boleh kosong');
        }

        if (empty($data['id_uk'])) {
            throw new \InvalidArgumentException('Unit kompetensi harus dipilih');
        }

        if (empty($data['id_elemen_uk'])) {
            throw new \InvalidArgumentException('Elemen UK harus dipilih');
        }

        // Validate UK belongs to scheme
        $skema = Skema::findOrFail($idSkema);
        $ukIds = is_array($skema->daftar_id_uk) ? $skema->daftar_id_uk : json_decode($skema->daftar_id_uk, true);
        
        if (!in_array($data['id_uk'], $ukIds ?? [])) {
            throw new \InvalidArgumentException('Unit kompetensi tidak valid untuk skema ini');
        }
    }

    // ========================================
    // MAPA01 - Assessment Planning Config
    // ========================================

    /**
     * Get MAPA01 config for a scheme.
     * Requirements: 4.1
     */
    public function getMAPA01Config(string $idSkema): ?MAPA01Config
    {
        return MAPA01Config::forSkema($idSkema)->first();
    }

    /**
     * Save MAPA01 config for a scheme.
     * Requirements: 4.2
     */
    public function saveMAPA01Config(string $idSkema, array $config): MAPA01Config
    {
        return MAPA01Config::updateOrCreate(
            ['id_skema' => $idSkema],
            ['config_data' => $config]
        );
    }

    // ========================================
    // MAPA02 - Assessment Instrument Config
    // ========================================

    /**
     * Get MAPA02 config for a scheme.
     * Requirements: 5.1
     */
    public function getMAPA02Config(string $idSkema): ?MAPA02Config
    {
        return MAPA02Config::forSkema($idSkema)->first();
    }

    /**
     * Save MAPA02 config for a scheme.
     * Requirements: 5.2, 5.3
     */
    public function saveMAPA02Config(string $idSkema, array $config): MAPA02Config
    {
        return MAPA02Config::updateOrCreate(
            ['id_skema' => $idSkema],
            [
                'muk_items' => $config['muk_items'] ?? null,
                'default_potensi' => $config['default_potensi'] ?? null,
            ]
        );
    }

    // ========================================
    // IA11 - Portfolio Checklist
    // ========================================

    /**
     * Get all IA11 checklist items for a scheme.
     * Requirements: 6.1
     */
    public function getIA11Checklist(string $idSkema): Collection
    {
        return IA11Checklist::forSkema($idSkema)
            ->ordered()
            ->get();
    }

    /**
     * Create a new IA11 checklist item.
     * Requirements: 6.2
     */
    public function createIA11Item(string $idSkema, array $data): IA11Checklist
    {
        if (empty($data['item_name'])) {
            throw new \InvalidArgumentException('Nama item tidak boleh kosong');
        }

        // Get next display order
        $maxOrder = IA11Checklist::forSkema($idSkema)->max('display_order') ?? -1;

        return IA11Checklist::create([
            'id_skema' => $idSkema,
            'item_name' => $data['item_name'],
            'description' => $data['description'] ?? null,
            'verification_criteria' => $data['verification_criteria'] ?? null,
            'display_order' => $maxOrder + 1,
            'is_required' => $data['is_required'] ?? true,
        ]);
    }

    /**
     * Update an existing IA11 checklist item.
     * Requirements: 6.3
     */
    public function updateIA11Item(int $id, array $data): bool
    {
        $item = IA11Checklist::findOrFail($id);
        
        // Preserve scheme association
        unset($data['id_skema']);
        
        return $item->update($data);
    }

    /**
     * Delete an IA11 checklist item.
     * Requirements: 6.4
     */
    public function deleteIA11Item(int $id): bool
    {
        $item = IA11Checklist::findOrFail($id);
        return $item->delete();
    }

    // ========================================
    // Dashboard Methods
    // ========================================

    /**
     * Get content summary for a scheme.
     * Requirements: 7.1
     */
    public function getContentSummary(string $idSkema): array
    {
        return [
            'ia05_count' => Soal::forSkema($idSkema)->count(),
            'ia02_exists' => IA02Template::forSkema($idSkema)->exists(),
            'ia07_count' => IA07Question::forSkema($idSkema)->active()->count(),
            'mapa01_exists' => MAPA01Config::forSkema($idSkema)->exists(),
            'mapa02_exists' => MAPA02Config::forSkema($idSkema)->exists(),
            'ia11_count' => IA11Checklist::forSkema($idSkema)->count(),
        ];
    }

    /**
     * Check if a scheme has any content configured.
     * Requirements: 7.1
     */
    public function hasContent(string $idSkema): bool
    {
        $summary = $this->getContentSummary($idSkema);
        
        return $summary['ia05_count'] > 0
            || $summary['ia02_exists']
            || $summary['ia07_count'] > 0
            || $summary['mapa01_exists']
            || $summary['mapa02_exists']
            || $summary['ia11_count'] > 0;
    }
}
