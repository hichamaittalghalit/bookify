<?php

namespace App\Mail;

use App\Models\ReceivedEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $receivedEmail;
    public $replyMessage;
    public $replySubject;

    /**
     * Create a new message instance.
     */
    public function __construct(ReceivedEmail $receivedEmail, string $replyMessage, string $replySubject = null)
    {
        $this->receivedEmail = $receivedEmail;
        $this->replyMessage = $replyMessage;
        $this->replySubject = $replySubject ?? __('mail.re_re') . ': ' . $receivedEmail->subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->replySubject,
            replyTo: [config('mail.from.address')],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-reply',
            with: [
                'receivedEmail' => $this->receivedEmail,
                'replyMessage' => $this->replyMessage,
            ],
        );
    }
}
