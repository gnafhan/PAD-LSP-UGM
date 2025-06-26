<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\EventSkema;
use App\Models\Event;
use App\Models\Skema;

class EventSkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate the table first for clean seeding
        DB::table('event_skema')->truncate();

        // Get references to existing records
        $events = Event::take(2)->get();
        $skemas = Skema::take(3)->get();

        // Check if required data exists
        if ($events->count() < 2 || $skemas->count() < 3) {
            throw new \Exception('Required data (events, skemas) not found. Please run their respective seeders first.');
        }

        // Create data with dynamic references
        $data = [
            [
                'id_event' => $events[0]->id_event,
                'id_skema' => $skemas[0]->id_skema,
            ],
            [
                'id_event' => $events[0]->id_event,
                'id_skema' => $skemas[1]->id_skema,
            ],
            [
                'id_event' => $events[1]->id_event,
                'id_skema' => $skemas[2]->id_skema,
            ],
        ];

        // Use model creation to ensure boot method gets called for ID generation
        foreach ($data as $item) {
            EventSkema::create($item);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
