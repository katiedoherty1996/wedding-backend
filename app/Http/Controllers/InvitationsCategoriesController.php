<?php

namespace App\Http\Controllers;

use App\Models\InvitationCategory;
use Illuminate\Http\Request;

class InvitationsCategoriesController extends Controller
{
    public static function getInvitationCategories(){
        $invitationCategories = InvitationCategory::whereNull('deletedDateTime')->get();

         // Transform the cards data and rename the columns
         $transformedCategories = $invitationCategories->map(function ($category) {
            return [
                'optionId'   => $category->id,
                'optionName' => $category->categoryName,
                // Add more fields as needed
            ];
        });
        return response()->json($transformedCategories);
    }
}
