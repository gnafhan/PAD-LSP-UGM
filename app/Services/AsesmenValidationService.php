<?php

namespace App\Services;

use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\ProgresAsesmen;
use App\Models\RincianAsesmen;

/**
 * Validation service for assessment forms and dependencies
 */
class AsesmenValidationService
{
    /**
     * Form dependencies - mapping which forms depend on other forms
     */
    protected $dependencies = [
        'mapa01' => ['ak01'],
        'mapa02' => ['mapa01'],
        'ia01' => ['mapa02'],
        'ia02' => ['ia01'],
        'ak07' => ['ia02']
    ];

    /**
     * Validate that an asesi exists
     * 
     * @param string $id_asesi
     * @param array $relations Relations to eager load
     * @return array|Asesi Returns array with error info or Asesi object if valid
     */
    public function validateAsesiExists(string $id_asesi, array $relations = [])
    {
        $asesi = Asesi::with($relations)->find($id_asesi);
        
        if (!$asesi) {
            return [
                'error' => true,
                'message' => 'Asesi tidak ditemukan',
                'code' => 404
            ];
        }
        
        return $asesi;
    }
    
    /**
     * Validate that an asesi has rincian asesmen
     * 
     * @param Asesi $asesi
     * @return array|null Returns array with error info or null if valid
     */
    public function validateRincianAsesmen(Asesi $asesi)
    {
        if (!$asesi->rincianAsesmen) {
            return [
                'error' => true,
                'message' => 'Asesi belum memiliki rincian asesmen',
                'code' => 404
            ];
        }
        
        return null;
    }
    
    /**
     * Validate that an asesi-asesor pair is valid
     * 
     * @param string $id_asesi
     * @param string $id_asesor
     * @return array|null Returns array with error info or null if valid
     */
    public function validateAsesiAsesorPair(string $id_asesi, string $id_asesor)
    {
        $isAssigned = RincianAsesmen::where('id_asesor', $id_asesor)
            ->where('id_asesi', $id_asesi)
            ->exists();
            
        if (!$isAssigned) {
            return [
                'error' => true,
                'message' => 'Asesi tidak terdaftar dengan asesor ini',
                'code' => 403
            ];
        }
        
        return null;
    }

    /**
     * Validate form dependencies for an asesi
     * 
     * @param string $id_asesi The asesi ID
     * @param string $formName The form being accessed
     * @return array|null Returns null if valid, or array with error info
     */
    public function validateFormDependencies(string $id_asesi, string $formName)
    {
        // Check if this form has dependencies
        if (!isset($this->dependencies[$formName])) {
            return null; // No dependencies to validate
        }

        // Get progress record for this asesi
        $progress = ProgresAsesmen::where('id_asesi', $id_asesi)->first();
        
        if (!$progress) {
            return [
                'error' => true,
                'message' => 'Progress asesmen tidak ditemukan',
                'code' => 404
            ];
        }

        // Check each dependency
        foreach ($this->dependencies[$formName] as $requiredForm) {
            if (!$progress->{$requiredForm}) {
                // Find the first missing dependency in the chain
                return $this->findRootDependency($progress, $requiredForm);
            }
        }

        return null; // All dependencies satisfied
    }

    /**
     * Find the root missing dependency in a chain
     */
    protected function findRootDependency(ProgresAsesmen $progress, string $missingForm)
    {
        // If this form has no dependencies or its dependencies are complete,
        // then this is the root dependency that needs to be completed
        if (!isset($this->dependencies[$missingForm])) {
            return $this->createErrorResponse($missingForm);
        }

        // Check if all dependencies of this form are complete
        foreach ($this->dependencies[$missingForm] as $dependency) {
            if (!$progress->{$dependency}) {
                return $this->findRootDependency($progress, $dependency);
            }
        }

        // If we get here, this is the root missing dependency
        return $this->createErrorResponse($missingForm);
    }

    /**
     * Create a standardized error response
     */
    protected function createErrorResponse(string $formName)
    {
        $formNames = [
            'apl01' => 'APL-01 (Formulir Aplikasi)',
            'apl02' => 'APL-02 (Asesmen Mandiri)',
            'ak01' => 'AK-01 (Formulir Persetujuan Asesmen)',
            'konsultasi_pra_uji' => 'Konsultasi Pra-Uji',
            'mapa01' => 'MAPA-01 (Merencanakan Aktivitas)',
            'mapa02' => 'MAPA-02 (Meninjau Dokumen)',
            'ia01' => 'IA-01 (Pertanyaan Tertulis)',
            'ia02' => 'IA-02 (Daftar Pertanyaan Lisan)',
            'ak07' => 'AK-07 (Formulir Banding Asesmen)',
        ];
        
        $displayName = $formNames[$formName] ?? $formName;
        
        return [
            'error' => true,
            'message' => "Formulir {$displayName} belum diselesaikan",
            'missing_form' => $formName,
            'display_name' => $displayName,
            'code' => 422
        ];
    }
}