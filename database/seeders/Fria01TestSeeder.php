<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\RincianAsesmen;
use App\Models\ProgresAsesmen;
use Illuminate\Support\Str;

class Fria01TestSeeder extends Seeder
{
    public function run(): void
    {
        $asesiList = Asesi::take(3)->get();
        $asesor = \App\Models\Asesor::first();
        $event = \App\Models\Event::first();

        foreach ($asesiList as $asesi) {
            ProgresAsesmen::firstOrCreate([
                'id_asesi' => $asesi->id_asesi,
            ], [
                'ia01' => ['completed' => true, 'completed_at' => now()],
            ]);

            // Eincian asesmen dummy
            if ($asesor && $event) {
                RincianAsesmen::firstOrCreate([
                    'id_asesi' => $asesi->id_asesi,
                ], [
                    'id_asesor' => $asesor->id_asesor,
                    'id_event' => $event->id_event,
                ]);
            }
        }
    }
}
