<?php

namespace Database\Seeders;

use App\Models\Ak07SeederB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Ak07SeederBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'rekaman_rencana_asesmen' => 'Apakah rekaman rencana asesmen tervalidasi dibuat menggunakan acuan pembanding, minimal standar kompetensi kerja?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'rekaman_rencana_asesmen' => 'Apakah rekaman rencana asesmen tervalidasi sudah sesuai dengan potensi asesi yang akan diujikan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'rekaman_rencana_asesmen' => 'Apakah rekaman rencana asesmen tervalidasi sudah sesuai dengan konteks asesi (berdasarkan rekaman APL.01 tervalidasi LSP dan rekaman APL.02 tervalidasi asesi?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $d) {
            Ak07SeederB::create($d);
        }
    }
}
