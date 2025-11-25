<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = [
        'name',
        'type',
        'is_required',
        'business_id',
    ];

    public function details()
    {
        return $this->hasMany(ProductOptionDetail::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
