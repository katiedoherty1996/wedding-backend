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
            return response()->json(['message' => 'Email Successfully Sent']);
        } else{
            return response()->json(['message' => 'Email Not Sent']);
            // $name = $request->query('name');
            // $phoneNumber = $request->query('phoneNumber');
            // $email = $request->query('email');
            // $customerMessage = $request->query('customerMessage');

            // try {
            //     $sesClient = new SesClient([
            //         'version' => 'latest',
            //         'region'  => config('services.ses.region'),
            //         'credentials' => [
            //             'key'    => config('services.ses.key'),
            //             'secret' => config('services.ses.secret'),
            //         ],
            //     ]);

            //     $sesClient->sendEmail([
            //         'Source' => 'katiedoherty222@gmail.com',  // Use your verified email as the Source
            //         'Destination' => [
            //             'ToAddresses' => ['katiedoherty222@gmail.com'],
            //         ],
            //         'Message' => [
            //             'Subject' => [
            //                 'Data' => 'New Enquiry From Website',
            //                 'Charset' => 'UTF-8',
            //             ],
            //             'Body' => [
            //                 'Text' => [
            //                     'Data' => "You have received a new message from $email:\n\$customerMessage",
            //                     'Charset' => 'UTF-8',
            //                 ],
            //             ],
            //         ],
            //         'ReplyToAddresses' => [$email], // Set the Reply-To header to the user's email
            //     ]);

            //     return response()->json(['message' => 'Email sent successfully']);

            // } catch (SesException $e) {
            //     return response()->json(['error' => 'Email not sent, ' . $e->getAwsErrorMessage()], 404);
            // }

        }
    }
}
