<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCollection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'is_featured',
        'thumbnail_id',
        'business_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Cadoc::class, 'thumbnail_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function details()
    {
        return $this->hasMany(ProductCollectionDetail::class, 'product_collection_id');
    }

    // unique
    public static function boot()
    {
        parent::boot();
        static::creating(function ($pc) {
            // Generate a unique slug when creating a new pc$pc
            $pc->slug = $pc->generateUniqueSlug($pc->name, $pc->business_id);
        });

        static::updating(function ($pc) {
            // Regenerate the slug if the name changes during update
            if ($pc->isDirty('name')) {
                $pc->slug = $pc->generateUniqueSlug($pc->name, $pc->business_id);
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
        while (ProductCollection::where('slug', $slug)->where('business_id', $business_id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }


}
