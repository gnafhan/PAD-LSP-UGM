<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use Illuminate\Database\Seeder;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get events and skemas for testing
        $events = Event::take(2)->get();
        $skemas = Skema::take(3)->get();

        if ($events->isEmpty() || $skemas->isEmpty()) {
            $this->command->warn('No events or skemas found. Please seed events and skemas first.');
            return;
        }

        $event = $events->first();
        
        // Create sample participants with different statuses for first event
        
        // Pending participants (not yet sent invitation)
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[0]->id_skema,
            'email' => 'pending1@example.com',
            'invitation_status' => 'pending',
        ]);

        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[1]->id_skema,
            'email' => 'pending2@example.com',
            'invitation_status' => 'pending',
        ]);

        // Sent participants (invitation sent but not registered)
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[0]->id_skema,
            'email' => 'sent1@example.com',
            'invitation_status' => 'sent',
            'invitation_sent_at' => now()->subDays(2),
        ]);

        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[1]->id_skema,
            'email' => 'sent2@example.com',
            'invitation_status' => 'sent',
            'invitation_sent_at' => now()->subDays(3),
        ]);

        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[2]->id_skema,
            'email' => 'sent3@example.com',
            'invitation_status' => 'sent',
            'invitation_sent_at' => now()->subDays(1),
        ]);

        // Registered participants (completed registration)
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[0]->id_skema,
            'email' => 'registered1@example.com',
            'invitation_status' => 'registered',
            'invitation_sent_at' => now()->subDays(7),
            'registered_at' => now()->subDays(5),
        ]);

        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[1]->id_skema,
            'email' => 'registered2@example.com',
            'invitation_status' => 'registered',
            'invitation_sent_at' => now()->subDays(10),
            'registered_at' => now()->subDays(8),
        ]);

        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skemas[2]->id_skema,
            'email' => 'registered3@example.com',
            'invitation_status' => 'registered',
            'invitation_sent_at' => now()->subDays(6),
            'registered_at' => now()->subDays(4),
        ]);

        // If there's a second event, add some participants to it as well
        if ($events->count() > 1) {
            $event2 = $events[1];
            
            EventParticipant::create([
                'id_event' => $event2->id_event,
                'id_skema' => $skemas[0]->id_skema,
                'email' => 'event2participant1@example.com',
                'invitation_status' => 'sent',
                'invitation_sent_at' => now()->subDays(1),
            ]);

            EventParticipant::create([
                'id_event' => $event2->id_event,
                'id_skema' => $skemas[1]->id_skema,
                'email' => 'event2participant2@example.com',
                'invitation_status' => 'registered',
                'invitation_sent_at' => now()->subDays(4),
                'registered_at' => now()->subDays(2),
            ]);
        }

        $this->command->info('Event participants seeded successfully with various statuses and skemas.');
    }
}
