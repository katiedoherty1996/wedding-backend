<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    // Define the table associated with the model (optional if it follows Laravel naming conventions)
    protected $table = 'prices';

    // Define the relationship with the products model
    public function products()
    {
        return $this->belongsTo(Product::class, 'productId', 'id');
    }
}
