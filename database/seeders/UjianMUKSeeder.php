<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UjianMUK;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\TUK;
use App\Models\MUK;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UjianMUKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate the table first for clean seeding
        DB::table('ujian_muk')->truncate();
        
        // Get first three asesis
        $asesis = Asesi::take(3)->get();
        
        // Get first three asesors
        $asesors = Asesor::take(3)->get();
        
        // Get TUKs
        $tuks = TUK::take(2)->get();
        
        // Get MUKs
        $muks = MUK::take(3)->get();
        
        // Check if required data exists
        if ($asesis->count() < 3 || $asesors->count() < 3 || $tuks->count() < 2 || $muks->count() < 3) {
            throw new \Exception('Required data (asesis, asesors, TUKs, MUKs) not found. Please run their respective seeders first.');
        }
        
        // Create data with dynamic references
        $ujianData = [
            [
                'id_asesi' => $asesis[0]->id_asesi,
                'id_asesor' => $asesors[0]->id_asesor,
                'tgl_ujian' => '2024-11-25',
                'status_ujian' => 'On process',
                'nilai_kompetensi' => 0,
                'id_tuk' => $tuks[0]->id_tuk,
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '11:00:00',
                'id_muk' => $muks[0]->id_muk,
                'tipe_ujian' => 'Offline',
            ],
            [
                'id_asesi' => $asesis[1]->id_asesi,
                'id_asesor' => $asesors[1]->id_asesor,
                'tgl_ujian' => '2024-11-26',
                'status_ujian' => 'Pending',
                'nilai_kompetensi' => 0,
                'id_tuk' => $tuks[1]->id_tuk,
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'id_muk' => $muks[1]->id_muk,
                'tipe_ujian' => 'Online',
            ],
            [
                'id_asesi' => $asesis[2]->id_asesi,
                'id_asesor' => $asesors[2]->id_asesor,
                'tgl_ujian' => '2024-11-27',
                'status_ujian' => 'Completed',
                'nilai_kompetensi' => 85,
                'id_tuk' => $tuks[0]->id_tuk,
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'id_muk' => $muks[2]->id_muk,
                'tipe_ujian' => 'Offline',
            ],
        ];

        // Use model creation to ensure boot method gets called for ID generation
        foreach ($ujianData as $data) {
            UjianMUK::create($data);
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}