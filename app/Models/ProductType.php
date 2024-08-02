<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    // Define the table associated with the model (optional if it follows Laravel naming conventions)
    protected $table = 'producttypes';

    //consts for different product types
    const WEDDING_INVITATIONS = 1;
    const MASS_BOOKLETS = 2;
    const THANK_YOU_CARD = 3;
}
