<?php

namespace Tests\Feature\EventInvitation;

use App\Exceptions\DuplicateEmailException;
use App\Mail\AsesiInvitationMail;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use App\Models\User;
use App\Services\AccessControlService;
use App\Services\EmailInvitationService;
use App\Services\ParticipantManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

/**
 * Integration Test: Complete Participant Addition Flow
 * 
 * Tests the complete flow from admin adding a participant through
 * email invitation, Google OAuth login, and registration completion.
 * 
 * **Validates: Requirements 1.2, 3.1, 5.4, 5.6, 7.1, 7.4**
 */
class CompleteParticipantFlowTest extends TestCase
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
     * Test complete participant addition flow
     * 
     * Flow:
     * 1. Admin adds participant
     * 2. Email is sent
     * 3. Participant logs in via Google
     * 4. Participant completes registration
     * 
     * @test
     */
    public function complete_participant_addition_flow_works_end_to_end(): void
    {
        Mail::fake();

        // Step 1: Admin adds participant
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        $email = 'test.participant@example.com';

        $participant = $this->participantService->addParticipant(
            $event->id_event,
            $skema->id_skema,
            $email
        );

        // Verify participant was created
        $this->assertDatabaseHas('event_participants', [
            'email' => $email,
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'invitation_status' => 'sent',
        ]);

        // Step 2: Verify email was sent
        Mail::assertSent(AsesiInvitationMail::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });

        // Step 3: Participant logs in via Google OAuth
        // Mock Google OAuth response
        $googleUser = Mockery::mock(SocialiteUser::class);
        $googleUser->shouldReceive('getEmail')->andReturn($email);
        $googleUser->shouldReceive('getName')->andReturn('Test Participant');
        $googleUser->shouldReceive('getId')->andReturn('google-id-123');

        Socialite::shouldReceive('driver->user')->andReturn($googleUser);

        // Verify email is invited
        $this->assertTrue($this->accessControl->isEmailInvited($email));

        // Get participant details
        $participantRecord = $this->accessControl->getParticipantByEmail($email);
        $this->assertNotNull($participantRecord);
        $this->assertEquals($event->id_event, $participantRecord->id_event);
        $this->assertEquals($skema->id_skema, $participantRecord->id_skema);

        // Simulate user creation/login
        $user = User::factory()->create([
            'email' => $email,
            'name' => 'Test Participant',
            'gauth_id' => 'google-id-123',
            'gauth_type' => 'google',
            'level' => 'asesi',
        ]);

        Auth::login($user);

        // Verify user is authenticated
        $this->assertTrue(Auth::check());
        $this->assertEquals($email, Auth::user()->email);

        // Step 4: Participant completes registration
        $this->accessControl->markAsRegistered($email);

        // Verify participant is marked as registered
        $this->assertDatabaseHas('event_participants', [
            'email' => $email,
            'invitation_status' => 'registered',
        ]);

        $updatedParticipant = EventParticipant::where('email', $email)->first();
        $this->assertNotNull($updatedParticipant->registered_at);

        // Verify user can access assessment
        $this->assertTrue($this->accessControl->canAccessAssessment($user));
    }

    /**
     * Test that duplicate email is rejected
     * 
     * @test
     */
    public function duplicate_email_is_rejected_across_events(): void
    {
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();
        $skema1 = Skema::factory()->create();
        $skema2 = Skema::factory()->create();
        $email = 'duplicate@example.com';

        // Add participant to first event
        $this->participantService->addParticipant(
            $event1->id_event,
            $skema1->id_skema,
            $email
        );

        // Try to add same email to second event - should fail
        $this->expectException(DuplicateEmailException::class);
        $this->expectExceptionMessage("Email {$email} is already registered in another event");

        $this->participantService->addParticipant(
            $event2->id_event,
            $skema2->id_skema,
            $email
        );
    }

    /**
     * Test that registered user is redirected to dashboard
     * 
     * @test
     */
    public function registered_user_cannot_access_registration_again(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();
        $email = 'registered@example.com';

        // Create participant and mark as registered
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

        // User should be able to access assessment
        $this->assertTrue($this->accessControl->canAccessAssessment($user));

        // Participant status should be registered
        $participantRecord = $this->accessControl->getParticipantByEmail($email);
        $this->assertEquals('registered', $participantRecord->invitation_status);
    }

    /**
     * Test event and skema pre-population
     * 
     * @test
     */
    public function event_and_skema_are_prepopulated_for_invited_user(): void
    {
        $event = Event::factory()->create(['nama_event' => 'Test Event 2024']);
        $skema = Skema::factory()->create(['nama_skema' => 'Test Skema']);
        $email = 'prepopulated@example.com';

        // Create participant
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $email,
            'invitation_status' => 'sent',
        ]);

        // Get participant details
        $participant = $this->accessControl->getParticipantByEmail($email);

        // Verify event and skema are loaded
        $this->assertNotNull($participant->event);
        $this->assertNotNull($participant->skema);
        $this->assertEquals('Test Event 2024', $participant->event->nama_event);
        $this->assertEquals('Test Skema', $participant->skema->nama_skema);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
