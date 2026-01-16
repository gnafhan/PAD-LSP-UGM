<?php

namespace App\Services;

use App\Models\EventParticipant;
use App\Jobs\SendEventInvitationEmail;

/**
 * Service for handling email invitations to event participants
 * 
 * This service manages sending invitation emails when participants are added
 * or updated using queue jobs for better performance and reliability.
 * Requirements: 3.1, 3.2, 3.3, 9.4
 */
class EmailInvitationService
{
    /**
     * Queue invitation email to participant
     * 
     * Dispatches a job to send an email invitation to a newly added participant.
     * The job will be processed asynchronously by the queue worker.
     * 
     * @param EventParticipant $participant The participant to send invitation to
     * @return void
     * 
     * Requirements: 3.1, 3.2
     */
    public function sendInvitation(EventParticipant $participant): void
    {
        // Update status to pending immediately
        $participant->update([
            'invitation_status' => 'pending',
        ]);

        // Dispatch job to queue
        SendEventInvitationEmail::dispatch($participant->id, false);
    }

    /**
     * Queue updated invitation when skema changes
     * 
     * Dispatches a job to send an updated invitation email when a participant's skema is changed.
     * The job will be processed asynchronously by the queue worker.
     * 
     * @param EventParticipant $participant The participant to send updated invitation to
     * @return void
     * 
     * Requirements: 3.3, 9.4
     */
    public function sendUpdatedInvitation(EventParticipant $participant): void
    {
        // Update status to pending immediately
        $participant->update([
            'invitation_status' => 'pending',
        ]);

        // Dispatch job to queue
        SendEventInvitationEmail::dispatch($participant->id, true);
    }
}
