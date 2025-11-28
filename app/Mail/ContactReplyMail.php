<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $replyMessage;
    public $replySubject;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact, string $replyMessage, string $replySubject = null)
    {
        $this->contact = $contact;
        $this->replyMessage = $replyMessage;
        $this->replySubject = $replySubject ?? __('mail.re_re') . ': ' . $contact->object;
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
            view: 'emails.contact-reply',
            with: [
                'contact' => $this->contact,
                'replyMessage' => $this->replyMessage,
            ],
        );
    }
}
