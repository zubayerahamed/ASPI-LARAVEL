<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

    protected $fillable = [
        'business_name',
        'logo',
        'country',
        'currency',
        'email',
        'mobile',

        'is_inhouse',
        'is_pickup',
        'is_delivery',
        'is_active',

        'business_caregory_id',
    ];

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_caregory_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'business_user')->withPivot('is_active');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'business_id', 'id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'business_id', 'id');
    }
}
