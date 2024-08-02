<?php

namespace App\Http\Controllers;

use App\Models\MassBooklet;
use Illuminate\Http\Request;

class MassBookletController extends Controller
{
    //get mass booklets
    public function index()
    {
        $cards = MassBooklet::whereNull('deletedDateTime')->get();
         // Transform the cards data and rename the columns
         $transformedCards = $cards->map(function ($card) {
            return [
                'id'             => $card->id,
                'invitationName' => $card->cardName,
                'image'          => $card->mainImage,
                'price'          => $card->price,
                'priceLowGrade'  => $card->priceLowGrade,
                'priceHighGrade' => $card->priceHighGrade,
                'categoryId'     => $card->categoryId,
                'pageNo'         => null,
                // Add more fields as needed
            ];
        });
        return response()->json($transformedCards);
    }
}
