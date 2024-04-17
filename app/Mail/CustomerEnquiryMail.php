<?php

namespace App\Mail;

use App\Models\Card;
use App\Models\CardDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class CustomerEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cardDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(Card $cardDetails)
    {
        $this->cardDetails = $cardDetails;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('hello@example.com', 'Katie Doherty'),
            subject: 'Enquiry About A Card',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customerEnquiry',
            with: [
                'cardName' => $this->cardDetails->cardName,
                'cardImage' => $this->cardDetails->mainImage,
                'cardPrice' => $this->cardDetails->price,
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
