<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'xmenu',
        'title',
        'icon',
        'seqn',
        'parent_menu_id',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function parentMenu()
    {
        return $this->belongsTo(Menu::class, 'parent_menu_id', 'id');
    }

    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'parent_menu_id', 'id')->orderBy('seqn', 'asc');
    }

    public function allSubMenus()
    {
        return $this->hasMany(Menu::class, 'parent_menu_id')
            ->with('allSubMenus')
            ->orderBy('seqn', 'asc');
    }

    // unique
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $exists = Menu::where('xmenu', $model->xmenu)
                ->where('business_id', $model->business_id)
                ->exists();

            if ($exists) {
                throw new \Exception('The menu code must be unique per business.');
            }
        });
    }

    public static function generateMenuTree($business_id = null, $excludeMenuId = null)
    {
        // Get all menus for the business in a single query
        $allMenus = Menu::where('business_id', $business_id)
            ->orderBy('seqn', 'asc')
            ->get();

        // Get IDs to exclude
        $excludeIds = [];
        if ($excludeMenuId) {
            $excludeIds = self::getAllDescendantIdsFromCollection($allMenus, $excludeMenuId);
            $excludeIds[] = $excludeMenuId;
        }

        // Build tree from flat collection
        $buildTree = function ($menus, $parentId = null) use (&$buildTree, $excludeIds) {
            $tree = [];

            foreach ($menus as $menu) {
                // Skip if this menu is in exclude list
                if (in_array($menu->id, $excludeIds)) {
                    continue;
                }

                if ($menu->parent_menu_id == $parentId) {
                    $node = [
                        'id' => $menu->id,
                        'xmenu' => $menu->xmenu,
                        'title' => $menu->title,
                        'icon' => $menu->icon,
                        'seqn' => $menu->seqn,
                        'business_id' => $menu->business_id,
                        'parent_menu_id' => $menu->parent_menu_id,
                        'children' => $buildTree($menus, $menu->id),
                    ];
                    $tree[] = $node;
                }
            }

            return $tree;
        };

        return $buildTree($allMenus);
    }

    // More efficient descendant ID collection
    public static function getAllDescendantIdsFromCollection($menus, $menuId)
    {
        $descendantIds = [];

        $getDescendants = function ($parentId) use (&$getDescendants, &$descendantIds, $menus) {
            $children = $menus->where('parent_menu_id', $parentId);

            foreach ($children as $child) {
                $descendantIds[] = $child->id;
                $getDescendants($child->id);
            }
        };

        $getDescendants($menuId);
        return $descendantIds;
    }
}
