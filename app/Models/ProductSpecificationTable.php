<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecificationTable extends Model
{
    protected $fillable = [
        'name',
        'description',
        'business_id',
    ];

    public function groups()
    {
        return $this->belongsToMany(ProductSpecificationGroup::class, 'product_specification_table_groups', 'table_id', 'group_id')
                    ->withPivot('seqn')
                    ->orderBy('product_specification_table_groups.seqn');
    }
}
