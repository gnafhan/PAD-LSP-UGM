<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsesiMUK;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\MUK;
use App\Models\UjianMUK;
use Illuminate\Support\Facades\DB;

class AsesiMUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate the table first for clean seeding
        DB::table('asesi_muk')->truncate();

        // Get references to existing records
        $asesis = Asesi::take(3)->get();
        $asesors = Asesor::take(3)->get();
        $muks = MUK::take(3)->get();
        $ujians = UjianMUK::take(3)->get();

        // Check if required data exists
        if ($asesis->count() < 2 || $asesors->count() < 2 || $muks->count() < 2 || $ujians->count() < 2) {
            throw new \Exception('Required data (asesis, asesors, MUKs, ujians) not found. Please run their respective seeders first.');
        }

        // Create data with dynamic references
        $asesiMUKData = [
            [
                'id_asesi' => $asesis[0]->id_asesi,
                'id_muk' => $muks[0]->id_muk,
                'file_jawabanMUK' => 'uploads/jawaban1.pdf',
                'id_asesor' => $asesors[0]->id_asesor,
                'id_ujian' => $ujians[0]->id_ujian,
            ],
            [
                'id_asesi' => $asesis[1]->id_asesi,
                'id_muk' => $muks[1]->id_muk,
                'file_jawabanMUK' => 'uploads/jawaban2.pdf',
                'id_asesor' => $asesors[1]->id_asesor,
                'id_ujian' => $ujians[1]->id_ujian,
            ],
        ];

        // Use model creation to ensure boot method gets called for ID generation
        foreach ($asesiMUKData as $data) {
            AsesiMUK::create($data);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
