<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'thumbnail_id',
        'website',
        'description',
        'is_active',
        'is_featured',
        'is_popular',
        'is_highlighted',
        'is_listed',
        'country_of_origin',
        'support_email',
        'support_phone',
        'warranty_period',
        'business_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'is_highlighted' => 'boolean',
        'is_listed' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Cadoc::class, 'thumbnail_id');
    }

    // unique
    public static function boot()
    {
        parent::boot();
        static::creating(function ($brand) {
            // Generate a unique slug when creating a new brand
            $brand->slug = $brand->generateUniqueSlug($brand->name, $brand->business_id);
        });

        static::updating(function ($brand) {
            // Regenerate the slug if the name changes during update
            if ($brand->isDirty('name')) {
                $brand->slug = $brand->generateUniqueSlug($brand->name, $brand->business_id);
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
        while (Brand::where('slug', $slug)->where('business_id', $business_id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
