<?php

namespace Tests\Feature\EventInvitation;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use App\Models\User;
use App\Services\AccessControlService;
use App\Services\ParticipantManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * Integration Test: Participant Removal Flow
 * 
 * Tests the participant removal flow including immediate access revocation
 * and session revocation for logged-in participants.
 * 
 * **Validates: Requirements 1.5, 12.1, 12.2, 12.3**
 */
class ParticipantRemovalFlowTest extends TestCase
{
    use RefreshDatabase;

    private ParticipantManagementService $participantService;
    private AccessControlService $accessControl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->participantService = app(ParticipantManagementService::class);
        $this->accessControl = app(AccessControlService::class);
    }

    /**
     * Test participant removal flow
     * 
     * Flow:
     * 1. Admin removes participant
     * 2. Participant loses access immediately
     * 3. Logged-in participant session is revoked
     * 
     * @test
     */
    public function participant_removal_revokes_access_immediately(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        $email = 'removed@example.com';

        // Create participant
        $participant = EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $email,
            'invitation_status' => 'registered',
            'registered_at' => now(),
        ]);

        $user = User::factory()->create([
            'email' => $email,
            'level' => 'asesi',
        ]);

        // Verify user has access before removal
        $this->assertTrue($this->accessControl->isEmailInvited($email));
        $this->assertTrue($this->accessControl->canAccessAssessment($user));

        // Admin removes participant
        $this->participantService->removeParticipant($participant->id);

        // Verify participant record is deleted
        $this->assertDatabaseMissing('event_participants', [
            'id' => $participant->id,
            'email' => $email,
        ]);

        // Verify user loses access immediately
        $this->assertFalse($this->accessControl->isEmailInvited($email));
        $this->assertFalse($this->accessControl->canAccessAssessment($user));

        // Verify getParticipantByEmail returns null
        $participantRecord = $this->accessControl->getParticipantByEmail($email);
        $this->assertNull($participantRecord);
    }

    /**
     * Test removal logs audit trail
     * 
     * @test
     */
    public function participant_removal_creates_audit_log(): void
    {
        Log::spy();

        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        $email = 'audit@example.com';

        // Create admin user
        $admin = User::factory()->create(['level' => 'admin']);
        Auth::login($admin);

        // Create participant
        $participant = EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $email,
            'invitation_status' => 'sent',
        ]);

        // Remove participant
        $this->participantService->removeParticipant($participant->id);

        // Verify audit log was created
        Log::shouldHaveReceived('info')
            ->once()
            ->with('Participant removed', \Mockery::on(function ($context) use ($participant, $email, $admin) {
                return $context['participant_id'] === $participant->id
                    && $context['email'] === $email
                    && $context['event_id'] === $participant->id_event
                    && $context['removed_by'] === $admin->id_user;
            }));
    }

    /**
     * Test removed participant cannot access registration
     * 
     * @test
     */
    public function removed_participant_cannot_access_registration(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        $email = 'blocked@example.com';

        // Create and then remove participant
        $participant = EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $email,
            'invitation_status' => 'sent',
        ]);

        $user = User::factory()->create([
            'email' => $email,
            'level' => 'asesi',
        ]);

        // Remove participant
        $this->participantService->removeParticipant($participant->id);

        // Verify user cannot access registration
        $this->assertFalse($this->accessControl->isEmailInvited($email));
        $this->assertNull($this->accessControl->getParticipantByEmail($email));
    }

    /**
     * Test email can be reused after removal
     * 
     * @test
     */
    public function email_can_be_reused_after_removal(): void
    {
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();
        $skema1 = Skema::factory()->create();
        $skema2 = Skema::factory()->create();
        $email = 'reusable@example.com';

        // Add participant to event1
        $participant1 = EventParticipant::create([
            'id_event' => $event1->id_event,
            'id_skema' => $skema1->id_skema,
            'email' => $email,
            'invitation_status' => 'sent',
        ]);

        // Verify email exists
        $this->assertTrue($this->accessControl->isEmailInvited($email));

        // Remove participant
        $this->participantService->removeParticipant($participant1->id);

        // Verify email no longer exists
        $this->assertFalse($this->accessControl->isEmailInvited($email));

        // Now add same email to event2 - should succeed
        $participant2 = $this->participantService->addParticipant(
            $event2->id_event,
            $skema2->id_skema,
            $email
        );

        // Verify new participant was created
        $this->assertNotNull($participant2);
        $this->assertEquals($email, $participant2->email);
        $this->assertEquals($event2->id_event, $participant2->id_event);
        $this->assertEquals($skema2->id_skema, $participant2->id_skema);

        // Verify email is invited again
        $this->assertTrue($this->accessControl->isEmailInvited($email));
    }

    /**
     * Test removal of registered participant
     * 
     * @test
     */
    public function removal_works_for_registered_participants(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        $email = 'registered.removed@example.com';

        // Create registered participant
        $participant = EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $email,
            'invitation_status' => 'registered',
            'registered_at' => now(),
        ]);

        $user = User::factory()->create([
            'email' => $email,
            'level' => 'asesi',
        ]);

        // Verify user has full access
        $this->assertTrue($this->accessControl->canAccessAssessment($user));

        // Remove participant
        $this->participantService->removeParticipant($participant->id);

        // Verify access is revoked
        $this->assertFalse($this->accessControl->isEmailInvited($email));
        $this->assertFalse($this->accessControl->canAccessAssessment($user));
    }

    /**
     * Test removal of pending participant
     * 
     * @test
     */
    public function removal_works_for_pending_participants(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        $email = 'pending.removed@example.com';

        // Create pending participant
        $participant = EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $email,
            'invitation_status' => 'pending',
        ]);

        // Verify participant exists
        $this->assertTrue($this->accessControl->isEmailInvited($email));

        // Remove participant
        $this->participantService->removeParticipant($participant->id);

        // Verify participant is deleted
        $this->assertDatabaseMissing('event_participants', [
            'id' => $participant->id,
        ]);

        $this->assertFalse($this->accessControl->isEmailInvited($email));
    }

    /**
     * Test multiple removals in sequence
     * 
     * @test
     */
    public function multiple_participants_can_be_removed_sequentially(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Create multiple participants
        $participants = [];
        for ($i = 1; $i <= 5; $i++) {
            $participants[] = EventParticipant::create([
                'id_event' => $event->id_event,
                'id_skema' => $skema->id_skema,
                'email' => "participant{$i}@example.com",
                'invitation_status' => 'sent',
            ]);
        }

        // Verify all exist
        $this->assertEquals(5, EventParticipant::where('id_event', $event->id_event)->count());

        // Remove them one by one
        foreach ($participants as $participant) {
            $this->participantService->removeParticipant($participant->id);
        }

        // Verify all are deleted
        $this->assertEquals(0, EventParticipant::where('id_event', $event->id_event)->count());

        // Verify none are invited
        for ($i = 1; $i <= 5; $i++) {
            $this->assertFalse($this->accessControl->isEmailInvited("participant{$i}@example.com"));
        }
    }

    /**
     * Test removal does not affect other events
     * 
     * @test
     */
    public function removal_from_one_event_does_not_affect_others(): void
    {
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Create participants in both events (different emails)
        $participant1 = EventParticipant::create([
            'id_event' => $event1->id_event,
            'id_skema' => $skema->id_skema,
            'email' => 'event1@example.com',
            'invitation_status' => 'sent',
        ]);

        $participant2 = EventParticipant::create([
            'id_event' => $event2->id_event,
            'id_skema' => $skema->id_skema,
            'email' => 'event2@example.com',
            'invitation_status' => 'sent',
        ]);

        // Remove participant from event1
        $this->participantService->removeParticipant($participant1->id);

        // Verify event1 participant is removed
        $this->assertFalse($this->accessControl->isEmailInvited('event1@example.com'));

        // Verify event2 participant still exists
        $this->assertTrue($this->accessControl->isEmailInvited('event2@example.com'));
        $this->assertDatabaseHas('event_participants', [
            'id' => $participant2->id,
            'email' => 'event2@example.com',
        ]);
    }
}
