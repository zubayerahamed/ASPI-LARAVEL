<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'seqn',
        'description',
        'is_active',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // unique
    public static function boot()
    {
        parent::boot();
        static::creating(function ($profile) {
            // Generate a unique slug when creating a new profile
            $profile->slug = $profile->generateUniqueSlug($profile->name, $profile->business_id);
        });

        static::updating(function ($profile) {
            // Regenerate slug if the name has changed
            if ($profile->isDirty('name')) {
                $profile->slug = $profile->generateUniqueSlug($profile->name, $profile->business_id);
            }
        });
    }

    public function generateUniqueSlug($name, $business_id)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug is unique for the given business_id
        while (Profile::where('slug', $slug)->where('business_id', $business_id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
