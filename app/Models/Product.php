<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'brand_id',

        'short_description',
        'description',

        'product_type',

        'base_unit',

        'is_active',
        'is_listed',
        'is_featured',
        'is_trending',
        'is_highlighted',
        'is_for_purchase',
        'is_for_sell',
        'is_downloadable',

        'business_id',
    ];

    public function getNameAttribute($value)
    {
        return $value == 'AUTO-DRAFT' ? '' : $value;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // unique slug per business
    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            // Generate a unique slug when creating a new product
            $product->slug = $product->generateUniqueSlug($product->name, $product->business_id);
        });
        static::updating(function ($product) {
            // Regenerate the slug if the name changes during update
            if ($product->isDirty('name')) {
                $product->slug = $product->generateUniqueSlug($product->name, $product->business_id);
            }
        });
    }

    // Generate a unique slug for a given business_id
    public function generateUniqueSlug($name, $business_id)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;
        while (self::where('slug', $slug)->where('business_id', $business_id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        return $slug;
    }

    
}
