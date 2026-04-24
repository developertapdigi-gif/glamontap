<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class AgencyRegister extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $token;
    /**
     * Create a new message instance.
     */
    public function __construct($name,$token)
    {
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new address(config('mail.from.address'),config('app.name')),
            replyTo: [
                new Address(config('mail.reply.email'),config('mail.reply.name')),
            ],
            subject: 'Welcome to Tradehook',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.agency_register',
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
