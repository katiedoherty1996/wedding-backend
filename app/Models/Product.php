<?php

namespace App\Models;

use App\Mail\CustomerEnquiryMailForCard;
use Aws\Ses\Exception\SesException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class Product extends Model
{
    protected $table = 'products';

    public function productDetails()
    {
        return $this->hasMany(ProductDetails::class, 'productId', 'id');
    }

    // Define the relationship with the Price model
    public function prices()
    {
        return $this->hasMany(Price::class, 'productId', 'id');
    }

    /**
     * get tthe prices for a singular wedding invitation
     *
     * @return void
     */
    public function weddingInvitationCardPrices(){
        return $this->hasOne(Price::class, 'productId', 'id')
                    ->whereNull('deletedDateTime')
                    ->where('productTypeId', ProductType::WEDDING_INVITATIONS);
    }

    // Scope to filter cards where deletedDateTime is null
    public function scopeActive($query)
    {
        return $query->whereNull('deletedDateTime');
    }

    public static function sendCustomerCardEnquiry($cardId = null, Request $request){
        try{
            $productDetails = null;
            
            // Retrieve the product details from the database
            if(!empty($cardId)){
                $productDetails = Product::find($cardId);
            }

            // Create an instance of the CustomerEnquiryMail Mailable class
            $mail = new CustomerEnquiryMailForCard($productDetails, $request);

            // Send the email
            Mail::to('katiedoherty222@gmail.com')->send($mail);

            // Return success message
            return response()->json(['message' => 'Email sent successfully', 'sent' => true]);

        } catch(SesException $e){
            // Return success message
            return response()->json(['message' => 'Email did not send', 'sent' => false], 500);
        } catch (\Exception $e) {
            // Handle all other exceptions
            return response()->json(['error' => 'Failed to send email. Please try again later.', 'sent' => false], 500);
        }
    }
}