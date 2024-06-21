<?php

namespace App\Models;

use App\Mail\CustomerEnquiryMailForCard;
use Aws\Ses\Exception\SesException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Card extends Model
{
    protected $table = 'cards';

    public function cardDetails()
    {
        return $this->hasMany(CardDetails::class, 'cardId', 'id');
    }

    public static function sendCustomerCardEnquiry($cardId, Request $request){
        try{
            // Retrieve the card details from the database
            $cardDetails = Card::find($cardId);

            // Check if the card details are retrieved successfully
        if ($cardDetails) {
            // Create an instance of the CustomerEnquiryMail Mailable class
            $mail = new CustomerEnquiryMailForCard($cardDetails, $request);

            // Send the email
            Mail::to('katiedoherty222@gmail.com')->send($mail);

            // Return success message
            return response()->json(['message' => 'Email sent successfully']);
        } else {
            // Return error message if card details are not found
            return response()->json(['error' => 'Card details not found'], 404);
        }

        } catch(SesException $e){
            // Return success message
            return response()->json(['message' => 'Email did not send']);
        }
    }
}
