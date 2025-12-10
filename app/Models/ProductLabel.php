<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLabel extends Model
{
    protected $fillable = [
        'name',
        'bg_color',
        'text_color',
        'is_active',
        'business_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relationships, Scopes, and other model methods can be added here
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function scopeRelatedBusiness($query){
        $businessId = getBusinessId();
        $allowCustomCategory = getSelectedBusiness()['is_allow_custom_product_labels'] ?? false;
        if (!$allowCustomCategory) {
            $businessId = null;
        }

        return $query->where('business_id', $businessId);
    }


}
