<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardDetails;
use App\Models\Price;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class CardController extends Controller
{
    public function index()
    {
        // Fetch all fields from both cards and prices
        $cards = DB::table('cards')
        ->leftJoin('prices', function ($join) {
            $join->on('cards.id', '=', 'prices.productId')
                ->whereNull('prices.deletedDateTime')
                ->where('prices.productTypeId', ProductType::WEDDING_INVITATIONS);
        })
        ->leftJoin('carddetails', function ($join) {
            $join->on('cards.mainImageId', '=', 'carddetails.id')
                ->whereNull('carddetails.deletedDateTime'); // Include condition for not deleted records in carddetails
        })
        ->whereNull('cards.deletedDateTime')
        ->select('cards.id AS cardId', 'cards.*', 'prices.*', 'carddetails.image') // Select all fields from both tables
        ->get();
        
         // Transform the cards data and rename the columns
         $transformedCards = $cards->map(function ($card) {
            return [
                'id'             => $card->cardId,
                'invitationName' => $card->cardName,
                'image'          => $card->image,
                'price'          => $card->price,
                'priceLowGrade'  => $card->priceLow,
                'priceHighGrade' => $card->priceHigh,
                'samplePrice'    => $card->samplePrice,
                'categoryId'     => $card->categoryId,
                'pageNo'         => null,
                // Add more fields as needed
            ];
        });
        return response()->json($transformedCards);
    }

    public function getWeddingCardDetails(Request $request){
        // Retrieve the record from the database based on the ID
        $id = $request->query('id');
        $cardDetailsObject              = new stdClass();
        $cardDetailsObject->cardName    = null;
        $cardDetailsObject->description = null;
        $cardDetailsObject->price       = null;
        $cardDetailsObject->images      = null;

        /**
         * get the card
         */
        $card = Card::find($id);
        

        /**
         * get the prices for the wedding invitation the user clicked on
        */
        $prices = $card->weddingInvitationCardPrices;

        /**
         * Fill in the returned cardDetailsObject
         */
        $cardDetailsObject->cardName       = $card->cardName;
        $cardDetailsObject->description    = $card->cardDescription;
        $cardDetailsObject->price          = !empty($prices) ? $prices->price : null;
        $cardDetailsObject->priceHighGrade = !empty($prices) ? $prices->priceHigh : null;
        $cardDetailsObject->priceLowGrade  = !empty($prices) ? $prices->priceLow : null;
        $cardDetailsObject->samplePrice    = !empty($prices) ? $prices->samplePrice : null;

        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        $cardDetails = $card->cardDetails;

        $cardDetailsObject->images = $cardDetails->map(function ($card) {
            return [
                'key'         => $card->key,
                'image'       => $card->image,
            ];
        });


        // Return the record as JSON response
        return response()->json($cardDetailsObject);
    }
}