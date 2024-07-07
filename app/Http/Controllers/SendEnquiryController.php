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
        $request->validate([
            'name'            => 'required',
            'phoneNumber'     => 'required',
            'email'           => 'required',
            'customerMessage' => 'required',
        ]);

        $cardId = !empty($request->cardId) ? $request->cardId : null;
        Card::sendCustomerCardEnquiry($cardId, $request);
    }
}
