<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $book;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Book $book)
    {
        $this->order = $order;
        $this->book = $book;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('email.book_purchase_subject', ['title' => $this->book->title]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.book-purchase',
            with: [
                'order' => $this->order,
                'book' => $this->book,
                'user' => $this->order->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach the book file if it exists
        if ($this->book->path) {
            $filename = ($this->book->slug ?: Str::slug($this->book->title)) . '.pdf';
            
            // Try storage first (books/pdfs/slug.pdf)
            if (Storage::disk('public')->exists($this->book->path)) {
                $attachments[] = Attachment::fromStorageDisk('public', $this->book->path)
                    ->as($filename)
                    ->withMime('application/pdf');
            } 
            // Try public path
            elseif (file_exists(public_path($this->book->path))) {
                $attachments[] = Attachment::fromPath(public_path($this->book->path))
                    ->as($filename)
                    ->withMime('application/pdf');
            }
            // Try absolute path
            elseif (file_exists($this->book->path)) {
                $attachments[] = Attachment::fromPath($this->book->path)
                    ->as($filename)
                    ->withMime('application/pdf');
            }
        }

        return $attachments;
    }
}

