<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecificationAttribute extends Model
{
    
    protected $fillable = [
        'name',
        'type',
        'default_value',
        'group_id',
        'business_id',
    ];

    public function group()
    {
        return $this->belongsTo(ProductSpecificationGroup::class, 'group_id');
    }

    public function options()
    {
        return $this->hasMany(ProductSpecificationAttributeOption::class, 'attribute_id');
    }
}
