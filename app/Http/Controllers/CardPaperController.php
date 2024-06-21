<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardDetails;
use App\Models\CardPaper;
use Illuminate\Http\Request;
use stdClass;

class CardPaperController extends Controller
{
    public function index()
    {
        $cardPaperRecords = CardPaper::whereNull('deletedDateTime')->get();
         // Transform the cards data and rename the columns
         $cardPaperTypes = $cardPaperRecords->map(function ($cardPaper) {
            return [
                'cardPaperId'       => $cardPaper->id,
                'cardPaperName'     => $cardPaper->cardPaperName,
                'cardPaperVariable' => $cardPaper->cardPaperVariable
                // Add more fields as needed
            ];
        });
        return response()->json($cardPaperTypes);
    }
}