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
        return $this->hasMany(Menu::class, 'parent_menu_id', 'id');
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

}
