<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItemPrice extends Model
{
    protected $fillable = [
        'product_item_id',
        'price_type',
        'amount',
        'effective_from',
        'effective_to',
    ];
}
