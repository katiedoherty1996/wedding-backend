<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerEnquiryMailForCard;
use App\Models\Product;
use App\Models\ProductDetails;

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
    public function show(ProductDetails $productDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductDetails $productDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDetails $productDetails)
    {
        //
    }

    public function sendEmailWithCardDetails(Request $request)
    {
        $cardId = $request->query('cardId');
        // Retrieve the product details from the database
        $productDetails = Product::find($cardId);

        // Check if the product details are retrieved successfully
        if ($productDetails) {
            // Create an instance of the CustomerEnquiryMail Mailable class
            $mail = new CustomerEnquiryMailForCard($productDetails);

            // Send the email
            Mail::to('katiedoherty222@gmail.com')->send($mail);

            // Return success message
            return response()->json(['message' => 'Email sent successfully']);
        } else {
            // Return error message if product details are not found
            return response()->json(['error' => 'Product details not found'], 404);
        }
    }
}
