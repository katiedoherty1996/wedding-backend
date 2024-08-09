<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Aws\Ses\Exception\SesException;
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

        try{
            $cardId = !empty($request->cardId) ? $request->cardId : null;
            Product::sendCustomerCardEnquiry($cardId, $request);

            // Return success message
            return response()->json(['message' => 'We have recieved your email and will be in touch shortly.', 'sent' => true]);
        } catch(SesException $e){
            // Handle all other exceptions
            return response()->json(['message' => $e->getMessage(), 'sent' => false], 500);
        } catch (\Exception $e) {
            // Handle all other exceptions
            return response()->json(['message' => $e->getMessage(), 'sent' => false], 500);
        }
    }
}
