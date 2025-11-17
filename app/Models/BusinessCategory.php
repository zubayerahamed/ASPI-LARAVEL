<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessCategory extends Model
{
    protected $fillable = [
        'xcode',
        'name',
        'seqn',
        'is_active',
    ];

    // cast
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function businesses()
    {
        return $this->hasMany(Business::class, 'business_category_id', 'id');
    }
}
