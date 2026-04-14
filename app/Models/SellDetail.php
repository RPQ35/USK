<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellDetail extends Model
{
    //

    protected $fillable = [
        'SellId',
        'ProductId',
        'ProductTotal',
        'Subtotal',
    ];
}
