<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\TandaTanganAsesor;
use App\Models\Asesor;
use Carbon\Carbon;

class TandaTanganAsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first few asesors
        $asesors = Asesor::take(3)->get();
        
        // Get actual signature files from storage
        $signatureFiles = Storage::disk('public')->files('tanda_tangan');
        $signatureFiles = array_filter($signatureFiles, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
        });
        $signatureFiles = array_values($signatureFiles);
        
        foreach ($asesors as $index => $asesor) {
            // Use actual file if exists, otherwise use placeholder name
            $filename = isset($signatureFiles[$index]) 
                ? basename($signatureFiles[$index]) 
                : 'asesor_signature_' . ($index + 1) . '.png';
            
            // If only one signature file exists, use it for all asesors
            if (count($signatureFiles) === 1) {
                $filename = basename($signatureFiles[0]);
            }
            
            TandaTanganAsesor::updateOrCreate(
                ['id_asesor' => $asesor->id_asesor],
                [
                    'file_tanda_tangan' => $filename,
                    'valid_from' => Carbon::now(),
                    'valid_until' => null, // No expiry for test data
                ]
            );
        }
        
        $this->command->info('TandaTanganAsesor seeder completed. Created signatures for ' . $asesors->count() . ' asesors.');
    }
}
