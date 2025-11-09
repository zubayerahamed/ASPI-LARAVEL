<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'thumbnail',
        'description',
        'is_featured',
        'is_system_defined',
        'is_active',
        'seqn',
        'parent_category_id',
        'business_id',
    ];

    // Default attributes
    // protected $attributes = [
    //     'is_featured' => false,
    //     'is_system_defined' => false,
    //     'is_active' => true,
    //     'seqn' => 0,
    // ];


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
        static::creating(function ($model) {
            $exists = Category::where('slug', $model->slug)
                ->where('business_id', $model->business_id)
                ->exists();

            if ($exists) {
                throw new \Exception('Category with this slug already exists for the given business.');
            }
        });
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
}
