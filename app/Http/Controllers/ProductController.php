<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the value of productTypeVariable from the query parameters
        $productTypeVariable = $request->query('productTypeVariable');

        //get the product type
        $productType = ProductType::where('productTypeVariable', $productTypeVariable)->first();

        if (empty($productType)) {
            return response()->json(['message' => 'No products avaliable'], 404);
        }

        // Fetch all fields from both products and prices
        $products = DB::table('products')
        ->leftJoin('prices', function ($join) use($productType) {
            $join->on('products.id', '=', 'prices.productId')
                ->whereNull('prices.deletedDateTime')
                ->where('prices.productTypeId', $productType->id);
        })
        ->leftJoin('productdetails', function ($join) {
            $join->on('products.mainImageId', '=', 'productdetails.id')
                ->whereNull('productdetails.deletedDateTime'); // Include condition for not deleted records in productdetails
        })
        ->whereNull('products.deletedDateTime')
        ->where('products.productTypeId', $productType->id)
        ->select('products.id AS mainProductId', 'products.*', 'prices.*', 'productdetails.image') // Select all fields from both tables
        ->get();

        if($products->isEmpty()){
            return response()->json(['message' => 'No products avaliable'], 404);
        }
        
         // Transform the products data and rename the columns
         $transformedCards = $products->map(function ($product) {
            return [
                'id'             => $product->mainProductId,
                'invitationName' => $product->name,
                'image'          => $product->image,
                'price'          => $product->price,
                'priceLowGrade'  => $product->priceLow,
                'priceHighGrade' => $product->priceHigh,
                'samplePrice'    => $product->samplePrice,
                'categoryId'     => $product->categoryId,
                'pageNo'         => null,
                // Add more fields as needed
            ];
        });
        return response()->json($transformedCards);
    }

    public function getProductDetails(Request $request){
        // Retrieve the record from the database based on the ID
        $id = $request->query('id');
        $productDetailsObject              = new stdClass();
        $productDetailsObject->cardName    = null;
        $productDetailsObject->description = null;
        $productDetailsObject->price       = null;
        $productDetailsObject->images      = null;

        /**
         * get the product
         */
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        

        /**
         * get the prices for the wedding invitation the user clicked on
        */
        $prices = $product->weddingInvitationCardPrices;

        /**
         * Fill in the returned productDetailsObject
         */
        $productDetailsObject->cardName       = $product->name;
        $productDetailsObject->description    = $product->description;
        $productDetailsObject->price          = !empty($prices) ? $prices->price : null;
        $productDetailsObject->priceHighGrade = !empty($prices) ? $prices->priceHigh : null;
        $productDetailsObject->priceLowGrade  = !empty($prices) ? $prices->priceLow : null;
        $productDetailsObject->samplePrice    = !empty($prices) ? $prices->samplePrice : null;

        $productDetails = $product->productDetails;

        $productDetailsObject->images = $productDetails->map(function ($product) {
            return [
                'key'         => $product->key,
                'image'       => $product->image,
            ];
        });


        // Return the record as JSON response
        return response()->json($productDetailsObject);
    }
}