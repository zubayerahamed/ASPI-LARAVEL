<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'display_layout',
        'is_image_visual_swatch',
        'is_searchable',
        'is_comparable',
        'is_used_in_product_listing',
        'is_active',
        'seqn',
        'business_id',
    ];

    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Unique
    public static function boot()
    {
        parent::boot();
        static::creating(function ($attribute) {
            // Generate a unique slug when creating a new attribute
            $attribute->slug = $attribute->generateUniqueSlug($attribute->name, $attribute->business_id);
        });

        static::updating(function ($attribute) {
            // Regenerate the slug if the name changes during update
            if ($attribute->isDirty('name')) {
                $attribute->slug = $attribute->generateUniqueSlug($attribute->name, $attribute->business_id);
            }
        });
    }

    // Generate a unique slug for a given business_id
    public function generateUniqueSlug($name, $business_id)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug is unique for the given business_id
        while (Attribute::where('slug', $slug)->where('business_id', $business_id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function scopeRelatedBusiness($query){
        $businessId = getBusinessId();
        $allowCustomAttribute = getSelectedBusiness()['is_allow_custom_attribute'] ?? false;
        if (!$allowCustomAttribute) {
            $businessId = null;
        }

        return $query->where('business_id', $businessId);
    }
}
