<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRuleComponent extends Model
{
    
    protected $fillable = [
        'rate',
        'calc_type',
        'seqn',
        'is_recoverable',
        'tax_rule_id',
        'tax_component_id',
    ];

    protected $casts = [
        'is_recoverable' => 'boolean',
        'rate' => 'decimal:2',
    ];

    public function taxRule()
    {
        return $this->belongsTo(TaxRule::class);
    }

    public function taxComponent()
    {
        return $this->belongsTo(TaxComponent::class);
    }

}
