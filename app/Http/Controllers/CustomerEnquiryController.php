<?php

namespace App\Http\Controllers;

use App\Models\CardDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerEnquiryMail;
use App\Models\Card;

class CustomerEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CardDetails $cardDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CardDetails $cardDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CardDetails $cardDetails)
    {
        //
    }

    public function sendEmailWithCardDetails(Request $request)
    {
        $cardId = $request->query('cardId');
        // Retrieve the card details from the database
        $cardDetails = Card::find($cardId);

        // Check if the card details are retrieved successfully
        if ($cardDetails) {
            // Create an instance of the CustomerEnquiryMail Mailable class
            $mail = new CustomerEnquiryMail($cardDetails);

            // Send the email
            Mail::to('kdoherty@mtx.ie')->send($mail);

            // Return success message
            return response()->json(['message' => 'Email sent successfully']);
        } else {
            // Return error message if card details are not found
            return response()->json(['error' => 'Card details not found'], 404);
        }
    }
}
