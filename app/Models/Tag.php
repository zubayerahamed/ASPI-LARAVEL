<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Unique
    public static function boot()
    {
        parent::boot();
        static::creating(function ($tag) {
            // Generate a unique slug when creating a new tag
            $tag->slug = $tag->generateUniqueSlug($tag->name, $tag->business_id);
        });
        static::updating(function ($tag) {
            // Regenerate the slug if the name changes during update
            if ($tag->isDirty('name')) {
                $tag->slug = $tag->generateUniqueSlug($tag->name, $tag->business_id);
            }
        });
    }

    // Method to generate a unique slug
    public function generateUniqueSlug($name, $businessId)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->where('business_id', $businessId)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function scopeRelatedBusiness($query){
        $businessId = getBusinessId();
        $allowCustomTags = getSelectedBusiness()['is_allow_custom_tags'] ?? false;
        if (!$allowCustomTags) {
            $businessId = null;
        }

        return $query->where('business_id', $businessId);
    }
}
