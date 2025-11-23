<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{

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
        'is_allow_custom_xcodes',
        'is_allow_custom_tags',

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
        'is_allow_custom_xcodes' => 'boolean',
    ];


    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_businesseses')->withPivot('is_active');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'business_id', 'id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'business_id', 'id');
    }

    public function activeBranches()
    {
        return $this->hasMany(Branch::class, 'business_id', 'id')->where('is_active', true)->count();
    }

}
