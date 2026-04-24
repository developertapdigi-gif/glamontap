<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class SubscriptionPaymentReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $agencyName;
    public $endDate;
    public $amount;
    /**
     * Create a new message instance.
     */
    public function __construct($agencyName,$endDate,$amount)
    {
        $this->agencyName = $agencyName;
        $this->endDate = $endDate;
        $this->amount = $amount;
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
            subject: 'Your account renews in 5 days',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_reminder',
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
