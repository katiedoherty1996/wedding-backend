<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    protected $table = 'productdetails';

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'id');
    }
}
