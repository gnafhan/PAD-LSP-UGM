<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('event_skema')->insert([
            [
                'id_event' => 'EVENT1',
                'id_skema' => 'SKEMA1',
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'id_event' => 'EVENT1',
                'id_skema' => 'SKEMA2',
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'id_event' => 'EVENT2',
                'id_skema' => 'SKEMA3',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
