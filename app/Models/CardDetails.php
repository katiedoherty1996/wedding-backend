<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetails extends Model
{
    protected $table = 'carddetails';

    public function card()
    {
        return $this->belongsTo(Card::class, 'cardId', 'id');
    }
}
