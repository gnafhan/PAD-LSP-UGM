<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\RincianAsesmen;
use App\Models\ProgresAsesmen;
use App\Models\Fria07;
use App\Models\UK;
use Illuminate\Support\Str;

class Fria07TestSeeder extends Seeder
{
    public function run(): void
    {
        $asesiList = Asesi::take(5)->get();
        $asesor = \App\Models\Asesor::first();
        $event = \App\Models\Event::first();

        if (!$asesor || !$event) {
            $this->command->error('Asesor atau Event tidak ditemukan!');
            return;
        }

        foreach ($asesiList as $asesi) {
            $progres = ProgresAsesmen::firstOrCreate([
                'id_asesi' => $asesi->id_asesi,
            ]);

            if (!$progres->ia02) {
                $progres->update([
                    'ia02' => ['completed' => false, 'completed_at' => null],
                ]);
            }

            // Create rincian asesmen
            $rincianAsesmen = RincianAsesmen::firstOrCreate([
                'id_asesi' => $asesi->id_asesi,
            ], [
                'id_asesor' => $asesor->id_asesor,
                'id_event' => $event->id_event,
            ]);

            // Get skema and unit kompetensi
            $skema = Skema::find($asesi->id_skema);
            if (!$skema) continue;

            // Get daftar UK from skema
            $daftarIdUk = $skema->daftar_id_uk;
            if (is_string($daftarIdUk)) {
                $daftarIdUk = json_decode($daftarIdUk, true);
            }

            if (empty($daftarIdUk)) continue;

            // Get unit kompetensi with elemen
            $unitKompetensi = UK::with('elemen_uk')
                ->whereIn('id_uk', $daftarIdUk)
                ->take(2) 
                ->get();

            if ($unitKompetensi->isEmpty()) continue;

            // Create FRIA07 record dengan data_tambahan kosong
            Fria07::updateOrCreate([
                'id_asesi' => $asesi->id_asesi,
                'id_asesor' => $asesor->id_asesor,
                'id_skema' => $asesi->id_skema,
            ], [
                'id_fria07' => Str::uuid()->toString(),
                'id_event' => $event->id_event,
                'id_rincian_asesmen' => $rincianAsesmen->id_rincian_asesmen,
                'data_tambahan' => null, // Biarkan kosong, akan diisi dari form
            ]);

            // Update progress for ia02
            if (rand(0, 10) > 3) {
                ProgresAsesmen::where('id_asesi', $asesi->id_asesi)
                    ->update([
                        'ia02' => ['completed' => true, 'completed_at' => now()]
                    ]);
            }
        }

        $this->command->info('FRIA07 test data seeded successfully with ' . $asesiList->count() . ' records!');
    }
}
