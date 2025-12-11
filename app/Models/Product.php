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
        'category_id',

        'short_description',
        'description',

        'product_type',

        'is_active',

        'business_id',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithoutAutoDraft($query)
    {
        return $query->where('name', '<>', 'AUTO-DRAFT');
    }

    public function getNameAttribute($value)
    {
        return $value == 'AUTO-DRAFT' ? '' : $value;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function productItems()
    {
        return $this->hasMany(ProductItem::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class)->orderBy('seqn', 'asc');
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
