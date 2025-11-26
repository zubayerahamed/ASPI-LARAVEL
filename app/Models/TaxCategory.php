<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'business_id',
    ];

    public function taxRules()
    {
        return $this->hasMany(TaxRule::class);
    }
}
