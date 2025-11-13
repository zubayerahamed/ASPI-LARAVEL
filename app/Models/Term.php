<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'is_default',
        'seqn',
        'thumbnail_id',
        'attribute_id',
        'business_id',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
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
        static::creating(function ($term) {
            // Generate a unique slug when creating a new term
            $term->slug = $term->generateUniqueSlug($term->name, $term->attribute_id, $term->business_id);
        });
        static::updating(function ($term) {
            // Regenerate the slug if the name changes during update
            if ($term->isDirty('name')) {
                $term->slug = $term->generateUniqueSlug($term->name, $term->attribute_id, $term->business_id);
            }
        });
    }

    // Generate a unique slug for a given attribute_id and business_id
    public function generateUniqueSlug($name, $attribute_id, $business_id)
    {
        $slug = \Illuminate\Support\Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug is unique for the given attribute_id and business_id
        while (Term::where('slug', $slug)->where('attribute_id', $attribute_id)->where('business_id', $business_id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

}
