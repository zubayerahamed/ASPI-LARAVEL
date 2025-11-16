<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'country',
        'currency',
        'email',
        'mobile',

        'is_inhouse',
        'is_pickup',
        'is_delivery',
        'is_active',
        'is_allow_custom_menu',
        'is_allow_custom_category',
        'is_allow_custom_attribute',

        'business_category_id',
    ];


    // cast
    protected $casts = [
        'is_inhouse' => 'boolean',
        'is_pickup' => 'boolean',
        'is_delivery' => 'boolean',
        'is_active' => 'boolean',
        'is_allow_custom_menu' => 'boolean',
        'is_allow_custom_category' => 'boolean',
        'is_allow_custom_attribute' => 'boolean',
    ];


    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id', 'id');
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
