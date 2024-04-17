<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    public function cardDetails()
    {
        return $this->hasMany(CardDetails::class, 'cardId', 'id');
    }
}
