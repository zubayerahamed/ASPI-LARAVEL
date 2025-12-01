<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_featured',
        'is_system_defined',
        'is_active',
        'seqn',
        'parent_category_id',
        'business_id',
        'thumbnail_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_system_defined' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Cadoc::class, 'thumbnail_id');
    }


    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id')->orderBy('seqn', 'asc');
    }

    public function allSubCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id')
            ->with('allSubCategories')
            ->orderBy('seqn', 'asc');
    }

    // unique
    public static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            // Generate a unique slug when creating a new category
            $category->slug = $category->generateUniqueSlug($category->name, $category->business_id);
        });

        static::updating(function ($category) {
            // Regenerate the slug if the name changes during update
            if ($category->isDirty('name')) {
                $category->slug = $category->generateUniqueSlug($category->name, $category->business_id);
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
        while (Category::where('slug', $slug)->where('business_id', $business_id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public static function generateCategoryTree($business_id = null, $excludeCategoryId = null)
    {
        // Get all categories for the business in a single query
        $allCategories = Category::where('business_id', $business_id)
            ->orderBy('seqn', 'asc')
            ->get();

        // Get IDs to exclude
        $excludeIds = [];
        if ($excludeCategoryId) {
            $excludeIds = self::getAllDescendantIdsFromCollection($allCategories, $excludeCategoryId);
            $excludeIds[] = $excludeCategoryId;
        }


        // Build the tree from flat collection
        $buildTree = function ($categories, $parentId = null) use (&$buildTree, $excludeIds) {
            $tree = [];

            foreach ($categories as $category) {
                // Skip if this category is in exclude list
                if (in_array($category->id, $excludeIds)) {
                    continue;
                }

                if ($category->parent_category_id == $parentId) {
                    $node = [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'icon' => $category->icon,
                        'thumbnail' => $category->thumbnail,
                        'description' => $category->description,
                        'is_featured' => $category->is_featured,
                        'is_system_defined' => $category->is_system_defined,
                        'is_active' => $category->is_active,
                        'seqn' => $category->seqn,
                        'business_id' => $category->business_id,
                        'parent_category_id' => $category->parent_category_id,
                        'children' => $buildTree($categories, $category->id),
                    ];
                    $tree[] = $node;
                }
            }

            return $tree;
        };

        return $buildTree($allCategories);
    }

    protected static function getAllDescendantIdsFromCollection($categories, $categoryId)
    {
        $descendantIds = [];

        $getDescendants = function ($parentId) use (&$getDescendants, &$descendantIds, $categories) {
            $children = $categories->where('parent_category_id', $parentId);

            foreach ($children as $child) {
                $descendantIds[] = $child->id;
                $getDescendants($child->id);
            }
        };

        $getDescendants($categoryId);
        return $descendantIds;
    }

    public function scopeRelatedBusiness($query){
        $businessId = getBusinessId();
        $allowCustomCategory = getSelectedBusiness()['is_allow_custom_category'] ?? false;
        if (!$allowCustomCategory) {
            $businessId = null;
        }

        return $query->where('business_id', $businessId);
    }
}
