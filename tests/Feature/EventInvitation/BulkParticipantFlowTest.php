<?php

namespace Tests\Feature\EventInvitation;

use App\Exceptions\DuplicateEmailException;
use App\Exceptions\InvalidEmailException;
use App\Mail\AsesiInvitationMail;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use App\Models\User;
use App\Services\AccessControlService;
use App\Services\ParticipantManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Integration Test: Bulk Participant Addition Flow
 * 
 * Tests the bulk participant addition flow including email sending
 * and login capability for all participants.
 * 
 * **Validates: Requirements 2.4, 2.8, 3.2**
 */
class BulkParticipantFlowTest extends TestCase
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
     * Test bulk participant addition flow
     * 
     * Flow:
     * 1. Admin adds multiple participants via bulk
     * 2. All emails are sent
     * 3. All participants can log in
     * 
     * @test
     */
    public function bulk_participant_addition_sends_all_emails(): void
    {
        Mail::fake();

        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        
        $emails = [
            'participant1@example.com',
            'participant2@example.com',
            'participant3@example.com',
            'participant4@example.com',
            'participant5@example.com',
        ];

        // Add participants in bulk
        $participants = $this->participantService->addBulkParticipants(
            $event->id_event,
            $skema->id_skema,
            $emails
        );

        // Verify all participants were created
        $this->assertCount(5, $participants);

        foreach ($emails as $email) {
            $this->assertDatabaseHas('event_participants', [
                'email' => $email,
                'id_event' => $event->id_event,
                'id_skema' => $skema->id_skema,
                'invitation_status' => 'sent',
            ]);
        }

        // Verify all emails were sent
        Mail::assertSent(AsesiInvitationMail::class, 5);

        foreach ($emails as $email) {
            Mail::assertSent(AsesiInvitationMail::class, function ($mail) use ($email) {
                return $mail->hasTo($email);
            });
        }

        // Verify all participants can log in (are invited)
        foreach ($emails as $email) {
            $this->assertTrue(
                $this->accessControl->isEmailInvited($email),
                "Email {$email} should be invited"
            );

            $participant = $this->accessControl->getParticipantByEmail($email);
            $this->assertNotNull($participant);
            $this->assertEquals($event->id_event, $participant->id_event);
            $this->assertEquals($skema->id_skema, $participant->id_skema);
        }
    }

    /**
     * Test bulk addition with same skema assignment
     * 
     * @test
     */
    public function bulk_participants_all_have_same_skema(): void
    {
        Mail::fake();

        $event = Event::factory()->create();
        $skema = Skema::factory()->create(['nama_skema' => 'Bulk Test Skema']);
        
        $emails = [
            'bulk1@example.com',
            'bulk2@example.com',
            'bulk3@example.com',
        ];

        $participants = $this->participantService->addBulkParticipants(
            $event->id_event,
            $skema->id_skema,
            $emails
        );

        // Verify all have the same skema
        foreach ($participants as $participant) {
            $this->assertEquals($skema->id_skema, $participant->id_skema);
        }

        // Verify in database
        $dbParticipants = EventParticipant::whereIn('email', $emails)->get();
        foreach ($dbParticipants as $participant) {
            $this->assertEquals($skema->id_skema, $participant->id_skema);
        }
    }

    /**
     * Test bulk addition rejects if any email is duplicate
     * 
     * @test
     */
    public function bulk_addition_rejects_if_any_email_is_duplicate(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Add one participant first
        $existingEmail = 'existing@example.com';
        $this->participantService->addParticipant(
            $event->id_event,
            $skema->id_skema,
            $existingEmail
        );

        // Try to add bulk with one duplicate
        $emails = [
            'new1@example.com',
            'new2@example.com',
            $existingEmail, // This is duplicate
            'new3@example.com',
        ];

        $this->expectException(DuplicateEmailException::class);
        $this->expectExceptionMessage("Emails already registered: {$existingEmail}");

        $this->participantService->addBulkParticipants(
            $event->id_event,
            $skema->id_skema,
            $emails
        );

        // Verify none of the new emails were added (atomic operation)
        $this->assertDatabaseMissing('event_participants', ['email' => 'new1@example.com']);
        $this->assertDatabaseMissing('event_participants', ['email' => 'new2@example.com']);
        $this->assertDatabaseMissing('event_participants', ['email' => 'new3@example.com']);
    }

    /**
     * Test bulk addition rejects duplicates within batch
     * 
     * @test
     */
    public function bulk_addition_rejects_duplicates_within_batch(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        $emails = [
            'unique1@example.com',
            'duplicate@example.com',
            'unique2@example.com',
            'duplicate@example.com', // Duplicate within batch
        ];

        $this->expectException(DuplicateEmailException::class);
        $this->expectExceptionMessage('Duplicate emails in batch: duplicate@example.com');

        $this->participantService->addBulkParticipants(
            $event->id_event,
            $skema->id_skema,
            $emails
        );

        // Verify none were added
        $this->assertDatabaseMissing('event_participants', ['email' => 'unique1@example.com']);
        $this->assertDatabaseMissing('event_participants', ['email' => 'unique2@example.com']);
        $this->assertDatabaseMissing('event_participants', ['email' => 'duplicate@example.com']);
    }

    /**
     * Test bulk addition validates all email formats
     * 
     * @test
     */
    public function bulk_addition_validates_all_email_formats(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        $emails = [
            'valid1@example.com',
            'invalid-email', // Invalid format
            'valid2@example.com',
        ];

        $this->expectException(InvalidEmailException::class);
        $this->expectExceptionMessage('Invalid email formats: invalid-email');

        $this->participantService->addBulkParticipants(
            $event->id_event,
            $skema->id_skema,
            $emails
        );

        // Verify none were added
        $this->assertDatabaseMissing('event_participants', ['email' => 'valid1@example.com']);
        $this->assertDatabaseMissing('event_participants', ['email' => 'valid2@example.com']);
    }

    /**
     * Test bulk addition with email normalization
     * 
     * @test
     */
    public function bulk_addition_normalizes_emails(): void
    {
        Mail::fake();

        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Emails with various formatting
        $emails = [
            '  UPPERCASE@EXAMPLE.COM  ',
            'MixedCase@Example.Com',
            'lowercase@example.com   ',
        ];

        $participants = $this->participantService->addBulkParticipants(
            $event->id_event,
            $skema->id_skema,
            $emails
        );

        // Verify all emails are normalized to lowercase and trimmed
        $this->assertDatabaseHas('event_participants', ['email' => 'uppercase@example.com']);
        $this->assertDatabaseHas('event_participants', ['email' => 'mixedcase@example.com']);
        $this->assertDatabaseHas('event_participants', ['email' => 'lowercase@example.com']);
    }

    /**
     * Test large bulk addition
     * 
     * @test
     */
    public function bulk_addition_handles_large_batches(): void
    {
        Mail::fake();

        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Generate 50 unique emails
        $emails = [];
        for ($i = 1; $i <= 50; $i++) {
            $emails[] = "participant{$i}@example.com";
        }

        $participants = $this->participantService->addBulkParticipants(
            $event->id_event,
            $skema->id_skema,
            $emails
        );

        // Verify all were created
        $this->assertCount(50, $participants);

        // Verify all emails were sent
        Mail::assertSent(AsesiInvitationMail::class, 50);

        // Verify all are in database
        $dbCount = EventParticipant::where('id_event', $event->id_event)->count();
        $this->assertEquals(50, $dbCount);
    }

    /**
     * Test bulk addition is atomic (all or nothing)
     * 
     * @test
     */
    public function bulk_addition_is_atomic_operation(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Create existing participant
        $existingEmail = 'existing@example.com';
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $existingEmail,
            'invitation_status' => 'sent',
        ]);

        // Try bulk add with 10 new emails + 1 duplicate
        $emails = [];
        for ($i = 1; $i <= 10; $i++) {
            $emails[] = "new{$i}@example.com";
        }
        $emails[] = $existingEmail; // Add duplicate at the end

        try {
            $this->participantService->addBulkParticipants(
                $event->id_event,
                $skema->id_skema,
                $emails
            );
            $this->fail('Should have thrown DuplicateEmailException');
        } catch (DuplicateEmailException $e) {
            // Expected
        }

        // Verify NONE of the new emails were added
        for ($i = 1; $i <= 10; $i++) {
            $this->assertDatabaseMissing('event_participants', [
                'email' => "new{$i}@example.com"
            ]);
        }

        // Verify only the original participant exists
        $count = EventParticipant::where('id_event', $event->id_event)->count();
        $this->assertEquals(1, $count);
    }
}
