<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'cadoc_id',
        'seqn',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cadoc()
    {
        return $this->belongsTo(Cadoc::class, 'cadoc_id');
    }
}
