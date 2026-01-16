<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventParticipant>
 */
class EventParticipantFactory extends Factory
{
    protected $model = EventParticipant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_event' => Event::factory(),
            'id_skema' => Skema::factory(),
            'email' => strtolower(fake()->unique()->safeEmail()),
            'invitation_status' => 'pending',
            'invitation_sent_at' => null,
            'registered_at' => null,
        ];
    }

    /**
     * Indicate that the invitation has been sent.
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'invitation_status' => 'sent',
            'invitation_sent_at' => now(),
        ]);
    }

    /**
     * Indicate that the participant has registered.
     */
    public function registered(): static
    {
        return $this->state(fn (array $attributes) => [
            'invitation_status' => 'registered',
            'invitation_sent_at' => now()->subDays(2),
            'registered_at' => now(),
        ]);
    }

    /**
     * Set a specific email address.
     */
    public function withEmail(string $email): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => strtolower($email),
        ]);
    }

    /**
     * Set a specific event.
     */
    public function forEvent(string $eventId): static
    {
        return $this->state(fn (array $attributes) => [
            'id_event' => $eventId,
        ]);
    }

    /**
     * Set a specific skema.
     */
    public function forSkema(string $skemaId): static
    {
        return $this->state(fn (array $attributes) => [
            'id_skema' => $skemaId,
        ]);
    }
}
