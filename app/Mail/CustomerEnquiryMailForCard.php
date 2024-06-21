<?php

namespace App\Mail;

use App\Models\Card;
use App\Models\CardDetails;
use App\Models\CardPaper;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Symfony\Component\Process\Process;

class CustomerEnquiryMailForCard extends Mailable
{
    use Queueable, SerializesModels;

    public $cardDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(Card $cardDetails, Request $request)
    {
        $this->cardDetails = $cardDetails;
        $this->request     = $request;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('katiedoherty222@gmail.com', 'Katie Doherty'),
            replyTo: [new Address($this->request->email)],
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
                'cardId'          => $this->cardDetails->id,
                'cardName'        => $this->cardDetails->cardName,
                'cardImage'       => $this->cardDetails->mainImage,
                'cardPrice'       => $this->request->cardPaper['cardPaperName'],
                'name'            => $this->request->name,
                'email'           => $this->request->email,
                'phoneNumber'     => $this->request->phoneNumber,
                'customerMessage' => $this->request->customerMessage,
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
