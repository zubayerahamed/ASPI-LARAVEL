<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxComponent extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'is_recoverable',
        'business_id',
    ];

    protected $casts = [
        'is_recoverable' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function taxRuleComponents()
    {
        return $this->hasMany(TaxRuleComponent::class);
    }

}
