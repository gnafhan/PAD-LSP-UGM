<?php

namespace Tests\Unit\EventInvitation;

use App\Exceptions\InvalidEmailException;
use App\Models\Event;
use App\Models\Skema;
use App\Services\ParticipantManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Unit Test: Email Validation Edge Cases
 * 
 * Tests edge cases for email validation including:
 * - Empty string
 * - Email with special characters
 * - Very long email
 * - Email without @ symbol
 * 
 * **Validates: Requirements 2.4, 13.1, 13.2**
 */
class EmailValidationEdgeCasesTest extends TestCase
{
    use RefreshDatabase;

    private ParticipantManagementService $participantService;
    private Event $event;
    private Skema $skema;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        $this->participantService = app(ParticipantManagementService::class);
        $this->event = Event::factory()->create();
        $this->skema = Skema::factory()->create();
    }

    /**
     * Test that empty string is rejected
     * 
     * @test
     */
    public function empty_string_email_is_rejected(): void
    {
        $this->expectException(InvalidEmailException::class);
        $this->expectExceptionMessage('Invalid email format:');

        $this->participantService->addParticipant(
            $this->event->id_event,
            $this->skema->id_skema,
            ''
        );
    }

    /**
     * Test that email with valid special characters is accepted
     * 
     * @test
     */
    public function email_with_valid_special_characters_is_accepted(): void
    {
        $validEmails = [
            'user+tag@example.com',
            'user.name@example.com',
            'user_name@example.com',
            'user-name@example.com',
            'user123@example.com',
        ];

        foreach ($validEmails as $email) {
            $participant = $this->participantService->addParticipant(
                $this->event->id_event,
                $this->skema->id_skema,
                $email
            );

            $this->assertDatabaseHas('event_participants', [
                'email' => strtolower($email),
            ]);

            // Clean up for next iteration
            $participant->delete();
        }
    }

    /**
     * Test that email with invalid special characters is rejected
     * 
     * @test
     */
    public function email_with_invalid_special_characters_is_rejected(): void
    {
        $invalidEmails = [
            'user@name@example.com',
            'user name@example.com',
            'user#name@example.com',
            '@example.com',
            'user@',
        ];

        foreach ($invalidEmails as $email) {
            try {
                $this->participantService->addParticipant(
                    $this->event->id_event,
                    $this->skema->id_skema,
                    $email
                );
                $this->fail("Expected InvalidEmailException for email: {$email}");
            } catch (InvalidEmailException $e) {
                $this->assertStringContainsString('Invalid email format', $e->getMessage());
            }
        }
    }

    /**
     * Test that very long email is handled correctly
     * 
     * @test
     */
    public function very_long_email_is_handled_correctly(): void
    {
        $longLocalPart = str_repeat('a', 64);
        $longEmail = $longLocalPart . '@example.com';

        if (filter_var($longEmail, FILTER_VALIDATE_EMAIL)) {
            $participant = $this->participantService->addParticipant(
                $this->event->id_event,
                $this->skema->id_skema,
                $longEmail
            );

            $this->assertDatabaseHas('event_participants', [
                'email' => strtolower($longEmail),
            ]);
        } else {
            $this->expectException(InvalidEmailException::class);
            $this->participantService->addParticipant(
                $this->event->id_event,
                $this->skema->id_skema,
                $longEmail
            );
        }
    }

    /**
     * Test that email without @ symbol is rejected
     * 
     * @test
     */
    public function email_without_at_symbol_is_rejected(): void
    {
        $invalidEmails = [
            'userexample.com',
            'user.example.com',
            'user',
            'example.com',
        ];

        foreach ($invalidEmails as $email) {
            try {
                $this->participantService->addParticipant(
                    $this->event->id_event,
                    $this->skema->id_skema,
                    $email
                );
                $this->fail("Expected InvalidEmailException for email without @: {$email}");
            } catch (InvalidEmailException $e) {
                $this->assertStringContainsString('Invalid email format', $e->getMessage());
            }
        }
    }
}
