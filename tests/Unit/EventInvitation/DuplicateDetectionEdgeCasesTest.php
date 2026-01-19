<?php

namespace Tests\Unit\EventInvitation;

use App\Exceptions\DuplicateEmailException;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use App\Services\ParticipantManagementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Unit Test: Duplicate Detection Edge Cases
 * 
 * Tests edge cases for duplicate email detection including:
 * - Same email different case
 * - Email with leading/trailing spaces
 * - Duplicate within bulk batch
 * 
 * **Validates: Requirements 13.3, 13.5**
 */
class DuplicateDetectionEdgeCasesTest extends TestCase
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
     * Test that same email with different case is detected as duplicate
     * 
     * @test
     */
    public function same_email_different_case_is_detected_as_duplicate(): void
    {
        // Add participant with lowercase email
        $this->participantService->addParticipant(
            $this->event->id_event,
            $this->skema->id_skema,
            'test@example.com'
        );

        // Try to add same email with different case variations
  