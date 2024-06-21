<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardDetails;
use Illuminate\Http\Request;
use stdClass;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::whereNull('deletedDateTime')->get();
         // Transform the cards data and rename the columns
         $transformedCards = $cards->map(function ($card) {
            return [
                'id'             => $card->id,
                'invitationName' => $card->cardName,
                'image'          => $card->mainImage,
                'price'          => $card->price,
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

        $card                              = Card::find($id);
        $cardDetailsObject->cardName       = $card->cardName;
        $cardDetailsObject->description    = $card->description;
        $cardDetailsObject->price          = $card->price;
        $cardDetailsObject->priceHighGrade = $card->priceHighGrade;
        $cardDetailsObject->priceLowGrade  = $card->priceLowGrade;

        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        $cardDetails = $card->cardDetails;

        $cardDetailsObject->images = $cardDetails->map(function ($card) {
            return [
                'key'         => $card->key,
                'image'       => $card->image,
                // Add more fields as needed
            ];
        });


        // Return the record as JSON response
        return response()->json($cardDetailsObject);
    }
}