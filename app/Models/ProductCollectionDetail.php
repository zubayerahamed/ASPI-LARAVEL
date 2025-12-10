<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCollectionDetail extends Model
{
    protected $fillable = [
        'product_collection_id',
        'product_id',
        'seqn',
    ];

    public function productCollection()
    {
        return $this->belongsTo(ProductCollection::class, 'product_collection_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
