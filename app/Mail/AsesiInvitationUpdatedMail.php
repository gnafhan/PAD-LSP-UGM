<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Skema;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AsesiInvitationUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public EventParticipant $participant,
        public Event $event,
        public Skema $skema
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembaruan: Informasi Event Sertifikasi - ' . $this->event->nama_event,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.asesi-invitation-updated',
            with: [
                'eventName' => $this->event->nama_event,
                'eventDates' => $this->event->rentang_waktu,
                'skemaName' => $this->skema->nama_skema,
                'loginUrl' => route('oauth.google'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
