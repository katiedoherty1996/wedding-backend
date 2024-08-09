<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
        Product::sendCustomerCardEnquiry($cardId, $request);
    }
}
