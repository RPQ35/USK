<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $fillable = [
        'SellDate',
        'PriceTotal',
        'CustomerId',
    ];
}
