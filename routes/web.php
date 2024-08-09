<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\S3ImageController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CustomerEnquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SendEnquiryController;
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


Route::get('/images', [S3ImageController::class, 'getAllImages']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/customerenquirymail', [CustomerEnquiryController::class, 'sendEmailWithCardDetails']);

// Route::post('/sendenquiry', [SendEnquiryController::class, 'sendEnquiry']);

