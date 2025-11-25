<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecificationAttributeOption extends Model
{
    protected $fillable = [
        'label',
        'attribute_id',
    ];

    public function attribute()
    {
        return $this->belongsTo(ProductSpecificationAttribute::class, 'attribute_id');
    }
}
