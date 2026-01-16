<?php

namespace App\Jobs;

use App\Models\EventParticipant;
use App\Mail\AsesiInvitationMail;
use App\Mail\AsesiInvitationUpdatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEventInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 120;
    public $backoff = [10, 30, 60];

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $participantId,
        public bool $isUpdate = false
    ) {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $participant = EventParticipant::with(['event', 'skema'])->find($this->participantId);

        if (!$participant) {
            Log::warning("Participant not found for email job", ['participant_id' => $this->participantId]);
            return;
        }

        try {
            $event = $participant->event;
            $skema = $participant->skema;

            if ($this->isUpdate) {
                Mail::to($participant->email)->send(
                    new AsesiInvitationUpdatedMail($participant, $event, $skema)
                );
            } else {
                Mail::to($participant->email)->send(
                    new AsesiInvitationMail($participant, $event, $skema)
                );
            }

            $participant->update([
                'invitation_status' => 'sent',
                'invitation_sent_at' => now(),
            ]);

            Log::info("Invitation email sent successfully", [
                'participant_id' => $this->participantId,
                'email' => $participant->email,
                'is_update' => $this->isUpdate
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send invitation email", [
                'participant_id' => $this->participantId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Invitation email job failed permanently", [
            'participant_id' => $this->participantId,
            'error' => $exception->getMessage()
        ]);

        $participant = EventParticipant::find($this->participantId);
        if ($participant) {
            $participant->update([
                'invitation_status' => 'failed',
            ]);
        }
    }
}
