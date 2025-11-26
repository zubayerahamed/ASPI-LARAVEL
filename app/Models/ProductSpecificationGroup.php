<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecificationGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductSpecificationAttribute::class, 'group_id');
    }

    public function tables()
    {
        return $this->belongsToMany(ProductSpecificationTable::class, 'product_specification_table_groups', 'group_id', 'table_id')
                    ->withPivot('seqn')
                    ->orderBy('product_specification_table_groups.seqn');
    }
}
