<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalMUK;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\UjianMUK;
use Illuminate\Support\Facades\DB;

class JadwalMUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate the table first for clean seeding
        DB::table('jadwal_muk')->truncate();

        // Get references to existing records
        $asesis = Asesi::take(3)->get();
        $asesors = Asesor::take(3)->get();
        $ujians = UjianMUK::take(3)->get();

        // Check if required data exists
        if ($asesis->count() < 3 || $asesors->count() < 3 || $ujians->count() < 3) {
            throw new \Exception('Required data (asesis, asesors, ujians) not found. Please run their respective seeders first.');
        }

        // Create data with dynamic references
        $jadwalData = [
            [
                'id_asesi' => $asesis[0]->id_asesi,
                'id_ujian' => $ujians[0]->id_ujian,
                'waktu_jadwal' => '2024-12-01 09:00:00',
                'id_asesor' => $asesors[0]->id_asesor,
            ],
            [
                'id_asesi' => $asesis[1]->id_asesi,
                'id_ujian' => $ujians[1]->id_ujian,
                'waktu_jadwal' => '2024-12-02 10:30:00',
                'id_asesor' => $asesors[1]->id_asesor,
            ],
            [
                'id_asesi' => $asesis[2]->id_asesi,
                'id_ujian' => $ujians[2]->id_ujian,
                'waktu_jadwal' => '2024-12-03 13:45:00',
                'id_asesor' => $asesors[2]->id_asesor,
            ],
        ];

        // Use model creation to ensure boot method gets called for ID generation
        foreach ($jadwalData as $data) {
            JadwalMUK::create($data);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
