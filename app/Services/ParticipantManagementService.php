<?php

namespace App\Services;

use App\Models\EventParticipant;
use App\Exceptions\DuplicateEmailException;
use App\Exceptions\InvalidEmailException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

/**
 * Service for managing event participants
 * 
 * This service handles all participant-related business logic including adding,
 * updating, removing participants, and validating email addresses.
 * Requirements: 1.2, 1.3, 1.5, 2.4, 2.5, 2.6, 2.8, 9.2, 9.3, 10.2, 12.1, 12.4, 13.1, 13.5
 */
class ParticipantManagementService
{
    /**
     * Email invitation service dependency
     */
    private EmailInvitationService $emailService;

    /**
     * Create a new service instance
     * 
     * @param EmailInvitationService $emailService
     */
    public function __construct(EmailInvitationService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Add a single participant to an event
     * 
     * Validates email format, checks for global uniqueness, creates the participant
     * record, and sends an invitation email.
     * 
     * @param string $eventId The event ID
     * @param string $skemaId The skema ID
     * @param string $email The participant's email address
     * @return EventParticipant The created participant
     * @throws InvalidEmailException if email format is invalid
     * @throws DuplicateEmailException if email already exists in system
     * 
     * Requirements: 1.2, 1.3, 2.4, 13.1, 13.5
     */
    public function addParticipant(
        string $eventId,
        string $skemaId,
        string $email
    ): EventParticipant {
        // Normalize email to lowercase
        $email = strtolower(trim($email));

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException("Invalid email format: {$email}");
        }

        // Check if email already exists in system
        if ($this->emailExists($email)) {
            throw new DuplicateEmailException("Email {$email} is already registered in another event");
        }

        // Create participant record
        $participant = EventParticipant::create([
            'id_event' => $eventId,
            'id_skema' => $skemaId,
            'email' => $email,
            'invitation_status' => 'pending',
        ]);

        // Send invitation email
        $this->emailService->sendInvitation($participant);

        return $participant;
    }

    /**
     * Add multiple participants via bulk input
     * 
     * Parses, normalizes, and validates an array of email addresses, checks for
     * duplicates within the batch and in the system, then creates all participants
     * in a transaction and sends invitation emails.
     * 
     * @param string $eventId The event ID
     * @param string $skemaId The skema ID to assign to all participants
     * @param array $emails Array of email addresses
     * @return array Array of created EventParticipant instances
     * @throws InvalidEmailException if any email format is invalid
     * @throws DuplicateEmailException if any email already exists or batch contains duplicates
     * 
     * Requirements: 2.4, 2.5, 2.6, 2.8, 13.3
     */
    public function addBulkParticipants(
        string $eventId,
        string $skemaId,
        array $emails
    ): array {
        // Parse and normalize email array (trim, lowercase, unique)
        $emails = array_map('strtolower', array_map('trim', $emails));
        $emails = array_unique($emails);

        // Validate all emails first
        $invalidEmails = [];
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $invalidEmails[] = $email;
            }
        }

        if (!empty($invalidEmails)) {
            throw new InvalidEmailException("Invalid email formats: " . implode(', ', $invalidEmails));
        }

        // Check for duplicates within the batch
        $batchDuplicates = $this->findBatchDuplicates($emails);
        if (!empty($batchDuplicates)) {
            throw new DuplicateEmailException("Duplicate emails in batch: " . implode(', ', $batchDuplicates));
        }

        // Check for duplicates in system
        $duplicates = $this->findDuplicateEmails($emails);
        if (!empty($duplicates)) {
            throw new DuplicateEmailException("Emails already registered: " . implode(', ', $duplicates));
        }

        // Create all participants in transaction
        $participants = [];
        DB::transaction(function () use ($eventId, $skemaId, $emails, &$participants) {
            foreach ($emails as $email) {
                $participant = EventParticipant::create([
                    'id_event' => $eventId,
                    'id_skema' => $skemaId,
                    'email' => $email,
                    'invitation_status' => 'pending',
                ]);
                $participants[] = $participant;
            }

            // Send all invitations
            foreach ($participants as $participant) {
                $this->emailService->sendInvitation($participant);
            }
        });

        return $participants;
    }

    /**
     * Update participant's skema
     * 
     * Updates the skema assigned to a participant and sends an updated invitation email.
     * 
     * @param int $participantId The participant ID
     * @param string $newSkemaId The new skema ID
     * @return EventParticipant The updated participant
     * 
     * Requirements: 9.2, 9.3
     */
    public function updateParticipantSkema(
        int $participantId,
        string $newSkemaId
    ): EventParticipant {
        $participant = EventParticipant::findOrFail($participantId);
        $participant->update(['id_skema' => $newSkemaId]);

        // Send updated invitation
        $this->emailService->sendUpdatedInvitation($participant);

        return $participant;
    }

    /**
     * Remove participant and revoke access
     * 
     * Deletes a participant record and logs the removal for audit trail.
     * 
     * @param int $participantId The participant ID to remove
     * @return void
     * 
     * Requirements: 1.5, 12.1, 12.4
     */
    public function removeParticipant(int $participantId): void
    {
        $participant = EventParticipant::findOrFail($participantId);
        
        // Log the removal for audit
        Log::info('Participant removed', [
            'participant_id' => $participantId,
            'email' => $participant->email,
            'event_id' => $participant->id_event,
            'removed_by' => auth()->id(),
            'removed_at' => now(),
        ]);

        $participant->delete();
    }

    /**
     * Check if email exists in any event
     * 
     * Performs case-insensitive check for email existence across all events.
     * 
     * @param string $email The email to check
     * @return bool True if email exists, false otherwise
     * 
     * Requirements: 1.3
     */
    public function emailExists(string $email): bool
    {
        return EventParticipant::where('email', strtolower($email))->exists();
    }

    /**
     * Find duplicate emails from array
     * 
     * Checks which emails from the provided array already exist in the system.
     * 
     * @param array $emails Array of emails to check
     * @return array Array of emails that already exist
     * 
     * Requirements: 2.5
     */
    private function findDuplicateEmails(array $emails): array
    {
        return EventParticipant::whereIn('email', $emails)->pluck('email')->toArray();
    }

    /**
     * Find duplicates within the batch itself
     * 
     * Identifies emails that appear more than once in the provided array.
     * 
     * @param array $emails Array of emails to check
     * @return array Array of duplicate emails
     * 
     * Requirements: 2.5
     */
    private function findBatchDuplicates(array $emails): array
    {
        $counts = array_count_values($emails);
        return array_keys(array_filter($counts, fn($count) => $count > 1));
    }

    /**
     * Get participants grouped by skema for an event
     * 
     * Retrieves all participants for an event with their skema and user relationships,
     * grouped by skema ID.
     * 
     * @param string $eventId The event ID
     * @return Collection Collection of participants grouped by skema
     * 
     * Requirements: 10.2
     */
    public function getParticipantsBySkema(string $eventId): Collection
    {
        return EventParticipant::with(['skema', 'user'])
            ->where('id_event', $eventId)
            ->get()
            ->groupBy('id_skema');
    }
}
