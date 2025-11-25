<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionDetail extends Model
{
    protected $fillable = [
        'label',
        'additional_price',
        'price_type',
        'product_option_id',
        'seqn',
    ];

    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }
}
