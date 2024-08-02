<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    // Define the table associated with the model (optional if it follows Laravel naming conventions)
    protected $table = 'prices';

    // Define the relationship with the Card model
    public function cards()
    {
        return $this->belongsTo(Card::class, 'productId', 'id');
    }
}
