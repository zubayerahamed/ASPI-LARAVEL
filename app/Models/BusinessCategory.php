<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $fillable = [
        'xcode',
        'name',
        'is_active',
    ];

    public function businesses()
    {
        return $this->hasMany(Business::class, 'business_caregory_id', 'id');
    }
}
