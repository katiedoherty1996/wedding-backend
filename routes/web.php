<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\S3ImageController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CustomerEnquiryController;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/images', [S3ImageController::class, 'getAllImages']);

Route::get('/weddingcards', [CardController::class, 'index']);
// Route::post('/customerenquirymail/{cardId}', [CardController::class, 'sendEmailWithCardDetails']);

// Route::get('/products', 'ProductController@index');

Route::get('/customerenquirymail', [CustomerEnquiryController::class, 'sendEmailWithCardDetails']);

