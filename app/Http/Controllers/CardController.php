<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardDetails;
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
                ->where('prices.productTypeId', 1);
        })
        ->whereNull('cards.deletedDateTime')
        ->select('cards.*', 'prices.*') // Select all fields from both tables
        ->get();
        
         // Transform the cards data and rename the columns
         $transformedCards = $cards->map(function ($card) {
            return [
                'id'             => $card->id,
                'invitationName' => $card->cardName,
                'image'          => $card->mainImage,
                'price'          => $card->price,
                'priceLowGrade'  => $card->priceLow,
                'priceHighGrade' => $card->priceHigh,
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
        $cardDetailsObject->description    = $card->cardDescription;
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