<?php

namespace App\Mail;


use App\Models\Product;
use App\Models\ProductDetails;
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

    public $productDetails;
    public $request;

    /**
     * Create a new message instance.
     */
    public function __construct(Product $productDetails = null, Request $request)
    {
        $this->productDetails = $productDetails;
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
            subject: 'Enquiry About A Product',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if(!empty($this->productDetails)){
            $cardDetailsImage = ProductDetails::find($this->productDetails->mainImageId);
        }
        return new Content(
            view: 'emails.customerEnquiry',
            with: [
                'productId'       => !empty($this->productDetails) ? $this->productDetails->id : null,
                'productName'     => !empty($this->productDetails) ? $this->productDetails->name : null,
                'image'           => !empty($cardDetailsImage) ? $cardDetailsImage->image : null,
                'cardPrice'       => !empty($this->productDetails) ? $this->request->cardPaper['cardPaperName'] : null,
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
