<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        
        foreach ($asesors as $index => $asesor) {
            TandaTanganAsesor::updateOrCreate(
                ['id_asesor' => $asesor->id_asesor],
                [
                    'file_tanda_tangan' => 'asesor_signature_' . ($index + 1) . '.png',
                    'valid_from' => Carbon::now(),
                    'valid_until' => null, // No expiry for test data
                ]
            );
        }
        
        $this->command->info('TandaTanganAsesor seeder completed. Created signatures for ' . $asesors->count() . ' asesors.');
    }
}
