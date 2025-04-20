<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsesiApl02;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Asesi;

class AsesiApl02Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate the table first for clean seeding
        DB::table('asesi_apl02')->truncate();

        $yekaUser = Asesi::where('email', 'yeka@email.com')->first();
        $sakuraUser = Asesi::where('email', 'sakura@email.com')->first();
        $hiroUser = Asesi::where('email', 'hiro@email.com')->first();

        $seedData = [
            [
                'id_asesi' => $yekaUser->id_asesi,
                'daftar_id_asesiUK' => json_encode(['ASESI_UK0001', 'ASESI_UK0002']),
                'file_portofolio' => json_encode(['portofolio/file1.pdf', 'portofolio/file2.pdf']),
            ],
            [
                'id_asesi' => $sakuraUser->id_asesi,
                'daftar_id_asesiUK' => json_encode(['ASESI_UK0002']),
                'file_portofolio' => json_encode(['portofolio/file3.pdf', 'portofolio/file4.pdf']),
            ],
            [
                'id_asesi' => $hiroUser->id_asesi,
                'daftar_id_asesiUK' => json_encode(['ASESI_UK0002', 'ASESI_UK0003']),
                'file_portofolio' => json_encode(['portofolio/file5.pdf', 'portofolio/file6.pdf']),
            ],
        ];

        // Use model creation to ensure boot method gets called for ID generation
        foreach ($seedData as $data) {
            AsesiApl02::create($data);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
