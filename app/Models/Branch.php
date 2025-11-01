<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'address',
        'area',
        'city',
        'state',
        'postal_code',
        'country',
        'map_link',

        'latitude',
        'longitude',

        'is_inhouse',
        'is_pickup',
        'is_delivery',
        'is_active',
        'is_orders_open',

        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'branch_id', 'id');
    }
}
