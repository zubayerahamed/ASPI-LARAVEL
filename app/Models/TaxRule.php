<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRule extends Model
{
    protected $fillable = [
        'notes',
        'transaction_type',
        'effective_from',
        'effective_to',
        'tax_category_id',
        'business_id',
    ];

    protected $dates = [
        'effective_from',
        'effective_to',
    ];

    public function taxCategory()
    {
        return $this->belongsTo(TaxCategory::class);
    }

    public function taxRuleComponents()
    {
        return $this->hasMany(TaxRuleComponent::class);
    }
}
