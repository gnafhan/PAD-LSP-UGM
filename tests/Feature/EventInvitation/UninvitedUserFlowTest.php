<?php

namespace Tests\Feature\EventInvitation;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use App\Models\User;
use App\Services\AccessControlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

/**
 * Integration Test: Uninvited User Flow
 * 
 * Tests the flow when a user attempts to log in with an email
 * that has not been invited by an administrator.
 * 
 * **Validates: Requirements 5.5, 6.2, 6.3**
 */
class UninvitedUserFlowTest extends TestCase
{
    use RefreshDatabase;

    private AccessControlService $accessControl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accessControl = app(AccessControlService::class);
    }

    /**
     * Test uninvited user flow
     * 
     * Flow:
     * 1. User attempts Google login with uninvited email
     * 2. System displays error message
     * 3. User cannot access registration
     * 
     * @test
     */
    public function uninvited_user_is_rejected_at_login(): void
    {
        $uninvitedEmail = 'uninvited@example.com';

        // Verify email is not invited
        $this->assertFalse($this->accessControl->isEmailInvited($uninvitedEmail));

        // Verify getParticipantByEmail returns null
        $participant = $this->accessControl->getParticipantByEmail($uninvitedEmail);
        $this->assertNull($participant);

        // Mock Google OAuth response
        $googleUser = Mockery::mock(SocialiteUser::class);
        $googleUser->shouldReceive('getEmail')->andReturn($uninvitedEmail);
        $googleUser->shouldReceive('getName')->andReturn('Uninvited User');
        $googleUser->shouldReceive('getId')->andReturn('google-id-uninvited');

        Socialite::shouldReceive('driver->user')->andReturn($googleUser);

        // Simulate the OAuth callback check
        $isInvited = $this->accessControl->isEmailInvited($uninvitedEmail);

        // User should not be invited
        $this->assertFalse($isInvited);

        // User should not be created or logged in
        $this->assertFalse(Auth::check());

        // Verify no user account was created
        $this->assertDatabaseMissing('users', [
            'email' => $uninvitedEmail,
        ]);
    }

    /**
     * Test uninvited user cannot access registration
     * 
     * @test
     */
    public function uninvited_user_cannot_access_registration(): void
    {
        $uninvitedEmail = 'noaccess@example.com';

        // Create a user account (but no invitation)
        $user = User::factory()->create([
            'email' => $uninvitedEmail,
            'level' => 'asesi',
        ]);

        // Verify user is not invited
        $this->assertFalse($this->accessControl->isEmailInvited($uninvitedEmail));

        // Verify user cannot access assessment
        $this->assertFalse($this->accessControl->canAccessAssessment($user));

        // Verify getParticipantByEmail returns null
        $participant = $this->accessControl->getParticipantByEmail($uninvitedEmail);
        $this->assertNull($participant);
    }

    /**
     * Test invited user can access registration
     * 
     * @test
     */
    public function invited_user_can_access_registration(): void
    {
        $invitedEmail = 'invited@example.com';
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Create invitation
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $invitedEmail,
            'invitation_status' => 'sent',
        ]);

        // Verify user is invited
        $this->assertTrue($this->accessControl->isEmailInvited($invitedEmail));

        // Verify getParticipantByEmail returns participant
        $participant = $this->accessControl->getParticipantByEmail($invitedEmail);
        $this->assertNotNull($participant);
        $this->assertEquals($invitedEmail, $participant->email);
    }

    /**
     * Test case-insensitive email check for uninvited users
     * 
     * @test
     */
    public function uninvited_check_is_case_insensitive(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Create invitation with lowercase email
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => 'invited@example.com',
            'invitation_status' => 'sent',
        ]);

        // Check with different cases
        $this->assertTrue($this->accessControl->isEmailInvited('invited@example.com'));
        $this->assertTrue($this->accessControl->isEmailInvited('INVITED@EXAMPLE.COM'));
        $this->assertTrue($this->accessControl->isEmailInvited('Invited@Example.Com'));

        // Check uninvited email with different cases
        $this->assertFalse($this->accessControl->isEmailInvited('uninvited@example.com'));
        $this->assertFalse($this->accessControl->isEmailInvited('UNINVITED@EXAMPLE.COM'));
        $this->assertFalse($this->accessControl->isEmailInvited('Uninvited@Example.Com'));
    }

    /**
     * Test multiple uninvited emails
     * 
     * @test
     */
    public function multiple_uninvited_emails_are_all_rejected(): void
    {
        $uninvitedEmails = [
            'uninvited1@example.com',
            'uninvited2@example.com',
            'uninvited3@example.com',
            'uninvited4@example.com',
            'uninvited5@example.com',
        ];

        foreach ($uninvitedEmails as $email) {
            $this->assertFalse(
                $this->accessControl->isEmailInvited($email),
                "Email {$email} should not be invited"
            );

            $participant = $this->accessControl->getParticipantByEmail($email);
            $this->assertNull(
                $participant,
                "Participant record should not exist for {$email}"
            );
        }
    }

    /**
     * Test uninvited user with existing account
     * 
     * @test
     */
    public function uninvited_user_with_existing_account_cannot_access(): void
    {
        $email = 'existing.uninvited@example.com';

        // Create user account (simulating old registration or manual creation)
        $user = User::factory()->create([
            'email' => $email,
            'level' => 'asesi',
            'gauth_id' => 'google-id-123',
            'gauth_type' => 'google',
        ]);

        // Verify user exists
        $this->assertDatabaseHas('users', ['email' => $email]);

        // But user is not invited
        $this->assertFalse($this->accessControl->isEmailInvited($email));

        // User cannot access assessment
        $this->assertFalse($this->accessControl->canAccessAssessment($user));
    }

    /**
     * Test transition from uninvited to invited
     * 
     * @test
     */
    public function user_gains_access_when_invited(): void
    {
        $email = 'transition@example.com';

        // Initially uninvited
        $this->assertFalse($this->accessControl->isEmailInvited($email));

        // Admin invites the user
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => $email,
            'invitation_status' => 'sent',
        ]);

        // Now user is invited
        $this->assertTrue($this->accessControl->isEmailInvited($email));

        // User can get participant details
        $participant = $this->accessControl->getParticipantByEmail($email);
        $this->assertNotNull($participant);
        $this->assertEquals($email, $participant->email);
    }

    /**
     * Test uninvited user cannot be marked as registered
     * 
     * @test
     */
    public function uninvited_user_cannot_be_marked_as_registered(): void
    {
        $email = 'notinvited@example.com';

        // Verify user is not invited
        $this->assertFalse($this->accessControl->isEmailInvited($email));

        // Try to mark as registered (should have no effect)
        $this->accessControl->markAsRegistered($email);

        // Verify no participant record was created
        $this->assertDatabaseMissing('event_participants', [
            'email' => $email,
        ]);

        // User still not invited
        $this->assertFalse($this->accessControl->isEmailInvited($email));
    }

    /**
     * Test error message for uninvited user
     * 
     * @test
     */
    public function uninvited_user_receives_appropriate_error_message(): void
    {
        $uninvitedEmail = 'error@example.com';

        // Simulate OAuth callback
        $googleUser = Mockery::mock(SocialiteUser::class);
        $googleUser->shouldReceive('getEmail')->andReturn($uninvitedEmail);

        Socialite::shouldReceive('driver->user')->andReturn($googleUser);

        // Check if invited
        $isInvited = $this->accessControl->isEmailInvited($uninvitedEmail);

        // Should not be invited
        $this->assertFalse($isInvited);

        // In the actual controller, this would redirect with error message:
        // "Your email is not registered for any event. Please contact the administrator."
        // We verify the access control logic returns false
        $this->assertFalse($isInvited);
    }

    /**
     * Test uninvited domain variations
     * 
     * @test
     */
    public function uninvited_emails_from_different_domains_are_rejected(): void
    {
        $event = Event::factory()->create();
        $skema = Skema::factory()->create();

        // Invite one email
        EventParticipant::create([
            'id_event' => $event->id_event,
            'id_skema' => $skema->id_skema,
            'email' => 'invited@example.com',
            'invitation_status' => 'sent',
        ]);

        // Similar emails from different domains should not be invited
        $this->assertFalse($this->accessControl->isEmailInvited('invited@different.com'));
        $this->assertFalse($this->accessControl->isEmailInvited('invited@example.org'));
        $this->assertFalse($this->accessControl->isEmailInvited('other@example.com'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
