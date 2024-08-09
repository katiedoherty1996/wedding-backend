<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CardPaperController;
use App\Http\Controllers\InvitationsCategoriesController;
use App\Http\Controllers\MassBookletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SendEnquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/massbooklets', [ProductController::class, 'index']);

Route::get('/thankyoucards', [ProductController::class, 'index']);

Route::get('/weddingcarddetails', [ProductController::class, 'getProductDetails']);

Route::get('/cardpapertypes', [CardPaperController::class, 'index']);

Route::post('/sendenquiry', [SendEnquiryController::class, 'sendEnquiry']);

Route::get('/invitationscategories', [InvitationsCategoriesController::class, 'getInvitationCategories']);