<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = [
        'product_id',
        'attribute_id',
        'term_id',
        'use_in_variation',
    ];

    protected $casts = [
        'use_in_variation' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
