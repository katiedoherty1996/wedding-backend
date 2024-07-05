<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;

class SendEnquiryController extends Controller
{
    public function sendEnquiry(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'message' => 'required',
        // ]);

        $cardId = !empty($request->cardId) ? $request->cardId : null;

        if(!empty($cardId)){
            Card::sendCustomerCardEnquiry($cardId, $request);
        } else{
            return response()->json(['message' => 'Email Not Sent']);

        }
    }
}
